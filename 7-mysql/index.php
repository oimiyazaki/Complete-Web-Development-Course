<?php 

	// Start session
	session_start();

	if (array_key_exists("username", $_COOKIE) || array_key_exists("username", $_SESSION)) {

		header("Location: home.php");

	}

	include("connection.php");

	// Set variables
	$errorSignUp = "";
	$errorLogIn = "";


	// If the form sign up is submitted
	if (isset($_POST["emailSignUp"]) || isset($_POST["passwordSignUp"])) {

		$email = mysqli_real_escape_string($link, $_POST["emailSignUp"]);
		$email = strtolower($email);
		$password = mysqli_real_escape_string($link, $_POST["passwordSignUp"]);

		// Display error if 1) email is empty, 2) email is invalid, and/ or 3) password is empty
		if ($email == "") {

			$errorSignUp .= "The email field cannot be empty.<br>";

		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

			$errorSignUp .= "The email entered is invalid.<br>";
			
			}

		if ($password == "") {

			$errorSignUp .= "<p>The password field cannot be empty.<br>";

		}

		// If no errors were found continue
		if ($errorSignUp == "") {

			// check if email is already in use
			$query = "SELECT * FROM diary WHERE email = '".$email."'";

			$result = mysqli_query($link, $query);

			if (mysqli_num_rows($result) > 0) {

				$errorSignUp .= "The email entered is already in use.<br>";

			} else {

				// Add user to the database
				$hash = password_hash($password, PASSWORD_DEFAULT);

				$query = "INSERT INTO diary (email, password, diaryEntry) VALUES ('".$email."', '".$hash."', 'Welcome to your secret diary! Start here  :)')";

				if (mysqli_query($link, $query) === TRUE) { 

					// If they decided to stay logged in, create cookie
					if (isset($_POST["stayLoggedInSignUp"])) {

						setcookie("username", $email, time() + 86400 * 7);
						
					} 

					// Create session and log them in
					$_SESSION["username"] = $email; 

					header("Location: home.php");


				} else {

					// Show error if the user could not be added 
					$errorSignUp .= "An error occured. Please try again.<br>";

				}				


			}


		} 


	}

	if ($errorSignUp != "") {

		$errorSignUp = "<div class='hide alert alert-danger'>".$errorSignUp."</div>";

	}


	// If the form log in is submitted
		if (isset($_POST["emailLogIn"]) || isset($_POST["passwordLogIn"])) {

			$email = mysqli_real_escape_string($link, $_POST["emailLogIn"]);
			$email = strtolower($email);
			$password = mysqli_real_escape_string($link, $_POST["passwordLogIn"]);

			// Display error if 1) email is empty, 2) email is invalid, and/ or 3) password is empty
			if ($email == "") {

				$errorLogIn .= "The email field cannot be empty.<br>";

			} 

			if ($password == "") {

				$errorLogIn .= "The password field cannot be empty.<br>";

			}

			// If no errors were found continue
			if ($errorLogIn == "") {

				// Query for email addres in DB
				$query = "SELECT * FROM diary WHERE email = '".$email."'";

				$result = mysqli_query($link, $query);

				// Show error if the email address is not found
				if (!mysqli_num_rows($result) > 0) {

					$errorLogIn .= "Invalid email or password.<br>";

				} else {

					// Query for email address
					$row = mysqli_fetch_array($result);

					// Show error if the password is not a match
					if (!password_verify($password, $row["password"])) {

						$errorLogIn .= "Invalid email or password.<br>";

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

	if ($errorLogIn != "") {

		$errorLogIn = "<div class='hide alert alert-danger'>".$errorLogIn."</div>";

	}

?>
<?php include("header.php"); ?>

	<body>
		<div class="container-fluid text-center">
			<h1>Secret Diary</h1>
			<h5>Store your thoughts permanently and securely.</h5>
			<div id="signUp">
				<h5>Interested? Sign up now.</h5>
				<!-- errors -->
				<div id="errorMessageSignUp" class="d-flex justify-content-center"></div>
				<div class="d-flex justify-content-center"><?php echo $errorSignUp ?></div>
				<!-- Sign up form -->
				<form method="post" id="formSignUp">
					<div class="form-group d-flex justify-content-center">
						<input class="form-control" type="text" name="emailSignUp" id="emailSignUp" placeholder="Email">
					</div>
					<div class="form-group  d-flex justify-content-center">
						<input class="form-control" type="password" name="passwordSignUp" id="passwordSignUp" placeholder="Password">
					</div>
					<div class="form-check">
					    <label class="form-check-label">
					      <input type="checkbox" class="form-check-input" name="stayLoggedInSignUp" id="stayLoggedInSignUp">
					      Stay logged in
					    </label>
					 </div>
					<button type="submit" class="btn btn-success my-2 my-sm-0">Sign up!</button>
				</form>
				<!-- Switch between signup and login -->
				<br>
				<a class="switchLogInSignUp" href="#">Log in</a>
			</div>
			<div id="logIn">
				<h5>Log in using your username and password.</h5>

				<div id="errorMessageLogIn" class="d-flex justify-content-center"></div>
				<div class="d-flex justify-content-center"><?php echo $errorLogIn ?></div>
				<!-- Log in form -->
				<form method="post" id="formLogIn">
					<div class="form-group d-flex justify-content-center">
						<input class="form-control" type="text" name="emailLogIn" id="emailLogIn" placeholder="Email">
					</div>
					<div class="form-group d-flex justify-content-center">
						<input class="form-control" type="password" name="passwordLogIn" id="passwordLogIn" placeholder="Password">
					</div>
					<div class="form-check">
					    <label class="form-check-label">
					      <input type="checkbox" class="form-check-input" name="stayLoggedInLogIn" id="stayLoggedInLogIn">
					      Stay logged in
					    </label>
					 </div>
					<button type="submit" class="btn btn-success my-2 my-sm-0">Log in!</button>
				</form>
				<!-- Switch between signup and login -->
				<br>
				<a class="switchLogInSignUp" href="#">Sign up</a>
			</div>

			

		</div> 

<?php include("footer.php"); ?>