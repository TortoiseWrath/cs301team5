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

if($count < 1){
    die("You have not seen this movie");
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
    <label>Rating</label>
    <select name="rating">
        <option value=1>1</option>
        <option value=2>2</option>
        <option value=3>3</option>
        <option value=4>4</option>
        <option value=5>5</option>
    </select>
    <br>
    <label>Title</label>
	<input name="reviewTitle" type="text" id="reviewTitle"/>
    <br>
    <label>Comment</label>
    <input name="comment" type="text" id="comment">
    <br>
	<input type="submit" name="submit" value="Submit"/>
</form>

<form method="GET">
	<input type="hidden" name="title" value="<?=$_GET['title']?>">
	<button formaction="review.php">Back</button>
</form>
</body>

<?php
    require_once('config.php');
    if(isset($_POST['submit'])){
        $query2 = $db->prepare('SELECT MAX(reviewID) FROM REVIEW');
        $reviewID = NULL;
        $query2->bind_result($reviewID);
        $query2->execute();
        $query2->fetch();
        $query2->close();
        $reviewID = $reviewID+1;

        $comment = $_POST["comment"];
        $reviewTitle = $_POST["reviewTitle"];
        $rating = $_POST["rating"];

        $insert = $db->prepare('INSERT INTO REVIEW VALUES (?,?,?,?,?,?)');
        $insert->bind_param("ssssis", $reviewID, $reviewTitle, $comment, $_GET['title'], $rating, $_SESSION['username']);
        if(!$insert->execute()) {
            die($db->errno . ' (' . $db->error . ')');
        }
        $insert->close();
    }
?>
