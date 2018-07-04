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
		'module', 'type_config', 'value', 'long_value'
	];

	protected $table = 'parametres';

}
