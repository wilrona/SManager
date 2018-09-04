<?php

namespace App\Http\Controllers;

use App\Repositories\EcritureStockRepository;
use App\Repositories\PointDeVenteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EcritureStockController extends Controller
{
    //

	protected $modelRepository;
	protected $pointdeventeRepository;

	public function __construct(EcritureStockRepository $ecriture_stock_repository, PointDeVenteRepository $point_de_vente_repository) {
		$this->modelRepository = $ecriture_stock_repository;
		$this->pointdeventeRepository = $point_de_vente_repository;
	}

	public function index(){

		$currentUser= Auth::user();
//		$pos_user = $this->pointdeventeRepository->getWhere()->where('id', '=', $currentUser->pos_id)->first();

		$mags = array();
		foreach ($currentUser->Magasins()->get() as $mag):
			array_push($mags, $mag->id);
		endforeach;


		$datas = $this->modelRepository->getWhere()->whereHas('Magasin', function ($q) use ($mags){
			$q->whereIn('id', $mags);
		})->orderBy('created_at', 'desc')->get();

		return view('ecriturestock.index', compact('datas'));

	}

	public function serie($ecriture_id){

		$data = $this->modelRepository->getById($ecriture_id);

		return view('ecriturestock.serie', compact('data'));

	}
}
