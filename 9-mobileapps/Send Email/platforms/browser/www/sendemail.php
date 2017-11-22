<?php
$to = $_POST["fromEmail"];
$subject = $_POST["toEmail"];
$txt = $_POST["emailSubject"];
$headers = $_POST["emailMessage"];


if (mail($to,$subject,$txt,$headers)) {

	echo '{"result":"success"}';

} else {

	echo '{"result":"error"}';

}

?>