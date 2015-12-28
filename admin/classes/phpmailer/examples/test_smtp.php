<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('Europe/Sofia');
//date_default_timezone_set(date_default_timezone_get());

include_once('../class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer(true);

$body             = $mail->getFile('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();    // telling the class to use SMTP

$mail->SMTPDebug  = 2;
$mail->SMTPAuth   = true; // turn on SMTP authentication
$mail->Username   = "ohboli@ohboli.bg"; // SMTP username
$mail->Password   = "fsdboing"; // SMTP password


$mail->Host       = "mail.ohboli.bg"; // SMTP server
$mail->SetLanguage("ru");
   
$mail->From       = "ohboli@ohboli.bg";
$mail->FromName   = "Екип оХБоли";

$mail->WordWrap = 100;  
$mail->Subject    = "Новите ни предложения";
$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test

$mail->Priority = 1;
$mail->MsgHTML($body);

$mail->ClearAddresses();
$mail->AddAddress("floorer@gbg.bg", "John Doe");

$mail->ClearAttachments();
$mail->AddAttachment("images/phpmailer.gif");             // attachment

if(!$mail->Send()) {
  echo "Грешка при изпращане: " . $mail->ErrorInfo; 
} else {
  echo "Успешно изпращане!";
}

?>
