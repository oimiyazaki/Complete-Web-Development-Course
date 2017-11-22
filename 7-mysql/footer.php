	<script type="text/javascript">
			
			// switchLogInSignUp

			$(".switchLogInSignUp").click(function() {


				$("#signUp").toggle();
				$("#logIn").toggle();


			})




			// Check email is in the right format
			function isEmail(email) {

			 	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				
				return regex.test(email);
			}

			// When form submits continue
			$("#formSignUp").submit(function() {

				var error = "";
				$(".hide").hide();

				// Display error if 1) email is empty, 2) email is invalid, and/ or 3) password is empty
				if ($("#emailSignUp").val() == "") {

					error += "The email field cannot be empty.<br>";

				} else if (!isEmail($("#emailSignUp").val())) {

					error += "The email entered is invalid.<br>"

				}

				if ($("#passwordSignUp").val() == "") {

					error += "The password field cannot be empty.<br>";

				}

				// If an error is found, show error and prevent the form from submitting
				if (error != "") {
	
					$("#errorMessageSignUp").html("<div class='alert alert-danger'>" + error + "</div>");

					return false;

				}

			});


			// When form submits continue
			$("#formLogIn").submit(function() {

				var error = "";

				// Display error if 1) email is empty and/ or 2) password is empty
				if ($("#emailLogIn").val() == "") {

					error += "The email field cannot be empty.<br>";

				} 

				if ($("#passwordLogIn").val() == "") {

					error += "The password field cannot be empty.<br>";

				}

				// If an error is found, show error and prevent the form from submitting
				if (error != "") {

					$("#errorMessageLogIn").html("<div class='alert alert-danger'>" + error + "</div>");

					return false;

				}

			});

		</script>

	</body>
</html>