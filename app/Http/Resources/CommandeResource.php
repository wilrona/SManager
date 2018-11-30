<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CommandeResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
	    $array = parent::toArray($request);

	    $array['client'] = $this->Client()->first();

	    $count = 0;

	    foreach ( $this->Produits()->get() as $item ) {
		    $count += $item->pivot->qte;
	    }

	    $array['article_count'] = $count;

        return $array;
    }
}
