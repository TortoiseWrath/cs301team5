<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
if(!isset($_GET['title'])) die('No movie specified!');
$title = $_GET['title'];
?>
<!DOCTYPE html>
<title>Choose a theater for <?=$_GET['title']?></title>
<link rel="stylesheet" href="style.css">
<h1>Choose Theater</h1>
<form method="GET">
	<input type="hidden" name="title" value="<?=htmlspecialchars($_GET['title'])?>">
	<p>
	<?php
    require_once('config.php');
	$query = $db->prepare('SELECT theaterID, name FROM THEATER NATURAL JOIN PREFERS NATURAL JOIN PLAYS_AT WHERE username = ? AND playing = 1 AND title = ?');
	$query->bind_param('ss',$_SESSION['username'], $_GET['title']);
	$query->execute();
	$query->store_result();
	if($query->num_rows == 0) {
		echo 'You have no saved theaters where ' . $_GET['title'] . ' is playing.';
	}
	else {
		echo '<label for="theaterID">Saved Theater</label> <select id="theaterID" name="theaterID">';
		$theaterID = $theaterName = NULL;
		$query->bind_result($theaterID, $theaterName);
		while($query->fetch()): ?>
			<option value="<?=$theaterID?>"><?=$theaterName?></option>
		<?php endwhile;
		echo '</select> <button formaction="selecttime.php">Choose</button>';
	}
	$query->close();
	?>
	<p>
	<label for="q">City/State/Theater</label>
	<input type="text" name="q" id="q">
	<button formaction="results.php">Search</button>
</form>
