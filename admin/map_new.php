<?php
include_once("inc/dblogin.inc.php");


$pageName = 'register_user';

$sql="SELECT * FROM news ORDER BY date DESC LIMIT 3";
$conn->setsql($sql);
$conn->getTableRows();
$resultNews=$conn->result;
$numNews=$conn->numberrows;


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
         theForm = document.registrationform;
         
          if(theForm.verificationcode.value.length == 0)  {
            alert('Моля, въведете коректен код за сигурност!');
            theForm.verificationcode.value = "";
            theForm.verificationcode.focus();
            return false;
         }
         

         if(theForm.username.value.length == 0) {
            alert('Моля, въведете потребителско име!');
            theForm.username.value = "";
            theForm.username.focus();
            return false;
         }
         if(theForm.username.value.length < 5) {
            alert('Моля, въведете потребителско име по-голямо от 5 символа!');
            theForm.username.value = "";
            theForm.username.focus();
            return false;
         }
          if(theForm.password.value.length < 5) {
            alert('Моля, въведете парола (по-голяма от 4 символа)!');
            theForm.password.value = "";
            theForm.password.focus();
            return false;
         }
          if(theForm.password.value != theForm.password2.value) {
            alert('Двете пароли не съвпадат!');
            theForm.password2.value = "";
            theForm.password2.focus();
            return false;
         }
         
          if(theForm.phone.value.length == 0) {
            alert('Моля, въведете телефон за връзка!');
            theForm.phone.value = "";
            theForm.phone.focus();
            return false;
         }
         
        
         if(theForm.email.value.length == 0)  {
            alert('Моля, въведете Е-мейл за връзка!');
            theForm.email.value = "";
            theForm.email.focus();
            return false;
         }
         
         
         
         if(theForm.address.value.length == 0)  {
            alert('Моля, посочете адреса (град, община, квартал, улица, номер, блок) на Вашата фирма!');
            theForm.address.value = "";
            theForm.address.focus();
            return false;
         }
         
         
        
      }

     
   </script>
</head>
<body  <?php if (isset($_GET['edit'])) print "onload=\"javascript: expandtab('maintab', 1)\"";
elseif (isset($_GET['insert'])) print "onload=\"javascript: expandtab('maintab', 2)\"";
elseif (isset($_GET['delete'])) print "onload=\"javascript: expandtab('maintab', 3)\"";
else  print "onload=\"javascript: expandtab('maintab', 0)\""; ?>>

<form  id='registrationform' name='registrationform' method='post' action='' enctype='multipart/form-data' ">
		
<script type="text/javascript">
window.onload=function(){
if(!NiftyCheck()) 
    return;
Rounded("div#left-2DIV","tr","#E0E0E0","#FFB12B");
//Rounded("div#orange_dqsno","tl","#FFF","#FFB12B");
Rounded("div#whiteDIV","top","#FFF","#F5F5F5");
Rounded("div#Main_Top_Bottom","bottom","#FFF","#F5F5F5");
//Rounded("div#BANER_KVADRAT_AND_NEWS","all","#FFF","#F9FBFF");

}
</script>

<script type="text/javascript">		
new Ajax.PeriodicalUpdater('user_info_test_div', 'test_Proto_Ajax.php', {
  method: 'get', frequency: 3, decay: 2
});
</script>




<div id="CONTAINER" style="margin:0px;width:auto; ">
	
  <div id="LEFT-1" style="float:left; width:160px;margin:0px;">
	  <?php include("login_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("login_inc/left-2.php");  ?>  
  </div>
  
   <div id="HEADER" style="height:320px; background-image:url(images/header_bgr_blue.png);background-position:top; background-repeat:repeat-x;">          
         <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
          <div id="map" style="width: 500px; height: 300px"></div>
         <?php  include("map.php");  ?>  
     </div>  
   </div>
     
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	
     <div id="MAIN" style="float:left; width:500px; margin-top:0px;">
        <?php include("login_inc/main.php");  ?>  
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("login_inc/right.php");  ?>  
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