<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupePrix extends Model
{
    //

	protected $table = 'groupe_prix';

	protected $fillable = ['produit_id','famille_id','client_id', 'type_client', 'type_prix', 'valeur', 'quantite_min', 'date_debut', 'date_fin', 'active'];

	public function Produit(){
		return $this->belongsTo('App\Produits', 'produit_id', 'id');
	}

	public function Famille(){
		return $this->belongsTo('App\Famille', 'famille_id', 'id');
	}

	public function Client(){
		return $this->belongsTo('App\Client', 'client_id', 'id');
	}
}
