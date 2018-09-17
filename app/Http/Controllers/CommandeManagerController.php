<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Library\CustomFunction;
use App\Repositories\ClientRepository;
use App\Repositories\CommandeRepository;
use App\Repositories\FamilleRepository;
use App\Repositories\MagasinRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
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
	protected $posRepository;

	protected $custom;
	protected $cart;
	protected $apply_tva;
	protected $tva;

	protected $tvCondition;

	public function __construct(CommandeRepository $commande_repository, FamilleRepository $famille_repository,
		ParametreRepository $parametre_repository, ClientRepository $client_repository, ProduitRepository $produit_repository,
		MagasinRepository $magasin_repository, PointDeVenteRepository $point_de_vente_repository
	) {
		$this->modelRepository = $commande_repository;
		$this->familleRepository = $famille_repository;
		$this->parametreRepository = $parametre_repository;
		$this->clientRepository = $client_repository;
		$this->produitRepository = $produit_repository;
		$this->magasinRepository = $magasin_repository;
		$this->posRepository = $point_de_vente_repository;

		$this->custom = new CustomFunction();
		$this->cart = app('cartlist');

		$tax_valeur = $parametre_repository->getWhere()->where(
			[
				['module', '=', 'commandes'],
				['type_config', '=', 'taxvalue']
			]
		)->first();

		$apply = $parametre_repository->getWhere()->where(
			[
				['module', '=', 'commandes'],
				['type_config', '=', 'tax_produit']
			]
		)->first();

		$this->apply_tva = $apply ? $apply->value : '';

		$this->tva = ($tax_valeur && intval($tax_valeur->value) > 0) ? strval($tax_valeur->value) : '19.25';

		if(!$apply):

			$this->tvCondition = new CartCondition(array(
				'name' => 'TVA',
				'type' => 'tax',
				'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
				'value' => ($tax_valeur && intval($tax_valeur->value) > 0) ? strval($tax_valeur->value).'%' : '19.25%'
			));

        else:

            if($apply->value == 'inclus'):

	            $this->tvCondition = new CartCondition(array(
		            'name' => 'TVA',
		            'type' => 'tax',
		            'value' => ($tax_valeur && intval($tax_valeur->value) > 0) ? '-'.strval($tax_valeur->value).'%' : '-19.25%'
	            ));

            else:

                $this->tvCondition = new CartCondition(array(
                    'name' => 'TVA',
                    'type' => 'tax',
                    'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                    'value' => ($tax_valeur && intval($tax_valeur->value) > 0) ? strval($tax_valeur->value).'%' : '19.25%'
                ));

		    endif;
		endif;

	}

	public function index(){

		$this->cart->clear();
		$this->cart->clearCartConditions();

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
			'total' => 0,
            'update' => 0,
            'id' => '',
            'countItem' => 0
		);

		if(!$this->cart->get($prod->id)):
			$response['success'] = 'Le produit '.$prod->name.' a été ajouté';
			$this->cart->add($prod->id, $prod->name, $prod->prix, 1);
			if($this->apply_tva == 'inclus'):
                $this->cart->addItemCondition($prod->id, $this->tvCondition);
            endif;
		else:
			$response['success'] = 'La quantité du produit '.$prod->name.' a été mise à jour';
		    $response['update'] = 1;

			$this->cart->update($prod->id, array(
				'quantity' => 1,
			));
		endif;

		$response['id'] = $prod->id;
		$response['countItem'] = $this->cart->getContent()->count();



		if(!$this->apply_tva || $this->apply_tva != 'inclus'):

			$response['subtotal'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

            $tva = $this->cart->getCondition('TVA');

            if(!$tva):
                $this->cart->condition($this->tvCondition);
                $tva = $this->cart->getCondition('TVA');
            endif;

			$response['tauxTax'] = $tva->getValue();

			$value = $tva->getCalculatedValue($this->cart->getSubTotalWithoutConditions());
			$response['tax'] = number_format($value, 0, '.', ' ') ;

			$response['total'] = number_format($this->cart->getTotal(), 0, '.', ' ');

        else:

	        $response['total'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

            $price_tax = 0;
            $price = 0;
            foreach ($this->cart->getContent() as $pro):
                $price_tax += $pro->getPriceSum();
	            $price += $pro->getPriceSumWithConditions();
            endforeach;
	        $response['tax'] = number_format(($price_tax - $price), 0, '.', ' ') ;

	        $response['tauxTax'] = $this->tva.'%';

	        $response['subtotal'] = number_format($this->cart->getTotal(), 0, '.', ' ');
		endif;



		return response()->json($response);

	}


	public function listPanier(Request $request){

	    $data = $request->all();
		$panier = $this->cart->get($data['id']);

		if($panier):
		?>
            <div class="col-md-12 no-padding item-panier" style="border-bottom: 1px solid #eee;" data-id="<?= $panier->id ?>">
                <div class="padding-15" style="width: 100%">
                    <button type="button" class="close closed-panier" style="opacity: 1" data-close="<?= $panier->id ?>">&times;</button>
                    <h4>
                        <strong><?= $panier->name ?></strong>
                    </h4>
                    <p>
                        <h4 style="display: inline-block; float: right">
                            <strong><?= $panier->price == $panier->getPriceWithConditions() ? number_format($panier->getPriceSum(), 0, '.', ' ') : number_format($panier->getPriceSumWithConditions(), 0, '.', ' ') ?> XAF</strong>
                        </h4>

                        Prix :  <span><?= $panier->price == $panier->getPriceWithConditions() ? number_format($panier->price, 0, '.', ' ') : number_format($panier->getPriceWithConditions(), 0, '.', ' ') ?></span> x Quantite : <span><?= $panier->quantity ?></span>
                    </p>
                </div>
            </div>
        <?php

        else:

            if(!$this->cart->getContent()->count()):

        ?>
            <div class="col-md-12 no-padding" style="border-top: 1px solid #eeeeee">
                <div class="padding-15" style="width: 100%">
                    <h3 class="text-center" style="margin: 0;"><strong>Aucun produit dans le panier</strong></h3>
                </div>
            </div>

        <?php

            endif;
        endif;
	}

	public function DeleteItemPanier(Request $request){

	    $data = $request->all();

	    $response = array();

	    if($data['request'] == 'remove'):

            $this->cart->remove($data['id']);

            if($this->apply_tva == 'inclus'):
		        $this->cart->removeItemCondition($data['id'], 'TVA');
	        endif;

            $response = array(
                'success' => '',
                'error' => '',
                'subtotal' => 0,
                'tauxTax' => 0,
                'tax' => 0,
                'total' => 0,
                'id' => $data['id']
            );

		    if(!$this->apply_tva || $this->apply_tva != 'inclus'):

			    $response['subtotal'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

			    $tva = $this->cart->getCondition('TVA');

			    if(!$tva):
				    $this->cart->condition($this->tvCondition);
				    $tva = $this->cart->getCondition('TVA');
			    endif;

			    $response['tauxTax'] = $tva->getValue();

			    $value = $tva->getCalculatedValue($this->cart->getSubTotalWithoutConditions());
			    $response['tax'] = number_format($value, 0, '.', ' ') ;

			    $response['total'] = number_format($this->cart->getTotal(), 0, '.', ' ');

		    else:

			    $response['total'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

			    $price_tax = 0;
			    $price = 0;
			    foreach ($this->cart->getContent() as $pro):
				    $price_tax += $pro->getPriceSum();
				    $price += $pro->getPriceSumWithConditions();
			    endforeach;
			    $response['tax'] = number_format(($price_tax - $price), 0, '.', ' ') ;

			    $response['tauxTax'] = $this->cart->getContent()->count() ? $this->tva.'%' : '0%';

			    $response['subtotal'] = number_format($this->cart->getTotal(), 0, '.', ' ');
		    endif;

            $response['success'] = 'Le produit a été supprimé du panier';

		endif;

		if($data['request'] == 'select'):

            $response = array(
                'id' => '',
                'name' => '',
                'qte' => 0

            );

		    $prod = $this->cart->get($data['id']);

		    $response['id'] = $prod->id;
		    $response['name'] = $prod->name;
		    $response['qte'] = $prod->quantity;

        endif;

		if($data['request'] == 'updateQte'):

			$response = array(
				'success' => '',
				'error' => '',
				'subtotal' => 0,
				'tauxTax' => 0,
				'tax' => 0,
				'total' => 0,
                'id' => $data['id']
			);

		    $this->cart->update($data['id'], array(
			    'quantity' => array(
				    'relative' => false,
				    'value' => $data['quantite']
			    )
            ));

			$response['subtotal'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

			$this->cart->condition($this->tvCondition);
			$tva = $this->cart->getCondition('TVA');
			$response['tauxTax'] = $tva->getValue();
			$value = $tva->getCalculatedValue($this->cart->getSubTotalWithoutConditions());
			$response['tax'] = number_format($value, 0, '.', ' ') ;
			$response['total'] = number_format($this->cart->getTotal(), 0, '.', ' ');

			$response['success'] = 'La quantité du produit a été modifié dans le panier';


        endif;

		return response()->json($response);
    }


    public function saveCommande(Request $request){

	    $data = $request->all();

	    $count = $this->modelRepository->getWhere()->count();
	    $coderef = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'commandes'],
			    ['type_config', '=', 'coderef']
		    ]
	    )->first();
	    $incref = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'commandes'],
			    ['type_config', '=', 'incref']
		    ]
	    )->first();
	    $count += $incref ? intval($incref->value) : 1;

	    $currentUser = Auth::user();

	    $POS = $this->posRepository->getById($currentUser->pos_id);

	    $reference = $this->custom->setReference($coderef, $count, 6, $POS->reference);

	    $codeTranfert = $this->custom->randomPassword(6, 1, 'upper_case,numbers');

	    $commande = array();
	    $commande['reference'] = $reference;
	    $commande['client_id'] = $data['client_id'];
	    $commande['point_de_vente_id'] = $POS->id;
	    $commande['total'] = $this->cart->getTotal();
	    $commande['subtotal'] = $this->cart->getSubTotalWithoutConditions();
	    $commande['codeCmd'] = $codeTranfert;

	    $commande_id = $this->modelRepository->store($commande);

	    $cmd = $this->modelRepository->getById($commande_id->id);

	    $devises = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'caisses'],
			    ['type_config', '=', 'devise']
		    ]
	    )->first();

	    $panier = $this->cart->getContent();

	    foreach ($panier as $item):

            $item_pro = $this->produitRepository->getById($item->id);

            $cmd->Produits()->save($item_pro, ['prix' => $item->price, 'qte' => $item->quantity, 'devise' => $devises->value ? $devises->value : '']);

        endforeach;

        $response = [
              'codeCmd' => $codeTranfert
        ];

        $this->cart->clear();

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
		$count += $incref ? intval($incref->value) : 1;
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

	public function commandePos(){

		$currentUser = Auth::user();

		$datas = $this->modelRepository->getWhere()->where('point_de_vente_id', '=', $currentUser->pos_id)->orderBy('created_at', 'desc')->get();

		return view('commande.commandePos', compact('datas'));

    }

	public function commandePosDetail($id){

		$data = $this->modelRepository->getById($id);

		return view('commande.commandePosDetail', compact('data'));

	}

}
