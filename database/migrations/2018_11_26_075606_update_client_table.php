<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('clients', function (Blueprint $table) {

		    $table->string('quartier');
		    $table->string('numeroCompte')->nullable($value = true);
		    $table->integer('etat')->default(0); // 0 enregistré, 1 verifier, 2 activer

		    $table->integer('ville_id')->unsigned();
		    $table->foreign('ville_id')->references('id')->on('region');

		    $table->integer('departement_id')->unsigned();
		    $table->foreign('departement_id')->references('id')->on('region');

		    $table->integer('region_id')->unsigned();
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
