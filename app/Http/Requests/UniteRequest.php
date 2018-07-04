<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UniteRequest extends FormRequest
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
					    $rules['name'] = Rule::unique('unites')->ignore($request->id, 'id')
				    ]
		    ];
	    else:
		    $rules = [
			    'name' => [
			    	'required',
				    $rules['name'] = Rule::unique('unites')
			    ]
		    ];
	    endif;

	    if(isset($request->reference) && $request->reference != null):
		    if (isset($request->id) && $request->id != null):
			    $rules['reference'] = 'unique:unites,reference,'.$request->id;
		    else:
			    $rules['reference'] = 'required|unique:unites';
		    endif;
	    endif;

        return $rules;
    }
}
