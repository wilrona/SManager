<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigneTransfert extends Model
{
    //

	protected $table = 'ligne_ordre_transfert';


	protected $fillable = ['qte_dmd', 'qte_exp','qte_a_exp', 'qte_recu', 'qte_a_recu' , 'produit_id', 'ordre_transfert_id'];

	public function OrdreTransfert(){
		return $this->belongsTo( 'App\OrdreTransfert', 'ordre_transfert_id', 'id');
	}
	public function produit(){
		return $this->belongsTo('App\Produits', 'produit_id', 'id');
	}

	public function serie_ligne(){
		return $this->belongsToMany('App\Serie', 'ligne_ordre_transfert_serie', 'ligne_id', 'serie_id')->withPivot('qte', 'a_recu');
	}


}
