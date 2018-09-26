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


//Route::group([ 'middleware' => ['role:super_admin']], function() {
Route::group([], function() {

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

		Route::get('/add/caisse/{pos_id}/{user_id}', 'UserController@addCaisse')->middleware('auth')->name('user.addCaisse');
		Route::get('/add/caisse/check', 'UserController@checkCaisse')->middleware('auth')->name('user.checkCaisse');
		Route::get('/list/caisse/{id}', 'UserController@listCaisse')->middleware('auth')->name('user.listingCaisse');
		Route::post('/valide/caisse/{id}', 'UserController@validCaisse')->middleware('auth')->name('user.valideCaisse');

		Route::get('/add/magasin/{pos_id}/{user_id}', 'UserController@addMagasin')->middleware('auth')->name('user.addMagasin');
		Route::get('/add/magasin/check', 'UserController@checkMagasin')->middleware('auth')->name('user.checkMagasin');
		Route::get('/list/magasin/{id}', 'UserController@listMagasin')->middleware('auth')->name('user.listingMagasin');
		Route::post('/valide/magasin/{id}', 'UserController@validMagasin')->middleware('auth')->name('user.valideMagasin');
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
		Route::get('/add/caisse/check/{pos_id}/{type}', 'PointDeVenteController@checkCaisse')->middleware('auth')->name('pos.checkCaisse');
		Route::get('/list/caisse/{id}', 'PointDeVenteController@listCaisse')->middleware('auth')->name('pos.listingCaisse');
		Route::post('/valide/caisse/{id}', 'PointDeVenteController@validCaisse')->middleware('auth')->name('pos.valideCaisse');

		Route::get('/add/magasin/{id}', 'PointDeVenteController@addMagasin')->middleware('auth')->name('pos.addMagasin');
		Route::get('/add/magasin/check/{pos_id}', 'PointDeVenteController@checkMagasin')->middleware('auth')->name('pos.checkMagasin');
		Route::get('/list/magasin/{id}', 'PointDeVenteController@listMagasin')->middleware('auth')->name('pos.listingMagasin');
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

		Route::get('/index/{ajax?}', 'ClientController@index')->middleware('auth')->name('client.index');
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

	Route::prefix('/settings/produit')->group(function () {

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

	Route::prefix('/stockages/produit')->group(function () {

		Route::get('/{single?}', 'ProduitController@index')->middleware('auth')->name('produit.indexUser');

		Route::get('/show/{id}/{single?}', 'ProduitController@show')->middleware('auth')->name('produit.showUser');

		Route::get('/serie/show/{magasin_id}/{produit_id}', 'ProduitController@serieMagasin')->middleware('auth')->name('produit.serieMagasin');

	});

	Route::prefix('/settings/serie')->group(function () {

		Route::get('/', 'SerieController@index')->middleware('auth')->name('serie.index');
		Route::get('/lots', 'SerieController@indexLot')->middleware('auth')->name('lot.index');
		Route::get('/show/{id}', 'SerieController@show')->middleware('auth')->name('serie.show');
		Route::get('/lots/show/{id}', 'SerieController@showLot')->middleware('auth')->name('lot.show');
		Route::get('/importe', 'SerieController@preview')->middleware('auth')->name('serie.import');
		Route::post('/importation', 'SerieController@import')->middleware('auth')->name('serie.importation');
		Route::get('/validation', 'SerieController@validation')->middleware('auth')->name('serie.validation');
		Route::post('/store', 'SerieController@store')->middleware('auth')->name('serie.store');

	});

	Route::prefix('/stockages/serie')->group(function () {

		Route::get('/{single?}', 'SerieController@index')->middleware('auth')->name('serie.indexUser');
		Route::get('/show/{id}/{single?}', 'SerieController@show')->middleware('auth')->name('serie.showUser');
		Route::get('/lots/show/{id}/{single?}', 'SerieController@showLot')->middleware('auth')->name('lot.showUser');

	});

	Route::prefix('/stockages/ecriture/stock')->group(function () {

		Route::get('/', 'EcritureStockController@index')->middleware('auth')->name('ecriture.index');
		Route::get('/serie/{ecriture_id}', 'EcritureStockController@serie')->middleware('auth')->name('ecriture.serie');

	});

	Route::prefix('/stockages/send')->group(function () {

		Route::get('/', 'OrdreTransfertController@indexSend')->middleware('auth')->name('dmd.index');
		Route::get('/create', 'OrdreTransfertController@createSend')->middleware('auth')->name('dmd.create');
		Route::get('/edit/{id}', 'OrdreTransfertController@editSend')->middleware('auth')->name('dmd.edit');
		Route::get('/show/{id}', 'OrdreTransfertController@showSend')->middleware('auth')->name('dmd.show');
		Route::get('/change/statut/{id}/{statut}', 'OrdreTransfertController@changeStatutDoc')->middleware('auth')->name('dmd.statutDoc');

		Route::post('/store', 'OrdreTransfertController@storeSend')->middleware('auth')->name('dmd.store');
		Route::post('/update/{id}', 'OrdreTransfertController@updateSend')->middleware('auth')->name('dmd.update');

		Route::get('/add/produit/{id}', 'OrdreTransfertController@addProduit')->middleware('auth')->name('dmd.addProduit');
		Route::get('/remove/produit/{key?}', 'OrdreTransfertController@removeProduit')->middleware('auth')->name('dmd.removeProduit');
		Route::get('/list/produit', 'OrdreTransfertController@listProduit')->middleware('auth')->name('dmd.listingProduit');
		Route::post('/valide/produit/{id}', 'OrdreTransfertController@validProduit')->middleware('auth')->name('dmd.valideProduit');

		Route::get('/show/reception/{id}', 'OrdreTransfertController@receiveSend')->middleware('auth')->name('dmd.receiveSend');

		Route::get('/show/reception/valid/{transfert_id}', 'OrdreTransfertController@showSerieReception')->middleware('auth')->name('dmd.showSerieReception');
		Route::get('/show/reception/valid/produit/{ligne_id}', 'OrdreTransfertController@showSerieProduitReception')->middleware('auth')->name('dmd.showSerieProduitReception');

		Route::get('/show/reception/check_serie/{transfert_id}', 'OrdreTransfertController@checkSerieReception')->middleware('auth')->name('dmd.checkSerieReception');
		Route::get('/show/reception/check_serie/produit/{ligne_id}', 'OrdreTransfertController@checkSerieProduitReception')->middleware('auth')->name('dmd.checkSerieProduitReception');


		Route::post('/check/valid/ligne_serie/{ligne_id}', 'OrdreTransfertController@validSerieProduitReception')->middleware('auth')->name('dmd.validSerieProduitReception');
		Route::post('/check/valid/trasnfert_serie/{transfert_id}', 'OrdreTransfertController@validSerieReception')->middleware('auth')->name('dmd.validSerieReception');
		Route::get('/list/ligne_transfert/{demande_id}', 'OrdreTransfertController@listdmdProduitReception')->middleware('auth')->name('dmd.listdmdProduitReception');


		Route::post('/reception/{demande_id}', 'OrdreTransfertController@reception')->middleware('auth')->name('dmd.reception');

	});

	Route::prefix('/stockages/receive')->group(function () {

		Route::get('/', 'OrdreTransfertController@indexReceive')->middleware('auth')->name('receive.index');
		Route::get('/edit/{id}', 'OrdreTransfertController@editReceive')->middleware('auth')->name('receive.edit');
		Route::get('/show/{id}', 'OrdreTransfertController@showReceive')->middleware('auth')->name('receive.show');
		Route::get('/change/statut/{id}/{statut}', 'OrdreTransfertController@changeStatutDoc')->middleware('auth')->name('receive.statutDoc');

		Route::get('/save/stock/appro', 'OrdreTransfertController@saveStockAppro')->middleware('auth')->name('receive.saveStockAppro');

		Route::get('/add/serie/{ligne_id}', 'OrdreTransfertController@addSerie')->middleware('auth')->name('receive.addSerie');
		Route::get('/check/add/serie/{ligne_id}', 'OrdreTransfertController@checkSerie')->middleware('auth')->name('receive.checkSerie');
		Route::get('/list/ligne_transfert/{demande_id}', 'OrdreTransfertController@listdmd')->middleware('auth')->name('receive.listing');
		Route::get('/list/transfert_serie/{transfert_id}', 'OrdreTransfertController@showSerieExpedition')->middleware('auth')->name('receive.showTransfert');


		Route::post('/expedition/{demande_id}', 'OrdreTransfertController@expedition')->middleware('auth')->name('receive.expedition');


		Route::post('/update/{id}', 'OrdreTransfertController@updateReceive')->middleware('auth')->name('receive.update');

		Route::post('/check/valid/serie/{ligne_id}', 'OrdreTransfertController@validSerie')->middleware('auth')->name('receive.validSerie');

	});

	Route::prefix('/caisse-manager')->group(function () {

		Route::get('/', 'CaisseManagerController@index')->middleware('auth')->name('caisseManager.index');
		Route::get('/preopen/{caisse_id}', 'CaisseManagerController@preopen')->middleware('auth')->name('caisseManager.preopen');
		Route::post('/preopen/check/{caisse_id}', 'CaisseManagerController@preopencheck')->middleware('auth')->name('caisseManager.preopencheck');
		Route::get('/open/{caisse_id}', 'CaisseManagerController@open')->middleware('auth')->name('caisseManager.open');
		Route::get('/openReload/{caisse_id}', 'CaisseManagerController@openReload')->middleware('auth')->name('caisseManager.openReload');
		Route::get('/close/{caisse_id}', 'CaisseManagerController@close')->middleware('auth')->name('caisseManager.close');
		Route::get('/checkClose/{caisse_id}', 'CaisseManagerController@checkClose')->middleware('auth')->name('caisseManager.checkClose');
		Route::get('/transfertFondClose/{caisse_id}', 'CaisseManagerController@transfertFondClose')->middleware('auth')->name('caisseManager.transfertFondClose');


		Route::get('/create/transfert_fond/{caisse_id}', 'CaisseManagerController@createTransfertFond')->middleware('auth')->name('caisseManager.createTransfertFond');
		Route::post('/create/transfert_fond/check/{caisse_id}', 'CaisseManagerController@createTransfertFondCheck')->middleware('auth')->name('caisseManager.createTransfertFondCheck');

		Route::get('/index/transfert_fond/{caisse_id}', 'CaisseManagerController@indexTransfertFond')->middleware('auth')->name('caisseManager.indexTransfertFond');

		Route::get('/cancel/transfert_fond/{caisse_id}', 'CaisseManagerController@cancelTransfertFond')->middleware('auth')->name('caisseManager.cancelTransfertFond');
		Route::post('/cancel/transfert_fond/check/{caisse_id}', 'CaisseManagerController@cancelTransfertFond')->middleware('auth')->name('caisseManager.cancelTransfertFondPost');

		Route::get('/receive/transfert_fond/{caisse_id}', 'CaisseManagerController@receiveTransfertFond')->middleware('auth')->name('caisseManager.receiveTransfertFond');

		Route::get('/received/transfert_fond/{caisse_id}', 'CaisseManagerController@receivedTransfertFond')->middleware('auth')->name('caisseManager.receivedTransfertFond');
		Route::post('/received/transfert_fond/ckeck/{caisse_id}', 'CaisseManagerController@receivedTransfertFond')->middleware('auth')->name('caisseManager.receivedTransfertFondPost');

		Route::get('/story/transfert_fond/{caisse_id}', 'CaisseManagerController@storyTransfertFond')->middleware('auth')->name('caisseManager.storyTransfertFond');

		Route::get('/rapport/{caisse_id}', 'CaisseManagerController@rapportSession')->middleware('auth')->name('caisseManager.rapportSession');

		Route::get('/rapport/detail/{ecriture_id}/{caisse_id}', 'CaisseManagerController@detailEcritureEtTransfert')->middleware('auth')->name('caisseManager.detailEcritureEtTransfert');

		Route::get('/search/commande', 'CaisseManagerController@searchCommande')->middleware('auth')->name('caisseManager.searchCommande');

		Route::get('/commande/encaissement/show/{id?}', 'CaisseManagerController@encaissementCommande')->middleware('auth')->name('commande.encaissementCommande');
		Route::get('/commande/encaissement/{paiement}/{id}/{caisse_id}', 'CaisseManagerController@encaissement')->middleware('auth')->name('commande.encaissement');

		// Route pour la commande de produit

		Route::get('/commande', 'CommandeManagerController@index')->middleware('auth')->name('commande.index');
		Route::get('/commande/panier/{produit_id}', 'CommandeManagerController@panier')->middleware('auth')->name('commande.panier');
		Route::get('/commande/list/panier/', 'CommandeManagerController@listPanier')->middleware('auth')->name('commande.listpanier');
		Route::get('/commande/list/panier/delete', 'CommandeManagerController@DeleteItemPanier')->middleware('auth')->name('commande.DeleteItemPanier');
		Route::get('/commande/list/panier/save', 'CommandeManagerController@saveCommande')->middleware('auth')->name('commande.save');
		Route::get('/commande/list/panier/updateClient', 'CommandeManagerController@selectClient')->middleware('auth')->name('commande.selectClient');

		Route::get('/commande/creer/client', 'CommandeManagerController@formClient')->middleware('auth')->name('commande.formClient');
		Route::post('/commande/creer/client/submit', 'CommandeManagerController@formClientPost')->middleware('auth')->name('commande.formClientPost');

		Route::get('/commande/vente', 'CommandeManagerController@commandePos')->middleware('auth')->name('commande.commandePos');
		Route::get('/commande/vente/detail/{id}', 'CommandeManagerController@commandePosDetail')->middleware('auth')->name('commande.commandePosDetail');

	});

	Route::prefix('/stockages')->group(function () {

		Route::get('/magasin', 'MagasinManagerController@index')->middleware('auth')->name('magasinManager.index');

		Route::get('/magasin/preopen/{magasin_id}', 'MagasinManagerController@preopen')->middleware('auth')->name('magasinManager.preopen');

		Route::get('/magasin/open/{magasin_id}', 'MagasinManagerController@open')->middleware('auth')->name('magasinManager.open');

		Route::get('/search/commande', 'MagasinManagerController@searchCommande')->middleware('auth')->name('magasinManager.searchCommande');

		Route::get('/openReload/{magasin_id}', 'MagasinManagerController@openReload')->middleware('auth')->name('magasinManager.openReload');

		Route::get('/close/{magasin_id}', 'MagasinManagerController@close')->middleware('auth')->name('magasinManager.close');

		Route::get('/story/transfert_stock/{magasin_id}', 'MagasinManagerController@storyTransfertStock')->middleware('auth')->name('magasinManager.storyTransfertStock');

		Route::get('/commande/stock/show/{id?}', 'MagasinManagerController@stockCommande')->middleware('auth')->name('magasinManager.stockCommande');
	});


});

//Route::when('admin/post*', 'manage_posts');

/*Route::get('/dashboard', [
    'middleware' => 'auth',
    'uses' => 'Auth\LoginController@login'
]);*/
