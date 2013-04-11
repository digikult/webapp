<?php require_once('functions.php');
$coord = get_coord();


require_once("header.inc.php");
?>

	<!-- Primary Page Layout
	================================================== -->

	<div class="container">
	   <div class="hearthbox">
        	<img src="images/logo.png" class="heart"/><br/>
        	
      		<button id="btnInit" >Find my location via browser/GPS</button><br/>
      		<button onclick="display_coord();">Find my location via IP-address</button><br/>
        </div>
    
        	<div id="basicMap" width="100%" height="100%"></div>
	</div><!-- container -->


<?php require_once("footer.inc.php"); ?>
