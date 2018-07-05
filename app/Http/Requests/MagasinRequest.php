<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MagasinRequest extends FormRequest
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
		    'name' => 'required'
	    ];

	    if(isset($request->transite) && $request->transite != null):
	    	if($request->transite == 1):
				if(isset($request->id) && $request->id != null)	:
					$rule['transite'] = 'required|unique:magasins,transite,'.$request->id;
				else:
			        $rule['transite'] = 'required|unique:magasins';
		        endif;
		    endif;
	    endif;

	    if (isset($request->id) && $request->id != null):
		    $rule['reference'] = 'unique:magasins,reference,'.$request->id;
	    else:
		    $rule['reference'] = 'required|unique:magasins';
	    endif;

        return $rule;
    }

    public function messages() {
	    return [
			'transite.unique' => 'Il existe déja un magasin de transite définie dans le système',
			'reference.required' => 'La configuration des numéros de séquence pour la reference des magasins n\'a pas été effectué.'
	    ];
    }
}
