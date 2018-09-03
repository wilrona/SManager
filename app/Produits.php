<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    //

	protected $fillable = ['reference', 'name', 'description', 'bundle', 'prix', 'active', 'famille_id', 'unite_id'];

	protected $table = 'produits';


	public function Famille(){
		return $this->belongsTo('App\Famille', 'famille_id', 'id');
	}

	public function Unite(){
		return $this->belongsTo('App\Unite', 'unite_id', 'id');
	}

	public function ProduitBundle(){
		return $this->belongsToMany('App\Produits', 'bundle_produit', 'bundle_id', 'produit_id')->withPivot('quantite', 'prix')->withTimestamps();
	}

	public function GroupePrix(){
		return $this->hasMany('App\GroupePrix', 'produit_id', 'id');
	}

	public function Series(){
		return $this->hasMany('App\Serie', 'produit_id', 'id');
	}

	public function ligne_transfert(){
		return $this->hasMany('App\LigneTransfert', 'produit_id', 'id');
	}

	public function EcritureStock(){
		return $this->hasMany( 'App\EcritureStock', 'produit_id', 'id');
	}

	public function Commandes(){
		return $this->belongsToMany('App\Commande', 'commande_ligne', 'produit_id', 'commande_id')->withPivot('qte', 'prix', 'devise');
	}




//
//	public function transferts(){
//		return $this->belongsToMany('App\Transferts', 'transferts_produits', 'produit_id', 'transfert_id')->withPivot('prix')->withTimestamps();
//	}
}
