<?php
require_once('functions.php');
$coord = get_coord();
?>
<!DOCTYPE html>  
<html>  
  <head>  
	<link rel="stylesheet" type="text/css" href="stylesheets/main.css"/>
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
	<image src="images/Corazon.jpg"/><br/>
      <button id="btnInit" >Find my location via browser/GPS</button><br/><br/>  
      <button onclick="display_coord();">Find my location via IP-address</button><br/><br/>  
    </div>  
    <div id="basicMap"></div>
	<p>Heart Image by Ilhh [<a href="http://creativecommons.org/licenses/by-sa/3.0">CC-BY-SA-3.0</a>], <a href="https://commons.wikimedia.org/wiki/File%3ACorazon-.jpg">via Wikimedia Commons</a></p>
  </body>  
</html> 
