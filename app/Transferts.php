<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transferts extends Model
{
    //
	protected $table = 'transferts';

	public function pos_vendeur(){
		return $this->belongsTo( 'App\PointDeVente', 'id_point_de_vente_vendeur', 'id');
	}
	public function pos_client(){
		return $this->belongsTo( 'App\PointDeVente', 'id_point_de_vente_client', 'id');
	}

	public function vendeur(){
		return $this->belongsTo( 'App\User', 'vendeur_id', 'id');
	}

	public function parent(){
		return $this->belongsTo( 'App\Transferts', 'parent_id', 'id');
	}

	public function enfants(){
		return $this->hasMany( 'App\Transferts', 'parent_id', 'id');
	}

	public function precommande(){
		return $this->belongsTo( 'App\Precommande', 'precommande_id', 'id');
	}

	public function client(){
		return $this->belongsTo( 'App\Client', 'client_id', 'id');
	}

	public function produits(){
		return $this->belongsToMany('App\Produits', 'transferts_produits', 'transfert_id', 'produit_id')->withPivot('prix')->withTimestamps();
	}

	public function transactions(){
		return $this->hasMany( 'App\Transactions', 'transaction_id', 'id');
	}

}
