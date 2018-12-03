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
	$query = $db->prepare('SELECT releaseDate, MOVIE.rating, length, genre, COUNT(REVIEW.reviewID) AS reviews, AVG(REVIEW.rating) AS avgScore FROM MOVIE LEFT JOIN REVIEW ON MOVIE.title = REVIEW.title WHERE MOVIE.title = ?');
	$query->bind_param('s',$_GET['title']);
	$query->execute();
	$releaseDate = $rating = $length = $genre = $reviews = $avgScore = NULL;
	$query->bind_result($releaseDate, $rating, $length, $genre, $reviews, $avgScore);
	if(!$query->fetch()) {
		die('Movie not found!');
	}
?>
<aside>
	<p class="released">Released: <span><?=$releaseDate?></span>
	<p class="rating"><?=$rating?>
	<p class="length"><?=($length>60?(floor($length/60).' hr '):'').($length%60).' min'?>
	<p class="genre"><?=$genre?>
	<p class="score"><a href="review.php?title=<?=urlencode($_GET['title'])?>"><?php
		$roundedScore = round($avgScore * 2) / 2;
		for($i = 1; $i <= $roundedScore; $i++) {
			echo '<i class="fas fa-star"></i>';
		}
		if($roundedScore - floor($roundedScore)) {
			echo '<i class="fas fa-star-half-alt"></i>';
		}
		for($i = ceil($roundedScore) + 1; $i <= 5; $i++) {
			echo '<i class="far fa-star"></i>';
		}
	?></a>
	<p class="reviews"><a href="review.php?title=<?=urlencode($_GET['title'])?>"><?=number_format($reviews).' Fan Rating'.($reviews==1?'':'s')?></a>
</aside>
<form method="GET">
	<input type="hidden" name="title" value="<?=$_GET['title']?>">
	<button formaction="overview.php">Overview</button>
	<button formaction="review.php">Movie Review</button>
	<button formaction="choosetheater.php">Choose Theater</button>
</form>
