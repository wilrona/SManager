<?php

namespace App\Http\Controllers;

use App\Http\Requests\PointDeVenteRequest;
use App\Repositories\CaisseRepository;
use App\Repositories\MagasinRepository;
use App\Repositories\ParametreRepository;
use App\Repositories\PointDeVenteRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use App\Library\CustomFunction;
use Illuminate\Support\Facades\Hash;
use App\Library\Roles;
use Illuminate\Http\Request;

class UserController extends Controller
{

	protected $modelRepository;
	protected $rolesRepository;
	protected $profilesRepository;
	protected $posRepository;
	protected $parametreRepository;
	protected $caisseRepository;
	protected $magasinRepository;

	protected $custom;
	protected $module;

	public function __construct(RoleRepository $rolesRepository, UserRepository $modelRepository,
		ProfileRepository $profilesRepository, PointDeVenteRepository $point_de_vente_repository,
		ParametreRepository $parametre_repository, CaisseRepository $caisse_repository, MagasinRepository $magasin_repository
	) {
		$this->rolesRepository = $rolesRepository;
		$this->modelRepository = $modelRepository;
		$this->profilesRepository = $profilesRepository;
		$this->posRepository = $point_de_vente_repository;
		$this->parametreRepository = $parametre_repository;
		$this->caisseRepository = $caisse_repository;
		$this->magasinRepository = $magasin_repository;

		$this->custom = new CustomFunction();

		$module = new Roles();
		$this->module = $module->listRoles();
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

		$no_role = array();

		foreach ($this->module as $module):
			if(!$module['role']):
				array_push($no_role, $module['name']);
			endif;
		endforeach;

		return view('users.create', compact('datas', 'allRoles', 'profile', 'sexe', 'pos', 'reference', 'no_role'));
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

		return redirect()->route('user.edit', $data-id)->withOk('Le compte utilisateur a été crée');

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

		$no_role = array();

		foreach ($this->module as $module):
            if(!$module['role']):
                array_push($no_role, $module['name']);
            endif;
        endforeach;

		return view('users.show', compact('data', 'allRoles', 'profile', 'sexe', 'roles_profile', 'pos', 'caisses', 'no_role'));
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

		$caisses = array();

		foreach ($data->Caisses()->get() as $items):
			$save = array();

			$save['caisse_id']  = $items->id;
			$save['caisse_name']  = $items->name;
			$save['caisse_principal']  = $items->pivot->principal;

			array_push($caisses, $save);
		endforeach;

		$magasins = array();

		foreach ($data->Magasins()->get() as $items):
			$save = array();

			$save['mag_id']  = $items->id;
			$save['mag_name']  = $items->name;
			$save['mag_principal']  = $items->pivot->principal;

			array_push($magasins, $save);
		endforeach;

		$no_role = array();

		foreach ($this->module as $module):
			if(!$module['role']):
				array_push($no_role, $module['name']);
			endif;
		endforeach;

		return view('users.edit', compact('allRoles', 'sexe', 'profile', 'data', 'roles_profile', 'pos', 'caisses', 'no_role', 'magasins'));
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

	public function addCaisse(Request $request, $pos_id, $user_id){

		$caisse_pos = array();
		$caisse_principal = array();

		$pos = $this->posRepository->getById($pos_id);
		$user = $this->modelRepository->getById($user_id);
//
		foreach ($user->Caisses()->get() as  $caisse):
			array_push($caisse_pos, $caisse->id);
			if($caisse->pivot->principal):
				array_push($caisse_principal, $caisse->id);
			endif;
		endforeach;

		$datas = $pos->Caisses()->whereHas('pointdevente', function($query){
		    $query->where('principal', '=', 0);
		})->get();

		return view('users.addCaisse', compact('datas', 'pos_id', 'user_id', 'caisse_principal', 'caisse_pos'));
	}

	public function checkCaisse(Request $request){
		$data = $request->all();

		$caisse = $this->caisseRepository->getById($data['id']);

		$response = array(
			'success' => '',
			'error' => '',
			'action' => $data['action']
		);

		if($data['action'] == 'add'):
			if($caisse->etat == 1):
				$response['error'] = 'La caisse est actuellement ouverte. Elle ne peut être ajoutée à l\'utilisateur.';
			else:
				$response['success'] = 'La caisse est ajoutée à l\'utilisateur avec succès.';
			endif;
		else:
			if($caisse->etat == 1):
				$response['error'] = 'La caisse est actuellement ouverte. Elle ne peut être retirée à l\'utilisateur.';
			else:
				$response['success'] = 'La caisse est retirée à l\'utilisateur avec succès.';
			endif;
		endif;


		return response()->json($response);

	}

	public function validCaisse(Request $request, $id){

		$data = $request->all();

		$user = $this->modelRepository->getById($id);

		$user->Caisses()->detach();
        if(isset($data['caisse'])):
            foreach ($data['caisse'] as $caisse_id){
                $caisse = $this->caisseRepository->getById($caisse_id);
                if(in_array($caisse_id, $data['caisse_principal'])):
                    $caisse->Users()->save($user, ['principal' => 1]);
                else:
                    $caisse->Users()->save($user);
                endif;
            }
		endif;

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);
	}

	public function listCaisse($id){

		$users = $this->modelRepository->getById($id);
		$produits = $users->caisses()->get();
		?>
		<table class="table">
			<thead>
			<tr>
				<th class="col-xs-1">#</th>
				<th>Caisse</th>
				<th class="col-xs-2">Principale</th>
			</tr>
			</thead>
			<tbody>
			<?php if($produits):
				foreach($produits as $key => $value):
					?>
					<tr>
						<td><?= $key + 1 ?></td>
						<td><?= $value->name ?></td>
						<td><?php if($value->pivot->principal == 1): ?> oui <?php else: ?> non <?php endif; ?></td>
					</tr>
					<?php
				endforeach;
			else:
				?>
				<tr>
					<td colspan="3">
						<h4 class="text-center" style="margin: 0;">Aucune caisse enregistrée</h4>
					</td>
				</tr>
			<?php endif;?>
			</tbody>
		</table>

		<?php
	}

	public function addMagasin(Request $request, $pos_id, $user_id){

		$mag_pos = array();
		$mag_principal = array();

		$pos = $this->posRepository->getById($pos_id);
		$user = $this->modelRepository->getById($user_id);
//
		foreach ($user->Magasins()->get() as  $item):
			array_push($mag_pos, $item->id);
			if($item->pivot->principal):
				array_push($mag_principal, $item->id);
			endif;
		endforeach;

		$datas = $pos->Magasins()->get();

		return view('users.addMagasin', compact('datas', 'pos_id', 'user_id', 'mag_principal', 'mag_pos'));
	}

	public function checkMagasin(Request $request){
		$data = $request->all();

		$mag = $this->magasinRepository->getById($data['id']);

		$response = array(
			'success' => '',
			'error' => '',
			'action' => $data['action']
		);

		if($data['action'] == 'add'):
			if($mag->etat == 1):
				$response['error'] = 'Le magasin est actuellement ouverte. Il ne peut être ajouté à l\'utilisateur.';
			else:
				$response['success'] = 'Le magasin est ajouté à l\'utilisateur avec succès.';
			endif;
		else:
			if($mag->etat == 1):
				$response['error'] = 'Le magasin est actuellement ouvert. IL ne peut être retiré à l\'utilisateur.';
			else:
				$response['success'] = 'Le magasin est retiré à l\'utilisateur avec succès.';
			endif;
		endif;


		return response()->json($response);

	}

	public function validMagasin(Request $request, $id){

		$data = $request->all();

		$user = $this->modelRepository->getById($id);

		$user->Magasins()->detach();
		if(isset($data['mag'])):
			foreach ($data['mag'] as $magasin_id){
				$magasin = $this->magasinRepository->getById($magasin_id);
				if(isset($data['mag_principal']) && in_array($magasin_id, $data['mag_principal'])):
					$magasin->Users()->save($user, ['principal' => 1]);
				else:
					$magasin->Users()->save($user);
				endif;
			}
		endif;

		return response()->json(['success'=>'Your enquiry has been successfully submitted! ']);
	}

	public function listMagasin($id){

		$users = $this->modelRepository->getById($id);
		$produits = $users->Magasins()->get();
		?>
        <table class="table">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Magasin</th>
                <th class="col-xs-2">Principale</th>
            </tr>
            </thead>
            <tbody>
			<?php if($produits):
				foreach($produits as $key => $value):
					?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $value->name ?></td>
                        <td><?php if($value->pivot->principal == 1): ?> oui <?php else: ?> non <?php endif; ?></td>
                    </tr>
					<?php
				endforeach;
			else:
				?>
                <tr>
                    <td colspan="3">
                        <h4 class="text-center" style="margin: 0;">Aucun magasin enregistrée</h4>
                    </td>
                </tr>
			<?php endif;?>
            </tbody>
        </table>

		<?php
	}


	public function active($id){

		$user = $this->modelRepository->getById($id);
		$user->active = !$user->active;
		$user->save();

		return redirect()->route('user.show', ['id' => $id])->withOk('Le compte utilisateur a été modifié');
	}

}
