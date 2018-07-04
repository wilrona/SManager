<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    //

	protected $fillable = [
		'name', 'display_name', 'parent_role', 'description'
	];

	public function enfants() {
		return $this->hasMany('App\Role', 'parent_role', 'id');

	}

	public function profiles(){
		return $this->belongsToMany('App\Profile');
	}

	public function users(){
		return $this->belongsToMany('App\User');
	}
}
