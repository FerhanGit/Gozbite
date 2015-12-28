<?php
$pageName = 'last_logins';
include_once("inc/dblogin.inc.php");


 
		 $sql="SELECT u.userID as 'userID', u.username as 'username', CONCAT(u.first_name,' ', u.last_name) as 'name', u.date_register as 'date_register', u.last_login as 'last_login', l.name as 'location', l.id as 'location_id', lt.name as 'locType' FROM users u, locations l, location_types lt WHERE l.id = u.location_id AND lt.id = l.loc_type_id ORDER BY u.last_login DESC LIMIT 20";
		 $conn->setsql($sql);		
		 $conn->getTableRows();
		 $resultUserLastLogin 	= $conn->result;
		 $numUserLastLogin 		= $conn->numberrows;
		 
		 
		 $sql="SELECT f.id as 'firmID', f.username as 'username', f.name as 'name', f.registered_on as 'registered_on', f.last_login as 'last_login', l.name as 'location', l.id as 'location_id', lt.name as 'locType' FROM firms f, locations l, location_types lt WHERE l.id = f.location_id AND lt.id = l.loc_type_id ORDER BY f.last_login DESC LIMIT 20";
		 $conn->setsql($sql);		
		 $conn->getTableRows();
		 $resultFirmLastLogin 	= $conn->result;
		 $numFirmLastLogin 		= $conn->numberrows;
		 
		  
		 $sql="SELECT h.id as 'hotelID', h.username as 'username', h.name as 'name', h.registered_on as 'registered_on', h.last_login as 'last_login', l.name as 'location', l.id as 'location_id', lt.name as 'locType' FROM hotels h, locations l, location_types lt WHERE l.id = h.location_id AND lt.id = l.loc_type_id ORDER BY h.last_login DESC LIMIT 20";
		 $conn->setsql($sql);		
		 $conn->getTableRows();
		 $resultHotelLastLogin 	= $conn->result;
		 $numHotelLastLogin 	= $conn->numberrows;
		 
		 
		 
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
     addCalendar("CalFDate", "Изберете дата", "fromDate", "searchform");
     addCalendar("CalTDate", "Изберете дата", "toDate", "searchform");
	   
</script>


   <link rel="stylesheet" type="text/css" href="js/niftyCornersC.css">
   <link rel="stylesheet" type="text/css" href="js/niftyPrint.css" media="print">
   <script type="text/javascript" src="js/niftycube.js"></script>
   
   
<script type="text/javascript" src="js/ajaxtabs/ajaxtabs.js"></script>
<link rel="stylesheet" type="text/css" href="js/ajaxtabs/ajaxtabs.css" />

<script type="text/javascript" src="js/javascripts/window.js"> </script>
<script type="text/javascript" src="js/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="js/javascripts/tooltip.js"> </script>
<link href="themes/default.css" rel="stylesheet" type="text/css" ></link>	
<link href="themes/spreah.css" rel="stylesheet" type="text/css" ></link>
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

Nifty("div#left-2DIV","tr transparent");
//Rounded("div#orange_dqsno","tl","#FFF","#FFB12B");
Nifty("div#whiteDIV","top");
Nifty("div#Main_Top_Bottom");
//Rounded("div#BANER_KVADRAT_AND_NEWS","all","#FFF","#F9FFF9");

}
</script>

<script type="text/javascript">		
new Ajax.PeriodicalUpdater('user_info_test_div', 'test_Proto_Ajax.php', {
  method: 'get', frequency: 3, decay: 2
});
</script>




<div id="CONTAINER" style="margin:0px;width:auto; ">
	
  <div id="LEFT-1" style="float:left; width:160px;margin:0px;">
	  <?php include("index_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("index_inc/left-2.php");  ?>  
  </div>
  
  <div id="HEADER" style="height:320px;  background-image:url(images/header_bgr_blue.gif);background-position:top; background-repeat:repeat-x;">          
        <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       <?php  include("index_inc/baner-kvadrat.inc.php");  ?>  
     </div>
  </div>    
     
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	 
     <div id="MAIN" style="float:left; width:660px; margin-top:0px;">
       	<fieldset style="width:660px;float:left;">
      		<legend>&nbsp;Потребители - Последни Логини&nbsp;</legend>
      		<?php      		
      			if ($numUserLastLogin > 0)
			 	{ 			 		
			 ?>	 		 
			 		<table style="border: 1px solid #0099FF; color:#FFFFFF; font-weight:bold;" border="1"><tr bgcolor="#CCCCCC"><td>Потребител</td><td>Юзърнейм</td><td>Населено място</td><td>Регистриран на</td><td>Последно Влизане</td></tr>
			 		<?php for($i = 0; $i < $numUserLastLogin; $i++)
			 		{
			 		?>
			 			<tr  bgcolor="<?=($i%2==0)?'#0099FF':'#FF6600'?>"><td><?=$resultUserLastLogin[$i]['name']?></td><td><?=$resultUserLastLogin[$i]['username']?></td><td><?=$resultUserLastLogin[$i]['locType'].' '.$resultUserLastLogin[$i]['location']?></td><td><?=$resultUserLastLogin[$i]['date_register']?></td><td><?=$resultUserLastLogin[$i]['last_login']?></td></tr>
			 		<?php
			 		}
			 		?>			 		
			 		</table>
			 <?php
			 	}     
			 ?>			 
   		</fieldset>   
   		
   		
   		<fieldset style="width:660px;float:left; margin-top:50px;">
      		<legend>&nbsp;Агенции/Превозвачи - Последни Логини&nbsp;</legend>
      		<?php      		
      			if ($numFirmLastLogin > 0)
			 	{ 			 		
			 ?>	 		 
			 		<table style="border: 1px solid #0099FF; color:#FFFFFF; font-weight:bold;" border="1"><tr bgcolor="#CCCCCC"><td>Агенция/Превозвач</td><td>Юзърнейм</td><td>Населено място</td><td>Регистриран на</td><td>Последно Влизане</td></tr>
			 		<?php for($i = 0; $i < $numFirmLastLogin; $i++)
			 		{
			 		?>
			 			<tr  bgcolor="<?=($i%2==0)?'#0099FF':'#FF6600'?>"><td><a style="color: #FFFFFF; font-weight:bold; font-size:12px;" href="http://izlet.bg/firms.php?firmID=<?=$resultFirmLastLogin[$i]['firmID']?>"><?=$resultFirmLastLogin[$i]['name']?></a></td><td><?=$resultFirmLastLogin[$i]['username']?></td><td><a style="color: #FFFFFF; font-weight:bold; font-size:12px;" href="http://izlet.bg/loc.php?locationID=<?=$resultFirmLastLogin[$i]['location_id']?>"><?=$resultFirmLastLogin[$i]['locType'].' '.$resultFirmLastLogin[$i]['location']?></a></td><td><?=$resultFirmLastLogin[$i]['registered_on']?></td><td><?=$resultFirmLastLogin[$i]['last_login']?></td></tr>
			 		<?php
			 		}
			 		?>			 		
			 		</table>
			 <?php
			 	}     
			 ?>			 
   		</fieldset>   
   		
   		
   		
   		<fieldset style="width:660px;float:left; margin-top:50px;">
      		<legend>&nbsp;Хотели - Последни Логини&nbsp;</legend>
      		<?php      		
      			if ($numHotelLastLogin > 0)
			 	{ 			 		
			 ?>	 		 
			 		<table style="border: 1px solid #0099FF; color:#FFFFFF; font-weight:bold;" border="1"><tr bgcolor="#CCCCCC"><td>Хотел</td><td>Юзърнейм</td><td>Населено място</td><td>Регистриран на</td><td>Последно Влизане</td></tr>
			 		<?php for($i = 0; $i < $numHotelLastLogin; $i++)
			 		{
			 		?>
			 			<tr  bgcolor="<?=($i%2==0)?'#0099FF':'#FF6600'?>"><td><a style="color: #FFFFFF; font-weight:bold; font-size:12px;" href="http://izlet.bg/hotels.php?hotelID=<?=$resultHotelLastLogin[$i]['hotelID']?>"><?=$resultHotelLastLogin[$i]['name']?></a></td><td><?=$resultHotelLastLogin[$i]['username']?></td><td><a style="color: #FFFFFF; font-weight:bold; font-size:12px;" href="http://izlet.bg/loc.php?locationID=<?=$resultHotelLastLogin[$i]['location_id']?>"><?=$resultHotelLastLogin[$i]['locType'].' '.$resultHotelLastLogin[$i]['location']?></a></td><td><?=$resultHotelLastLogin[$i]['registered_on']?></td><td><?=$resultHotelLastLogin[$i]['last_login']?></td></tr>
			 		<?php
			 		}
			 		?>			 		
			 		</table>
			 <?php
			 	}     
			 ?>			 
   		</fieldset>   
   		
   		
   		
   		
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



