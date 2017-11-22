<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<style type="text/css">
		#circle {
			background-color: green;
			width: 100px;
			height: 100px;
			margin-bottom: 10px;
			border-radius: 50%;
		}
	</style>
</head>
<body>
	<div id="circle"></div>

	<script type="text/javascript">

	$("#circle").click(function() {
		$(this).animate({
			width:"400px", 
			height:"400px",
			marginLeft:"100px",
			marginTop:"100px"
		}, 5000, function() {
			$(this).css("background-color", "red");
			}
		);
	});


	</script>
</body>
</html>