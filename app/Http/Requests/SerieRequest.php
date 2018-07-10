<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SerieRequest extends FormRequest
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
			    //

			    'reference' => 'required|unique:series,reference,'.$request->id,
		    ];

	    else:

		    $rules = [
			    //

			    'reference' => 'required|unique:series',
		    ];

	    endif;

	    $rules['produit_id'] = 'required';
	    $rules['magasin_id'] = 'required';


	    return $rules;
    }

    public function messages() {
	    return [
	    	'produit_id.required' => 'La selection du produit est obligatoire',
	    	'magasin_id.required' => 'La selection du produit est obligatoire'
	    ];
    }
}
