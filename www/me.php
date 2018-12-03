<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
?>
<!DOCTYPE html>
<title>Me</title>
<link rel="stylesheet" href="style.css">
<h1>Me</h1>

<ul>
	<li><a href="orderhistory.php">My Order History</a></li>
	<li><a href="mypayment.php">My Payment Information</a></li>
	<li><a href="mypreferred.php">My Preferred Theater</a></li>
</ul>

<form>
	<button formaction="nowplaying.php">Back</button>
	<button formaction="logout.php">Logout</button>
</form>
