<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update2ClientTable extends Migration
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

		    $table->string('nationalite');
		    $table->date('dateCNI');
		    $table->string('noCNI');
		    $table->string('sexe');
		    $table->string('profession');
		    $table->string('fileCNI1')->nullable($value = true);
		    $table->string('fileCNI2')->nullable($value = true);
		    $table->string('repere')->nullable($value = true);


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
