<?php

namespace App\Http\Controllers;

use App\Http\Requests\MagasinRequest;
use App\Library\CustomFunction;
use App\Repositories\MagasinRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
use App\Repositories\SerieRepository;
use Illuminate\Http\Request;

class MagasinController extends Controller
{
	protected $modelRepository;
	protected $posRepository;
	protected $serieRepository;
	protected $type;
	protected $custom;
	protected $listPOS;
	protected $transitRef;

	protected $parametreRepository;

	public function __construct(MagasinRepository $modelRepository, PointDeVenteRepository $point_de_vente_repository,
		ParametreRepository $parametre_repository, SerieRepository $serie_repository
	) {
		$this->modelRepository = $modelRepository;
		$this->posRepository = $point_de_vente_repository;
		$this->parametreRepository = $parametre_repository;
		$this->serieRepository = $serie_repository;

		$this->type = array(
			0 => 'Magasin Normal',
			1 => 'Magasin de transit'
		);
		$this->custom = new CustomFunction();
		$this->listPOS = $point_de_vente_repository->getWhere()->get();

		$transit = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'magasins'],
				['type_config', '=', 'transitref']
			]
		)->first();

		$this->transitRef = $transit;

		if(!$transit):
			unset($this->type[1]);
		endif;


	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
	    $datas = $this->modelRepository->getWhere()->get();


	    return view('magasins.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
	    $type = $this->type;

	    $pos = array();
	    foreach ($this->listPOS as $item):
		    $pos[$item->id] = $item->name;
	    endforeach;

	    // Initialisation de la reference

	    $count = $this->modelRepository->getWhere()->count();
	    $coderef = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'magasins'],
			    ['type_config', '=', 'coderef']
		    ]
	    )->first();
	    $incref = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'magasins'],
			    ['type_config', '=', 'incref']
		    ]
	    )->first();
	    $count += $incref ? intval($incref->value) : 0;
	    $reference = $this->custom->setReference($coderef, $count, 4);

		return view('magasins.create', compact('type', 'pos', 'reference'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MagasinRequest $request)
    {
	    $data = $request->all();

	    if($data['transite'] == 1):

		    $coderef = $this->transitRef;

		    $count = $this->modelRepository->getWhere()->count();
		    $incref = $this->parametreRepository->getWhere()->where(
			    [
				    ['module', '=', 'magasins'],
				    ['type_config', '=', 'incref']
			    ]
		    )->first();
		    $count += $incref ? intval($incref->value) : 0;
		    $reference = $this->custom->setReference($coderef, $count, 4);
		    $data['reference'] = $reference;

	        $data['pos_id'] = null;
	    endif;

	    $this->modelRepository->store($data);

	    return redirect()->route('magasin.index')->withOk('Le magasin a été crée');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
	    $type = $type = $this->type;
	    $data = $this->modelRepository->getById($id);

	    $pos = array();
	    foreach ($this->listPOS as $item):
		    $pos[$item->id] = $item->name;
	    endforeach;

	    $allSerie = null;
	    if($data->transite):
	        $allSerie = $this->serieRepository->getWhere()->whereHas('magasins', function ($q){
	        	$q->where('mouvement', '=', 2);
	        })->get();
	    endif;

	    return view('magasins.show', compact('data', 'type', 'pos', 'allSerie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
	    $type = $this->type;
	    $data = $this->modelRepository->getById($id);

	    $pos = array();
	    foreach ($this->listPOS as $item):
		    $pos[$item->id] = $item->name;
	    endforeach;

	    return view('magasins.edit', compact('data', 'type', 'pos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MagasinRequest $request, $id)
    {

	    $data = $request->all();

	    $current = $this->modelRepository->getById($id);
	    if($current->transite == 1 && $data['transite'] == 0):
		    $number = explode($this->transitRef, $current->reference);

		    $coderef = $this->parametreRepository->getWhere()->where(
			    [
				    ['module', '=', 'magasins'],
				    ['type_config', '=', 'coderef']
			    ]
		    )->first();

		    $data['reference'] = $coderef->value.''.$number[0];
	    endif;

	    if($current->transite == 0 && $data['transite'] == 1):

		    $coderef = $this->parametreRepository->getWhere()->where(
			    [
				    ['module', '=', 'magasins'],
				    ['type_config', '=', 'coderef']
			    ]
		    )->first();

		    $number = explode($coderef->value, $current->reference);

		    $data['reference'] = $this->transitRef.''.$number[0];
	    endif;

	    if($data['transite'] == 1):
		    $data['pos_id'] = null;
	    endif;

	    $this->modelRepository->update($id, $data);

	    return redirect()->route('magasin.show', $id)->withOk('Le magasin a été modifié');
    }
}
