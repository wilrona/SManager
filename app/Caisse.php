<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    //

	protected $table = 'caisses';

	protected $fillable = ['name','reference','etat', 'montantEnCours'];

	public function Magasin() {
		return $this->belongsTo('App\PointDeVente', 'pos_id', 'id');
	}

	public function PointDeVente(){
		return $this->belongsToMany('App\PointDeVente', 'pos_caisse', 'caisse_id', 'pos_id')->withPivot('principal')->withTimestamps();
	}

	public function Users(){
		return $this->belongsToMany('App\User', 'user_caisse', 'caisse_id', 'user_id')->withPivot('principal');
	}
}
