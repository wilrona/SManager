<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //

	protected $table = 'clients';

	protected $fillable = ['nom','reference','prenom', 'dateNais', 'display_name', 'adresse', 'phone', 'phone_un', 'phone_deux',  'email',  'active', 'famille_id', 'contact_id', 'ville_id', 'quartier', 'departement_id', 'region_id', 'etat', 'numeroCompte',
		'nationalite', 'dateCNI', 'noCNI', 'sexe', 'profession', 'repere'];

	public function GroupePrix(){
		return $this->hasMany('App\GroupePrix', 'client_id', 'id');
	}

	public function Famille(){
		return $this->belongsTo('App\Famille', 'famille_id', 'id');
	}

	public function Ville(){
		return $this->belongsTo('App\Region', 'ville_id', 'id');
	}

}
