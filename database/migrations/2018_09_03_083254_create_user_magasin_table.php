<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMagasinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_magasin', function (Blueprint $table) {
	        $table->integer('user_id')->unsigned();
	        $table->integer('magasin_id')->unsigned();
	        $table->integer('principal')->default(0);
	        $table->integer('principal')->default(0);

	        $table->foreign('user_id')->references('id')->on('users')
	              ->onUpdate('cascade')->onDelete('cascade');
	        $table->foreign('magasin_id')->references('id')->on('magasins')
	              ->onUpdate('cascade')->onDelete('cascade');

	        $table->primary(['user_id', 'magasin_id']);

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
        Schema::dropIfExists('user_magasin');
    }
}
