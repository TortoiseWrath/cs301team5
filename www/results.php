<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
if(!isset($_GET['title'])) die('No movie specified!');
if(!isset($_GET['q'])) die('No search query specified!');
?>
<!DOCTYPE html>
<title>Choose a theater for <?=$_GET['title']?></title>
<link rel="stylesheet" href="style.css">
<h1>Results</h1>
<form method="GET" action="selecttime.php">
	<input type="hidden" name="title" value="<?=htmlspecialchars($_GET['title'])?>">
	<ul>
	<?php
    require_once('config.php');
	$query = $db->prepare('SELECT theaterID, name, state, city, street, zip FROM THEATER NATURAL JOIN PLAYS_AT WHERE (lower(state) LIKE ? OR lower(city) LIKE ? OR lower(name) LIKE ?) AND playing = 1 AND title = ?');
	$likeQuery = '%'.strtolower($_GET['q']).'%';
	$query->bind_param('ssss', $likeQuery, $likeQuery, $likeQuery, $_GET['title']);
	$query->execute();
	$query->store_result();
	$theaterID = $theaterName = $state = $city = $street = $zip = NULL;
	$query->bind_result($theaterID, $theaterName, $state, $city, $street, $zip);
	$n = 0;
	while($query->fetch()): $n++; ?>
		<li>
			<input type="radio" name="theaterID" value="<?=$theaterID?>" id="theater<?=$theaterID?>">
			<label for="theater<?=$theaterID?>"><strong><?=$theaterName?></strong><address><?="$street, $city, $state $zip"?></address></label>
		</li>
	<?php endwhile;
	if($n === 0): ?>
		<li class="error">
			No theaters were found matching your criteria.
			<input type="hidden" value="" name="q">
			<button formaction="results.php">View all theaters where <?=$_GET['title']?> is playing</button>
		</li>
		<?php
	endif;
	?>
	</ul>
	<?php if($n > 0): ?>
	<input type="checkbox" id="save" name="save">
	<label for="save">Save this theater</label>
	<button>Next</button>
<?php endif;
$query->close();
?>
</form>
