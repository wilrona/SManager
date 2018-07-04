<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FamilleRequest extends FormRequest
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
		    if($request->type == 0):
			    $rules = [
				    //

				    'name' => [
				        'required',
					    $rules['name'] = Rule::unique('familles')->ignore($request->id, 'id')->where(function($query){
						    return $query->where('type', 0);
					    })
				     ]
			    ];
		    else:
			    $rules = [
				    //

				    'name' => [
					    'required',
					    $rules['name'] = Rule::unique('familles')->ignore($request->id, 'id')->where(function($query){
						    return $query->where('type', 1);
					    })
				    ]
			    ];
		    endif;

	    else:

		    if($request->type == 0):
			    $rules = [
				    //

				    'name' => [
					    'required',
					    $rules['name'] = Rule::unique('familles')->where(function($query){
						    return $query->where('type', 0);
					    })
				    ]
			    ];
		    else:
			    $rules = [
				    //

				    'name' => [
					    'required',
					    $rules['name'] = Rule::unique('familles')->where(function($query){
						    return $query->where('type', 1);
					    })
				    ]
			    ];
		    endif;

	    endif;

	    if(isset($request->reference) && $request->reference != null):
		    if (isset($request->id) && $request->id != null):
			    $rule['reference'] = 'unique:familles,reference,'.$request->id;
		    else:
			    $rule['reference'] = 'required|unique:familles';
		    endif;
	    endif;


	    return $rules;
    }

    
    public function messages()
    {
		return [
			'name.required' => 'Attribuer un nom à cette famille',
			'name.unique' => 'Une famille du même nom existe déjà',
		];
               
    }
}
