<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcritureStock extends Model
{
    //

	protected $table = 'ecriture_stock';


	protected $fillable = ['type_ecriture', 'quantite','produit_id', 'ordre_transfert_id', 'transfert_id' , 'user_id', 'magasin_id'];

}
