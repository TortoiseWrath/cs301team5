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

		  $query = 'SELECT orderID, title, status, totalTickets FROM ORDERS where username=?';
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
	      $orderID = $title = $status = $totalTickets = NULL;
	      $query->bind_result($orderID, $title, $status, $totalTickets);
	      while($query->fetch()):?>
	        <tr>
	          <td><input type="radio" name="orderID" value=<?=$orderID?>></td>
	          <td><?=$orderID?></td>
	          <td><?=$title?></td>
	          <td><?=$status?></td>
	          <td><?=$totalTickets?></td>
	        </tr>
	      <?php endwhile;
		  $query->close(); ?>

	    </table>

	    <button formaction="viewdetail.php" >View Detail</button>
	</form>
  </body>
</html>
