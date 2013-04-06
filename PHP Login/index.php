<?php

session_start();
include_once("./RewardStyle.php");

$rstyle = new RewardStyle();

if(isset($_GET['logout'])){
	unset($_SESSION['token']);
}

if(isset($_SESSION['token'])){
	echo "HELLO YOU ARE LOGGED IN WITH THE TOKEN ".$_SESSION['token']."<br/><br/>";
	echo "<a href='http://your-domain.com?logout=now'>Logout</a>";
} else 
if(isset($_GET['code'])) {
	$rstyle->sendCode($_GET['code']);
} else {
    $rstyle->authenticate();
}

?>

