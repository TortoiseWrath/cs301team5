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
    <title>Order History</title>
    <link rel="stylesheet" href="style.css">
  </header>

  <body>
    <h1>Order History</h1>

	<form>
	    <div>
	      <span>Order ID</span>
	      <input name="q"<?=isset($_GET['orderid'])?' value="'.$_GET['orderid'].'"':''?>>
	      <button>Search</button>
	    </div>

	    <table class="order-history__table" border="1">
	      <tr>
	        <th>Select</th>
	        <th>Order ID</th>
	        <th>Movie</th>
	        <th>Status</th>
	        <th>Total Cost</th>
	      </tr>

	      <?php
	      require_once('config.php');

		  $query = $db->prepare('SELECT childDiscount, seniorDiscount FROM SYSTEMINFO');
		  $childDiscount = $seniorDiscount = NULL;
		  $query->bind_result($childDiscount, $seniorDiscount);
		  $query->execute();
		  $query->fetch();
		  $query->close();

		  $query = 'SELECT orderID, title, status, adultTickets, childTickets, seniorTickets, ticketPrice FROM ORDERS where username=?';
		  if(isset($_GET['q'])) {
			  $query .= ' AND orderID=?';
		      $query = $db->prepare($query);
		      $query->bind_param('ss', $_SESSION['username'], $_GET['q']);
	  	  }
		  else {
			  $query = $db->prepare($query);
			  $query->bind_param('s', $_SESSION['username']);
		  }
	      $query->execute();
	      $orderID = $title = $status = $adultTickets = $childTickets = $seniorTickets = $ticketPrice = NULL;
	      $query->bind_result($orderID, $title, $status, $adultTickets, $childTickets, $seniorTickets, $ticketPrice);
	      while($query->fetch()):
			  $childPrice = $ticketPrice * (100 - $childDiscount) / 100;
			  $seniorPrice = $ticketPrice * (100 - $seniorDiscount) / 100;
			  $totalPrice = $ticketPrice * $adultTickets + $childPrice * $childTickets + $seniorPrice * $seniorTickets;
			  ?>
	        <tr>
	          <td><input type="radio" name="orderID" value=<?=$orderID?>></td>
	          <td><?=$orderID?></td>
	          <td><a href="movie.php?title=<?=urlencode($title)?>"><?=htmlspecialchars($title)?></a></td>
	          <td><?=$status?></td>
	          <td>$<?=number_format($totalPrice, 2)?></td>
	        </tr>
	      <?php endwhile;
		  $query->close(); ?>

	    </table>

	    <button formaction="viewdetail.php" >View Detail</button>
	</form>
  </body>
</html>
