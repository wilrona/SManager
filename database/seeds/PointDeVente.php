<?php

use Illuminate\Database\Seeder;

class PointDeVente extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('points_de_vente')->insert([
		    'libelle' => 'YooMee Mobile',
		    'adresse' => 'Immeuble Yoomee, Derriere la salle des fêtes',
		    'email' => 'support@yoomee.cm',
		    'phone' => '651015951',
		    'ville' => 'Douala',
		    'etat' => 1,
		    'parent_id' => null,
		    'created_at' => date("Y-m-d H:i:s"),
		    'updated_at' => date("Y-m-d H:i:s")
	    ]);
    }
}
