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
      Tickets: <br>
      <?php
        if ($result['adultTickets']) {
          echo "Adult Tickets: " . $result['adultTickets'] . "<br>";
        }
        if ($result['childTickets']) {
          echo "Child Tickets: " . $result['childTickets'] . "<br>";
        }
        if ($result['seniorTickets']) {
          echo "Senior Tickets: " . $result['seniorTickets'] . "<br>";
        }
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