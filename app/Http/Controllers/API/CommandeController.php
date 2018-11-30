<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CommandeResource;
use App\Repositories\CommandeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommandeController extends Controller
{
    //

	private $commandeRepository;

	public function __construct(CommandeRepository $commande_repository) {

		$this->commandeRepository = $commande_repository;
	}

	public function show(Request $request){

		$data = $request->all();
		$data = $this->commandeRepository->getWhere()->with('Produits', 'Ville')->findOrFail($data['id']);

		return new CommandeResource($data);
	}
}
