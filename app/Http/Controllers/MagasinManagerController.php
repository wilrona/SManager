<?php

namespace App\Http\Controllers;

use App\Repositories\MagasinRepository;
use App\Repositories\SessionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MagasinManagerController extends Controller
{
    //

	protected $modelRepository;
	protected $sessionRepository;

	public function __construct(MagasinRepository $magasin_repository, SessionRepository $session_repository) {

		$this->modelRepository = $magasin_repository;
		$this->sessionRepository = $session_repository;

	}

	public function index(){

		$current_user = Auth::user();

		$datas = $current_user->Magasins()->get();

		return view('magasinManager.index', compact('datas'));
	}

	public function preopen($magasin_id){

		$current_user = Auth::user();

		$open_session = $this->sessionRepository->getWhere()->where([['user_id', '=', $current_user->id], ['last', '=', 1]])->whereNotNull('magasin_id')->first();

		$data = $this->modelRepository->getById($magasin_id);

		if(!$open_session):
			return redirect()->route('magasinManager.open', ['magasin_id' => $magasin_id]);
		else:
			return view('magasinManager.preopen', compact('data', 'open_session'));
		endif;

	}

	public function open(Request $request, $magasin_id){

		$current_user = Auth::user();

		$user_id = $current_user->id;

		$magasin = $this->modelRepository->getById($magasin_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['magasin_id', '=', $magasin->id], ['last', '=', 1]]);

		if($magasin->etat == 1 && $exist_session->count() && $exist_session->first()->user_id != $user_id):
			return redirect()->route('magasinManager.index')->withWarning('Magasin ouvert par un autre utilisateur.');
		endif;

		if(!$exist_session->count()):

			$session = array();

			$session['last'] = 1;
			$session['magasin_id'] = $magasin->id;
			$session['user_id'] = $user_id;

			$this->sessionRepository->store($session);

		endif;


		return view('magasinManager.manager', compact('caisse', 'montant_caisse', 'exist_session', 'montant_encaisse', 'exist_receiveFond'));
	}
}
