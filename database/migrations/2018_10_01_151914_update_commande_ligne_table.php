<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCommandeLigneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

	    Schema::table('commande_ligne', function (Blueprint $table) {
		    $table->string('serie_sortie')->nullable($value = true);
		    $table->string('serie_livree')->nullable($value = true);
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

	    Schema::table('caisses', function (Blueprint $table) {
		    $table->dropColumn('serie_sortie');
		    $table->dropColumn('serie_livree');
	    });
    }
}
