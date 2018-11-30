<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('api', 'cors')->get('user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('cors','api')->post('login', 'API\UserController@login');
Route::middleware('cors','api')->post('logout', 'API\UserController@logout');
Route::middleware('cors','api')->post('register', 'API\UserController@register');


Route::group(['middleware' => ['api', 'cors']], function(){
	Route::get('produit', 'API\ProduitController@index');
	Route::post('produit/id', 'API\ProduitController@show');


	Route::get('categorie', 'API\ProduitController@productCategorie');


	Route::get('client', 'API\ClientController@index');
	Route::get('ville', 'API\ClientController@listVille');
	Route::post('client/creer', 'API\ClientController@store');
	Route::post('client/show', 'API\ClientController@show');


	Route::post('user/commande', 'API\UserController@getCommande');

	Route::post('cmd/show', 'API\CommandeController@show');


});
