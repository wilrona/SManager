<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcritureCaisseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('transfert_fond', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('reference');

		    $table->integer('caisse_receive_id')->unsigned();
		    $table->foreign('caisse_receive_id')->references('id')->on('caisses');

		    $table->integer('caisse_sender_id')->unsigned();
		    $table->foreign('caisse_sender_id')->references('id')->on('caisses');

		    $table->float('montant')->default(0);
		    $table->text('motif')->nullable($value = true);
		    $table->text('motif_annulation')->nullable($value = true);

		    $table->integer('statut')->default(0);  // 0 non recu; 1 recu;
		    $table->string('code_transfert');

		    $table->timestamps();
	    });

	    Schema::create('sessions', function (Blueprint $table) {
		    $table->increments('id');

		    $table->integer('caisse_id')->unsigned();
		    $table->foreign('caisse_id')->references('id')->on('caisses');

		    $table->float('montant_ouverture')->default(0);
		    $table->float('montant_fermeture')->default(0);

		    $table->integer('last')->default(0);

		    $table->integer('user_id')->nullable($value = true)->unsigned();
		    $table->foreign('user_id')->references('id')->on('users');

		    $table->timestamps();
	    });

        Schema::create('ecriture_caisse', function (Blueprint $table) {

	        $table->increments('id');
	        $table->integer('type_ecriture')->default(0); // 0 Cloture, 1 Ouverture, 2 Approvisionnement, 3 Encaissement, 4 Sortie
	        $table->string('type_paiement'); // cash, orange_money, mobile_money
	        $table->string('devise');

	        $table->float('montant');
	        $table->float('montant_remb')->default(0);

	        $table->string('libelle');

	        $table->integer('session_id')->unsigned();
	        $table->foreign('session_id')->references('id')->on('sessions');

	        $table->integer('caisse_id')->nullable($value = true)->unsigned();
	        $table->foreign('caisse_id')->references('id')->on('caisses');

	        $table->integer('transfert_fond_id')->nullable($value = true)->unsigned();
	        $table->foreign('transfert_fond_id')->references('id')->on('transfert_fond');

	        $table->integer('user_id')->nullable($value = true)->unsigned();
	        $table->foreign('user_id')->references('id')->on('users');

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
	    Schema::dropIfExists('ecriture_caisse');
	    Schema::dropIfExists('sessions');
        Schema::dropIfExists('transfert_fond');
    }
}
