<?php 


////////////////// Cookie

	////// Set cookie
	setcookie("customerID", "1234", time() + 60 * 60 * 24);


	////// echo cookie (even after it's been set)
	echo $_COOKIE["customerID"];
	echo "<br><br>";

	////// Remove Cookie
	// setcookie("customerID", "", time() - 60 * 60);


	////// Update cookie
	$_COOKIE["customerID"] = "test";


	////// echo cookie (even after it's been set)
	echo $_COOKIE["customerID"];
	echo "<br><br>";

////////////////// Password 

	////// Hash password
	$hash = password_hash("mypassword", PASSWORD_DEFAULT);

	echo $hash;

	echo "<br><br>";

	////// Verify password
	if (password_verify('mypassword', $hash)) {
		echo "Password is valid!";
	} else {
		echo 'Invalid password';
	}


?>


