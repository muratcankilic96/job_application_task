<?php 
header("Access-Control-Allow-Origin: *");
include "header.php"; ?>

<?php
	
	if(!isset($_SESSION["jackets"])) {
		$r = API("https://bad-api-assignment.reaktor.com/products/jackets");
		$r = json_decode($r, true);
		$_SESSION["jackets"] = $r;
	} else {
		$r = $_SESSION["jackets"];
	}
	listing($r, "#2FA1B8", "#EEEEFF", 10);
	buttons(sizeof($r), 10);
?>

<?php echo file_get_contents("footer.php"); ?>
