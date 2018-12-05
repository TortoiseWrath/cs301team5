<?php
session_start();
if(!@$_SESSION['manager']) {
	// User is not a manager
	header('Location: login.php');
	die();
}
?>

<!DOCTYPE html>
    <title>View Revenue Report</title>
    <link rel="stylesheet" href="style.css">


<h1>View Revenue Report</h1>

<table class="revenue">
      <tr>
        <th>Month</th>
        <th>Revenue</th>
      </tr>
<?php
require_once('config.php');
$query = $db->prepare('SELECT childDiscount, seniorDiscount FROM SYSTEMINFO');
	  $childDiscount = $seniorDiscount = NULL;
	  $query->bind_result($childDiscount, $seniorDiscount);
	  $query->execute();
	  $query->fetch();
	  $query->close();
$query = $db->prepare('SELECT month(date), SUM(adultTickets * ticketPrice), SUM(childTickets * ticketPrice), SUM(seniorTickets * ticketPrice) FROM ORDERS WHERE status <> "Cancelled" GROUP BY month(date) ORDER BY month(date) DESC LIMIT 3');
$query->execute();
$month = $adulttickets = $childtickets = $seniortickets = NULL;
$query->bind_result($month, $adulttickets, $childtickets, $seniortickets);
 while($query->fetch()):
 	$monthName = date("F", mktime(0, 0, 0, $month, 10));
 	 $childPrice = (100 - $childDiscount) / 100;
		  $seniorPrice = (100 - $seniorDiscount) / 100;
		  $totalPrice = $adulttickets + $childPrice * $childtickets + $seniorPrice * $seniortickets;
 	?>
        <tr>
          <td><?=$monthName?></td>
          <td>$<?=$totalPrice?></td>
	  </tr>
      <?php endwhile;
	  $query->close(); ?>
</table>

<form>
	<button formaction="managerview.php">Back</button>
</form>
