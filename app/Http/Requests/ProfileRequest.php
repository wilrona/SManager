<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProfileRequest extends FormRequest
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

			    'name' => 'required|unique:profiles,name,'.$request->id,
		    ];

	    else:

		    $rules = [
			    //

			    'name' => 'required|unique:profiles',
		    ];

	    endif;


	    return $rules;
    }

    
    public function messages()
    {
		return [
			'name.required' => 'Attribuer un nom à votre profile',
			'name.unique' => 'Un profil du même nom existe déjà',
		];
               
    }
}
