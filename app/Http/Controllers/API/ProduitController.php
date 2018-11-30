<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\FamilleResource;
use App\Http\Resources\ProduitResource;
use App\Repositories\FamilleRepository;
use App\Repositories\ProduitRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProduitController extends Controller
{
    //
	private $produitRepository;
	private $familleRepository;

	public function __construct(ProduitRepository $produit_repository, FamilleRepository $famille_repository) {
		$this->produitRepository = $produit_repository;
		$this->familleRepository = $famille_repository;
	}

	public function index(){
		$data = $this->produitRepository->getWhere()->where('active', '=', '1')->with('Famille', 'Unite')->get();
		return ProduitResource::collection($data);
	}

	public function productCategorie(){
		$data = $this->familleRepository->getWhere()->where([['active', '=', '1'], ['type', '=', '0']])->get();
		return FamilleResource::collection($data);
	}

	public function show(Request $request){
		$id = $request->get('id');
		$data = $this->produitRepository->getById($id);
		return new ProduitResource($data);
	}
}
