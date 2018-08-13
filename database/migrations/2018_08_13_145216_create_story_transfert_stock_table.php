<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoryTransfertStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story_transfert_stock', function (Blueprint $table) {
	        $table->integer('user_id')->unsigned();
	        $table->integer('ordre_transfert_id')->unsigned();
	        $table->string('action');

	        $table->foreign('user_id')->references('id')->on('users')
	              ->onUpdate('cascade')->onDelete('cascade');
	        $table->foreign('ordre_transfert_id')->references('id')->on('ordre_transfert')
	              ->onUpdate('cascade')->onDelete('cascade');

	        $table->primary(['user_id', 'ordre_transfert_id']);

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
        Schema::dropIfExists('story_transfert_stock');
    }
}
