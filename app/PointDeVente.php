<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class PointDeVente extends Model
{
    //
    protected $table = 'point_de_vente';

    protected $fillable = ['reference','name','type','centrale'];
  
//    public function parent() {
//		return $this->belongsTo('App\PointDeVente', 'parent_id', 'id');
//    }

    public function Magasins() {
		return $this->hasMany('App\Magasin', 'pos_id', 'id');
    }

	public function Users(){
		return $this->hasMany('App\User', 'pos_id', 'id');
	}

	public function Caisses(){
		return $this->hasMany('App\Caisse', 'pos_id', 'id');
	}

	public function DemandesTransfert(){
		return $this->hasMany( 'App\Transfert', 'pos_dmd_id', 'id');
	}

	public function ApproTransfert(){
		return $this->hasMany( 'App\Transfert', 'pos_appro_id', 'id');
	}

//
//	public function enfants() {
//		return $this->hasMany('App\PointDeVente', 'parent_id', 'id');
//	}

//	public function stock(){
//		return $this->belongsToMany('App\Produits', 'stock', 'point_de_vente_id', 'produit_id')->withPivot('etat')->withTimestamps();
//	}

}
