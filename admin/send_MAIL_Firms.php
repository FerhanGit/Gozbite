<?php
$pageName = 'send_bulletin';

	include_once("inc/dblogin.inc.php");
	require_once("classes/phpmailer/class.phpmailer.php");
	require_once("classes/Upload.class.php");
	ini_set('max_execution_time', '5750');
	header('Content-type: text/html; charset=utf-8');



if(isset($_REQUEST['sendMails']))
{



	// ============================ UPLOADVA localno Attachmentite i vru6ta ARRAY s putq do tqh =============================

		if(is_array($_FILES['attachment']) && (count($_FILES['attachment']) > 0))
         {
            $files = array();
            foreach ($_FILES['attachment'] as $k => $l) {
               foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // ../pics Manipulation and Upload
           	foreach($files as $file) {
               $upPic = new Upload($file);
               if ($upPic->uploaded) {
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/attachments/');
                 	if($upPic->processed) {
                 		$attachedFiles[] = $upPic->file_dst_pathname;
                    	$upPic->clean();
                 	}

              	}
           }

        }
    //============================================================================

    $Error = "";

  // -------------------------------------- FIRMS ------------------------------------------------

   $xml = simplexml_load_file("http://gozbite.com/firms.xml");


	$numMailsSuccessFirms = 0;
	$counter = 0;
	foreach($xml->firms as $firm)
	{
		$counter++;
		if($counter > 1 ) continue;

			$emailTo = $firm->email;
			$emailMy = 'fismailov@mailjet.com';


			error_reporting(E_ALL);
			//error_reporting(E_STRICT);

			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());

			include_once('classes/phpmailer/class.phpmailer.php');

			$mail             	= new PHPMailer();
			$mail->CharSet      = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			$mail->Priority = 3;
			$mail->WordWrap = 100;



			$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
					<html>
					<head>
					<title></title>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<link rel="stylesheet" type="text/css" href="http://gozbite.com/css/NiftyLayout.css" media="screen">

					</head>
					<body style="float:left;width:100%; background-color: #F1F1F1;"><div>';

			$body .= "<a href='http://gozbite.com' style='border: none; text-decoration: none;'><img style='border: none; text-decoration: none;' src='http://gozbite.com/images/logce.png'></a><br /><br />";


	  		$body .= '<br /><br /><div style="background-color: #FFFFFF;">Не четете този e-mail? <a href="http://gozbite.com/adv.php">Вижте го онлайн.</a></div>';
			$body .= '<br /><br /><div style="color: #0099FF; font-weight:bold; font-size:18px;">Здравейте, '.$firm->name.'</div><hr style="float:left; width:100%; border: 1px dotted #0099FF;">';



	  		$body .= '<br /><br /><div style="margin-bottom:10px; width:300px; float:left; color:#FF6600; font-weight:bold;" align="center"><u>Актуално Предложение</u></div><div style="margin-bottom:10px; width:300px; float:left; color:#FF6600; font-weight:bold;" align="center"><u>Полезно</u></div>
					<br style="clear:left;" />
					<div style="width:600px; background-color:#F1F1F1; text-align:left;">
					<table><tr><td style=" float:left; vertical-align: top;" width="300">';


			$body .= nl2br($_REQUEST['mailBody']);

			$body = str_replace('__FIRM__', $firm->name, $body);
	       	$body = eregi_replace("[\]",'',$body);



			$body .= "</td>";
			$body .= '<td style="vertical-align: top; width:300px; padding:5px; border-left:1px dashed #FF6600;"><div id="get_register"  style="margin-left:5px; margin-bottom:10px; background-color:#0099FF; padding:5px;"><h3 style="color:#FF6600; font-weight:bold;">За Вашия бизнес!</h3><hr style="border:1px dashed #FFFFFF;"><p style="color:#FFF;"> &rarr; <a href="http://gozbite.com/добави-нова-фирма,сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">Регистрирайте</a> се безплатно в портала <a href="http://gozbite.com">GoZbiTe.Com</a> за да получите уникални безплатни възможности за представяне, както и свободно публикуване на рецепти за вкусни ястия и напитки, статии, описания на продукти и коментари. <br /><br /> &rarr; Влезте в нашият <a href="http://gozbite.com/разгледай-форум,интересни_кулинарни_теми_потърси_съвет_или_помогни.html">обновен форум</a>, където вече имате много повече възможности за споделяне и получаване на информация.</p> <hr style="border:1px dashed #FFFFFF;"> <h3 style="color:#FF6600; font-weight:bold;">Възползвайте се!</h3></div></td>';
			$body .= '</tr></table>';
			$body .= '</div>';

			$body .= '<br /><br /><div style="background-color: #FFFFFF;">Не желаете да получавате вече непоискани писма? <a href="http://gozbite.com/unsubscribe_bulletin.php?unsubscribe='.$emailTo.'"> Откажете се сега.</a></div>';
			$body .= '<hr style="float:left; width:100%; border: 1px dotted #0099FF;"><div style="color: #0099FF; font-weight:bold; font-size:12px;">Екипът на <a href="http://gozbite.com">GoZbiTe.Com</a>  Ви желае успешен ден! </div>';


			$body .= '</div></body>';



			$mail->From       = "fismailov@mailjet.com";
			$mail->FromName   = "Info.GoZbiTe.Com";
			//$mail->AddReplyTo("office@gozbite.com"); // tova moje da go zadadem razli4no ot $mail->From


			$mail->Subject    = $_REQUEST['mailTitle'];
			$mail->AltBody    = "За да видите това писмо, моля използвайте e-mail клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);

			$mail->ClearAddresses();
			$mail->AddAddress($emailTo);
		//	$mail->AddAddress($emailMy);

			$mail->ClearAttachments();
			if(is_array($attachedFiles))
			foreach ($attachedFiles as $fileToAttach )
			{
				if(is_file($fileToAttach))
	   			{
	   				$mail->AddAttachment($fileToAttach);
	   			}
		   		else $Error = $fileToAttach. 'не беше прикачен!';              // attachment
			}

			if(!$mail->Send()) {
			  $Error .= "<br />Грешка при изпращане: " . $mail->ErrorInfo;
			} else
			{
			  $Error .= "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно до $emailTo</span><br />";
			  $numMailsSuccessFirms++;




			}

	}

	$Error .= "\n <font color='red'><br /><br />Бяха изпратени са ".$numMailsSuccessFirms." писма от общо ".count($xml->firms)." писма</font><p>";
	// ----------------------------------------------- END FIRMS ----------------------------------------------------




}


?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.:GoZbiTe.Com:.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />


<script type = "text/javascript" src = "js/load_pic_ajax_js.js"></script>
<script type = "text/javascript" src = "js/quarters_ajax_js.js"></script>
<script type = "text/javascript" src = "js/vilages_ajax_js.js"></script>
<script type="text/javascript" src="js/functions.js"></script>

<script src="js/scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous/src/scriptaculous.js" type="text/javascript"></script>

<script type = "text/javascript" src = "js/calendar.js"></script>
<script type = "text/javascript" src = "js/calendar_conf.js"></script>
<script type = "text/javascript">
     addCalendar("CalFDate", "Изберете дата", "fromDate", "itemform");
     addCalendar("CalTDate", "Изберете дата", "toDate", "itemform");
</script>


   <link rel="stylesheet" type="text/css" href="js/niftyCornersN.css">
   <link rel="stylesheet" type="text/css" href="js/niftyPrint.css" media="print">
   <script type="text/javascript" src="js/nifty.js"></script>


<script type="text/javascript" src="js/ajaxtabs/ajaxtabs.js"></script>
<link rel="stylesheet" type="text/css" href="js/ajaxtabs/ajaxtabs.css" />

<script type="text/javascript" src="js/javascripts/window.js"> </script>
<script type="text/javascript" src="js/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="js/javascripts/tooltip.js"> </script>
<link href="themes/default.css" rel="stylesheet" type="text/css" ></link>
<link href="themes/spread.css" rel="stylesheet" type="text/css" ></link>
<link href="themes/alphacube.css" rel="stylesheet" type="text/css" ></link>

<link href="css/style_green.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 1px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

 <script language = "JavaScript">
      function checkForCorrectData() {
         if(document.searchform.catName.value.length == 0) {
            alert('Моля, въведете наименование на категория!');
            document.searchform.catName.focus();
            return false;
         }

         if(document.searchform.catName.value.length > 64) {
            alert('Наименованието на категория не може да бъде по-дълго от 64 символа. Моля, коригирайте!');
            document.searchform.catName.focus();
            return false;
         }

         document.searchform.confirmOK.value = 1;
      }
   </script>


</head>
<body>

<form name = "searchform" method = "POST" action = ""  enctype="multipart/form-data" >
<input type='hidden' name='MAX_FILE_SIZE' value='4000000'>


<script type="text/javascript">
window.onload=function(){
if(!NiftyCheck())
    return;
Rounded("div#left-2DIV","tr","#E0E0E0","#FFB12B");
Rounded("div#MAIN","all","#FFF","#F5F5F5");
Rounded("div#whiteDIV","top","#FFF","#F5F5F5");
Rounded("div#Main_Top_Bottom","bottom","#FFF","#F5F5F5");
Rounded("div#BANER_KVADRAT_AND_NEWS","all","#FFF","#F9FFF9");
Rounded("div.paging","all","#FFF","#B9F4A8");
Rounded("div.newsDIVContainer","all","#FFF","#B9F4A8");
Rounded("div.newsButton","tr bl","#FFF","#E2E2E2","big");
Rounded("div.last_posts","tr bl","#FFF","#E7E7E7","big");

}
</script>

<script type="text/javascript">
new Ajax.PeriodicalUpdater('user_info_test_div', 'test_Proto_Ajax.php', {
  method: 'get', frequency: 3, decay: 2
});
</script>




<script type="text/javascript">
<!--
function jumpBlank(selObj) {
  eval("document.searchform.action='?"+selObj.options[selObj.selectedIndex].value+"'");
  selObj.selectedIndex=0;
}
// -->
</script>




<div id="CONTAINER" style="margin:0px;width:auto; ">

  <div id="LEFT-1" style="float:left; width:160px;margin:0px;">
	  <?php include("index_inc/left-1.php");  ?>
  </div>



  <div id="LEFT-2" style="float:left; width:150px;margin:0px;">
  	  <?php include("index_inc/left-2.php");  ?>
  </div>


  <div id="CENTER" style="margin-left:0px;">
 	 <div id="HEADER" style="height:175px; background-image:url(images/header_bgr_green.gif);background-position:top; background-repeat:repeat-x;">
         <div id="BANER_Goren" style="float:left;padding-top:44px;height:90px;margin-left:30px;">
            <?php include_once("inc/header.inc.php"); ?>
         </div>
     </div>
     <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:10px;background-color:#F9FFF9;">
       <?php  include("index_inc/baner-kvadrat.inc.php");  ?>
     </div>
     <div id="MAIN" style="float:left; width:480px; margin:20px; margin-right:10px; background-color:#F5F5F5;" align="left">

		  <?php
	   if(isset($Error))
	      printf("<div class = \"error\" style = \"padding: 3px 3px 3px 3px; width: 100%%; border: solid 1px #ca0000; background-color: #ffffff;\">%s</div>", $Error);
		?>
	    <fieldset style="margin:10px;">
   <?php
      print "<legend>&nbsp;СПАМ | изпращане на мейли към фирми от XML файл &nbsp;</legend>\n";
   ?>




      <div style = "margin: 10px 10px 10px 10px;">
      <label for = "mailTitle">Зглавие на писмото</label><br>
      <?php
         printf("<input type = \"text\" id = \"mailTitle\" name = \"mailTitle\" value = \"%s\" size = \"60\"><br><br>\n", $_REQUEST['mailTitle']);
      ?>
      </div>


       <div style=" margin:10px;margin-left:0px;">
				&nbsp;&nbsp;Текст на писмото:
				  <?php
				 include_once("../FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('mailBody') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '400';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = $_REQUEST['mailBody'];
		         $oFCKeditor->Create();
			?>
	  </div>


      <div style = "margin: 10px 10px 10px 10px;">
		 <fieldset style="width:400px">
	        <legend>&nbsp;Прикачи файл&nbsp;</legend>
			<input type = "file" name = "attachment[]" style="margin:10px;float:left;width:200px;">
      		<input type = "file" name = "attachment[]" style="margin:10px;float:left;width:200px;">
      		<input type = "file" name = "attachment[]" style="margin:10px;float:left;width:200px;">
      		<input type = "file" name = "attachment[]" style="margin:10px;float:left;width:200px;">
      		<input type = "file" name = "attachment[]" style="margin:10px;float:left;width:200px;">
	  	</fieldset>
	  </div>


      <div style = "margin: 10px 10px 10px 10px;">
      <?php
         print "<input type = \"submit\" name = \"sendMails\" value = \"Изпрати писмата\" class = \"buttonInv\">";
      ?>
      </div>
   </fieldset>

     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("index_inc/right.php");  ?>
     </div>
  </div>

</div> <!-- END CONTAINER DIV -->

</form>

<div id="FOOTER" style=" float:left;width:auto; margin-top:20px;">
	 <?php include("inc/footer.inc.php");  ?>
</div>

<script>
  //TooltipManager.addHTML("COLLAPSE_BTN", "collapse_help");
   TooltipManager.addURL("question", "help/collapse_help.html", 200, 300);
</script>
</body>
</html>
<?php
   $conn->closedbconnection();
?>