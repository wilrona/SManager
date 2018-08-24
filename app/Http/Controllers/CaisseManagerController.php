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

		$data = $this->modelRepository->getById($caisse_id);

		$devise = $this->devise;

		return view('caisseManager.preopen', compact('data', 'devise'));

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

		$caisse = $this->modelRepository->getById($caisse_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['caisse_id', '=', $caisse->id], ['last', '=', 1]]);

		if($caisse->etat == 1 && $exist_session->count() && $exist_session->first()->user_id != $current_user->id):
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
			$session['user_id'] = $current_user->id;

			$save_session = $this->sessionRepository->store($session);

			$ecriture = array();
			$ecriture['libelle'] = 'Ouverture de la caisse';
			$ecriture['type_ecriture'] = 1;
			$ecriture['type_paiement'] = 'cash';
			$ecriture['devise'] = $this->devise->value;
			$ecriture['montant'] = $caisse->montantEnCours;
			$ecriture['session_id'] = $save_session->id;
			$ecriture['caisse_id'] = $caisse->id;
			$ecriture['user_id'] = $current_user->id;

			$this->ecritureCaisseRepository->store($ecriture);

		endif;

		if($caisse->etat == 0):

			$caisse->etat = 1;
			$caisse->save();

		endif;

		return view('caisseManager.manager', compact('caisse'));
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
		else:
			$principal_caisse = $pos_principal->Caisses()->where('principal', '=', 1)->first();
			$caisse_sender[$principal_caisse->id] = $principal_caisse->name;
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
			'field' => ''
		);

		if(!$datas['caisse_receive_id']):
			$response['error_field'] = "Selectionnez une caisse";
			$response['field'] = 'caisse_receive_id';

		else:
			if(empty($datas['montant'])):
				$response['error_field'] = "Veuillez saisir un montant pour à transferer";
				$response['field'] = 'montant';

			else:
				if($datas['montant'] == 0):
					$response['error_field'] = "Le montant doit etre supérieure à 0";
					$response['field'] = 'montant';

				else:
					if(!$datas['motif']):
						$response['error_field'] = "Le motif est obligatoire";
						$response['field'] = 'motif';
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

		if($datas['montant']):

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
				$transfert['caisse_sender_id'] = $caisse_id->id;
				$transfert['caisse_receive_id'] = $caisse_receive->id;
				$transfert['montant'] = $datas['montant'];
				$transfert['motif'] = $datas['motif'];
				$transfert['code_transfert'] = $codeTranfert;

				$transfert_fond_id =$this->transfertFondRepository->store($transfert);

				$ecriture = array();
				$ecriture['libelle'] = 'Transfert de fond';
				$ecriture['type_ecriture'] = 2;
				$ecriture['type_paiement'] = 'cash';
				$ecriture['devise'] = $this->devise->value;
				$ecriture['montant'] = ($datas['montant'] * -1);
				$ecriture['session_id'] = $exist_session->id;
				$ecriture['caisse_id'] = $caisse->id;
				$ecriture['user_id'] = $current_user->id;
				$ecriture['transfert_fond_id'] = $transfert_fond_id->id;

				$this->ecritureCaisseRepository->store($ecriture);

				$response['success'] = "Transfert de fond enregistré";
			endif;

		endif;


		return response()->json($response);
	}


}
