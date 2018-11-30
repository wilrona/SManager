<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
	protected $table = 'region';

	protected $fillable = [
		'libelle', 'parent_id', 'type'
	];

	public function enfants() {
		return $this->hasMany('App\Region', 'parent_id', 'id');

	}

	public function parent() {
		return $this->belongsTo('App\Region', 'parent_id', 'id');
	}
}
