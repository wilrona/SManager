<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandeReceiveRequest;
use App\Http\Requests\DemandeSendRequest;
use App\Http\Requests\TransfertProduitRequest;
use App\Library\CustomFunction;
use App\Repositories\LigneTransfertRepository;
use App\Repositories\MagasinRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SerieRepository;
use App\Repositories\TransfertRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransfertController extends Controller
{
	protected $modelRepository;
	protected $posRepository;
	protected $magasinRepository;
	protected $parametreRepository;
	protected $produitRepository;
	protected $ligneTransfertRepository;
	protected $serieRepository;

	protected $custom;

	public function __construct(TransfertRepository $transfert_repository, PointDeVenteRepository $point_de_vente_repository,
		MagasinRepository $magasin_repository, ParametreRepository $parametre_repository,
		ProduitRepository $produit_repository, LigneTransfertRepository $ligne_transfert_repository,
        SerieRepository $serie_repository
	) {

		$this->modelRepository = $transfert_repository;
		$this->posRepository = $point_de_vente_repository;
		$this->magasinRepository = $magasin_repository;
		$this->parametreRepository = $parametre_repository;
		$this->produitRepository = $produit_repository;
		$this->ligneTransfertRepository = $ligne_transfert_repository;
		$this->serieRepository = $serie_repository;

		$this->custom = new CustomFunction();

	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSend()
    {
        //
	    $currentUser= Auth::user();

	    $datas = $this->modelRepository->getWhere()->where('pos_dmd_id', '=', $currentUser->pos_id)->get();

	    return view('transfert.dmdsend.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSend()
    {
        //

	    $currentUser= Auth::user();

	    $pdv = $this->posRepository->getWhere()->where('id', '!=', $currentUser->pos_id)->get();

	    $pos = array();
	    foreach ($pdv as $item):
		    $pos[$item->id] = $item->name;
	    endforeach;

	    $my_mag = array();

	    $currentMag = $this->posRepository->getById($currentUser->pos_id);
	    foreach ($currentMag->Magasins()->get() as $item):
		    $my_mag[$item->id] = $item->name;
	    endforeach;

	    // Initialisation de la reference

	    $count = $this->modelRepository->getWhere()->count();
	    $coderef = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'demandes'],
			    ['type_config', '=', 'coderef']
		    ]
	    )->first();
	    $incref = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'demandes'],
			    ['type_config', '=', 'incref']
		    ]
	    )->first();
	    $count += $incref ? intval($incref->value) : 0;
	    $reference = $this->custom->setReference($coderef, $count, 4);

	    return view('transfert.dmdsend.create', compact('pos', 'my_mag', 'reference', 'currentMag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSend(DemandeSendRequest $request)
    {
        //
	    $data = $request->all();

	    $data = $this->modelRepository->store($data);

	    $redirect = redirect()->route('dmd.edit', $data->id)->withOk("La demande a été créé.")->withWarning("Ajoutez les produits à votre demande avant envoie");

	    return $redirect;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showSend(Request $request, $id)
    {
        //

	    $request->session()->forget('produit_send_id');
	    $request->session()->forget('produit_send');

	    $currentUser = Auth::user();

	    $pdv = $this->posRepository->getWhere()->where('id', '!=', $currentUser->pos_id)->get();

	    $pos = array();
	    foreach ($pdv as $item):
		    $pos[$item->id] = $item->name;
	    endforeach;

	    $my_mag = array();

	    $currentMag = $this->posRepository->getById($currentUser->pos_id);
	    foreach ($currentMag->Magasins()->get() as $item):
		    $my_mag[$item->id] = $item->name;
	    endforeach;

	    $data = $this->modelRepository->getById($id);

	    return view('transfert.dmdsend.show', compact('pos', 'my_mag', 'data'));
    }

	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editSend(Request $request, $id)
    {

	    $data = $this->modelRepository->getById($id);

	    if($data->statut_doc == 2):
		    return redirect()->route('dmd.show', $data->id)->withWarning('Cette demande est déja cloturée');
	    endif;

	    $currentUser= Auth::user();

	    $pdv = $this->posRepository->getWhere()->where('id', '!=', $currentUser->pos_id)->get();

	    $pos = array();
	    foreach ($pdv as $item):
		    $pos[$item->id] = $item->name;
	    endforeach;

	    $my_mag = array();

	    $currentMag = $this->posRepository->getById($currentUser->pos_id);
	    foreach ($currentMag->Magasins()->get() as $item):
		    $my_mag[$item->id] = $item->name;
	    endforeach;

	    $produits = array();

	    $produit_ids = array();

	    if($request->session()->has('produit_send')):
		    $request->session()->forget('produit_send');
	    endif;

	    if($request->session()->has('produit_send_id')):
		    $request->session()->forget('produit_send_id');
	    endif;

	    foreach ($data->ligne_transfert()->get() as $items):
		    $save = array();

		    $save['produit_id']  = $items->produit()->first()->id;
		    $save['produit_name']  = $items->produit()->first()->name;
		    $save['quantite'] = $items->qte_dmd;

		    array_push($produits, $save);
		    array_push($produit_ids, $items->produit()->first()->id);
	    endforeach;

	    $request->session()->put('produit_send', $produits);
	    $request->session()->put('produit_send_id', $produit_ids);


	    return view('transfert.dmdsend.edit', compact('pos', 'my_mag', 'data', 'currentMag', 'produits'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSend(DemandeSendRequest $request, $id)
    {
        //
	    $data = $request->all();

	    $this->modelRepository->update($id, $data);

	    $current = $this->modelRepository->getById($id);

	    $produit = $request->session()->get('produit_send');
	    $produit_id = $request->session()->get('produit_send_id');



	    if($produit):
		    foreach ($produit as $prod):
                $ligne = $this->ligneTransfertRepository->getWhere()->where(
                        [
                            ['produit_id', '=', $prod['produit_id']],
                            ['transfert_id', '=', $id]
                        ]
                )->first();


                if(!$ligne):
                    $ligne_array = array();
                    $ligne_array['produit_id'] = $prod['produit_id'];
                    $ligne_array['transfert_id'] = $id;
                    $ligne_array['qte_dmd'] = $prod['quantite'];

                    $this->ligneTransfertRepository->store($ligne_array);
                endif;

		    endforeach;
	    endif;

	    if($produit_id == null):
            $produit_id = array();
        endif;

        foreach($current->ligne_transfert()->get() as $item):
            if(!in_array($item->produit_id, $produit_id)):
                $del_data = $this->ligneTransfertRepository->getById($item->id);
                $del_data->delete();
            endif;
        endforeach;


	    $request->session()->forget('produit_send_id');
	    $request->session()->forget('produit_send');

	    $redirect = redirect()->route('dmd.show', $id)->withOk("La demande a été modifiée.");

	    return $redirect;
    }


	public function addProduit(Request $request, $id){

		$allProduits = $this->produitRepository->getWhere()->where([['bundle', '=', '0']])->get();

		$produits = array();
		foreach ( $allProduits as $item ) {
			if($request->session()->has('produit_send_id')):
				if(!in_array($item->id, $request->session()->get('produit_send_id'))):
					$produits[$item->id] = $item->name;
				endif;
			else:
				$produits[$item->id] = $item->name;
			endif;
		}

		return view('transfert.dmdsend.addProduit', compact('produits', 'id'));
	}

	public function validProduit(TransfertProduitRequest $request, $id){

		$produits = array();
		$produit_id = array();

		if($request->session()->has('produit_send')):
			$produits = $request->session()->get('produit_send');
		endif;

		if($request->session()->has('produit_send_id')):
			$produit_id = $request->session()->get('produit_send_id');
		endif;

		$produit = array();

		$current_produit = $this->produitRepository->getById($request['produit_id']);

		$produit['produit_id']  = $request['produit_id'];
		$produit['produit_name']  = $current_produit->name;
		$produit['quantite'] = $request['quantite'];


		array_push($produits, $produit);

		array_push($produit_id, $request['produit_id']);

		$request->session()->put('produit_send', $produits);
		$request->session()->put('produit_send_id', $produit_id);

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);
	}

	public function listProduit(){

		$produits = session('produit_send');

		?>
		<table class="table table-stylish">
			<thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Produit</th>
                <th>Quantité</th>
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
						<td><a class="delete" onclick="remove(<?= $key ?>)"><i class="fa fa-trash"></i></a></td>
					</tr>
					<?php
				endforeach;
			else:
				?>
				<tr>
					<td colspan="4">
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

		if($request->session()->has('produit_send')):
			$produits = $request->session()->get('produit_send');
		endif;

		if($request->session()->has('produit_send_id')):
			$produit_id = $request->session()->get('produit_send_id');
		endif;

		unset($produits[$key]);
		unset($produit_id[$key]);

		if(!$produits){
			$request->session()->forget('produit_send');
		}else{
			$request->session()->put('produit_send', $produits);
		}

		if(!$produit_id){
			$request->session()->forget('produit_send_id');
		}else{
			$request->session()->put('produit_send_id', $produit_id);
		}

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);

	}



	/**
	 *
	 *
	 *
	 * Action pour les demandes de stocks recçues
	 *
	 *
	 *
	 *
	 */



	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function indexReceive()
	{
		//
		$currentUser= Auth::user();

		$datas = $this->modelRepository->getWhere()->where([
			['pos_appro_id', '=', $currentUser->pos_id],
			['statut_doc', '!=', 0]
		])->get();

		return view('transfert.dmdreceive.index', compact('datas'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function showReceive($id)
	{
		//

		$currentUser = Auth::user();

		$pdv = $this->posRepository->getWhere()->get();

		$pos = array();
		foreach ($pdv as $item):
			$pos[$item->id] = $item->name;
		endforeach;

		$my_mag = array();

		$currentMag = $this->posRepository->getById($currentUser->pos_id);
		foreach ($currentMag->Magasins()->get() as $item):
			$my_mag[$item->id] = $item->name;
		endforeach;

		$data = $this->modelRepository->getById($id);

		return view('transfert.dmdreceive.show', compact('pos', 'my_mag', 'data'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editReceive(Request $request, $id)
	{

		$data = $this->modelRepository->getById($id);

		if($data->statut_doc == 2):
			return redirect()->route('receive.show', $data->id)->withWarning('Cette demande est déja cloturée');
		endif;

		$currentUser= Auth::user();

		$pdv = $this->posRepository->getWhere()->get();

		$pos = array();
		foreach ($pdv as $item):
			$pos[$item->id] = $item->name;
		endforeach;

		$mag = array();

		$currentMag = $this->magasinRepository->getWhere()->get();
		foreach ($currentMag as $item):
			$mag[$item->id] = $item->name;
		endforeach;

		$my_mag = array();

		$currentMag = $this->posRepository->getById($currentUser->pos_id);
		foreach ($currentMag->Magasins()->get() as $item):
			$my_mag[$item->id] = $item->name;
		endforeach;

		$produits = array();

		$produit_ids = array();

		if($request->session()->has('produit_receive')):
			$request->session()->forget('produit_receive');
		endif;

		if($request->session()->has('produit_receive_id')):
			$request->session()->forget('produit_receive_id');
		endif;

		foreach ($data->ligne_transfert()->get() as $items):
			$save = array();

			$save['ligne_id']  = $items->id;
			$save['produit_id']  = $items->produit()->first()->id;
			$save['produit_name']  = $items->produit()->first()->name;
			$save['quantite'] = $items->qte_dmd;
			$save['quantite_exp'] = $items->qte_exp;
			$save['quantite_a_exp'] = $items->qte_a_exp;

			array_push($produits, $save);
			array_push($produit_ids, $items->id);
		endforeach;

		$request->session()->put('produit_receive', $produits);
		$request->session()->put('produit_receive_id', $produit_ids);


		return view('transfert.dmdreceive.edit', compact('pos', 'my_mag', 'data', 'currentMag', 'mag', 'produits'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateReceive(DemandeReceiveRequest $request, $id)
	{
		//
		$data = $request->all();

		$this->modelRepository->update($id, $data);

		$redirect = redirect()->route('receive.show', $id)->withOk("La demande a été modifiée.");

		return $redirect;
	}



	public function changeStatutDoc($id, $statut)
    {
        //
	    $data = $this->modelRepository->getById($id);

	    $redirect = redirect()->route('dmd.show', $id);

	    if($data->statut_doc == 0):

		    if($data->ligne_transfert()->count()):

                if($statut == 1):
				    $redirect->withOk('La demande de stock a été envoyé');
                elseif ($statut == 2):
				    $redirect->withOk('La dmande de stock a été cloturé');
			    endif;

		    else:

			    return $redirect->withWarning('Vous devez associer des produits à demander avant l\'envoie de la demande');

		    endif;

        endif;

	    $data->statut_doc = $statut;
	    $data->save();

	    return $redirect;

    }


    public function verifieStock(Request $request){

	    $data = $request->all();

	    $mag = $this->magasinRepository->getById($data['magasin_id']);



	    $mag_count = $mag->Stock()->where([
	            ['produit_id', '=', $data['produit_id']],
	            ['type', '=', 0],
        ])->count();

	    $response = array(
	            'success' => '',
                'error' => '',
                'qte_stock' => '',
                'qte_max' => ''
        );

	    $current_ligne = $this->ligneTransfertRepository->getById($data['ligne_id']);

	    if($data['qte_a_exp'] <= $current_ligne->qte_dmd):
            if($mag_count > $data['qte_a_exp']):
                if($data['qte_a_exp'] == 0):
	                $response['error'] = 'Your enquiry has not been successfully submitted!';
                else:
                    $response['success'] = 'Quantité suffisante !';
	            endif;

                $current_ligne->qte_a_exp = $data['qte_a_exp'];
                $current_ligne->save();

            else:
                $response['error'] = 'Quantité non suffisante !';
                $response['qte_stock'] = $mag_count;

                $current_ligne->qte_a_exp = 0;
                $current_ligne->save();
            endif;
        else:

	        $response['error'] = 'La quantité à expédier ne doit pas être supérieure à la quantité demandée';
            $response['qte_max'] = 'La quantité à expédier ne doit pas être supérieure à la quantité demandée';
	        $current_ligne->qte_a_exp = 0;
	        $current_ligne->save();

        endif;

	    return response()->json($response);
    }

	public function saveStockAppro(Request $request){
        $data = $request->all();

        $save = $this->modelRepository->getById($data['id']);
        $save->mag_appro_id = $data['mag_appro_id'];
        $save->save();

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);
	}

	public function addSerie(Request $request, $demande_id){

		$demande = $this->modelRepository->getById($demande_id);
		$magasin_id = $demande->mag_appro_id;


		$series = $this->magasinRepository->getById($magasin_id);
		$series = $series->Stock()->get();

		$produits = array();
		foreach ($series as $serie):
//            if(!$serie->ligne_serie()->count()):
//                if($serie->type == 0):
//                    if($serie->lot_id):
//                        if(!$serie->Lot()->ligne_serie()->count()):
//	                        array_push($produits, $serie);
//                        endif;
//                    else:
//	                    array_push($produits, $serie);
//                    endif;
//                elseif($serie->type == 1):
//	                array_push($produits, $serie);
//                endif;
//            endif;
        endforeach;

//		return view('transfert.dmdreceive.addSerie', compact('produits', 'id'));
	}


}
