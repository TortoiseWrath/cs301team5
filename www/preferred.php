<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
?>

<!DOCTYPE html>
<html lang="en">
  <header>
    <title>My Preferred Theater</title>
    <link rel="stylesheet" href="style.css">
  </header>

  <body>
    <h1>My Preferred Theater</h1>

	  <form method="GET">
	    <ul class="preferred-theater">

	      <?php
        require_once('config.php');
	  if(isset($_GET['theaterID'])) {
	      $query = $db->prepare('DELETE FROM PREFERS WHERE theaterID=? AND username=?');
		   $query->bind_param('ss', $_GET['theaterID'], $_SESSION['username']);
		  $query->execute();
	  }

        $query = $db->prepare('SELECT theaterID, name, state, city, street, zip FROM THEATER NATURAL JOIN PREFERS WHERE username=?');
        $query->bind_param('s', $_SESSION['username']);
        $query->execute();
	      $theaterID = $name = $state = $city = $street = $zip = NULL;
	      $query->bind_result($theaterID, $name, $state, $city, $street, $zip);

		 $n = 0;

        while($query->fetch()): $n++;
			  ?>
		  		<li>
		  			<input type="radio" name="theaterID" value="<?=$theaterID?>" id="theater<?=$theaterID?>">
		  			<label for="theater<?=$theaterID?>"><strong><?=$name?></strong><address><?="$street, $city, $state $zip"?></address></label>
		  		</li>

	      <?php endwhile;
        $query->close();
		if($n == 0):
        ?>
			<p class="formError">You have no preferred theaters.</p>
		<?php endif;?>

	    </ul>
		<div class="preferred">
			<?php if($n > 0): ?>
		    <button class="space">Delete</button> <?php endif; ?>
		    <button formaction="me.php" >Back</button>
		</div>
  	</form>
  </body>
</html>
