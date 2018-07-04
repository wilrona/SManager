<?php

use Illuminate\Database\Seeder;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'reference' => 'ADMIN01',
            'nom' => 'Application ',
            'prenom' => 'Administrateur',
            'phone' => '',
            'adresse' => '',
            'sexe' => 'm',
            'ville' => 'Douala',
            'email' => 'support@yoomee.onl',
            'password' => '$2y$10$sRuNCEa/1kROdAmy7/SraOuDHqd7ROlpsdwwL.IGJ6a2d.MYla9Cm'
            
        ]);

        DB::table('roles')->insert([
            'name' => 'super_admin',
            'display_name' => 'Super Admin',
            'description' => 'YooMee Direction Générale'    
        ]);

        DB::table('role_user')->insert([
            'user_id' => '1',
            'role_id' => '1'  
        ]);

//        DB::table('permissions')->insert([
//            'name' => 'create-pos',
//            'display_name' => 'Create POS',
//            'description' => 'Create New Point Of Sale'
//        ]);
//        DB::table('permissions')->insert([
//            'name' => 'list-pos',
//            'display_name' => 'List POS',
//            'description' => 'List All Points Of Sales'
//        ]);
//
//        DB::table('permission_role')->insert([
//            'permission_id' => '1',
//            'role_id' => '1'
//        ]);
//
//        DB::table('permission_role')->insert([
//            'permission_id' => '2',
//            'role_id' => '1'
//        ]);
    }
}
