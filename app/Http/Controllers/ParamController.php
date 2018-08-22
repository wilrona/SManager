<?php

namespace App\Http\Controllers;

use App\Library\Roles;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
use Illuminate\Http\Request;

class ParamController extends Controller
{
    //

	protected $modelRepository;
	protected $posRepository;
	protected $modules;

	public function __construct(ParametreRepository $parametre_repository, PointDeVenteRepository $point_de_vente_repository) {
		$this->modelRepository = $parametre_repository;
		$this->posRepository = $point_de_vente_repository;

		$module = new Roles();
		$this->modules = $module->listRoles();
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
		$datas = $this->modules;

		$datas_values = $this->modelRepository->getWhere()->get();

		$values = array();
		$valeur_saved = array();

		foreach ($datas_values as $value):
			if(!in_array($value->module, $valeur_saved)):
				array_push($valeur_saved, $value->module);
				$values[$value->module] = array();
			endif;

			$values[$value->module][$value->type_config] = $value->value;
		endforeach;

		$pos = $this->posRepository->getWhere()->get();


		return view('params.index', compact('datas', 'values', 'pos'));
	}

	public function update(Request $request, $module){

		$data = $request->all();

		// Enregistrement du code de reférence

		if($module != 'parametrages'):
			$coderef = $this->modelRepository->getWhere()->where(
				[
					['module', '=', $module],
					['type_config', '=', 'coderef']
				]
			)->first();

			if($coderef):
				$coderef->value = $data['coderef'];
				$coderef->save();
			else:
				$saved = array();
				$saved['module'] = $module;
				$saved['type_config'] = 'coderef';
				$saved['value'] = $data['coderef'];
				$this->modelRepository->store($saved);
			endif;

			// Enregistrement du code de reférence

			$coderef = $this->modelRepository->getWhere()->where(
				[
					['module', '=', $module],
					['type_config', '=', 'incref']
				]
			)->first();

			if($coderef):
				$coderef->value = $data['incref'];
				$coderef->save();
			else:
				$saved = array();
				$saved['module'] = $module;
				$saved['type_config'] = 'incref';
				$saved['value'] = $data['incref'];
				$this->modelRepository->store($saved);
			endif;
		endif;

		if($module == 'magasins'):
			$coderef = $this->modelRepository->getWhere()->where(
				[
					['module', '=', $module],
					['type_config', '=', 'transitref']
				]
			)->first();

			if($coderef):
				$coderef->value = $data['transitref'];
				$coderef->save();
			else:
				$saved = array();
				$saved['module'] = $module;
				$saved['type_config'] = 'transitref';
				$saved['value'] = $data['transitref'];
				$this->modelRepository->store($saved);
			endif;
		endif;

		if($module == 'demandes'):
			$coderef = $this->modelRepository->getWhere()->where(
				[
					['module', '=', $module],
					['type_config', '=', 'transfertref']
				]
			)->first();

			if($coderef):
				$coderef->value = $data['transfertref'];
				$coderef->save();
			else:
				$saved = array();
				$saved['module'] = $module;
				$saved['type_config'] = 'transfertref';
				$saved['value'] = $data['transfertref'];
				$this->modelRepository->store($saved);
			endif;
		endif;

		if($module == 'caisses'):
			$coderef = $this->modelRepository->getWhere()->where(
				[
					['module', '=', $module],
					['type_config', '=', 'devise']
				]
			)->first();

			if($coderef):
				$coderef->value = $data['devise'];
				$coderef->save();
			else:
				$saved = array();
				$saved['module'] = $module;
				$saved['type_config'] = 'devise';
				$saved['value'] = $data['devise'];
				$this->modelRepository->store($saved);
			endif;
		endif;

		if($module == 'point_de_vente'):


			$coderef = $this->modelRepository->getWhere()->where(
				[
					['module', '=', $module],
					['type_config', '=', 'pos_center']
				]
			)->first();

			if($coderef):
				if(!empty($data['pos_center']) && $data['pos_center'] != $coderef->value):

					// Enregistrer le nouveau POS Centrale
					$center_pos = $this->posRepository->getById($data['pos_center']);
					$center_pos->centrale = 1;
					$center_pos->save();

					// Enlever l'ancien POS Centrale
					if($coderef->value):
						$center_pos = $this->posRepository->getById($coderef->value);
						$center_pos->centrale = 0;
						$center_pos->save();
					endif;
				endif;
				$coderef->value = $data['pos_center'];
				$coderef->save();
			else:
				$saved = array();
				$saved['module'] = $module;
				$saved['type_config'] = 'pos_center';
				$saved['value'] = $data['pos_center'];
				$this->modelRepository->store($saved);

				if(!empty($data['pos_center'])):
					$center_pos = $this->posRepository->getById($data['pos_center']);
					$center_pos->centrale = 1;
					$center_pos->save();
				endif;
			endif;
		endif;

		return response()->json(['success'=> 'Vos modifications ont été pris en compte !']);
	}
}
