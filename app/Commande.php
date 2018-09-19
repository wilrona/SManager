<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    //

	protected $table = 'commande';

	protected $fillable = ['reference','total', 'subtotal', 'client_id', 'etat', 'codeCmd', 'point_de_vente_id', 'devise'];

	public function Client(){
		return $this->belongsTo('App\Client', 'client_id', 'id');
	}

	public function PointDeVente(){
		return $this->belongsTo('App\PointDeVente', 'point_de_vente_id', 'id');
	}

	public function Produits(){
		return $this->belongsToMany('App\Produits', 'commande_ligne', 'commande_id', 'produit_id')->withPivot('qte', 'prix', 'devise');
	}
}
