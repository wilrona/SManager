<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ClientResource;
use App\Http\Resources\RegionResource;
use App\Repositories\ClientRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\RegionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CustomFunction;
use Validator;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManagerStatic as Image;

class ClientController extends Controller
{
    //
	private $clientRepository;
	private $regionRepository;
	private $parametreRepository;
	protected $custom;

	public function __construct(ClientRepository $client_repository, RegionRepository $region_repository,
			ParametreRepository $parametre_repository) {
		$this->clientRepository = $client_repository;
		$this->regionRepository = $region_repository;
		$this->parametreRepository = $parametre_repository;

		$this->custom = new CustomFunction();
	}

	public function index (){
		$data = $this->clientRepository->getWhere()->get();

		return ClientResource::collection($data);
	}


	public function listVille(){
		$data = $this->regionRepository->getWhere()->where('type', '=','ville')->orderby('libelle', 'asc')->get();

		return RegionResource::collection($data);
	}

	public function show(Request $request){

		$data = $request->all();
		$data = $this->clientRepository->getById($data['id']);

		return new ClientResource($data);
	}

	public function store(Request $request){

		$data = $request->all();

		$dateNaiss = $data['dateNais'];
		$data['dateNais'] = date('Y-m-d', strtotime($dateNaiss));

		$dateCNI = $data['dateCNI'];
		$data['dateCNI'] = date('Y-m-d', strtotime($dateCNI));

		$data['display_name'] = $data['nom'];
		$data['display_name'] .= $data['prenom'] ? ' '.$data['prenom'] : '';

		$ville = $this->regionRepository->getById($data['ville_id']);

		$data['departement_id'] = $ville->parent_id;

		$data['region_id'] = $ville->parent()->first()->parent_id;


		$rules = [
			'nom' => 'required',
			'dateNais' => 'required',
			'email' => 'required|unique:clients',
//			'famille_id' => 'required',
			'ville_id' => 'required',
			'quartier' => 'required',
			'phone' => 'required',
			'sexe' => 'required',
			'nationalite' => 'required',
			'profession' => 'required',
			'dateCNI' => 'required',
			'noCNI' => 'required',
		];

		$messages = [
			'dateNais.required' => 'Le champ date de naissance est obligatoire',
//			'famille_id.required' => 'Le champ de la famille de client est obligatoire',
			'phone.required' => 'Le champ téléphone principal est obligatoire',
			'ville_id.required' => 'Le champ ville est obligatoire',
			'quartier.required' => 'Le champ quartier est obligatoire',
			'sexe.required' => 'Le champ sexe est obligatoire',
			'nationalite.required' => 'Le champ nationalité est obligatoire',
			'profession.required' => 'Le champ profession est obligatoire',
			'noCNI.required' => 'Le champ numero de CNI est obligatoire',
			'dateCNI.required' => 'Le champ date de delivrance est obligatoire',

		];

		$current_client = null;

		if(isset($data['id']) && $data['id'] != null):

			$current_client = $this->clientRepository->getById($data['id']);

			$data['reference'] = $current_client->reference;

			$rules['reference'] = 'unique:clients,reference,'.$data['id'];
			$rules['email'] = 'required|unique:clients,email,'.$data['id'];

		else:

			$count = $this->clientRepository->getWhere()->count();
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

			$data['reference'] = $reference;

			$rules['reference'] = 'required|unique:clients';
			$rules['email'] = 'required|unique:clients';

		endif;

		if($request->hasFile('fileCNI1')){
			$image = $request->file('fileCNI1');
			$extension = $image->getClientOriginalExtension();
			Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));
			$image = Image::make(sprintf('uploads/cni/%s', $image->getFilename().'.'.$extension))->save();
			$data['fileCNI1'] = $image->getFilename().'.'.$extension;

			if($current_client && $data['fileCNI1'] !== $current_client->fileCNI1):
				File::delete(public_path() . '/uploads/cni/'.$current_client->fileCNI1);
			endif;
		}else{
			$data['fileCNI1'] = '';
		};

		if($request->hasFile('fileCNI2')){
			$image = $request->file('fileCNI2');
			$extension = $image->getClientOriginalExtension();
			Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));
			$image = Image::make(sprintf('uploads/cni/%s', $image->getFilename().'.'.$extension))->save();
			$data['fileCNI2'] = $image->getFilename().'.'.$extension;

			if($current_client && $data['fileCNI2'] !== $current_client->fileCNI2):
				File::delete(public_path() . '/uploads/cni/'.$current_client->fileCNI2);
			endif;
		}else{
			$data['fileCNI2'] = '';
		};

		$validators = Validator::make($data, $rules, $messages);

		$response = array();
		$user = '';

		if($validators->fails()){
			$response['error'] = $validators->errors();

		}else{
			if(isset($data['id']) && $data['id'] != null) :
				$this->clientRepository->update($data['id'], $data);
				$user = $this->clientRepository->getById($data['id']);
			else:
				$user = $this->clientRepository->store($data);
				$user = $this->clientRepository->getById($user->id);
			endif;
			$response['success'] = 'Enregistrement avec succès';
		}

		$response['user'] = $user;

		return response()->json($response);
	}


}
