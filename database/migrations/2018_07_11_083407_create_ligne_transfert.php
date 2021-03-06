<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLigneTransfert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

	    Schema::create('ligne_ordre_transfert', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('qte_dmd');
		    $table->integer('qte_exp')->nullable($value = true)->default(0);
		    $table->integer('qte_a_exp')->nullable($value = true)->default(0);
		    $table->integer('qte_recu')->nullable($value = true)->default(0);
		    $table->integer('qte_a_recu')->nullable($value = true)->default(0);

		    $table->integer('produit_id')->unsigned();
		    $table->foreign('produit_id')->references('id')->on('produits');

		    $table->integer('ordre_transfert_id')->nullable($value = true)->unsigned();
		    $table->foreign('ordre_transfert_id')->references('id')->on('ordre_transfert');
		    $table->timestamps();
	    });

	    Schema::create('ligne_ordre_transfert_serie', function (Blueprint $table) {
		    $table->integer('serie_id')->unsigned();
		    $table->integer('ligne_id')->unsigned();

		    $table->integer('qte')->default(1);
		    $table->integer('a_recu')->default(0);

		    $table->foreign('serie_id')->references('id')->on('series')
		          ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('ligne_id')->references('id')->on('ligne_ordre_transfert')
		          ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['serie_id', 'ligne_id']);
	    });

	    Schema::create('transfert_serie', function (Blueprint $table) {
		    $table->integer('serie_id')->unsigned();
		    $table->integer('transfert_id')->unsigned();

		    $table->integer('ok')->default(0);
		    $table->integer('show')->default(1);

		    $table->foreign('serie_id')->references('id')->on('series')
		          ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('transfert_id')->references('id')->on('transfert')
		          ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['serie_id', 'transfert_id']);

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

	    Schema::dropIfExists('ligne_transfert_serie');
	    Schema::dropIfExists('ligne_transfert');
	    Schema::dropIfExists('transfert_serie');
    }
}
