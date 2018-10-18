<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProduitRequest extends FormRequest
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
			    'name' => [
				    'required',
				    $rules['name'] = Rule::unique('produits')->ignore($request->id, 'id')
			    ],
			    'unite_id' => 'required',
			    'famille_id' => 'required',
			    'bundle' => 'required'
		    ];
	    else:
		    $rules = [
			    'name' => [
				    'required',
				    $rules['name'] = Rule::unique('produits')
			    ],
			    'unite_id' => 'required',
			    'famille_id' => 'required',
			    'bundle' => 'required'
		    ];
	    endif;

	    if (isset($request->id) && $request->id != null):
		    $rules['reference'] = 'unique:produits,reference,'.$request->id;
	    else:
		    $rules['reference'] = 'required|unique:produits';
	    endif;

	    if(isset($request->bundle) && $request->bundle == 0):
		    $rules['prix'] = 'required';
	    endif;

	    if(isset($request->id) && $request->filename != null):
		    $rules['filename.*'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
	    endif;

        return $rules;
    }

    public function messages() {
	    return [
			'famille_id.required' => 'Le champ famille de produit est obligatoire',
		    'unite_id.required' => 'Le champ unité de produit est obligatoire',
			'reference.required' => 'La configuration des numéros de séquence pour la reference des produits n\'a pas été effectué.'

	    ];
    }
}
