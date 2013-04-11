<?php require_once('functions.php');
$coord = get_coord();
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
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

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>DigiKult</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
        <link rel="stylesheet" href="stylesheets/maps.css"/>
	<link rel="stylesheet" href="stylesheets/base.css">
	<link rel="stylesheet" href="stylesheets/skeleton.css">
	<link rel="stylesheet" href="stylesheets/layout.css">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

</head>
<body onload="map_init();">



	<!-- Primary Page Layout
	================================================== -->

	<div class="container">
        	<image src="images/Corazon.jpg"/><br/>
      		<button id="btnInit" >Find my location via browser/GPS</button><br/><br/>
      		<button onclick="display_coord();">Find my location via IP-address</button><br/><br/>
	</div><!-- container -->
    	<div id="basicMap" width="80%" height="100%"></div>
        <p>Heart Image by Ilhh [<a href="http://creativecommons.org/licenses/by-sa/3.0">CC-BY-SA-3.0</a>], <a href="https://commons.wikimedia.org/wiki/File%3ACorazon-.jpg">via Wikimedia Commons</a></p>


<!-- End Document
================================================== -->
</body>
</html>
