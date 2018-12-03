<?php
session_start();
if(!isset($_SESSION['username'])) {
	// User not logged in
	header('Location: login.php');
	die();
}
?>

<?php
  $orderID = $_GET['orderID']
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

      $query = $db->prepare('SELECT * FROM ORDERS JOIN THEATER JOIN MOVIE WHERE orderID=?');
      $query->bind_param('s', $orderID);
      $query->execute();
      $result = $query->get_result()->fetch_assoc();

      print_r($result)
    ?>

    <h2>Title: <?=$result['title']?></h2>
    <p>
      <span><?=$result['rating']?>, </span>
      <span>
        <?php
          function convertToHoursMins($time, $format = '%2d:%02d') {
            if ($time < 1) {
                return;
            }
            $hours = floor($time / 60);
            $minutes = ($time % 60);
            return sprintf($format, $hours, $minutes);
        }

          echo convertToHoursMins($result['length'], '%2d hr  %02d min');
        ?>
      </span>
    </p>

    <p>Theater: <? echo $result['name'] . ', ' . $result['street'] . ' ' . $result['city'] . ' ' . $result['state'] . ' ' . $result['zip']?></p>
    <p>Time: <?=$result['date']?> <?=$result['time']?></p>
    <p>Status: <?=$result['status']?></p>

    <p>
      <strong>Tickets: <?=$result['totalTickets']?></strong><br>
      <?php
		  $query = $db->prepare('SELECT childDiscount, seniorDiscount FROM SYSTEMINFO');
		  $childDiscount = $seniorDiscount = NULL;
		  $query->bind_result($childDiscount, $seniorDiscount);
		  $query->execute();
		  $query->fetch();
		  $query->close();

		  $childPrice = $result['ticketPrice'] * (100 - $childDiscount) / 100;
		  $seniorPrice = $result['ticketPrice'] * (100 - $seniorDiscount) / 100;
		  $totalPrice = $result['ticketPrice'] * $result['adultTickets'] + $childPrice * $result['childTickets'] + $seniorPrice * $result['seniorTickets'];

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
		Total: $<?php

		echo number_format($totalPrice, 2);
		 ?>
	</p>

    <?php
      // TODO: Implement cancelling order
      if ($result['status'] === "Unusued")
        echo "<button>Cancel this order</button>";
    ?>

    <button onclick="window.location='orderhistory.php'">Back</button>
  </body>
</html>
