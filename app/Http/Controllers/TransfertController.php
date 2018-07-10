<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandeReceiveRequest;
use App\Http\Requests\DemandeSendRequest;
use App\Library\CustomFunction;
use App\Repositories\MagasinRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
use App\Repositories\TransfertRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransfertController extends Controller
{
	protected $modelRepository;
	protected $posRepository;
	protected $magasinRepository;
	protected $parametreRepository;

	protected $custom;

	public function __construct(TransfertRepository $transfert_repository, PointDeVenteRepository $point_de_vente_repository,
		MagasinRepository $magasin_repository, ParametreRepository $parametre_repository
	) {

		$this->modelRepository = $transfert_repository;
		$this->posRepository = $point_de_vente_repository;
		$this->magasinRepository = $magasin_repository;
		$this->parametreRepository = $parametre_repository;

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
    public function showSend($id)
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
	    foreach ($currentMag->Magasins()->get() as $item):
		    $my_mag[$item->id] = $item->name;
	    endforeach;

	    $data = $this->modelRepository->getById($id);

	    return view('transfert.dmdsend.show', compact('pos', 'my_mag', 'data'));
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
    public function editSend($id)
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


	    return view('transfert.dmdsend.edit', compact('pos', 'my_mag', 'data', 'currentMag'));

    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editReceive($id)
	{

		$data = $this->modelRepository->getById($id);

		if($data->statut_doc == 2):
			return redirect()->route('receive.show', $data->id)->withWarning('Cette demande est déja cloturée');
		endif;

		if($data->mag_appro_id):
			return redirect()->route('receive.show', $data->id)->withWarning('Vous devez creer une expédition');
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


		return view('transfert.dmdreceive.edit', compact('pos', 'my_mag', 'data', 'currentMag', 'mag'));

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

	    $redirect = redirect()->route('dmd.show', $id)->withOk("La demande a été modifiée.");

	    return $redirect;
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
	    $data->statut_doc = $statut;
	    $data->save();

	    $redirect = redirect()->route('dmd.show', $id);
	    if($statut == 1):
			$redirect->withOk('La demande de stock a été envoyé');
	    elseif ($statut == 2):
		    $redirect->withOk('La dmande de stock a été cloturé');
	    endif;

	    return $redirect;

    }
}
