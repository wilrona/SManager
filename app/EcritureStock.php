<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcritureStock extends Model
{
    //

	protected $table = 'ecriture_stock';


	protected $fillable = ['type_ecriture', 'quantite','produit_id', 'ordre_transfert_id', 'transfert_id' , 'user_id', 'magasin_id'];

	public function Transfert(){
		return $this->belongsTo('App\Transfert', 'transfert_id', 'id');
	}

	public function User(){
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function Magasin(){
		return $this->belongsTo('App\Magasin', 'magasin_id', 'id');
	}

	public function Produit(){
		return $this->belongsTo('App\Produits', 'produit_id', 'id');
	}

	public function OrdreTransfert(){
		return $this->belongsTo('App\OrdreTransfert', 'ordre_transfert_id', 'id');
	}

	public function Series(){
		return $this->belongsToMany('App\Serie', 'ecriture_stock_serie', 'ecriture_stock_id', 'serie_id');
	}

	public function Commande(){
		return $this->belongsTo('App\Commande', 'commande_id', 'id');
	}

	public function Session(){
		return $this->belongsTo('App\Session', 'session_id', 'id');
	}

}
