<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 16/05/2018
 * Time: 16:17
 */

namespace App\Repositories;

use App\Promotions;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Boolean;

class PromotionRepository
{

	protected $model;

	public function __construct(Promotions $modelcurrent)
	{
		$this->model = $modelcurrent;
	}

	private function save(Promotions $modelcurrent, Array $inputs)
	{
		$modelcurrent->libelle = $inputs['libelle'];
		$modelcurrent->description = $inputs['description'];
		$modelcurrent->prix_promo = $inputs['prix_promo'];
		$modelcurrent->date_debut = date('Y-m-d', strtotime($inputs['date_debut']));
		$modelcurrent->active = $inputs['active'];
		$modelcurrent->typeproduit_id = $inputs['typeproduit_id'];
		$modelcurrent->date_fin = date('Y-m-d', strtotime($inputs['date_fin']));

		$modelcurrent->save();
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

	public function active(Promotions $modelcurrent, $activated){
		$modelcurrent->active = $activated;
		$modelcurrent->save();
	}

}
