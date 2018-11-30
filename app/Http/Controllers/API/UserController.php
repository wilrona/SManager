<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CommandeResource;
use App\Repositories\CommandeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
	public $successStatus = 200;
	private $userRepository;
	private $commandeRepository;

	public function __construct(UserRepository $user_repository, CommandeRepository $commande_repository) {
		$this->userRepository = $user_repository;
		$this->commandeRepository = $commande_repository;
	}

	public function login(){
		if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
			$user = Auth::user();
			$success['token'] =  $user->createToken('MyApp')-> accessToken;
			$success['user'] = $user;
			return response()->json(['success' => $success], $this->successStatus);
		}
		else{
			return response()->json(['error'=>'Unauthorised'], 401);
		}
	}


	public function logout(Request $request){
		$accessToken = Auth::user()->token();
		DB::table('oauth_refresh_tokens')
		  ->where('access_token_id', $accessToken->id)
		  ->update(['revoked' => true]);
		$accessToken->revoke();
		return response()->json([], 204);
	}


	public function getCommande(Request $request){

		$data = $request->all();

		$cmd = $this->commandeRepository->getWhere()->with('Produits')->whereHas('StoryAction', function($q) use ($data){
			$q->where('user_id', '=', $data['id']);
		})->whereDate('created_at', '=', date('Y-m-d', strtotime($data['date'])))->orderby('created_at', 'desc')->get();

		return CommandeResource::collection($cmd);
	}

}
