<?php

namespace App\Http\Resources;

use App\Client;
use Illuminate\Http\Resources\Json\Resource;

class ClientResource extends Resource
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
	    $array['url_fileCNI1'] = $this->fileCNI1 ? url('uploads/cni/'.$this->fileCNI1 ) : null;
	    $array['url_fileCNI2'] = $this->fileCNI2 ? url('uploads/cni/'.$this->fileCNI2 ) : null;
        return $array;
    }

}
