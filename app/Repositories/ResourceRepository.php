<?php

namespace App\Repositories;

abstract class ResourceRepository
{

	protected $model;

	public function getPaginate($n)
	{
		return $this->model->paginate($n);
	}

	public function store(Array $inputs)
	{
		return $this->model->create($inputs);
	}

	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->getById($id)->update($inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

	public function getWhere(){

		$query = $this->model;

		return $query;

	}

//	public function getWhere($attribut = null, $condition = null, $value = null){
//
//		$query = $this->model;
//
//		if($attribut && $condition && $value):
//			$query = $query->where($attribut, $condition, $value);
//		endif;
//
//		return $query;
//
//	}

	public function getWhereNotNULL($attribut, $reverse = null){

		$query = $this->model;
		if($reverse):
			$query = $query->whereNull($attribut);
		else:
			$query = $query->whereNotNull($attribut);
		endif;

		return $query;

	}



}