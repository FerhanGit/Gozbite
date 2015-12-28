<?php
include_once("inc/dblogin.inc.php");

	$page = $_REQUEST['page']; 
	$pageName = 'target_links'; 
   
//=========================================================

if (!isset($_SESSION['valid_user'])) 
{
?>
	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../../login.php';</script> 
<?php 
exit;
}

// -------------------------------------------------------

if ($_SESSION['user_kind']<>2)
{
?>
	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../../index.php';</script> 
<?php 
exit;
}

//==========================================================

	 
	
if ((isset($_POST['vavedi'])) && (!empty($_POST['companyID'])) && (!empty($_POST['fromDate'])) && (!empty($_POST['toDate'])))
{ 
	
	
	$sql="INSERT INTO target_links_hospitals SET firm_id='".$_POST['companyID']."',
											 loc_id='".$_POST['cityName']."',
											 action_type='".$_POST['action_type']."',
											 fromD=STR_TO_DATE('".$_POST['fromDate']."','%d.%m.%Y %H.%i'),
											 toD=STR_TO_DATE('".$_POST['toDate']."','%d.%m.%Y %H.%i')
											 
											 ON DUPLICATE KEY UPDATE
											 firm_id='".$_POST['companyID']."',
											 loc_id='".$_POST['cityName']."',
											 action_type='".$_POST['action_type']."',
											 fromD=STR_TO_DATE('".$_POST['fromDate']."','%d.%m.%Y %H.%i'),
											 toD=STR_TO_DATE('".$_POST['toDate']."','%d.%m.%Y %H.%i')
											 "; 

	$conn->setsql($sql);
    $last_ID=$conn->insertDB();
   
    
    if ((isset($_REQUEST['category'])) && ($_REQUEST['category']!=""))
		  {
		  		$category=implode(',',$_POST['category']);
		 		$sql="UPDATE target_links_hospitals SET category='".$category."' WHERE id='".$last_ID."'";
				$conn->setsql($sql);
				$conn->updateDB();
	 		 	
		  }
		  
		  
   
    print "Таргетираната връзка беше добавена успешно.Благодарим Ви!";
    
	$referer=parse_url($_SERVER['HTTP_REFERER']);



  echo "<br /><br /><a href=".$referer['path'].">Върнете се назад</a>"; 
		exit;
}

elseif ((isset($_REQUEST['delete'])) && (!empty($_REQUEST['delete']))) 
{		
	
	$sql="DELETE FROM target_links_hospitals WHERE id='".$_REQUEST['delete']."'"; 
	$conn->setsql($sql);
    $conn->updateDB();
   
    
    print "Таргетираната връзка беше изтрита успешно.Благодарим Ви!";
    
$referer=parse_url($_SERVER['HTTP_REFERER']);

  echo "<br /><a href=".$referer['path'].">Върнете се назад</a>"; 
		exit;
}
// --- Край на INSERT ----------------------
	

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.:Фери:.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<script type = "text/javascript" src = "js/marka_ajax.js"></script>
<script type = "text/javascript" src = "js/load_pic_ajax_js.js"></script>
<script type = "text/javascript" src = "js/quarters_ajax_js.js"></script>
<script type = "text/javascript" src = "js/vilages_ajax_js.js"></script>
<script type="text/javascript" src="js/ajaxtabs/ajaxtabs.js"></script>
<link rel="stylesheet" type="text/css" href="js/ajaxtabs/ajaxtabs.css" />
<script type="text/javascript" src="js/functions.js"></script>
<script type = "text/javascript" src = "js/calendar.js"></script>
<script type = "text/javascript" src = "js/calendar_conf.js"></script>

<script src="js/scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous/src/scriptaculous.js" type="text/javascript"></script>

<script type="text/javascript" src="js/javascripts/effects.js"> </script>
<script type="text/javascript" src="js/javascripts/window.js"> </script>
<script type="text/javascript" src="js/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="js/javascripts/tooltip.js"> </script>

<script type = "text/javascript">
     addCalendar("CalFDate", "Изберете дата", "fromDate", "searchform");
     addCalendar("CalTDate", "Изберете дата", "toDate", "searchform");
</script>


   <link rel="stylesheet" type="text/css" href="js/niftyCornersN.css">
   <link rel="stylesheet" type="text/css" href="js/niftyPrint.css" media="print">
   <script type="text/javascript" src="js/nifty.js"></script>

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
//Rounded("div#orange_dqsno","tl","#FFF","#FFB12B");
//Rounded("div#whiteDIV","top","#FFF","#F5F5F5");
//Rounded("div#Main_Top_Bottom","bottom","#FFF","#F5F5F5");
//Rounded("div#BANER_KVADRAT_AND_NEWS","all","#FFF","#F9FFF9");

}
</script>


<script type="text/javascript">
<!--
function jumpBlank(selObj) {
  eval("document.searchform.action='?"+selObj.options[selObj.selectedIndex].value+"'");
  selObj.selectedIndex=0;
}
// -->
</script>

<div id="CONTAINER" style="margin:0px;">

<div id="LEFT-1" style="float:left; width:160px;margin:0px;">
	  <?php include("target_links_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("target_links_inc/left-2.php");  ?>  
  </div>
  
  <div id="HEADER" style="height:320px; background-image:url(images/header_bgr_blue.gif);background-position:top; background-repeat:repeat-x;">          
        <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       <?php  include("target_links_inc/baner-kvadrat.inc.php");  ?>  
     </div>    
   </div>
     
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	 <div id="MAIN" style="float:left; width:500px; margin-top:0px;">
        <?php  include("target_links_inc/main.php");  ?>  
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("target_links_inc/right.php");  ?>  
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
// -------------------- funkcii -----------------------------------------



?>