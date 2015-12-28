<?php
$pageName = 'edit_forum';

include_once("inc/dblogin.inc.php");
$page = $_REQUEST['page']; 
   


if(isset($_REQUEST['qcID']) && !empty($_REQUEST['qcID']))			$qcID = $_REQUEST['qcID'];
if(isset($_REQUEST['catName']) && !empty($_REQUEST['catName']))		$catName = $_REQUEST['catName'];
if(isset($_REQUEST['kind']) && !empty($_REQUEST['kind']))			$kind = $_REQUEST['kind'];
if(isset($_REQUEST['parentID']) && !empty($_REQUEST['parentID']))	$parentID = $_REQUEST['parentID'];
if(isset($_REQUEST['confirmOK']) && !empty($_REQUEST['confirmOK']))	$confirmOK = $_REQUEST['confirmOK'];
if(isset($_REQUEST['add']) && !empty($_REQUEST['add']))				$add = $_REQUEST['add'];
if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))			$save = $_REQUEST['save'];


	//=========================================================

if (!isset($_SESSION['valid_user']) && $_SESSION['user_kind']!=2) 
{
?>
	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../login.php';</script> 
<?php 
exit;
}


   require_once("classes/QuestionCategory.class.php");

   /*== INSERT NEW COMPANY CATEGORY ==*/
   if(isset($add) && ($confirmOK == 1)) {
      $catName = trim(htmlspecialchars($catName));

      if (strlen($catName) == 0)
         $Error = "&#149&nbsp;<b>Потребителска грешка:</b><br>Моля, въведете наименование на категория!<br>";

      if(!isset($Error)) {
         $QuestionCtgr            = new QuestionCategory($conn);
         $QuestionCtgr->name      = $catName;
         $QuestionCtgr->parentID  = (($kind == 1) ? 0 : $parentID);
         if($QuestionCtgr->create())
            $typeID = $QuestionCtgr->id;
         else
            $Error .= errorMsg($QuestionCtgr->Error);
      }
   }

   /*== UPDATE COMPANY CATEGORY ==*/
   if (isset($save) && ($qcID > 0) && ($confirmOK == 1)) {
      $catName = trim(htmlspecialchars($catName));
     
      if (strlen($catName) == 0) {
         $Error = "&#149&nbsp;<b>Потребителска грешка:</b><br>Моля, въведете наименование на фирмената категория!<br>";
      }

      if(!isset($Error)) {
         $QuestionCtgr            = new QuestionCategory($conn);
         $QuestionCtgr->id        = $qcID;
         $QuestionCtgr->name      = $catName;
         $QuestionCtgr->parentID  = (($kind == 1) ? 0 : $parentID);
      
         if (!$QuestionCtgr->update())
            $Error .= errorMsg($QuestionCtgr->Error);
      }
   }

   if (isset($qcID) && $qcID > 0) {
      $actionTitle = "Редактиране";
      $QuestionCtgr     = new QuestionCategory($conn);
      $QuestionCtgr->id = $qcID;
      $QuestionCtgr->load();
   } else {
      $actionTitle = "Добавяне";
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
<body  onload = "startList();" style="color:#467B99;font-size:14px;">

<form name = "searchform" method = "POST" action = "edit_forum_category.php" onsubmit = "return checkForCorrectData();">


<input type = "hidden" name = "ActionQuestionCtgr" value="<?=$_REQUEST['ActionQuestionCtgr']?>">
<input type = "hidden" name = "qcID" value="<?=$qcID?>">

<script type="text/javascript">
window.onload=function(){
if(!NiftyCheck()) 
    return;
Rounded("div#left-2DIV","tr","#E0E0E0","#FFB12B");
Rounded("div#MAIN","all","#FFF","#F5F5F5");
Rounded("div#whiteDIV","top","#FFF","#F5F5F5");
Rounded("div#Main_Top_Bottom","bottom","#FFF","#F5F5F5");
Rounded("div#MAIN","all","#FFF","#F5F5F5");

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
  
  
  <div id="CENTER" style="margin-left:0px;">
 	 <div id="HEADER" style="height:175px; background-image:url(images/header_bgr_blue.gif);background-position:top; background-repeat:repeat-x;">          
         <div id="BANER_Goren" style="float:left;padding-top:44px;height:90px;margin-left:30px;">
            <?php include_once("inc/header.inc.php"); ?>
         </div>    
     </div>
     <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:10px;background-color:#F9FFF9;">
       <?php  include("question_inc/baner-kvadrat.inc.php");  ?>  
     </div>
  <div id="MAIN" style="float:left; width:480px; margin:20px; margin-right:10px; background-color:#F5F5F5;" align="center">
         
		  <?php
	   if(isset($Error))
	      printf("<div class = \"error\" style = \"padding: 3px 3px 3px 3px; width: 100%%; border: solid 1px #ca0000; background-color: #ffffff;\">%s</div>", $Error);
		?>
	    <fieldset style="margin:10px;">
   <?php
      print "<legend>&nbsp;Форум | ".$actionTitle." на категория&nbsp;</legend>\n";
   ?>
      <div style = "margin: 10px 10px 10px 10px;">
      <label for = "typeName">наименование на категорията</label><br>
      <?php
         printf("<input type = \"text\" id = \"catName\" name = \"catName\" value = \"%s\" size = \"40\"><br><br>\n", $QuestionCtgr->name);
      ?>
      </div>
      <div style = "margin: 10px 10px 10px 10px;">
         <input type = "radio" id = "kind1" name = "kind" value = "1"<?php print ((($QuestionCtgr->parentID == 0) || ($qcID == 0)) ? " checked" : ""); ?>><label for = "kind1">главна категория</label>
         <?php
            $sql = "SELECT id, name FROM question_category WHERE parentID = 0 ORDER BY id";
            $conn->setsql($sql);
            $conn->getTableRows();
            if($conn->numberrows > 1 ) {
               printf("&nbsp;&nbsp;&nbsp;<input type = \"radio\" id = \"kind2\" name = \"kind\" value = \"2\"%s><label for = \"kind2\">подкатегория на</label>&nbsp;", (($QuestionCtgr->parentID > 0) ? " checked" : ""));

               print "<select name = \"parentID\">\n";
               for($i = 0; $i < $conn->numberrows; $i++) {
                  printf(     "<option value = \"%d\"%s>%s</option>\n", $conn->result[$i]["id"], (($conn->result[$i]["id"] == $QuestionCtgr->parentID) ? " selected" : ""), $conn->result[$i]["name"]);
               }
               print "</select>\n";
            }
         ?>
      </div>
      <div style = "margin: 10px 10px 10px 10px;">
      <?php
         if ($qcID > 0)
            print "<input type = \"submit\" name = \"save\" value = \"запиши\" class = \"buttonInv\">";
         else
            print "<input type = \"submit\" name = \"add\" value = \"въведи\" class = \"buttonInv\">";
      ?>
      </div>
   </fieldset>
      
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("question_inc/right.php");  ?>  
     </div>      
  </div>
  
</div> <!-- END CONTAINER DIV -->
   
<input type = "hidden" name = "confirmOK">
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