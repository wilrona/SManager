<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PointDeVenteRequest extends FormRequest
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
		    'type' => 'required'
	    ];


	    if (isset($request->id) && $request->id != null):
		    $rule['reference'] = 'unique:point_de_vente,reference,'.$request->id;
	    else:
		    $rule['reference'] = 'required|unique:point_de_vente';
		endif;

        return $rule;
    }

    public function messages() {
	    return [
		    'reference.required' => 'La configuration des numéros de séquence pour la reference des points de vente n\'a pas été effectué'
	    ];
    }
}
