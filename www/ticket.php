<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
if(!isset($_GET['title'])) die('No movie specified!');
if(!isset($_GET['theaterID'])) die('No theater specified!');
if(!isset($_GET['time'])) die('No showtime specified!');

require_once('config.php');

if($_GET['save'] == 'on') {
	// Save the theater to the user's preferred theaters.
	$insertion = $db->prepare('INSERT INTO PREFERS VALUES (?, ?)');
	$insertion->bind_param('ss', $_GET['theaterID'], $_SESSION['username']);
	$insertion->execute();
	$insertion->close();
}

$query = $db->prepare('SELECT rating, length, genre FROM MOVIE WHERE title = ?');
$query->bind_param('s', $_GET['title']);
$rating = $length = $genre = NULL;
$query->bind_result($rating, $length, $genre);
$query->execute();
$query->fetch();
$query->close();

$query = $db->prepare('SELECT name, state, city, street, zip FROM THEATER WHERE theaterID = ?');
$query->bind_param('s', $_GET['theaterID']);
$name = $state = $city = $street = $zip = NULL;
$query->bind_result($name, $state, $city, $street, $zip);
$query->execute();
$query->fetch();
$query->close();

$query = $db->prepare('SELECT childDiscount, seniorDiscount FROM SYSTEMINFO');
$childDiscount = $seniorDiscount = NULL;
$query->bind_result($childDiscount, $seniorDiscount);
$query->execute();
$query->fetch();
$query->close();

$query = $db->prepare('SELECT ticketPrice FROM SHOWTIME WHERE showtime = ? AND theaterID = ? AND title = ?');
$query->bind_param('sss', $_GET['time'], $_GET['theaterID'], $_GET['title']);
$ticketPrice = NULL;
$query->bind_result($ticketPrice);
$query->execute();
$query->fetch();
$query->close();
?>
<!DOCTYPE html>
<title>Buy tickets for <?=$_GET['title']?> at <?=$theaterName?></title>
<link rel="stylesheet" href="style.css">
<h1>Buy Ticket</h1>
<aside class="movie">
	<strong><?=$_GET['title']?></strong>
	<p class="rating"><?=$rating?>
	<p class="length"><?=($length>60?(floor($length/60).' hr '):'').($length%60).' min'?>
	<p class="genre"><?=$genre?>
</aside>
<aside class="showtime">
	<?=date('l, F j<br>g:i A', strtotime($_GET['time']))?>
</aside>
<aside class="theater">
	<strong><?=$name?></strong>
	<address><?="$street<br>$city, $state $zip"?></address>
</aside>
<hr>
<form method="GET" action="payment.php">
	<h2>How many ticket?</h1>
	<input type="hidden" name="title" value="<?=htmlspecialchars($_GET['title'])?>">
	<input type="hidden" name="theaterID" value="<?=htmlspecialchars($_GET['theaterID'])?>">
	<ul>
	<?php foreach($showtimes as $showtime): ?>
		<li>
			<input type="radio" id="<?=urlencode($showtime)?>" name="time" value="<?=htmlspecialchars($showtime)?>">
			<label for="<?=urlencode($showtime)?>"><?=date('F j, g:i A',strtotime($showtime))?></label>
		</li>
	<?php endforeach; ?>
	</ul>
	<button>Next</button>
</form>
