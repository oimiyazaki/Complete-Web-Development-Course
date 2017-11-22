<?php 

	// Start session
	session_start();

	if (array_key_exists("username", $_COOKIE) || array_key_exists("username", $_SESSION)) {

		header("Location: home.php");

	}


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

	// Set variables
	$errorSignUp = "";
	$errorLogIn = "";


	// If the form sign up is submitted
	if (isset($_POST["emailSignUp"]) || isset($_POST["passwordSignUp"])) {

		$email = mysqli_real_escape_string($link, $_POST["emailSignUp"]);
		$password = mysqli_real_escape_string($link, $_POST["passwordSignUp"]);

		// Display error if 1) email is empty, 2) email is invalid, and/ or 3) password is empty
		if ($email == "") {

			$errorSignUp .= "<p>The email field cannot be empty.</p>";

		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

			$errorSignUp .= "<p>The email entered is invalid.</p>";
			
			}

		if ($password == "") {

			$errorSignUp .= "<p>The password field cannot be empty.</p>";

		}

		// If no errors were found continue
		if ($errorSignUp == "") {

			// check if email is already in use
			$query = "SELECT * FROM users WHERE email = '".$email."'";

			$result = mysqli_query($link, $query);

			if (mysqli_num_rows($result) > 0) {

				$errorSignUp .= "<p>The email entered is already in use.</p>";

			} else { 

				// Add user to the database
				$hash = password_hash($password, PASSWORD_DEFAULT);

				$query = "INSERT INTO users (email, password) VALUES ('".$email."', '".$hash."')";

				if (mysqli_query($link, $query) === TRUE) {  /////////// Test Code: Replace -> TRUE with -> (mysqli_query($link, $query) === TRUE)

					// If they decided to stay logged in, create cookie
					if (isset($_POST["stayLoggedInSignUp"])) {

						setcookie("username", $email, time() + 86400 * 7);
						
					} 

					// Create session and log them in
					$_SESSION["username"] = $email; 

					header("Location: home.php");


				} else {

					// Show error if the user could not be added 
					$errorSignUp .= "<p>An error occured. Please try again.</p>";

				}				


			}


		}


	}

	// If the form log in is submitted
		if (isset($_POST["emailLogIn"]) || isset($_POST["passwordLogIn"])) {

			$email = mysqli_real_escape_string($link, $_POST["emailLogIn"]);
			$password = mysqli_real_escape_string($link, $_POST["passwordLogIn"]);

			// Display error if 1) email is empty, 2) email is invalid, and/ or 3) password is empty
			if ($email == "") {

				$errorLogIn .= "<p>The email field cannot be empty.</p>";

			} 

			if ($password == "") {

				$errorLogIn .= "<p>The password field cannot be empty.</p>";

			}

			// If no errors were found continue
			if ($errorLogIn == "") {

				// Query for email addres in DB
				$query = "SELECT * FROM users WHERE email = '".$email."'";

				$result = mysqli_query($link, $query);

				// Show error if the email address is not found
				if (!mysqli_num_rows($result) > 0) {

					$errorLogIn .= "<p>Invalid email or password.</p>";

				} else {

					// Query for email address
					$row = mysqli_fetch_array($result);

					// Show error if the password is not a match
					if (!password_verify($password, $row["password"])) {

						$errorLogIn .= "<p>Invalid email or password.</p>";

					} else {

						// If they decided to stay logged in, create cookie
						if (isset($_POST["stayLoggedInLogIn"])) {

							setcookie("username", $email, time() + 86400 * 7);
							
						} 

						// Create session and log them in
						$_SESSION["username"] = $email; 

						header("Location: home.php");

					}

				}

			}

		}

?>
<head>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>

	<!-- Sign up form -->
	<form method="post" id="formSignUp">
		
		<input type="text" name="emailSignUp" id="emailSignUp" placeholder="Email">
		
		<input type="password" name="passwordSignUp" id="passwordSignUp" placeholder="Password">
		
		<input type="checkbox" name="stayLoggedInSignUp" id="stayLoggedInSignUp">
		
		<button type="submit">Sign up!</button>
	
	</form>
	
	<p id="errorMessageSignUp"></p>

	<?php echo $errorSignUp ?>

	<!-- Log in form -->
	<form method="post" id="formLogIn">
		
		<input type="text" name="emailLogIn" id="emailLogIn" placeholder="Email">
		
		<input type="password" name="passwordLogIn" id="passwordLogIn" placeholder="Password">
		
		<input type="checkbox" name="stayLoggedInLogIn" id="stayLoggedInLogIn">
		
		<button type="submit">Log in!</button>
	
	</form>

	<p id="errorMessageLogIn"></p>
	<?php echo $errorLogIn ?>



	<script type="text/javascript">
		
		// Check email is in the right format
		function isEmail(email) {

		 	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			
			return regex.test(email);
		}

		// When form submits continue
		$("#formSignUp").submit(function() {

			var error = "";

			// Display error if 1) email is empty, 2) email is invalid, and/ or 3) password is empty
			if ($("#emailSignUp").val() == "") {

				error += "<p>The email field cannot be empty.</p>";

			} else if (!isEmail($("#emailSignUp").val())) {

				error += "<p>The email entered is invalid.</p>"

			}

			if ($("#passwordSignUp").val() == "") {

				error += "<p>The password field cannot be empty.</p>";

			}

			// If an error is found, show error and prevent the form from submitting
			if (error != "") {

				$("#errorMessageSignUp").html(error);

				return false;

			}

		});


		// When form submits continue
		$("#formLogIn").submit(function() {

			var error = "";

			// Display error if 1) email is empty and/ or 2) password is empty
			if ($("#emailLogIn").val() == "") {

				error += "<p>The email field cannot be empty.</p>";

			} 

			if ($("#passwordLogIn").val() == "") {

				error += "<p>The password field cannot be empty.</p>";

			}

			// If an error is found, show error and prevent the form from submitting
			if (error != "") {

				$("#errorMessageLogIn").html(error);

				return false;

			}

		});


	</script>

</body>