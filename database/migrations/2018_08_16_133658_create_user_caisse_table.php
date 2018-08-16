<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCaisseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

	    Schema::create('user_caisse', function (Blueprint $table) {
		    $table->integer('user_id')->unsigned();
		    $table->integer('caisse_id')->unsigned();
		    $table->integer('principal')->default(0);

		    $table->foreign('user_id')->references('id')->on('users')
		          ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('caisse_id')->references('id')->on('caisses')
		          ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['user_id', 'caisse_id']);

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
        Schema::dropIfExists('user_caisse');
    }
}
