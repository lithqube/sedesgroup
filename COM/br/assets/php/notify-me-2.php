<?php

header('content-type: application/json');
$o->status = 'success';
echo json_encode($o);

$email_to = "info@sedesgroup.it"; //Just write your email, no more :)
$email = $_POST["email"];
$text = "Congratulations ! A new person wants to be on the newsletter: $email";

$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html; charset=utf-8" . "\r\n"; 
$headers .= "From:<$email>\n";
mail($email_to, "Message", $text, $headers);

?>
