<?php
require_once("functions.php");
require_once("classes.php");

$coords = get_coords_from_GET();


// Initialize classes
$europe = new europeiana($coords);
$wiki = new wikipedia($coords);
$inst = new institutions($coords);
if(isset($_GET["debug"])){
	$konst = new offkonst($coords);
}

require_once("header.inc.php");



?>

	<!-- Primary Page Layout
	================================================== -->

	<div class="container">
	
	   <?php 

	   echo("<h2>Europeana</h2>");
	   $europe->get_html();

	   echo("<h2>Wikipedia</h2>");
	   $wiki->get_html();

	   echo("<h2>Institutions</h2>");
	   $inst->get_html();
	   
	   if(isset($_GET["debug"])){
		   echo("<h2>Offentlig konst</h2>");
		   $konst->get_html();
		}
	   ?>

	
	</div><!-- container -->

<?php require_once("footer.inc.php"); ?>
