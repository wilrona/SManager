<?php

namespace App\Http\Controllers;

use App\Repositories\CommandeRepository;
use App\Repositories\EcritureStockRepository;
use App\Repositories\MagasinRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SerieRepository;
use App\Repositories\SessionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MagasinManagerController extends Controller
{
    //

	protected $modelRepository;
	protected $sessionRepository;
	protected $commandeRepository;
	protected $ecritureStockRepository;
	protected $produitRepository;
	protected $serieRepository;

	public function __construct(MagasinRepository $magasin_repository, SessionRepository $session_repository,
		CommandeRepository $commande_repository, EcritureStockRepository $ecriture_stock_repository, ProduitRepository $produit_repository,
		SerieRepository $serie_repository
	) {

		$this->modelRepository = $magasin_repository;
		$this->sessionRepository = $session_repository;
		$this->commandeRepository = $commande_repository;
		$this->ecritureStockRepository = $ecriture_stock_repository;
		$this->produitRepository = $produit_repository;
		$this->serieRepository = $serie_repository;

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

		$end = Carbon::parse($exist_session->first()->created_at);

		$now = Carbon::now();

		$length = $now->diffInDays($end);

		if($length):
			return redirect()->route('magasinManager.close', ['magasin_id' => $magasin->id, 'redirect' => 1]);
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
					['codeCmd', 'LIKE', '%' . strtoupper($data['q']) . '%']
				]
			)->orWhere('etat', '=', 1)->orWhere('etat', '=', 2)->get();

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

	public function close(Request $request, $magasin_id){

		$data = $request->all();

		$magasin = $this->modelRepository->getById($magasin_id);

		$exist_session = $this->sessionRepository->getWhere()->where([['magasin_id', '=', $magasin->id], ['last', '=', 1]])->first();

		$exist_session->last = 0;
		$exist_session->save();

		$magasin->etat = 0;
		$magasin->save();

		$response = array(
			'code' => ''
		);

		if(isset($data['redirect'])):
			return redirect()->route('magasinManager.index')->withWarning('Magasin fermé automatique.');
		else:
			return response()->json($response);
		endif;

	}

	public function storyTransfertStock(Request $request, $magasin_id){

		$exist_session = $this->sessionRepository->getWhere()->where([['magasin_id', '=', $magasin_id], ['last', '=', 1]])->first();

		$datas = $exist_session->commandes()->orderBy('created_at', 'desc')->get();

		return view('magasinManager.storyTransfertStock', compact('datas', 'magasin_id'));


	}

	public function stockCommande(Request $request, $id = null){

		$request->session()->forget('commande_serie_produit');

		$data = $this->commandeRepository->getById($id);

		return view('magasinManager.stockCommande', compact('data', 'request'));

	}

	public function serieProduit(Request $request){

		$data = $request->all();

		$cmd = $this->commandeRepository->getById($data['commande_id']);
		$ligne = $cmd->Produits()->where('id', '=', $data['id'])->first();

		$prod = $this->produitRepository->getById($data['id']);

		$exist_prod = $prod->series()->with('Produit', 'Lot')->where('type', '=', 0)->whereHas('Magasins', function ($q) use ($data){
			$q->where('id', '=', $data['magasin_id']);
		})->get();

		$in_session = [];
		$in_session_count = 0;

		if($request->session()->has('commande_serie_produit')):

			$in_session_var = $request->session()->get('commande_serie_produit');

			$key_prod = array_search($data['id'], array_column($in_session_var, 'produit_id'));

			if(is_integer($key_prod)):

				$in_session = $in_session_var[$key_prod]['serie'];
				$in_session_count = count($in_session_var[$key_prod]['serie']);

			endif;

		endif;

		foreach ($cmd->EcritureStock()->where('produit_id', '=', $data['id'])->get() as $ecriture):
			$in_session_count += $ecriture->quantite;
		endforeach;

		return view('magasinManager.serieProduit', compact('ligne', 'exist_prod', 'in_session', 'in_session_count'));

	}

	public function serieProduitCheck(Request $request){

		$data = $request->all();

		$serie_id = array();

		if($request->session()->has('commande_serie_produit')):
			$serie_id = $request->session()->get('commande_serie_produit');
		endif;

		$count = $data['count'];

		$serie = $this->serieRepository->getById($data['id']);

		$key_prod = array_search($serie->produit_id, array_column($serie_id, 'produit_id'));

		if(!is_integer($key_prod)):
			$prod = array();
			$prod['produit_id'] = $serie->produit_id;
			$prod['serie'] = array();
			array_push($prod['serie'], $serie->id);
			array_push($serie_id, $prod);
			$count += 1;
		else:

			if($data['action'] == 'add'):
				$count += 1;
				array_push($serie_id[$key_prod]['serie'], $serie->id);
			else:
				$count -= 1;
				if (($key = array_search($serie->id, $serie_id[$key_prod]['serie'])) !== false) {
					unset($serie_id[$key_prod]['serie'][$key]);
				}
			endif;

		endif;

		$response = array(
			'success' => '',
			'error' => '',
			'count' => 0,
			'action' => $data['action']
		);

		$current_count = $count;


		if($current_count <= $data['totalCount']):

			if($data['action'] == 'add'):
				$response['success'] = 'Le numéro de série a été pris en compte';
			else:
				$response['success'] = 'Le numéro de série a été retiré avec succès';
			endif;

		else:
			$response['error'] = 'Quantité de serie selectionnée supérieure par rapport à la quantité commandée';
			$count -= 1;
			if (($key = array_search($serie->id, $serie_id[$key_prod]['serie'])) !== false) {
				unset($serie_id[$key_prod]['serie'][$key]);
			}
		endif;

		$response['count'] = $count;
		$response['content'] = $serie_id;

		$request->session()->put('commande_serie_produit', $serie_id);

		return response()->json($response);

	}

	public function validCommande(Request $request){

		$data = $request->all();

		$current_user = Auth::user();

		$cmd = $this->commandeRepository->getById($data['commande_id']);
		$lignes = $cmd->Produits()->get();

		$response = array(
			'success' => '',
			'error' => '',
			'produit_restant' => 0,
			'produit_sortie' => 0

		);

		$error = false;

		$in_session = $request->session()->get('commande_serie_produit');

		foreach ($lignes as $produit):

			if($in_session):
				$key_prod = array_search($produit->id, array_column($in_session, 'produit_id'));

				$ecrite = $cmd->ecriturestock()->where('produit_id', '=', $produit->id)->get();
				$old_qte = 0;

				foreach ($ecrite as $item):
					$old_qte += $item->quantite;
				endforeach;

				$in_ses = count($in_session[$key_prod]['serie']) + $old_qte;

				if($in_ses < $produit->pivot->qte):
					$error = true;
				endif;
			endif;

		endforeach;

		$exist_session = $this->sessionRepository->getWhere()->where([['magasin_id', '=', $data['magasin_id']], ['last', '=', 1]])->first();

		$ecriture_stock = array();
		$ecriture_stock['type_ecriture'] = 1;
		$ecriture_stock['user_id'] = $current_user->id;
		$ecriture_stock['magasin_id'] = $data['magasin_id'];
		$ecriture_stock['commande_id'] = $cmd->id;
		$ecriture_stock['session_id'] = $exist_session->id;


		$exist_var_session = false;

		if($in_session):

			foreach ($in_session as $session):

				if($session['serie']):

					$ecriture_stock['produit_id'] = $session['produit_id'];
					$ecriture_stock['quantite'] = count($session['serie']);

					$transit = $this->ecritureStockRepository->store($ecriture_stock);

					$link = $cmd->Produits()->where('id', '=',$session['produit_id'])->first();

					$serie_out = [];

					if(unserialize($link->pivot->serie_sortie)):
						$serie_out = unserialize($link->pivot->serie_sortie);
					endif;

					foreach ($session['serie'] as $serie):
						$serial = $this->serieRepository->getById($serie);
						$serial->EcriureStocks()->save($transit);
						$serial->Magasins()->wherePivot('magasin_id', '=', $data['magasin_id'])->detach();
						array_push($serie_out, $serie);
					endforeach;


					$link->pivot->serie_sortie = serialize($serie_out);
					$link->pivot->save();

					$exist_var_session = true;

				endif;

			endforeach;

		endif;

		if($exist_var_session):

			if(!$error):
				$cmd->etat = 3;

				$cmd->StoryAction()->save($current_user, ['etape_action' => 'cmd_serie_total', 'description' => 'Sérialisation totale de la commande "'.$cmd->reference.'"']);
			else:
				$cmd->etat = 2;

				$cmd->StoryAction()->save($current_user, ['etape_action' => 'cmd_serie_partiel', 'description' => 'Sérialisation partielle de la commande "'.$cmd->reference.'"']);
			endif;

			$cmd->save();

			$cmd->sessions()->save($exist_session);


			$request->session()->forget('commande_serie_produit');

			if($exist_session->count()):

				$exist_sess = $exist_session->first();
				$magasin = $this->modelRepository->getById($data['magasin_id']);

				foreach ($exist_sess->EcritureStock()->get() as $item):
					$response['produit_sortie'] += $item->quantite;
				endforeach;

				foreach ($magasin->Stock()->where('type', '=', 0)->get() as $item):
					$response['produit_restant'] += 1;
				endforeach;

			endif;

			$response['success'] = 'Les produits ont été serialisés avec succeès';

		else:
			$response['error'] = 'Aucun numéro de serie fournis au produit';
		endif;

		return response()->json($response);
	}


}
