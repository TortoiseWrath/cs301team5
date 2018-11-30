<!DOCTYPE html>
<?php
if(!isset($_GET['title'])) die('No movie specified!');
$title = $_GET['title'];
?>
<title><?=$_GET['title']?></title>
<link rel="stylesheet" href="style.css">
<h1><?=$_GET['title']?></h1>
<?php
	require_once('config.php');
	$query = $db->prepare('SELECT releaseDate, MOVIE.rating, length, genre, COUNT(REVIEW.reviewID) AS reviews, AVG(REVIEW.rating) AS avgScore FROM MOVIE LEFT JOIN REVIEW ON MOVIE.title = REVIEW.title WHERE MOVIE.title = ?');
	$query->bind_param('s',$_GET['title']);
	$query->execute();
	$releaseDate = $rating = $length = $genre = $reviews = $avgScore = NULL;
	$query->bind_result($releaseDate, $rating, $length, $genre, $reviews, $avgScore);
	if(!$query->fetch()) {
		die('Movie not found!');
	}
?>
Release date: <?=$releaseDate?><br>
Rating: <?=$rating?><br>
Length: <?=$length?><br>
Genre: <?=$genre?><br>
Reviews: <?=$reviews?><br>
AvgScore: <?=$avgScore?><br>
