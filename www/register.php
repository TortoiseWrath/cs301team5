<?php
// Please never use this in production. It makes no attempt to be secure.

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

$registrationFailures = array();
if(isset($_POST['email'])) {
	// Connect to the database.
	require_once('config.php');

	$_POST['email'] = trim(strtolower($_POST['email']));
	$_POST['username'] = trim(strtolower($_POST['username']));

	if($_POST['password'] != $_POST['password2']) {
		$registrationFailures['password2'] = 'Passwords do not match.';
	}
	if(empty($_POST['password'])) {
		$registrationFailures['password'] = 'Please enter a password.';
	}
	if(empty($_POST['username'])) {
		$registrationFailures['username'] = 'Please enter a username.';
	}
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$registrationFailures['email'] = 'Please enter a valid email address.';
	}

	if(count($registrationFailures) == 0) {
		// Check whether the user already exists.
		$exists_check = $db->prepare('SELECT username, email FROM (SELECT * FROM CUSTOMER UNION SELECT * FROM MANAGER) AS USERS WHERE username = ? OR email = ?');
		$exists_check->bind_param('ss', $_POST['username'], $_POST['email']);
		$exists_check->execute();
		$exists_check->store_result();
		$exists = $exists_check->num_rows;
		if($exists) {
			$resultUser = $resultEmail = NULL;
			$exists_check->bind_result($resultUser, $resultEmail);
			while($exists_check->fetch()) {
				if($resultEmail == $_POST['email']) {
					if($resultUser == $_POST['username']) {
						$registrationFailures[] = 'A user already exists with this username and email address. Did you mean to <a href="login.php">log in</a>?';
						$registrationFailures['username'] = '';
						$registrationFailures['email'] = '';
					}
					else {
						$registrationFailures['email'] = 'A user already exists with this email address. Did you mean to <a href="login.php">log in</a>?';
					}
				}
				else {
					$registrationFailures['username'] = 'A user already exists with this username. Did you mean to <a href="login.php">log in</a>?';
				}
			}
		}
		$exists_check->close();
	}

	$submittedMgrPassword = $_POST['manager'];
	if(!empty($submittedMgrPassword)) {
		// Validate the submitted manager password.
		$manager_check = $db->prepare('SELECT COUNT(*) FROM SYSTEMINFO WHERE managerPassword = ?');
		$manager_check->bind_param('s', $_POST['manager']);
		$manager_check->execute();
		$pwCorrect = NULL;
		$manager_check->bind_result($pwCorrect);
		$manager_check->fetch();
		$manager_check->close();
		if(!$pwCorrect) {
			$registrationFailures['manager'] = 'Manager password is invalid.';
		}

		if(count($registrationFailures) == 0) {
			// Attempt to add the user as a manager.
			$insert = $db->prepare("INSERT INTO MANAGER (email, username, password) VALUES (?, ?, ?)");
			$insert->bind_param('sss', $_POST['email'], $_POST['username'], $_POST['password']);
			if(!$insert->execute()) {
				$registrationFailures[] = $db->errno . ' (' . $db->error . ')';
			}
			else {
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['manager'] = 1;
				header('Location: managerview.php');
				die();
			}
		}
	}
	elseif(count($registrationFailures) == 0) {
		// Attempt to add the user as a customer.
		$insert = $db->prepare("INSERT INTO CUSTOMER (email, username, password) VALUES (?, ?, ?)");
		$insert->bind_param('sss', $_POST['email'], $_POST['username'], $_POST['password']);
		if(!$insert->execute()) {
			$registrationFailures[] = $db->errno . ' (' . $db->error . ')';
		}
		else {
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['manager'] = 0;
			header('Location: nowplaying.php');
			die();
		}
	}
}
?>
<!DOCTYPE html>
<title>Register</title>
<link rel="stylesheet" href="style.css">

<h1>New User Registration</h1>
<form method="POST">
	<ul class="errors">
		<?php foreach($registrationFailures as $error) if(!empty($error)) echo '<li>'.$error.'</li>'; ?>
	</ul>
	<label for="username">Username</label>
	<input type="text" name="username"<?=(isset($registrationFailures['username'])?' class="error"':'').(isset($_POST['username'])?' value="'.$_POST['username'].'"':'')?>>
	<br>
	<label for="email">Email Address</label>
	<input type="text" name="email"<?=(isset($registrationFailures['email'])?' class="error"':'').(isset($_POST['email'])?' value="'.$_POST['email'].'"':'')?>>
	<br>
	<label for="password">Password</label>
	<input type="password" name="password"<?=isset($registrationFailures['password'])?' class="error"':''?>>
	<br>
	<label for="password2">Confirm Password</label>
	<input type="password" name="password2"<?=isset($registrationFailures['password2'])?' class="error"':''?>>
	<br>
	<label for="manager">Manager Password</label>
	<input type="password" name="manager"<?=isset($registrationFailures['manager'])?' class="error"':''?>>
	<br>
	<button>Create</button>
</form>
