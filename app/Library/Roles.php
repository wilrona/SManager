<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library;

class Roles {

	function __construct() {

	}

	protected $ListeRoles = array(
		array(
			'name' => 'users', 'display_name' => 'Utilisateurs', 'description' => 'Module de gestion des utilisateurs',
			'child' => array(
				array('name'=> 'create_user', 'display_name' => 'Creation des utilisateurs', 'description' => '')
			),
			'active' => true,
			'config' => true
		),
		array(
			'name' => 'profiles', 'display_name' => 'Profiles', 'description' => 'Module de gestion des profiles',
			'child' => array(),
			'active' => false,
			'config' => false
		),
		array(
			'name' => 'magasins', 'display_name' => 'Magasins', 'description' => 'Module de gestion des magasins',
			'child' => array(),
			'active' => false,
			'config' => true
		),
		array(
			'name' => 'demandes', 'display_name' => 'Demande de stock', 'description' => 'Module de gestion des demandes de stock',
			'child' => array(),
			'active' => false,
			'config' => true
		),
		array(
			'name' => 'point_de_vente', 'display_name' => 'Points de vente', 'description' => 'Module de gestion des points de vente',
			'child' => array(),
			'active' => false,
			'config' => true
		),
		array(
			'name' => 'produits', 'display_name' => 'Produits', 'description' => 'Module de gestion des produits',
			'child' => array(),
			'active' => false,
			'config' => true
		),
		array(
			'name' => 'famillesP', 'display_name' => 'Familles de produit', 'description' => 'Module de gestion des familles de produit',
			'child' => array(),
			'active' => false,
			'config' => true
		),
		array(
			'name' => 'famillesC', 'display_name' => 'Familles de client', 'description' => 'Module de gestion des clients',
			'child' => array(),
			'active' => false,
			'config' => true
		),
		array(
			'name' => 'unites', 'display_name' => 'Unités', 'description' => 'Module de gestion des unités de produit',
			'child' => array(),
			'active' => false,
			'config' => true
		),
		array(
			'name' => 'caisses', 'display_name' => 'Caisses', 'description' => 'Module de gestion des caisses',
			'child' => array(),
			'active' => false,
			'config' => true
		),
		array(
			'name' => 'clients', 'display_name' => 'Clients', 'description' => 'Module de gestion des clients',
			'child' => array(),
			'active' => false,
			'config' => true
		),
		array(
			'name' => 'parametrages', 'display_name' => 'Paramètres Généraux', 'description' => 'Module de gestion des paramètres généraux',
			'child' => array(),
			'active' => false,
			'config' => true
		)
	);

	protected $listRoles=[
		['id' => 1,
		 'name' => 'administration',
		 'display_name' => 'Super Admin',
		 'description' => 'Administration',
                 'parent_id' => null
                 
                 ] ,
		['id' => 2,
		 'name' => 'Point_vente',
		 'display_name' => 'Gestion  point de vente',
		 'description' => 'Point de vente',
                 'parent_id' => null] ,
		['id' => 3,
		 'name' => 'user',
		 'display_name' => 'Gestion utilisateur',
		 'description' => 'Utilisateur',
                 'parent_id' => null    ] ,
		['id' => 4,
		 'name' => 'precommande',
		 'display_name' => 'Gestion précommande',
		 'description' => 'Precommande',
                  'parent_id' => null] ,
		['id' => 5,
		 'name' => 'produit',
		 'display_name' => 'Gestion Produit',
		 'description' => 'Produit',
                 'parent_id' => null],
		['id' => 6,
		 'name' => 'compte',
		 'display_name' => 'Gestion compte',
		 'description' => 'Administration',
                    'parent_id' => null],
		['id' => 7,
		 'name' => 'ventes',
		 'display_name' => 'Gestion des ventes',
		 'description' => 'ventes',
                 'parent_id' => null],
             
		['id' => 8,
		 'name' => 'add-pos',
		 'display_name' => 'Ajouter un point de vente',
		 'description' => 'Point de vente','parent_id' => 2,
                 'type' => 'add'
                 ] ,
		['id' => 9,
		 'name' => 'add-user',
		 'display_name' => 'Ajouter un user',
		 'description' => 'Utilisateur' ,'parent_id' => 3, 'type' => 'add'] ,
		['id' => 10,
		 'name' => 'add-preorder',
		 'display_name' => 'Effectuer une précommande',
		 'description' => 'Precommande','parent_id' => 4 , 'type' => 'add'   ] ,
		['id' => 11,
		 'name' => 'add-product',
		 'display_name' => 'Ajouter Produit',
		 'description' => 'Produit','parent_id' => 5 , 'type' => 'add'   ],
		['id' => 12,
		 'name' => 'edit-account',
		 'display_name' => 'Modifier compte',
		 'description' => 'Administration','parent_id' => 6 , 'type' => 'update'   ],
		['id' => 13,
		 'name' => 'validate-preorder',
		 'display_name' => 'Valider une précommande',
		 'description' => 'Precommande','parent_id' => 4 , 'type' => 'other'   ],
                 ['id' => 14,
		 'name' => 'super-admin',
		 'display_name' => 'Super Admin',
		 'description' => 'Administration',
                 'parent_id' => 1, 'type' => 'other'
                 ] ,
                 ['id' => 15,
		 'name' => 'update-pos',
		 'display_name' => 'Modifier un point de vente',
		 'description' => 'Point de vente','parent_id' => 2,
                 'type' => 'update'
                 ] ,
                 ['id' => 16,
		 'name' => 'changestate-pos',
		 'display_name' => 'Activé/desactivé un point de vente',
		 'description' => 'Point de vente','parent_id' => 2,
                 'type' => 'changestate'
                 ] ,
                ['id' => 17,
		 'name' => 'update-user',
		 'display_name' => 'Modifier un user',
		 'description' => 'Utilisateur' ,'parent_id' => 3, 'type' => 'update'] ,
                ['id' => 18,
		 'name' => 'changestate-user',
		 'display_name' => 'Activé/desactivé un user',
		 'description' => 'Utilisateur' ,'parent_id' => 3, 'type' => 'changestate'] ,
                ['id' => 19,
		 'name' => 'update-product',
		 'display_name' => 'Modifier Produit',
		 'description' => 'Produit','parent_id' => 5 , 'type' => 'update'   ],
                 ['id' => 20,
		 'name' => 'manage-caisse',
		 'display_name' => 'Gestion caisse',
		 'description' => 'Caisse',
                 'parent_id' => null
                 
                 ] ,
                 ['id' => 21,
		 'name' => 'close-caisse',
		 'display_name' => 'Fermer la caisse',
		 'description' => 'Produit','parent_id' => 20 , 'type' => 'other'],
	];
        
       /* protected $listPermissions=[
		['id' => 1,
		 'name' => 'super-admin',
		 'display_name' => 'Super Admin',
		 'description' => 'Administration'
                 ] ,
		['id' => 2,
		 'name' => 'add-pos',
		 'display_name' => 'Ajouter un point de vente',
		 'description' => 'Point de vente'    ] ,
		['id' => 3,
		 'name' => 'add-user',
		 'display_name' => 'Ajouter un user',
		 'description' => 'Utilisateur'    ] ,
		['id' => 4,
		 'name' => 'add-preorder',
		 'display_name' => 'Effectuer une précommande',
		 'description' => 'Precommande'    ] ,
		['id' => 5,
		 'name' => 'add-product',
		 'display_name' => 'Ajouter Produit',
		 'description' => 'Produit'    ],
		['id' => 6,
		 'name' => 'edit-account',
		 'display_name' => 'Modifier compte',
		 'description' => 'Administration'    ],
		['id' => 7,
		 'name' => 'validate-preorder',
		 'display_name' => 'Valider une précommande',
		 'description' => 'Precommande'    ]
	];
        
          protected $permission_role=[
		['permission_id' => 1,
		 'role_id' => 1
                 ],
                ['permission_id' => 2,
		 'role_id' => 2
                 ],
                ['permission_id' => 3,
		 'role_id' => 3
                 ],
                ['permission_id' => 4,
		 'role_id' => 4
                 ],
                ['permission_id' => 5,
		 'role_id' => 5
                 ],
                ['permission_id' => 6,
		 'role_id' => 6
                 ],
                ['permission_id' => 7,
		 'role_id' => 4
                 ]
	];*/
          
	public function listRoles(){
		return $this->ListeRoles;
	}

}