<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SerieFileRequest extends FormRequest
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
	        'file_import' => 'required',
	        'produit_id' => 'required',
	        'magasin_id' => 'required'
        ];
    }

	public function messages() {
		return [
			'produit_id.required' => 'La selection du produit est obligatoire',
			'magasin_id.required' => 'La selection du produit est obligatoire'
		];
	}
}
