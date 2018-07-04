<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 16/05/2018
 * Time: 16:17
 */

namespace App\Repositories;

use App\Produits;

class SerieRepository
{

	protected $model;

	public function __construct(Produits $modelcurrent)
	{
		$this->model = $modelcurrent;
	}

	private function save(Produits $modelcurrent)
	{
		$modelcurrent->importe = true;

		$modelcurrent->save();
	}

	private function presave(Produits $modelcurrent, Array $inputs)
	{
		$modelcurrent->reference = $inputs['reference'];
		$modelcurrent->importe = false;
		$modelcurrent->typeproduit_id = $inputs['typeproduit_id'];

		$modelcurrent->save();
	}

	public function getAllWhere($attribut = null, $condition = null, $value = null, Array $order = []){

		$query = $this->model;

		if($attribut && $condition && $value):
			$query = $query->where($attribut, $condition, $value);
		endif;

		if($order):
			$query = $query->orderBy($order['name'], $order['value']);
		endif;

		return $query->get();

	}

	public function getByAttribut($attribut, $condition, $value){

		$query = $this->model->where($attribut, $condition,  $value);

		return $query->first();
	}

	public function getPaginate($n)
	{
		return $this->model->paginate($n);
	}

	public function store($id)
	{

		$this->save($this->getById($id));
	}

	public function previewstore(Array $inputs)
	{
		$model = new $this->model;

		$this->presave($model, $inputs);

		return $model;
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

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

}
