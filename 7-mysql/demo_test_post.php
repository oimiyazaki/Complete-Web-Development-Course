<?php 

	session_start();
	// Connect to DB
	$servername = "shareddb1c.hosting.stackcp.net";
	$username = "users-myzk-32301dd1";
	$password = "19MYZK90";
	$dbname = "users-myzk-32301dd1";

	$link = mysqli_connect($servername, $username, $password, $dbname);

	// Error message if DB doesn't connect
	if (mysqli_connect_error()) {

		die("There was an error connecting to the database.");

	}

	if (isset($_POST["diaryEntry"])) {


			$diaryEntry = mysqli_real_escape_string($link, $_POST["diaryEntry"]);
			$email = $_SESSION["username"];


			$query = "UPDATE diary SET diaryEntry ='".$diaryEntry."' WHERE email = '".$email."'";

			if (mysqli_query($link, $query) === TRUE) {  

				echo "success";


			} else {

				echo "canont update";

			}				

	}

?>

