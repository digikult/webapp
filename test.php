<?php
require_once('functions.php');
$coord = get_coord();
?>
<!DOCTYPE html>  
<html>  
  <head>  
	<link rel="stylesheet" type="text/css" href="stylesheets/maps.css"/>
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/geolocation.js"></script>
    <script src="js/maps.js"></script>
    <script src="js/main.js"></script>
    <script src="maps/OpenLayers.js"></script>
    <script>
	function display_coord() {
		var move_on = confirm("Search based on these coordinates: Lat: <?php echo $coord['lat'] ?> Long: <?php echo $coord['long'] ?>");
		if (move_on == true) {
   			window.location="/digikult/results.php?lat=<?php echo $coord['lat'] ?>&long=<?php echo $coord['long'] ?>";
		}
	}
    </script>
  </head>  
  <body onload="map_init();">  
    <div>  
      <button id="btnInit" >Find my location via browser/GPS</button><br>  
      <button onclick="display_coord();">Find my location via IP-address</button>  
    </div>  
    <div id="basicMap"></div>
  </body>  
</html> 
