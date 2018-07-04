<?php

namespace App\Http\Controllers;

use App\Http\Requests\MagasinRequest;
use App\Library\CustomFunction;
use App\Repositories\MagasinRepository;
use App\Repositories\PointDeVenteRepository;
use Illuminate\Http\Request;

class MagasinController extends Controller
{
	protected $modelRepository;
	protected $posRepository;
	protected $type;
	protected $custom;
	protected $listPOS;

	public function __construct(MagasinRepository $modelRepository, PointDeVenteRepository $point_de_vente_repository) {
		$this->modelRepository = $modelRepository;
		$this->posRepository = $point_de_vente_repository;
		$this->type = array(
			0 => 'Magasin Normal',
			1 => 'Magasin de transit'
		);
		$this->custom = new CustomFunction();
		$this->listPOS = $point_de_vente_repository->getWhere()->get();

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

		return view('magasins.create', compact('type', 'pos'));
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

	    if(empty($data['reference'])):

		    $name = $data['name'];
		    $prefix = 'Mag';
		    $number = 4;

		    if($data['transite'] == 1):
			    $name = '';
		        $prefix = 'Transit';
		        $number = 0;
	        endif;

		    $reference = $this->custom->setReference($prefix, [$name], $number, "numbers");
		    $data['reference'] = $reference;
	    endif;

	    if($data['transite'] == 1):
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

	    return view('magasins.show', compact('data', 'type', 'pos'));
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

	    if($data['transite'] == 1):
		    $data['pos_id'] = null;
	    endif;

	    $this->modelRepository->update($id, $data);

	    return redirect()->route('magasin.show', $id)->withOk('Le magasin a été modifié');
    }
}
