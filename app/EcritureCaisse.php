<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcritureCaisse extends Model
{
    //

	protected $table = 'ecriture_caisse';


	protected $fillable = ['type_ecriture', 'type_paiement', 'devise', 'montant', 'montant_remb', 'libelle', 'session_id', 'caisse_id', 'transfert_fond_id', 'user_id'];

	public function caisse(){
		return $this->belongsTo('App\Caisse', 'caisse_id', 'id');
	}

	public function TransfertFond(){
		return $this->belongsTo('App\TransfertFond', 'transfert_fond_id', 'id');
	}

	public function User(){
		return $this->belongsTo('App\TransfertFond', 'user_id', 'id');
	}

	public function Session(){
		return $this->belongsTo('App\Session', 'session_id', 'id');
	}
}
