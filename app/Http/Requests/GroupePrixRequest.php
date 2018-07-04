<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class GroupePrixRequest extends FormRequest
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
    		'type_remise' => 'required',
    		'remise' => 'required|integer|min:1',
    		'prix' => 'required|integer|min:1'
	    ];

    	if($request->type_client == 0):
	        $rules['client_id'] = 'required';
    	else:
		    $rules['famille_id'] = 'required';
    	endif;

    	if($request->type_remise == 1):
		    $rules['remise'] = 'integer|between:1,100';
	    endif;
	    if($request->date_debut !== null):
		    $rules['date_debut'] = 'date|after:' . date('d-m-Y');
		    if($request->date_fin !== null):
			    $rules['date_fin'] = 'date|after:date_debut';
		    endif;
	    endif;

        return $rules;
    }

    public function messages() {
	    return [
	    	'remise.between' => 'Vous selectionnez le pourcentage. La remise doit etre comprise en 1 et 100'
	    ];
    }
}
