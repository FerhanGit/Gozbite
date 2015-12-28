<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('Europe/Sofia');
//date_default_timezone_set(date_default_timezone_get());

include_once('../class.phpmailer.php');

$mail             = new PHPMailer();
$body             = $mail->getFile('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSendmail(); // telling the class to use SendMail transport

$mail->CharSet       = "UTF-8";

$mail->From       = "ohboli@ohboli.bg";
$mail->FromName   = "Екип оХБоли";

$mail->AddReplyTo("floorer@gbg.bg", "Екип оХБоли"); // tova moje da go zadadem razli4no ot $mail->From

$mail->Subject    = "Новите ни предложения";
$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
$mail->MsgHTML($body);

$mail->Priority = 1;
$mail->ClearAddresses();
$mail->AddAddress("floorer@gbg.bg", "John Doe");

$mail->ClearAttachments();
$mail->AddAttachment("images/phpmailer.gif");             // attachment

if(!$mail->Send()) {
  echo "Грешка при изпращане: " . $mail->ErrorInfo; print_r($mail);
} else {
  echo "Успешно изпращане!";
}

?>
