<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigneTransfert extends Model
{
    //

	protected $table = 'ligne_transfert';


	protected $fillable = ['qte_dmd', 'qte_exp','qte_a_exp', 'qte_recu', 'qte_a_recu' , 'produit_id', 'transfert_id'];

	public function transfert(){
		return $this->belongsTo('App\Transferts', 'transfert_id', 'id');
	}
	public function produit(){
		return $this->belongsTo('App\Produits', 'produit_id', 'id');
	}

	public function serie_ligne(){
		return $this->belongsToMany('App\Serie', 'ligne_transfert_serie', 'ligne_id', 'serie_id')->withPivot('livre', 'exp', 'qte', 'recu');
	}


}
