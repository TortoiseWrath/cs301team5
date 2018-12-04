<!DOCTYPE html>
<?php
if(!isset($_GET['title'])) die('No movie specified!');
$title = $_GET['title'];
?>
<title><?=$_GET['title']?></title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<body class="reviews">
<h1><?=$_GET['title']?></h1>

<?php
	require_once('config.php');
	$query1 = $db->prepare('SELECT AVG(REVIEW.rating) AS avgScore FROM MOVIE LEFT JOIN REVIEW ON MOVIE.title = REVIEW.title WHERE MOVIE.title = ?');
    $query2 = $db->prepare('SELECT reviewTitle, comment, rating FROM REVIEW WHERE REVIEW.title = ?');

	$query1->bind_param('s',$_GET['title']);
    $query2->bind_param('s',$_GET['title']);


	$avgScore = $title = $comment = $rating = NULL;

    $query1->execute();
	$query1->bind_result($avgScore);

	if(!$query1->fetch()) {
		die('No reviews!');
	}
?>

<p class="avgRating">Avg. Rating: <span><?php
        $formatedNum = number_format($avgScore);
        echo $formatedNum;
?></span>

<form method="GET">
	<input type="hidden" name="title" value="<?=$_GET['title']?>">
	<button formaction="givereview.php">Give Review</button>
</form>
<table class="reviews">
<thead><tr><th>Title</th><th>Rating</th><th>Comment</th></tr></thead>
<?php
    $query1->close();
    $query2->execute();
    $query2->bind_result($title, $comment, $rating);

    while($query2->fetch()): ?>
        <tr><td><?=$title?></td><td><?=$rating?></td><td><?=$comment?></td>
<?php
    endwhile;
    $query2->close();
?>
</table>

<form method="GET">
	<input type="hidden" name="title" value="<?=$_GET['title']?>">
	<button formaction="movie.php">Back</button>
</form>
