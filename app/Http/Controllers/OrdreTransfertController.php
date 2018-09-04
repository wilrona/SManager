<?php

namespace App\Http\Controllers;

use App\EcritureStock;
use App\Http\Requests\DemandeReceiveRequest;
use App\Http\Requests\DemandeSendRequest;
use App\Http\Requests\TransfertProduitRequest;
use App\Library\CustomFunction;
use App\Repositories\EcritureStockRepository;
use App\Repositories\LigneTransfertRepository;
use App\Repositories\MagasinRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SerieRepository;
use App\Repositories\OrdreTransfertRepository;
use App\Repositories\TransfertRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdreTransfertController extends Controller
{
	protected $modelRepository;
	protected $posRepository;
	protected $magasinRepository;
	protected $parametreRepository;
	protected $produitRepository;
	protected $ligneTransfertRepository;
	protected $serieRepository;
	protected $transfertRepository;
	protected $ecritureStockRepository;

	protected $custom;
	protected $transitRef;

	public function __construct(OrdreTransfertRepository $ordre_transfert_repository, PointDeVenteRepository $point_de_vente_repository,
		MagasinRepository $magasin_repository, ParametreRepository $parametre_repository,
		ProduitRepository $produit_repository, LigneTransfertRepository $ligne_transfert_repository,
        SerieRepository $serie_repository, TransfertRepository $transfert_repository,
        EcritureStockRepository $ecriture_stock_repository
	) {

		$this->modelRepository = $ordre_transfert_repository;
		$this->posRepository = $point_de_vente_repository;
		$this->magasinRepository = $magasin_repository;
		$this->parametreRepository = $parametre_repository;
		$this->produitRepository = $produit_repository;
		$this->ligneTransfertRepository = $ligne_transfert_repository;
		$this->serieRepository = $serie_repository;
		$this->transfertRepository = $transfert_repository;
		$this->ecritureStockRepository = $ecriture_stock_repository;

		$transit = $this->magasinRepository->getWhere()->where('transite', '=', 1)->first();

		$this->transitRef = $transit;

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

	    $mags = array();
	    foreach ($currentUser->Magasins()->get() as $mag):
		    array_push($mags, $mag->id);
	    endforeach;

	    $datas = $this->modelRepository->getWhere()->whereIn('pos_dmd_id', $mags)->orderBy('created_at', 'desc')->get();

	    return view('ordretransfert.dmdsend.index', compact('datas'));
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

	    foreach ($currentUser->Magasins()->get() as $item):
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

	    return view('ordretransfert.dmdsend.create', compact('pos', 'my_mag', 'reference', 'currentMag'));
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

	    foreach ($currentUser->Magasins()->get() as $item):
		    $my_mag[$item->id] = $item->name;
	    endforeach;

	    $data = $this->modelRepository->getById($id);

	    return view('ordretransfert.dmdsend.show', compact('pos', 'my_mag', 'data'));
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function receiveSend(Request $request, $id)
	{
		//
		$currentUser = Auth::user();

		$pdv = $this->posRepository->getWhere()->where('id', '!=', $currentUser->pos_id)->get();

		$pos = array();
		foreach ($pdv as $item):
			$pos[$item->id] = $item->name;
		endforeach;

		$my_mag = array();

		$currentMag = $this->posRepository->getById($currentUser->pos_id);

		foreach ($currentUser->Magasins()->get() as $item):
			$my_mag[$item->id] = $item->name;
		endforeach;

		$data = $this->modelRepository->getById($id);

		return view('ordretransfert.dmdsend.receive', compact('pos', 'my_mag', 'data'));
	}

	public function showSerieProduitReception(Request $request, $ligne_id){

		$request->session()->forget('transfert_serie_produit');

		$datas = $this->ligneTransfertRepository->getById($ligne_id);

		$ordre_transfert = $datas->ordre_transfert_id;

		$series = $datas->serie_ligne()->whereHas('transferts', function ($q) use ($ordre_transfert){
		    $q->where(
		            [
		                    ['ok', '=', 0],
                            ['ordre_transfert_id', '=', $ordre_transfert]
                    ]
            );
        })->get();

		$selected = array();
		$select = $datas->serie_ligne()->where('a_recu', '=', 1);
		foreach ($select->get() as $item):
            array_push($selected, $item->id);
        endforeach;


		return view('ordretransfert.dmdsend.addSerieLigne', compact('datas', 'series', 'selected', 'ordre_transfert'));
	}

	public function checkSerieProduitReception(Request $request, $ligne_id){
		$data = $request->all();

		$serie_id = array();

		if($request->session()->has('transfert_serie_produit')):
			$serie_id = $request->session()->get('transfert_serie_produit');
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

		$transfert = $this->ligneTransfertRepository->getById($ligne_id);


		$qte_dmd = $transfert->qte_exp - $transfert->qte_recu;
		if($qte_dmd >= $count):
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
			$response['error'] = 'Quantité de produit selectionnée supérieure par rapport à la quantité expedier';
		endif;

		$request->session()->put('transfert_serie_produit', $serie_id);


		return response()->json($response);

	}

	public function validSerieProduitReception(Request $request, $ligne_id){

		$data = $request->all();

		$ligne_id = $this->ligneTransfertRepository->getById($ligne_id);

		$count = 0;
		if(isset($data['produit'])):

			foreach ($data['produit'] as $produit):
				$serie = $this->serieRepository->getById($produit);
                $ligne_serie = $serie->ligne_serie()->where('id', $ligne_id->id);

				if($ligne_serie->count()):

					$saved = $ligne_serie->first();

                    $saved->pivot->a_recu = 1;

				    $saved->pivot->save();

					if($serie->type == 1):
						$count += $serie->SeriesLots()->count();
					else:
						$count += 1;
					endif;
				endif;
			endforeach;

			foreach ($ligne_id->serie_ligne()->get() as $ser):
                if(!in_array($ser->id, $data['produit'])):
                    $saved = $ser->ligne_serie()->where('id', $ligne_id->id)->first();
                    $saved->pivot->a_recu = 0;
                    $saved->pivot->save();
				endif;
			endforeach;

		else:
			foreach ($ligne_id->serie_ligne()->get() as $ser):
				$saved = $ligne_id->serie_ligne()->where('id', $ser->id)->first();
				$saved->pivot->a_recu = 0;
				$saved->pivot->save();
			endforeach;
		endif;

		$ligne_id->qte_a_recu = $count;
		$ligne_id->save();

		$response = array(
			'success' => 'Tous les enregistrements ont été pris en compte'
		);

		return response()->json($response);
	}

	public function listdmdProduitReception($demande_id){

		$dmd = $this->modelRepository->getById($demande_id);

		?>
        <table class="table">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Produit</th>
                <th class="col-xs-2">Qte ddée</th>
                <th class="col-xs-2">Qté Reçue</th>
                <th class="col-xs-2">Qté Exp.</th>
                <th class="col-xs-2">Qté à Rec.</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>
			<?php if($dmd->ligne_transfert()->count()):
				foreach($dmd->ligne_transfert()->get() as $key => $value):
					?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $value->produit()->first()->name ?></td>
                        <td><?= $value->qte_dmd; ?></td>
                        <td><?= $value->qte_recu; ?></td>
                        <td><?= $value->qte_exp; ?></td>
                        <td><?= $value->qte_a_recu; ?></td>
                        <td>
                            <?php if($value->qte_exp): ?>
                            <a href="<?= route('dmd.showSerieProduitReception', $value->id) ?>" class="btn-serie" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static">
                                <i class="fa fa-list-alt"></i>
                            </a>
                            <?php endif; ?>
                        </td>

                    </tr>
					<?php
				endforeach;
			else:
				?>
                <tr>
                    <td colspan="7">
                        <h4 class="text-center" style="margin: 0;">Aucun produit enregistré</h4>
                    </td>
                </tr>
			<?php endif; ?>
            </tbody>
        </table>

		<?php
	}

	public function showSerieReception(Request $request, $transfert_id){

		$request->session()->forget('transfert_serie');

		$datas = $this->transfertRepository->getById($transfert_id);

		$qte_exp = 0;
		$exist_exp = array();
		foreach ($datas->Series()->where('ok', '=', 0)->get() as $item):

            if($item->type == 1):
	            $qte_exp += $item->SeriesLots()->count();
		        array_push($exist_exp, $item->id);
		    else:
                if($item->lot_id):
                    if(!in_array($item->lot_id, $exist_exp)):
	                    $qte_exp += 1;
                    endif;
                else:
			        $qte_exp += 1;
                endif;
            endif;

        endforeach;

		$qte_recept = 0;
        $exist_recept = array();;
		foreach ($datas->Series()->get() as $item):
			if($item->ligne_serie()->where([['a_recu', '=', 1],['ordre_transfert_id', '=', $datas->ordre_transfert_id]])->count()):
                if($item->type == 1):

                        $qte_recept += $item->SeriesLots()->count();
                        array_push($exist_recept, $item->id);

                else:
                    if($item->lot_id):
                        if(!in_array($item->lot_id, $exist_recept)):
                            $qte_recept += 1;
                        endif;
                    else:
                        $qte_recept += 1;
                    endif;
                endif;
			endif;
        endforeach;


		$selected = array();
		foreach ($datas->Series()->get() as $item):
            if($item->ligne_serie()->where('a_recu', '=', 1)->first()):
			    array_push($selected, $item->id);
		    endif;
		endforeach;


		return view('ordretransfert.dmdsend.addSerie', compact('datas', 'qte_recept', 'qte_exp', 'selected'));
	}

	public function checkSerieReception(Request $request, $transfert_id){
		$data = $request->all();

		$serie_id = array();

		if($request->session()->has('transfert_serie')):
			$serie_id = $request->session()->get('transfert_serie');
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

		$transfert = $this->transfertRepository->getById($transfert_id);

		$qte_exp = 0;
		$exist_exp = array();
		foreach ($transfert->Series()->get() as $item):

			if($item->type == 1):
				$qte_exp += $item->SeriesLots()->count();
				array_push($exist_exp, $item->id);
			else:
				if($item->lot_id):
					if(!in_array($item->id, $exist_exp)):
						$qte_exp += 1;
					endif;
				else:
					$qte_exp += 1;
				endif;
			endif;

		endforeach;

		$qte_recept = 0;
		$exist_recept = array();;
		foreach ($transfert->Series()->where('ok', '=', 1)->get() as $item):
			if($item->type == 1):
				$qte_recept += $item->SeriesLots()->count();
				array_push($exist_recept, $item->id);
			else:
				if($item->lot_id):
					if(!in_array($item->id, $exist_recept)):
						$qte_recept += 1;
					endif;
				else:
					$qte_recept += 1;
				endif;
			endif;
		endforeach;

		$qte_dmd = $qte_exp - $qte_recept;

		if($qte_dmd >= $count):
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
			$response['error'] = 'Quantité de produit selectionnée supérieure par rapport à la quantité expedier';
		endif;

		$request->session()->put('transfert_serie', $serie_id);


		return response()->json($response);

	}

	public function validSerieReception(Request $request, $transfert_id){

		$data = $request->all();

		$transfert_id = $this->transfertRepository->getById($transfert_id);

		if(isset($data['produit'])):

			foreach ($data['produit'] as $produit):
				$serie = $this->serieRepository->getById($produit);
		        $ligne_serie = $serie->ligne_serie()->where([['a_recu', '=', 0],['ordre_transfert_id', '=', $transfert_id->ordre_transfert_id]]);

				if($ligne_serie->count()):

					$saved = $ligne_serie->first();
					$saved->qte_a_recu += $saved->pivot->qte;
					$saved->pivot->a_recu = 1;
					$saved->save();
					$saved->pivot->save();

				endif;

			endforeach;
			foreach ($transfert_id->Series()->get() as $ser):
                if(!in_array($ser->id, $data['produit'])):
                    $ligne_serie = $ser->ligne_serie()->where([['a_recu', '=', 1],['ordre_transfert_id', '=', $transfert_id->ordre_transfert_id]])->first();
                    if($ligne_serie):
                        $ligne_serie->pivot->a_recu = 0;
                        if($ligne_serie->qte_a_recu > 0):
                            $ligne_serie->qte_a_recu -= $ligne_serie->pivot->qte;
                        endif;
	                    $ligne_serie->save();
                        $ligne_serie->pivot->save();

                    endif;
				endif;
			endforeach;
		else:
			foreach ($transfert_id->Series()->get() as $ser):
				$ligne_serie = $ser->ligne_serie()->where([['a_recu', '=', 1],['ordre_transfert_id', '=', $transfert_id->ordre_transfert_id]])->first();
                if($ligne_serie):
                    $ligne_serie->pivot->a_recu = 0;
                    if($ligne_serie->qte_a_recu > 0):
                        $ligne_serie->qte_a_recu -= $ligne_serie->pivot->qte;
                    endif;
	                $ligne_serie->save();
                    $ligne_serie->pivot->save();
				endif;
			endforeach;
		endif;

		$response = array(
			'success' => 'Tous les enregistrements ont été pris en compte'
		);

		return response()->json($response);
	}


	public function reception(Request $request, $id){

		$dmd = $this->modelRepository->getById($id);

		$exit_ligne_zero = 0;

		foreach ($dmd->ligne_transfert()->get() as $ligne):
			if($ligne->qte_a_recu):
				$exit_ligne_zero += 1;
			endif;
		endforeach;

		if(!$exit_ligne_zero):
			return redirect()->route('dmd.receiveSend', $id)->withWarning('Une reception vide n\'est pas autorisée.');
		endif;

		$transferts = $dmd->transferts()->get();

		$transit = null;
		$dmdeur = null;

		foreach ($transferts as $transfert):

            $count_serie = array();
		    $produit = array();

		    $series = $transfert->Series();

		    foreach ($series->get() as $serie):

                $lign_serie = $serie->ligne_serie()->where('ordre_transfert_id', '=', $dmd->id)->first();

                if($lign_serie && $lign_serie->pivot->a_recu == 1):

                    $lign_serie->pivot->a_recu = 2;
                    $lign_serie->pivot->save();


                    $serie->pivot->ok = 1;
                    $serie->pivot->save();

                    $mah = $this->magasinRepository->getById($dmd->mag_dmd_id);

                    $serie_child_id = array();

                    if($serie->type == 1):
                        $child_in_appro_mag = false;
                        foreach ($serie->SeriesLots()->get() as $item):
                            if($item->Magasins()->where([['id', '=', $dmd->mag_appro_id], ['mouvement', '=', 2]])->count()):
                                $item->Magasins()->wherePivot('magasin_id', '=', $dmd->mag_appro_id)->detach();
                                $item->Magasins()->save($mah);
                                if(!in_array($item->id, $serie_child_id)):
                                    array_push($serie_child_id, $item->id);
                                endif;
                            endif;
                            if($item->Magasins()->where('id', '=', $dmd->mag_appro_id)->count()):
                                $child_in_appro_mag = true;
                            endif;
                        endforeach;

                        if(!$child_in_appro_mag):
                            $serie->Magasins()->wherePivot('magasin_id', '=', $dmd->mag_appro_id)->detach();
                        endif;

                        $serie->Magasins()->save($mah);
                    else:
                        if($serie->Magasins()->where('id', '=', $dmd->mag_appro_id)->count()):

	                        $serie->Magasins()->wherePivot('magasin_id', '=', $dmd->mag_appro_id)->detach();
                            $serie->Magasins()->save($mah);

                            if($serie->lot_id):
                                $lot = $serie->Lot()->first();
                                $exist_in_appro = false;
                                foreach ($lot->SeriesLots()->get() as $otem):
                                    if($otem->Magasins()->where('id', '=', $dmd->mag_appro_id)->count()):
                                        $exist_in_appro = true;
                                    endif;
                                endforeach;

                                if(!$lot->Magasins()->where('id', '=', $mah->id)->count()):
                                    $lot->Magasins()->save($mah);
                                endif;

                                if(!$exist_in_appro):
                                    $lot->Magasins()->wherePivot('magasin_id', '=', $dmd->mag_appro_id)->detach();
                                endif;
                            endif;

                        endif;
                    endif;

                    if(!in_array($serie->produit_id, $produit)):

                        $info = array();
                        $info['produit_id'] = $serie->produit_id;

                        $info['serie_id'] = array();

                        $info['count'] = 0;
                        if($serie->type == 1):

                             foreach ($serie_child_id as $child):
                                 if(!in_array($child, $info['serie_id'])):
                                    array_push($info['serie_id'], $child);
                                 endif;
                             endforeach;

                            $info['count'] += count($info['serie_id']);
                        else:
	                        array_push($info['serie_id'], $serie->id);
                            $info['count'] += 1;
                        endif;

                        array_push($count_serie, $info);
                        array_push($produit, $serie->produit_id);

                    else:

                        $key = array_search($serie->produit_id, array_column($count_serie, 'produit_id'));
                        if(!in_array($serie->id, $count_serie[$key]['serie_id'])):
                            array_push($count_serie[$key]['serie_id'], $serie->id);
                        endif;

                        if($serie->type == 1):
                            foreach ($serie_child_id as $child):
                                if(!in_array($child, $count_serie[$key]['serie_id'])):
                                    array_push($count_serie[$key]['serie_id'], $child);
                                endif;
                            endforeach;

                            $count_serie[$key]['count'] += count(($count_serie[$key]['serie_id']));
                        else:
                            $count_serie[$key]['count'] += 1;
                        endif;

                    endif;

                endif;

            endforeach;

            if($series->where('type', '=', 0)->count() == $series->where([['type', '=', 0], ['ok', '=', 1]])->count()):
                $transfert->etat = 1;
                $transfert->save();
            endif;

			$currentUser= Auth::user();

			foreach ($count_serie as $value):

				$ecriture_stock = array();
				$ecriture_stock['type_ecriture'] = 1;
				$ecriture_stock['quantite'] = (-1 * $value['count']);
				$ecriture_stock['produit_id'] = $value['produit_id'];
				$ecriture_stock['ordre_transfert_id'] = $dmd->id;
				$ecriture_stock['transfert_id'] = $transfert->id;
				$ecriture_stock['user_id'] = $currentUser->id;
				$ecriture_stock['magasin_id'] = $this->transitRef->id;

				$transit = $this->ecritureStockRepository->store($ecriture_stock);

				$ecriture_stock = array();
				$ecriture_stock['type_ecriture'] = 0;
				$ecriture_stock['quantite'] = (1 * $value['count']);
				$ecriture_stock['produit_id'] = $value['produit_id'];
				$ecriture_stock['ordre_transfert_id'] = $dmd->id;
				$ecriture_stock['transfert_id'] = $transfert->id;

				$ecriture_stock['user_id'] = $currentUser->id;
				$ecriture_stock['magasin_id'] = $dmd->mag_dmd_id;

				$dmdeur = $this->ecritureStockRepository->store($ecriture_stock);

				foreach ($value['serie_id'] as $serie_child_id):
                    $serie_child = $this->serieRepository->getById($serie_child_id);
                    if($dmdeur):
	                    $serie_child->EcriureStocks()->save($dmdeur);
					endif;
					if($transit):
						$serie_child->EcriureStocks()->save($transit);
					endif;
                endforeach;

            endforeach;


        endforeach;

        $recept_total = false;

		foreach ($dmd->ligne_transfert()->get() as $ligne):

			$ligne->qte_recu += $ligne->qte_a_recu;
			$ligne->qte_a_recu = 0;

			$ligne->save();

			if($ligne->qte_recu == $ligne->qte_dmd):
                $recept_total = true;
			else:
				$recept_total = false;
            endif;

		endforeach;

		if($recept_total):
            $dmd->statut_recept = 2;
        else:
	        $dmd->statut_recept = 1;
        endif;
		$dmd->save();

		return redirect()->route('dmd.show', $id)->withOk('Votre reception a été prise en compte avec succès.');

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

	    foreach ($currentUser->Magasins()->get() as $item):
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


	    return view('ordretransfert.dmdsend.edit', compact('pos', 'my_mag', 'data', 'currentMag', 'produits'));

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
                            ['ordre_transfert_id', '=', $id]
                        ]
                )->first();


                if(!$ligne):
                    $ligne_array = array();
                    $ligne_array['produit_id'] = $prod['produit_id'];
                    $ligne_array['ordre_transfert_id'] = $id;
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

		return view('ordretransfert.dmdsend.addProduit', compact('produits', 'id'));
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
		<table class="table">
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

	public function changeStatutDoc($id, $statut)
	{
		//
		$data = $this->modelRepository->getById($id);

		$redirect = redirect()->route('dmd.show', $id);

		if($data->statut_doc == 0):

			if($data->ligne_transfert()->count()):

				if($statut == 1):
					$redirect->withOk('La demande de stock a été envoyé');
                elseif ($statut == 3):
					$redirect->withOk('La dmande de stock a été annulé');
				endif;

			else:

				return $redirect->withWarning('Vous devez associer des produits à demander avant l\'envoie de la demande');

			endif;

			$data->statut_doc = $statut;
			$data->save();

        elseif ($data->statut_doc == 1):

            if($data->Transferts()->where('etat', '=', 0)->count()):

	            return redirect()->route('receive.show', $id)->withWarning('La demande de stock a une ou plusieurs expéditions en cours.');

            else:
                foreach ($data->ligne_transfert()->get() as $item):

                    $del = false;

                    foreach ($item->serie_ligne()->get() as $subitem):
                        if(!$subitem->Transferts()->count()):
	                        $item->serie_ligne()->detach($subitem->id);
                            $del = true;
                        endif;
                    endforeach;

                    if($del):
	                    $item->qte_a_exp = 0;
	                    $item->save();
                    endif;


                endforeach;

	            $data->statut_doc = $statut;
	            $data->save();

	            return redirect()->route('receive.show', $id)->withOk('La demande a été cloturé');
            endif;

		endif;



		return $redirect;

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

		$mags = array();
		foreach ($currentUser->Magasins()->get() as $mag):
			array_push($mags, $mag->id);
		endforeach;

		$datas = $this->modelRepository->getWhere()->where(
			'statut_doc', '!=', 0
		)->whereIn('pos_appro_id', $mags)->orderBy('created_at', 'desc')->get();

		return view('ordretransfert.dmdreceive.index', compact('datas'));
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
		foreach ($currentUser->Magasins()->get() as $item):
			$my_mag[$item->id] = $item->name;
		endforeach;

		$data = $this->modelRepository->getById($id);

		return view('ordretransfert.dmdreceive.show', compact('pos', 'my_mag', 'data'));
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

		if($data->statut_exp == 2):
			return redirect()->route('receive.show', $data->id);
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
		foreach ($currentUser->Magasins()->get() as $item):
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


		return view('ordretransfert.dmdreceive.edit', compact('pos', 'my_mag', 'data', 'currentMag', 'mag', 'produits'));

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

	public function saveStockAppro(Request $request){

		$request->session()->forget('serie_ligne');

		$data = $request->all();

		$lignes = $this->ligneTransfertRepository->getWhere()->where('ordre_transfert_id', '=', $data['id'])->get();
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

		$demande = $ligne->OrdreTransfert()->first();

		$magasin_id = $demande->mag_appro_id;

		if(!$magasin_id):
			return redirect()->route('receive.edit', $demande->id)->withWarning('Le magasin d\'approvisionnement n\'a pas été définie');
		endif;

		$series = $this->magasinRepository->getById($magasin_id);
		$series = $series->Stock()->where([['produit_id', '=', $ligne->produit_id], ['mouvement', '<=', 1]])->get();

		$produits = array();
		$current_serie = array();
		$no_demande = array();
		$serie_exp = array();
		foreach ($series as $serie):

			if($serie->pivot->mouvement == 1):
				if($serie->ligne_serie()->where('ordre_transfert_id', '=', $demande->id)->count()):
                    if($serie->type == 1):
                        if(!in_array($serie->id, $current_serie)):
	                        array_push($current_serie, $serie->id);
                        endif;
                    else:
	                    if(!in_array($serie->id, $current_serie)):
		                    array_push($current_serie, $serie->id);
	                    endif;
                        if($serie->lot_id):
                            if(!in_array($serie->lot_id, $no_demande)):
                                array_push($no_demande, $serie->lot_id);
                            endif;
                        endif;
                    endif;
                else:
                    if($serie->type == 1):
	                    if(!in_array($serie->id, $no_demande)):
			                array_push($no_demande, $serie->id);
		                endif;

		                if($serie->magasins()->where('mouvement', '=', 1)->count()):
			                $count_SeriesLots = $serie->SeriesLots()->whereHas('Magasins', function($q) use ($demande)
			                {
				                $q->where([['mouvement', '=', 1], ['id', '=', $demande->mag_appro_id]]);
			                })->get();
		                else:
			                $count_SeriesLots = $serie->SeriesLots()->whereHas('Magasins', function($q) use ($demande)
			                {
				                $q->where([['mouvement', '=', 0], ['id', '=', $demande->mag_appro_id]]);
			                })->get();

                        endif;


                        foreach ($count_SeriesLots as $item):
                            array_push($no_demande, $item->id);
                        endforeach;
                    else:

	                    if($serie->lot_id):
                            if(!in_array($serie->lot_id, $no_demande) && !in_array($serie->lot_id, $current_serie)):
                                array_push($no_demande, $serie->lot_id);
                            endif;
		                    if(!in_array($serie->id, $no_demande) && !in_array($serie->lot_id, $current_serie)):
			                    array_push($no_demande, $serie->id);
		                    endif;
                        else:
	                        if(!in_array($serie->id, $no_demande)):
                                array_push($no_demande, $serie->id);
                            endif;
                        endif;
                    endif;
                endif;
            else:
	            if($serie->type == 1):
		            $count_SeriesLots_in_appro = $serie->SeriesLots()->whereHas('Magasins', function($q) use ($demande)
		            {
			            $q->where([['mouvement', '=', 0], ['id', '=', $demande->mag_appro_id]]);
		            })->count();

		            $count_SeriesLots = $serie->SeriesLots()->count();
		            if($count_SeriesLots != $count_SeriesLots_in_appro):
			            if(!in_array($serie->id, $no_demande)):
				            array_push($no_demande, $serie->id);
			            endif;
                    endif;

                endif;
			endif;

		endforeach;

		$request->session()->put('serie_ligne', $current_serie);

		return view('ordretransfert.dmdreceive.addSerie', compact('produits',  'current_serie', 'serie_exp', 'ligne', 'demande', 'series', 'no_demande'));
	}

	public function checkSerie(Request $request, $ligne_id){
		$data = $request->all();

		$ligne = $this->ligneTransfertRepository->getById($ligne_id);
		$demande = $ligne->OrdreTransfert()->first();

		$serie_id = array();

		if($request->session()->has('serie_ligne')):
			$serie_id = $request->session()->get('serie_ligne');
		endif;

		$count = $data['count'];

		$serie = $this->serieRepository->getById($data['id']);

		$exist = false;

		if($serie->type == 1):
			$count_serieLot = 0;
			foreach ($serie->SeriesLots()->get() as $sousSerie):
				if(in_array($sousSerie->id, $serie_id)):
					$exist = true;
				endif;
				if($serie->magasins()->where('mouvement', '=', 1)->count()):
                    if($sousSerie->Magasins()->where([['mouvement', '=', 1], ['id', '=', $demande->mag_appro_id]])->count()):
                        $count_serieLot += 1;
                    endif;
                else:
	                if($sousSerie->Magasins()->where([['mouvement', '=', 0], ['id', '=', $demande->mag_appro_id]])->count()):
		                $count_serieLot += 1;
	                endif;
                endif;

			endforeach;

			if(!$exist):
				if($data['action'] == 'add'):
					if(!in_array($serie->id, $serie_id)):
						array_push($serie_id, $serie->id);
					endif;
                    $count += $count_serieLot;
                else:
	                if (($key = array_search($serie->id, $serie_id)) !== false) {
		                unset($serie_id[$key]);
	                }
                    $count -= $count_serieLot;
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
					if(!in_array($serie->id, $serie_id)):
						array_push($serie_id, $serie->id);
					endif;
                    $count += 1;
                    if($serie->lot_id):
                        $c = $serie->Magasins()->where('id', '=', $demande->mag_appro_id)->first();
                        $c->pivot->mouvement = 1;
                        $c->pivot->save();
                    endif;
                else:
	                if (($key = array_search($serie->id, $serie_id)) !== false) {
		                unset($serie_id[$key]);
	                }
                    $count -= 1;
	                if($serie->lot_id):
		                $c = $serie->Magasins()->where('id', '=', $demande->mag_appro_id)->first();
		                $c->pivot->mouvement = 0;
		                $c->pivot->save();
	                endif;
                endif;
			endif;
		endif;

		$response = array(
			'success' => '',
			'error' => '',
			'count' => 0,
			'action' => $data['action']
		);


		$qte_dmd = $ligne->qte_dmd - $ligne->qte_exp;
		if($qte_dmd >= $count):
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

    public function validSerie(Request $request, $ligne_id){

	    $data = $request->all();

        $ligne_id = $this->ligneTransfertRepository->getById($ligne_id);

	    $demande_en_cours = $ligne_id->OrdreTransfert()->first();

        $count = 0;
        if(isset($data['produit'])):

            foreach ($data['produit'] as $produit):
                $serie = $this->serieRepository->getById($produit);
                if(!$serie->ligne_serie()->where('id', $ligne_id->id)->count()):
                    if($serie->type == 1):

	                    $count_SeriesLots = $serie->SeriesLots()->whereHas('Magasins', function($q) use ($demande_en_cours)
	                    {
		                    $q->where([['mouvement', '=', 0], ['id', '=', $demande_en_cours->mag_appro_id]]);
	                    });

                        $ligne_id->serie_ligne()->save($serie, ['qte' => $count_SeriesLots->count()]);
                        $count += $count_SeriesLots->count();

	                    foreach ($count_SeriesLots->get() as $item):
		                    $c = $item->Magasins()->where('id', '=', $demande_en_cours->mag_appro_id)->first();
		                    $c->pivot->mouvement = 1;
		                    $c->pivot->save();
	                    endforeach;
                    else:
                        $ligne_id->serie_ligne()->save($serie, ['qte' => 1]);
                        $count += 1;
                    endif;
                else:
	                if($serie->type == 1):
		                $count_SeriesLots = $serie->SeriesLots()->whereHas('Magasins', function($q) use ($demande_en_cours)
		                {
			                $q->where([['mouvement', '=', 1], ['id', '=', $demande_en_cours->mag_appro_id]]);
		                });

		                $count += $count_SeriesLots->count();
	                else:
		                $count += 1;
	                endif;
                endif;

                $stock = $serie->Magasins()->where('id', '=', $demande_en_cours->mag_appro_id)->first();
                $stock->pivot->mouvement = 1;
                $stock->pivot->save();
            endforeach;

            foreach ($ligne_id->serie_ligne()->get() as $ser):
	            $en_mag = $ser->Magasins()->where([['mouvement', '=', 1], ['id', '=', $demande_en_cours->mag_appro_id]]);
                if(!in_array($ser->id, $data['produit']) && $en_mag->count()):
                    $ligne_id->serie_ligne()->detach($ser->id);
                    $stock = $en_mag->first();
	                $stock->pivot->mouvement = 0;
	                $stock->pivot->save();

	                if($ser->type == 1):

		                foreach ($ser->SeriesLots()->get() as $item):
			                $c = $item->Magasins()->where([['id', '=', $demande_en_cours->mag_appro_id], ['mouvement', '=', 1]])->first();
	                        if($c && !in_array($item->id, $data['produit'])):
                                $c->pivot->mouvement = 0;
                                $c->pivot->save();
                            endif;
		                endforeach;

                    endif;
                endif;
            endforeach;

        else:
	        foreach ($ligne_id->serie_ligne()->get() as $ser):
                $ligne_id->serie_ligne()->detach($ser->id);
		        $en_mag = $ser->Magasins()->where([['mouvement', '=', 1], ['id', '=', $demande_en_cours->mag_appro_id]]);
		        if($en_mag->count()):
                    $stock = $en_mag->first();
                    $stock->pivot->mouvement = 0;
                    $stock->pivot->save();
		        endif;

		        if($ser->type == 1):

			        foreach ($ser->SeriesLots()->get() as $item):
				        $c = $item->Magasins()->where('id', '=', $demande_en_cours->mag_appro_id)->first();
				        $c->pivot->mouvement = 0;
				        $c->pivot->save();
			        endforeach;

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
                            <a href="<?=  route('receive.addSerie', [$value->id]) ?>" class="btn-serie" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static" data-quantite="<?= $value->qte_dmd ?>" data-ligne="<?= $value->id ?>" data-produit="<?= $value->produit()->first()->id ?>">
                                <i class="fa fa-list-alt"></i>
                            </a>
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

        $exp_partiel = false;

		$count = $this->transfertRepository->getWhere()->where('ordre_transfert_id', '=', $dmd->id)->count();
		$coderef = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'demandes'],
				['type_config', '=', 'transfertref']
			]
		)->first();
		$count += 1;
		$reference = $this->custom->setReference($coderef, $count, 4, $dmd->reference.'/');

		$save_transfert = array();
		$save_transfert['reference'] = $reference;
		$save_transfert['position'] = $count;
		$save_transfert['ordre_transfert_id'] = $dmd->id;

        $transfert = $this->transfertRepository->store($save_transfert);
        $transfert = $this->transfertRepository->getById($transfert->id);

		$currentUser= Auth::user();

		foreach ($dmd->ligne_transfert()->get() as $ligne):

            $qte = $ligne->qte_a_exp + $ligne->qte_exp;

		    if($qte < $ligne->qte_dmd):
                $exp_partiel = true;
		    else:
                $exp_partiel = false;
            endif;

			$appro = null;
			$transit = null;

            if($ligne->qte_a_exp):

                $ecriture_stock = array();
                $ecriture_stock['type_ecriture'] = 1;
                $ecriture_stock['quantite'] = (-1 * $ligne->qte_a_exp);
                $ecriture_stock['produit_id'] = $ligne->produit_id;
                $ecriture_stock['ordre_transfert_id'] = $dmd->id;
                $ecriture_stock['transfert_id'] = $transfert->id;
                $ecriture_stock['user_id'] = $currentUser->id;
                $ecriture_stock['magasin_id'] = $dmd->mag_appro_id;

                $appro = $this->ecritureStockRepository->store($ecriture_stock);

                $ecriture_stock = array();
                $ecriture_stock['type_ecriture'] = 0;
                $ecriture_stock['quantite'] = (1 * $ligne->qte_a_exp);
                $ecriture_stock['produit_id'] = $ligne->produit_id;
                $ecriture_stock['ordre_transfert_id'] = $dmd->id;
                $ecriture_stock['transfert_id'] = $transfert->id;
                $ecriture_stock['user_id'] = $currentUser->id;
                $ecriture_stock['magasin_id'] = $this->transitRef->id;

                $transit = $this->ecritureStockRepository->store($ecriture_stock);

	            foreach ($ligne->serie_ligne()->get() as $serie):
		            if(!$serie->transferts()->where('ordre_transfert_id', '=', $ligne->ordre_transfert_id)->count()):

			            $transfert->Series()->save($serie);
			            if($appro):
				            $serie->EcriureStocks()->save($appro);
			            endif;
			            if($transit):
				            $serie->EcriureStocks()->save($transit);
			            endif;

			            $stock = $serie->Magasins()->where([["mouvement", "=", 1], ['id', '=', $dmd->mag_appro_id]])->first();
                        $stock->pivot->mouvement = 2;
                        $stock->pivot->save();

			            if($serie->type == 1):
				            foreach ($serie->SeriesLots()->get() as $item):
                                $stock_item = $item->Magasins()->where([["mouvement", "=", 1], ['id', '=', $dmd->mag_appro_id]]);
                                if($stock_item->count()):
                                    $transfert->Series()->save($item, ['show' => 0]);
                                    if($appro):
                                        $item->EcriureStocks()->save($appro);
                                    endif;
                                    if($transit):
                                        $item->EcriureStocks()->save($transit);
                                    endif;
	                                $stock_item = $stock_item->first();
	                                $stock_item->pivot->mouvement = 2;
	                                $stock_item->pivot->save();
					            endif;
				            endforeach;
			            endif;

		            endif;
	            endforeach;
			endif;

			$ligne->qte_exp += $ligne->qte_a_exp;
			$ligne->qte_a_exp = 0;

			$ligne->save();

		endforeach;

		if($exp_partiel):
		    $dmd->statut_exp = 1;
		else:
			$dmd->statut_exp = 2;
		endif;

		$dmd->save();

        return redirect()->route('receive.show', $id)->withOk('Votre expédition a été prise en compte avec succès.');

    }


    public function showSerieExpedition($transfert_id){

	    $datas = $this->transfertRepository->getById($transfert_id);
	    $demande = $datas->OrdreTransfert()->first();

	    return view('ordretransfert.dmdreceive.serieExpedition', compact('datas', 'demande'));
    }


}
