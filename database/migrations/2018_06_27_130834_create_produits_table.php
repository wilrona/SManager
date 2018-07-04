<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('reference')->unique();
	        $table->string('name');
	        $table->text('description')->nullable($value = true);
	        $table->float('prix');
	        $table->integer('active')->default(1);
	        $table->integer('bundle')->default(0);

	        $table->integer('famille_id')->unsigned();
	        $table->foreign('famille_id')->references('id')->on('familles');


	        $table->integer('unite_id')->unsigned();
	        $table->foreign('unite_id')->references('id')->on('unites');


            $table->timestamps();
        });

	    Schema::create('bundle_produit', function (Blueprint $table) {

		    $table->integer('bundle_id')->unsigned();
		    $table->integer('produit_id')->unsigned();

		    $table->float('quantite');
		    $table->float('prix');

		    $table->foreign('bundle_id')->references('id')->on('produits')
		          ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('produit_id')->references('id')->on('produits')
		          ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['bundle_id', 'produit_id']);

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
	    Schema::dropIfExists('bundle_produit');
        Schema::dropIfExists('produits');
    }
}
