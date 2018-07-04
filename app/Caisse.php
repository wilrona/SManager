<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    //

	protected $table = 'caisses';

	protected $fillable = ['name','reference','etat', 'montantEnCours', 'pos_id'];

	public function Magasin() {
		return $this->belongsTo('App\PointDeVente', 'pos_id', 'id');
	}
}
