<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 16/05/2018
 * Time: 16:17
 */

namespace App\Repositories;

use App\Client;

class ClientRepository extends ResourceRepository
{

	protected $model;

	public function __construct(Client $modelcurrent)
	{
		$this->model = $modelcurrent;
	}



}
