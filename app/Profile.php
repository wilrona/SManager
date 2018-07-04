<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $fillable = [
        'name', 'description'
    ];
    
    public function roles(){
		return $this->belongsToMany('App\Role');
    }
}
