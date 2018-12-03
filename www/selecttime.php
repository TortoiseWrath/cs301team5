<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
if(!isset($_GET['title'])) die('No movie specified!');
if(!isset($_GET['theaterID'])) die('No theater specified!');

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

$query = $db->prepare('SELECT showtime FROM SHOWTIME where theaterID = ? AND title = ? AND showtime BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)');
$query->bind_param('ss', $_GET['theaterID'], $_GET['title']);
$showtimes = array();
$showtime = NULL;
$query->bind_result($showtime);
$query->execute();
while($query->fetch()) {
	$showtimes[] = $showtime;
}
$query->close();
?>
<!DOCTYPE html>
<title>Choose a showtime for <?=$_GET['title']?></title>
<link rel="stylesheet" href="style.css">
<h1>Select Time</h1>
<aside>
	<strong><?=$_GET['title']?></strong>
	<p class="rating"><?=$rating?>
	<p class="length"><?=($length>60?(floor($length/60).' hr '):'').($length%60).' min'?>
	<p class="genre"><?=$genre?>
</aside>
<form method="GET" action="ticket.php">
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
