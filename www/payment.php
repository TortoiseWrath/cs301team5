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

$query = $db->prepare('SELECT cardNumber FROM PAYMENT_INFO WHERE username = ? AND expirationDate >= CURDATE() AND saved = 1');
$query->bind_param('s', $_SESSION['username']);
$cards = array();
$card = NULL;
$query->bind_result($card);
$query->execute();
while($query->fetch()) {
	$cards[] = $card;
}
$query->close();
?>
<!DOCTYPE html>
<title>Buying <?=$totalTickets=$_GET['adult']+$_GET['child']+$_GET['senior']?> ticket<?=$totalTickets==1?'':'s'?> for <?=$_GET['title']?> at <?=$name?></title>
<link rel="stylesheet" href="style.css">
<h1>Buy Ticket</h1>
<aside class="movie">
	<strong><?=$_GET['title']?></strong>
	<p class="rating"><?=$rating?>
	<p class="length"><?=($length>60?(floor($length/60).' hr '):'').($length%60).' min'?>
	<p class="genre"><?=$genre?>
</aside>
<aside class="showtime">
	<?=date('l, F j',strtotime($_GET['time']))?>
	<br>
	<?=date('g:i A',strtotime($_GET['time']))?>
</aside>
<aside class="theater">
	<strong><?=$name?></strong>
	<address><?="$street<br>$city, $state $zip"?></address>
</aside>
<hr>
<form method="POST" action="confirmation.php">
	<h2>Payment Information</h2>
	<div class="saved">
		Use a saved card
		<select name="savedCard">
			<?php foreach($cards as $card): ?>
				<option value="<?=$card?>"><?=substr($card, -4)?></option>
			<?php endforeach; ?>
		</select>
		<button name="use" value="saved">Buy Ticket<?=$totalTickets==1?'':'s'?></button>
	</div>
		<div class="new">
		<strong>Use a new card</strong><br>
		<label for="name">Name on Card</label>
		<input type="text" name="name" id="name">
		<br>
		<label for="cardNumber">Card Number</label>
		<input type="text" name="cardNumber" id="cardNumber">
		<br>
		<label for="cvv">CVV</label>
		<input type="text" name="cvv" id="cvv">
		<br>
		<label for="exp">Expiration Date</label>
		<input type="date" name="exp" id="exp">
		<br>
		<input type="checkbox" id="save" name="save">
		<label for="save">Save this card for later use</label>
		<button value="new" name="use">Submit</button>
	</div>
</form>
