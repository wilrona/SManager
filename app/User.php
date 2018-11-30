<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use HasApiTokens;


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
		return $this->hasMany('App\EcritureStock', 'user_id', 'id');
	}

	public function StoryEcritureStock(){
		return $this->belongsToMany('App\EcritureStock', 'story_transfert_stock', 'user_id', 'ordre_transfert_id')->withPivot('action');
	}

	public function Caisses(){
		return $this->belongsToMany('App\Caisse', 'user_caisse', 'user_id', 'caisse_id')->withPivot('principal');
	}

	public function EcritureCaisse(){
		return $this->hasMany('App\EcritureCaisse', 'user_id', 'id');
	}

	public function Magasins(){
		return $this->belongsToMany('App\Magasin', 'user_magasin', 'user_id', 'magasin_id')->withPivot('principal');
	}

	public function OrdreTransfertAction(){
		return $this->belongsToMany('App\OrdreTransfert', 'story_action', 'user_id', 'ordre_transfert_id')->withPivot('etape_action', 'description')->withTimestamps();
	}

	public function CommandeAction(){
		return $this->belongsToMany('App\Commande', 'story_action', 'user_id', 'commande_id')->withPivot('etape_action', 'description')->withTimestamps();
	}

	public function  TransfertFondAction(){
		return $this->belongsToMany('App\TransfertFond', 'story_action', 'user_id', 'transfert_fond_id')->withPivot('etape_action', 'description')->withTimestamps();
	}


}
