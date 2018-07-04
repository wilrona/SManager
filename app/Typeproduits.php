<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typeproduits extends Model
{
    //

	protected $table = 'typeproduits';

	public function produits(){
		return $this->hasMany('App\Produits', 'typeproduit_id', 'id');
	}

	public function promotions(){
		return $this->hasMany('App\Promotions', 'typeproduit_id', 'id');
	}

	public function precommandes(){
		return $this->belongsToMany('App\Precommande')->withPivot('qte');
	}
}

