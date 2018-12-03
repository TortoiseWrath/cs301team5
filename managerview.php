<?php
session_start();
if(!isset($_SESSION['manager'])) {
	// User is not a manager
	header('Location: login.php');
	die();
}
?>

<!DOCTYPE html>
<title>Manager View</title>
<link rel="stylesheet" href="style.css">
<h1>Manager View</h1>

<ul>
	<li><a href="revenue.php">View revenue report</a></li>
	<li><a href="popular.php">View popular movie report</a></li>
</ul>

<form>
	<button formaction="logout.php">Logout</button>
</form>