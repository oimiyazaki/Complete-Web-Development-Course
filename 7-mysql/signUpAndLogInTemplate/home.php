<?php 
	session_start();

	// Check if a cookie exist. If it does, create a session
	if (array_key_exists("username", $_COOKIE)) {

		$_SESSION["username"] = $_COOKIE["username"];

	}

	// If a session doesn't exist, redirect to sign up/ log in page
	if (!array_key_exists("username", $_SESSION)) {

		header("Location: index.php");

	}


	// Log out
	if ($_POST) {

		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}

		// Finally, destroy the session.
		session_destroy();

		// Remove cookie
		setcookie("username", "", time() - 3600);


		// Redirect to sign up/ log in page
		header("Location: index.php");

	}

	echo "<p>Welcome: ".$_SESSION["username"]."!</p>";


?>


<head>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>

	<form method="post" id="logOut">
			
		<input type="submit" name="LogOut" value="Log out!">
	
	</form>


</body>
