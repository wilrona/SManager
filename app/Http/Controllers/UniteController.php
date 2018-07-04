<?php

namespace App\Http\Controllers;

use App\Library\CustomFunction;
use App\Repositories\UniteRepository;
use Illuminate\Http\Request;

class UniteController extends Controller
{
	protected $modelRepository;

	public function __construct(UniteRepository $modelRepository) {
		$this->modelRepository = $modelRepository;
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

	    return view('unites.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
	    return view('unites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

	    $data=$request->all();

	    $c = new CustomFunction();

	    if(empty($data['reference'])):
		    $reference = $c->setReference('Un', [$data['name']], 4, "numbers");
		    $data['reference'] = $reference;
	    endif;

	    $this->modelRepository->store($data);

	    $redirect = redirect()->route('unite.index');

	    return $redirect->withOk('l\'Unité a été enregistré');
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

	    return view('unites.show', compact('data'));
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

	    return view('unites.edit', compact('data'));
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
	    return redirect()->route('unite.show', $id)->withOk('l\'Unité a été modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        //
	    $data = $this->modelRepository->getById($id);
	    if($data->active == true):
		    if($data->Produits()->count()):
			    return redirect()->route('unite.show', ['id' => $id])->withWarning('L\'unité est déja utilisée dans un produit');
		    endif;
	    endif;
	    $data->active = !$data->active;
	    $data->save();

	    return redirect()->route('unite.show', ['id' => $id])->withOk('l\'Unité a été modifié');
    }
}
