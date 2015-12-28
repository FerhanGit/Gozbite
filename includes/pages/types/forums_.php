<?php
$pageName = 'forum';
include_once("inc/dblogin.inc.php");
$page = $_REQUEST['page']; 
   
//ini_set('display_errors','1');
//error_reporting (E_ALL); 

$time_start = getmicrotime();

	//================================= DELETE ansers =====================================
	
     if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1) && !empty($_REQUEST['deleteQuestion']))
     {
	    //***************	Изтрива главната тема и всички отговори към нея! *****************************//
	     
     	$sql="DELETE FROM questions WHERE questionID = '".$_REQUEST['deleteQuestion']."' OR parentID = '".$_REQUEST['deleteQuestion']."'";
    	$conn->setsql($sql);
    	$conn->updateDB();
    			   
		?>
			<script type="text/javascript">
		       window.location.href='разгледай-форум,инересни_кулинарни_теми_потърси_съвет_или_помогни.html';
			</script> 
		<?php	

     }
	   
     if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1) && !empty($_REQUEST['deleteAnser']))
     {
     	$sql="DELETE FROM questions WHERE questionID='".$_REQUEST['deleteAnser']."' LIMIT 1";
    	$conn->setsql($sql);
    	$conn->updateDB();
    	    			   
		?>
			<script type="text/javascript">
		       window.location.href='разгледай-форум-тема-<?=$_REQUEST['questionID']?>,инересни_кулинарни_теми_потърси_съвет_или_помогни.html';
			</script> 
		<?php	
     }
       	
	//==============================================================================================
	
// ------------------СТАРТ на Вкарване на Коментари -----------------------

//=========================================================
 if (isset($_REQUEST['insert_question_btn']))
 {
     
    if(isset($_REQUEST['verificationcode'])) {
	
	include("verificationimage/verification_image.class.php");
	$image = new verification_image();
	// do this when the form is submitted
	$correct_code=false;
	if($image->validate_code($_REQUEST['verificationcode'])) 
	{		
		$correct_code=true;
		$_SESSION['verification_key']="";

		if((!empty($_REQUEST['question_title'])) && (!empty($_REQUEST['question_body'])))
	    {
	     		 
	       	    
	    	 if (!isset($_SESSION['valid_user'])) 
	        {
	        ?>
	        	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='вход,вход_в_системата_на_кулинарния_портал_GoZbiTe.Com.html';</script> 
	        <?php 
	        exit;
	        }
	    	 
	        
	        $sql="INSERT INTO questions SET parentID	=	'".$_REQUEST['parentID']."',
	        							 	autor	=	'".$_SESSION['userID']."',
	        							 	autor_type	=	'".$_SESSION['user_type']."',
	        							 	question_title	=	'".addslashes($_REQUEST['question_title'])."',
	        							 	question_body	=	'".addslashes($_REQUEST['question_body'])."',
	        							 	category	=	'".addslashes($_REQUEST['question_category'])."',
	        							 	active 	= 	'1',
	        							 	created_on	=	NOW()    									 							
	        	 							";
	    	$conn->setsql($sql);
	    	$last_ID = $conn->insertDB();
	    	
	    		 
	    
	    	$sql="UPDATE ".(($_SESSION['user_type']=='user')?'users':'firms')." SET cnt_comment = (cnt_comment+1) WHERE username='".$_SESSION['valid_user']."'";
	    	$conn->setsql($sql);
	    	$conn->updateDB();
	    	
	    	$_SESSION['cnt_comment']++;
	    	
	  
	  // ==================================== MAIL SEND ============================================
	    	
	   if(isset($_REQUEST['parentID']) AND $_REQUEST['parentID'] > 0) 	
	   {
	   		$sql="SELECT questionID, parentID, autor, autor_type FROM questions  WHERE questionID = '".$_REQUEST['parentID']."' OR parentID = '".$_REQUEST['parentID']."' GROUP BY autor_type, autor";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultQuestionNew = $conn->result;
			$numQuestionNew = $conn->numberrows;
	   }	
	   
	if($numQuestionNew > 0)
	{
		for($n=0; $n<$numQuestionNew; $n++)
		{
		
		//************ Автора за всяка тема ****************
			$sql="SELECT ".(($resultQuestionNew[$n]['autor_type']=='user')?" CONCAT(first_name, ' ', last_name)":'name')." as 'autor_name' FROM ".(($resultQuestionNew[$n]['autor_type']=='user')?'users':'firms')." WHERE ".(($resultQuestionNew[$n]['autor_type']=='user')?'userID':'id')." = '".$resultQuestionNew[$n]['autor']."' LIMIT 1";
			$conn->setsql($sql);
			$conn->getTableRow();
			$resultMneniqAvtor = $conn->result['autor_name'];	
			
			$sql="SELECT email as 'email' FROM ".(($resultQuestionNew[$n]['autor_type']=='user')?'users':'firms')." WHERE ".(($resultQuestionNew[$n]['autor_type']=='user')?'userID':'id')." = '".$resultQuestionNew[$n]['autor']."' LIMIT 1";
			$conn->setsql($sql);
			$conn->getTableRow();
			$resultMneniqEmail = $conn->result['email'];	
		//***********************************************************************
		
			//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('classes/phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			$body ="<div style=\"width:600px; \">";
			$body .= "Уважаеми, <b><font color='#FF6600'>".$resultMneniqAvtor."</font></b>, Има ново съобщение във Вашата тема от форума на GoZbiTe.Com!<br /><br />";
	   		
	   		 $body .= "<div style=\"width:600px; float:left; margin: 0px 0px 50px 0px;\">	
	   		 			За да го прочетете последвайте този линк <a href='http://GoZbiTe.Com/разгледай-форум-тема-".$_REQUEST['parentID'].",инересни_кулинарни_теми_потърси_съвет_или_помогни.html'>Ново съобщение</a>.
	   					</div>";
	   		 
			 $body .= "</div>";
			 
		 
			$body  = eregi_replace("[\]",'',$body);
			
						
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Forum.GoZbiTe.Com" ;
			
			//$mail->AddReplyTo("office@gozbite.com"); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Novo saobshtenie ot Foruma na GoZbiTe.Com";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress($resultMneniqEmail);
			$mail->AddAddress("office@gozbite.com");
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!$mail->Send()) {
			  //$MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo; 
			} else {
			  //$MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в GoZbiTe.Com.</span><br />";
			}
		
		}
		
	}
	// ================================= KRAI na MAIL-a =========================================
	
			
			
	    }
	    else 
	    {
	        ?>
	        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='разгледай-форум-тема-<?=$_REQUEST['questionID']?>,инересни_кулинарни_теми_потърси_съвет_или_помогни.html';</script> 
	        <?php 
	    }
	}
   }
}

// --------------------Край на коментарите --------------------------------	
	

	$and = '';		
	if(empty($_REQUEST['search_question_category'])) $_REQUEST['search_question_category'] = $_REQUEST['category'];		
	
	if ($_REQUEST['fromDate']!="")  $and .= " AND q.created_on > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	if ($_REQUEST['toDate']!="")  $and .= " AND q.created_on < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	if ($_REQUEST['search_question_category']!="")  $and .= " AND q.category='".$_REQUEST['search_question_category']."'";
	if ($_REQUEST['search_question_title']!="")  $and .= " AND q.question_title LIKE '%".$_REQUEST['search_question_title']."%'";
	if ($_REQUEST['search_question_body']!="")  $and .= " AND q.question_body LIKE '%".$_REQUEST['search_question_body']."%'";
	if ($_REQUEST['autorID']!="")  $and .= " AND q.autor LIKE '%".$_REQUEST['autorID']."%'"; 
	if ($_REQUEST['autor_type']!="")  $and .= " AND q.autor_type LIKE '%".$_REQUEST['autor_type']."%'"; 
	 	

	$sql="SELECT q.questionID as 'questionID', q.parentID as 'parentID', q.created_on as 'created_on', q.autor as 'autor', q.autor_type as 'autor_type', q.question_title as 'question_title', q.question_body as 'question_body', q.sender_name as 'sender_name', q.sender_email as 'sender_email', qc.id as 'category_id' , qc.name as 'category'  FROM questions q, question_category qc WHERE q.category=qc.id AND q.parentID = '0' AND q.active = '1' $and ORDER BY q.created_on DESC";
	$conn->setsql($sql);
	$conn->getTableRows();
	$total=$conn->numberrows;
	
			
//----------------- paging ----------------------

	//$pp = "3"; 
	
	$pp = $_REQUEST['limit']!=""?$_REQUEST['limit']:5; 
	
	$numofpages = ceil($total / $pp);

		if ((!isset($_REQUEST['page']) or ($_REQUEST['page']=="")) or (isset($_REQUEST['search_btn']))) 
		{
			$page = 1;
		}
		else
		{
			$page = $_REQUEST['page'];
		}
		$limitvalue = $page * $pp - ($pp);
// -----------------------------------------------      	
	    
	$sql="SELECT q.questionID as 'questionID', q.parentID as 'parentID', q.created_on as 'created_on', q.autor as 'autor', q.autor_type as 'autor_type', q.question_title as 'question_title', q.question_body as 'question_body', qc.id as 'category_id' , qc.name as 'category' FROM questions q, question_category qc WHERE q.category=qc.id AND q.parentID = '0' AND q.active = '1' $and ORDER BY q.created_on DESC LIMIT $limitvalue,$pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultQuestionMain = $conn->result;
	$numQuestionMain = $conn->numberrows;





 $questionID = $_REQUEST['questionID']?$_REQUEST['questionID']:$_REQUEST['edit'];

if (isset($questionID))
{
	
	$sql="SELECT q.questionID as 'questionID', q.parentID as 'parentID', q.created_on as 'created_on', q.autor as 'autor', q.autor_type as 'autor_type', q.question_title as 'question_title', q.question_body as 'question_body', qc.id as 'category_id' , qc.name as 'category'  FROM questions q, question_category qc WHERE q.category=qc.id AND q.active = '1' AND questionID='".$questionID."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultQuestionBig = $conn->result;	
	
	$sql="SELECT question_id, SUM(cnt) as 'cnt' FROM log_question WHERE question_id='".$questionID."' GROUP BY question_id";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultQuestionCnt=$conn->result;	
	
	$sql="SELECT DISTINCT(questionID) as 'questionID', parentID as 'parentID', created_on as 'created_on', autor as 'autor', autor_type as 'autor_type', question_title as 'question_title', question_body as 'question_body' FROM questions WHERE parentID='".$questionID."' AND active = '1' ORDER BY created_on DESC";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultQuestionAnsers=$conn->result;	
	$numQuestionAnsers=$conn->numberrows;	
	
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="bg-BG" lang="bg-BG">

<head>
<title>.: GoZbiTe.Com - Форум - <?=strlen($resultQuestionBig['question_body'])>0 ? myTruncate($resultQuestionBig['question_body'], 200, " ") :'Спедели и помогни'?> :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<meta name="revisit-after" content="1 days" />
<meta name="robots" content="follow,index" />
<meta http-equiv="Description" content="GoZbiTe.Com е кулинарен портал, в който може да откриете вкусни готварски рецепти, екзотични коктейли, алкохолни и безалкохолни шейкове, сиропи, нектари, концентрати, авторски статии, интервюта и множество развлекателни секции - богат снимков материал, новини, описания на храни, витамини и минерали, плодове и зеленчуци, каталог от сладкарници, ресторанти, пицарии, магазини, вносители на хранителни продукти и др." />
<meta http-equiv="Keywords" content="готварска,рецепта,месо,вегетариански,зеленчуци,плодове,десерт,торта,сладки,коктейл,кафе,чай,нектар,сок,шейк,сладкарница,ресторант,механа,таверна,кафене,пицария,магазин,бар,закусвалня,вносител на храни,кръчма" />
<meta http-equiv="Refresh" content="900" />
<meta name="abstract" content="Кулинарен сайт – готварски рецепти, месо, вегетариански, зеленчуци, плодове, десерти, торти, сладки, коктейли, кафе, чай, нектари, сокове, шейкове, сладкарници, ресторанти, механа, таверна, кафене, пицарии, магазини, барове, закусвални, вносители на храни, кръчми." />
<meta name="Subject" content="готварска,рецепта,месо,вегетариански,зеленчуци,плодове,десерт,торта,сладки,коктейл,кафе,чай,нектар,сок,шейк,сладкарница,ресторант,механа,таверна,кафене,пицария,магазин,бар,закусвалня,вносител на храни,кръчма" />
<meta name="classification" content="готварска,рецепта,месо,вегетариански,зеленчуци,плодове,десерт,торта,сладки,коктейл,кафе,чай,нектар,сок,шейк,сладкарница,ресторант,механа,таверна,кафене,пицария,магазин,бар,закусвалня,вносител на храни,кръчма" />
<meta name="language" content="bulgarian" />
<meta name="author" content="GoZbiTe.Com" />
<meta name="owner" content="GoZbiTe.Com - готварска,рецепта,месо,вегетариански,зеленчуци,плодове,десерт,торта,сладки,коктейл,кафе,чай,нектар,сок,шейк,сладкарница,ресторант,механа,таверна,кафене,пицария,магазин,бар,закусвалня,вносител на храни,кръчма" />
<meta name="copyright" content="Copyright (c) by GoZbiTe.Com" />
<meta name="city" content="Sofia" />
<meta name="country" content="Bulgaria" />
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta name="robots" content="all" />
<meta name="robots" content="index, follow" />
<meta name="slurp" content="index,follow" />
<meta name="msnbot" content="index, follow" />
<meta name="msnbot" content="robots-terms" />
<meta name="googlebot" content="index,follow" />
<meta name="googlebot" content="robots-terms" />
<meta name="generator" content="кулинария" />
<meta name="ProgId" content="кулинария" />
<meta name="rating" content="general" />
<meta name="description" content="GoZbiTe.Com е кулинарен портал, в който може да откриете вкусни готварски рецепти, екзотични коктейли, алкохолни и безалкохолни шейкове, сиропи, нектари, концентрати, авторски статии, интервюта и множество развлекателни секции - богат снимков материал, новини, описания на храни, витамини и минерали, плодове и зеленчуци, каталог от сладкарници, ресторанти, пицарии, магазини, вносители на хранителни продукти и др." />
<meta name="keywords" content="готварска,рецепта,месо,вегетариански,зеленчуци,плодове,десерт,торта,сладки,коктейл,кафе,чай,нектар,сок,шейк,сладкарница,ресторант,механа,таверна,кафене,пицария,магазин,бар,закусвалня,вносител на храни,кръчма" />


<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />


<script type="text/javascript" src="js/functions.js"></script>

<script src="js/scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous/src/scriptaculous.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="css/lightview.css" />
<script type='text/javascript' src='js/lightview.js'></script>
<script type='text/javascript' src='js/starbox.js'></script>
<link rel="stylesheet" type="text/css" href="css/starbox.css" />

<script type="text/javascript" src="js/phototype.js"></script>

<link rel='stylesheet' type='text/css' href='question_inc/ajax_calendar/calendar_style.css'></link>	
<script type='text/javascript' src="question_inc/ajax_calendar/calendar.js"></script>

<script type = "text/javascript" src = "flash_flv_player/ufo.js"></script>
       
<script type="text/javascript" src="js/boxover.js"></script>


   
<script type = "text/javascript" src = "js/calendar.js"></script>
<script type = "text/javascript" src = "js/calendar_conf.js"></script>
<script type = "text/javascript">
     addCalendar("CalFDate", "Изберете дата", "fromDate", "searchform");
     addCalendar("CalTDate", "Изберете дата", "toDate", "searchform");
</script>


<link rel="stylesheet" type="text/css" href="css/NiftyLayout.css" media="screen">
<script type="text/javascript" src="js/niftycube.js"></script>

   
<script type="text/javascript" src="js/ajaxtabs/ajaxtabs.js"></script>
<link rel="stylesheet" type="text/css" href="js/ajaxtabs/ajaxtabs.css" />

<script type="text/javascript" src="js/javascripts/window.js"> </script>
<script type="text/javascript" src="js/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="js/javascripts/tooltip.js"> </script>
<link href="themes/default.css" rel="stylesheet" type="text/css" ></link>	
<link href="themes/spread.css" rel="stylesheet" type="text/css" ></link>
<link href="themes/alphacube.css" rel="stylesheet" type="text/css" ></link>



<link rel="stylesheet" type="text/css" href="css/menuStyles.css" media="screen">



<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript">

	function getFastSearch(category, question_body, question_title, fromDate, toDate)
	{
		new Ajax.Updater('fastSearchDiv', 'question_inc/Ajax_Fast_Search.php?category='+category+'&question_title='+question_title+'&question_body='+question_body+'&fromDate='+fromDate+'&toDate='+toDate, {
		  method: 'get',onSuccess: function() {
	                       new Effect.Opacity('fastSearchDiv', {duration: 1.0, from:0.3, to:1.0});
						
	              }
		});										
	}
</script>

<script language = "JavaScript">
      
 	function checkForCorrectComment(category_clause) {
         theForm = document.searchform;
              
        if(category_clause == 'question_category')
        {
             if(theForm.question_category.value == '-1' || theForm.question_category.value == '' )  {
	            alert('Моля, изберете Раздел на Вашия коментар!');
	            theForm.question_category.options[0].selected = true;
	            theForm.question_category.focus();
	            return false;
             }
        }

         
          if(theForm.question_title.value.length == 0) {
            alert('Моля, въведете Заглавие на Вашия коментар!');
            theForm.question_title.value = "";
            theForm.question_title.focus();
            return false;
         }
         
        
         
         if(theForm.question_body.value.length == 0) {
            alert('Моля, въведете Вашия коментар!');
            theForm.question_body.value = "";
            theForm.question_body.focus();
            return false;
         }
         
         if(theForm.verificationcode.value.length == 0)  {
             alert('Моля, въведете коректен код за сигурност!');
             theForm.verificationcode.value = "";
             theForm.verificationcode.focus();
             return false;
          }
               
      }

     
   </script>
  
<script type="text/javascript">
	function redirectSearchAll()
	{
		document.location.href = "search.php?searchAll=" + document.getElementById('searchAll').value;
		
	}
</script>

 

<script type="text/javascript">
<!--
function jumpBlank(selObj) {
  eval("document.searchform.action='?"+selObj.options[selObj.selectedIndex].value+"'");
  selObj.selectedIndex=0;
}
// -->



	function insertUserForBulletin(mail_toSend) {
		 theForm = document.searchform;         

		emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (emailPattern.test(theForm.mail_toSend.value))
		{
			new Ajax.Updater('bulletinDiv', 'inc/Ajax_Check_Insert_User_For_Bulletin.php?mail_toSend=' +mail_toSend , {
			  method: 'get',onSuccess: function() {
		          // $('suggestions').show();
			  }
			});		
		}
		else 
		{			
			alert('Моля, въведете коректен Е-мейл адрес!');
           	theForm.mail_toSend.value = "";
           	theForm.mail_toSend.focus();
			return (false);			
		}
	}
	
	
</script>



<script type="text/javascript">
/***********************************************
* Textarea Maxlength script- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

function ismaxlength(obj){
var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
if (obj.getAttribute && obj.value.length>mlength)
obj.value=obj.value.substring(0,mlength)
}
</script>



</head>
<body>
<div id="adv_bgr_Div">

<form name='searchform' action='' method='post' enctype='multipart/form-data' >

<script type="text/javascript">
window.onload=function(){
//Nifty("div#menu a","small transparent top");
Nifty("ul#intro li","same-height");
Nifty("ul#listingPhones li","transparent same-height");
Nifty("div.listArea","transparent");
Nifty("div.date","transparent");
Nifty("div#content,div#right","same-height");
Nifty("div#footer");
Nifty("div#container","transparent bottom");
Nifty("div.boxLeft","transparent");
Nifty("div.boxRight","transparent");
Nifty("ul.TwoHalf li","transparent");
Nifty("div.post_text","transparent");
Nifty("div.thumbDiv","transparent");
Nifty("div.detailsDivMap","bottom");
Nifty("div.detailsDiv","bottom");
Nifty("ul#thumbs li","same-height");
Nifty("div.paging","transparent");
Nifty("div.rsBoxContent","transparent");

navigate("","");
}
</script>



<div id="header">
	<div id="menu">
		<?php  require_once('inc/header.inc.php');?>
		<?php  require_once('inc/menu_new.inc.php');?>
	</div>
</div>
<div id="container">

	
	<div id="content">
	 	<?php
    		include("question_inc/main.php");
		?>
		
	</div>

	<div id="right">
		<?php include("question_inc/right.php"); ?>
	
	</div>



	<div id="footer">
	<?php 
		$time_end = getmicrotime();
	?>
	<p><?php require_once('inc/footer.inc.php'); ?></p>
	</div>

</div>

<script>
  TooltipManager.addURL("question", "help/collapse_help.html", 200, 300);
</script>

<?php require_once('inc/footer_overlay_div_banner.inc.php');?>



</form>

</div>
</body>
</html>	
