<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

/*Route::get('/login', function () {
   // return view('welcome');
   echo "veuillez vs connectez";
});

Route::post('/login', function () {
   // return view('welcome');
   echo "veuillez vs connectez";
});*/

//Route::get('login', 'Auth\LoginController@login')->name('login');

Route::get('/login', function () {
	return view('login');
})->name('login');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/', function () {
	return view('dashboard');
})->middleware('auth');

Route::post('auth/login', 'Auth\LoginController@login'); // traitem de la connexion


Route::group([ 'middleware' => ['role:super_admin']], function() {

//	Route::prefix('clients')->group(function () {
//
//		Route::get('/', 'ClientsController@index')->middleware('auth')->name('client.index');
//
//		Route::get('/create', 'ClientsController@create')->middleware('auth')->name('client.create');
//
//
//		Route::get('/show/{id}', 'ClientsController@show')->middleware('auth')->name('client.show');
//		Route::get('/edit/{id}', 'ClientsController@edit')->middleware('auth')->name('client.edit');
//
//		Route::post('/create', 'ClientsController@store')->middleware('auth')->name('client.store');
//		Route::post('/update/{id}', 'ClientsController@update')->middleware('auth')->name('client.update');
//
//	});

	Route::get('/refreshrole', 'UserController@runSeedRole')->middleware('auth');

	Route::prefix('/settings/profile')->group(function () {
		Route::get('/', 'ProfileController@index')->middleware('auth')->name('profile.index');
		Route::get('/create', 'ProfileController@create')->middleware('auth')->name('profile.create');
		Route::get('/show/{id}', 'ProfileController@show')->middleware('auth')->name('profile.show');

		Route::get('/edit/{id}', 'ProfileController@edit')->middleware('auth')->name('profile.edit');


		Route::post('/store', 'ProfileController@store')->middleware('auth')->name('profile.store');
		Route::post('/update/{id}', 'ProfileController@update')->middleware('auth')->name('profile.update');
	});

	Route::prefix('/settings/users')->group(function () {

		Route::get('/', 'UserController@index')->middleware('auth')->name('user.index');
		Route::get('/create', 'UserController@create')->middleware('auth')->name('user.create');

		Route::get('/show/{id}', 'UserController@show')->middleware('auth')->name('user.show');
		Route::get('/edit/{id}', 'UserController@edit')->middleware('auth')->name('user.edit');

		Route::post('/store', 'UserController@store')->middleware('auth')->name('user.store');
		Route::post('/update/{id}', 'UserController@update')->middleware('auth')->name('user.update');

		Route::get('/activation/{id}', 'UserController@active')->middleware('auth')->name('user.active');
	});

	Route::prefix('/settings/magasin')->group(function () {

		Route::get('/', 'MagasinController@index')->middleware('auth')->name('magasin.index');
		Route::get('/create', 'MagasinController@create')->middleware('auth')->name('magasin.create');

		Route::get('/show/{id}', 'MagasinController@show')->middleware('auth')->name('magasin.show');
		Route::get('/edit/{id}', 'MagasinController@edit')->middleware('auth')->name('magasin.edit');

		Route::post('/store', 'MagasinController@store')->middleware('auth')->name('magasin.store');
		Route::post('/update/{id}', 'MagasinController@update')->middleware('auth')->name('magasin.update');
	});

	Route::prefix('/settings/pointdevente')->group(function () {

		Route::get('/', 'PointDeVenteController@index')->middleware('auth')->name('pos.index');
		Route::get('/create', 'PointDeVenteController@create')->middleware('auth')->name('pos.create');

		Route::get('/show/{id}', 'PointDeVenteController@show')->middleware('auth')->name('pos.show');
		Route::get('/edit/{id}', 'PointDeVenteController@edit')->middleware('auth')->name('pos.edit');

		Route::post('/store', 'PointDeVenteController@store')->middleware('auth')->name('pos.store');
		Route::post('/update/{id}', 'PointDeVenteController@update')->middleware('auth')->name('pos.update');

		Route::get('/add/caisse/{id}', 'PointDeVenteController@addCaisse')->middleware('auth')->name('pos.addCaisse');
		Route::get('/remove/caisse/{key?}', 'PointDeVenteController@removeCaisse')->middleware('auth')->name('pos.removeCaisse');
		Route::get('/list/caisse', 'PointDeVenteController@listCaisse')->middleware('auth')->name('pos.listing');
		Route::post('/valide/caisse/{id}', 'PointDeVenteController@validCaisse')->middleware('auth')->name('pos.valideCaisse');

		Route::get('/add/magasin/{id}', 'PointDeVenteController@addMagasin')->middleware('auth')->name('pos.addMagasin');
		Route::get('/remove/magasin/{key?}', 'PointDeVenteController@removeMagasin')->middleware('auth')->name('pos.removeMagasin');
		Route::get('/list/magasin', 'PointDeVenteController@listMagasin')->middleware('auth')->name('pos.listingMagasin');
		Route::post('/valide/magasin/{id}', 'PointDeVenteController@validMagasin')->middleware('auth')->name('pos.valideMagasin');
	});

	Route::prefix('/settings/famille/')->group(function () {

		Route::get('/produit', 'FamilleController@indexProduit')->middleware('auth')->name('famillepro.index');
		Route::get('/create/produit', 'FamilleController@createProduit')->middleware('auth')->name('famillepro.create');
		Route::get('/edit/produit/{id}', 'FamilleController@edit')->middleware('auth')->name('famillepro.edit');

		Route::get('/client', 'FamilleController@indexClient')->middleware('auth')->name('famillecli.index');
		Route::get('/create/client', 'FamilleController@createClient')->middleware('auth')->name('famillecli.create');
		Route::get('/edit/client/{id}', 'FamilleController@edit')->middleware('auth')->name('famillecli.edit');


		// Generale

		Route::get('/show/{id}', 'FamilleController@show')->middleware('auth')->name('famille.show');
		Route::post('/store', 'FamilleController@store')->middleware('auth')->name('famille.store');
		Route::post('/update/{id}', 'FamilleController@update')->middleware('auth')->name('famille.update');
		Route::get('/activation/{id}', 'FamilleController@active')->middleware('auth')->name('famille.active');
	});

	Route::prefix('/settings/unite')->group(function () {

		Route::get('/', 'UniteController@index')->middleware('auth')->name('unite.index');
		Route::get('/create', 'UniteController@create')->middleware('auth')->name('unite.create');

		Route::get('/show/{id}', 'UniteController@show')->middleware('auth')->name('unite.show');
		Route::get('/edit/{id}', 'UniteController@edit')->middleware('auth')->name('unite.edit');

		Route::post('/store', 'UniteController@store')->middleware('auth')->name('unite.store');
		Route::post('/update/{id}', 'UniteController@update')->middleware('auth')->name('unite.update');

		Route::get('/activation/{id}', 'UniteController@active')->middleware('auth')->name('unite.active');
	});

	Route::prefix('/clients')->group(function () {

		Route::get('/', 'ClientController@index')->middleware('auth')->name('client.index');
		Route::get('/create', 'ClientController@create')->middleware('auth')->name('client.create');

		Route::get('/show/{id}', 'ClientController@show')->middleware('auth')->name('client.show');
		Route::get('/edit/{id}', 'ClientController@edit')->middleware('auth')->name('client.edit');

		Route::post('/store', 'ClientController@store')->middleware('auth')->name('client.store');
		Route::post('/update/{id}', 'ClientController@update')->middleware('auth')->name('client.update');
	});

	Route::prefix('/settings/caisses')->group(function () {

		Route::get('/', 'CaisseController@index')->middleware('auth')->name('caisse.index');
		Route::get('/create', 'CaisseController@create')->middleware('auth')->name('caisse.create');

		Route::get('/show/{id}', 'CaisseController@show')->middleware('auth')->name('caisse.show');
		Route::get('/edit/{id}', 'CaisseController@edit')->middleware('auth')->name('caisse.edit');

		Route::post('/store', 'CaisseController@store')->middleware('auth')->name('caisse.store');
		Route::post('/update/{id}', 'CaisseController@update')->middleware('auth')->name('caisse.update');

	});


	Route::prefix('/settings')->group(function () {

		Route::get('/', 'ParamController@index')->middleware('auth')->name('param.index');

		Route::post('/update/{module}', 'ParamController@update')->middleware('auth')->name('param.update');

	});

	Route::prefix('/stockages/produit')->group(function () {

		Route::get('/', 'ProduitController@index')->middleware('auth')->name('produit.index');
		Route::get('/create', 'ProduitController@create')->middleware('auth')->name('produit.create');

		Route::get('/show/{id}', 'ProduitController@show')->middleware('auth')->name('produit.show');
		Route::get('/edit/{id}', 'ProduitController@edit')->middleware('auth')->name('produit.edit');

		Route::post('/store', 'ProduitController@store')->middleware('auth')->name('produit.store');
		Route::post('/update/{id}', 'ProduitController@update')->middleware('auth')->name('produit.update');

		Route::get('/activation/{id}', 'ProduitController@active')->middleware('auth')->name('produit.active');

		Route::get('/add/bundle/{id}', 'ProduitController@addProduit')->middleware('auth')->name('produit.addBundle');
		Route::get('/remove/bundle/{key?}', 'ProduitController@removeProduit')->middleware('auth')->name('produit.removeBundle');
		Route::get('/list/bundle', 'ProduitController@listproduit')->middleware('auth')->name('produit.listing');
		Route::post('/valide/bundle/{id}', 'ProduitController@validProduit')->middleware('auth')->name('produit.valideBundle');

		Route::get('/add/groupe_prix/{id}/{type}', 'ProduitController@addGroupePrix')->middleware('auth')->name('produit.addGroupePrix');
		Route::get('/remove/groupe_prix/{key?}', 'ProduitController@removeGroupePrix')->middleware('auth')->name('produit.removeGroupePrix');
		Route::get('/list/groupe_prix', 'ProduitController@listGroupePrix')->middleware('auth')->name('produit.listingGroupePrix');
		Route::post('/valide/groupe_prix/{id}', 'ProduitController@validGroupePrix')->middleware('auth')->name('produit.valideGroupePrix');

	});

	Route::prefix('/stockages/serie')->group(function () {

		Route::get('/', 'SerieController@index')->middleware('auth')->name('serie.index');
		Route::get('/lots', 'SerieController@indexLot')->middleware('auth')->name('lot.index');
		Route::get('/show/{id}', 'SerieController@show')->middleware('auth')->name('serie.show');
		Route::get('/lots/show/{id}', 'SerieController@showLot')->middleware('auth')->name('lot.show');
		Route::get('/importe', 'SerieController@preview')->middleware('auth')->name('serie.import');
		Route::post('/importation', 'SerieController@import')->middleware('auth')->name('serie.importation');
		Route::get('/validation', 'SerieController@validation')->middleware('auth')->name('serie.validation');
		Route::post('/store', 'SerieController@store')->middleware('auth')->name('serie.store');

	});

	Route::prefix('/demandes/send')->group(function () {

		Route::get('/', 'TransfertController@indexSend')->middleware('auth')->name('dmd.index');
		Route::get('/create', 'TransfertController@createSend')->middleware('auth')->name('dmd.create');
		Route::get('/edit/{id}', 'TransfertController@editSend')->middleware('auth')->name('dmd.edit');
		Route::get('/show/{id}', 'TransfertController@showSend')->middleware('auth')->name('dmd.show');
		Route::get('/change/statut/{id}/{statut}', 'TransfertController@changeStatutDoc')->middleware('auth')->name('dmd.statutDoc');

		Route::post('/store', 'TransfertController@storeSend')->middleware('auth')->name('dmd.store');
		Route::post('/update/{id}', 'TransfertController@updateSend')->middleware('auth')->name('dmd.update');

		Route::get('/add/produit/{id}', 'TransfertController@addProduit')->middleware('auth')->name('dmd.addProduit');
		Route::get('/remove/produit/{key?}', 'TransfertController@removeProduit')->middleware('auth')->name('dmd.removeProduit');
		Route::get('/list/produit', 'TransfertController@listProduit')->middleware('auth')->name('dmd.listingProduit');
		Route::post('/valide/produit/{id}', 'TransfertController@validProduit')->middleware('auth')->name('dmd.valideProduit');

	});

	Route::prefix('/demandes/receive')->group(function () {

		Route::get('/', 'TransfertController@indexReceive')->middleware('auth')->name('receive.index');
		Route::get('/edit/{id}', 'TransfertController@editReceive')->middleware('auth')->name('receive.edit');
		Route::get('/show/{id}', 'TransfertController@showReceive')->middleware('auth')->name('receive.show');
		Route::get('/change/statut/{id}/{statut}', 'TransfertController@changeStatutDoc')->middleware('auth')->name('receive.statutDoc');

		Route::get('/save/stock/appro', 'TransfertController@saveStockAppro')->middleware('auth')->name('receive.saveStockAppro');

		Route::get('/add/serie/{ligne_id}', 'TransfertController@addSerie')->middleware('auth')->name('receive.addSerie');
		Route::get('/check/add/serie/{ligne_id}', 'TransfertController@checkSerie')->middleware('auth')->name('receive.checkSerie');
		Route::get('/list/ligne_transfert/{demande_id}', 'TransfertController@listdmd')->middleware('auth')->name('receive.listing');


		Route::get('/expedition/{demande_id}', 'TransfertController@expedition')->middleware('auth')->name('receive.expedition');


		Route::post('/update/{id}', 'TransfertController@updateReceive')->middleware('auth')->name('receive.update');

		Route::post('/check/valid/serie/{ligne_id}', 'TransfertController@validSerie')->middleware('auth')->name('receive.validSerie');

	});


});

//Route::when('admin/post*', 'manage_posts');

/*Route::get('/dashboard', [
    'middleware' => 'auth',
    'uses' => 'Auth\LoginController@login'
]);*/
