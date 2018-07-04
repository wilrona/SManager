<?php

namespace App\Http\Controllers;

use App\Repositories\ParametreRepository;
use Illuminate\Http\Request;

class ParamController extends Controller
{
    //

	protected $modelRepository;

	public function __construct(ParametreRepository $parametre_repository) {
		$this->modelRepository = $parametre_repository;
	}


	public function index(){

	}
}
