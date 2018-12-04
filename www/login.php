<?php
// Please never use any part of this in production. It makes no attempt to be secure.

// Check if the user is already logged in, and if so redirect to the appropriate page.
session_start();
if(isset($_SESSION['username'])) {
	if($_SESSION['manager']) {
		header('Location: managerview.php');
		die();
	}
	else {
		header('Location: nowplaying.php');
		die();
	}
}

$loginFailed = false;
if(isset($_POST['username'])) {
	// Load the database configuration and open a connection to the database
	require_once('config.php');

	$_POST['username'] = trim(strtolower($_POST['username']));

	// Prepare the statements
	$manager_check = $db->prepare('SELECT COUNT(*) FROM MANAGER WHERE username=? AND password=?');
	$customer_check = $db->prepare('SELECT COUNT(*) FROM CUSTOMER WHERE username=? AND password=?');

	// Bind the parameters ('s' is string format)
	$manager_check->bind_param('ss', $_POST['username'], $_POST['password']);
	$customer_check->bind_param('ss', $_POST['username'], $_POST['password']);

	// Check if the user is a manager.
	$manager_check->execute();
	$isMgr = NULL;
	$manager_check->bind_result($isMgr);
	$manager_check->fetch();
	$manager_check->close();
	if($isMgr) {
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['manager'] = true;
		header('Location: managerview.php');
		die();
	}

	// Check if the user is a customer.
	$customer_check->execute();
	$isCustomer = NULL;
	$customer_check->bind_result($isCustomer);
	$customer_check->fetch();
	$customer_check->close();
	if($isCustomer) {
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['manager'] = false;
		header('Location: nowplaying.php');
		die();
	}

	// If we get here, there is neither a user nor a manager with the given credentials.
	$loginFailed = true;
} ?>
<!DOCTYPE html>
<title>Log In</title>
<link rel="stylesheet" href="style.css">
<h1>Login</h1>
<?php if($loginFailed): ?>
	<p class="loginError">Your username or password was invalid. Please try again.</p>
<?php endif; ?>
<form method="POST" class="login">
<label for="username">Username</label>
<input type="text" id="username" name="username"<?=isset($_POST['username'])?' value="'.$_POST['username'].'"':''?>>
<br>
<label for="password">Password</label>
<input type="password" id="password" name="password">
<br>
<button class="space">Login</button>
<button formaction="register.php">Register</button>
</form>
<img src="bee.png">
