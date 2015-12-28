<?php 

	require_once("../functions.php");
	require_once("../config.inc.php");
	require_once("../bootstrap.inc.php");
   
	$conn = new mysqldb();
	
	header('Content-type: text/html;charset=utf-8');
		
		
  		$price = $_REQUEST['price'];
	
	// ==================================== MAIL SEND ============================================
	
			//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('../classes/phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			//$body             = $mail->getFile('contents.html');
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			$body = "<img src='http://GoZBiTe.Com/images/logce.png'><br /><br /><br /><br />";			
			
			
			$body .= "<div style=\"width:800px; background-color:#0099FF; color:#FFFFFF; \">";
			$body .= "Извършено е плащане чрез <b><font color='#FF6600'> ePay.Bg </font></b> в GoZBiTe.Com на стойност ".$price." лева.<br /><br />";
	   		$body .= "</div>";
			 
		 
			$body  = eregi_replace("[\]",'',$body);
			
						
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "ePay.GoZBiTe.Com" ;
			
			//$mail->AddReplyTo("office@izlet.bg"); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Плащане чрез ePay.bg в GoZBiTe.Com";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress("office@gozbite.com");
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!$mail->Send()) {
			  $MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo; 
			} else {
			  //$MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в иЗЛеТ.Бг.</span><br />";
			}
		

	// ================================= KRAI na MAIL-a =========================================
	

?>