<?php

namespace App\Http\Controllers;

use App\Http\Requests\PointDeVenteRequest;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use App\Library\CustomFunction;
use Illuminate\Support\Facades\Hash;
use App\Library\Roles;

class UserController extends Controller
{

	protected $modelRepository;
	protected $rolesRepository;
	protected $profilesRepository;
	protected $posRepository;
	protected $parametreRepository;

	protected $custom;

	public function __construct(RoleRepository $rolesRepository, UserRepository $modelRepository,
		ProfileRepository $profilesRepository, PointDeVenteRepository $point_de_vente_repository,
		ParametreRepository $parametre_repository
	) {
		$this->rolesRepository = $rolesRepository;
		$this->modelRepository = $modelRepository;
		$this->profilesRepository = $profilesRepository;
		$this->posRepository = $point_de_vente_repository;
		$this->parametreRepository = $parametre_repository;

		$this->custom = new CustomFunction();
	}

	public function runSeedRole(){

		$roles_save = new Roles();
		$roles_save = $roles_save->listRoles();
		foreach ($roles_save as $role):

			$current_role = $this->rolesRepository->getWhere()->where('name', '=', $role['name'])->first();
			$inputs = array();
			$inputs['name'] = $role['name'];
			$inputs['display_name'] = $role['display_name'];
			$inputs['description'] = $role['description'];
			if(!$current_role):

				$current_role = $this->rolesRepository->store($inputs);
				$current_role = $this->rolesRepository->getById($current_role->id);
			else:
				$this->rolesRepository->update($current_role->id, $inputs);
			endif;

			$childs = $role['child'];

			foreach ($childs as $child):

				$exist_child = $this->rolesRepository->getWhere()->where('name', '=', $child['name'])->first();
				$inputs_child = array();
				$inputs_child['name'] = $child['name'];
				$inputs_child['display_name'] = $child['display_name'];
				$inputs_child['description'] = $child['description'];
				$inputs_child['parent_role'] = $current_role->id;
				if(!$exist_child):
					$this->rolesRepository->store($inputs_child);
				else:
					$this->rolesRepository->update($exist_child->id, $inputs_child);
				endif;

			endforeach;

		endforeach;

	}

	public function index()
	{
//		$datas = $this->modelRepository->getWhere()->whereHas('roles', function ($q){
//			$q->where('name', '!=', 'super_admin');
//		})->get();

		$datas = $this->modelRepository->getWhere()->get();

		return view('users.index', compact('datas'));
	}

	public function create(){

		$allRoles = $this->rolesRepository->getWhereNotNULL('parent_role', true)->where('name', '!=', 'super_admin')->get();
		$profils = $this->profilesRepository->getWhere()->get();

		$sexe = array(
			'm' => 'Masculin',
			'f' => 'Féminin'
		);

		$profile = array();
		foreach ($profils as $item):
			$profile[$item->id] = $item->name.' ('.$item->roles()->count().' role(s))';
		endforeach;


		$pointDeVente = $this->posRepository->getWhere()->get();
		$pos = array();
		foreach ($pointDeVente as $item):
			$pos[$item->id] = $item->name;
		endforeach;

		// Initialisation de la reference de l'utilisateur

		$count = $this->modelRepository->getWhere()->count();
		$coderef = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'users'],
				['type_config', '=', 'coderef']
			]
		)->first();
		$incref = $this->parametreRepository->getWhere()->where(
			[
				['module', '=', 'users'],
				['type_config', '=', 'incref']
			]
		)->first();
		$count += $incref ? intval($incref->value) : 0;
		$reference = $this->custom->setReference($coderef, $count, 4);

		return view('users.create', compact('datas', 'allRoles', 'profile', 'sexe', 'pos', 'reference'));
	}



	public function store(UserRequest $request)
	{
		$data = $request->all();
		unset($data["roles"]);
		unset($data["password_confirmation"]);

		$c = new CustomFunction();

		if(empty($data['password'])):
			$data["password"] = Hash::make($c->randomPassword(7,1,"lower_case,upper_case,numbers"));
		else:
			$data["password"] = Hash::make($data["password"]);
		endif;

		$user = $this->modelRepository->store($data);

		if($data['profile_id']):
			$profile = $this->profilesRepository->getById($data['profile_id']);
			$user->roles()->attach($profile->roles()->get());
		else:
			if(is_array($request->roles)) {
				$roles = $request->roles;
				foreach ($request->roles as $role):
					$currenrole = $this->rolesRepository->getById($role);
					if(!in_array($currenrole->parent_role, $roles)):
						array_push($roles, $currenrole->parent_role);
					endif;
				endforeach;

				$user->roles()->attach($roles);
			}
		endif;

		// Pensez à renvoyer un mail à l'utilisateur pour recevoir son mot de passe

		return redirect('settings/users')->withOk('Le compte utilisateur a été crée');

	}

	public function show($id)
	{
		$allRoles = $this->rolesRepository->getWhereNotNULL('parent_role', true)->where('name', '!=', 'super_admin')->get();
		$profils = $this->profilesRepository->getWhere()->get();

		$sexe = array(
			'm' => 'Masculin',
			'f' => 'Féminin'
		);

		$profile = array();
		foreach ($profils as $item):
			$profile[$item->id] = $item->name.' ('.$item->roles()->count().' role(s))';
		endforeach;

		$data = $this->modelRepository->getById($id);

		$roles_profile = array();

		foreach ($data->roles()->get() as $roles):
			array_push($roles_profile, $roles->id);
		endforeach;

		$pointDeVente = $this->posRepository->getWhere()->get();
		$pos = array();
		foreach ($pointDeVente as $item):
			$pos[$item->id] = $item->name;
		endforeach;

		return view('users.show', compact('data', 'allRoles', 'profile', 'sexe', 'roles_profile', 'pos'));
	}

	public function edit($id)
	{

		$allRoles = $this->rolesRepository->getWhereNotNULL('parent_role', true)->where('name', '!=', 'super_admin')->get();
		$profils = $this->profilesRepository->getWhere()->get();

		$sexe = array(
			'm' => 'Masculin',
			'f' => 'Féminin'
		);

		$profile = array();
		foreach ($profils as $item):
			$profile[$item->id] = $item->name.' ('.$item->roles()->count().' role(s))';
		endforeach;

		$data = $this->modelRepository->getById($id);

		$roles_profile = array();

		foreach ($data->roles()->get() as $roles):
			array_push($roles_profile, $roles->id);
		endforeach;

		$pointDeVente = $this->posRepository->getWhere()->get();
		$pos = array();
		foreach ($pointDeVente as $item):
			$pos[$item->id] = $item->name;
		endforeach;

		return view('users.edit', compact('allRoles', 'sexe', 'profile', 'data', 'roles_profile', 'pos'));
	}

	public function update(UserRequest $request, $id){

		$data = $request->all();
		unset($data["roles"]);
		unset($data["password_confirmation"]);

		$user = $this->modelRepository->getById($id);

		if(!empty($data['password'])):
			$data["password"] = Hash::make($data["password"]);
			// Pensez à renvoyer un mail à l'utilisateur pour recevoir son nouveau mot de passe
		else:
			$data['password'] = $user->password;
		endif;

		$user = $this->modelRepository->getById($id);
		$user->roles()->detach();

		if($user->profile_id != $data['profile_id']):
			$profile = $this->profilesRepository->getById($data['profile_id']);
			$user->roles()->attach($profile->roles()->get());
		else:
			if(is_array($request->roles)) {
				$roles = $request->roles;
				foreach ($request->roles as $role):
					$currenrole = $this->rolesRepository->getById($role);
					if(!in_array($currenrole->parent_role, $roles)):
						array_push($roles, $currenrole->parent_role);
					endif;
				endforeach;

				$user->roles()->attach($roles);
			}
		endif;

		$this->modelRepository->update($id, $data);


		return redirect()->route('user.show', ['id' => $id])->withOk('Le compte utilisateur a été modifié');

	}


	public function active($id){

		$user = $this->modelRepository->getById($id);
		$user->active = !$user->active;
		$user->save();

		return redirect()->route('user.show', ['id' => $id])->withOk('Le compte utilisateur a été modifié');
	}

}
