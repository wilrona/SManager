<?php

namespace App\Http\Controllers;


use App\Http\Requests\SerieFileRequest;
use App\Http\Requests\SerieRequest;
use App\Repositories\PointDeVenteRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SerieRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SerieController extends Controller
{
    //

	protected $modelRepository;
	protected $produitRepository;
	protected $pointdeventeRepository;

	protected $nbrPerPage = 4;


	public function __construct(SerieRepository $modelRepository, ProduitRepository $produitRepository, PointDeVenteRepository $pointdeventeRepository)
	{
		$this->modelRepository = $modelRepository;
		$this->produitRepository = $produitRepository;
		$this->pointdeventeRepository = $pointdeventeRepository;
	}


	public function index(){

		$datas = $this->modelRepository->getAllWhere('importe', '=', true);

		return view('series.index', compact('datas'));
	}

	public function preview(){

		$datas = $this->modelRepository->getAllWhere('importe', '!=', true);

		$typeproduit = $this->produitRepository->getAllWhere();

		$select = array();
		foreach ($typeproduit as $type):
			$select[$type['id']] = $type['libelle'];
		endforeach;



		return view('series.create', compact('datas', 'produit', 'select'));
	}

	public function show($id){

		$data = $this->modelRepository->getById($id);

		$typeproduit = $this->produitRepository->getAllWhere();

		$select = array();
		foreach ($typeproduit as $type):
			$select[$type['id']] = $type['libelle'];
		endforeach;

		return view('series.show',  compact('data', 'select'));
	}

	public function importation(SerieFileRequest $request){

		// traiter l'import avec le previw save
		$count_error = 0;
		if($request->hasFile('file_import')){

			$data['typeproduit_id'] = $request->typeproduit;

			$path = $request->file('file_import')->getRealPath();

			$datas = Excel::load($path)->get();

			if($datas->count()){

				foreach ($datas as $key => $value){
					$value = json_decode($value, TRUE);
					$data['reference'] = array_values($value)[0];
					if(!empty($value)){
						$check = $this->modelRepository->getByAttribut('reference', '=', $value);

						if(!$check){
							$this->modelRepository->previewstore($data);
						}else{
							$count_error += 1;
						}

					}
				}
			}

		}

		$return = redirect('series/preview')->withOk("Les numéros de serie ont été importé.");
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

		$datas = $this->modelRepository->getAllWhere('importe', '!=', true);

		$pointdevente = $this->pointdeventeRepository->firstByAttribut('parent_id', '=', null);


		foreach ($datas as $data):
				$this->modelRepository->store($data->id);
				$data->stock()->attach($pointdevente->id);
		endforeach;

		return redirect('series/preview')->withOk("Les numéros de serie ont été validés.");
	}


	public function store(SerieRequest $request){

		$this->modelRepository->previewstore($request->all());

		return redirect('series.preview')->withOk("Le numéro de serie a été créé.");
	}

	public function delete($id){

		$this->modelRepository->destroy($id);

		return redirect('series.preview')->withOk("Le numéro de serie a été créé.");
	}
}
