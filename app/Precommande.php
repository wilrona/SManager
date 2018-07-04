<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Precommande extends Model
{
    
    protected $fillable = ['montantverse', 'statut', 'id_point_de_vente_destinataire','id_utilisateur_emetteur', 'id_point_de_vente_emetteur', 'numero'];
    
    protected $table = 'precommandes'; 
    
   /* public function produit(){
        return $this->belongsToMany('App\Precommande', 'precommande_type_produits', 'id_precommande', 'id_type_produit');
    }*/
    
    public function produits(){
		return $this->belongsToMany('App\Typeproduits')->withPivot('qte');
    } 

    
    public function user(){
		return $this->belongsTo('App\User', 'id_utilisateur_emetteur', 'id');
   }
   
   public function posemetteur(){
	return $this->belongsTo('App\PointDeVente', 'id_point_de_vente_emetteur', 'id');
                
   }
   public function posdestinataire(){
		return $this->belongsTo('App\PointDeVente', 'id_point_de_vente_destinataire', 'id');
                
   }

   public function transferts(){
   	    return $this->hasMany('App\Transferts', 'precommande_id', 'id');
   }
}
