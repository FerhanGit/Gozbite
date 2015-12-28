<?php
  
   require_once("../inc/dblogin.inc.php");
  

   if(isset($_REQUEST['sendToFriend'])) {
      $friendName = trim(htmlspecialchars($_REQUEST['friendName']));
      $txt        = trim(htmlspecialchars($_REQUEST['txt']));
      $email      = trim($_REQUEST['email']);

      $errors = "";
      $message = "";

      if(!isset($friendName) || (strlen($friendName) <= 0))
         $errors = "<br /><span class = \"txt10 orange\">Моля, попълнете името на вашия приятел! </span>";

      if(!isset($email) || !eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$", $email))
         $errors .= "<br /><span txt10 orange = \"error\">Моля, въведете валиден имейл! </span>";

      if(!isset($txt) || (strlen($txt) <= 0))
         $errors .= "<br /><span class = \"txt10 orange\">Моля, попълнете текста на съобщението! </span>";

      if(strlen($errors) <= 0) {
         // Sending Mail
         $mailTo = $email;
         $mailFrom = "OHboli.BG <system@oh-boli.bg>";

         require_once("../classes/htmlMimeMail.class.php");

         $mail = new htmlMimeMail();
         $mail->setTextCharset('utf-8');
         $mail->setHtmlCharset('utf-8');
         $mail->setHeadCharset('utf-8');

         $htmlTxt = "<html>\n<head>\n<title>OHboli.бг | Новини</title>\n<style>body, td, span { font-family: Verdana, Arial, Tahoma, Helvetica, Geneva, sans-serif; font-size: 11px; color: #333333; }</style></head>\n<body topmargin = \"10\" leftmargin = \"20\" marginheight = \"10\" marginwidth = \"20\" bgcolor=\"#ffffff\">\n";
         $htmlTxt .= sprintf("Здравейте, <strong>%s</strong>.<br /><br />Вашият приятел <strong>%s</strong>, Ви изпраща следната Новина от <strong>OHboli.BG</strong>:<br /><br />", $friendName, $_SESSION['username']);

         $htmlTxt .= sprintf("<strong><a href = \"http://www.ohboli.bg/news.php?newsID=%d\" style = \"color: #ff6600;\" target = \"_blank\"><span style = \"text-transform: uppercase;\">%s</span></a></strong><br />", $_REQUEST['newsID'], $Offr->estateTypeName);
       
         $htmlTxt .= nl2br($txt);

         $htmlTxt .= "<br /><br />Поздрави от екипа на OHboli.BG<br /><br />";
         $htmlTxt .= "</body>\n</html>\n";

         $mail->setHtml($htmlTxt);

         $mail->setSubject("OHboli.bg, Новини| Новина от приятел");

         $mail->setFrom($mailFrom);

//         if($mail->send(array($mailTo),'smtp'))
         if($mail->send(array($mailTo)))
            $message = "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
         else {
            $message = "<br /><span>По технически причини вашето съобщение не беше изпратено.</span><br />";
				//print_r($mail->errors);
			}
      }
   }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <title>Largo.bg | Изпрати на приятел</title>
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
<form method = "post" name = "itemform" action = "sendtofriend.php" onsubmit = "return validate();">
<table cellspacing = "0" cellpadding = "0" border = "0" style = "margin: 15px 10px 3px 10px; padding: 0;" width = "382">
   <tr>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_top_l_bw.gif); background-position: bottom left; background-repeat: no-repeat;"></td>
      <td style = "width: 370px; height: 6px; background: url(../img/fr_or_top_bw.gif); background-position: bottom; background-repeat: repeat-x;"></td>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_top_r_bw.gif); background-position: bottom right; background-repeat: no-repeat;"></td>
   </tr>
   <tr>
      <td style = "background: url(../img/fr_or_l_bw.gif); width: 6px; height: 100%; background-position: bottom; background-repeat: repeat-y;"></td>
      <td valign = "top" bgcolor = "#ffffff" align = "center">
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
   <tr>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_bot_l_bw.gif); background-repeat: no-repeat;"></td>
      <td style = "width: 370px; height: 6px; background: url(../img/fr_or_bot_bw.gif); background-repeat: repeat-x;"></td>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_bot_r_bw.gif); background-repeat: no-repeat;"></td>
   </tr>
</table>
<input type = "hidden" name = "confirmOK" value = "" />
<input type = "hidden" name = "bolestID" value = "<?php print $_REQUEST['bolestID']; ?>" />
</form>
</body>
</html>