<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomFunction
 *
 * @author Admin
 */

namespace App\Library;
use PhpParser\Node\Expr\Array_;

class CustomFunction {
    
    function __construct() {
        
    }

    //si le parent est 0, on stocke la valeur nulle
    public function transformtonull($value) {
	if($value=="0"){
            $value=null;
        }
        
        return $value;
    }

    public function NumeroSerie($number = 5){
	    $car = $number;

	    $string = strval(date('dmY'));
	    $chaine = "1234567890";
	    srand((double)microtime()*1000000);
	    for($i=0; $i<$car; $i++) {
		    $string .= $chaine[rand()%strlen($chaine)];
	    }

	    return $string;
    }

	function multidimensional_search($parents, $searched) {
		if (empty($searched) || empty($parents)) {
			return false;
		}

		foreach ($parents as $key => $value) {
			$exists = true;
			foreach ($searched as $skey => $svalue) {
				$exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);
			}
			if($exists){ return $key; }
		}

		return false;
	}

	function getStatePrecommande($state){
		$resp="Précommande annulée";
		if($state==0){$resp="Précommande Réfusée ";}
		else if($state==1){$resp="Précommande Validée";}
		else if($state==2){$resp="Précommande En cours de traitement";}

		return $resp;
	}

	public function randomPassword($length,$count, $characters) {

		$symbols = array();
		$passwords = array();
		$used_symbols = '';
		$pass = '';
		$symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
		$symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$symbols["numbers"] = '1234567890';

		$characters = explode(",",$characters);
		foreach ($characters as $key=>$value) {
			$used_symbols .= $symbols[$value];
		}
		$symbols_length = strlen($used_symbols) - 1;

		for ($p = 0; $p < $count; $p++) {
			$pass = '';
			for ($i = 0; $i < $length; $i++) {
				$n = rand(0, $symbols_length);
				$pass .= $used_symbols[$n];
			}
			$passwords[] = $pass;
		}

		return $passwords[0];
	}

	public function setReference($prefix = '', $count = 1, $lenght = 7, $parent_prefix = ''){

		$fix = str_pad($count, $lenght, 0, STR_PAD_LEFT);
		if(is_object($prefix)){
			$mot = $parent_prefix.''.$prefix->value.''.$fix;
		}else{
			$mot = $parent_prefix.'';
		}

		return $mot;
	}


}
