<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference', 'nom', 'prenom', 'password','email', 'ville', 'adresse', 'sexe' ,'phone', 'profile_id', 'pos_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
//    public function pointsdevente(){
//        return $this->belongsToMany('App\PointDeVente', 'points_de_vente_users', 'user_id', 'point_de_vente_id');
//    }

    public function PointDeVente(){
    	return $this->belongsTo('App\PointDeVente', 'pos_id', 'id');
    }

//	public function ventes(){
//		return $this->hasMany('App\Transferts', 'vendeur_id', 'id');
//	}

	public function Roles(){
		return $this->belongsToMany('App\Role');
	}

	public function EcritureStock(){
		return $this->hasMany('App\EcritureStock', 'user__id', 'id');
	}

	public function StoryEcritureStock(){
		return $this->belongsToMany('App\EcritureStock', 'story_transfert_stock', 'user_id', 'ordre_transfert_id')->withPivot('action');
	}

//	public function transactions(){
//		return $this->hasMany( 'App\Transactions', 'user_id', 'id');
//	}


}
