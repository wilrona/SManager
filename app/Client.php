<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //

	protected $table = 'clients';

	protected $fillable = ['nom','reference','prenom', 'dateNais', 'display_name', 'adresse', 'phone', 'phone_un', 'phone_deux', 'ville',  'email',  'active', 'famille_id', 'contact_id'];

	public function GroupePrix(){
		return $this->hasMany('App\GroupePrix', 'client_id', 'id');
	}

	public function Famille(){
		return $this->belongsTo('App\Famille', 'famille_id', 'id');
	}

}
