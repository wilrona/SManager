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

	public $listNationalite = [
		'Afghanistan',
		'Albania',
		'Algeria',
		'American Samoa',
		'Andorra',
		'Angola',
		'Anguilla',
		'Antarctica',
		'Antigua and Barbuda',
		'Argentina',
		'Armenia',
		'Aruba',
		'Australia',
		'Austria',
		'Azerbaijan',
		'Bahamas',
		'Bahrain',
		'Bangladesh',
		'Barbados',
		'Belarus',
		'Belgium',
		'Belize',
		'Benin',
		'Bermuda',
		'Bhutan',
		'Bolivia',
		'Bosnia and Herzegovina',
		'Botswana',
		'Bouvet Island',
		'Brazil',
		'British Indian Ocean Territory',
		'Brunei Darussalam',
		'Bulgaria',
		'Burkina Faso',
		'Burundi',
		'Cambodia',
		'Cameroon',
		'Canada',
		'Cape Verde',
		'Cayman Islands',
		'Central African Republic',
		'Chad',
		'Chile',
		'China',
		'Christmas Island',
		'Cocos (Keeling) Islands',
		'Colombia',
		'Comoros',
		'Congo',
		'Congo, The Democratic Republic of The',
		'Cook Islands',
		'Costa Rica',
		'Cote D\'ivoire',
        'Croatia',
        'Cuba',
        'Cyprus',
        'Czech Republic',
        'Denmark',
        'Djibouti',
        'Dominica',
        'Dominican Republic',
        'Ecuador',
        'Egypt',
        'El Salvador',
        'Equatorial Guinea',
        'Eritrea',
        'Estonia',
        'Ethiopia',
        'Falkland Islands (Malvinas)',
        'Faroe Islands',
        'Fiji',
        'Finland',
        'France',
        'French Guiana',
        'French Polynesia',
        'French Southern Territories',
        'Gabon',
        'Gambia',
        'Georgia',
        'Germany',
        'Ghana',
        'Gibraltar',
        'Greece',
        'Greenland',
        'Grenada',
        'Guadeloupe',
        'Guam',
        'Guatemala',
        'Guinea',
        'Guinea-bissau',
        'Guyana',
        'Haiti',
        'Heard Island and Mcdonald Islands',
        'Holy See (Vatican City State)',
        'Honduras',
        'Hong Kong',
        'Hungary',
        'Iceland',
        'India',
        'Indonesia',
        'Iran, Islamic Republic of',
        'Iraq',
        'Ireland',
        'Israel',
        'Italy',
        'Jamaica',
        'Japan',
        'Jordan',
        'Kazakhstan',
        'Kenya',
        'Kiribati',
        'Korea, Democratic People\'s Republic of',
        'Korea, Republic of',
        'Kuwait',
        'Kyrgyzstan',
        'Lao People\'s Democratic Republic',
		'Latvia',
		'Lebanon',
		'Lesotho',
		'Liberia',
		'Libyan Arab Jamahiriya',
		'Liechtenstein',
		'Lithuania',
		'Luxembourg',
		'Macao',
		'Macedonia, The Former Yugoslav Republic of',
		'Madagascar',
		'Malawi',
		'Malaysia">Malaysia',
		'Maldives',
		'Mali',
		'Malta',
		'Marshall Islands',
		'Martinique',
		'Mauritania',
		'Mauritius',
		'Mayotte',
		'Mexico',
		'Micronesia, Federated States of',
		'Moldova, Republic of',
		'Monaco',
		'Mongolia',
		'Montserrat',
		'Morocco',
		'Mozambique',
		'Myanmar',
		'Namibia',
		'Nauru',
		'Nepal',
		'Netherlands',
		'Netherlands Antilles',
		'New Caledonia',
		'New Zealand',
		'Nicaragua',
		'Niger',
		'Nigeria',
		'Niue',
		'Norfolk Island',
		'Northern Mariana Islands',
		'Norway',
		'Oman',
		'Pakistan',
		'Palau',
		'Palestinian Territory, Occupied',
		'Panama',
		'Papua New Guinea',
		'Paraguay',
		'Peru">Peru',
		'Philippines',
		'Pitcairn',
		'Poland',
		'Portugal',
		'Puerto Rico',
		'Qatar',
		'Reunion',
		'Romania',
		'Russian Federation',
		'Rwanda',
		'Saint Helena',
		'Saint Kitts and Nevis',
		'Saint Lucia',
		'Saint Pierre and Miquelon',
		'Saint Vincent and The Grenadines',
		'Samoa',
		'San Marino',
		'Sao Tome and Principe',
		'Saudi Arabia',
		'Senegal',
		'Serbia and Montenegro',
		'Seychelles',
		'Sierra Leone',
		'Singapore',
		'Slovakia',
		'Slovenia',
		'Solomon Islands',
		'Somalia',
		'South Africa',
		'South Georgia and The South Sandwich Islands',
		'Spain',
		'Sri Lanka',
		'Sudan',
		'Suriname',
		'Svalbard and Jan Mayen',
		'Swaziland',
		'Sweden',
		'Switzerland',
		'Syrian Arab Republic',
		'Taiwan, Province of China',
		'Tajikistan',
		'Tanzania, United Republic of',
		'Thailand',
		'Timor-leste',
		'Togo',
		'Tokelau',
		'Tonga',
		'Trinidad and Tobago',
		'Tunisia',
		'Turkey',
		'Turkmenistan',
		'Turks and Caicos Islands',
		'Tuvalu',
		'Uganda',
		'Ukraine',
		'United Arab Emirates',
		'United Kingdom',
		'United States',
		'United States Minor Outlying Islands',
		'Uruguay',
		'Uzbekistan',
		'Vanuatu',
		'Venezuela',
		'Viet Nam',
		'Virgin Islands, British',
		'Virgin Islands, U.S.',
		'Wallis and Futuna',
		'Western Sahara',
		'Yemen',
		'Zambia',
		'Zimbabwe',
	];
    
    function __construct() {
        
    }

	public function dateToMySQL($date){
		$tabDate = explode('/' , $date);
		$date  = $tabDate[2].'-'.$tabDate[1].'-'.$tabDate[0];
		$date = date( 'Y-m-d H:i:s', strtotime($date) );
		return $date;
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

		$countlen = strlen($count);

		if($countlen <= $lenght):
			$fix = str_pad($count, $lenght, 0, STR_PAD_LEFT);
		else:
			$fix = str_pad($count, $countlen, 0, STR_PAD_LEFT);
		endif;

		$parent = $parent_prefix ? $parent_prefix.'/' : '';

		if(is_object($prefix)){
			$mot = $parent.''.$prefix->value.'/'.date("Y").'/'.$fix;
		}else{
			$mot = $parent.''.date("Y").'/'.$fix.$fix;
		}

		return $mot;
	}


}
