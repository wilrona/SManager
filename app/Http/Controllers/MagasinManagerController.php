<?php

namespace App\Http\Controllers;

use App\Repositories\MagasinRepository;
use App\Repositories\SessionRepository;
use Illuminate\Http\Request;

class MagasinManagerController extends Controller
{
    //

	protected $magasinRepository;
	protected $sessionRepository;

	public function __construct(MagasinRepository $magasin_repository, SessionRepository $session_repository) {

		$this->magasinRepository = $magasin_repository;
		$this->sessionRepository = $session_repository;

	}
}
