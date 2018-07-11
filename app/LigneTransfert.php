<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigneTransfert extends Model
{
    //

	protected $table = 'ligne_transfert';


	protected $fillable = ['qte_dmd', 'qte_exp', 'qte_recu', 'type_ligne', 'produit_id', 'transfert_id'];

	public function transfert(){
		return $this->belongsTo('App\Transfert', 'transfert_id', 'id');
	}
	public function produit(){
		return $this->belongsTo('App\Produits', 'produit_id', 'id');
	}

	public function serie_ligne(){
		return $this->belongsToMany('App\Serie', 'ligne_transfert_serie')->withPivot('livre');
	}


}
