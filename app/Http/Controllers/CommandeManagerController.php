<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Library\CustomFunction;
use App\Repositories\ClientRepository;
use App\Repositories\CommandeRepository;
use App\Repositories\FamilleRepository;
use App\Repositories\MagasinRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\ProduitRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeManagerController extends Controller
{
    //

	protected $modelRepository;
	protected $familleRepository;
	protected $parametreRepository;
	protected $clientRepository;
	protected $produitRepository;
	protected $magasinRepository;

	protected $custom;

	public function __construct(CommandeRepository $commande_repository, FamilleRepository $famille_repository,
		ParametreRepository $parametre_repository, ClientRepository $client_repository, ProduitRepository $produit_repository,
		MagasinRepository $magasin_repository
	) {
		$this->modelRepository = $commande_repository;
		$this->familleRepository = $famille_repository;
		$this->parametreRepository = $parametre_repository;
		$this->clientRepository = $client_repository;
		$this->produitRepository = $produit_repository;
		$this->magasinRepository = $magasin_repository;

		$this->custom = new CustomFunction();
	}

	public function index(Request $request){

//		$request->session()->forget('panier');

		$produit_list = $this->produitRepository->getWhere()->get();

		return view('commande.index', compact('produit_list'));
	}

	public function formClient(){

		$famillesData = $this->familleRepository->getWhere()->where([['type', '=', '1'], ['active', '=', 1]])->get();

		$familles = array();

		foreach ($famillesData as $famille):
			$familles[$famille->id] = $famille->name;
		endforeach;

		// Initialisation de la reference

		$count = $this->clientRepository->getWhere()->count();
		$coderef = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'clients'],
				['type_config', '=', 'coderef']
			]
		)->first();
		$incref = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'clients'],
				['type_config', '=', 'incref']
			]
		)->first();
		$count += $incref ? intval($incref->value) : 0;
		$reference = $this->custom->setReference($coderef, $count, 4);

		return view('commande.formClient', compact('familles', 'reference'));
	}

	public function formClientPost(ClientRequest $request){

		$data = $request->all();

		$dateNaiss = $data['dateNais'];
		$data['dateNais'] = date('Y-m-d', strtotime($dateNaiss));

		$data['display_name'] = $data['nom'];
		$data['display_name'] .= $data['prenom'] ? ' '.$data['prenom'] : '';

		$c = new CustomFunction();

		if(empty($data['reference'])):
			$reference = $c->setReference('Cl', [$data['nom'], $data['prenom']], 4, "numbers");
			$data['reference'] = $reference;
		endif;

		$response = [
			'user_id' => '',
			'user_name' => '',
			'error' => '',
			'success' => ''
		];

		$user = $this->clientRepository->store($data);

		if($user):

			$response['success'] = 'Enregistrement effectué avec succès';
			$response['user_id'] = $user->id;
			$response['display_name'] = $data['display_name'];

		else:

			$response['error'] = 'Error d\'enregistrement des modifications';

		endif;


		return response()->json($response);

	}

	public function panier(Request $request, $produit_id){

		$prod = $this->produitRepository->getById($produit_id);

		$currentUser= Auth::user();

		$exist_prod = $prod->series()->where('type', '=', 0)->whereHas('Magasins', function ($q) use ($currentUser){
			$q->where('pos_id', '=', $currentUser->pos_id);
		})->count();

		$panier = array();
		$panier['produit'] = array();
		$panier['total'] = 0;
		$panier['subtotal'] = 0;
		$panier['TVA'] = 19.25;
		$panier['error'] = '';
		var_dump($request->session()->has('panier_commande'));
		if($request->session()->has('panier_commande')):
			$panier = $request->session()->get('panier_commande');
			var_dump('SESSION');
		endif;

		$key = array_search($prod->id, array_column($panier['produit'], 'id'));

		if(!is_integer($key)):

			$prod_new = array();
			$prod_new['id'] = $prod->id;
			$prod_new['titre'] = $prod->name;
			$prod_new['qte'] = 1;
			$prod_new['prix'] = $prod->prix;
			$prod_new['total'] = $prod->prix * 1;

			array_push($panier['produit'], $prod_new);

			$panier['total'] += ($prod->prix * 1);

		else:

			$panier['produit'][$key]['qte'] += 1;
			$panier['total'] += ($prod->prix * 1);

		endif;

		$montant_tva = ($panier['TVA'] * $panier['total']) / 100;
		$panier['subtotal'] = $panier['total'] - $montant_tva;



		$request->session()->put('panier_commande', $panier);

		var_dump('OK');

		var_dump($request->session()->has('panier_commande'));


		die();

	}

}
