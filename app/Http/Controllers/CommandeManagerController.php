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
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session;

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
	protected $cart;

	protected $tvCondition;

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
		$this->cart = app('cartlist');

		$this->tvCondition = new CartCondition(array(
			'name' => 'TVA',
			'type' => 'tax',
			'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
			'value' => '19.25%'
		));
	}

	public function index(){

		$this->cart->clear();

		$produit_list = $this->produitRepository->getWhere()->get();

		return view('commande.index', compact('produit_list'));
	}


	public function panier(Request $request, $produit_id){

		$prod = $this->produitRepository->getById($produit_id);

//		$currentUser= Auth::user();
//
//		$exist_prod = $prod->series()->where('type', '=', 0)->whereHas('Magasins', function ($q) use ($currentUser){
//			$q->where('pos_id', '=', $currentUser->pos_id);
//		})->count();

		$response = array(
			'success' => '',
			'error' => '',
			'subtotal' => 0,
			'tauxTax' => 0,
			'tax' => 0,
			'total' => 0
		);

		if(!$this->cart->get($prod->id)):
			$response['success'] = 'Le produit '.$prod->name.' a été ajouté';
			$this->cart->add($prod->id, $prod->name, $prod->prix, 1);
		else:
			$response['success'] = 'La quantité du produit '.$prod->name.' a été mise à jour';
			$this->cart->update($prod->id, array(
				'quantity' => 1,
			));
		endif;

		$response['subtotal'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

		$this->cart->condition($this->tvCondition);
		$tva = $this->cart->getCondition('TVA');
		$response['tauxTax'] = $tva->getValue();
		$value = $tva->getCalculatedValue($this->cart->getSubTotalWithoutConditions());
		$response['tax'] = number_format($value, 0, '.', ' ') ;
		$response['total'] = number_format($this->cart->getTotal(), 0, '.', ' ');

		return response()->json($response);

	}


	public function listPanier(){

		$paniers = $this->cart->getContent();
		if($paniers->count()):
			foreach ($paniers as $panier):
		?>

				<div class="col-md-12 no-padding" style="border-bottom: 1px solid #eee;">
					<div class="padding-15" style="width: 100%">
						<button type="button" class="close closed-panier" style="opacity: 1" data-close="<?= $panier->id ?>">&times;</button>
						<h4>
							<strong><?= $panier->name ?></strong>
						</h4>
						<p>
							<h4 style="display: inline-block; float: right">
								<strong><?= number_format($panier->getPriceSum(), 0, '.', ' ') ?> XAF</strong>
							</h4>

							Prix :  <span><?= number_format($panier->price, 0, '.', ' ') ?></span> x Quantite : <span><?= $panier->quantity ?></span>
						</p>
					</div>
				</div>
		<?php

			endforeach;

		else:

		?>
			<div class="col-md-12 no-padding" style="border-top: 1px solid #eeeeee">
				<div class="padding-15" style="width: 100%">
					<h3 class="text-center" style="margin: 0;"><strong>Aucun produit dans le panier</strong></h3>
				</div>
			</div>
		<?php

		endif;
	}

	public function DeleteItemPanier(Request $request){

	    $data = $request->all();

	    $this->cart->remove($data['id']);

		$response = array(
			'success' => '',
			'error' => '',
			'subtotal' => 0,
			'tauxTax' => 0,
			'tax' => 0,
			'total' => 0
		);

		$response['subtotal'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

		$this->cart->condition($this->tvCondition);
		$tva = $this->cart->getCondition('TVA');
		$response['tauxTax'] = $tva->getValue();
		$value = $tva->getCalculatedValue($this->cart->getSubTotalWithoutConditions());
		$response['tax'] = number_format($value, 0, '.', ' ') ;
		$response['total'] = number_format($this->cart->getTotal(), 0, '.', ' ');

		$response['success'] = 'Le produit a été supprimé du panier';

		return response()->json($response);

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

}
