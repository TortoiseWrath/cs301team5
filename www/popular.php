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

<table class="popular">
      <tr>
        <th>Month</th>
        <th>Movie</th>
        <th>#of Orders</th>
      </tr>
<?php
require_once('config.php');

for($month = intval(date('n')) - 2; $month <= intval(date('n')); $month++):

	$year = intval(date('Y'));
	if($month > intval(date('n'))) $year--;

	echo '<tbody>';
	$query = $db->prepare('SELECT count(*) AS total, title as month FROM ORDERS AS q1 WHERE q1.status <> "cancelled" AND month(date) = ? AND year(date) = ? GROUP BY month(date), title ORDER BY total DESC LIMIT 3');
	$query->bind_param('ii', $month, $year);
	$query->execute();
	$title = $total = NULL;
	$query->bind_result($total, $title);
	 while($query->fetch()):
	 	$monthName = date("F", mktime(0, 0, 0, $month, 10));
	 	?>
	        <tr>
	          <td><label for="order<?=$month?>"><?=$monthName?></label></td>
	          <td><label for="order<?=$ticketPrice?>"><?=$title?></label></td>
	          <td><label for="order<?=$ticketPrice?>"><?=$total?></label></td>
		  </tr></label>
	      <?php endwhile;
		  $query->close();

	echo '</tbody>';
endfor;?>
</table>

<form>
	<button formaction="managerview.php">Back</button>
</form>

  </body>
</html>
