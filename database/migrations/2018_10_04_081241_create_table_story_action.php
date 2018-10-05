<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStoryAction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

	    Schema::create('story_action', function (Blueprint $table) {

		    $table->increments('id');
		    $table->string('etape_action');
		    $table->text('description');

		    $table->integer('user_id')->nullable($value = true)->unsigned();
		    $table->foreign('user_id')->references('id')->on('users');

		    $table->integer('ordre_transfert_id')->nullable($value = true)->unsigned();
		    $table->foreign('ordre_transfert_id')->references('id')->on('ordre_transfert');

		    $table->integer('commande_id')->nullable($value = true)->unsigned();
		    $table->foreign('commande_id')->references('id')->on('commande');

		    $table->integer('transfert_fond_id')->nullable($value = true)->unsigned();
		    $table->foreign('transfert_fond_id')->references('id')->on('transfert_fond');

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
	    Schema::dropIfExists('story_action');
    }
}
