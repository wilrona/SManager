<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCommandeTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('commande_session', function (Blueprint $table) {
			$table->integer('session_id')->unsigned();
			$table->integer('commande_id')->unsigned();

			$table->foreign('session_id')->references('id')->on('sessions')
			      ->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('commande_id')->references('id')->on('commande')
			      ->onUpdate('cascade')->onDelete('cascade');

			$table->primary(['session_id', 'commande_id']);

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
		Schema::dropIfExists('commande_session');
	}
}
