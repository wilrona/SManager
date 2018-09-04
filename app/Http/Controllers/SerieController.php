<?php

namespace App\Http\Controllers;


use App\Http\Requests\SerieFileRequest;
use App\Http\Requests\SerieRequest;
use App\Repositories\EcritureStockRepository;
use App\Repositories\MagasinRepository;
use App\Repositories\PointDeVenteRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SerieRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SerieController extends Controller
{
    //

	protected $modelRepository;
	protected $produitRepository;
	protected $pointdeventeRepository;
	protected $magasinRepository;

	protected $ecritureStockRepository;

	protected $nbrPerPage = 4;


	public function __construct(SerieRepository $modelRepository, ProduitRepository $produitRepository,
		PointDeVenteRepository $pointdeventeRepository, MagasinRepository $magasin_repository, EcritureStockRepository $ecriture_stock_repository)
	{
		$this->modelRepository = $modelRepository;
		$this->produitRepository = $produitRepository;
		$this->pointdeventeRepository = $pointdeventeRepository;
		$this->magasinRepository = $magasin_repository;
		$this->ecritureStockRepository = $ecriture_stock_repository;
	}


	public function index($single = null){

//		$currentUser= Auth::user();
//		$pos_user = $this->pointdeventeRepository->getWhere()->where('id', '=', $currentUser->pos_id)->first();
//
//		$mags = array();
//		if($pos_user):
//			foreach ($pos_user->Magasins()->get() as $mag):
//				array_push($mags, $mag->id);
//			endforeach;
//		endif;

		$mags = array();

		if($single):
			$currentUser = Auth::user();

			foreach ($currentUser->Magasins()->get() as $mag):
				array_push($mags, $mag->id);
			endforeach;

		else:

			foreach ($this->magasinRepository->getWhere()->where('transite', '=', 0)->get() as $mag):
				array_push($mags, $mag->id);
			endforeach;

		endif;

		$datas = $this->modelRepository->getWhere()->where('importe', '=', 1)->whereHas('Magasins', function ($q) use ($mags){
			$q->whereIn('id', $mags);
		})->has('magasins', '=', 1)->get();

		return view('series.index', compact('datas', 'mags', 'single'));
	}

	public function preview(){

		$datas = $this->modelRepository->getWhere()->where([
			['importe', '!=', 1],
			['type', '!=', 1]
		])->get();

		$typeproduit = $this->produitRepository->getWhere()->where('bundle', '=', 0)->get();

		$select = array();
		foreach ($typeproduit as $type):
			$select[$type->id] = $type->name;
		endforeach;

		$pos_center = $this->pointdeventeRepository->getWhere()->where('centrale', '=', 1)->first();

		$magasin = array();
		foreach ($pos_center->Magasins()->get() as $mag):
			$magasin[$mag->id] = $mag->name;
		endforeach;

		return view('series.create', compact('datas', 'produit', 'select', 'magasin'));
	}

	public function show($id, $single = null){

		$data = $this->modelRepository->getById($id);

		$typeproduit = $this->produitRepository->getWhere()->where('bundle', '=', 0)->get();

		$select = array();
		foreach ($typeproduit as $type):
			$select[$type->id] = $type->name;
		endforeach;

		return view('series.show',  compact('data', 'select', 'single'));
	}

	public function showLot($id, $single = null){

		$data = $this->modelRepository->getById($id);

		$typeproduit = $this->produitRepository->getWhere()->where('bundle', '=', 0)->get();

		$select = array();
		foreach ($typeproduit as $type):
			$select[$type->id] = $type->name;
		endforeach;

		$currentUser= Auth::user();
		$pos_user = $this->pointdeventeRepository->getWhere()->where('id', '=', $currentUser->pos_id)->first();

		$mags = array();
		if($pos_user):
			foreach ($pos_user->Magasins()->get() as $mag):
				array_push($mags, $mag->id);
			endforeach;
		endif;

		return view('series.showLot',  compact('data', 'select', 'mags', 'single'));
	}

	public function import(SerieFileRequest $request){

		// traiter l'import avec le previw save
		$count_error = 0;
		if($request->hasFile('file_import')){

			$data['produit_id'] = $request->produit_id;

			$path = $request->file('file_import')->getRealPath();

			$datas = Excel::load($path)->get();

			if($datas->count()){

				foreach ($datas as $key => $value){
					$value = json_decode($value, TRUE);
					$value = explode(';', array_values($value)[0]);
					$data['reference'] = $value[0];
					$data['lot_id'] = isset($value[1]) && !empty($value[1]) ? $value[1] : null;
					if(!empty($value)){

						// Vérifier que le numéro de serie n'existe pas
						$check_serie = $this->modelRepository->getWhere()->where('reference','=', $data['reference'])->first();

						if(!$check_serie):

							if($data['lot_id']):

								$check_lot = $this->modelRepository->getWhere()->where('reference', '=', $data['lot_id'])->first();
								if(!$check_lot):

									$data_lot = array();
									$data_lot['reference'] = $data['lot_id'];
//									$data_lot['lot_id'] = '';
									$data_lot['type'] = 1;
									$data_lot['produit_id'] = $data['produit_id'];
									$check_lot = $this->modelRepository->store($data_lot);

									$data['lot_id'] = $check_lot->id;

									$lot = $this->modelRepository->getById($check_lot->id);
									$magasin = $this->magasinRepository->getById($request->magasin_id);
									$lot->Magasins()->save($magasin);
								else:
									$data['lot_id'] = $check_lot->id;
								endif;

							endif;

							$serie = $this->modelRepository->store($data);

							$serie = $this->modelRepository->getById($serie->id);
							$magasin = $this->magasinRepository->getById($request->magasin_id);
							$serie->Magasins()->save($magasin);
						else:
							$count_error += 1;
						endif;

					}
				}
			}

		}

		$return = redirect()->route('serie.import')->withOk("Les numéros de serie ont été importé.");
		if($count_error){
			if($count_error == 1){
				$return->withNok("Il y'a ".$count_error." reference qui n'a pas été pris en compte car il existe déja");
			}else{
				$return->withNok("Il y'a ".$count_error." reference(s) qui n'ont pas été pris en compte car ils existent déja.");
			}
		}

		return $return;
	}

	public function validation(){

		$datas = $this->modelRepository->getWhere()->where('importe', '!=', 1)->get();

		$currentUser= Auth::user();

		$item_produit = array();

		foreach ($datas as $data):

			$data->importe = 1;
			$data->save();

			$magasin = $data->stock()->first();

			if($data->type == 0):

				$key_maga = array_search($magasin->id, array_column($item_produit, 'magasin'));

				if(!is_integer($key_maga)):

					$item['magasin'] = $magasin->id;
					$item['produit'] = [];

					$item_nd = array();
					$item_nd['prod'] = $data->produit_id;
					$item_nd['qte'] = 1;

					array_push($item['produit'], $item_nd);
					array_push($item_produit, $item);

				else:

					$key_prod = array_search($data->produit_id, array_column($item_produit[$key_maga]['produit'], 'prod'));

					if(!is_integer($key_prod)):
						$item_nd = array();
						$item_nd['prod'] = $data->produit_id;
						$item_nd['qte'] = 1;

						array_push($item_produit[$key_maga]['produit'], $item_nd);
					else:
						$item_produit[$key_maga]['produit'][$key_prod]['qte'] += 1;
					endif;

				endif;

			endif;

		endforeach;

		foreach ($item_produit as $item):

			$mag = $item['magasin'];

			foreach ($item['produit'] as $iem_2):

				$ecriture_stock = array();
				$ecriture_stock['type_ecriture'] = 0;
				$ecriture_stock['quantite'] = (1 * $iem_2['qte']);
				$ecriture_stock['produit_id'] = $iem_2['prod'];

				$ecriture_stock['user_id'] = $currentUser->id;
				$ecriture_stock['magasin_id'] = $mag;

				$dmdeur = $this->ecritureStockRepository->store($ecriture_stock);

				foreach ($datas as $serie_child):
					if($serie_child->type == 0 && $serie_child->stock()->where('magasin_id', '=', $mag)->count() && $serie_child->produit_id == $iem_2['prod']):
						$serie_child->EcriureStocks()->save($dmdeur);
					endif;
				endforeach;

			endforeach;

		endforeach;

		return redirect()->route('serie.import')->withOk("Les numéros de serie ont été validés.");
	}


	public function store(SerieRequest $request){
		$data = $request->all();
		$data['importe'] = 0;
		$this->modelRepository->store($data);
		return redirect('series.preview')->withOk("Le numéro de serie a été créé.");
	}

	public function delete($id){

		$this->modelRepository->destroy($id);

		return redirect('series.preview')->withOk("Le numéro de serie a été supprimé.");
	}
}
