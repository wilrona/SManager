<?php

namespace App\Http\Controllers;

use App\Repositories\PointDeVenteRepository;
use App\Repositories\TransactionsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    //

	protected $POSRespository;
	protected $TransfertRepository;

	public function __construct(PointDeVenteRepository $POSRespository, TransactionsRepository $TransfertRepository) {
		$this->POSRespository = $POSRespository;
		$this->TransfertRepository = $TransfertRepository;
	}

	public function produits(){

		$currentUser= Auth::user();
		$current_POS = $this->POSRespository->getById($currentUser->id_point_de_vente_encours);

		$datas = $current_POS->stock()->get();

		return view('stocks.produit', compact('datas'));
	}

	public function reception(){
		$currentUser= Auth::user();
		$current_POS = $this->POSRespository->getById($currentUser->id_point_de_vente_encours);

		$datas = $current_POS->transferts_clients()->where('expedition', '>', 0)->get();

		$page = 'reception';

		return view('provisions.index', compact('datas', 'page'));
	}

	public function show($id, $page){

		$data = $this->TransfertRepository->getById($id);

		return view('provisions.show',  compact('data', 'page'));
	}
}
