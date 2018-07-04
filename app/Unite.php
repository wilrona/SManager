<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    //
	protected $table = 'unites';

	protected $fillable = ['name','reference','active'];

	public function Produits(){
		return $this->hasMany('App\Produits', 'unite_id', 'id');
	}
}
