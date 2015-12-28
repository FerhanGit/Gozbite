<?php
  
	require_once '../header.inc.php';


   if(isset($_REQUEST['sendToFriend'])) {
      $ownName = trim(htmlspecialchars($_REQUEST['ownName']));
      $friendName = trim(htmlspecialchars($_REQUEST['friendName']));
      $txt        = trim(htmlspecialchars($_REQUEST['txt']));
      $emailTo      = trim($_REQUEST['email']);

      $errors = "";
      $message = "";

      if(!isset($friendName) || (strlen($friendName) <= 0))
         $errors = "<br /><span class = \"txt10 orange\">Моля, попълнете името на вашия приятел! </span>";

      if(!isset($emailTo) || !eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$", $emailTo))
         $errors .= "<br /><span txt10 orange = \"error\">Моля, въведете валиден имейл! </span>";

     // if(!isset($txt) || (strlen($txt) <= 0))
         //$errors .= "<br /><span class = \"txt10 orange\">Моля, попълнете текста на съобщението! </span>";

      if(strlen($errors) <= 0) 
      {
     
			//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('../classes/phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			//$mail_body             = $mail->getFile('contents.html');
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			
			if(isset($_REQUEST['postID']) && $_REQUEST['postID'] > 0)
			{
				$mail_body = "<html><br /><head><br /><title>GoZbiTe.Com | Статии</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
	         	$mail_body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща следната Статия от <strong>GoZbiTe.Com</strong>:<br /><br />", $friendName, $ownName);
				$mail_body .= sprintf("<strong><a href=\"http://www.GoZbiTe.Com/index.php?pg=posts&postID=%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", $_REQUEST['postID'], "Прочети Статията")."<br /><br />";
		        $mail_body .= nl2br($txt);	
		        $mail_body .= "<br /><br />Поздрави от екипа на GoZbiTe.Com<br /><br />";
		        $mail_body .= "</body><br /></html><br />";         
				$mail_body  = eregi_replace("[\]",'',$mail_body);
			}
			elseif(isset($_REQUEST['drinkID']) && $_REQUEST['drinkID'] > 0)
			{
				$mail_body = "<html><br /><head><br /><title>GoZbiTe.Com | Описание на Напитка</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
	         	$mail_body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща следното Описание на Напитка от <strong>GoZbiTe.Com</strong>:<br /><br />", $friendName, $ownName);
				$mail_body .= sprintf("<strong><a href=\"http://www.GoZbiTe.Com/index.php?pg=drinks&drinkID=%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", $_REQUEST['drinkID'], "Разгледай Напитката")."<br /><br />";
		        $mail_body .= nl2br($txt);	
		        $mail_body .= "<br /><br />Поздрави от екипа на GoZbiTe.Com<br /><br />";
		        $mail_body .= "</body><br /></html><br />";         
				$mail_body  = eregi_replace("[\]",'',$mail_body);
			}
			elseif(isset($_REQUEST['recipeID']) && $_REQUEST['recipeID'] > 0)
			{
				$mail_body = "<html><br /><head><br /><title>GoZbiTe.Com | Рецепта</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
	         	$mail_body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща следното Описание на Рецепта от <strong>GoZbiTe.Com</strong>:<br /><br />", $friendName, $ownName);
				$mail_body .= sprintf("<strong><a href=\"http://www.GoZbiTe.Com/index.php?pg=recipes&recipeID=%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", $_REQUEST['recipeID'], "Разгледай Рецептата")."<br /><br />";
		        $mail_body .= nl2br($txt);	
		        $mail_body .= "<br /><br />Поздрави от екипа на GoZbiTe.Com<br /><br />";
		        $mail_body .= "</body><br /></html><br />";         
				$mail_body  = eregi_replace("[\]",'',$mail_body);
			}
			elseif(isset($_REQUEST['guideID']) && $_REQUEST['guideID'] > 0)
			{
				$mail_body = "<html><br /><head><br /><title>GoZbiTe.Com | Справочно Описание</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
	         	$mail_body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща следното Справочно Описание от <strong>GoZbiTe.Com</strong>:<br /><br />", $friendName, $ownName);
				$mail_body .= sprintf("<strong><a href=\"http://www.GoZbiTe.Com/index.php?pg=guides&guideID=%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", $_REQUEST['guideID'], "Разгледай Описанието от Справочника")."<br /><br />";
		        $mail_body .= nl2br($txt);	
		        $mail_body .= "<br /><br />Поздрави от екипа на GoZbiTe.Com<br /><br />";
		        $mail_body .= "</body><br /></html><br />";         
				$mail_body  = eregi_replace("[\]",'',$mail_body);
			}
			elseif(isset($_REQUEST['cardID']) && $_REQUEST['cardID'] > 0)
			{
				$mail_body = "<html><br /><head><br /><title>GoZbiTe.Com | Картички/Покани</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
	         	$mail_body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща следната Картичка/Покана от <strong>GoZbiTe.Com</strong>:<br /><br />", $friendName, $ownName);
				$mail_body .= sprintf("<strong><a href=\"http://www.GoZbiTe.Com/index.php?pg=cards&cardID=%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", $_REQUEST['cardID'], "Разгледай Картичката/Поканата")."<br /><br />";
		        $mail_body .= nl2br($txt);	
		        $mail_body .= "<br /><br />Поздрави от екипа на GoZbiTe.Com<br /><br />";
		        $mail_body .= "</body><br /></html><br />";         
				$mail_body  = eregi_replace("[\]",'',$mail_body);
			}
			elseif(isset($_REQUEST['firmID']) && $_REQUEST['firmID'] > 0)
			{
				$mail_body = "<html><br /><head><br /><title>GoZbiTe.Com | Заведение/Фирма</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
	         	$mail_body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща следния профил на Заведение/Фирма от <strong>GoZbiTe.Com</strong>:<br /><br />", $friendName, $ownName);
				$mail_body .= sprintf("<strong><a href=\"http://www.GoZbiTe.Com/index.php?pg=firms&firmID=%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", $_REQUEST['firmID'], "Разгледай профила на Заведение/Фирма")."<br /><br />";
		        $mail_body .= nl2br($txt);	
		        $mail_body .= "<br /><br />Поздрави от екипа на GoZbiTe.Com<br /><br />";
		        $mail_body .= "</body><br /></html><br />";         
				$mail_body  = eregi_replace("[\]",'',$mail_body);
			}
			elseif(isset($_REQUEST['bolestID']) && $_REQUEST['bolestID'] > 0)
			{
				$mail_body = "<html><br /><head><br /><title>GoZbiTe.Com | Описание на Заболяване</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
	         	$mail_body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща следното Описание на Заболяване от <strong>GoZbiTe.Com</strong>:<br /><br />", $friendName, $ownName);
				$mail_body .= sprintf("<strong><a href=\"http://www.GoZbiTe.Com/index.php?pg=bolesti&bolestID=%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", $_REQUEST['bolestID'], "Разгледай описание на Заболяването")."<br /><br />";
		        $mail_body .= nl2br($txt);	
		        $mail_body .= "<br /><br />Поздрави от екипа на GoZbiTe.Com<br /><br />";
		        $mail_body .= "</body><br /></html><br />";         
				$mail_body  = eregi_replace("[\]",'',$mail_body);
			}
			elseif(isset($_REQUEST['locationID']) && $_REQUEST['locationID'] > 0)
			{
				$mail_body = "<html><br /><head><br /><title>GoZbiTe.Com | Дестинацията/Населено място</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
	         	$mail_body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща следното описание на Дестинацията/Населено място от <strong>GoZbiTe.Com</strong>:<br /><br />", $friendName, $ownName);
				$mail_body .= sprintf("<strong><a href=\"http://www.GoZbiTe.Com/index.php?pg=locations&locationID=%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", $_REQUEST['locationID'], "Разгледай Дестинацията")."<br /><br />";
		        $mail_body .= nl2br($txt);	
		        $mail_body .= "<br /><br />Поздрави от екипа на GoZbiTe.Com<br /><br />";
		        $mail_body .= "</body><br /></html><br />";         
				$mail_body  = eregi_replace("[\]",'',$mail_body);
			}
			elseif(isset($_REQUEST['aphorismID']) && $_REQUEST['aphorismID'] > 0)
			{
				$mail_body = "<html><br /><head><br /><title>GoZbiTe.Com | Фраза/Афоризъм</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
	         	$mail_body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща интересна Фраза/Афоризъм от <strong>GoZbiTe.Com</strong>:<br /><br />", $friendName, $ownName);
				$mail_body .= sprintf("<strong><a href=\"http://www.GoZbiTe.Com/index.php?pg=aphorisms&aphorismID=%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", $_REQUEST['aphorismID'], "Разгледай Фразата")."<br /><br />";
		        $mail_body .= nl2br($txt);	
		        $mail_body .= "<br /><br />Поздрави от екипа на GoZbiTe.Com<br /><br />";
		        $mail_body .= "</body><br /></html><br />";         
				$mail_body  = eregi_replace("[\]",'',$mail_body);
			}
			elseif(isset($_REQUEST['questionID']) && $_REQUEST['questionID'] > 0)
			{ 
				$mail_body = "<html><br /><head><br /><title>GoZbiTe.Com | Форум Мнение/Коментар</title><br /><style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head><br /><body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\"><br />";
	         	$mail_body .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща интересно Мнение/Коментар от Форума на <strong>GoZbiTe.Com</strong>:<br /><br />", $friendName, $ownName);
				$mail_body .= sprintf("<strong><a href=\"http://www.GoZbiTe.Com/index.php?pg=forums&questionID=%d#question_%d\" style=\"color: #ff6600;\"><span style = \"text-transform: uppercase;\">%s</span></a></strong>", get_question_parentID($_REQUEST['questionID']), $_REQUEST['questionID'], "Разгледай Мнението/Коментара")."<br /><br />";
		        $mail_body .= nl2br($txt);	
		        $mail_body .= "<br /><br />Поздрави от екипа на GoZbiTe.Com<br /><br />";
		        $mail_body .= "</body><br /></html><br />";         
				$mail_body  = eregi_replace("[\]",'',$mail_body);
			}
			
			
			
			
			
			
			$mail->From       = $emailTo;
			$mail->FromName   = $ownName;
			
			$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "От твоя приятел $ownName ";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($mail_body);
			
			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress($emailTo);
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			if(!empty($emailTo) && !empty($ownName))
			{
				if(!$mail->Send()) {
				  echo "Грешка при изпращане: " . $mail->ErrorInfo; 
				} else {
				  echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
				}
			}


      }
   }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <title>GoZbiTe.Com | Изпрати на приятел</title>
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
   <script type = "text/javascript" src = "../js/sndtofrnd.js"></script>
</head>
<body>
<form method = "post" name = "itemform" action = "sendStuffToFriend.php" onsubmit = "return validate();">
<table cellspacing = "0" cellpadding = "0" border = "0" style = "background-color: #F7F7F7; margin: 15px 10px 3px 10px; padding: 0;" width = "382">
    <tr>
      <td style = "background: url(../img/fr_or_l_bw.gif); width: 6px; height: 100%; background-position: bottom; background-repeat: repeat-y;"></td>
      <td valign = "top" bgcolor = "#F7F7F7" align = "center">
         <table border = "0" cellspacing = "0" cellpadding = "3">
            <caption><strong>Изпрати на приятел</strong></caption>
            <tr><td colspan = "2">&nbsp;</td></tr>
            <tr><td colspan = "2" style = "height: 10px;"></td></tr>

            <?php
               if($errors || $message) {
                  print "<tr><td colspan = \"2\" valign = \"top\" align = \"left\" class = \"txt11 orange\">\n";
                  if(strlen($errors) > 0) {
                     print $errors;
                  } elseif(strlen($message) > 0) {
                     print $message;
                  }
                  print "</td></tr>\n";
                  print "<tr><td colspan = \"2\" style = \"height: 10px;\"></td></tr>\n";
               }
            ?>
           <tr>
               <td align = "right"><label for = "ownName">Вашето име:</label></td>
               <td><input type = "text" id = "ownName" name = "ownName" value = "" /></td>
           </tr>
           <tr>
               <td align = "right"><label for = "friendName">име на приятеля:</label></td>
               <td><input type = "text" id = "friendName" name = "friendName" value = "" /></td>
            </tr>
            <tr>
               <td align = "right"><label for = "email">e-mail:</td>
               <td><input type="text" id = "email" name = "email" value = "" /></td>
            </tr>
            <tr>
               <td align = "right"><label for = "txt">текст:</label></td>
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
  
</table>
<input type = "hidden" name = "confirmOK" value = "" />
<input type = "hidden" name = "postID" value = "<?php print $_REQUEST['postID']; ?>" />
<input type = "hidden" name = "drinkID" value = "<?php print $_REQUEST['drinkID']; ?>" />
<input type = "hidden" name = "recipeID" value = "<?php print $_REQUEST['recipeID']; ?>" />
<input type = "hidden" name = "guideID" value = "<?php print $_REQUEST['guideID']; ?>" />
<input type = "hidden" name = "firmID" value = "<?php print $_REQUEST['firmID']; ?>" />
<input type = "hidden" name = "aphorismID" value = "<?php print $_REQUEST['aphorismID']; ?>" />
<input type = "hidden" name = "bolestID" value = "<?php print $_REQUEST['bolestID']; ?>" />
<input type = "hidden" name = "questionID" value = "<?php print $_REQUEST['questionID']; ?>" />
<input type = "hidden" name = "locationID" value = "<?php print $_REQUEST['locationID']; ?>" />
<input type = "hidden" name = "cardID" value = "<?php print $_REQUEST['cardID']; ?>" />
</form>
</body>
</html>