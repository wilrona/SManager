<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersRelationRolesAndProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('users', function (Blueprint $table) {
		    $table->integer('profile_id')->nullable($value = true)->unsigned();
		    $table->foreign('profile_id')->references('id')->on('profiles');
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

	    Schema::table('users', function (Blueprint $table) {
		    $table->dropColumn('profile_id');
	    });
    }
}
