<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProvisionAddProduitRequest;
use App\Http\Requests\ProvisionRequest;
use App\PointDeVente;
use App\Precommande;
use App\Repositories\PointDeVenteRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\ProvisionsRepository;
use App\Repositories\TransactionsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProvisionsController extends Controller
{
    //

	protected $modelRepository;
	protected $typeproduitRepository;
	protected $pointDeVenteRepository;
	protected $modelPOS;
	protected $modelPrecmd;
	protected $transactionsRepository;

	protected $nbrPerPage = 4;


	public function __construct(ProvisionsRepository $modelRepository, ProduitRepository $typeproduitRepository,
        PointDeVente $modelPOS, Precommande $modelPrecmd, TransactionsRepository $transactionsRepository,
        PointDeVenteRepository $pointDeVenteRepository)
	{
		$this->modelRepository = $modelRepository;
		$this->typeproduitRepository = $typeproduitRepository;
		$this->modelPOS = $modelPOS;
		$this->modelPrecmd = $modelPrecmd;
		$this->transactionsRepository = $transactionsRepository;
		$this->pointDeVenteRepository = $pointDeVenteRepository;
	}


	public function index(){

	    $current_user = Auth::user();

	    if($current_user->id_point_de_vente_encours):

            $datas = $this->modelRepository->getAllWhere('id_point_de_vente_vendeur', '=', $current_user->id_point_de_vente_encours);

        else:

		    $datas = $this->modelRepository->getAllWhere();

	    endif;

	    $page = 'provisions';

		return view('provisions.index', compact('datas', 'page'));
	}


	public function show($id, $page){

		$data = $this->modelRepository->getById($id);

		return view('provisions.show',  compact('data','page'));
	}


	public function create(Request $request){

		$user = Auth::user();

		$user_pos = $this->pointDeVenteRepository->getById($user->id_point_de_vente_encours);

		$select = array();

		foreach ($user_pos->enfants()->get() as $type):
			$select[$type['id']] = $type['libelle'];
		endforeach;

		$produits = session('produit');

		return view('provisions.create', compact('user_pos', 'select', 'produits'));
	}


	public function add(Request $request){


		$typeproduit = $this->typeproduitRepository->getAllWhere('id', 'NOT IN', $request->session()->get('produit_id'));

		$select = array();

		foreach ($typeproduit as $type):
			$select[$type['id']] = $type['libelle'];
		endforeach;

		return view('provisions.add', compact('select'));
	}


	public function listproduit(){

		$produits = session('produit');
		?>
		<table class="table">
			<thead>
			<tr>
				<th>Produit</th>
				<th>Quantité</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php if($produits):


				foreach($produits as $key => $value):
			?>
			<tr>
				<td><?= $value['produit'] ?></td>
				<td><?= $value['qte'] ?></td>
				<td><a class="delete" onclick="remove(<?= $key ?>)"><i class="fa fa-trash"></i></a></td>
			</tr>
			<?php
				endforeach;
				?>
                <input type="hidden" name="produit" value="1">
                <?php
			else:
			?>
			<tr>
				<td colspan="3">
					<h3 class="text-center">Aucun produit enregistré</h3>
				</td>
			</tr>
                <input type="hidden" name="produit" value="">
			<?php endif; ?>
			</tbody>
		</table>

		<?php
	}


	public function addStore(ProvisionAddProduitRequest $request){


		$produits = array();
		$produit_id = array();

		if($request->session()->has('produit')):
			$produits = $request->session()->get('produit');
		endif;

		if($request->session()->has('produit_id')):
			$produit_id = $request->session()->get('produit_id');
		endif;

		$produit = array();

		$current_prod = $this->typeproduitRepository->getById($request['produit_id']);

		$produit['produit_id']  = $request['produit_id'];
		$produit['produit']  = $current_prod->libelle;
		$produit['qte'] = $request['qte'];

		if($current_prod->promo):
		    $produit['montant'] = $current_prod->prix_promo;
		else:
			$produit['montant'] = $current_prod->prix;
		endif;

		array_push($produits, $produit);

		array_push($produit_id, $request['produit_id']);

		$request->session()->put('produit', $produits);
		$request->session()->put('produit_id', $produit_id);

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);

	}

	public function removeStore($key = null, Request $request){


		$produits = array();
		$produit_id = array();

		if($request->session()->has('produit')):
			$produits = $request->session()->get('produit');
		endif;

		if($request->session()->has('produit_id')):
			$produit_id = $request->session()->get('produit_id');
		endif;


		unset($produits[$key]);
		unset($produit_id[$key]);

		if(!$produits){
			$request->session()->forget('produit');
		}else{
			$request->session()->put('produit', $produits);
		}

		if(!$produit_id){
			$request->session()->forget('produit_id');
		}else{
			$request->session()->put('produit_id', $produit_id);
		}

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);

	}



	public function store(ProvisionRequest $request){

	    $qte_tranfert = 0;
	    $montant_tranfert = 0;

	    $produit = $request->session()->get('produit');

	    foreach ($produit as $prod):
            $qte_tranfert += $prod['qte'];

	        $inter = $prod['qte'] * $prod['montant'];
	        $montant_tranfert += $inter;

        endforeach;

		$request->merge(['qte' => $qte_tranfert]);
		$request->merge(['montant' => $montant_tranfert]);
		$request->merge(['precommande_id' => null]);
		$request->merge(['vendeur' => Auth::user()->id]);

		$transfert = $this->modelRepository->store($request->all());

		foreach ($produit as $prods):

            // liste des produits en stock dans le point de vente qui ne sont pas encore transferé à un autre POS

			$POS_seller = $this->modelPOS->findOrFail($request['pos_vendeur'])
			                             ->stock()
			                             ->where('typeproduit_id', '=', $prods['produit_id'])
                                         ->where('etat', '=', 0)
			                             ->orderBy('created_at', 'asc')
			                             ->limit($prods['qte'])
			                             ->get();

			foreach ($POS_seller as $prod){
			    // Pour chaque produit, j'affecte au transfert que je viens de creer
				$this->modelRepository->getById($transfert->id)->produits()->save($prod, ['prix' => $prods['montant']]);
				// Recherche de la relation du produit avec le stock du POS vendeur pour modification de l'etat du produit en stock
				$changeState = $this->modelPOS->findOrFail($request['pos_vendeur'])->stock()->where('id', $prod->id)->get()->first();
				$changeState->pivot->etat = 1;
				$changeState->pivot->save();
			}

		endforeach;

        if($montant_tranfert):

            $inputTran = array();
            $inputTran['transfert_id'] = $transfert->id;
            $inputTran['user_id'] = Auth::user()->id;
            $inputTran['montant'] = $montant_tranfert;
            $inputTran['type'] = 0;

            $this->transactionsRepository->store($inputTran);

        endif;

		$request->session()->forget('produit_id');
		$request->session()->forget('produit');

		return redirect('provisions')->withOk("le transfert d'approvisionnement a été créé.");
	}

	public function cancel($id){

	    $current_provision = $this->modelRepository->getById($id);

	    foreach ($current_provision->produits()->get() as $prod){
		    $changeState = $this->modelPOS->findOrFail($current_provision->id_point_de_vente_vendeur)->stock()->where('id', $prod->id)->get()->first();
		    $changeState->pivot->etat = 0;
		    $changeState->pivot->save();
        }

        if($current_provision->precommande_id){
	        $precommande = $this->modelPrecmd->findOrFail($current_provision->precommande_id);
	        $precommande->statut = 0;
	        $precommande->save();
        }

        $this->modelRepository->destroy($id);

		return redirect('provisions')->withOk("le transfert d'approvisionnement a été annulé avec success.");

    }

    public function expedition(){

    }


}
