<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 16/05/2018
 * Time: 16:17
 */

namespace App\Repositories;

use App\Session;

class SessionRepository extends ResourceRepository
{

	protected $model;

	public function __construct(Session $modelcurrent)
	{
		$this->model = $modelcurrent;
	}


}
