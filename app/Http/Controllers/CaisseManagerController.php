<?php

namespace App\Http\Controllers;

use App\EcritureCaisse;
use App\Http\Requests\CaisseOpenRequest;
use App\Repositories\CaisseRepository;
use App\Repositories\EcritureCaisseRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class CaisseManagerController extends Controller
{
    //

	protected $modelRepository;
	protected $userRepository;
	protected $sessionRepository;
	protected $ecritureCaisseRepository;
	protected $parametreRepository;

	protected $devise;
	protected $current_user;

	public function __construct(CaisseRepository $caisse_repository, UserRepository $user_repository,
		SessionRepository $session_repository, EcritureCaisseRepository $ecriture_caisse_repository, ParametreRepository $parametre_repository) {

		$this->modelRepository = $caisse_repository;
		$this->userRepository = $user_repository;
		$this->sessionRepository = $session_repository;
		$this->ecritureCaisseRepository = $ecriture_caisse_repository;
		$this->parametreRepository = $parametre_repository;

		$this->devise = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'caisses'],
				['type_config', '=', 'devise']
			]
		)->first();

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

		return view('caisseManager.manager', compact(''));
	}


}
