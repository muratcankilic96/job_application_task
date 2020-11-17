<?php 
header("Access-Control-Allow-Origin: *");
include "header.php"; ?>

<?php
	if(!isset($_SESSION["accessories"])) {
		$r = API("https://bad-api-assignment.reaktor.com/products/accessories");
		$r = json_decode($r, true);
		$_SESSION["accessories"] = $r;
	} else {
		$r = $_SESSION["accessories"];
	}
	listing($r, "#2FB8A1", "#EEFFEE", 10);
	buttons(sizeof($r), 10);
	
?>

<?php echo file_get_contents("footer.php"); ?>
