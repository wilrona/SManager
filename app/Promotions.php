<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    //

	protected $fillable = ['libelle', 'description', 'date_debut', 'date_fin', 'prix_promo', 'active', 'typeproduit_id'];

	protected $table = 'promotions';


	public function type_produit(){
		return $this->belongsTo('App\Typeproduits', 'typeproduit_id', 'id');
	}
}
