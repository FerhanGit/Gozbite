<?php

   require_once("includes/header.inc.php");
	
  	header('Content-type: text/html; charset=utf-8');
  
   $unsubscribe = $_REQUEST['unsubscribe'];

   
	if(isset($unsubscribe) && $unsubscribe != '')
	{	     	   	
		$emailMy = 'office@gozbite.com';
								
		error_reporting(E_ALL);
		//error_reporting(E_STRICT);
		
		date_default_timezone_set('Europe/Sofia');
		//date_default_timezone_set(date_default_timezone_get());
		
		include_once('includes/classes/phpmailer/class.phpmailer.php');
		
		$mail             	= new PHPMailer();
		$mail->CharSet      = "UTF-8";
		$mail->IsSendmail(); // telling the class to use SendMail transport
		$mail->Priority = 3;
		$mail->WordWrap = 100; 
		
		$body = "<a  style='border:none; text-decoration:none' href='http://GoZbiTe.Com'><img style='border:none;' src='http://GoZbiTe.Com/images/logce.png'></a><br /><br /><br /><br />";			  	
  		$body .= '<br /><br /><div style="background-color: #FFFFFF;">Заведение/Фирма с е-мейл адрес: <b>'.$unsubscribe.'</b> не желае да получава повече подобни писма</div>';
			
       
						
		$mail->From       = "office@gozbite.com";
		$mail->FromName   = "GoZbiTe.Com";			
		//$mail->AddReplyTo("office@GoZbiTe.Com"); // tova moje da go zadadem razli4no ot $mail->From
		
		
		$mail->Subject    = 'Jelaesht da se otkaje ot Buletina na GoZbiTe.Com';
		$mail->AltBody    = "За да видите това писмо, моля използвайте e-mail клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
		$mail->MsgHTML($body);
		
		$mail->ClearAddresses();
		$mail->AddAddress($emailMy);
	
		if(!$mail->Send()) {
		 // $Error .= "<br />Грешка при изпращане: " . $mail->ErrorInfo; 
		} else {
		 	?>
	        	<script type="text/javascript">alert("Благодарим Ви! Вие се отписахте успешно!"); window.location.href='http://GoZbiTe.Com';</script> 
	        <?php 
		  //$Error .= "<br /><span>Благодарим Ви!<br />Вие се отписахте успешно</span><br />";
		}
	}
	
   
?>