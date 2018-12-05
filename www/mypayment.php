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
    <title>My Payment Information</title>
    <link rel="stylesheet" href="style.css">
  </header>

  <body>
    <h1>My Payment Information</h1>

	  <form>
	    <table class="order-history__table" border="1">
	      <tr>
	        <th>Select</th>
	        <th>Card Number</th>
	        <th>Name on Card</th>
	        <th>Exp Date</th>
	      </tr>

	      <?php
        require_once('config.php');
        
        // TODO
        // UPDATE SQL Statement
        // UPDATE PAYMENT_INFO SET saved=false WHERE cardNumber=?

        $query = $db->prepare('SELECT cardNumber, expirationDate, nameOnCard FROM PAYMENT_INFO WHERE saved=true AND username=?');
        $query->bind_param('s', $_SESSION['username']);
        $query->execute();
	      $cardNumber = $expirationDate = $nameOnCard = NULL;
	      $query->bind_result($cardNumber, $expirationDate, $nameOnCard);

        while($query->fetch()):
			  ?>

        <tr>
          <td><input type="radio" name="cardNumber" id="cardNumber<?=$cardNumber?>" value="<?=$cardNumber?>"></td>
          <td><label for="cardNumber<?=$cardNumber?>"><?=$cardNumber?></label></td>
          <td><label for="cardNumber<?=$cardNumber?>"><?=$nameOnCard?></label></td>
          <td><label for="cardNumber<?=$cardNumber?>"><?=$expirationDate?></label></td>
        </tr>

	      <?php endwhile;
        $query->close();
        ?>

	    </table>

	    <button>Delete</button>
	    <button formaction="me.php" >Back</button>
  	</form>
  </body>
</html>