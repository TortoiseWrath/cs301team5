<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
if(!isset($_POST['title'])) die('No movie specified!');
if(!isset($_POST['theaterID'])) die('No theater specified!');
if(!isset($_POST['time'])) die('No showtime specified!');

require_once('config.php');

$query = $db->prepare('SELECT rating, length, genre FROM MOVIE WHERE title = ?');
$query->bind_param('s', $_POST['title']);
$rating = $length = $genre = NULL;
$query->bind_result($rating, $length, $genre);
$query->execute();
$query->fetch();
$query->close();

$query = $db->prepare('SELECT name, state, city, street, zip FROM THEATER WHERE theaterID = ?');
$query->bind_param('s', $_POST['theaterID']);
$name = $state = $city = $street = $zip = NULL;
$query->bind_result($name, $state, $city, $street, $zip);
$query->execute();
$query->fetch();
$query->close();

$query = $db->prepare('SELECT ticketPrice FROM SHOWTIME WHERE showtime = ? AND theaterID = ? AND title = ?');
$query->bind_param('sss', $_POST['time'], $_POST['theaterID'], $_POST['title']);
$ticketPrice = NULL;
$query->bind_result($ticketPrice);
if(!$query->execute()) {
	die($db->errno . ' (' . $db->error . ')');
}
$query->fetch();
$query->close();

$query = $db->prepare('SELECT orderID FROM ORDERS ORDER BY cast(orderID as unsigned) DESC LIMIT 1');
$orderID = NULL;
$query->bind_result($orderID);
if(!$query->execute()) {
	die($db->errno . ' (' . $db->error . ')');
}
$query->fetch();
$query->close();
$orderID = $orderID + 1;

$card = $_POST['use'] === 'new' ? $_POST['cardNumber'] : $_POST['savedCard'];

if(empty($card) || $_POST['use'] === 'new' && (empty($_POST['name']) || empty($_POST['exp']) || empty($_POST['cvv']))) {
	$url = 'payment.php?error=card&'.http_build_query($_POST);
	header("Location: $url");
	die();
}

if($_POST['use'] === 'new') {
	// Save the card.
	$saved = @$_POST['save'] === 'on' ? 1 : 0;
	$query = $db->prepare('INSERT INTO PAYMENT_INFO VALUES(?, ?, ?, ?, ?, ?)');
	$query->bind_param('ssssis', $card, $_POST['exp'], $_POST['name'], $_POST['cvv'], $saved, $_SESSION['username']);
	$query->execute();
	$query->close();
}

$query = $db->prepare('INSERT INTO ORDERS VALUES (?, CURDATE(), CURTIME(), "Completed", ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$totalTickets = $_POST['adult'] + $_POST['child'] + $_POST['senior'];
$query->bind_param('siiiissssd', $orderID, $totalTickets, $_POST['adult'], $_POST['child'], $_POST['senior'], $_SESSION['username'], $card, $_POST['theaterID'], $_POST['title'], $ticketPrice);
if(!$query->execute()) {
	die($db->errno . ' (' . $db->error . ')');
}
$query->close();

?>
<!DOCTYPE html>
<title>Order Confirmation</title>
<link rel="stylesheet" href="style.css">
<h1>Buy Ticket</h1>
<aside class="theater">
	<strong><?=$name?></strong>
	<address><?="$street<br>$city, $state $zip"?></address>
</aside>
<aside class="movie">
	<strong><?=$_POST['title']?></strong>
	<p class="rating"><?=$rating?>
	<p class="length"><?=($length>60?(floor($length/60).' hr '):'').($length%60).' min'?>
</aside>
<aside class="showtime">
	<?=date('l, F j',strtotime($_POST['time']))?>
	<br>
	<?=date('g:i A',strtotime($_POST['time']))?>
</aside>
<hr>
<h2>Confirmation</h2>
<div class="left">
Order ID <span class="orderID"><?=$orderID?></span>
<p class="small">Thank you for your purchase! Please save order ID for your records.
</div>
