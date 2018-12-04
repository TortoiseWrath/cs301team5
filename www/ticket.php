<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
if(!isset($_GET['title'])) die('No movie specified!');
if(!isset($_GET['theaterID'])) die('No theater specified!');
if(!isset($_GET['time']) || empty($_GET['time'])) {
	$url = 'selecttime.php?error=time&'.http_build_query($_GET);
	header("Location: $url");
	die();
}

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
<title>Buy tickets for <?=$_GET['title']?> at <?=$name?></title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
	var adultTotal = 0;
	var childTotal = 0;
	var seniorTotal = 0;
	$(document).ready(function() {
		$('select[name="adult"]').change(function() {
			adultTotal = <?=$ticketPrice?> * $(this).val();
			$('td#adultTotal').text("$" + adultTotal.toFixed(2));
		});
		$('select[name="child"]').change(function() {
			childTotal = <?=$ticketPrice * (100 - $childDiscount) / 100?> * $(this).val();
			$('td#childTotal').text("$" + childTotal.toFixed(2));
		});
		$('select[name="senior"]').change(function() {
			seniorTotal = <?=$ticketPrice * (100 - $seniorDiscount) / 100?> * $(this).val();
			$('td#seniorTotal').text("$" + seniorTotal.toFixed(2));
		});
		$('select').change(function() {
			$('td#TOTAL').text('$' + (adultTotal + childTotal + seniorTotal).toFixed(2));
		}).change();
	});
</script>
<h1>Buy Ticket</h1>
<aside class="theater">
	<strong><?=$name?></strong>
	<address><?="$street<br>$city, $state $zip"?></address>
</aside>
<aside class="movie">
	<strong><?=$_GET['title']?></strong>
	<p class="rating"><?=$rating?>
	<p class="length"><?=($length>60?(floor($length/60).' hr '):'').($length%60).' min'?>
</aside>
<aside class="showtime">
	<?=date('l, F j',strtotime($_GET['time']))?>
	<br>
	<?=date('g:i A',strtotime($_GET['time']))?>
</aside>
<hr>
<form method="GET" action="payment.php">
	<input type="hidden" name="title" value="<?=htmlspecialchars($_GET['title'])?>">
	<input type="hidden" name="theaterID" value="<?=htmlspecialchars($_GET['theaterID'])?>">
	<input type="hidden" name="time" value="<?=htmlspecialchars($_GET['time'])?>">
	<h2>How many ticket?</h2>
	<?php if(@$_GET['error'] == 'zero'): ?>
		<p class="formError">You must buy at least one ticket.</p>
	<?php endif; ?>
	<table>
		<tr class="adult">
			<th>Adult</th>
			<td><select name="adult">
				<?php for($i = 0; $i <= 20; $i++): ?>
					<option value="<?=$i?>"><?=$i?></option>
				<?php endfor; ?>
			</td>
			<td>&times; $<?=number_format($ticketPrice, 2)?></td>
			<td>=</td>
			<td id="adultTotal">$0.00</td>
		</tr>
		<tr class="senior">
			<th>Senior</th>
			<td><select name="senior">
				<?php for($i = 0; $i <= 20; $i++): ?>
					<option value="<?=$i?>"><?=$i?></option>
				<?php endfor; ?>
			</td>
			<td>&times; $<?=number_format($ticketPrice, 2)." &times; ".(100-$seniorDiscount)."%"?></td>
			<td>=</td>
			<td id="seniorTotal">$0.00</td>
		</tr>
		<tr class="child">
			<th>Child</th>
			<td><select name="child">
				<?php for($i = 0; $i <= 20; $i++): ?>
					<option value="<?=$i?>"><?=$i?></option>
				<?php endfor; ?>
			</td>
			<td>&times; $<?=number_format($ticketPrice, 2)." &times; ".(100-$childDiscount)."%"?></td>
			<td>=</td>
			<td id="childTotal">$0.00</td>
		</tr>
		<tr class="total">
			<th colspan="4">Total</th>
			<td id="TOTAL">$0.00</td>
		</tr>
	</table>
	<button>Next</button>
</form>
