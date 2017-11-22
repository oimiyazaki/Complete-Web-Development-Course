<?php 

	session_start();

	if ($_SESSION['email']) {

		echo "Welcome ".$_SESSION['email'];

	} else {

		header("Location: index.php");

	}

?>