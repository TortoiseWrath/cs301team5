<!DOCTYPE html>
<?php
if(!isset($_GET['title'])) die('No movie specified!');
$title = $_GET['title'];
?>
<title><?=$_GET['title']?></title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<h1><?=$_GET['title']?></h1>
<?php
    require_once('config.php');
	$query = $db->prepare('SELECT synopsis, cast FROM MOVIE WHERE MOVIE.title = ?');
	$query->bind_param('s',$_GET['title']);
	$query->execute();
	$synopsis = $cast = NULL;
	$query->bind_result($synopsis, $cast);
	if(!$query->fetch()) {
		die('Movie not found!');
	}
?>
<aside>
	<p class="synopsis">Synopsis <br> <?=$synopsis?>
	<p class="cast">Cast <br> <?=$cast?>
</aside>
<form method="GET">
	<input type="hidden" name="title" value="<?=$_GET['title']?>">
	<button formaction="movie.php">Back</button>
</form>
