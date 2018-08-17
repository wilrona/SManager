<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    //

	protected $table = 'sessions';


	protected $fillable = ['caisse_id', 'montant_ouverture', 'montant_fermeture', 'last'];

	public function caisse(){
		return $this->belongsTo('App\Caisse', 'caisse_id', 'id');
	}

}
