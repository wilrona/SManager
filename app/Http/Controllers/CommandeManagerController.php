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

	protected $tvaCondition;
	protected $tvaInclusCondition;

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

		$this->tvaInclusCondition = ($tax_valeur && intval($tax_valeur->value) > 0) ? ($tax_valeur->value / 100) + 1 : (19.25 / 100) + 1;

		$this->tvaCondition = new CartCondition(array(
			'name' => 'TVA',
			'type' => 'tax',
			'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
			'value' => ($tax_valeur && intval($tax_valeur->value) > 0) ? strval($tax_valeur->value).'%' : '19.25%'
		));

	}

	public function index(){

		$this->cart->clear();
		$this->cart->clearCartConditions();

		$produit_list = $this->produitRepository->getWhere()->get();

		return view('commande.index', compact('produit_list'));
	}


	public function panier(Request $request, $produit_id){

	    $data = $request->all();

		$prod = $this->produitRepository->getById($produit_id);

		$currentUser= Auth::user();

		$exist_prod = $prod->series()->where('type', '=', 0)->whereHas('Magasins', function ($q) use ($currentUser){
			$q->where('pos_id', '=', $currentUser->pos_id);
		})->count();

		$exist_cmd = $prod->Commandes()->where([
		        ['point_de_vente_id', '=', $currentUser->pos_id],
                ['etat', '<=', 1]
        ])->get();

		$count_exist_cmd = 0;

		foreach ( $exist_cmd as $item ) {
            $count_exist_cmd += $item->pivot->qte;
		}

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

		$count_en_stock = $exist_prod - $count_exist_cmd;

		if($count_en_stock):

			$prix = $prod->prix;

            if(!$this->cart->get($prod->id)):

	            if(isset($data['client_id']) && !empty($data['client_id'])):
		            $prix_ckeck = $this->relativePrice($prod, $data['client_id'], 1);
		            $prix = $prix_ckeck ? $prix_ckeck : $prix;
	            endif;

                $response['success'] = 'Le produit '.$prod->name.' a été ajouté';

                if($this->apply_tva == 'inclus'):
	                $prix = $prix / $this->tvaInclusCondition;
                endif;

	            $this->cart->add($prod->id, $prod->name, $prix , 1);

            else:

                $current_prod = $this->cart->get($prod->id);

                if($current_prod->quantity < $count_en_stock):

                    $response['success'] = 'La quantité du produit '.$prod->name.' a été mise à jour';
                    $response['update'] = 1;

                    if(isset($data['client_id']) && !empty($data['client_id'])):
                        $prix_ckeck = $this->relativePrice($prod, $data['client_id'], $current_prod->quantity + 1);
                        $prix = $prix_ckeck ? $prix_ckeck : $prix;
                    endif;

	                if($this->apply_tva == 'inclus'):
		                $prix = $prix / $this->tvaInclusCondition;
	                endif;

	                $update = array(
		                'quantity' => 1,
		                'price' => $prix
	                );


                    $this->cart->update($prod->id, $update);
                else:
	                $response['error'] = 'Quantité en stock de ce produit dépassée.';
                endif;

            endif;

            $response['id'] = $prod->id;
            $response['countItem'] = $this->cart->getContent()->count();

            $response['subtotal'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

            $tva = $this->cart->getCondition('TVA');

            if(!$tva):
                $this->cart->condition($this->tvaCondition);
                $tva = $this->cart->getCondition('TVA');
            endif;

            $response['tauxTax'] = $tva->getValue();

            $value = $tva->getCalculatedValue($this->cart->getSubTotalWithoutConditions());
            $response['tax'] = number_format($value, 0, '.', ' ') ;

            $response['total'] = number_format($this->cart->getTotal(), 0, '.', ' ');

		else:
            $response['error'] = 'Vous ne disposez pas de ce produit dans vos magasins';

        endif;

		return response()->json($response);

	}

    public function selectClient(Request $request){

	    $data = $request->all();

	    $contentCart = $this->cart->getContent();

	    $response = array(
		    'subtotal' => 0,
		    'tauxTax' => 0,
		    'tax' => 0,
		    'total' => 0,
		    'update' => 0,
		    'id' => '',
		    'countItem' => 0,
            'itemContent' => []
	    );

	    foreach ($contentCart as $cart):

            $item = [];
	        $item['id'] = $cart->id;
	        $item['quantity'] = $cart->quantity;
//		    $item['name'] = $cart->name;
//		    $item['price'] = $cart->price;

	        array_push($response['itemContent'], $item);

		    $this->cart->clearItemConditions($cart->id);

        endforeach;

        $response['countItem'] = $contentCart->count();

	    $this->cart->clear();
	    $this->cart->clearCartConditions();

	    foreach ($response['itemContent'] as $content):

	        $prod = $this->produitRepository->getById($content['id']);

		    $prix = $prod->prix;

		    if(isset($data['client_id']) && !empty($data['client_id'])):
			    $prix_ckeck = $this->relativePrice($prod, $data['client_id'], $content['quantity']);
			    $prix = $prix_ckeck ? $prix_ckeck : $prix;
		    endif;

		    if($this->apply_tva == 'inclus'):
			    $prix = $prix / $this->tvaInclusCondition;
		    endif;

		    $this->cart->add($prod->id, $prod->name, $prix, $content['quantity']);

        endforeach;

	    $response['subtotal'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

	    $tva = $this->cart->getCondition('TVA');

	    if(!$tva):
		    $this->cart->condition($this->tvaCondition);
		    $tva = $this->cart->getCondition('TVA');
	    endif;

	    $response['tauxTax'] = $tva->getValue();

	    $value = $tva->getCalculatedValue($this->cart->getSubTotalWithoutConditions());
	    $response['tax'] = number_format($value, 0, '.', ' ') ;

	    $response['total'] = number_format($this->cart->getTotal(), 0, '.', ' ');

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

            $response = array(
                'success' => '',
                'error' => '',
                'subtotal' => 0,
                'tauxTax' => 0,
                'tax' => 0,
                'total' => 0,
                'id' => $data['id']
            );

		    $response['subtotal'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

		    $tva = $this->cart->getCondition('TVA');

		    if(!$tva):
			    $this->cart->condition($this->tvaCondition);
			    $tva = $this->cart->getCondition('TVA');
		    endif;

		    $response['tauxTax'] = $tva->getValue();

		    $value = $tva->getCalculatedValue($this->cart->getSubTotalWithoutConditions());
		    $response['tax'] = number_format($value, 0, '.', ' ') ;

		    $response['total'] = number_format($this->cart->getTotal(), 0, '.', ' ');

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

			$prod = $this->produitRepository->getById($data['id']);

			$currentUser= Auth::user();

			$exist_prod = $prod->series()->where('type', '=', 0)->whereHas('Magasins', function ($q) use ($currentUser){
				$q->where('pos_id', '=', $currentUser->pos_id);
			})->count();

			$exist_cmd = $prod->Commandes()->where([
				['point_de_vente_id', '=', $currentUser->pos_id],
				['etat', '<=', 1]
			])->get();

			$count_exist_cmd = 0;

			foreach ( $exist_cmd as $item ) {
				$count_exist_cmd += $item->pivot->qte;
			}

			$count_en_stock = $exist_prod - $count_exist_cmd;

			if($data['quantite'] <= $count_en_stock):

                $prix = $prod->prix;

                if(isset($data['client_id']) && !empty($data['client_id'])):
                    $prix_ckeck = $this->relativePrice($prod, $data['client_id'], $data['quantite']);
                    $prix = $prix_ckeck ? $prix_ckeck : $prix;
                endif;

				if($this->apply_tva == 'inclus'):
					$prix = $prix / $this->tvaInclusCondition;
				endif;

                $this->cart->update($data['id'], array(
                    'price' => $prix,
                    'quantity' => array(
                        'relative' => false,
                        'value' => $data['quantite']
                    )
                ));

				$response['success'] = 'La quantité du produit a été modifié dans le panier';

            else:
	            $response['error'] = 'La quantité du produit en stock a été dépassé.';

		    endif;

			$response['subtotal'] = number_format($this->cart->getSubTotalWithoutConditions(), 0, '.', ' ');

			$tva = $this->cart->getCondition('TVA');

			if(!$tva):
				$this->cart->condition($this->tvaCondition);
				$tva = $this->cart->getCondition('TVA');
			endif;

			$response['tauxTax'] = $tva->getValue();

			$value = $tva->getCalculatedValue($this->cart->getSubTotalWithoutConditions());
			$response['tax'] = number_format($value, 0, '.', ' ') ;

			$response['total'] = number_format($this->cart->getTotal(), 0, '.', ' ');

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

	    $devises = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'caisses'],
			    ['type_config', '=', 'devise']
		    ]
	    )->first();

	    $commande = array();
	    $commande['reference'] = $reference;
	    $commande['client_id'] = $data['client_id'];
	    $commande['point_de_vente_id'] = $POS->id;

	    $commande['codeCmd'] = $codeTranfert;
	    $commande['devise'] = $devises ? $devises->value : '';

        $commande['total'] = $this->cart->getTotal();
        $commande['subtotal'] = $this->cart->getSubTotalWithoutConditions();

	    $commande_id = $this->modelRepository->store($commande);

	    $cmd = $this->modelRepository->getById($commande_id->id);

	    $panier = $this->cart->getContent();

	    foreach ($panier as $item):

            $item_pro = $this->produitRepository->getById($item->id);

            $cmd->Produits()->save($item_pro, ['prix' => $item->price, 'qte' => $item->quantity, 'devise' => $devises ? $devises->value : '']);

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

	public function relativePrice($prod_object, $client_id, $quantity = null){

        $groupe_prix = $prod_object->GroupePrix()->where('active', '=', 1)->get();

	    $montant_famille = 0;
	    $montant_client = 0;

	    $client = $this->clientRepository->getById($client_id);
	    $famille = $client->Famille()->first();

	    foreach ($groupe_prix as $g_prix):

            if($g_prix->type_client):

                if($g_prix->famille_id == $famille->id):

	                if($g_prix->quantite_min <= $quantity):

                        if($g_prix->type_remise == 1):

                            $value = ($g_prix->prix * $g_prix->remise) / 100;
                            $montant_famille += $value;

                        else:
                            $montant_famille += $g_prix->remise;
                        endif;

	                endif;

                endif;

            else:

	            if($g_prix->client_id == $client->id):

		            if($g_prix->quantite_min <= $quantity):

                        if($g_prix->type_remise == 1):
                            $value = ($g_prix->prix * $g_prix->remise) / 100;
                            $montant_client += $value;
                        else:
                            $montant_client += $g_prix->remise;
                        endif;

		            endif;

	            endif;

            endif;

        endforeach;

        $montant  = 0;

        if($montant_client):

            if($montant_famille):

	            if($montant_famille < $montant_client):
		            $montant = $montant_famille;
                else:
	                $montant = $montant_client;
	            endif;

            else:
	            $montant = $montant_client;
            endif;

        else:

	        if($montant_famille):
		        $montant = $montant_famille;
	        endif;

        endif;

//		var_dump($montant);
//		var_dump($montant_client);
//		var_dump($montant_famille);

        return $montant;

    }

}
