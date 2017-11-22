<!DOCTYPE html>
<html>
<head>
	<title>What's The Weather?</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<style type="text/css">
		body {
		    background-image: url("background-weather.jpg");
			background-size: auto 2500px;
    		background-position: center;
    		background-color: #F0F8FF;
		}
		h1 {
			margin-top: 75px;
		}
		#city-input {
			width: 400px;
		}
		.alert {
			width: 400px;
		}
	</style>
</head>
<body>
	<?php

		$city = "";
		$websiteContent = "";
		$weatherAlert = "";
		$error = "";

		function replaceAll($text) { 
		    $text = str_replace(" ", "-", $text);
		    return $text;

    	}


		if ($_POST) {

			// Check if empty city field
			if ($_POST["city"] == "") {
				
				$error = '<div class="alert alert-danger" id="error">Please add a city to search.</div>';
			
			} 

			// convert URL to city
			$city = replaceAll($_POST["city"]);
			$url = "http://www.weather-forecast.com/locations/".$city."/forecasts/latest";
			$websiteContent = @file_get_contents($url);

			// check if city exists. If it doesn't the website will not open
			if ($websiteContent === FALSE) { 
				
				$error = '<div class="alert alert-danger" id="error">'.$_POST["city"].' was not found, sorry.</div>';

			} else {
				

				// search for summary
				$needle1 = 'Weather Forecast Summary:';
				$needle2 = '</span>';

				$posStart = strpos($websiteContent, $needle1) + 92;
				$posEnd = strpos($websiteContent, $needle2, $posStart);

				$messageLenght = $posEnd - $posStart;

				$weatherSummary = substr($websiteContent, $posStart, $messageLenght);

				// create weather message
				$weatherAlert = '<div class="alert alert-success" id="errorSuccess"><strong>'.$_POST["city"].'</strong><br>'.$weatherSummary.'</div>';

			}

		}







	?>

	<div class="container text-center d-flex justify-content-center">
		<div id="width-container">
			<h1>What's The Weather?</h1>
			<p class="lead">Enter the name of a city.</p>

			<!-- Form -->
			<form method="post">
				<div class="form-group">
					<input class="form-control" id="city-input" type="text" name="city" placeholder="Eg. London, Tokyo">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>

			<!-- Alerts -->
			<div id="response"></div>
			<?php echo $weatherAlert; echo $error;?>
		</div>
	</div>

	<script type="text/javascript"> /////////////// Script
		
		var errMessage = "";

		// submit form
		$("form").submit(function() {

			errMessage = $("#city-input").val()

			// if empty, show error
			if (errMessage == "") {

				errMessage += "Please add a city to search.";

				$("#response").html('<div class="alert alert-danger" id="error">Please add a city to search.</div>');

				return false;

			} 

		})

	</script>

</body>
</html>