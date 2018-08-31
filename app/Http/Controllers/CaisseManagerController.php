<?php

namespace App\Http\Controllers;

use App\EcritureCaisse;
use App\Http\Requests\CaisseOpenRequest;
use App\Library\CustomFunction;
use App\Repositories\CaisseRepository;
use App\Repositories\EcritureCaisseRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\SessionRepository;
use App\Repositories\TransfertFondRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaisseManagerController extends Controller
{
    //

	protected $modelRepository;
	protected $userRepository;
	protected $sessionRepository;
	protected $ecritureCaisseRepository;
	protected $parametreRepository;
	protected $transfertFondRepository;

	protected $devise;
	protected $current_user;
	protected $custom;

	public function __construct(CaisseRepository $caisse_repository, UserRepository $user_repository, TransfertFondRepository $transfert_fond_repository,
		SessionRepository $session_repository, EcritureCaisseRepository $ecriture_caisse_repository, ParametreRepository $parametre_repository) {

		$this->modelRepository = $caisse_repository;
		$this->userRepository = $user_repository;
		$this->sessionRepository = $session_repository;
		$this->ecritureCaisseRepository = $ecriture_caisse_repository;
		$this->parametreRepository = $parametre_repository;
		$this->transfertFondRepository = $transfert_fond_repository;

		$this->devise = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'caisses'],
				['type_config', '=', 'devise']
			]
		)->first();

		$this->custom = new CustomFunction();

	}

	public function index(){


		$current_user = Auth::user();

		$pos = $current_user->PointDeVente()->first();

		$datas_pos = $pos->Caisses()->where('principal', '=', 1)->get();

		$datas = $current_user->Caisses()->get();

		return view('caisseManager.index', compact('datas', 'datas_pos'));
	}

	public function preopen($caisse_id){

		$current_user = Auth::user();

		$open_session = $this->sessionRepository->getWhere()->where([['user_id', '=', $current_user->id], ['last', '=', 1]])->first();

		$data = $this->modelRepository->getById($caisse_id);

		$devise = $this->devise;

		return view('caisseManager.preopen', compact('data', 'devise', 'open_session'));

	}


	public function preopenCheck(CaisseOpenRequest $resquest, $caisse_id){

		$datas = $resquest->all();

		$caisse = $this->modelRepository->getById($caisse_id);

		$response = array(
			'success' => '',
			'error' => '',
		);

		if(floatval($caisse->montantEnCours) == floatval($datas['caisse_montant'])):
			$response['success'] = 'Montant correct. Rediretion automatique dans quelques secondes';
		else:
			$response['error'] = 'Montant incorrect. Veuillez saisir le montant exact présent dans votre caisse ou contacter un responsable';
		endif;

		return response()->json($response);

	}

	public function open($caisse_id){

		$current_user = Auth::user();

		$user_id = $current_user->id;

		$caisse = $this->modelRepository->getById($caisse_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $caisse->id], ['last', '=', 1]]);



		if($caisse->etat == 1 && $exist_session->count() && $exist_session->first()->user_id != $user_id):
			return redirect()->route('caisseManager.index')->withWarning('Caisse ouverte par un autre utilisateur.');
		endif;

		if(!$this->devise):

			if($caisse->etat == 1):

				$caisse->etat = 0;
				$caisse->save();

			endif;

			return redirect()->route('caisseManager.index')->withWarning('Le parametrage de la devise a été Modifié. Aucune devise défini');

		endif;

		if(!$exist_session->count()):

			$session = array();
			$session['montant_ouverture'] = $caisse->montantEnCours;
			$session['last'] = 1;
			$session['caisse_id'] = $caisse->id;
			$session['user_id'] = $user_id;

			$save_session = $this->sessionRepository->store($session);

			$ecriture = array();
			$ecriture['libelle'] = 'Ouverture de la caisse';
			$ecriture['type_ecriture'] = 1;
			$ecriture['type_paiement'] = 'cash';
			$ecriture['devise'] = $this->devise->value;
			$ecriture['montant'] = $caisse->montantEnCours;
			$ecriture['session_id'] = $save_session->id;
			$ecriture['caisse_id'] = $caisse->id;
			$ecriture['user_id'] = $user_id;

			$this->ecritureCaisseRepository->store($ecriture);

		endif;

		if($caisse->etat == 0):

			$caisse->etat = 1;
			$caisse->save();

		endif;

		$montant_caisse = 0;
		$montant_encaisse = 0;

		if($exist_session->count()):

			$exist_sess = $exist_session->first();

			foreach ($exist_sess->EcritureCaisse()->get() as $item):
				$montant_caisse += $item->montant;
			endforeach;

			foreach ($exist_sess->EcritureCaisse()->where('type_ecriture', '=', 3)->get() as $item):
				$montant_encaisse += $item->montant;
			endforeach;

		endif;

		$exist_receiveFond = $this->transfertFondRepository->getWhere()->where([['caisse_receive_id', '=', $caisse_id], ['statut', '=', 0]])->count();

		return view('caisseManager.manager', compact('caisse', 'montant_caisse', 'exist_session', 'montant_encaisse', 'exist_receiveFond'));
	}

	public function openReload($caisse_id){

		$caisse = $this->modelRepository->getById($caisse_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $caisse->id], ['last', '=', 1]]);

		$montant_caisse = 0;
		$montant_encaisse = 0;

		if($exist_session->count()):

			$exist_ses = $exist_session->first();

			foreach ($exist_ses->EcritureCaisse()->get() as $item):
				$montant_caisse += $item->montant;
			endforeach;

			foreach ($exist_ses->EcritureCaisse()->where('type_ecriture', '=', 3)->get() as $item):
				$montant_encaisse += $item->montant;
			endforeach;
		endif;

		return view('caisseManager.managerReload', compact('caisse', 'montant_caisse', 'exist_session', 'montant_encaisse'));
	}


	public function createTransfertFond($caisse_id){

		$caisse = $this->modelRepository->getById($caisse_id);

		$caisse_sender = array();

		$pos_principal = $caisse->PointDeVente()->first();
		$caisse_principal = $pos_principal->Caisses()->where('principal', '=', 1)->first();

		if($caisse_principal->id == $caisse->id):
			foreach ($pos_principal->Caisses()->where('principal', '=', 0)->get() as $item):
				$caisse_sender[$item->id] = $item->name;
			endforeach;

			// listes des caisses principales des autres point de vente

			$all_caisse = $this->modelRepository->getWhere()->whereHas('PointDeVente', function ($q){
				$q->where('principal', '=', 1);
			})->get();

			foreach ($all_caisse as $item):
				if($item->id != $caisse_id):
					$caisse_sender[$item->id] = $item->name.' ('.$item->PointDeVente()->first()->name.')';
				endif;
			endforeach;

		else:
			$caisse_sender[$caisse_principal->id] = $caisse_principal->name;
		endif;

		return view('caisseManager.CreateTransfertFond', compact('caisse_sender', 'caisse'));
	}

	public function createTransfertFondCheck(Request $request, $caisse_id){

		$datas = $request->all();

		$current_user = Auth::user();

		$response = array(
			'success' => '',
			'error' => '',
			'error_field' => '',
			'field' => '',
			'code' => ''
		);

		$error = false;

		if(!$datas['caisse_receive_id']):
			$response['error_field'] = "Selectionnez une caisse";
			$response['field'] = 'caisse_receive_id';
			$error = true;
		else:
			if(empty($datas['montant'])):
				$response['error_field'] = "Veuillez saisir un montant pour à transferer";
				$response['field'] = 'montant';
				$error = true;
			else:
				if($datas['montant'] == 0):
					$response['error_field'] = "Le montant doit etre supérieure à 0";
					$response['field'] = 'montant';
					$error = true;
				else:
					if(!$datas['motif']):
						$response['error_field'] = "Le motif est obligatoire";
						$response['field'] = 'motif';
						$error = true;
					endif;
				endif;
			endif;
		endif;

		$caisse = $this->modelRepository->getById($caisse_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $caisse->id], ['last', '=', 1]])->first();

		$montant = 0;

		foreach ($exist_session->EcritureCaisse()->get() as $item):
			$montant += $item->montant;
		endforeach;

		if($datas['montant'] && !$error):

			$reste = $montant - $datas['montant'];

			if($reste <= 0):
				$response['field'] = 'montant';

				$response['error'] = "Montant en caisse inssuffisant pour le montant à transfert.";
			else:

				// Creer le transfert de fond. Reference et code

				$count = $this->modelRepository->getWhere()->count();
				$coderef = $this->parametreRepository->getWhere()->where(
					[
						['module', '=', 'caisses'],
						['type_config', '=', 'coderefTF']
					]
				)->first();
				$incref = $this->parametreRepository->getWhere()->where(
					[
						['module', '=', 'caisses'],
						['type_config', '=', 'increfTF']
					]
				)->first();

				$count += $incref ? intval($incref->value) : 0;
				$reference = $this->custom->setReference($coderef, $count, 4);

				$codeTranfert = $this->custom->randomPassword(6, 1, 'upper_case,numbers');

				$caisse_receive = $this->modelRepository->getById($datas['caisse_receive_id']);

				$transfert = array();
				$transfert['reference'] = $reference;
				$transfert['caisse_sender_id'] = $caisse->id;
				$transfert['caisse_receive_id'] = $caisse_receive->id;
				$transfert['montant'] = $datas['montant'];
				$transfert['motif'] = $datas['motif'];
				$transfert['code_transfert'] = $codeTranfert;

				$transfert_fond_id =$this->transfertFondRepository->store($transfert);

				$ecriture = array();
				$ecriture['libelle'] = 'Transfert de fond';
				$ecriture['type_ecriture'] = 4;
				$ecriture['type_paiement'] = 'cash';
				$ecriture['devise'] = $this->devise->value;
				$ecriture['montant'] = ($datas['montant'] * -1);
				$ecriture['session_id'] = $exist_session->id;
				$ecriture['caisse_id'] = $caisse->id;
				$ecriture['user_id'] = $current_user->id;
				$ecriture['transfert_fond_id'] = $transfert_fond_id->id;

				$this->ecritureCaisseRepository->store($ecriture);

				$response['success'] = "Transfert de fond enregistré";
				$response['code'] = $codeTranfert;
			endif;

		endif;


		return response()->json($response);
	}

	public function indexTransfertFond($caisse_id){

		$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $caisse_id], ['last', '=', 1]])->first();

		$datas = $this->ecritureCaisseRepository->getWhere()->where([['caisse_id', '=', $caisse_id], ['session_id', '=', $exist_session->id], ['type_ecriture', '=', 4]])->get();

		return view('caisseManager.indexTransfertFond', compact('datas', 'caisse_id'));
	}

	public function cancelTransfertFond(Request $request, $transfertFond_id){

		$data = $this->transfertFondRepository->getById($transfertFond_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $data->caisse_sender_id], ['last', '=', 1]])->first();

		$current_user = Auth::user();

		if($request->isMethod('POST')):

			$datas = $request->all();

			$response = array(
				'success' => '',
				'error' => '',
				'error_field' => '',
				'field' => '',
			);

			if(!$datas['motif']):

				$response['error_field'] = "Le motif d'annulation est obligatoire";
				$response['field'] = 'motif';

			else:

				$data->motif_annulation = $datas['motif'];
				$data->statut = 2;
				$data->save();

				$ecriture = array();
				$ecriture['libelle'] = 'Annulation Transfert de fond';
				$ecriture['type_ecriture'] = 2;
				$ecriture['type_paiement'] = 'cash';
				$ecriture['devise'] = $this->devise->value;
				$ecriture['montant'] = ($data->montant * 1);
				$ecriture['session_id'] = $exist_session->id;
				$ecriture['caisse_id'] = $data->caisse_sender_id;
				$ecriture['user_id'] = $current_user->id;
				$ecriture['transfert_fond_id'] = $data->id;

				$this->ecritureCaisseRepository->store($ecriture);

				$response['success'] = "Enregistrement des modifications";

			endif;

			return response()->json($response);

		endif;

		return view('caisseManager.cancelTransfertFond', compact('data'));

	}

	public function close($caisse_id){

		$current_user = Auth::user();

		$user_id = $current_user->id;

		$caisse = $this->modelRepository->getById($caisse_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $caisse->id], ['last', '=', 1]])->first();

		$montant_caisse = 0;

		foreach ($exist_session->EcritureCaisse()->get() as $item):
			$montant_caisse += $item->montant;
		endforeach;

		$ecriture = array();
		$ecriture['libelle'] = 'Fermeture de la caisse';
		$ecriture['type_ecriture'] = 0;
		$ecriture['type_paiement'] = 'cash';
		$ecriture['devise'] = $this->devise->value;
		$ecriture['montant'] = $montant_caisse;
		$ecriture['session_id'] = $exist_session->id;
		$ecriture['caisse_id'] = $caisse->id;
		$ecriture['user_id'] = $user_id;

		$this->ecritureCaisseRepository->store($ecriture);

		$exist_session->montant_fermeture = $montant_caisse;
		$exist_session->last = 0;
		$exist_session->save();

		$caisse->etat = 0;
		$caisse->montantEnCours = $montant_caisse;
		$caisse->save();

		$response = array(
			'code' => ''
		);

		return response()->json($response);

	}

	public function checkClose(Request $request, $caisse_id){

		$current_user = Auth::user();

		$datas = $request->all();

		$caisse_principal = $current_user->Caisses()->where('principal', '=', 1)->first();

		$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $caisse_id], ['last', '=', 1]])->first();

		$response = array(
			'success' => '',
			'error' => '',
			'principal' => 0,
			'code' => ''
		);

		if($caisse_principal->id == $caisse_id):
			$response['principal'] = 1;
		endif;

		$montant_caisse = 0;

		foreach ($exist_session->EcritureCaisse()->get() as $item):
			$montant_caisse += $item->montant;
		endforeach;

		$codeTranfert = $this->custom->randomPassword(6, 1, 'upper_case,numbers');

		$response['code'] = $codeTranfert;

		if($montant_caisse == intval($datas['montant'])):
			$response['success'] = 'Montant correct.';
		else:
			$response['error'] = 'Montant incorrect.';
		endif;

		return response()->json($response);

	}

	public function transfertFondClose(Request $request, $caisse_id){

		$datas = $request->all();

		$response = array(
			'code' => ''
		);

		$current_user = Auth::user();

		$caisse = $this->modelRepository->getById($caisse_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $caisse->id], ['last', '=', 1]])->first();

		$montant = 0;

		foreach ($exist_session->EcritureCaisse()->get() as $item):
			$montant += $item->montant;
		endforeach;

		// Creer le transfert de fond. Reference et code

		$count = $this->modelRepository->getWhere()->count();
		$coderef = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'caisses'],
				['type_config', '=', 'coderefTF']
			]
		)->first();
		$incref = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'caisses'],
				['type_config', '=', 'increfTF']
			]
		)->first();

		$count += $incref ? intval($incref->value) : 0;
		$reference = $this->custom->setReference($coderef, $count, 4);

		$codeTranfert = $datas['code'];

		$pos_principal = $caisse->PointDeVente()->first();
		$caisse_principal = $pos_principal->Caisses()->where('principal', '=', 1)->first();

		$transfert = array();
		$transfert['reference'] = $reference;
		$transfert['caisse_sender_id'] = $caisse->id;
		$transfert['caisse_receive_id'] = $caisse_principal->id;
		$transfert['montant'] = $montant;
		$transfert['motif'] = 'Trasnfert de fond pour fermeture de session de la caisse';
		$transfert['code_transfert'] = $codeTranfert;

		$transfert_fond_id = $this->transfertFondRepository->store($transfert);

		$ecriture = array();
		$ecriture['libelle'] = 'Transfert de fond';
		$ecriture['type_ecriture'] = 4;
		$ecriture['type_paiement'] = 'cash';
		$ecriture['devise'] = $this->devise->value;
		$ecriture['montant'] = ($montant * -1);
		$ecriture['session_id'] = $exist_session->id;
		$ecriture['caisse_id'] = $caisse->id;
		$ecriture['user_id'] = $current_user->id;
		$ecriture['transfert_fond_id'] = $transfert_fond_id->id;

		$this->ecritureCaisseRepository->store($ecriture);

		return response()->json($response);
	}


	public function receiveTransfertFond($caisse_id){

		$datas = $this->transfertFondRepository->getWhere()->where([['caisse_receive_id', '=', $caisse_id], ['statut', '=', 0]])->get();

		return view('caisseManager.receiveTransfertFond', compact('datas'));
	}

	public function receivedTransfertFond(Request $request, $transfert_id){

		$transfert = $this->transfertFondRepository->getById($transfert_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $transfert->caisse_receive_id], ['last', '=', 1]])->first();

		$current_user = Auth::user();

		if($request->isMethod('POST')):

			$datas = $request->all();

			$response = array(
				'success' => '',
				'error' => '',
				'error_field' => '',
				'field' => '',
				'count' => ''
			);

			$error = false;

			if(empty($datas['montant'])):
				$response['error_field'] = "Veuillez saisir le montant du transfert";
				$response['field'] = 'montant';
				$error = true;
			else:
				if(!$datas['code']):
					$response['error_field'] = "Le code est obligatoire";
					$response['field'] = 'code';
					$error = true;
				endif;
			endif;

			if($datas['montant'] && !$error && $datas['code']):

				if($transfert->montant == $datas['montant'] && strcmp($transfert->code_transfert, strtolower($datas['code']))):

					$response['success'] = "Enregistrement des mofications réussi";

					$ecriture = array();
					$ecriture['libelle'] = 'Reception Transfert de fond';
					$ecriture['type_ecriture'] = 2;
					$ecriture['type_paiement'] = 'cash';
					$ecriture['devise'] = $this->devise->value;
					$ecriture['montant'] = ($transfert->montant * 1);
					$ecriture['session_id'] = $exist_session->id;
					$ecriture['caisse_id'] = $transfert->caisse_receive_id;
					$ecriture['user_id'] = $current_user->id;
					$ecriture['transfert_fond_id'] = $transfert->id;

					$this->ecritureCaisseRepository->store($ecriture);

					$transfert->statut = 1;
					$transfert->save();

					$response['count'] = $this->transfertFondRepository->getWhere()->where([['caisse_receive_id', '=', $transfert->caisse_receive_id], ['statut', '=', 0]])->get();

				else:

					if(!strcmp($transfert->code_transfert, strtolower($datas['code']))):
						$response['error_field'] = "Le code est incorrect. Veuillez saisir le code exact ou contactez l'émeteur du transfert de fond.";
						$response['field'] = 'code';
					else:
						if($transfert->montant != $datas['montant']):
							$response['error_field'] = "Le montant est incorrect. Veuillez saisir le montant exact.";
							$response['field'] = 'montant';
						endif;
					endif;

				endif;

			endif;


			return response()->json($response);

		endif;

		return view('caisseManager.receivedTransfertFond', compact('transfert'));
	}

	public function storyTransfertFond(Request $request, $caisse_id){

		$request = $request->all();

		if(isset($request['type'])):

			$date_start = $this->custom->dateToMySQL($request['date_start']);
			$date_end = $this->custom->dateToMySQL($request['date_end']);
			if(isset($request['session'])):
				$session = $this->sessionRepository->getById($request['session']);
				$datas = $session->EcritureCaisse()->orderBy('created_at', 'desc')->get();
			else:
				if($date_end == $date_start):
					$datas = $this->ecritureCaisseRepository->getWhere()->where('caisse_id', '=', $caisse_id)->whereDate('created_at', $date_start)->orderBy('created_at', 'desc')->get();
				else:
					$datas = $this->ecritureCaisseRepository->getWhere()->where('caisse_id', '=', $caisse_id)->whereBetween('created_at', array(
						$date_start, date('Y-m-d 00:00:00', strtotime($date_end. ' + 1 days'))
					))->orderBy('created_at', 'desc')->get();
				endif;
			endif;

			return view('caisseManager.storyTransfertFondList', compact('datas', 'caisse_id', 'request', 'session'));

		else:

			$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $caisse_id], ['last', '=', 1]])->first();

			$datas = $this->ecritureCaisseRepository->getWhere()->where([['session_id', '=', $exist_session->id], ['caisse_id', '=', $caisse_id]])->orderBy('created_at', 'desc')->get();

			return view('caisseManager.storyTransfertFond', compact('datas', 'caisse_id'));
		endif;


	}

	public function rapportSession(Request $request, $caisse_id){

		$date_now = Carbon::now();

		$caisse = $this->modelRepository->getById($caisse_id);

		$request = $request->all();

		if(isset($request['type'])):
			$date_start = $this->custom->dateToMySQL($request['date_start']);
			$date_end = $this->custom->dateToMySQL($request['date_end']);

			if($date_end == $date_start):
				$datas = $this->sessionRepository->getWhere()->where('caisse_id', '=', $caisse_id)->whereDate('created_at', $date_start)->orderBy('created_at', 'desc')->get();
			else:
				$datas = $this->sessionRepository->getWhere()->where('caisse_id', '=', $caisse_id)->whereBetween('created_at', array(
					$date_start, date('Y-m-d 00:00:00', strtotime($date_end. ' + 1 days'))
				))->orderBy('created_at', 'desc')->get();
			endif;

			return view('caisseManager.rapportSessionList', compact('datas'));

		else:
			$datas = $this->sessionRepository->getWhere()->where('caisse_id', '=', $caisse_id)->whereDate('created_at', Carbon::today()->toDateString())->orderBy('created_at', 'desc')->get();

			return view('caisseManager.rapportSession', compact('datas', 'caisse', 'date_now'));

		endif;
	}

	public function detailEcritureEtTransfert(Request $request, $ecriture_id, $caisse_id){

		if(isset($request['type'])):
			$data = $this->transfertFondRepository->getById($ecriture_id);
		else:
			$data = $this->ecritureCaisseRepository->getById($ecriture_id);
		endif;

		return view('caisseManager.detailEcritureEtTransfert', compact('data', 'request', 'caisse_id'));
	}


}
