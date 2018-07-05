<?php

namespace App\Http\Controllers;

use App\Http\Requests\PointDeVenteRequest;
use App\Http\Requests\PosCaisseRequest;
use App\Http\Requests\PosMagasinRequest;
use App\Repositories\CaisseRepository;
use App\Repositories\MagasinRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
use App\Library\CustomFunction;
use Illuminate\Http\Request;

class PointDeVenteController extends Controller
{
	protected $modelRepository;
	protected $magasinRepository;
	protected $caisseRepository;
	protected $parametreRepository;

	protected $type;
	protected $custom;

	public function __construct(PointDeVenteRepository $modelRepository, MagasinRepository $magasin_repository, CaisseRepository $caisse_repository,
    ParametreRepository $parametre_repository) {
		$this->modelRepository = $modelRepository;
		$this->magasinRepository = $magasin_repository;
		$this->caisseRepository = $caisse_repository;
		$this->parametreRepository = $parametre_repository;

		$this->custom = new CustomFunction();

		$this->type = array(
			'1' => 'Point de vente fixe',
//		    '2' => 'Point de vente mobile',
//		    '3' => 'Point de vente externe'
		);
	}

	//
    public function index()
    {
       $datas = $this->modelRepository->getWhere()->get();

       return view('pointdeventes.index', compact('datas'));
    }  
    
    public function create(){


	    // Initialisation de la reference
	    $count = $this->modelRepository->getWhere()->count();
	    $coderef = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'point_de_vente'],
			    ['type_config', '=', 'coderef']
		    ]
	    )->first();
	    $incref = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'point_de_vente'],
			    ['type_config', '=', 'incref']
		    ]
	    )->first();
	    $count += $incref ? intval($incref->value) : 0;
	    $reference = $this->custom->setReference($coderef, $count, 4);

	    $type = $this->type;

	    return view('pointdeventes.create', compact( 'type', 'reference'));
    }

    public function show(Request $request, $id)
    {

	    $request->session()->forget('caisse_id');
	    $request->session()->forget('caisse');

		$data = $this->modelRepository->getById($id);

	    $type = $this->type;

	    return view('pointdeventes.show', compact('type', 'data'));
    } 
    
    public function edit(Request $request, $id)
    {

    	$data = $this->modelRepository->getById($id);

	    $type = $this->type;

	    $caisses = array();

	    $caisses_ids = array();

	    if($request->session()->has('caisse')):
		    $request->session()->forget('caisse');
	    endif;

	    if($request->session()->has('caisse_id')):
		    $request->session()->forget('caisse_id');
	    endif;

	    foreach ($data->Caisses()->get() as $items):
		    $save = array();

		    $save['caisse_id']  = $items->id;
		    $save['caisse_name']  = $items->name;

		    array_push($caisses, $save);
		    array_push($caisses_ids, $items->id);
	    endforeach;

	    $request->session()->put('caisse', $caisses);
	    $request->session()->put('caisse_id', $caisses_ids);

	    // Traitement de l'affichage des magasins du point de vente
	    $magasin = array();

	    $magasin_ids = array();

	    if($request->session()->has('magasin')):
		    $request->session()->forget('magasin');
	    endif;

	    if($request->session()->has('magasin_id')):
		    $request->session()->forget('magasin_id');
	    endif;

	    foreach ($data->Magasins()->get() as $items):
		    $save = array();

		    $save['magasin_id']  = $items->id;
		    $save['magasin_name']  = $items->name;

		    array_push($magasin, $save);
		    array_push($magasin_ids, $items->id);
	    endforeach;

	    $request->session()->put('magasin', $magasin);
	    $request->session()->put('magasin_id', $magasin_ids);

	    return view('pointdeventes.edit', compact('type', 'data', 'caisses', 'magasin'));
    } 
    


    public function store(PointDeVenteRequest $request)
    {

        $data=$request->all();

	    $saved = $this->modelRepository->store($data);

        return redirect()->route('pos.edit', $saved->id)->withOk('Le point de vente a été enregistré')->withWarning("Ajoutez les caisses et les magasins associés");
    }

    
    public function update(PointDeVenteRequest $request, $id){

	    $data = $request->all();

	    $caisse = $request->session()->get('caisse');

	    $current = $this->modelRepository->getById($id);

	    foreach ($current->Caisses()->get() as $cai):
		    $cai->pos_id = null;
	        $cai->save();
	    endforeach;

	    if($caisse):
		    foreach ($caisse as $prod):
			    $caisse_cu = $this->caisseRepository->getById($prod['caisse_id']);
		        $caisse_cu->pos_id = $id;
		        $caisse_cu->save();
		    endforeach;
	    endif;

	    $request->session()->forget('caisse_id');
	    $request->session()->forget('caisse');

	    $this->modelRepository->update($id, $data);

	    return redirect()->route('pos.show', $id)->withOk('Point de vente a été modifié');
    }

	public function addCaisse(Request $request, $id){

		$allProduits = $this->caisseRepository->getWhere()->get();

		$produits = array();
		foreach ( $allProduits as $item ) {
			if($request->session()->has('caisse_id')):
				if(!in_array($item->id, $request->session()->get('caisse_id'))):
					$produits[$item->id] = $item->name;
				endif;
			else:
				$produits[$item->id] = $item->name;
			endif;
		}

		return view('pointdeventes.addCaisse', compact('produits', 'id'));
	}

	public function validCaisse(PosCaisseRequest $request, $id){

		$produits = array();
		$produit_id = array();

		if($request->session()->has('caisse')):
			$produits = $request->session()->get('caisse');
		endif;

		if($request->session()->has('caisse_id')):
			$produit_id = $request->session()->get('caisse_id');
		endif;

		$produit = array();

		$current_produit = $this->caisseRepository->getById($request['caisse_id']);

		$produit['caisse_id']  = $request['caisse_id'];
		$produit['caisse_name']  = $current_produit->name;


		array_push($produits, $produit);

		array_push($produit_id, $request['caisse_id']);

		$request->session()->put('caisse', $produits);
		$request->session()->put('caisse_id', $produit_id);

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);
	}

	public function listCaisse(){

		$produits = session('caisse');
		?>
		<table class="table table-stylish">
			<thead>
			<tr>
				<th class="col-xs-1">#</th>
				<th>Caisse</th>
				<th class="col-xs-1"></th>
			</tr>
			</thead>
			<tbody>
			<?php if($produits):
				foreach($produits as $key => $value):
					?>
					<tr>
						<td><?= $key + 1 ?></td>
						<td><?= $value['caisse_name'] ?></td>
						<td><a class="delete" onclick="remove(<?= $key ?>)"><i class="fa fa-trash"></i></a></td>
					</tr>
					<?php
				endforeach;
			else:
				?>
				<tr>
					<td colspan="3">
						<h4 class="text-center" style="margin: 0;">Aucune caisse enregistrée</h4>
					</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<?php
	}

	public function removeCaisse($key = null, Request $request){


		$produits = array();
		$produit_id = array();

		if($request->session()->has('caisse')):
			$produits = $request->session()->get('caisse');
		endif;

		if($request->session()->has('caisse_id')):
			$produit_id = $request->session()->get('caisse_id');
		endif;


		unset($produits[$key]);
		unset($produit_id[$key]);

		if(!$produits){
			$request->session()->forget('caisse');
		}else{
			$request->session()->put('caisse', $produits);
		}

		if(!$produit_id){
			$request->session()->forget('caisse_id');
		}else{
			$request->session()->put('caisse_id', $produit_id);
		}

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);

	}

	public function addMagasin(Request $request, $id){

		$allProduits = $this->magasinRepository->getWhere()->get();

		$produits = array();
		foreach ( $allProduits as $item ) {
		    if($item->transite != 1):
                if($request->session()->has('magasin_id')):
                    if(!in_array($item->id, $request->session()->get('magasin_id'))):
                        $produits[$item->id] = $item->name;
                    endif;
                else:
                    $produits[$item->id] = $item->name;
                endif;
			endif;
		}

		return view('pointdeventes.addMagasin', compact('produits', 'id'));
	}

	public function validMagasin(PosMagasinRequest $request, $id){

		$produits = array();
		$produit_id = array();

		if($request->session()->has('magasin')):
			$produits = $request->session()->get('magasin');
		endif;

		if($request->session()->has('magasin_id')):
			$produit_id = $request->session()->get('magasin_id');
		endif;

		$produit = array();

		$current_produit = $this->magasinRepository->getById($request['magasin_id']);

		$produit['magasin_id']  = $request['magasin_id'];
		$produit['magasin_name']  = $current_produit->name;


		array_push($produits, $produit);

		array_push($produit_id, $request['magasin_id']);

		$request->session()->put('magasin', $produits);
		$request->session()->put('magasin_id', $produit_id);

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);
	}

	public function listMagasin(){

		$produits = session('magasin');
		?>
        <table class="table table-stylish">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Magasin</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>
			<?php if($produits):
				foreach($produits as $key => $value):
					?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $value['magasin_name'] ?></td>
                        <td><a class="delete" onclick="remove_magasin(<?= $key ?>)"><i class="fa fa-trash"></i></a></td>
                    </tr>
					<?php
				endforeach;
			else:
				?>
                <tr>
                    <td colspan="3">
                        <h4 class="text-center" style="margin: 0;">Aucun magasin enregistré</h4>
                    </td>
                </tr>
			<?php endif; ?>
            </tbody>
        </table>

		<?php
	}

	public function removeMagasin($key = null, Request $request){


		$produits = array();
		$produit_id = array();

		if($request->session()->has('magasin')):
			$produits = $request->session()->get('magasin');
		endif;

		if($request->session()->has('magasin_id')):
			$produit_id = $request->session()->get('magasin_id');
		endif;


		unset($produits[$key]);
		unset($produit_id[$key]);

		if(!$produits){
			$request->session()->forget('magasin');
		}else{
			$request->session()->put('magasin', $produits);
		}

		if(!$produit_id){
			$request->session()->forget('magasin_id');
		}else{
			$request->session()->put('magasin_id', $produit_id);
		}

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);

	}

}
