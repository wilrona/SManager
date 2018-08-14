<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCaisseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

	    Schema::table('caisses', function (Blueprint $table) {
		    $table->dropForeign('caisses_pos_id_foreign');
		    $table->dropColumn('pos_id');
	    });

	    Schema::create('pos_caisse', function (Blueprint $table) {
		    $table->integer('pos_id')->unsigned();
		    $table->integer('caisse_id')->unsigned();
		    $table->integer('principal')->default(0);

		    $table->foreign('pos_id')->references('id')->on('point_de_vente')
		          ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('caisse_id')->references('id')->on('caisses')
		          ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['pos_id', 'caisse_id']);

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

	    Schema::table('caisses', function (Blueprint $table) {
		    $table->integer('pos_id')->nullable($value = true)->unsigned();
		    $table->foreign('pos_id')->references('id')->on('point_de_vente');
	    });

	    Schema::dropIfExists('pos_caisse');
    }
}
