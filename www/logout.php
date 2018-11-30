<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['manager']);
header('Location: login.php');
