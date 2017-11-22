<?php 

	session_start();

	// $_SESSION['username'] = "oimiyazaki";

	// echo $_SESSION['username'];

	if ($_SESSION['email']) {

		echo "Welcome ".$_SESSION['email'];

	} else {

		header("Location: index.php");

	}

?>