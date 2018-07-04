<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 16/05/2018
 * Time: 16:17
 */

namespace App\Repositories;

use App\Precommande;

class PrecommandeRepository
{

	protected $model;

	public function __construct(Precommande $modelcurrent)
	{
		$this->model = $modelcurrent;
	}

	public function saveValid(Precommande $modelcurrent)
	{
		$modelcurrent->statut = 1;
		$modelcurrent->save();
	}

	private function save(Precommande $modelcurrent, Array $inputs)
	{
		$modelcurrent->reference = $inputs['reference'];
		$modelcurrent->importe = false;
		$modelcurrent->typeproduit_id = $inputs['typeproduit_id'];

		$modelcurrent->save();
	}

	public function getAllWhere($attribut = null, $condition = null, $value = null){

		$query = $this->model;

		if($attribut && $condition && $value):
			$query = $query->where($attribut, $condition, $value);
		endif;

		return $query->get();

	}

	public function firstByAttribut($attribut, $condition, $value){

		$query = $this->model->where($attribut, $condition,  $value);

		return $query->first();
	}

	public function getPaginate($n)
	{
		return $this->model->paginate($n);
	}
//
	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

}
