<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
?>

<?php
  $orderID = $_GET['orderID'];
?>

<!DOCTYPE html>
<html lang="en">
  <header>
    <title>Order <?=$orderID?></title>
    <link rel="stylesheet" href="style.css">
  </header>

  <body>
    <h1>Order Detail</h1>

    <?php
      require_once('config.php');

	  if(isset($_POST['orderID'])) {
		  $orderID = $_POST['orderID'];
	      $query = $db->prepare('UPDATE ORDERS SET status="Cancelled" WHERE orderID=?');
		  $query->bind_param('s', $orderID);
		  $query->execute();
	  }

      $query = $db->prepare('SELECT * FROM ORDERS NATURAL JOIN THEATER NATURAL JOIN MOVIE WHERE orderID=?');
      $query->bind_param('s', $orderID);
      $query->execute();
      $result = $query->get_result()->fetch_assoc();
    ?>

		<aside class="theater">
			<strong><?=$result['name']?></strong>
			<address><?=$result['street']."<br>".$result['city'].', '.$result['state'].' '.$result['zip']?></address>
		</aside>
		<aside class="movie">
			<strong><?=$result['title']?></strong>
			<p class="rating"><?=$result['rating']?>
			<p class="length"><?=($result['length']>60?(floor($result['length']/60).' hr '):'').($result['length']%60).' min'?>
		</aside>
		<aside class="showtime">
			<?=date('l, F j',strtotime($result['date']))?>
			<br>
			<?=date('g:i A',strtotime('2010-01-01 '.$result['time']))?>
		</aside>
  <div class="view-detail__ticket">
    <p>
      <strong>Tickets: <?=$result['totalTickets']?></strong><br>
      <?php
      $query = $db->prepare('SELECT childDiscount, seniorDiscount, cancellationFee FROM SYSTEMINFO');
      $childDiscount = $seniorDiscount = $cancellationFee = NULL;
      $query->bind_result($childDiscount, $seniorDiscount, $cancellationFee);
      $query->execute();
      $query->fetch();
      $query->close();

      $childPrice = $result['ticketPrice'] * (100 - $childDiscount) / 100;
      $seniorPrice = $result['ticketPrice'] * (100 - $seniorDiscount) / 100;
      $totalPrice = $result['ticketPrice'] * $result['adultTickets'] + $childPrice * $result['childTickets'] + $seniorPrice * $result['seniorTickets'];

      if($result['status'] === 'Cancelled') {
        $totalPrice = $cancellationFee;
      }

        if ($result['adultTickets']) {
          echo $result['adultTickets'] . " adult ticket" . ($result['adultTickets']==1?'':'s') . ": $" . number_format($result['ticketPrice'] * $result['adultTickets'], 2) . "<br>";
        }
        if ($result['childTickets']) {
          echo $result['childTickets'] . " child ticket" . ($result['childTickets']==1?'':'s') . ": $" . number_format($childPrice * $result['childTickets'], 2) . "<br>";
        }
        if ($result['seniorTickets']) {
          echo $result['seniorTickets'] . " senior ticket" . ($result['seniorTickets']==1?'':'s') . ": $" . number_format($seniorPrice * $result['seniorTickets'], 2);
        }
      ?>
    </p>

    <p>
      Total: $<?=number_format($totalPrice, 2)?>
    </p>
  </div>

    <p>Status: <?=$result['status']?></p>


	<form method="POST">
		<input type="hidden" name="orderID" value="<?=$orderID?>">
	    <?php
	      if ($result['status'] === "Unused" || $result['status'] === "Completed"): // Completed for demonstration purposes only
	    ?>
			<button class="space">Cancel this order</button>
		<?php endif; ?>
	    <button formaction="orderhistory.php" formmethod="GET">Back</button>
	</form>
  </body>
</html>
