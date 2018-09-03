<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    //

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'reference', 'name', 'transite', 'pos_id'
	];

	protected $table = 'magasins';

	public function PointDeVente(){
		return $this->belongsTo( 'App\PointDeVente', 'pos_id', 'id');
	}

	public function Stock(){
		return $this->belongsToMany('App\Serie', 'stock_serie')->withPivot('mouvement');
	}

	public function DemandesTransfert(){
		return $this->hasMany( 'App\OrdreTransfert', 'mag_dmd_id', 'id');
	}

	public function ApproTransfert(){
		return $this->hasMany( 'App\OrdreTransfert', 'mag_appro_id', 'id');
	}

	public function EcritureStock(){
		return $this->hasMany( 'App\EcritureStock', 'magasin_id', 'id');
	}

	public function Users(){
		return $this->belongsToMany('App\User', 'user_magasin', 'magasin_id', 'user_id')->withPivot('principal');
	}
}
