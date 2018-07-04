<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersAdColumnPos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

	    Schema::table('users', function (Blueprint $table) {
		    $table->integer('pos_id')->nullable($value = true)->unsigned();
		    $table->foreign('pos_id')->references('id')->on('point_de_vente');


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
	    Schema::table('users', function (Blueprint $table) {
		    $table->dropColumn('pos_id');
	    });
    }
}
