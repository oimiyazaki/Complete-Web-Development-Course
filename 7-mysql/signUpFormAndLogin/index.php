<?php 

	// Start session to use session
	session_start();

	// Connect do database
	$link = mysqli_connect("shareddb1c.hosting.stackcp.net", "users-myzk-32301dd1", "19MYZK90mar", "users-myzk-32301dd1");

		// if the connection is not made, handle error
		if (mysqli_connect_error()) {

			die ("There was an error connecting to the database");

		} 

		// if the form is submitted because there is a email or password
		if (array_key_exists('email', $_POST) OR array_key_exists('password', $_POST)) {

			// validate if email is empty
			if ($_POST['email'] == '') {

				echo "<p>Email address is required.</p>";

			// validate if password is empty
			} else if ($_POST['password'] == '') {

				echo "<p>Password is required.</p>";


			} else {

				// Query to see if the email submitted is already in the DB
				$query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'"; 

				$result = mysqli_query($link, $query);

				// Display email already taken error
				if (mysqli_num_rows($result) > 0) {

					echo "<p>That email address has already been taken.</p>";

				} else {

					// Add email and password to DB
					$query = "INSERT INTO users (email, password) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";

					// If the email and password were added successfully 1) create session and 2) route the new website to simulate somone is logged in
					if (mysqli_query($link, $query)) {

						$_SESSION['email'] = $_POST['email'];

						header('Location: sessions.php');

					} else {

						// Show error that the user was not added successfully 
						echo "<p>There was a problem signing you up - please try again.</p>";

					}


				}


			}

		}





?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign up</title>
</head>
<body>
	<form method="post">
		<label>Email</label>
		<br>
		<input type="text" name="email">
		<br>
		<label>Password</label>
		<br>
		<input type="password" name="password">
		<br>
		<button type="submit" name="submit">Sign up!</button>
	</form>
</body>
</html>

