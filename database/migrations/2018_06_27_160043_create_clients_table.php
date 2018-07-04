<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('reference')->unique();
	        $table->string('nom');
	        $table->string('prenom')->nullable($value = true);
	        $table->date('dateNais');
	        $table->string('display_name');
	        $table->string('adresse');
	        $table->string('phone');
	        $table->string('ville');
	        $table->string('email')->unique();

	        $table->integer('famille_id')->unsigned();
	        $table->foreign('famille_id')->references('id')->on('familles');

	        $table->integer('contact_id')->nullable($value = true)->unsigned();
	        $table->foreign('contact_id')->references('id')->on('clients');

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
        Schema::dropIfExists('clients');
    }
}
