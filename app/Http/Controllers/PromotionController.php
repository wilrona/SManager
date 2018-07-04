<?php

namespace App\Http\Controllers;


use App\Http\Requests\PromotionRequest;
use App\Repositories\ProduitRepository;
use App\Repositories\PromotionRepository;
use App\Typeproduits;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    //

	protected $modelRepository;
	protected $produitRepository;

	protected $nbrPerPage = 4;


	public function __construct(PromotionRepository $Repository, ProduitRepository $produit)
	{
		$this->modelRepository = $Repository;
		$this->produitRepository = $produit;
	}


	public function index(){

		$datas = $this->modelRepository->getPaginate($this->nbrPerPage);
		$links = $datas->render();

		return view('promotions.index', compact('datas', 'links'));
	}

	public function create(){

		$typeproduit = Typeproduits::all();

		$select = array();
		foreach ($typeproduit as $type):
			$select[$type['id']] = $type['libelle'];
		endforeach;

		return view('promotions.create', compact('select'));
	}

	public function show($id){

		$typeproduit = Typeproduits::all();

		$select = array();
		foreach ($typeproduit as $type):
			$select[$type['id']] = $type['libelle'];
		endforeach;

		$data = $this->modelRepository->getById($id);

		return view('promotions.show',  compact('data', 'select'));
	}

	public function store(PromotionRequest $request){

		$this->setActive($request);

		$user = $this->modelRepository->store($request->all());

		return redirect('promotions')->withOk("La promotion " . $user->libelle . " a été créé.");
	}

	public function edit($id)
	{
		$data = $this->modelRepository->getById($id);

		$typeproduit = Typeproduits::all();

		$select = array();
		foreach ($typeproduit as $type):
			$select[$type['id']] = $type['libelle'];
		endforeach;

		return view('promotions.edit',  compact('data', 'select'));
	}

	public function update(PromotionRequest $request, $id)
	{
		$this->setActive($request);

		$this->modelRepository->update($id, $request->all());

		return redirect()->route('promotion.show', ['id' => $id])->withOk("La promotion " . $request->input('libelle') . " a été modifié.");
	}

	private function setActive($request)
	{
		if(!$request->has('active'))
		{
			$request->merge(['active' => 0]);
		}
	}

	public function setActived($id){

		$data = $this->modelRepository->getById($id);

		$produit = $this->produitRepository->getById($data->typeproduit_id);

		$input = array();
		$input['prix_promo'] = $data->prix_promo;

		if($data->active):
			$input['promo'] = false;

			$this->produitRepository->activePromo($produit, $input);
			$this->modelRepository->active($data, false);
			$message = "La promotion a été désactivé.";
		else:

			$input['promo'] = true;

			$this->produitRepository->activePromo($produit, $input);

			$this->modelRepository->active($data, true);
			$message = "La promotion a été activé.";
		endif;

		return redirect()->route('promotion.show', ['id' => $id])->withOk($message);
	}

}
