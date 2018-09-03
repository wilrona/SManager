<?php

namespace App\Http\Controllers;

use App\Http\Requests\PointDeVenteRequest;
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

	    foreach ($data->Caisses()->get() as $items):
		    $save = array();

		    $save['caisse_id']  = $items->id;
		    $save['caisse_name']  = $items->name;
		    $save['caisse_principal']  = $items->pivot->principal;

		    array_push($caisses, $save);
	    endforeach;

	    // Traitement de l'affichage des magasins du point de vente
	    $magasin = array();

	    foreach ($data->Magasins()->get() as $items):
		    $save = array();

		    $save['magasin_id']  = $items->id;
		    $save['magasin_name']  = $items->name;

		    array_push($magasin, $save);
	    endforeach;

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

	    $this->modelRepository->update($id, $data);

	    return redirect()->route('pos.show', $id)->withOk('Point de vente a été modifié');
    }

	public function addCaisse(Request $request, $id){

		$caisse_pos = array();
		$caisse_principal = array();

		$pos = $this->modelRepository->getById($id);

		foreach ($pos->Caisses()->get() as  $caisse):
            array_push($caisse_pos, $caisse->id);
            if($caisse->pivot->principal):
                array_push($caisse_principal, $caisse->id);
            endif;
        endforeach;

        $datas = $this->caisseRepository->getWhere()->get();

		return view('pointdeventes.addCaisse', compact('datas', 'id', 'caisse_principal', 'caisse_pos'));
	}

	public function checkCaisse(Request $request, $pos_id, $type = 'select'){
		$data = $request->all();

		$pos = $this->modelRepository->getById($pos_id);

		$caisse = $this->caisseRepository->getById($data['id']);

		$response = array(
			'success' => '',
			'success_principal' => '',
			'error' => '',
			'error_principal' => '',
			'action' => $data['action'],
			'type' => $type
		);

		if($type == 'select'):
			if($data['action'] == 'add'):
				$exist_other = $caisse->PointDeVente()->where([['id', '!=', $pos_id], ['principal', '=', 1]]);
				if($exist_other->count()):
					$response['error'] = 'La caisse est une caisse principale d\'un autre point de vente.';
				else:
					if(!$pos->Caisses()->where('principal', '=', 1)->count()):
						$response['success_principal'] = 'La caisse est défini comme caisse principal du point de vente.';
				    else:
					    $response['success_principal'] = 'La caisse est deja défini comme caisse principal du point de vente.';
					endif;
					$response['success'] = 'La caisse est ajouté au point de vente avec succès.';
				endif;
			else:
                $exist_user = $caisse->Users()->count();
			    if($exist_user || $caisse->etat == 1 || $caisse->montantEnCours != 0):
				    $response['error'] = 'La caisse ne peut être retirée au point de vente.';
			    else:
				    $response['success'] = 'La caisse est retirée au point de vente avec succès.';
                endif;
			endif;
        else:
	        if($data['action'] == 'add'):
		        $exist_other = $caisse->PointDeVente()->where([['id', '!=', $pos_id], ['principal', '=', 1]]);
		        if($exist_other->count()):
			        $response['error'] = 'La caisse est une caisse principale d\'un autre point de vente.';
		        else:
			        if(!$pos->Caisses()->where('principal', '=', 1)->count()):
				        $response['success'] = 'La caisse est défini comme caisse principal du point de vente.';
		            else:
			            $response['success'] = 'La caisse est déja défini comme caisse principal du point de vente.';
			        endif;
		        endif;
	        else:
                if($caisse->montantEnCours != 0):
	                $response['error'] = 'La caisse ne peut être retirée comme caisse principale de ce point de vente.';
                else:
	                $response['success'] = 'La caisse n\'est plus la caisse principale du vente avec succès.';
                endif;

	        endif;
        endif;

		return response()->json($response);

	}

	public function validCaisse(Request $request, $id){

        $data = $request->all();

        $pos = $this->modelRepository->getById($id);

        $pos->Caisses()->detach();

        foreach ($data['caisse'] as $caisse_id){
            $caisse = $this->caisseRepository->getById($caisse_id);
            if(in_array($caisse_id, $data['caisse_principal'])):
                $caisse->PointDeVente()->save($pos, ['principal' => 1]);
            else:
	            $caisse->PointDeVente()->save($pos);
            endif;
        }

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);
	}

	public function listCaisse($id){

		$produits = $this->modelRepository->getById($id);
		$produits = $produits->caisses()->get();
		?>
		<table class="table">
			<thead>
			<tr>
				<th class="col-xs-1">#</th>
				<th>Caisse</th>
				<th class="col-xs-2">Principale</th>
			</tr>
			</thead>
			<tbody>
			<?php if($produits):
				foreach($produits as $key => $value):
					?>
					<tr>
						<td><?= $key + 1 ?></td>
						<td><?= $value->name ?></td>
						<td><?php if($value->pivot->principal == 1): ?> OUI <?php else: ?> NON <?php endif; ?></td>
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

	public function addMagasin(Request $request, $id){

		$magasin_pos = array();

		$pos = $this->modelRepository->getById($id);

		foreach ($pos->Magasins()->get() as  $mag):
			array_push($magasin_pos, $mag->id);
		endforeach;

		$datas = $this->magasinRepository->getWhere()->where('transite', '=', 0)->get();

		return view('pointdeventes.addMagasin', compact('datas', 'id', 'magasin_pos'));
	}

	public function checkMagasin(Request $request, $pos_id){

	    $data = $request->all();

		$mag = $this->magasinRepository->getById($data['id']);

		$response = array(
			'success' => '',
			'error' => '',
			'action' => $data['action']
		);


        if($data['action'] == 'add'):
            $response['success'] = 'Le magasin est ajouté au point de vente avec succès.';
        else:
            if($mag->etat == 0):
                if($mag->DemandesTransfert()->where('statut_doc', '!=', 2)->count() ||  $mag->ApproTransfert()->where('statut_doc', '!=', 2)->count()):
                    $response['error'] = 'Le magasin a des transferts de stock non cloturé et des demandes de stock en cours.';
                else:
                    if($mag->users()->count()):
                        $response['error'] = 'Des utilisateurs de votre point de vente sont encore affecté à ce magasin.';
                    else:
                        $response['success'] = 'Le magasin est retiré au point de vente avec succès.';
                    endif;
                endif;
            else:
	            $response['error'] = 'Impossible d\'enregistrer les changement. Le magasin est ouvert par un utulisateur.';
            endif;

        endif;

		return response()->json($response);

	}

	public function validMagasin(Request $request, $id){

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

	public function listMagasin($id){

		$produits = $this->modelRepository->getById($id);
		$produits = $produits->Magasins()->get();
		?>
        <table class="table">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Magasin</th>
            </tr>
            </thead>
            <tbody>
			<?php if($produits):
				foreach($produits as $key => $value):
					?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $value->name ?></td>
                    </tr>
					<?php
				endforeach;
			else:
				?>
                <tr>
                    <td colspan="2">
                        <h4 class="text-center" style="margin: 0;">Aucun magasin enregistré</h4>
                    </td>
                </tr>
			<?php endif; ?>
            </tbody>
        </table>

		<?php
	}

}
