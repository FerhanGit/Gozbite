<?php
$pageName = 'surveys';
include_once("../includes/header.inc.php");
$page = $_REQUEST['page']; 
   
 if(!empty($_REQUEST['fromDate2'])) $start_date="STR_TO_DATE('".$_REQUEST['fromDate2']."','%d.%m.%Y')"; 
 else $start_date="NOW()";
 if(!empty($_REQUEST['toDate2'])) $end_date="STR_TO_DATE('".$_REQUEST['toDate2']."','%d.%m.%Y')"; 
 else $end_date="(".$start_date." + INTERVAL 3 DAY)";


	
// ------------------СТАРТ на Вкарване на Survey -----------------------
   
//=========================================================
 if (isset($_REQUEST['insert_survey_btn']))
 {
     
     if (!empty($_REQUEST['survey_body']))
     {
     		 
       	    
        $sql="INSERT INTO surveys SET 	body='".addslashes($_REQUEST['survey_body'])."',
        							 	start_date=".$start_date.",
        								end_date = ".$end_date." 
        								ON DUPLICATE KEY UPDATE
        								active = '1'								 							
        	 							";
    	$conn->setsql($sql);
    	$last_ID=$conn->insertDB();
    	
		for($n=0;$n<sizeof($_REQUEST['surveys_ansers']);$n++)    	
		{
			if(!empty($_REQUEST['surveys_ansers'][$n]))
			{
		    	$sql="INSERT INTO surveys_ansers SET survey_ID='".$last_ID."',
		        							 	anser='".addslashes($_REQUEST['surveys_ansers'][$n])."',
		        							 	cnt = '0' 
		        								ON DUPLICATE KEY UPDATE
		        								survey_ID = '".$last_ID."'							 							
		        	 							";
		    	$conn->setsql($sql);
		    	$conn->insertDB();
			}
		}	 
    		 
    
    	
    	
    }
    else 
    {
        ?>
        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='surveys.php?surveyID=<?=$_REQUEST['surveyID']?>';</script> 
        <?php 
    }
}

// --------------------Край на Survey --------------------------------	
//=========================================================
 if (isset($_REQUEST['edit_btn']) && isset($_REQUEST['edit']))
 {
     
     if (!empty($_REQUEST['survey_body']))
     {
     		 
       	    
        $sql="UPDATE surveys SET body='".addslashes($_REQUEST['survey_body'])."',
        						 start_date=".$start_date.",
        						 end_date =".$end_date." 
        						 WHERE ID ='".$_REQUEST['edit']."' 									 							
        	 					 ";
    	$conn->setsql($sql);
    	$last_ID=$conn->updateDB();
    		 

    	$sql="DELETE FROM surveys_ansers WHERE survey_ID='".$_REQUEST['edit']."'";
	    $conn->setsql($sql);
	    $conn->updateDB();
	    	
	    	
    	for($n=0;$n<sizeof($_REQUEST['surveys_ansers']);$n++)    	
		{
			if(!empty($_REQUEST['surveys_ansers'][$n]))
			{
		    	$sql="INSERT INTO surveys_ansers SET survey_ID='".$_REQUEST['edit']."',
		        							 	anser='".addslashes($_REQUEST['surveys_ansers'][$n])."',
		        							 	cnt = '0' 
		        								ON DUPLICATE KEY UPDATE
		        								survey_ID = '".$_REQUEST['edit']."',
		        								anser='".addslashes($_REQUEST['surveys_ansers'][$n])."'		        							 					 							
		        	 							";
		    	$conn->setsql($sql);
		    	$conn->insertDB();
			}
	    	
		}	 
    		 	 
    

    	
    }
    else 
    {
        ?>
        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='surveys.php?surveyID=<?=$_REQUEST['surveyID']?>';</script> 
        <?php 
    }
}



if (isset($_REQUEST['delete']))
{
	  if (!empty($_REQUEST['delete']))
     {
     		 
       	    
        $sql="DELETE FROM surveys WHERE ID='".$_REQUEST['delete']."'";
    	$conn->setsql($sql);
    	$conn->updateDB();

    	$sql="DELETE FROM surveys_ansers WHERE survey_ID='".$_REQUEST['delete']."'";
    	$conn->setsql($sql);
    	$conn->updateDB();
    		 
    		 
    }
    else 
    {
        ?>
        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='surveys.php?surveyID=<?=$_REQUEST['surveyID']?>';</script> 
        <?php 
    }
		 
}



//============ DELETE ANSER =======================================



if (isset($_REQUEST['deleteAnser']))
{
	  if (!empty($_REQUEST['deleteAnser']))
     {
     		
    	$sql="DELETE FROM surveys_ansers WHERE ID='".$_REQUEST['deleteAnser']."'";
    	$conn->setsql($sql);
    	$conn->updateDB();
    		 
    	?>
        	<script type="text/javascript">window.location.href='surveys.php?surveyID=<?=$_REQUEST['surveyID']?>';</script> 
        <?php 
    }
   
}


//=================================================================

// --------------------Край на Survey --------------------------------	
	

	$and = '';		
	
	if ($_REQUEST['fromDate']!="")  $and .= " AND s.start_date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y')";
	if ($_REQUEST['toDate']!="")  $and .= " AND s.end_date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y'),"; 
	if ($_REQUEST['search_survey_body']!="")  $and .= " AND s.body LIKE '%".$_REQUEST['search_survey_body']."%'";
	 		 	

	$sql="SELECT s.ID as 'surveyID', s.active as 'active', s.start_date as 'start_date', s.end_date as 'end_date', s.body as 'survey_body' FROM surveys s WHERE 1=1 $and ORDER BY s.start_date DESC";
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
	$sql="SELECT s.ID as 'surveyID', s.active as 'active', s.start_date as 'start_date', s.end_date as 'end_date', s.body as 'survey_body' FROM surveys s WHERE 1=1 $and ORDER BY s.start_date DESC LIMIT $limitvalue,$pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultSurveysMain=$conn->result;
	$numSurveysMain=$conn->numberrows;

for($s=0;$s<$numSurveysMain;$s++)
{
	$sql="SELECT sa.ID as 'anserID', sa.survey_ID as 'survey_ID', sa.anser as 'anser', sa.cnt as 'cnt' FROM surveys_ansers sa WHERE sa.anser<> '' AND sa.survey_ID='".$resultSurveysMain[$s]['surveyID']."' ORDER BY sa.ID";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultAnsersMain[$s]=$conn->result;
	$numAnsersMain[$s]=$conn->numberrows;
}
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
     addCalendar("CalFDate2", "Изберете дата", "fromDate2", "searchform");
     addCalendar("CalTDate2", "Изберете дата", "toDate2", "searchform");
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
Rounded("div#BANER_KVADRAT_AND_surveys","all","#FFF","#F9F9F9");

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



<script type="text/javascript">
function setActive(selObj) {
 new Ajax.Request('surveys_inc/Ajax_set_Active_Survey.php', {
	    parameters: 'Active='+selObj.options[selObj.selectedIndex].value,  
	  //  onSuccess: function(transport) {
		//   	var indicator = $('ActiveSurveyDiv');
		//    if (transport.responseText){   
		///    	window.setTimeout(function() { indicator.update(transport.responseText) }, 10);  	    	  		    	    	
		//    }     
		   // else indicator.update('Вие ще сте пръв с Вашата оценка');	  
		//	}
		}
	  );
	 
}
</script>



<div id="CONTAINER" style="margin:0px;width:auto; ">
	
  <div id="LEFT-1" style="float:left; width:160px;margin:0px;">
	  <?php include("question_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("surveys_inc/left-2.php");  ?>  
  </div>
  
  <div id="HEADER" style="height:175px; background-image:url(images/header_bgr_blue.gif);background-position:top; background-repeat:repeat-x;">          
         <div id="BANER_Goren" style="float:left;padding-top:44px;height:90px;margin-left:30px;">
            <?php include_once("inc/header.inc.php"); ?>
         </div>    
  </div>
 
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	 
     <div id="BANER_KVADRAT_AND_surveys"style="float:left; width:650px; margin-left:10px; margin-top:5px;background-color:#F9F9F9;">
       <?php  include("surveys_inc/baner-kvadrat.inc.php");  ?>  
     </div>
     <div id="MAIN" style="float:left; width:500px; margin-top:0px;">
        <?php include("surveys_inc/main.php");  ?>  
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("surveys_inc/right.php");  ?>  
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