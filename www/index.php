<!DOCTYPE html>
<title>Index</title>
<style type="text/css">
	ol {
		list-style: none;
		counter-reset: item;
	}
	ol>li:before {
		content: "Fig "  counter(item)  ": ";
		counter-increment: item;
	}
</style>
<ol>
	<li><a href="login.php">Log in</a></li>
	<li><a href="register.php">New User Registration</a></li>
	<li><a href="nowplaying.php">Now Playing</a></li>
	<li><a href="me.php">Me</a></li>
	<li><a href="movie.php">Movie</a></li>
	<li><a href="overview.php">Movie Overview</a></li>
	<li><a href="review.php">Review</a></li>
	<li><a href="givereview.php">Give Review</a></li>
	<li><a href="choosetheater.php">Choose Theater</a></li>
	<li><a href="results.php">Search Theater Results</a></li>
	<li><a href="selecttime.php">Select Time</a></li>
	<li><a href="ticket.php">Ticket</a></li>
	<li><a href="payment.php">Payment Information</a></li>
	<li><a href="confirmation.php">Confirmation</a></li>
	<li><a href="orderhistory.php">Order History</a></li>
	<li><a href="viewdetail.php">Order Detail</a></li>
	<li><a href="mypayment.php">My Payment Information</a></li>
	<li><a href="preferred.php">My Preferred Theater</a></li>
	<li><a href="managerview.php">Choose Functionality (manager view)</a></li>
	<li><a href="revenue.php">View Revenue Report</a></li>
	<li><a href="popular.php">View Popular Movie Report</a></li>
</ol>
<a href="logout.php">Logout</a>
