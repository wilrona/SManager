<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 16/05/2018
 * Time: 16:17
 */

namespace App\Repositories;

use App\TransfertFond;

class TransfertFondRepository extends ResourceRepository
{

	protected $model;

	public function __construct(TransfertFond $modelcurrent)
	{
		$this->model = $modelcurrent;
	}


}
