<?php

namespace App\Http\Controllers;

use App\Repositories\CaisseRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaisseManagerController extends Controller
{
    //

	protected $modelRepository;
	protected $userRepository;

	public function __construct(CaisseRepository $caisse_repository, UserRepository $user_repository) {

		$this->modelRepository = $caisse_repository;
		$this->userRepository = $user_repository;

	}

	public function index(){

		$current_user = Auth::user();

		$pos = $current_user->PointDeVente()->first();

		$datas_pos = $pos->Caisses()->where('principal', '=', 1)->get();

		$datas = $current_user->Caisses()->get();


		return view('caisseManager.index', compact('datas', 'datas_pos'));
	}
}
