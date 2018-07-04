<?php

namespace App\Http\Controllers;

use App\Library\Roles;
use App\Repositories\ParametreRepository;
use Illuminate\Http\Request;

class ParamController extends Controller
{
    //

	protected $modelRepository;
	protected $modules;

	public function __construct(ParametreRepository $parametre_repository) {
		$this->modelRepository = $parametre_repository;

		$module = new Roles();
		$this->modules = $module->listRoles();
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
		$datas = $this->modules;

//		var_dump($datas[1]);die();

		return view('params.index', compact('datas'));
	}
}
