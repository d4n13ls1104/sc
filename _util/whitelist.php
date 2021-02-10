<?php
include "../_util/config.php";
$whitelisted = true;
$m = true;

$ip = $_SERVER["REMOTE_ADDR"];
$agent = $_SERVER["HTTP_USER_AGENT"];

$ip = mysqli_real_escape_string($conn, $ip);
$agent = mysqli_real_escape_string($conn, $agent);

if($_SERVER["REMOTE_ADDR"] != "::1") $logVisit = mysqli_query($conn, "INSERT INTO visits (ip, user_agent) VALUES ('$ip', '$agent')");

$whitelisted_ips = array(
	"::1",
	"72.197.46.61",
	"73.191.171.131",
	"192.168.0.30",
	"24.255.39.70",
	"71.91.2.252"
);

foreach($whitelisted_ips as $ip) {
	if($_SERVER["REMOTE_ADDR"] == $ip) {
		$whitelisted = false;
		break;
	}
}

if($m && $_SERVER["REMOTE_ADDR"] != "::1") {
	die("This page is down for maintenance");
}

if($whitelisted) {
	die("Whitelisted.");
}
?>
