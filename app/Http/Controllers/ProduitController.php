<?php

namespace App\Http\Controllers;


use App\Http\Requests\BundleRequest;
use App\Http\Requests\GroupePrixRequest;
use App\Http\Requests\ProduitRequest;
use App\Library\CustomFunction;
use App\Repositories\ClientRepository;
use App\Repositories\FamilleRepository;
use App\Repositories\GroupePrixRepository;
use App\Repositories\MagasinRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\UniteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
{
    //
	protected $modelRepository;
	protected $familleRepository;
	protected $uniteRepository;
	protected $clientRepository;
	protected $groupeRepository;
	protected $parametreRepository;
	protected $pointdeventeRepository;
	protected $magasinRepository;

	protected $bundle;
	protected $type_prix;
	protected $custom;


	public function __construct(ProduitRepository $produitRepository, FamilleRepository $familleRepository,
        UniteRepository  $uniteRepository, ClientRepository $client_repository, GroupePrixRepository $groupe_prix_repository,
        ParametreRepository $parametre_repository, PointDeVenteRepository $point_de_vente_repository, MagasinRepository $magasin_repository
    )
	{
		$this->modelRepository = $produitRepository;
		$this->familleRepository = $familleRepository;
		$this->uniteRepository = $uniteRepository;
		$this->clientRepository = $client_repository;
        $this->groupeRepository = $groupe_prix_repository;
        $this->parametreRepository = $parametre_repository;
        $this->pointdeventeRepository = $point_de_vente_repository;
        $this->magasinRepository = $magasin_repository;

		$this->bundle = array(
			'0' => 'Produit unique',
			'1' => 'Composé de produit (Bundle, Offres)'
		);

		$this->type_prix = array(
			'0' => 'Montant fixe',
			'1' => 'Pourcentage'
		);

		$this->custom = new CustomFunction();
	}


	public function index($single = null){

		$datas = $this->modelRepository->getWhere()->get();

		return view('produits.index', compact('datas', 'links', 'single'));
	}

	public function create(){


		$select_bundle = $this->bundle;


		$famillesData = $this->familleRepository->getWhere()->where([['type', '=', '0'], ['active', '=', 1]])->get();

		$familles = array();

		foreach ($famillesData as $famille):
			$familles[$famille->id] = $famille->name;
		endforeach;


		$uniteProuit = $this->uniteRepository->getWhere()->get();

		$unites = array();
		foreach ( $uniteProuit as $item ) {
				$unites[$item->id] = $item->name;
		}

		$count = $this->modelRepository->getWhere()->count();
		$coderef = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'produits'],
				['type_config', '=', 'coderef']
			]
		)->first();
		$incref = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'produits'],
				['type_config', '=', 'incref']
			]
		)->first();
		$count += $incref ? intval($incref->value) : 1;
		$reference = $this->custom->setReference($coderef, $count, 4);


		return view('produits.create', compact( 'select_bundle', 'familles', 'unites', 'reference'));
	}

	public function show(Request $request, $id, $single = null){

		$request->session()->forget('produit_id');
		$request->session()->forget('produit');

		$data = $this->modelRepository->getById($id);

		$select_bundle = $this->bundle;


		$famillesData = $this->familleRepository->getWhere()->where([['type', '=', '0'], ['active', '=', 1]])->get();

		$familles = array();

		foreach ($famillesData as $famille):
			$familles[$famille->id] = $famille->name;
		endforeach;

		$uniteProuit = $this->uniteRepository->getWhere()->get();

		$unites = array();
		foreach ( $uniteProuit as $item ) {
			$unites[$item->id] = $item->name;
		}

		if($single):

		$currentUser = Auth::user();
		$pos_user = $this->pointdeventeRepository->getWhere()->where('id', '=', $currentUser->pos_id)->first();

		// Controler si l'utilisateur est responsable de point de vente

		$mag = $currentUser->Magasins()->get();

        else:
		// Tous les numéros de series des magasins de façon global

        $mag = $this->magasinRepository->getWhere()->where('transite', '=', 0)->get();

		endif;

		return view('produits.show',  compact('data', 'select_bundle', 'familles', 'unites', 'pos_user', 'mag', 'single'));
	}

	public function store(ProduitRequest $request){

		$data = $request->all();

		if($data['bundle'] == 1):
			$data['prix'] = 0;
		endif;

		$data = $this->modelRepository->store($data);

        $redirect = redirect()->route('produit.edit', $data->id)->withOk("Le produit " . $data->name . " a été créé.")->withWarning("Ajoutez les groupes de prix associés");
		if($data['bundle'] == 1):
			$redirect = $redirect->withWarning("Ajouter les produits qui vont constituer le bundle");
		endif;

		return $redirect;
	}

	public function edit(Request $request, $id)
	{

		$data = $this->modelRepository->getById($id);


		$select_bundle = $this->bundle;


		$famillesData = $this->familleRepository->getWhere()->where([['type', '=', '0'], ['active', '=', 1]])->get();

		$familles = array();

		foreach ($famillesData as $famille):
			$familles[$famille->id] = $famille->name;
		endforeach;

		$uniteProuit = $this->uniteRepository->getWhere()->get();

		$unites = array();
		foreach ( $uniteProuit as $item ) {
			$unites[$item->id] = $item->name;
		}
		$produits = array();

		// Recuperer les informations du bundle pour mettre en session afin de traiter
		if($data->bundle == 1):

            $produit_ids = array();

            if($request->session()->has('produit')):
                $request->session()->forget('produit');
            endif;

			if($request->session()->has('produit_id')):
				$request->session()->forget('produit_id');
			endif;

            foreach ($data->ProduitBundle()->get() as $items):
                $save = array();

	            $save['produit_id']  = $items->id;
	            $save['produit_name']  = $items->name;
	            $save['quantite'] = $items->pivot->quantite;
	            $save['prix'] = $items->pivot->prix;

	            array_push($produits, $save);
	            array_push($produit_ids, $items->id);
            endforeach;

			$request->session()->put('produit', $produits);
			$request->session()->put('produit_id', $produit_ids);
        endif;

        $groupePrix = array();

        $famille_id = array();
        $client_id = array();

		if($request->session()->has('groupe')):
			$request->session()->forget('groupe');
		endif;

		if($request->session()->has('client_id')):
			$request->session()->forget('client_id');
		endif;

		if($request->session()->has('famille_id')):
			$request->session()->forget('famille_id');
		endif;


		foreach ($data->GroupePrix()->get() as $items):
			$save = array();


			if($items->type_client == 0):
				$save['produit_id']  = $items->client_id;
			    $save['produit_name']  = $items->Client()->first()->display_name;
				array_push($client_id, $items->client_id);
			else:
				$save['produit_id']  = $items->famille_id;
				$save['produit_name']  = $items->Famille()->first()->name;
				array_push($famille_id, $items->famille_id);
            endif;

			$save['type_client'] = $items->type_client;
			$save['quantite'] = $items->quantite_min;
			$save['prix'] = $items->prix;
			$save['type_remise'] = $items->type_remise;
			$save['remise'] = $items->remise;
			$save['date_debut'] = $items->date_debut ? date('d-m-Y', $items->date_debut) : '';
			$save['date_fin'] = $items->date_fin ? date('d-m-Y', $items->date_fin) : '';

            array_push($groupePrix, $save);

		endforeach;

		$request->session()->put('groupe', $groupePrix);
		$request->session()->put('client_id', $client_id);
		$request->session()->put('famille_id', $famille_id);



		return view('produits.edit',   compact('data', 'select_bundle', 'familles', 'unites', 'produits', 'groupePrix'));
	}

	public function update(ProduitRequest $request, $id)
	{

		$data = $request->all();

		$current = $this->modelRepository->getById($id);

		if($data['bundle'] == 1):
			$data['prix'] = 0;


            // Enregistrement des produits du bundle

            $produit = $request->session()->get('produit');

            $current->ProduitBundle()->detach();

            if($produit):
                foreach ($produit as $prod):
                    $data['prix'] += $prod['prix'];
                    $prod_cu = $this->modelRepository->getById($prod['produit_id']);
                    $current->ProduitBundle()->save($prod_cu, ['prix' => $prod['prix'], 'quantite' => $prod['quantite']]);

                endforeach;
            endif;

			$request->session()->forget('produit_id');
			$request->session()->forget('produit');

		endif;

		if($request->session()->has('groupe') && $request->session()->get('groupe')):
            $groupes = $request->session()->get('groupe');

            if($groupes):


                foreach ($groupes as $groupe):

                    if($groupe['type_client'] == 0):
                        $existe_cli = $current->GroupePrix()->where('client_id', '=', $groupe['produit_id'])->first();
                        if(!$existe_cli):
                            $saved_item = array();
                            $saved_item['client_id'] = $groupe['produit_id'];
                            $saved_item['produit_id'] = $id;
                            $saved_item['type_client'] = $groupe['type_client'];
                            $saved_item['prix'] = $groupe['prix'];
                            $saved_item['type_remise'] = $groupe['type_remise'];
                            $saved_item['remise'] = $groupe['remise'];
                            $saved_item['quantite_min'] = $groupe['quantite'];
	                        $saved_item['date_debut'] = $groupe['date_debut'] ? date('Y-m-d', strtotime($groupe['date_debut'])) : null;
	                        $saved_item['date_fin'] = $groupe['date_fin'] ? date('Y-m-d', strtotime($groupe['date_fin'])) : null;

                            $this->groupeRepository->store($saved_item);
                        endif;
                    else:
	                    $existe_fam = $current->GroupePrix()->where('famille_id', '=', $groupe['produit_id'])->first();
	                    if(!$existe_fam):
		                    $saved_item = array();
		                    $saved_item['famille_id'] = $groupe['produit_id'];
		                    $saved_item['produit_id'] = $id;
		                    $saved_item['type_client'] = $groupe['type_client'];
		                    $saved_item['prix'] = intval($groupe['prix']);
		                    $saved_item['type_remise'] = $groupe['type_remise'];
		                    $saved_item['remise'] = $groupe['remise'];
		                    $saved_item['quantite_min'] = $groupe['quantite'];
		                    $saved_item['date_debut'] = $groupe['date_debut'] ? date('Y-m-d', strtotime($groupe['date_debut'])) : null;
		                    $saved_item['date_fin'] = $groupe['date_fin'] ? date('Y-m-d', strtotime($groupe['date_fin'])) : null;

		                    $this->groupeRepository->store($saved_item);
	                    endif;
                    endif;
                endforeach;

                foreach ($current->GroupePrix()->get() as $del):
                    if($del->type_client == 0 && !in_array($del->client_id, $request->session()->get('client_id'))):
                        $del->delete();
                    endif;

	                if($del->type_client == 1 && !in_array($del->famille_id, $request->session()->get('famille_id'))):
		                $del->delete();
	                endif;

                endforeach;

            endif;

			$request->session()->forget('client_id');
			$request->session()->forget('famille_id');
			$request->session()->forget('groupe');
        endif;

		$this->modelRepository->update($id, $data);

		return redirect()->route('produit.show', ['id' => $id])->withOk("Le produit " . $request->input('name') . " a été modifié.");
	}

	public function active($id){

		$data = $this->modelRepository->getById($id);
		$data->active = !$data->active;
		$data->save();

		return redirect()->route('produit.show', ['id' => $id])->withOk('Le produit a été modifié');
	}

	public function addProduit(Request $request, $id){

		$allProduits = $this->modelRepository->getWhere()->where([['bundle', '=', '0']])->get();

		$produits = array();
		foreach ( $allProduits as $item ) {
		    if($request->session()->has('produit_id')):
                if(!in_array($item->id, $request->session()->get('produit_id'))):
			        $produits[$item->id] = $item->name;
		        endif;
            else:
	            $produits[$item->id] = $item->name;
		    endif;
		}

		return view('produits.addProduit', compact('produits', 'id'));
	}

	public function validProduit(BundleRequest $request, $id){

		$produits = array();
		$produit_id = array();

		if($request->session()->has('produit')):
			$produits = $request->session()->get('produit');
		endif;

		if($request->session()->has('produit_id')):
			$produit_id = $request->session()->get('produit_id');
		endif;

		$produit = array();

		$current_produit = $this->modelRepository->getById($request['produit_id']);

		$produit['produit_id']  = $request['produit_id'];
		$produit['produit_name']  = $current_produit->name;
		$produit['quantite'] = $request['quantite'];
		$produit['prix'] = $request['prix'];


		array_push($produits, $produit);

		array_push($produit_id, $request['produit_id']);

		$request->session()->put('produit', $produits);
		$request->session()->put('produit_id', $produit_id);

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);
	}

	public function listproduit(){

		$produits = session('produit');
		?>
		<table class="table table-stylish">
			<thead>
				<tr>
					<th class="col-xs-1">#</th>
					<th>Produit</th>
					<th>Quantité</th>
					<th>Prix</th>
					<th class="col-xs-1"></th>
				</tr>
			</thead>
			<tbody>
			<?php if($produits):
				foreach($produits as $key => $value):
					?>
					<tr>
                        <td><?= $key + 1 ?></td>
						<td><?= $value['produit_name'] ?></td>
						<td><?= $value['quantite'] ?></td>
						<td><?= $value['prix'] ?></td>
						<td><a class="delete" onclick="remove(<?= $key ?>)"><i class="fa fa-trash"></i></a></td>
					</tr>
					<?php
				endforeach;
			else:
				?>
				<tr>
					<td colspan="5">
                        <h4 class="text-center" style="margin: 0;">Aucun produit enregistré</h4>
					</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<?php
	}

	public function removeProduit($key = null, Request $request){


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

	public function addGroupePrix(Request $request, $id, $type){

	    if($type == 0): // si c'est un formulaire de type Client
            $allClients = $this->clientRepository->getWhere()->get();

            $client = array();

            foreach ( $allClients as $item ) {

	            if($request->session()->has('client_id')):
//		            if(!in_array($item->id, $request->session()->get('client_id'))):
			            $client[$item->id] = $item->display_name;
//		            endif;
	            else:
		            $client[$item->id] = $item->display_name;
	            endif;
            }
        else:
	        $allClients = $this->familleRepository->getWhere()->where('type', '=', '1')->get();

	        $client = array();
	        foreach ( $allClients as $item ) {
		        if($request->session()->has('famille_id')):
//			        if(!in_array($item->id, $request->session()->get('famille_id'))):
				        $client[$item->id] = $item->name;
//			        endif;
		        else:
			        $client[$item->id] = $item->name;
		        endif;
	        }
        endif;

	        $type_prix = $this->type_prix;

		return view('produits.addGroupePrix', compact('client', 'id', 'type', 'type_prix'));
	}

	public function validGroupePrix(GroupePrixRequest $request, $id){

		$produits = array();
		$produit_id = array();
		$famille_id = array();

		if($request->session()->has('groupe')):
			$produits = $request->session()->get('groupe');
		endif;

		if($request->session()->has('client_id')):
			$produit_id = $request->session()->get('client_id');
		endif;

		if($request->session()->has('famille_id')):
			$famille_id = $request->session()->get('famille_id');
		endif;

		$produit = array();

		if($request['type_client'] == 0):
		    $current_produit = $this->clientRepository->getById($request['client_id']);

            $produit['produit_id']  = $request['client_id'];
            $produit['produit_name']  = $current_produit->display_name;

			array_push($produit_id, $request['client_id']);
        else:
	        $current_produit = $this->familleRepository->getById($request['famille_id']);

	        $produit['produit_id']  = $request['famille_id'];
	        $produit['produit_name']  = $current_produit->name;

	        array_push($famille_id, $request['famille_id']);
        endif;

		$produit['type_client']  = $request['type_client'];
        $produit['quantite'] = $request['quantite_min'];
        $produit['prix'] = $request['prix'];
        $produit['remise'] = $request['remise'];
        $produit['type_remise'] = $request['type_remise'];
        $produit['date_debut'] = $request['date_debut'];
        $produit['date_fin'] = $request['date_fin'];


		array_push($produits, $produit);


		$request->session()->put('groupe', $produits);
		$request->session()->put('client_id', $produit_id);
		$request->session()->put('famille_id', $famille_id);

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);
	}

	public function listGroupePrix(){

		$groupePrix = session('groupe');
		?>
        <table class="table table-stylish">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Client</th>
                <th>Prix</th>
                <th>Remise</th>
                <th>Qté min</th>
                <th>Programmé</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>
			<?php

			?>

			<?php if($groupePrix):


				foreach($groupePrix as $key => $value):
					?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $value['produit_name'] ?></td>
                        <td><?= $value['prix'] ?></td>
                        <td><?= $value['remise'] ?><?php if($value['type_remise'] == 1): ?> % <?php endif; ?></td>
                        <td><?= $value['quantite'] ?></td>
                        <td>
							<?php if(empty($value['date_debut']) && empty($value['date_fin'])):  ?> Non <?php endif; ?>
							<?php if($value['date_debut']):  ?>
                                <div><strong>Debut </strong>: <?= date('d-m-Y', strtotime($value['date_debut'])); ?></div>
							<?php endif; ?>
							<?php if($value['date_fin']):  ?>
                                <div><strong>Fin </strong>: <?= date('d-m-Y', strtotime($value['date_fin'])); ?></div>
							<?php endif; ?>
                        </td>
                        <td><a class="delete" onclick="remove_groupe(<?= $key ?>)"><i class="fa fa-trash"></i></a></td>
                    </tr>
					<?php
				endforeach;
			else:
				?>
                <tr>
                    <td colspan="7">
                        <h4 class="text-center" style="margin: 0;">Aucun groupe de prix enregistré</h4>
                    </td>
                </tr>
			<?php endif; ?>

            </tbody>
        </table>

		<?php
	}

	public function removeGroupePrix($key = null, Request $request){


		$produits = array();
		$produit_id = array();
		$famille_id = array();

		if($request->session()->has('groupe')):
			$produits = $request->session()->get('groupe');
		endif;

		if($request->session()->has('client_id')):
			$produit_id = $request->session()->get('client_id');
		endif;

		if($request->session()->has('famille_id')):
			$famille_id = $request->session()->get('famille_id');
		endif;

		$current_prod = $produits[$key];

		unset($produits[$key]);

		if($current_prod['type_client'] == 0):
		    unset($produit_id[$key]);
		else:
		    unset($famille_id[$key]);
		endif;

		if(!$produits){
			$request->session()->forget('groupe');
		}else{
			$request->session()->put('groupe', $produits);
		}

		if(!$produit_id){
			$request->session()->forget('client_id');
		}else{
			$request->session()->put('client_id', $produit_id);
		}

		if(!$famille_id){
			$request->session()->forget('famille_id');
		}else{
			$request->session()->put('famille_id', $famille_id);
		}

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);

	}

	public function serieMagasin($magasin_id, $produit_id){

		$data = $this->magasinRepository->getById($magasin_id);

		return view('produits.serie', compact('data', 'produit_id'));
    }
}
