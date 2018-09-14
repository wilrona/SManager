<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Library\CustomFunction;
use App\Repositories\ClientRepository;
use App\Repositories\FamilleRepository;
use App\Repositories\ParametreRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //

	protected $modelRepository;
	protected $familleRepository;
	protected $parametreRepository;

	protected $custom;

	public function __construct(ClientRepository $clientRepository, FamilleRepository $famille_repository,
	ParametreRepository $parametre_repository)
	{
		$this->modelRepository = $clientRepository;
		$this->familleRepository = $famille_repository;
		$this->parametreRepository = $parametre_repository;

		$this->custom = new CustomFunction();

	}


	public function index(Request $request, $ajax = false){

		if($ajax == true):
			$q = $request->get('q');
			$datas = $this->modelRepository->getWhere()->where('display_name', 'LIKE', '%' . $q . '%')->orWhere('reference', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->get();


			$response = [];

			foreach ($datas as $data):
				$res = [];
				$res['id'] = $data->id;
				$res['text'] = $data->display_name;
				array_push($response, $res);
			endforeach;

			return response()->json($response);

		else:
			$datas = $this->modelRepository->getWhere()->get();
			return view('clients.index', compact('datas'));
		endif;
	}

	public function create(){

		$famillesData = $this->familleRepository->getWhere()->where([['type', '=', '1'], ['active', '=', 1]])->get();

		$familles = array();

		foreach ($famillesData as $famille):
			$familles[$famille->id] = $famille->name;
		endforeach;


		// Initialisation de la reference

		$count = $this->modelRepository->getWhere()->count();
		$coderef = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'clients'],
				['type_config', '=', 'coderef']
			]
		)->first();
		$incref = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'clients'],
				['type_config', '=', 'incref']
			]
		)->first();
		$count += $incref ? intval($incref->value) : 1;
		$reference = $this->custom->setReference($coderef, $count, 4);

		return view('clients.create', compact('familles', 'reference'));
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
