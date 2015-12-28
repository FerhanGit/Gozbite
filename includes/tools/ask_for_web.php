<?php
  
   require_once("../header.inc.php");
  
  		
//==================================================================================================================		
		
   if(isset($_REQUEST['sendToFriend'])) {
      $ownName 	  = trim(htmlspecialchars($_REQUEST['ownName']));
      $txt        = trim(htmlspecialchars($_REQUEST['txt']));
      $emailTo      = trim($_REQUEST['email']);
		$mailToSend = "office@gozbite.com";
      $errors = "";
      $message = "";

      
      if(!isset($emailTo) || !eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$", $emailTo))
         $errors .= "<br /><span txt10 orange = \"error\">Моля, въведете валиден имейл! </span>";

      if(!isset($txt) || (strlen($txt) <= 0))
         $errors .= "<br /><span class = \"txt10 orange\">Моля, въведете текст на Запитването! </span>";

      if(strlen($errors) <= 0) 
      {

  	
      	//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('../classes/phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			//$body             = $mail->getFile('contents.html');
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			$body = "<html><br /><head><br /><title>GoZBiTe.Com | Запитване за реклама</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
         	$body .= sprintf("ЗАПИТВАНЕ ЗА РЕКЛАМА от: <strong>%s</strong><br /> и Е-мейл адрес за връзка: <strong>%s</strong><br /><br />", $ownName, $emailTo);
			 $body .= nl2br($txt);	
	        $body .= "</body><br /></html><br />";         
			$body  = eregi_replace("[\]",'',$body);
			
			
			
			
			$mail->From       = $emailTo;
			$mail->FromName   = $ownName;
			
			$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Zapitvane za izrabotka na WEB SITE ot $ownName ";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress($mailToSend);
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!empty($emailTo) && !empty($ownName))
			{
				
				if(!$mail->Send()) {
				  echo "<font color='red'><b>Грешка при изпращане:</b></font> " .$mail->ErrorInfo; 
				} 
				else {
				  echo "<br /><span><font color='red'><b>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</b></font></span><br />";
				}			
			}
			
					
      }
   }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <title>GoZBiTe.Com | Изпрати запитване за изработка на Уеб-сайт</title>
   <link rel = "stylesheet" href="../css/c.css" />
   <style>
      body {
            margin: 0 auto;
            padding: 0;
            text-align: center;
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 11px;
            background: url(none);
            background-color: #898989;
      }
   </style>
  <script type = "text/javascript">
		function validate() 
		{
		   theForm = document.itemform;
		
		   re = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
		
		   if((theForm.ownName.value.length == 0)) {
		      alert('Моля, въведете Вашето ИМЕ!');
		      theForm.ownName.focus();
		      return false;
		   }
		
		   if((theForm.email.value.length == 0) || !re.test(theForm.email.value)) {
		      alert('Моля, въведете ВАЛИДЕН e-mail за връзка с Вас!');
		      theForm.email.value = "";
		      theForm.email.focus();
		      return false;
		   }
		
		   if((theForm.txt.value.length == 0)) {
		      alert('Моля, въведете текста на вашето съобщение!');
		      theForm.txt.focus();
		      return false;
		   }
		
		   theForm.confirmOK.value = 1;
		   return true;
		}
	</script>
</head>
<body>
<form method = "post" name = "itemform" action = "ask_for_adv.php" onsubmit = "return validate();">
<table cellspacing = "0" cellpadding = "0" border = "0" style = "background-color: #F7F7F7; margin: 15px 10px 3px 10px; padding: 0;" width = "382">
   <tr>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_top_l_bw.gif); background-position: bottom left; background-repeat: no-repeat;"></td>
      <td style = "width: 370px; height: 6px; background: url(../img/fr_or_top_bw.gif); background-position: bottom; background-repeat: repeat-x;"></td>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_top_r_bw.gif); background-position: bottom right; background-repeat: no-repeat;"></td>
   </tr>
   <tr>
      <td style = "background: url(../img/fr_or_l_bw.gif); width: 6px; height: 100%; background-position: bottom; background-repeat: repeat-y;"></td>
      <td valign = "top" bgcolor = "#F7F7F7" align = "center">
         <table border = "0" cellspacing = "0" cellpadding = "3">
            <caption><strong>Запитване за изработка на Уеб-сайт</strong><br />
            <tr><td colspan = "2">&nbsp;</td></tr>
            <tr><td colspan = "2" style = "height: 10px;"></td></tr>


            <?php
               if($errors || $message) {
                  print "<tr><td colspan = \"2\" valign = \"top\" align = \"left\" class = \"txt11 orange\"><br />";
                  if(strlen($errors) > 0) {
                     print $errors;
                  } elseif(strlen($message) > 0) {
                     print $message;
                  }
                  print "</td></tr><br />";
                  print "<tr><td colspan = \"2\" style = \"height: 10px;\"></td></tr><br />";
               }
            ?>
            <tr>
               <td align = "right"><label for = "ownName">Вашето име:</label></td>
               <td><input type = "text" id = "ownName" name = "ownName" value = "" /></td>
            </tr>
            <tr>
               <td align = "right"><label for = "email">Вашият e-mail:</td>
               <td><input type="text" id = "email" name = "email" value = "" /></td>
            </tr>
            <tr>
               <td align = "right"><label for = "txt">Текст на запитването:</label><br /> <br /> (Напишете услугата или продукта към който проявявате интерес)</td>
               <td><textarea name = "txt" cols = "30" rows = "5"></textarea></td>
            </tr>
            <tr><td colspan = "2">&nbsp;</td></tr>
            <tr>
               <td align = "right" colspan = "2" style = "padding-right: 67px; padding-bottom: 20px;"><input type="submit" name = "sendToFriend" value = "изпрати" />&nbsp;<input type = "button" value = "затвори" onclick = "window.self.close()" /></td>
            </tr>
         </table>
      </td>
      <td valign = "top" style = "background: url(../img/fr_or_r_bw.gif); width: 6px; height: 100%; background-repeat: repeat-y;">&nbsp;</td>
   </tr>
   <tr>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_bot_l_bw.gif); background-repeat: no-repeat;"></td>
      <td style = "width: 370px; height: 6px; background: url(../img/fr_or_bot_bw.gif); background-repeat: repeat-x;"></td>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_bot_r_bw.gif); background-repeat: no-repeat;"></td>
   </tr>
</table>
<input type = "hidden" name = "confirmOK" value = "" />
</form>
</body>
</html>