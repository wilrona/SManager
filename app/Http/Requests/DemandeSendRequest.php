<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DemandeSendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
    	$rules = [
		    'mag_dmd_id' => 'required',
		    'pos_appro_id' => 'required',
	    ];

	    if (isset($request->id) && $request->id != null):
		    $rules['reference'] = 'unique:ordre_transfert,reference,'.$request->id;
	    else:
		    $rules['reference'] = 'required|unique:ordre_transfert';
	    endif;

        return $rules;
    }

    public function messages() {
	    return [
	    	'pos_appro_id.required' => 'le point de vente destinataire est obligatoire.',
	    	'mag_dmd_id.required' => 'Le magasin demandeur est obligatoire.',
	    	'reference.required' => 'La configuration des numéros de séquence pour la reference des demandes de stock n\'a pas été effectué.',
	    ];
    }
}
