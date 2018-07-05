<?php

namespace App\Http\Controllers;


use App\Http\Requests\FamilleRequest;
use App\Library\CustomFunction;
use App\Repositories\FamilleRepository;
use App\Repositories\ParametreRepository;
use Illuminate\Http\Request;

class FamilleController extends Controller
{
	protected $modelRepository;
	protected $parametreRepository;
	protected $custom;

	public function __construct(FamilleRepository $modelRepository, ParametreRepository $parametre_repository) {

		$this->modelRepository = $modelRepository;
		$this->parametreRepository = $parametre_repository;

		$this->custom = new CustomFunction();

	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexProduit()
    {
        //

	    $datas = $this->modelRepository->getWhere()->where('type', '=', '0')->get();
	    $type = 0;

	    return view('familles.index', compact('datas', 'type'));
    }

	public function indexClient()
	{
		//

		$datas = $this->modelRepository->getWhere()->where('type', '=', '1')->get();
		$type = 1;

		return view('familles.index', compact('datas', 'type'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProduit()
    {
        //
	    $type = 0;

	    // Initialisation de la reference

	    $count = $this->modelRepository->getWhere()->count();
	    $coderef = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'famillesP'],
			    ['type_config', '=', 'coderef']
		    ]
	    )->first();
	    $incref = $this->parametreRepository->getWhere()->where(
		    [
			    ['module', '=', 'famillesP'],
			    ['type_config', '=', 'incref']
		    ]
	    )->first();
	    $count += $incref ? intval($incref->value) : 0;
	    $reference = $this->custom->setReference($coderef, $count, 4);

	    return view('familles.create', compact('type', 'reference'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function createClient()
	{
		//
		$type = 1;

		$count = $this->modelRepository->getWhere()->count();
		$coderef = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'famillesC'],
				['type_config', '=', 'coderef']
			]
		)->first();
		$incref = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'famillesC'],
				['type_config', '=', 'incref']
			]
		)->first();
		$count += $incref ? intval($incref->value) : 0;
		$reference = $this->custom->setReference($coderef, $count, 4);

		return view('familles.create', compact('type', 'reference'));
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FamilleRequest $request)
    {
        //
	    $data=$request->all();

	    $this->modelRepository->store($data);

	    if($data['type'] == 0):
	        $redirect = redirect()->route('famillepro.index');
	    else:
		    $redirect = redirect()->route('famillecli.index');
	    endif;

	    return $redirect->withOk('La famille a été enregistré');
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

	    return view('familles.show', compact('data'));
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

	    return view('familles.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
	    $data=$request->all();
	    $this->modelRepository->update($id, $data);
	    return redirect()->route('famille.show', $id)->withOk('La famille a été modifié');
    }

    /**
     * Active the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        //
	    $data = $this->modelRepository->getById($id);
	    if($data->active == true):
		    if($data->Produits()->count() && $data->type == 0):
		        return redirect()->route('famille.show', ['id' => $id])->withWarning('La famille est déja utilisée dans un produit');
	        endif;

		    if($data->Clients()->count() && $data->type == 1):
			    return redirect()->route('famille.show', ['id' => $id])->withWarning('La famille est déja utilisée par un client');
		    endif;
	    endif;
	    $data->active = !$data->active;
	    $data->save();

	    return  redirect()->route('famille.show', ['id' => $id])->withOk('La famille a été modifié');
    }
}
