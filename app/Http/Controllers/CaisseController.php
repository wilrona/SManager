<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaisseRequest;
use App\Library\CustomFunction;
use App\Repositories\CaisseRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
use Illuminate\Http\Request;

class CaisseController extends Controller
{
	protected $modelRepository;
	protected $posRepository;
	protected $parametreRepository;
	protected $custom;

	public function __construct(CaisseRepository $caisse_repository, PointDeVenteRepository $point_de_vente_repository,
		ParametreRepository $parametre_repository) {
		$this->modelRepository = $caisse_repository;
		$this->posRepository = $point_de_vente_repository;
		$this->parametreRepository = $parametre_repository;

		$this->custom = new CustomFunction();
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

		return view('caisses.index', compact('datas'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


	    // Initialisation de la reference

	    $count = $this->modelRepository->getWhere()->count();
	    $coderef = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'caisses'],
			    ['type_config', '=', 'coderef']
		    ]
	    )->first();
	    $incref = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'caisses'],
			    ['type_config', '=', 'incref']
		    ]
	    )->first();
	    $count += $incref ? intval($incref->value) : 0;
	    $reference = $this->custom->setReference($coderef, $count, 4);

	    return view('caisses.create', compact(  'reference'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CaisseRequest $request)
    {
        //
	    $data = $request->all();

	    $save = $this->modelRepository->store($data);

	    return redirect()->route('caisse.index')->withOk('La caisse a été enregistré');
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

	    $data = $this->modelRepository->getById($id);

	    return view('caisses.show', compact( 'data'));
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

	    $data = $this->modelRepository->getById($id);

	    return view('caisses.edit', compact( 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CaisseRequest $request, $id)
    {
        //

	    $data = $request->all();

	    $this->modelRepository->update($id, $data);

	    return redirect()->route('caisse.show', $id)->withOk('La caisse a été modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
