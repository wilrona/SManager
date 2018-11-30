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
//			    'famille_id' => 'required',
			    'ville_id' => 'required',
			    'quartier' => 'required',
			    'phone' => 'required',
			    'sexe' => 'required',
			    'nationalite' => 'required',
			    'profession' => 'required',
			    'dateCNI' => 'required',
			    'noCNI' => 'required',

		    ];
	    else:
		    $rules = [
			    'nom' => 'required',
			    'dateNais' => 'required',
			    'email' => 'required|unique:clients',
//			    'famille_id' => 'required',
			    'ville_id' => 'required',
			    'quartier' => 'required',
			    'phone' => 'required',
			    'sexe' => 'required',
			    'nationalite' => 'required',
			    'profession' => 'required',
			    'dateCNI' => 'required',
			    'noCNI' => 'required',
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
			'dateNais.required' => 'Le champ date de naissance est obligatoire',
//			'famille_id.required' => 'Le champ de la famille de client est obligatoire',
			'phone.required' => 'Le champ téléphone principal est obligatoire',
		    'ville_id.required' => 'Le champ ville est obligatoire',
		    'quartier.required' => 'Le champ quartier est obligatoire',
		    'sexe.required' => 'Le champ sexe est obligatoire',
		    'nationalite.required' => 'Le champ nationalité est obligatoire',
		    'profession.required' => 'Le champ profession est obligatoire',
		    'noCNI.required' => 'Le champ numero de CNI est obligatoire',
		    'dateCNI.required' => 'Le champ date de delivrance est obligatoire',

	    ];
    }
}
