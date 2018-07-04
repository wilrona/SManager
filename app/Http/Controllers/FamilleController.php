<?php

namespace App\Http\Controllers;


use App\Http\Requests\FamilleRequest;
use App\Library\CustomFunction;
use App\Repositories\FamilleRepository;
use Illuminate\Http\Request;

class FamilleController extends Controller
{
	protected $modelRepository;

	public function __construct(FamilleRepository $modelRepository) {

		$this->modelRepository = $modelRepository;

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
	    return view('familles.create', compact('type'));
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
		return view('familles.create', compact('type'));
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

	    $c = new CustomFunction();

	    if(empty($data['reference'])):
		    if($data['type'] == 0):
			    $type = 'FaPro';
            else:
	            $type = 'FaCli';
		    endif;
		    $reference = $c->setReference($type, [$data['name']], 4, "numbers");
		    $data['reference'] = $reference;
	    endif;

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
