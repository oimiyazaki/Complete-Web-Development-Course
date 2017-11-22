<?php 

// variable lesson
$myArray = array("Rob", "Homer", "Tommy", "Jamie");

$myArray[] = "Bronie";

print_r($myArray);

echo "<br><br>";

$anotherArray[0] = "pizza";
$anotherArray[1] = "yoghurt";
$anotherArray["myFavoriteFood"] = "tacos";

print_r($anotherArray);

echo "<br><br>";

$thirdArray = array(
	"France" => "French", 
	"USA" => "English", 
	"Germany" => "German");

unset($thirdArray["France"]);

print_r($thirdArray);

echo sizeof($thirdArray);

echo "<br><br><br><br>";


// Include file php lesson
include("includedfile.php");

echo "<br><br><br><br>";
// Email lesson
$mailTo = "omar.miyazaki@gmail.com";
$subject = "I hope this works";
$body = "I think you're great!";
$header = "From: omar.miyazaki@gmail.com";

if (mail($mailTo, $subject, $body, $header)) {
    echo "the email was sent successfully";
} else {
    echo "it was not successful";
}

?>


<p>What is your name</p>

<form method="post">
	<input type="text" name="name">
	<input type="submit" name="Go!">
</form>

