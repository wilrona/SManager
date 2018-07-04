<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('users', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('reference')->unique();
		    $table->string('nom')->nullable($value = true);
		    $table->string('prenom')->nullable($value = true);
		    $table->string('phone')->nullable($value = true);
		    $table->string('adresse')->nullable($value = true);
		    $table->string('password');
		    $table->string('ville')->nullable($value = true);
		    $table->string('sexe')->nullable($value = true);
		    $table->string('email')->unique();
		    $table->integer('active')->default(1);
		    $table->integer('etatVente')->default(1); // 1 Etat de vente ouverte, 0 Etat de vente en recouvrement
		    $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
