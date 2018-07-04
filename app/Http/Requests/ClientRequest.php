<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
	    if (isset($request->id) && $request->id != null):
		    $rules = [
			    'nom' => 'required',
			    'dateNais' => 'required',
			    'email' => 'required|unique:clients,email,'.$request->id,
			    'ville' => 'required',
			    'famille_id' => 'required'

		    ];
	    else:
		    $rules = [
			    'nom' => 'required',
			    'dateNais' => 'required',
			    'email' => 'required|unique:clients',
			    'ville' => 'required',
			    'famille_id' => 'required'
		    ];
	    endif;

	    if(isset($request->reference) && $request->reference != null):
		    if (isset($request->id) && $request->id != null):
			    $rules['reference'] = 'unique:clients,reference,'.$request->id;
		    else:
			    $rules['reference'] = 'required|unique:clients';
		    endif;
	    endif;

        return $rules;
    }

    public function messages() {
	    return [
			'dateNais.required' => 'Le champ date de naissance est obligatoire'

	    ];
    }
}
