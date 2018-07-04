<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosCaisseRequest extends FormRequest
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
	        'caisse_id' => 'required'
        ];
    }

    public function messages() {
	    return [
	    	'caisse_id.required' => 'Selection de la caisse obligatoire'
	    ];
    }
}
