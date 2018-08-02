<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcritureStockSerieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

	    Schema::create('ecriture_stock_serie', function (Blueprint $table) {
		    $table->integer('serie_id')->unsigned();
		    $table->integer('ecriture_stock_id')->unsigned();

		    $table->foreign('serie_id')->references('id')->on('series')
		          ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('ecriture_stock_id')->references('id')->on('ecriture_stock')
		          ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['serie_id', 'ecriture_stock_id']);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecriture_stock_serie');
    }
}
