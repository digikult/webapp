<?php
require_once("functions.php");
require_once("classes.php");

$coords = get_coords_from_GET();


// Initialize classes
$europe = new europeiana($coords);


require_once("header.inc.php");



?>

	<!-- Primary Page Layout
	================================================== -->

	<div class="container">
	
	   <?php 
	   $europe->get_html();
	   ?>

	
	</div><!-- container -->

<?php require_once("footer.inc.php"); ?>