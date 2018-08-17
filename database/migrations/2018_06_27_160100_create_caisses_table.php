<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaissesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caisses', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('reference')->unique();
	        $table->string('name');
	        $table->integer('etat')->default(0);
	        $table->float('montantEnCours')->default(0);

	        $table->integer('pos_id')->nullable($value = true)->unsigned();
	        $table->foreign('pos_id')->references('id')->on('point_de_vente');

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
        Schema::dropIfExists('caisses');
    }
}
