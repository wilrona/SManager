<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 16/05/2018
 * Time: 16:17
 */

namespace App\Repositories;

use App\Transactions;

class TransactionsRepository
{

	protected $model;

	public function __construct(Transactions $modelcurrent)
	{
		$this->model = $modelcurrent;
	}


	// Enregistrement d'un precommande vers un transfert
	private function save(Transactions $modelcurrent, Array $inputs)
	{
		$modelcurrent->montant = $inputs['montant'];
		$modelcurrent->transfert_id = $inputs['transfert_id'];
		$modelcurrent->user_id = $inputs['user_id'];
		$modelcurrent->type = $inputs['type'];

		$modelcurrent->save();
	}


	public function getAllWhere($attribut = null, $condition = null, $value = null){

		$query = $this->model;

		if($attribut && $condition && $value):
			$query = $query->where($attribut, $condition, $value);
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

	public function store(Array $inputs)
	{
		$model = new $this->model;

		$this->save($model, $inputs);

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
