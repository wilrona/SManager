<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BundleRequest extends FormRequest
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
    public function rules()
    {
        return [
            //
	        'produit_id' => 'required',
	        'quantite' => 'required',
	        'prix' => 'required|integer|min:1'
        ];
    }

    public function messages() {
	    return [
	    	'produit_id.required' => 'Le choix du produit est obligatoire'
	    ];
    }
}
