
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

	<form>
		<input type="text" name="address" id="address">
		<input type="submit" name="submit">
	</form>
	<div id="result"></div>
	<script type="text/javascript">
		


		$("form").submit(function() {

			var address = "";

			address = $("#address").val();
			urlAddress = encodeURI(address);
			// alert(urlAddress);


			// "https://maps.googleapis.com/maps/api/geocode/json?address="+urlAddress+"&key=AIzaSyBkZ7zkN_Tk8s4XaEVQh3-JthG2LxWeewk"


			$.ajax({
				url: "https://maps.googleapis.com/maps/api/geocode/json?address="+urlAddress+"&key=AIzaSyBkZ7zkN_Tk8s4XaEVQh3-JthG2LxWeewk",
				type: "GET",
				success: function(data) {

					console.log(data);
					// alert(data['status']);

					if (data['status'] != "OK") {

						alert("Zipcode not found");


					} else {


						$.each(data['results'][0]['address_components'][7], function(index, value) {

							if (index == 'short_name') {

								alert(value);

							}

						});


					}





				}});





			return false;
		});










	</script>
</body>
</html>