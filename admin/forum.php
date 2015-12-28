<?php
$pageName = 'forum';
include_once("inc/dblogin.inc.php");
$page = $_REQUEST['page']; 
   

	
	
// ------------------СТАРТ на Вкарване на Коментари -----------------------
   
//=========================================================
 if (isset($_REQUEST['insert_question_btn']))
 {
     
     if ((!empty($_REQUEST['sender_name'])) && (!empty($_REQUEST['sender_email'])) && (!empty($_REQUEST['question_body'])))
     {
     		 
       	    
        $sql="INSERT INTO questions SET questionID='".$_REQUEST['questionID']."',
        								parentID='".$_REQUEST['parentID']."',
        							 	question_body='".addslashes($_REQUEST['question_body'])."',
        							 	category='".addslashes($_REQUEST['question_category'])."',
        							 	sender_name='".$_REQUEST['sender_name']."',
        							 	sender_email='".$_REQUEST['sender_email']."',
        								created_on=NOW()    									 							
        	 							";
    	$conn->setsql($sql);
    	$last_ID=$conn->insertDB();
    		 
    		 
    
    	
    	
    }
    else 
    {
        ?>
        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='forum.php?questionID=<?=$_REQUEST['questionID']?>';</script> 
        <?php 
    }
}

// --------------------Край на коментарите --------------------------------	
	

	$and = '';		
	if(empty($_REQUEST['search_question_category'])) $_REQUEST['search_question_category'] = $_REQUEST['category'];		
	
	if ($_REQUEST['fromDate']!="")  $and .= " AND q.created_on > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	if ($_REQUEST['toDate']!="")  $and .= " AND q.created_on < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i'),"; 
	if ($_REQUEST['search_question_category']!="")  $and .= " AND q.category='".$_REQUEST['search_question_category']."'";
	if ($_REQUEST['search_question_body']!="")  $and .= " AND q.question_body LIKE '%".$_REQUEST['search_question_body']."%'";
	if ($_REQUEST['search_sender_name']!="")  $and .= " AND q.sender_name LIKE '%".$_REQUEST['search_sender_name']."%'"; 
	 		 	

	$sql="SELECT q.questionID as 'questionID', q.parentID as 'parentID', q.created_on as 'created_on', q.question_body as 'question_body', q.sender_name as 'sender_name', q.sender_email as 'sender_email', qc.name as 'category' FROM questions q, question_category qc WHERE q.category=qc.id AND q.parentID = '0' $and ORDER BY q.created_on DESC";
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
	    
	$sql="SELECT q.questionID as 'questionID', q.parentID as 'parentID', q.created_on as 'created_on', q.question_body as 'question_body', q.sender_name as 'sender_name', q.sender_email as 'sender_email', qc.name as 'category' FROM questions q, question_category qc WHERE q.category=qc.id AND q.parentID = '0' $and ORDER BY q.created_on DESC LIMIT $limitvalue,$pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultQuestionMain=$conn->result;
	$numQuestionMain=$conn->numberrows;



?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.:Фери:.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /><script type = "text/javascript" src = "js/marka_ajax.js"></script>

<script type = "text/javascript" src = "js/load_pic_ajax_js.js"></script>
<script type = "text/javascript" src = "js/quarters_ajax_js.js"></script>
<script type = "text/javascript" src = "js/vilages_ajax_js.js"></script>
<script type="text/javascript" src="js/functions.js"></script>

<script src="js/scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous/src/scriptaculous.js" type="text/javascript"></script>


<link rel="stylesheet" type="text/css" href="css/lightview.css" />
<script type='text/javascript' src='js/lightview.js'></script>
<script type='text/javascript' src='js/starbox.js'></script>
<link rel="stylesheet" type="text/css" href="css/starbox.css" />

<script type = "text/javascript" src = "js/calendar.js"></script>
<script type = "text/javascript" src = "js/calendar_conf.js"></script>
<script type = "text/javascript">
     addCalendar("CalFDate", "Изберете дата", "fromDate", "searchform");
     addCalendar("CalTDate", "Изберете дата", "toDate", "searchform");
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

<link href="css/style.css" rel="stylesheet" type="text/css" />
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
</head>
<body>


<form name='searchform' action='' method='post' enctype='multipart/form-data' >

<script type="text/javascript">
window.onload=function(){
if(!NiftyCheck()) 
    return;
Rounded("div#left-2DIV","tr","#E0E0E0","#FFB12B");
//Rounded("div#orange_dqsno","top","#FFF","#0099FF");
Rounded("div#whiteDIV","top","#FFF","#F5F5F5");
Rounded("div#Main_Top_Bottom","bottom","#FFF","#F5F5F5");
Rounded("div#BANER_KVADRAT_AND_question","all","#FFF","#F9F9F9");

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
	  <?php include("question_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("question_inc/left-2.php");  ?>  
  </div>
  
  <div id="HEADER" style="height:175px; background-image:url(images/header_bgr_blue.gif);background-position:top; background-repeat:repeat-x;">          
         <div id="BANER_Goren" style="float:left;padding-top:44px;height:90px;margin-left:30px;">
            <?php include_once("inc/header.inc.php"); ?>
         </div>    
  </div>
 
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	 
     <div id="BANER_KVADRAT_AND_question"style="float:left; width:650px; margin-left:10px; margin-top:5px;background-color:#F9F9F9;">
       <?php  include("question_inc/baner-kvadrat.inc.php");  ?>  
     </div>
     <div id="MAIN" style="float:left; width:500px; margin-top:0px;">
        <?php include("question_inc/main.php");  ?>  
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("question_inc/right.php");  ?>  
     </div>      
  </div>
  
</div> <!-- END CONTAINER DIV -->


<div id="FOOTER" style=" float:left;width:auto; margin-top:20px;">
	 <?php include("inc/footer.inc.php");  ?>  
</div>

<script> 
  //TooltipManager.addHTML("COLLAPSE_BTN", "collapse_help");
   TooltipManager.addURL("question", "help/collapse_help.html", 200, 300);
</script>
  
</form>
</body>
</html>


<?php
// -------------------- funkcii -----------------------------------------



?>