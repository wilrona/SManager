<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    //

	protected $table = 'familles';

	protected $fillable = ['name','reference','active', 'type'];

	public function Produits(){
		return $this->hasMany('App\Produits', 'famille_id', 'id');
	}

	public function Clients(){
		return $this->hasMany('App\Client', 'famille_id', 'id');
	}

	public function GroupePrix(){
		return $this->hasMany('App\GroupePrix', 'famille_id', 'id');
	}
}
