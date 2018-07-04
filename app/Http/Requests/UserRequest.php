<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
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

			$rule = [
				'email' => 'required|email|max:255|unique:users,email,'.$request->id,
				'nom' => 'required',
//				'prenom' => 'required',
				'adresse' => 'required',
				'ville' => 'required',
				'phone' => 'required',
				'sexe' => 'required',
				'pos_id' => 'required'
			];

		else:

			$rule=[
				'email' => 'required|email|max:255|unique:users',
				'nom' => 'required',
//				'prenom' => 'required',
				'adresse' => 'required',
				'ville' => 'required',
				'phone' => 'required',
				'sexe' => 'required',
				'pos_id' => 'required'
			];

		endif;

		if(isset($request->password) && $request->password != null):
			$rule['password'] = 'min:6|required_with:password_confirmation|same:password_confirmation';
			$rule['password_confirmation'] = 'min:6';
		endif;

		if(isset($request->reference) && $request->reference != null):
			if (isset($request->id) && $request->id != null):
				$rule['reference'] = 'unique:users,reference,'.$request->id;
			else:
				$rule['reference'] = 'required|unique:users';
			endif;
		endif;

		return $rule;
	}

	public function messages()
	{
		return [
			'password.required_with' => 'La confirmation de mot de passe est obligatoire',
			'password.same' => 'Les deux mots passes ne sont pas identique',
			'pos_id.required' => 'Le choix du point de vente est obligatoire'
		];
	}
}
