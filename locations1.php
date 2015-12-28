<?php
   $file = "locations1.php";
   require("inc/dblogin.inc.php");

   if (isset($_REQUEST['ActionLctn']) && ($_REQUEST['ActionLctn'] == 1) && isset($_REQUEST['lctnID']) && ($_REQUEST['lctnID'] > 0)) {
      require("classes/Location.class.php");

      $Lctn = new Location($conn);
      $Lctn->id = $_REQUEST['lctnID'];
      if (!$Lctn->deleteLctn())
         $Error = errorMsg($Lctn->Error);
   }
?>
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.: иЗЛеТ.Бг - Локации - <?=$resultDoctorBig['first_name']?$resultDoctorBig['first_name'].' '.$resultDoctorBig['last_name'].' - '.$resultDoctorBigCats[0]['doctor_category_name']:get_offer_category($_REQUEST['doctor_category'])?> :.</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="revisit-after" content="1 days" />
<meta name="robots" content="follow,index" />
<meta http-equiv="Description" content="iZLeT.Bg е туристически портал, в който може да откриете пълна информация, свързана с почивки, екскурзии, агенции, хотели и превозвачи в целия свят и България, авторски статии, интервюта и множество развлекателни секции - богат снимков материал, новини, описания на градове и курортни селища и др." />
<meta http-equiv="Keywords" content="туризъм,туристически,море,морски,почивка,екскурзия,пътуване,туристически новини,България,туристи,резервация,круиз,общество,агенция,хотел,хотели,превозвач,светът,инциденти,агенции,автобуси,самолет,интервю,туризъм,наука,технологии,спорт,любопитно,turizam,tourist,trip,travel,destination,beach" />
<meta http-equiv="Refresh" content="900" />
<meta name="abstract" content="Туристически сайт – актуални оферти за почивки, екскурзии, резервации, както и много статии и новини от областта на туризма и голям каталог от туризтически агенции, превозвачи и хотели." />
<meta name="Subject" content="туризъм,екскурзия,екскурзии,почивка,почивки,агенция,агенции,превозвач,превозвачи,хотел,хотели,резервация,резервации,море,планина,отдих,плаж" />
<meta name="classification" content="туризъм,екскурзия,екскурзии,почивка,почивки,агенция,агенции,превозвач,превозвачи,хотел,хотели,резервация,резервации,море,планина,отдих,плаж" />
<meta name="language" content="bulgarian" />
<meta name="author" content="iZLeT.bg" />
<meta name="owner" content="iZLeT.bg - туризъм,екскурзия,екскурзии,почивка,почивки,агенция,агенции,превозвач,превозвачи,хотел,хотели,резервация,резервации,море,планина,отдих,плаж" />
<meta name="copyright" content="Copyright (c) by iZLeT.bg" />
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
<meta name="generator" content="туризъм" />
<meta name="ProgId" content="туризъм" />
<meta name="rating" content="general" />
<meta name="description" content="iZLeT.Bg е туристически портал, в който може да откриете пълна информация, свързана с почивки, екскурзии, агенции, хотели и превозвачи в целия свят и България, авторски статии, интервюта и множество развлекателни секции - богат снимков материал, новини, описания на градове и курортни селища и др." />
<meta name="keywords" content="туризъм,туристически,море,морски,почивка,екскурзия,пътуване,туристически новини,България,туристи,резервация,круиз,общество,агенция,хотел,хотели,превозвач,светът,инциденти,агенции,автобуси,самолет,интервю,туризъм,наука,технологии,спорт,любопитно,turizam,tourist,trip,travel,destination,beach" />



<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAx_W5ztkhhP0ZnBVvqHy4LhQI23lQsU1fbJA4pbevBZnHkhnGdxSqOnB2z6fKmhKMiU1VAIlGNgYyCQ" type="text/javascript"></script>


<script type="text/javascript" src="js/functions.js"></script>

<script src="js/scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous/src/scriptaculous.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="css/lightview.css" />
<script type='text/javascript' src='js/lightview.js'></script>
<script type='text/javascript' src='js/starbox.js'></script>
<link rel="stylesheet" type="text/css" href="css/starbox.css" />

<script type="text/javascript" src="js/phototype.js"></script>

<link rel='stylesheet' type='text/css' href='index_inc/ajax_calendar/calendar_style.css'></link>	
<script type='text/javascript' src="index_inc/ajax_calendar/calendar.js"></script>

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


<script src="js/AC_RunActiveContent.js" language="javascript"></script>
<script src="js/EditMe.multiLayer.js" language="javascript"></script>
<script src="js/MultiLevelDHTMLMenuExpanderV11.js" language="javascript"></script>


 
</head>
<body onLoad = "startList(); ">
<form name = "itemform" method = "post" action = "locations1.php">
<input type = "hidden" name = "ActionLctn" />
<input type = "hidden" name = "lctnID" />

<script type="text/javascript">
window.onload=function(){
//Nifty("div#menu a","small transparent top");
Nifty("ul#intro li","same-height");
Nifty("ul#listingPhones li","transparent same-height");
Nifty("div.listArea","transparent");
Nifty("div.date","transparent");
Nifty("div#content,div#right","same-height");
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
InitializePage();
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
			   if(isset($Error))
			      printf("<div class = \"error\" style = \"padding: 3px 3px 3px 3px; width: 100%%; border: solid 1px #ca0000; background-color: #ffffff;\">%s</div>", $Error);
			?>
			   <fieldset>
			      <legend>&nbsp;Административен модул&nbsp;&nbsp;НОМЕНКЛАТУРА | Л О К А Ц И И&nbsp;</legend>
			      
			     <?php if($_REQUEST['country'] > 0) { ?> <a href = "edit_location.php?parent_id=<?=$_REQUEST['country']?>"><img src = "images/add.png" width = "16" height = "16" alt = "Добавяне на подлокация" />Добавяне на подлокация</a> <?php }?>
			      
			      <div style = "margin: 10px 10px 10px 10px;">
			         <?php
					 	$sql = "select id, name from locations where parent_id = 0 ORDER BY name";
						$conn->setsql($sql);
						echo "<form><select name=\"country\" onchange=\"this.form.submit()\"><option value=0>Изберете държава\n";
						while($conn->fetch()) printf("<option value=%d%s>%s\n",$conn->result[0], ($conn->result[0]==$_REQUEST['country']?" selected":""), $conn->result[1]);
						echo "</select>\n</form>\n";
						if($_REQUEST['country']){
							require_once("classes/LocationsList.class.php");
							$LcList = new LocationsList($conn);
							if($LcList->load())
							{
								$LcList->drawMainLocations($_REQUEST['country']);
							}
						 }
			            /*print "<table cellpadding = \"4\" cellspacing = \"0\" border = \"0\" width = \"400\" class = \"listtable\">\n";
			            if($LcList->load())
			               $LcList->showlist(0);
			            else
			               print "<tr><td class = \"txt red\" align = \"center\">Няма въведени локации<input type = \"hidden\" name = \"nnumrow\" value = \"0\"></td></tr>\n";
			            print "</table>\n";*/
			         ?>
			      </div>
			   </fieldset>
   
	</div>

	<div id="right">
		<?php include("index_inc/right.php"); ?>
	
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

</form>
</body>
</html>	
		  

<?php
   $conn->closedbconnection();
?>