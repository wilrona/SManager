<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commande', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('reference');
	        $table->float('total');
	        $table->float('subtotal');
	        $table->string('devise')->nullable($value = true);

	        $table->integer('client_id')->unsigned();
	        $table->foreign('client_id')->references('id')->on('clients');

	        $table->integer('etat')->default(0);
	        $table->string('codeCmd');

	        $table->integer('point_de_vente_id')->unsigned();
	        $table->foreign('point_de_vente_id')->references('id')->on('point_de_vente');

            $table->timestamps();
        });

	    Schema::create('commande_ligne', function (Blueprint $table) {
		    $table->integer('produit_id')->unsigned();
		    $table->integer('commande_id')->unsigned();
		    $table->integer('qte')->default(1);
		    $table->float('prix');
		    $table->string('devise')->nullable($value = true);

		    $table->foreign('produit_id')->references('id')->on('produits')
		          ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('commande_id')->references('id')->on('commande')
		          ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['produit_id', 'commande_id']);

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
        Schema::dropIfExists('commande_ligne');
        Schema::dropIfExists('commande');
    }
}
