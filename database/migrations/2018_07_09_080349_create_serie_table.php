<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('reference')->unique();
	        $table->integer('importe')->default(0);
	        $table->integer('type')->default(0); // 0 serie; 1 Lots

	        $table->integer('produit_id')->unsigned();
	        $table->foreign('produit_id')->references('id')->on('produits');

	        $table->integer('lot_id')->nullable($value = true)->unsigned();
	        $table->foreign('lot_id')->references('id')->on('series');
            $table->timestamps();
        });

	    Schema::create('stock_serie', function (Blueprint $table) {
		    $table->integer('serie_id')->unsigned();
		    $table->integer('magasin_id')->unsigned();
		    $table->integer('mouvement')->default(0);

		    $table->foreign('serie_id')->references('id')->on('series')
		          ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('magasin_id')->references('id')->on('magasins')
		          ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['serie_id', 'magasin_id']);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

	    Schema::dropIfExists('stock_serie');
        Schema::dropIfExists('serie');
    }
}
