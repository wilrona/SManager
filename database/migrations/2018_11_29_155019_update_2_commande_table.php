<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update2CommandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

	    Schema::table('commande', function (Blueprint $table) {

		    $table->string('nomDmd')->nullable($value = true);
		    $table->string('prenomDmd')->nullable($value = true);
		    $table->string('phoneDmd')->nullable($value = true);
		    $table->string('adresseDmd')->nullable($value = true);

		    $table->integer('ville_id')->nullable($value = true)->unsigned();
		    $table->foreign('ville_id')->references('id')->on('region');

		    $table->integer('departement_id')->nullable($value = true)->unsigned();
		    $table->foreign('departement_id')->references('id')->on('region');

		    $table->integer('region_id')->nullable($value = true)->unsigned();
		    $table->foreign('region_id')->references('id')->on('region');


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
    }
}
