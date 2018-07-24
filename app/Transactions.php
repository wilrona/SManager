<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    //
	protected $table = 'transactions';

	public function transfert(){
		return $this->belongsTo( 'App\OrdreTransfert', 'transfert_id', 'id');
	}
	public function pos_client(){
		return $this->belongsTo( 'App\User', 'user_id', 'id');
	}

}
