<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClientsTable extends Migration
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
		    $table->integer('phone_un')->nullable($value = true);
		    $table->integer('phone_deux')->nullable($value = true);
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
	    Schema::table('clients', function (Blueprint $table) {
		    $table->dropColumn('phone_un');
		    $table->dropColumn('phone_deux');
	    });
    }
}
