<?php

//Get IP-adress

function get_ip() {
        $ip = 'empty';

        //See if the client was forwarded from a proxy
        foreach ( getallheaders() as $name => $value ) {
                if( strcasecmp( $name, "x-forwarded-for" ) == 0 ) {
                        $ip = $value;
                }
        }
        //If not, use the reported ip
        if ($ip == 'empty') {
                $ip=$_SERVER['REMOTE_ADDR'];
        }
	return $ip;
}

function hostip() { 
	$ip = get_ip();
	//Set query string for geoip api
	$geo_api_url='http://api.hostip.info/get_json.php?ip=' . $ip . '&position=true';

	//Make the request and decode the json
	$string = file_get_contents($geo_api_url);
	$json_coord=json_decode($string,true);

	return  array( "lat" => $json_coord['lat'], "long" => $json_coord['lng'], "city" => $json_coord['city'], );
}


function maxmind() {
	require_once("geodata/geoipcity.inc");
	require_once("geodata/geoipregionvars.php");
	$ip = get_ip();
	$gi = geoip_open("geodata/GeoLiteCity.dat",GEOIP_STANDARD);
	$record = geoip_record_by_addr($gi,$ip);
	$lat = $record->latitude;
	$long = $record->longitude;
	$city = $record->city;
	geoip_close($gi);

	return  array( "lat" => $lat, "long" => $long, "city" => $city, );
}

function check_empty($arr) {
	$check = false;
	foreach($arr as $item) {
		if( empty($item) ) {
			$check = true;
		}
	} 
	return $check;
} 

function get_coord() {
	$arr = maxmind();
	if( check_empty($arr) ) {
		$arr = hostip();
	}
	return $arr;

}

function getbbox($lat, $lon, $side){
	#lat, lon in degrees, side in m
	$deg_per_m = (360.0/40075000);
	
	$latrange = $side * $deg_per_m;
	$blat = ($lat-($latrange/2))%90;
	$tlat = ($lat+($latrange/2))%90;
	
	$lonrange = $side * $deg_per_m/cos(deg2rad($lat));
	$blon = ($lon-($lonrange/2))%180;
	$tlon = ($lon+($lonrange/2))%180;
	
	return array( "blat" => $blat, "blong" => $blon, "tlat" => $tlat, "tlong" => $tlon);
}


function get_coords_from_GET() {
  	return  array( "lat" => $_GET['lat'], "long" => $_GET['long'], "city" => "unknown", );  
}

?>
