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

	  <form>
	    <ul class="preferred-theater">

	      <?php
        require_once('config.php');
        
        // TODO: Delete Preferred Theater
        // DELETE SQL Statement
        // DELETE FROM PREFERS WHERE theaterID=? AND username=?

        $query = $db->prepare('SELECT theaterID, name, state, city, street, zip FROM THEATER NATURAL JOIN PREFERS WHERE username=?');
        $query->bind_param('s', $_SESSION['username']);
        $query->execute();
	      $theaterID = $name = $state = $city = $street = $zip = NULL;
	      $query->bind_result($theaterID, $name, $state, $city, $street, $zip);

        while($query->fetch()):
			  ?>

        <li>
          <input type="radio" name="theater" id="theater<?=$theaterID?>" value="<?=$theaterID?>"></td>
          <label for="theater<?=$theaterID?>">
            <p><? echo $name ?></p>
            <p><? echo $street . ", " . $city . " " . $state . " " . $zip ?></p>
          </label>
        </li>

	      <?php endwhile;
        $query->close();
        ?>

	    </ul>

	    <button>Delete</button>
	    <button formaction="me.php" >Back</button>
  	</form>
  </body>
</html>
