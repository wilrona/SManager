<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProduitResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
//	        substr($username, 0, 1);

	      $name = explode(' ',$this->name);
	      $i = 0;
	      $word_shot = '';

	      foreach ($name as $ele){
		      if ($i < 2) :
		        $word_shot .= ''. substr($ele, 0, 1);
		      endif;
		      $i += 1;
	      }

	      if (strlen($word_shot) == 1) {
	      	  $word_shot = substr($name[0], 0, 2);
	      }

	      return [
	      	'id' => $this->id,
		      'short' => $word_shot,
		      'name' => $this->name,
		      'reference' => $this->reference,
		      'prix' => $this->prix,
		      'description' => $this->description,
		      'image' => $this->filename ? url('uploads/'.$this->filename) : '',
		      'famille' => [
		      	        'reference' => $this->Famille()->first()->reference,
		      	        'name' => $this->Famille()->first()->name
                    ],
		      'unite' => [
			      'reference' => $this->Unite()->first()->reference,
			      'name' => $this->Unite()->first()->name
		      ]

	      ];
    }
}
