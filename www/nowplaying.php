<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	//header('Location: login.php');
	die();
}
?>
<!DOCTYPE html>
<title>Now Playing</title>
<link rel="stylesheet" href="style.css">
<h1>Now Playing</h1>
<nav class="me">
	<a href="me.php">
		<img src="me.png" alt="Me">
		<br>
		Me
	</a>
	<svg height="0">
		<filter id="mef">
		    <feColorMatrix
		      type="matrix"
		      values="1 0 0 0.32 0
		              0 1 0 0 0
		              0 0 1 0 0
		              0 0 0 1 0 "/>
		</filter>
	</svg>
</nav>
<ul class="nowplaying">
	<?php
	require_once('config.php');
	$query = $db->prepare('SELECT title FROM MOVIE NATURAL JOIN PLAYS_AT WHERE playing=1');
	$query->execute();
	$title = NULL;
	$query->bind_result($title);
	while($query->fetch()): ?>
		<li><a href="movie.php?title=<?=urlencode($title)?>"><?=htmlspecialchars($title)?></a></li>
	<?php endwhile; ?>
</ul>
