<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.:Фери:.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />
<script type = "text/javascript" src = "../js/marka_ajax.js"></script>

<script type = "text/javascript" src = "../js/load_pic_ajax_js.js"></script>
<script type = "text/javascript" src = "../js/quarters_ajax_js.js"></script>
<script type = "text/javascript" src = "../js/vilages_ajax_js.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>

<script src="../js/scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="../js/scriptaculous/src/scriptaculous.js" type="text/javascript"></script>

<script type = "text/javascript" src = "../js/calendar.js"></script>
<script type = "text/javascript" src = "../js/calendar_conf.js"></script>
<script type = "text/javascript">
     addCalendar("CalFDate", "Изберете дата", "fromDate", "itemform");
     addCalendar("CalTDate", "Изберете дата", "toDate", "itemform");
</script>


   <link rel="stylesheet" type="text/css" href="../js/niftyCornersN.css">
   <link rel="stylesheet" type="text/css" href="../js/niftyPrint.css" media="print">
   <script type="text/javascript" src="../js/nifty.js"></script>
   
   
<script type="text/javascript" src="../js/ajaxtabs/ajaxtabs.js"></script>
<link rel="stylesheet" type="text/css" href="../js/ajaxtabs/ajaxtabs.css" />

<script type="text/javascript" src="../js/javascripts/window.js"> </script>
<script type="text/javascript" src="../js/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="../js/javascripts/tooltip.js"> </script>
<link href="../themes/default.css" rel="stylesheet" type="text/css" ></link>	
<link href="../themes/spread.css" rel="stylesheet" type="text/css" ></link>
<link href="../themes/alphacube.css" rel="stylesheet" type="text/css" ></link>

<link href="../css/style_red.css" rel="stylesheet" type="text/css" />
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
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
 
   
<script language="javascript" src="ajax.js"></script>
<link rel="stylesheet" href="css.css" type="text/css">

</head>
<body onLoad="getagents('id','')">



<div id="CONTAINER" style="margin:0px;width:auto; ">
	
  <div id="LEFT-1" style="float:left; width:160px;margin:0px;">
	  <?php include("../lekarstva_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("../lekarstva_inc/left-2.php");  ?>  
  </div>
  
  <div id="HEADER" style="height:320px; background-image:url(../images/header_bgr_red.gif);background-position:top; background-repeat:repeat-x;">          
         <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       <?php  include("../lekarstva_inc/baner-kvadrat.inc.php");  ?>  
     </div>  
   </div>
     
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	
     <div id="MAIN" style="float:left; width:500px; margin-top:0px;">         
		<fieldset style="margin:10px;">
		   <?php
		      print "<legend>&nbsp;Лекарства | Симптоми;</legend>\n";
		          
		   ?>
<div id="hiddenDIV" style="visibility:hidden; background-color:white; border: 0px solid black;">sdff</div>     
   		</fieldset>
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("../lekarstva_inc/right.php");  ?>  
     </div>      
  </div>
  
  
  
  
</div> <!-- END CONTAINER DIV -->
   
</form>

<div id="FOOTER" style=" float:left;width:auto; margin-top:20px;">
	 <?php include("../inc/footer.inc.php");  ?>  
</div>

</body>