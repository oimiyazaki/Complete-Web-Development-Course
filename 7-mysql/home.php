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
	if (array_key_exists("LogOut", $_POST)) {

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


	// Populate existing diary

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


	$email = $_SESSION["username"];


	$query = "SELECT diaryEntry FROM diary WHERE email = '".$email."'";

	$result = mysqli_query($link, $query);

	$previusDiaryEntry = "";

	if (mysqli_num_rows($result) > 0) {
    	// output data of each row
    	while($row = mysqli_fetch_assoc($result)) {

        	// echo $row["name"];
        	$previusDiaryEntry = $row["diaryEntry"];

    	}

	} else {

		echo "fail";


	}	



?>
<html>
	<head>
		<title>Diary</title>

	    <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>		
	
		<style type="text/css">
			html { 
			  background: url(road2.jpg) no-repeat center center fixed; 
			  -webkit-background-size: cover;
			  -moz-background-size: cover;
			  -o-background-size: cover;
			  background-size: cover;
			}
			body {
				font-family: Arial;
				color: #2f2f2f;
				background-color: transparent;
			}
			form {
				margin-top: 25px;
			}
			textarea {
				height: 80%;
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-toggleable-xl navbar-light bg-faded d-flex justify-content-between">
		 	<a class="navbar-brand mr-auto" href="#">Secret Diary</a>
			<form method="post" id="logOut" class="form-inline my-2 my-lg-0">
	    		<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="LogOut" value="Log out!">Logout</button>
	   		</form>
		</nav>
		<!-- <div id="status"></div> -->
		<div class="container-fluid text-center">
			<form method="post" id="diary" name="diaryEntry">
			 	<div class="form-group">
			   		<textarea class="form-control" id="diaryEntry" name="diaryEntry" rows="3" ><?php echo $previusDiaryEntry; ?></textarea>
			  	</div>
			</form>
		</div>

		<script type="text/javascript">

			function ajax_post(){
			    // Create our XMLHttpRequest object
			    var hr = new XMLHttpRequest();
			    // Create some variables we need to send to our PHP file
			    var url = "demo_test_post.php";
			    var diaryEntry = document.getElementById("diaryEntry").value;
			    var vars = "&diaryEntry="+diaryEntry;
			    hr.open("POST", url, true);
			    // Set content type header information for sending url encoded variables in the request
			    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			    // Access the onreadystatechange event for the XMLHttpRequest object
			    hr.onreadystatechange = function() {
			        if(hr.readyState == 4 && hr.status == 200) {
			            var return_data = hr.responseText;
			            document.getElementById("status").innerHTML = return_data;
			        }
			    }
			    // Send the data to PHP now... and wait for response to update the status div
			    hr.send(vars); // Actually execute the request
			    document.getElementById("status").innerHTML = "saving...";
			}

            
            $("#diaryEntry").keyup(function(){

                ajax_post();

            });


		</script>
	</body>
</html>