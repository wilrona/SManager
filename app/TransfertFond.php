<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransfertFond extends Model
{
    //
	protected $table = 'transfert_fond';


	protected $fillable = ['reference', 'caisse_receive_id', 'caisse_sender_id', 'montant', 'motif', 'motif_annulation', 'statut', 'code_transfert'];

	public function caisse_receive(){
		return $this->belongsTo( 'App\Caisse', 'caisse_receive_id', 'id');
	}

	public function caisse_sender(){
		return $this->belongsTo( 'App\Caisse', 'caisse_sender_id', 'id');
	}

	public function EcritureCaisse(){
		return $this->hasMany('App\EcritureCaisse', 'transfert_fond_id', 'id');
	}

	public function StoryAction(){
		return $this->belongsToMany('App\User', 'story_action', 'transfert_fond_id', 'user_id')->withPivot('etape_action', 'description')->withTimestamps();
	}

}
