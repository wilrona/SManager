<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CaisseRequest extends FormRequest
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
	    $rule = [
		    'name' => 'required',
	    ];


	    if (isset($request->id) && $request->id != null):
		    $rule['reference'] = 'unique:caisses,reference,'.$request->id;
	    else:
		    $rule['reference'] = 'required|unique:caisses';
	    endif;

	    return $rule;
    }

    public function messages() {
	    return [
		    'reference.required' => 'La configuration des numéros de séquence pour la reference des caisses n\'a pas été effectué.'
	    ];
    }
}
