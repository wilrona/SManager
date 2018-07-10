<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdreTransfertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordre_transfert', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('reference')->unique();
	        $table->text('motif')->nullable($value = true);
	        $table->integer('statut_doc')->default(0);
	        $table->integer('statut_exp')->default(0);
	        $table->integer('statut_recept')->default(0);

	        $table->integer('pos_dmd_id')->nullable($value = true)->unsigned();
	        $table->foreign('pos_dmd_id')->references('id')->on('point_de_vente');

	        $table->integer('mag_dmd_id')->nullable($value = true)->unsigned();
	        $table->foreign('mag_dmd_id')->references('id')->on('magasins');

	        $table->integer('pos_appro_id')->nullable($value = true)->unsigned();
	        $table->foreign('pos_appro_id')->references('id')->on('point_de_vente');

	        $table->integer('mag_appro_id')->nullable($value = true)->unsigned();
	        $table->foreign('mag_appro_id')->references('id')->on('magasins');

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
        Schema::dropIfExists('ordre_transfert');
    }
}
