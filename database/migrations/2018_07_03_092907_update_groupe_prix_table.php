<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGroupePrixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

	    Schema::create('groupe_prix', function (Blueprint $table) {
		    $table->increments('id');

		    $table->integer('produit_id')->unsigned();
		    $table->integer('famille_id')->nullable($value = true)->unsigned();
		    $table->integer('client_id')->nullable($value = true)->unsigned();
		    $table->integer('type_client')->default(0); // 0 : Client; 1: Famille de client
		    $table->integer('prix');
		    $table->integer('type_remise')->default(0); // 0 : Prix fixe ; 1 : Pourcentage
		    $table->float('remise');
		    $table->integer('quantite_min')->default(1);
		    $table->date('date_debut')->nullable($value = true);
		    $table->date('date_fin')->nullable($value = true);
		    $table->integer('active')->default(1);

		    $table->foreign('famille_id')->references('id')->on('familles');
		    $table->foreign('produit_id')->references('id')->on('produits');
		    $table->foreign('client_id')->references('id')->on('clients');

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
	    Schema::dropIfExists('groupe_prix');
    }
}
