<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    //

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'reference', 'name', 'transite', 'pos_id'
	];

	protected $table = 'magasins';

}
