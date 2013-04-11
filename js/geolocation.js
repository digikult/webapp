// Shamelessly stolen from http://mobile.tutsplus.com/tutorials/html5/html5-apps-positioning-with-geolocation/

jQuery(window).ready(function() {  
	jQuery("#btnInit").click(initiate_geolocation);  
});  
function initiate_geolocation() {  
	navigator.geolocation.getCurrentPosition(handle_geolocation_query,handle_errors);  
}  
function handle_errors(error) {  
	switch(error.code) {  
		case error.PERMISSION_DENIED: alert("user did not share geolocation data");  
		break;  
		case error.POSITION_UNAVAILABLE: alert("could not detect current position");  
		break;  
		case error.TIMEOUT: alert("retrieving position timed out");  
		break;  
		default: alert("unknown error");  
		break;  
	}  
}  

function handle_geolocation_query(position){  
	var move_on = confirm('Search based on these coordinates: Lat: ' + position.coords.latitude + ' Lon: ' + position.coords.longitude);
	if (move_on == true) {
		window.location="/digikult/results.php?lat=" + position.coords.latitude + "&long=" + position.coords.longitude;
        } 
} 
