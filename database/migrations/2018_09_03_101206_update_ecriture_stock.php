<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEcritureStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('ecriture_stock', function (Blueprint $table) {
		    $table->integer('commande_id')->nullable($value = true)->unsigned();
		    $table->foreign('commande_id')->references('id')->on('commande');

		    $table->integer('session_id')->nullable($value = true)->unsigned();
		    $table->foreign('session_id')->references('id')->on('sessions');
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
