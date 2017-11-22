<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<body>

	<?php
		// set variables 
		$errAlert = "";
		$errSuccess = "";
		$errMessage = "";

		$email = "";
		$emailErr = "";

		// funtion to test email from w3school
		function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}

		// if form is submimtted
		if ($_POST) {

			// check email is not empty and that it's in the right format
			if (!$_POST["email"]) {
				$errMessage .= "The email field is required.<br>";
			} else {
			    $email = test_input($_POST["email"]);
			    // check if e-mail address is well-formed
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			    	$errMessage .= "The email is not in the right format.<br>";
				}
			}

			// check subject is not empty
			if (!$_POST["subject"]) {
				$errMessage .= "The subject field is required.<br>";
			}
			
			// check content is not empty
			if (!$_POST["content"]) {
				$errMessage .= "The content field is required.";
			}

			// there there are any error messages, display error messages
			if ($errMessage != "") {
				$errAlert =  
							'<div class="alert alert-danger">
								<strong>There were error(s) in your form:</strong>
								<p>'.$errMessage.'</p>
							</div>';	
			} else { // If there are no error messages... 

				// set email variables
				$mailTo = $_POST["email"];
				$subject = $_POST["subject"];
				$body = $_POST["content"];
				$header = "From: omar.miyazaki@gmail.com";

				// If all email variables are true, 1) send email and 2) show success messagge
				if (mail($mailTo, $subject, $body, $header)) {
				    $errSuccess = '<div class="alert alert-success">'."Your message was sent, we'll get to you ASAP!".'</div>';

				} else { // else, show error message that email was not sent
					$errAlert =  
							'<div class="alert alert-danger">
								<strong>There were error(s) in your form:</strong>
								<p>'."Your message was not sent successfully.".'</p>
							</div>';

				}
			}
	
		}
	?>

	<div class="container">
		<h1>Get in Touch!</h1>
		
		<!-- php error and success message AND javascript error -->
		<?php echo $errAlert; ?>
		<?php echo $errSuccess; ?>
		<div id="errAlert"></div>

		<!-- Contact form -->
		<form id="contactForm" method="post">
			<div class="form-group">
				<label for="email" >Email address</label>
				<input id="email" class="form-control" type="email" name="email" placeholder="Enter email">
				<p class="text-muted" >We'll never share your email with anyone else.</p>
			</div>
			<div class="form-group">
				<label for="suject">Subject</label>
				<input id="subject" class="form-control" type="text" name="subject">
			</div>
			<div class="form-group">
				<label for="content">What would you like to ask us?</label>
				<textarea id="content" class="form-control" name="content" rows="5"></textarea>
			</div>
			<input id="submit-btn" type="submit" class="btn btn-primary" name="Submit">
		</form>
	</div>

	<script type="text/javascript"> //////////////// script
		

		// When form is submitted do
		$("#contactForm").submit(function(event) {
			
			var errMessage = "";

			// check email is not empty
			if ($("#email").val() == "") {
				errMessage += "The email field is required.<br>";
			}

			// check subject is not empty
			if ($("#subject").val() == "") {
				errMessage += "The subject field is required.<br>";
			}

			// check content is not empty
			if ($("#content").val() == "") {
				errMessage += "The content field is required.";
			}

			// If any empty, show error message AND prevent the form from submitting
			if (errMessage != "") {
				$("#errAlert").html('<div class="alert alert-danger"><strong>There were error(s) in your form:</strong>' + '<p>' + errMessage + '</p></div>');
				event.preventDefault();
			} 

		})

	</script>

</body>
</html>

