<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FamilleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
	    return [
		    'id' => $this->id,
		    'name' => $this->name,
		    'reference' => $this->reference

	    ];
    }
}
