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

    <!-- TODO: Search -->
    <div>
      <span>Order ID</span>
      <input id="order_id">
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

      $query = $db->prepare('SELECT orderID, title, status, totalTickets FROM ORDERS where username=?');
      $query->bind_param('s', $_SESSION['username']);
      $query->execute();
      $orderID = $title = $status = $totalTickets = NULL;
      $query->bind_result($orderID, $title, $status, $totalTickets);
      while($query->fetch()):?>
        <tr>
          <td><input type="radio" name="selectedOrder" value=<?=$orderID?>></td>
          <td><?=$orderID?></td>
          <td><?=$title?></td>
          <td><?=$status?></td>
          <td><?=$totalTickets?></td>
        </tr>
      <?php endwhile; ?>

    </table>

    <button onclick="viewDetail(event)" >View Detail</button>
  </body>

  <script>
    function viewDetail() {
      const selectedOrder = document.querySelector('input[name=selectedOrder]:checked')
      if (selectedOrder) {
        window.location = `viewdetail.php?orderID=${selectedOrder.value}`
      }
    }
  </script>
</html>