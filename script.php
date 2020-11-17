<?php

// Sends HTTPS request to server.
function API($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$arresponse = curl_exec($ch);
	curl_close($ch);
	
	return $arresponse;
}

// Converts the manufacturer table into an associative array for later easy access.
function hash_manufacturer($manu_name) {
	for($i = 0; $i < sizeof($manu_name); $i++) {
		$x = $manu_name[$i];
		$hashed_manu[$x["id"]] = $x["DATAPAYLOAD"];
	}
	return $hashed_manu;
}

// Gets the manufacturer information from server.
function get_manufacturer($manu_name) {
	if(!isset($_SESSION[$manu_name])) {
		$r = API("https://bad-api-assignment.reaktor.com/availability/" . $manu_name);
		$r = json_decode($r, true);
		$r = hash_manufacturer($r["response"]);
		$_SESSION[$manu_name] = $r;
	} else {
		$r = $_SESSION[$manu_name];
	}
	return $r;
}

// Compares ID number between the one with manufacturer API.
function compare_id_to_manu($id, $manu_name) {
	$id_u = strtoupper($id);
	if(isset($manu_name[$id_u])) {
		$x = $manu_name[$id_u];
		echo $x;
	}
}

// Lists the data received from API request.
function listing($arr, $color1, $color2, $per) {
	if( isset($_GET['pg']) ) {
		$pg = $_GET['pg'];
	} else {
		$pg = 1;
	}
	for($i = $per * ($pg - 1); $i < (10 * ($pg - 1) + $per) & $i < sizeof($arr); $i++) {
		echo "<div style='border: 5px solid " . $color1 . "; background-color:" . $color2 . "'>";
		$obj = $arr[$i];
		echo "<ul style='list-style-type:none;'>";
		echo "<li><b>NAME: </b>" . ($obj["name"]) . "</li>";
		echo "<li><b>PRICE: </b>" . ($obj["price"]) . "€" . "</li>";
		echo "<li><b>MANUFACTURER: </b>" . ($obj["manufacturer"]) . "</li>";
		$m = get_manufacturer($obj["manufacturer"]);
		echo "<li><b>STOCK SITUATION: </b>";
		compare_id_to_manu($obj["id"], $m);
		echo "<li><b>AVAILABLE IN COLORS OF: </b>";
		echo "<li><ul>";
		$clrs = $obj["color"];
		for($j = 0; $j < sizeof($clrs); $j++) {
			echo "<li>" . $clrs[$j] . "</li>";
		}
		echo "</ul></li>";
		echo "</ul>";
		echo "</div>";
		echo "<br>";
	}
}

// Add page buttons and number below.
function buttons($n, $per) {
	$p_tot = ceil($n / $per);
	$dis_bw = "";
	$dis_fw = "";
	$pname = basename($_SERVER['PHP_SELF']);
	if( isset($_GET['pg']) ) {
		$pg = $_GET['pg'];
	} else {
		$pg = 1;
	}
	if($pg == 1)
		$dis_bw = "disabled";
	if($pg == $p_tot)
		$dis_fw = "disabled";
	echo "<form action='/" . $pname . "' method='get'>";
		echo "<button name='pg' value='" . ($pg - 1) ."' " . $dis_bw . "> << </button>";
		echo "Page " . $pg;
		echo "<button name='pg' value='" . ($pg + 1) ."' " . $dis_fw . "> >> </button>";
	echo "</form>";
	echo "There are " . $p_tot . " pages.";
}
?>