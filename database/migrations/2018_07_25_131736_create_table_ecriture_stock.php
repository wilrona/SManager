<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEcritureStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

	    Schema::create('ecriture_stock', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('type_ecriture')->default(0);
		    $table->integer('quantite')->default(0);

		    $table->integer('produit_id')->unsigned();
		    $table->foreign('produit_id')->references('id')->on('produits');

		    $table->integer('ordre_transfert_id')->nullable($value = true)->unsigned();
		    $table->foreign('ordre_transfert_id')->references('id')->on('ordre_transfert');

		    $table->integer('transfert_id')->nullable($value = true)->unsigned();
		    $table->foreign('transfert_id')->references('id')->on('transfert');

		    $table->integer('user_id')->nullable($value = true)->unsigned();
		    $table->foreign('user_id')->references('id')->on('users');

		    $table->integer('magasin_id')->nullable($value = true)->unsigned();
		    $table->foreign('magasin_id')->references('id')->on('magasins');


		    $table->timestamps();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	    Schema::dropIfExists('ecriture_stock');
    }
}
