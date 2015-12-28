<?php
   require_once '../header.inc.php';


   if(isset($_REQUEST['userID']) && $_REQUEST['userID'] > 0 && $_SESSION['userID'] > 0) 
   {
   
   		$sql="SELECT * FROM users WHERE userID = '".$_SESSION['userID']."' LIMIT 1";
    	$conn->setsql($sql);
    	$conn->getTableRow();
		$resultOwnDetails = $conn->result;
		
		
		$sql="SELECT * FROM users WHERE userID = '".$_REQUEST['userID']."' LIMIT 1";
    	$conn->setsql($sql);
    	$conn->getTableRow();
		$resultFriendDetails = $conn->result;
   
		//======================================= Име на Изпращащия (този, който е ОН-Лайн) ==========================================
			$ownName = $resultOwnDetails['first_name'].' '.$resultOwnDetails['last_name'];
			if($_SESSION['userID'] == 1)
			{
				$ownName = 'Админ';
			}
		//==================================================================================================
	
		
		//======================================= Име на Приятеля ==========================================
			$friendName = $resultFriendDetails['first_name'].' '.$resultFriendDetails['last_name'];
			if($_REQUEST['userID'] == 1)
			{
				$friendName = 'Админ';
			}
		//==================================================================================================
	
		
   
      $txt        = trim(htmlspecialchars($_REQUEST['txt']));
      $emailTo    = trim($resultFriendDetails['email']);

      $errors = "";
      $message = "";

     
			//error_reporting(E_ALL);
		error_reporting(E_STRICT);
		
		date_default_timezone_set('Europe/Sofia');
		//date_default_timezone_set(date_default_timezone_get());
		
		include_once('../classes/phpmailer/class.phpmailer.php');
		
		$mail             = new PHPMailer();
		//$body             = $mail->getFile('contents.html');
		$mail->CharSet       = "UTF-8";
		$mail->IsSendmail(); // telling the class to use SendMail transport
		
		$body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong> от портала <a href=\"http://www.gozbite.com\" style=\"color: #ff6600;\">GoZbiTe.Com</a>, Ви изпраща следното съобщение: <br /><br />", $friendName, $ownName);
		$body .= sprintf("<strong><a href=\"http://www.gozbite.com/index.php?pg=users&userID=%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", $_SESSION['userID'], "Виж профила на ".$ownName)."<br /><br />";
        $body .= nl2br($txt);	
        $body .= "</body><br /></html><br />";         
		$body  = eregi_replace("[\]",'',$body);
		
		
		
		
		$mail->From       = $resultOwnDetails['email'];
		$mail->FromName   = $ownName." - GoZbiTe.Com";
		
		$mail->AddReplyTo($resultOwnDetails['email']); // tova moje da go zadadem razli4no ot $mail->From
		
		$mail->WordWrap = 100; 
		$mail->Subject    = "GoZbiTe.Com - Съобщение от $ownName ";
		$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
		$mail->MsgHTML($body);
		
		$mail->Priority = 1;
		$mail->ClearAddresses();
		$mail->AddAddress($emailTo);
		
		//$mail->ClearAttachments();
		//$mail->AddAttachment("images/phpmailer.gif");             // attachment
		
		 if(isset($_REQUEST['sendToFriend']))
		 {
			if(!empty($emailTo) && !empty($ownName))
			{
				if(!$mail->Send()) {
				  $message .= "Грешка при изпращане: " . $mail->ErrorInfo; 
				} else {
				  $message .= "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
				}
			}
			
		 }
	}
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <title>GoZbiTe.Com | Изпрати съобщение на потребител </title>
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
</head>
<body>
<form method = "post" name = "itemform" action = "sendMSGtofriend.php" >
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
            <caption><strong>Изпрати съобшение на приятел</strong></caption>
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
               <td align = "right"><label for = "txt">Текст:</label></td>
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
<input type = "hidden" name = "userID" value = "<?php print $_REQUEST['userID']; ?>" />
</form>
</body>
</html>