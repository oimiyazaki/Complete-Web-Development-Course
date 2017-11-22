<?php 

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$consumerKey = "wzPsPtKWcV94LvcZGRuaP3Fhm";
$consumerSecret = "mS8Wo2TMFsUC3JeLFD86U0cKRzp73G84YUeb4D5tkeFfpwDHAe";
$accessToken = "4562631918-CdQcuHlTEWFKxhm7HTY7gk47k5cR7EfaWJXEPD9";
$accessTokenSecret = "SM2HzAbLYxrgRjV3IS3Zk3NBSZGrLgabSfaqCytlNgSSR";

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

$content = $connection->get("account/verify_credentials");

// $statues = $connection->post("statuses/update", ["status" => "This came from my twitter app!"]);

$statuses = $connection->get("statuses/home_timeline/MiyazakiOmar", ["count" => 25, "exclude_replies" => true]);

print_r($statuses)

// foreach ($statuses as $key => $value) {
// 	if ($statuses[$key] -> favorite_count > 5) {
// 		echo $statuses[$key] -> text;
// 		echo "<br>";
// 	}
// }

?>