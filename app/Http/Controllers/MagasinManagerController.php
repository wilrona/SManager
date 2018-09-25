<?php

namespace App\Http\Controllers;

use App\Repositories\CommandeRepository;
use App\Repositories\MagasinRepository;
use App\Repositories\SessionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MagasinManagerController extends Controller
{
    //

	protected $modelRepository;
	protected $sessionRepository;
	protected $commandeRepository;

	public function __construct(MagasinRepository $magasin_repository, SessionRepository $session_repository, CommandeRepository $commande_repository) {

		$this->modelRepository = $magasin_repository;
		$this->sessionRepository = $session_repository;
		$this->commandeRepository = $commande_repository;

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

		return view('magasinManager.preopen', compact('data', 'open_session', 'magasin_id'));


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

		if($magasin->etat == 0):

			$magasin->etat = 1;
			$magasin->save();

		endif;

		$produit_restant = 0;
		$produit_sortie = 0;


		if($exist_session->count()):

			$exist_sess = $exist_session->first();

			foreach ($exist_sess->EcritureStock()->get() as $item):
				$produit_sortie += $item->quantite;
			endforeach;

			foreach ($magasin->Stock()->where('type', '=', 0)->get() as $item):
				$produit_restant += 1;
			endforeach;

		endif;

		$produit_mag = $produit_restant + $produit_sortie;

		return view('magasinManager.manager', compact('magasin', 'produit_sortie', 'produit_restant', 'produit_mag'));
	}

	public function openReload($magasin_id){

		$magasin = $this->modelRepository->getById($magasin_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['magasin_id', '=', $magasin->id], ['last', '=', 1]]);

		$produit_restant = 0;
		$produit_sortie = 0;

		if($exist_session->count()):

			$exist_sess = $exist_session->first();

			foreach ($exist_sess->EcritureStock()->get() as $item):
				$produit_sortie += $item->quantite;
			endforeach;

			foreach ($magasin->Stock()->where('type', '=', 0)->get() as $item):
				$produit_restant += 1;
			endforeach;

		endif;

		$produit_mag = $produit_restant + $produit_sortie;

		return view('magasinManager.managerReload', compact('magasin', 'produit_restant', 'produit_sortie', 'produit_mag'));
	}

	public function searchCommande(Request $request){

		$data = $request->all();

		$response = array(
			'data' => []
		);

		if($data['q']):

			$commandes = $this->commandeRepository->getWhere()->where(
				[
					['codeCmd', 'LIKE', '%' . strtoupper($data['q']) . '%'],
					['etat', '=', 1]
				]
			)->get();

			foreach ($commandes as $commande):
				$cmd = [];
				$cmd['id'] = $commande->id;
				$cmd['reference'] = $commande->reference;
				$cmd['client'] = $commande->client()->first()->display_name;
				$cmd['total'] = number_format($commande->total, 0, '.', ' '). ' '.$commande->devise;
				$cmd['date'] = $commande->created_at->format('d-m-Y H:i');

				array_push($response['data'], $cmd);
			endforeach;

		endif;

		return response()->json($response);
	}

	public function close($magasin_id){

		$magasin = $this->modelRepository->getById($magasin_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['magasin_id', '=', $magasin->id], ['last', '=', 1]])->first();

		$exist_session->last = 0;
		$exist_session->save();

		$magasin->etat = 0;
		$magasin->save();

		$response = array(
			'code' => ''
		);

		return response()->json($response);

	}


}
