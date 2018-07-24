<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
    //

	protected $table = 'transfert';


	protected $fillable = ['position', 'etat', 'ordre_transfert_id'];


	public function OrdreTransfert(){
		return $this->belongsTo( 'App\OrdreTransfert', 'ordre_transfert_id', 'id');
	}

	public function Series(){
		return $this->belongsToMany('App\Serie', 'transfert_serie', 'transfert_id', 'serie_id')->withPivot('ok');
	}
}
