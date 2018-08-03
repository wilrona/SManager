<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    //

	protected $fillable = ['reference', 'importe', 'produit_id', 'lot_id', 'type'];

	protected $table = 'series';

	public function Magasins(){
		return $this->belongsToMany('App\Magasin', 'stock_serie')->withPivot('mouvement');
	}

	public function Produit(){
		return $this->belongsTo('App\Produits', 'produit_id', 'id');
	}

	public function Lot(){
		return $this->belongsTo('App\Serie', 'lot_id', 'id');
	}

	public function SeriesLots(){
		return $this->hasMany('App\Serie', 'lot_id', 'id');
	}

	public function ligne_serie(){
		return $this->belongsToMany('App\LigneTransfert', 'ligne_ordre_transfert_serie', 'serie_id', 'ligne_id')->withPivot('qte', 'a_recu');
	}

	public function Transferts(){
		return $this->belongsToMany('App\Transfert', 'transfert_serie', 'serie_id', 'transfert_id')->withPivot('ok');
	}

	public function EcriureStocks(){
		return $this->belongsToMany('App\EcritureStock', 'ecriture_stock_serie', 'serie_id', 'ecriture_stock_id');
	}
}
