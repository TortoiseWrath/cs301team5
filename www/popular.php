<?php
session_start();
if(!@$_SESSION['manager']) {
	// User is not a manager
	header('Location: login.php');
	die();
}
?>

<!DOCTYPE html>
<html lang="en">
  <header>
    <title>View Popular Movie Report</title>
    <link rel="stylesheet" href="style.css">
  </header>

<body>

<h1>View Popular Movie Report</h1>

<form>
	<table class="order-history__table" border="1">
	      <tr>
	        <th>Month</th>
	        <th>Movie</th>
	        <th>#of Orders</th>
	      </tr>
	<?php
	require_once('config.php');
	$query = $db->prepare('SELECT count(*) as total, title, month(date) as month FROM orders as q1 WHERE q1.status <> "cancelled" and month(date) = "12" GROUP BY month(date), title ORDER BY total DESC LIMIT 3');
	$query->execute();
	$title = $count = NULL;
	$query->bind_result($total, $title, $month);
	 while($query->fetch()):
	 	$monthName = date("F", mktime(0, 0, 0, $month, 10));
	 	?>
	        <tr>
	          <td><label for="order<?=$month?>"><?=$monthName?></label></td>
	          <td><label for="order<?=$ticketPrice?>"><?=$title?></label></td>
	          <td><label for="order<?=$ticketPrice?>"><?=$total?></label></td>
		  </tr></label>
	      <?php endwhile;
		  $query->close(); ?>
		  <?php
	$query = $db->prepare('SELECT count(*) as total, title, month(date) as month FROM orders as q1 WHERE q1.status <> "cancelled" and month(date) = "11" GROUP BY month(date), title ORDER BY total DESC LIMIT 3');
	$query->execute();
	$title = $count = NULL;
	$query->bind_result($total, $title, $month);
	 while($query->fetch()):
	 	$monthName = date("F", mktime(0, 0, 0, $month, 10));
	 	?>
	        <tr>
	          <td><label for="order<?=$month?>"><?=$monthName?></label></td>
	          <td><label for="order<?=$ticketPrice?>"><?=$title?></label></td>
	          <td><label for="order<?=$ticketPrice?>"><?=$total?></label></td>
		  </tr></label>
	      <?php endwhile;
		  $query->close(); ?>
		    <?php
	$query = $db->prepare('SELECT count(*) as total, title, month(date) as month FROM orders as q1 WHERE q1.status <> "cancelled" and month(date) = "10" GROUP BY month(date), title ORDER BY total DESC LIMIT 3');
	$query->execute();
	$title = $count = NULL;
	$query->bind_result($total, $title, $month);
	 while($query->fetch()):
	 	$monthName = date("F", mktime(0, 0, 0, $month, 10));
	 	?>
	        <tr>
	          <td><label for="order<?=$month?>"><?=$monthName?></label></td>
	          <td><label for="order<?=$ticketPrice?>"><?=$title?></label></td>
	          <td><label for="order<?=$ticketPrice?>"><?=$total?></label></td>
		  </tr></label>
	      <?php endwhile;
		  $query->close(); ?>
</table>
</form>

<form>
	<button formaction="managerview.php">Back</button>
</form>

  </body>
</html>
