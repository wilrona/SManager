<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    //

	protected $table = 'sessions';


	protected $fillable = ['caisse_id', 'montant_ouverture', 'montant_fermeture', 'last', 'user_id', 'magasin_id'];

	public function caisse(){
		return $this->belongsTo('App\Caisse', 'caisse_id', 'id');
	}

	public function EcritureCaisse(){
		return $this->hasMany('App\EcritureCaisse', 'session_id', 'id');
	}

	public function EcritureStock(){
		return $this->hasMany('App\EcritureStock', 'session_id', 'id');
	}

	public function magasin(){
		return $this->belongsTo('App\Magasin', 'magasin_id', 'id');
	}

	public function user(){
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function commandes(){
		return $this->belongsToMany('App\Commande', 'commande_session', 'session_id', 'commande_id')->withTimestamps();
	}

}
