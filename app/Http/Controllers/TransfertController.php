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


    public function validSerie(Request $request, $ligne_id){

	    $data = $request->all();

        $ligne_id = $this->ligneTransfertRepository->getById($ligne_id);

        $ligne_id->serie_ligne()->detach();

        $count = 0;
        if(isset($data['produit'])):
            foreach ($data['produit'] as $produit):
                $serie = $this->serieRepository->getById($produit);
                if($serie->type == 1):
                    $ligne_id->serie_ligne()->save($serie, ['qte' => $serie->SeriesLots()->count()]);
                    $count += $serie->SeriesLots()->count();
                else:
                    $ligne_id->serie_ligne()->save($serie, ['qte' => 1]);
                    $count += 1;
                endif;
            endforeach;
        endif;

	    $ligne_id->qte_a_exp = $count;
	    $ligne_id->save();

	    $response = array(
		    'success' => 'Tous les enregistrements ont été pris en compte'
	    );

	    return response()->json($response);
    }

	public function listdmd($demande_id){

		$dmd = $this->modelRepository->getById($demande_id);

		?>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="col-xs-5">Produit</th>
                    <th class="col-xs-2 text-center">Qté ddé</th>
                    <th class="col-xs-2 text-center">Qté  Exp.</th>
                    <th class="col-xs-2 text-center">Qté à Exp.</th>
                    <th class="col-xs-1"></th>
                </tr>
            </thead>
            <tbody>
			<?php if($dmd->ligne_transfert()->count()):
				foreach($dmd->ligne_transfert()->get() as $key => $value):
					?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $value->produit()->first()->name ?> <div><small class="text-danger" id="<?= $value->produit()->first()->id ?>"></small></div> </td>
                        <td class="text-center"><?= $value->qte_dmd ?></td>
                        <td class="text-center"><?= $value->qte_exp ?></td>
                        <td class="text-center"><?= $value->qte_a_exp; ?></td>
                        <td>
                            <div aria-label="First group" role="group" class="btn-group col-xs-12">
                                <a href="<?=  route('receive.addSerie', [$value->id]) ?>" class="btn btn-primary btn-serie" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static" data-quantite="<?= $value->qte_dmd ?>" data-ligne="<?= $value->id ?>" data-produit="<?= $value->produit()->first()->id ?>">
                                    <i class="fa fa-list-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
					<?php
				endforeach;
			else:
				?>
                <tr>
                    <td colspan="6">
                        <h4 class="text-center" style="margin: 0;">Aucun produit enregistré</h4>
                    </td>
                </tr>
			<?php endif; ?>
            </tbody>
        </table>

		<?php
	}

    public function checkSerie(Request $request, $ligne_id){
	    $data = $request->all();

	    $serie_id = array();

	    if($request->session()->has('serie_ligne')):
		    $serie_id = $request->session()->get('serie_ligne');
	    endif;

        $count = $data['count'];

        $serie = $this->serieRepository->getById($data['id']);

	    $exist = false;


        if($serie->type == 1):

            foreach ($serie->SeriesLots()->get() as $sousSerie):
                if(in_array($sousSerie->id, $serie_id)):
                    $exist = true;
                endif;
            endforeach;

            if(!$exist):
                if($data['action'] == 'add'):
                    $count += $serie->SeriesLots()->count();
                    array_push($serie_id, $serie->id);
                else:
                    $count -= $serie->SeriesLots()->count();
                    if (($key = array_search($serie->id, $serie_id)) !== false) {
                        unset($serie_id[$key]);
                    }
                endif;
            endif;
        else:
            if($serie->lot_id):
                if(in_array($serie->lot_id, $serie_id)):
                    $exist = true;
                endif;
	        endif;

	        if(!$exist):
                if($data['action'] == 'add'):
                    $count += 1;
	                array_push($serie_id, $serie->id);
                else:
                    $count -= 1;
	                if (($key = array_search($serie->id, $serie_id)) !== false) {
		                unset($serie_id[$key]);
	                }
                endif;
	        endif;
        endif;

	    $response = array(
		    'success' => '',
		    'error' => '',
            'count' => 0,
            'action' => $data['action']
	    );

        $ligne = $this->ligneTransfertRepository->getById($ligne_id);
        if($ligne->qte_dmd >= $count):
	        $response['count'] = $count;
            if(!$exist):
                if($data['action'] == 'add'):
                    $response['success'] = 'Le produit a été pris en compte';
                else:
                    $response['success'] = 'Le produit a été retiré avec succès';
                endif;
            else:
                if($serie->type == 0):
	                $response['error'] = 'Le produit est affecté à un numéro de lot déjà selectionné';
                else:
	                $response['error'] = 'Un numéro de serie du lot a été selectionné';
                endif;
            endif;
        else:
	        $response['count'] = $data['count'];
	        $response['error'] = 'Quantité de produit selectionnée supérieure par rapport à la quantité demandé';
        endif;

	    $request->session()->put('serie_ligne', $serie_id);


	    return response()->json($response);

    }

	public function saveStockAppro(Request $request){

		$request->session()->forget('serie_ligne');

        $data = $request->all();

        $lignes = $this->ligneTransfertRepository->getWhere()->where('transfert_id', '=', $data['id'])->get();
        $exist = false;
        foreach ($lignes as $ligne):
            if($ligne->serie_ligne()->count()):
                $exist = true;
            endif;
        endforeach;

        $response = array('success' => '', 'error' => '');

        if(!$exist):
            $save = $this->modelRepository->getById($data['id']);
            $save->mag_appro_id = $data['mag_appro_id'];
            $save->save();

            $response['success'] = 'Your enquiry has been successfully submitted!';
        else:
            $appro = $this->magasinRepository->getById($data['mag_appro_id']);
            $response['error'] = 'Les modifications ne peuvent pas être prise en compte car vous utilisez déja des produits du magasin "'.$appro->name.'"';
        endif;

		return response()->json($response);
	}

	public function addSerie(Request $request, $ligne_id){

		$request->session()->forget('serie_ligne');

		$ligne = $this->ligneTransfertRepository->getById($ligne_id);

		$demande = $ligne->transfert()->first();

		$magasin_id = $demande->mag_appro_id;

		if(!$magasin_id):
            return redirect()->route('receive.edit', $demande->id)->withWarning('Le magasin d\'approvisionnement n\'a pas été définie');
        endif;

		$series = $this->magasinRepository->getById($magasin_id);
		$series = $series->Stock()->get();

		$produits = array();
		$current_serie = array();
		foreach ($series as $serie):

            $inDmd = $serie->ligne_serie()->where('transfert_id', '=', $demande->id)->first();
		    if($inDmd):
                array_push($current_serie, $serie->id);
            endif;

            if($serie->type == 0):
                if($serie->lot_id):
                    if(!$serie->Lot()->first()->ligne_serie()->count()):
                        array_push($produits, $serie->id);
                    endif;
                else:
                    array_push($produits, $serie->id);
                endif;
            elseif($serie->type == 1):
                array_push($produits, $serie->id);
            endif;

        endforeach;

		return view('transfert.dmdreceive.addSerie', compact('produits',  'current_serie', 'ligne', 'demande', 'series'));
	}

	public function expedition(Request $request, $id){

	    $dmd = $this->modelRepository->getById($id);

	    if(!$dmd->mag_appro_id):
            return redirect()->route('receive.edit', $id)->withWarning('Vous devez définir le magasin approvisionneur avant expédition.');
        endif;

        $exit_ligne_zero = 0;

        foreach ($dmd->ligne_transfert()->get() as $ligne):
            if($ligne->qte_a_exp == 0):
                $exit_ligne_zero += 1;
            endif;
        endforeach;

        if($exit_ligne_zero == $dmd->ligne_transfert()->count()):
	        return redirect()->route('receive.edit', $id)->withWarning('Une expédition vide n\'est pas autorisée.');
        endif;

		foreach ($dmd->ligne_transfert()->get() as $ligne):

            $lign = $this->ligneTransfertRepository->getById($ligne->id);

			$lign->qte_exp = $dmd->qte_a_exp;
			$lign->qte_a_exp = 0;
			$lign->save();

		endforeach;

        return redirect()->route('receive.show', $id)->withOk('Votre expédition a été prise en compte avec succès.');

    }


}
