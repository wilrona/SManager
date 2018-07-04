<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Library\CustomFunction;
use App\Repositories\ClientRepository;
use App\Repositories\FamilleRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //

	protected $modelRepository;
	protected $familleRepository;

	public function __construct(ClientRepository $clientRepository, FamilleRepository $famille_repository)
	{
		$this->modelRepository = $clientRepository;
		$this->familleRepository = $famille_repository;

	}


	public function index(){

		$datas = $this->modelRepository->getWhere()->get();

		return view('clients.index', compact('datas'));
	}

	public function create(){

		$famillesData = $this->familleRepository->getWhere()->where([['type', '=', '1'], ['active', '=', 1]])->get();

		$familles = array();

		foreach ($famillesData as $famille):
			$familles[$famille->id] = $famille->name;
		endforeach;

		return view('clients.create', compact('familles'));
	}

	public function show($id){

		$famillesData = $this->familleRepository->getWhere()->where([['type', '=', '1'], ['active', '=', 1]])->get();

		$familles = array();

		foreach ($famillesData as $famille):
			$familles[$famille->id] = $famille->name;
		endforeach;


		$data = $this->modelRepository->getById($id);

		return view('clients.show',  compact('data', 'familles'));
	}

	public function store(ClientRequest $request){

		$data = $request->all();

		$dateNaiss = $data['dateNais'];
		$data['dateNais'] = date('Y-m-d', strtotime($dateNaiss));

		$data['display_name'] = $data['nom'];
		$data['display_name'] .= $data['prenom'] ? ' '.$data['prenom'] : '';

		$c = new CustomFunction();

		if(empty($data['reference'])):
			$reference = $c->setReference('Cl', [$data['nom'], $data['prenom']], 4, "numbers");
			$data['reference'] = $reference;
		endif;

		$user = $this->modelRepository->store($data);

		return redirect()->route('client.show', $user->id)->withOk("Le client " . $user->nom . " ".$user->prenom." a été créé.");
	}

	public function edit($id)
	{
		$data = $this->modelRepository->getById($id);

		$famillesData = $this->familleRepository->getWhere()->where([['type', '=', '1'], ['active', '=', 1]])->get();

		$familles = array();

		foreach ($famillesData as $famille):
			$familles[$famille->id] = $famille->name;
		endforeach;

		return view('clients.edit',  compact('data', 'familles'));
	}

	public function update(ClientRequest $request, $id)
	{

		$data = $request->all();

		$dateNaiss = $data['dateNais'];
		$data['dateNais'] = date('Y-m-d', strtotime($dateNaiss));

		$data['display_name'] = $data['nom'];
		$data['display_name'] .= $data['prenom'] ? ' '.$data['prenom'] : '';

		$this->modelRepository->update($id, $data);

		return redirect()->route('client.show', ['id' => $id])->withOk("Le client " . $request->input('nom') . " " . $request->input('prenom') . " a été modifié.");
	}
}
