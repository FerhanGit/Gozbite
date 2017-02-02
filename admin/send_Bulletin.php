<?php
$pageName = 'send_bulletin';


	include_once("../includes/header.inc.php");
	require_once("../includes/classes/phpmailer/class.phpmailer.php");
	require_once("../includes/classes/Upload.class.php");
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


  		// ========================= Update is_send to 1 if mail send successfully =================================
		  	$sql="UPDATE bulletins SET is_send = 0 WHERE is_send = 1";
			$conn->setsql($sql);
			$conn->updateDB();
		// =========================================================================================================





   		$sql="SELECT mail_toSend FROM bulletins WHERE is_send = 0";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numMailsToSend = $conn->numberrows;
		$resMailsToSend = $conn->result;



	$numMailsSuccessFirms = 0;
	$counter = 0;
	for($z=0; $z < $numMailsToSend; $z++)
	{
		$counter++;
		if($counter > 1 && $_GET['test']  == 1) continue;

			$emailTo = $resMailsToSend[$z]['mail_toSend'];
			$emailMy = 'fismailov@mailjet.com';


			error_reporting(E_ALL);
			//error_reporting(E_STRICT);

			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());

			include_once('../includes/classes/phpmailer/class.phpmailer.php');

			$mail             	= new PHPMailer();
			$mail->CharSet      	= "UTF-8";
			//$mail->CharSet      = "windows-1251";
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

			$body .= '<div style="background-color: #FFFFFF;">Не четете този e-mail? <a href="http://gozbite.com">Вижте го онлайн.</a></div><hr style="float:left; width:100%; border: 1px dotted #0099FF;">';
			$body .= '<div style="color: #0099FF; font-weight:bold; font-size:18px;">Здравейте, </div>Вие получавате тази информация, защото сте се абонирали за периодичния инфирмационен бюлетин на GoZbiTe.Com<hr style="float:left; width:100%; border: 1px dotted #0099FF;">';


			$body .= '<br /><br />';
			$body .= nl2br(mb_convert_encoding($_REQUEST['mailBody'], 'UTF-8'));


	  		$body .= '<br /><br />
                <div style="margin-bottom:10px; width:400px; float:left; color:#FF6600; font-weight:bold; background-color:#0099FF; padding:5px;" align="center"><u><a style="color:#FF6600; text-align:center; font-weight:bold;" href="http://www.gozbite.com/разгледай-рецепти,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Последни Рецепти</a></u></div>
                <div style="margin-bottom:10px; width:400px; float:left; color:#FF6600; font-weight:bold; background-color:#0099FF; padding:5px;" align="center"><u><a style="color:#FF6600; text-align:center; font-weight:bold;" href="http://www.gozbite.com/прочети-статии,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Актуални Статии</a></u></div>
                <div style="margin-bottom:10px; width:200px; float:left; color:#FF6600; font-weight:bold; background-color:#0099FF; padding:5px; text-align:center; font-weight:bold;" align="center"><u>Полезно</u></div>
					<br style="clear:left;" />
					<div style="width:1000px; background-color:#F1F1F1; text-align:center;">
					<table><tr>';


    // Последни Рецепти
    $body .= '<td style=" float:left; vertical-align: top; border-left:1px dashed #FF6600;" width="400">';

	$sql="SELECT r.id as 'id', r.title as 'title', r.has_pic as 'has_pic', r.registered_on as 'registered_on' FROM recipes r WHERE r.active = '1' AND (NOW() BETWEEN r.registered_on AND (r.registered_on + INTERVAL 48 MONTH )) ORDER BY registered_on DESC LIMIT 10 ";
    $conn->setsql($sql);
	$conn->getTableRows();
	$Itm  = $conn->result;
	$numItms = $conn->numberrows;

	for($i=0; $i<$numItms; $i++)
	{
        //------------- Categories ----------------------------------------------------

        $sql="SELECT rc.id as 'recipe_category_id', rc.name as 'recipe_category_name' FROM recipes r, recipe_category rc, recipes_category_list rcl WHERE rcl.recipe_id = r.id AND rcl.category_id = rc.id AND r.id = '".$Itm[$i]['id']."' ";
        $conn->setsql($sql);
        $conn->getTableRows();
        $Itm[$i]['numCats'] = $conn->numberrows;
        $resultRecipesCat[$i] = $conn->result;

        for($n = 0; $n < $Itm[$i]['numCats']; $n++) {
            $Itm[$i]['Cats'][$n] = $resultRecipesCat[$i][$n];
        }


        $randRecipeCat = rand(0, (count($Itm[$i]['Cats']) - 1));


        if ($Itm[$i]['has_pic']=='1')
        {
            $sql="SELECT * FROM recipe_pics WHERE recipeID='".$Itm[$i]['id']."'";
            $conn->setsql($sql);
            $conn->getTableRows();
            $resultPicsLast[$i] = $conn->result;
            $numPicsLast[$i] = $conn->numberrows;
        }

        if($numPicsLast[$i]>0 && is_file('../pics/recipes/'.$resultPicsLast[$i][0]['url_thumb'])) $picFile = 'http://gozbite.com/pics/recipes/'.$resultPicsLast[$i][0]['url_thumb'];
        else $picFile = 'http://gozbite.com/pics/recipes/no_photo_thumb.png';

        $body .= '<table><tr>';
        $body .= '<td><div style=" border:double; border-color:#333333; height:50px; width:50px;" ><a style="color:#467B99;" href="http://gozbite.com/разгледай-рецепта-'.$Itm[$i]['id'].','.myTruncateToCyrilic($Itm[$i]['title'],200,'_','') .'.html"><img width="50" height="50" src="'.$picFile.'" /></a></div></td>';
        $body .= '<td><div style=" margin-left:10px; color:#467B99; " ><a style="color:#467B99;" href="http://gozbite.com/разгледай-рецепта-'.$Itm[$i]['id'].','.myTruncateToCyrilic($Itm[$i]['title'],200,'_','') .'.html">'.myTruncate($Itm[$i]['title'], 1000, " ").'</a></div><br />';
        $body .= '<div style="margin-left:10px; color:#467B99; " ><i><a style="color:#467B99;" href="http://gozbite.com/рецепти-категория-'.$Itm[$i]['Cats'][$randRecipeCat]['recipe_category_id'] .','.myTruncateToCyrilic($Itm[$i]['Cats'][$randRecipeCat]['recipe_category_name'],100,'_','') .'.html">'.$Itm[$i]['Cats'][$randRecipeCat]['recipe_category_name'] .'</a></i></div>';
        $body .= '</td></tr></table>';
        $body .= '<hr style="border:1px dotted #FFFFFF;">';

	}

    $body .= '<a href="http://www.gozbite.com/разгледай-рецепти,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html"><div style="background-color:#0099FF; padding:5px; margin-bottom:10px; width:400px; float:left; text-align:center; color:#FF6600; font-weight:bold;" align="center"><u> &rarr; Още Рецепти</u></div></a>';

    $body .= "</td>";

    // Актуални Статии
    $body .= '<td style=" float:left; vertical-align: top; border-left:1px dashed #FF6600;" width="400">';


	$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.id as 'category_id', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category = pc.id  AND p.active = '1' AND p.post_category <> '59' ORDER BY p.date DESC LIMIT 10 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$Itm  = $conn->result;
	$numItms = $conn->numberrows;

	for($i=0;$i<$numItms;$i++)
	{
	   if(is_file('../pics/posts/'.$Itm[$i]['picURL'])) $picFile= 'http://gozbite.com/pics/posts/'.$Itm[$i]['picURL'];
	   else $picFile = 'http://gozbite.com/pics/posts/no_photo_thumb.png';



	   $body .= '<table><tr>';
	   $body .= '<td><div style=" border:double; border-color:#333333; height:50px; width:50px;" ><a style="color:#467B99;" href="http://gozbite.com/прочети-статия-'.$Itm[$i]['postID'].','.myTruncateToCyrilic($Itm[$i]['title'],100,'_','') .'.html"><img width="50" height="50" src="'.$picFile.'" /></a></div></td>';
	   $body .= '<td><div style=" margin-left:10px; color:#467B99; " ><a style="color:#467B99;" href="http://gozbite.com/прочети-статия-'.$Itm[$i]['postID'].','.myTruncateToCyrilic($Itm[$i]['title'],100,'_','') .'.html">'.myTruncate($Itm[$i]['title'], 1000, " ").'</a></div><br />';
	   $body .= '<div style="margin-left:10px; color:#467B99; " ><i><a style="color:#467B99;" href="http://gozbite.com/статии-категория-'.$Itm[$i]['category_id'].','.myTruncateToCyrilic($Itm[$i]['category'],100,'_','') .'.html">'.$Itm[$i]['category'].'</a></i></div>';
	   $body .= '</td></tr></table>';
	   $body .= '<hr style="border:1px dotted #FFFFFF;">';

	}

    $body .= '<a href="http://www.gozbite.com/прочети-статии,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html"><div style="background-color:#0099FF; padding:5px; margin-bottom:10px; width:400px; float:left; text-align:center; color:#FF6600; font-weight:bold;" align="center"><u> &rarr; Още Статии</u></div></a>';

	$body .= "</td>";

	$body .= '<td style="vertical-align: top; width:200px; padding:5px; border-left:1px dashed #FF6600;"><div id="get_register"  style="margin-left:5px; margin-bottom:10px; background-color:#0099FF; padding:5px;"><h3 style="color:#FF6600; font-weight:bold;">Регистрирайте се!</h3><hr style="border:1px dashed #FFFFFF;"><p style="color:#FFF;"> &rarr; <a href="http://gozbite.com/регистрация,регистрация_в_системата_на_gozbite_com.html">Регистрирайте</a> се безплатно в портала <a href="http://gozbite.com">GoZbiTe.Com</a> и свободно публикувайте рецепти за гозби и напитки, статии, описания в справочника и коментирайте всичко което другите са публикували в портала. <br /><br /> &rarr; Влезте в нашият <a href="http://gozbite.com/разгледай-форум,интересни_кулинарни_теми_потърси_съвет_или_помогни.html">обновен форум</a>, където вече имате много повече възможности за споделяне и получаване на информация.</p> <hr style="border:1px dashed #FFFFFF;"> <h3 style="color:#FF6600; font-weight:bold;">Възползвайте се!</h3></div></td>';
	$body .= '</tr></table>';
	$body .= '</div>';

	$body .= '<hr style="float:left; width:100%; border: 1px dotted #0099FF;"><div style="color: #0099FF; font-weight:bold; font-size:12px;">Екипът на <a href="http://gozbite.com">GoZbiTe.Com</a> Ви желае успешен ден!</div>';


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


			// ========================= Update is_send to 1 if mail send successfully =================================
			  	$sql="UPDATE bulletins SET is_send = 1, send_date = NOW() WHERE is_send = 0 AND mail_toSend = '".$emailTo."'";
				$conn->setsql($sql);
				$conn->updateDB();
			// =========================================================================================================


			}

	}

	$Error .= "\n <font color='red'><br /><br />Бяха изпратени са ".$numMailsSuccessFirms." писма от общо ".$numMailsToSend." писма</font><p>";
	// ----------------------------------------------- END FIRMS ----------------------------------------------------




}


?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.: GoZbiTe.Com :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /><script type = "text/javascript" src = "js/marka_ajax.js"></script>

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
      print "<legend>&nbsp;Бюлетин | изпращане на Бюлетин със последните 10 Статии &nbsp;</legend>\n";
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