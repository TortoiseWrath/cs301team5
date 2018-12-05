<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
if(!isset($_GET['title'])) die('No movie specified!');

require_once('config.php');

$query = $db->prepare('SELECT COUNT(*) FROM ORDERS WHERE username = ? AND title = ?');
$query->bind_param('ss', $_SESSION['username'], $_GET['title']);
$count = NULL;
$query->bind_result($count);
$query->execute();
$query->fetch();
$query->close();

$emptyComment = 0;

if(isset($_POST['title']) && $count >= 1){
	if(empty(trim($_POST['comment']))) {
		$emptyComment = 1;
	}
	else {
	    $query2 = $db->prepare('SELECT reviewID FROM REVIEW ORDER BY cast(reviewID as unsigned) DESC LIMIT 1');
	    $reviewID = NULL;
	    $query2->bind_result($reviewID);
	    $query2->execute();
	    $query2->fetch();
	    $query2->close();
	    $reviewID = intval($reviewID)+1;

	    $comment = $_POST["comment"];
	    $reviewTitle = $_POST["reviewTitle"];
	    $rating = $_POST["rating"];

	    $insert = $db->prepare('INSERT INTO REVIEW VALUES (?,?,?,?,?,?)');
	    $insert->bind_param("ssssis", $reviewID, $reviewTitle, $comment, $_GET['title'], $rating, $_SESSION['username']);
	    if(!$insert->execute()) {
	        die($db->errno . ' (' . $db->error . ')');
	    }
	    $insert->close();
		header('Location: review.php?'.http_build_query($_GET));
		die();
	}
}

?>

<!DOCTYPE html>
<?php
$title = $_GET['title'];
?>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<title>Give Review</title>
<body class="givereviews">
<h1><?=$_GET['title']?></h1>
<form method="POST">
	<?php

	if($count < 1): ?>
		<p class="formError">You have not seen this movie! You must buy a ticket and watch the movie before you can review it.</p>
	<?php else: ?>
		<input type="hidden" name="title" value="<?=$_GET['title']?>">
	    <label>Rating</label>
	    <select name="rating">
	        <option value=1<?=@$_POST['rating']==='1'?' selected':''?>>1</option>
	        <option value=2<?=@$_POST['rating']==='2'?' selected':''?>>2</option>
	        <option value=3<?=@$_POST['rating']==='3'?' selected':''?>>3</option>
	        <option value=4<?=@$_POST['rating']==='4'?' selected':''?>>4</option>
	        <option value=5<?=@$_POST['rating']==='5'?' selected':''?>>5</option>
	    </select>
	    <br>
	    <label>Title</label>
		<input name="reviewTitle" type="text" id="reviewTitle" value="<?=@$_POST['reviewTitle']?>"/>
	    <br>
		<?php if($emptyComment): ?>
			<p class="formError">You must type a review</p>
		<?php endif; ?>
	    <label>Comment</label>
	    <textarea name="comment" id="comment"><?=@$_POST['comment']?></textarea>
	    <br>
		<button>Submit</button>
		<div id="gap"></div>
		<button formaction="review.php" formmethod="GET">Back</button>
	<?php endif; ?>
</form>
</body>
