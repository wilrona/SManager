<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\ProfileRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Role;
use App\Profile;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
	protected $modelRepository;
	protected $roleRepository;

	public function __construct(ProfileRepository $modelRepository, RoleRepository $roleRepository) {
		$this->modelRepository = $modelRepository;
		$this->roleRepository = $roleRepository;
	}

	//
    public function index()
    {
        
        $datas = $this->modelRepository->getWhere()->get();

		return view('profiles.index', compact('datas'));
    }


    public function create(){

		$allRoles = $this->roleRepository->getWhereNotNULL('parent_role', true)->where('name', '!=', 'super_admin')->get();

		return view('profiles.create', compact('allRoles'));
    }
    
    public function store(ProfileRequest $request)
	{
		$data = $request->all();
		unset($data['roles']);

		$profile = $this->modelRepository->store($data);

		if(is_array($request->roles)) {
			$roles = $request->roles;
			foreach ($request->roles as $role):
				$currenrole = $this->roleRepository->getById($role);
				if(!in_array($currenrole->parent_role, $roles)):
					array_push($roles, $currenrole->parent_role);
				endif;
			endforeach;

			$profile->roles()->attach($roles);
		}

		return redirect()->route('profile.index')->withOk("le profile a été créé.");

	}

	public function edit($id){

		$data = $this->modelRepository->getById($id);

		$allRoles = $this->roleRepository->getWhereNotNULL('parent_role', true)->where('name', '!=', 'super_admin')->get();

		$roles_profile = array();

		foreach ($data->roles()->get() as $roles):
			array_push($roles_profile, $roles->id);
		endforeach;

		return view('profiles.edit', compact('allRoles', 'data', 'roles_profile'));
	}

	public function update(ProfileRequest $request, $id){

		$data = $request->all();
		unset($data['roles']);

		$this->modelRepository->update($id, $data);

		$profile = $this->modelRepository->getById($id);
		$profile->roles()->detach();
		if(is_array($request->roles)) {
			$roles = $request->roles;
			foreach ($request->roles as $role):
				$currenrole = $this->roleRepository->getById($role);
				if(!in_array($currenrole->parent_role, $roles)):
					array_push($roles, $currenrole->parent_role);
				endif;
			endforeach;

			$profile->roles()->attach($roles);
		}

		return redirect()->route('profile.show', ['id' => $id])->withOk("Le profile " . $request->input('name') . " a été modifié.");
	}
        
    public function show($id)
	{

		$data = $this->modelRepository->getById($id);

		$allRoles = $this->roleRepository->getWhereNotNULL('parent_role', true)->where('name', '!=', 'super_admin')->get();

		$roles_profile = array();

		foreach ($data->roles()->get() as $roles):
			array_push($roles_profile, $roles->id);
		endforeach;

		return view('profiles.show', compact('data', 'allRoles', 'roles_profile'));
	}
}
