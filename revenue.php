<?php
session_start();
if(!isset($_SESSION['manager'])) {
	// User is not a manager
	header('Location: login.php');
	die();
}
?>

<!DOCTYPE html>
<html lang="en">
  <header>
    <title>View Revenue Report</title>
    <link rel="stylesheet" href="style.css">
  </header>

<body>

<h1>View Revenue Report</h1>

<form>
	<table class="order-history__table" border="1">
	      <tr>
	        <th>Month</th>
	        <th>Revenue</th>
	      </tr>
	<?php
	require_once('config.php');
	$query = $db->prepare('SELECT childDiscount, seniorDiscount, cancellationFee FROM SYSTEMINFO');
		  $childDiscount = $seniorDiscount = $cancellationFee = NULL;
		  $query->bind_result($childDiscount, $seniorDiscount, $cancellationFee);
		  $query->execute();
		  $query->fetch();
		  $query->close();

		  $query = $db->prepare('SELECT count(*), totalTickets FROM ORDERS WHERE month(date) = "11" AND status = "cancelled"');
		  $novCount = $totaltix2 = $novFee = NULL;
		  $query->bind_result($novCount, $totaltix2);
		  $query->execute();
		  $query->fetch();
		  $novFee = $novCount * $totaltix2;
		  $query->close();

		  $query = $db->prepare('SELECT count(*), totalTickets FROM ORDERS WHERE month(date) = "12" AND status = "cancelled"');
		  $decCount = $totaltix3 = $decFee = NULL;
		  $query->bind_result($decCount, $totaltix3);
		  $query->execute();
		  $query->fetch();
		  $decFee = $decCount * $totaltix3;
		  $query->close();

		  $query = $db->prepare('SELECT count(*), totalTickets FROM ORDERS WHERE month(date) = "10" AND status = "cancelled"');
		  $octCount = $totaltix1 = $octFee = NULL;
		  $query->bind_result($octCount, $totaltix1);
		  $query->execute();
		  $query->fetch();
		  $octFee = $octCount * $totaltix1;
		  $query->close();

	$query = $db->prepare('SELECT month(date), SUM(adulttickets) as adulttickets, SUM(childtickets) as childtickets, SUM(seniortickets) as seniorTickets, ticketprice FROM ORDERS GROUP BY month(date) DESC LIMIT 3');
	$query->execute();
	$month = $adulttickets = $childtickets = $seniortickets = $ticketprice = NULL;
	$query->bind_result($month, $adulttickets, $childtickets, $seniortickets, $ticketprice);
	 while($query->fetch()):
	 	$monthName = date("F", mktime(0, 0, 0, $month, 10));
	 	 $childPrice = $ticketprice * (100 - $childDiscount) / 100;
			  $seniorPrice = $ticketprice * (100 - $seniorDiscount) / 100;
			  $totalPrice = $ticketprice * $adulttickets + $childPrice * $childtickets + $seniorPrice * $seniortickets;
			  if($month == "12")
			  {
			 	$totalPrice = $totalPrice - (5*$decFee);
			  }
			  if($month == "11")
			  {
			 	$totalPrice = $totalPrice - (5*$novFee);
			  }
			  if($month == "10")
			  {
			  	$totalPrice = $totalPrice - (5*$octFee);
			  }
	 	?>
	        <tr>
	          <td><label for="order<?=$month?>"><?=$monthName?></label></td>
	          <td><label for="order<?=$ticketPrice?>"><?=$totalPrice?></label></td>
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