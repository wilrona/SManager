<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 16/05/2018
 * Time: 16:17
 */

namespace App\Repositories;

use App\Library\CustomFunction;
use App\OrdreTransfert;

class ProvisionsRepository
{

	protected $model;

	public function __construct(OrdreTransfert $modelcurrent)
	{
		$this->model = $modelcurrent;
	}


	// Enregistrement d'un precommande vers un transfert
	private function save(OrdreTransfert $modelcurrent, Array $inputs)
	{
		$modelcurrent->qte_total = $inputs['qte'];
		$modelcurrent->montant_total = $inputs['montant'];
		$modelcurrent->id_point_de_vente_vendeur = $inputs['pos_vendeur'];
		$modelcurrent->id_point_de_vente_client = $inputs['pos_acheteur'];
		$modelcurrent->precommande_id = $inputs['precommande_id'];
		$modelcurrent->vendeur_id = $inputs['vendeur'];
		$modelcurrent->type_commande = 1;
		$modelcurrent->nature_transfert = 2;
		$modelcurrent->etat = 0;

		$custon = new CustomFunction();
		$modelcurrent->numero = $custon->NumeroSerie();

		$modelcurrent->save();
	}


	public function getAllWhere($attribut = null, $condition = null, $value = null){

		$query = $this->model->where('nature_transfert', '=', 2);

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
