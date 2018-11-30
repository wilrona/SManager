<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

	    Schema::create('region', function (Blueprint $table) {

		    $table->increments('id');
		    $table->string('libelle');
		    $table->string('type');

		    $table->integer('parent_id')->nullable($value = true)->unsigned();
		    $table->foreign('parent_id')->references('id')->on('region');

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
        //
    }
}
