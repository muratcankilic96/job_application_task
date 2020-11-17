<?php 
header("Access-Control-Allow-Origin: *");
include "header.php"; ?>

<?php
	
	if(!isset($_SESSION["shirts"])) {
		$r = API("https://bad-api-assignment.reaktor.com/products/shirts");
		$r = json_decode($r, true);
		$_SESSION["shirts"] = $r;
	} else {
		$r = $_SESSION["shirts"];
	}
	listing($r, "#A82FA1", "#FFEEFF", 10);
	buttons(sizeof($r), 10);
?>

<?php echo file_get_contents("footer.php"); ?>
