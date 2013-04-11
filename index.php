<?php require_once('functions.php');
$coord = get_coord();


require_once("header.inc.php");
?>

	<!-- Primary Page Layout
	================================================== -->

	<div class="container">
        	<image src="images/Corazon.jpg"/><br/>
      		<button id="btnInit" >Find my location via browser/GPS</button><br/><br/>
      		<button onclick="display_coord();">Find my location via IP-address</button><br/><br/>
    
	</div><!-- container -->
        	<div id="basicMap" width="80%" height="100%"></div>
            <p>Heart Image by Ilhh [<a href="http://creativecommons.org/licenses/by-sa/3.0">CC-BY-SA-3.0</a>], <a href="https://commons.wikimedia.org/wiki/File%3ACorazon-.jpg">via Wikimedia Commons</a></p>


<?php require_once("footer.inc.php"); ?>