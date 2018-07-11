<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transferts extends Model
{
    //
	protected $table = 'ordre_transfert';


	protected $fillable = ['reference', 'motif', 'statut_doc', 'statut_exp', 'statut_recept', 'pos_dmd_id', 'mag_dmd_id', 'pos_appro_id', 'mag_appro_id'];

	public function pos_dmd(){
		return $this->belongsTo( 'App\PointDeVente', 'pos_dmd_id', 'id');
	}
	public function pos_appro(){
		return $this->belongsTo( 'App\PointDeVente', 'pos_appro_id', 'id');
	}

	public function magasin_dmd(){
		return $this->belongsTo( 'App\Magasin', 'mag_dmd_id', 'id');
	}

	public function magasin_appro(){
		return $this->belongsTo( 'App\Magasin', 'mag_appro_id', 'id');
	}

	public function ligne_transfert(){
		return $this->hasMany('App\LigneTransfert', 'transfert_id', 'id');
	}


//	public function vendeur(){
//		return $this->belongsTo( 'App\User', 'vendeur_id', 'id');
//	}

//	public function parent(){
//		return $this->belongsTo( 'App\Transferts', 'parent_id', 'id');
//	}
//
//	public function enfants(){
//		return $this->hasMany( 'App\Transferts', 'parent_id', 'id');
//	}
//
//	public function precommande(){
//		return $this->belongsTo( 'App\Precommande', 'precommande_id', 'id');
//	}
//
//	public function client(){
//		return $this->belongsTo( 'App\Client', 'client_id', 'id');
//	}

//	public function produits(){
//		return $this->belongsToMany('App\Produits', 'transferts_produits', 'transfert_id', 'produit_id')->withPivot('prix')->withTimestamps();
//	}

//	public function transactions(){
//		return $this->hasMany( 'App\Transactions', 'transaction_id', 'id');
//	}

}
