<?php 

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$consumerKey = "wzPsPtKWcV94LvcZGRuaP3Fhm";
$consumerSecret = "mS8Wo2TMFsUC3JeLFD86U0cKRzp73G84YUeb4D5tkeFfpwDHAe";
$accessToken = "4562631918-CdQcuHlTEWFKxhm7HTY7gk47k5cR7EfaWJXEPD9";
$accessTokenSecret = "SM2HzAbLYxrgRjV3IS3Zk3NBSZGrLgabSfaqCytlNgSSR";

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

$content = $connection->get("account/verify_credentials");

$statuses = $connection->get("statuses/home_timeline/MiyazakiOmar", ["count" => 25, "exclude_replies" => true]);

$tweets = "";

foreach ($statuses as $key => $value) {
	if ($statuses[$key] -> favorite_count > 5) {

		$text = $statuses[$key] -> text;
		$pos = strpos($text, "http");
		$title = substr($text, 0, $pos - 1);
		$link = "";

		if (!empty($statuses[$key] -> entities -> urls)) {
			$link = $statuses[$key] -> entities -> urls[0] -> url;

		}

		$tweets .= "<li><a href=".'"'.$link.'"'.">".$title."</a>"."<br><br><span><i class='fa fa-retweet' aria-hidden='true'></i>".$statuses[$key] -> retweet_count." &#x2764;   ".$statuses[$key] -> favorite_count."</span></li>";


	}
}



?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css"> <!-- made up name-->
	<style type="text/css">
		body {
			background-color: #E8E8E8;
			margin: 0;
			padding: 0;
			font-family: Arial;
			color: #404040;
		}
		#header {
			background-color: white;
			width: 100%;
			height: 75px;
			border-bottom: 3px solid #4AB3F4;
		}
		h1 {
			color: #404040;
			margin: 0;
			position: relative;
			padding-top: 20px;
			padding-left: 40px;
		}
		ul {
			list-style-type: none;			
		}
		li {
			background-color: white;
			min-height: 50px;
			margin-bottom: 10px;
			max-width: 500px;
			padding: 10px;
			font-size: 18px;
			border-radius: 5px;
		}
		a {
			text-decoration: none;
			color: #404040;
		}
		a:hover {
			color: #3498DB;
		}
		span {
			font-size: 14px;
		}
	</style>
</head>
<body>
	<div id="header">
		<h1>Omar Miyazaki Twitter Feed</h1>
	</div>
	<ul>
<!-- 		<li><a href="">Science says you'll remember more if you take notes with a pen and paper instead of a laptop</a></li>
		<li><a href="">Pick one task and focus on it intensely</a></li>
		<li><a href="">Nintendo may make as many as 30 million Switches next year</a></li>
		<li><a href="">A NASA scientist might have cracked the answer to making Mars habitable</a></li>
		<li><a href="">What it takes to close the strategy-execution gap</a></li> -->
		
		<?php 
			echo $tweets 
		?>

	</ul>

	<script type="text/javascript">
		

	</script>
</body>
</html>
 	