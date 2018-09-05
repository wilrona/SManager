<?php

namespace App\Http\Controllers;

use App\Repositories\CommandeRepository;
use Illuminate\Http\Request;

class CommandeManagerController extends Controller
{
    //

	protected $modelRepository;

	public function __construct(CommandeRepository $commande_repository) {
		$this->modelRepository = $commande_repository;
	}

	public function index(){


		return view('commande.index', compact(''));

	}

}
