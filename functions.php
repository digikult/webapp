<?php

//Get IP-adress
function get_coord() { 
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

	//Set query string for geoip api
	$geo_api_url='http://api.hostip.info/get_json.php?ip=' . $ip . '&position=true';

	//Make the request and decode the json
	$string = file_get_contents($geo_api_url);
	$json_coord=json_decode($string,true);

	return  array( "lat" => $json_coord['lat'], "long" => $json_coord['lng'], "city" => $json_coord['city'], );
}

function get_results($coord_info) {
	$url='http://kulturarvsdata.se/ksamsok/api?method=search&hitsPerPage=10&x-api=%22test%22&query=boundingBox=/RT90%20%221628000%206585000%201628490.368%206585865.547%22';
//http://kulturarvsdata.se/ksamsok/api?method=search&hitsPerPage=10&x-api=%22test%22&query=boundingBox=/WGS84
	$results = new SimpleXMLElement($url);
	print_r($results);
}
