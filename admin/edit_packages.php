<?php
$pageName = 'shopping';
include_once("inc/dblogin.inc.php");

$package_id = $_REQUEST['package_id']?$_REQUEST['package_id']:0;

   /*== INSERT NEW COMPANY ==*/
   if(isset($_REQUEST['add'])) {
      $package_name                 = trim(htmlspecialchars($_REQUEST['package_name']));
      $is_VIP            			= trim(htmlspecialchars($_REQUEST['is_VIP']));
      $has_video            		= trim(htmlspecialchars($_REQUEST['has_video']));
      $is_Silver            		= trim(htmlspecialchars($_REQUEST['is_Silver']));
      $is_Gold            			= trim(htmlspecialchars($_REQUEST['is_Gold']));
      $is_Featured            		= trim(htmlspecialchars($_REQUEST['is_Featured']));
      $is_Promo_cnt            		= trim(htmlspecialchars($_REQUEST['is_Promo_cnt']));
      $pr_Stuff            			= trim(htmlspecialchars($_REQUEST['pr_Stuff']));      
	  $months            			= trim(htmlspecialchars($_REQUEST['months']));
      $total_price             		= trim(htmlspecialchars($_REQUEST['total_price']));
      $credit_cost            		= trim(htmlspecialchars($_REQUEST['credit_cost']));
      $concession        			= trim(htmlspecialchars($_REQUEST['concession']));
     

      
      	$sql = "INSERT INTO packages SET name='".$package_name."',
      											is_VIP = '".$is_VIP."',
      											has_video = '".$has_video."',
      											is_Silver = '".$is_Silver."',
      											is_Gold = '".$is_Gold."',
      											is_Featured = '".$is_Featured."',
      											is_Promo_cnt = '".$is_Promo_cnt."',
      											pr_Stuff = '".$pr_Stuff."',
      											months = '".$months."',
      											total_price = '".$total_price."',
      											credit_cost = '".$credit_cost."',
      											concession = '".$concession."'
      											";
      	$conn->setsql($sql);
      	$lastID = $conn->insertDB();
      	
      	?>
      	 <script type = "text/javascript">
      	 document.location="edit_packages.php?package_id=<?=$lastID?>";
      	 </script>
        <?php 
      
   }

   /*== UPDATE COMPANY ==*/
   if (isset($_REQUEST['save']) && ($package_id > 0) ) {
      $package_name                 = trim(htmlspecialchars($_REQUEST['package_name']));
      $is_VIP            			= trim(htmlspecialchars($_REQUEST['is_VIP']));
      $has_video            		= trim(htmlspecialchars($_REQUEST['has_video']));
      $is_Silver            		= trim(htmlspecialchars($_REQUEST['is_Silver']));
      $is_Gold            			= trim(htmlspecialchars($_REQUEST['is_Gold']));
      $is_Featured            		= trim(htmlspecialchars($_REQUEST['is_Featured']));
      $is_Promo_cnt            		= trim(htmlspecialchars($_REQUEST['is_Promo_cnt']));
      $pr_Stuff            			= trim(htmlspecialchars($_REQUEST['pr_Stuff']));      
	  $months            			= trim(htmlspecialchars($_REQUEST['months']));
      $total_price             		= trim(htmlspecialchars($_REQUEST['total_price']));
      $credit_cost            		= trim(htmlspecialchars($_REQUEST['credit_cost']));
      $concession        			= trim(htmlspecialchars($_REQUEST['concession']));
        		
      
        $sql = "UPDATE packages SET name='".$package_name."',
      											is_VIP = '".$is_VIP."',
      											has_video = '".$has_video."',
      											is_Silver = '".$is_Silver."',
      											is_Gold = '".$is_Gold."',
      											is_Featured = '".$is_Featured."',
      											is_Promo_cnt = '".$is_Promo_cnt."',
      											pr_Stuff = '".$pr_Stuff."',
      											months = '".$months."',
      											total_price = '".$total_price."',
      											credit_cost = '".$credit_cost."',
      											concession = '".$concession."'
      											WHERE id='".$package_id."'
      											";
         $conn->setsql($sql);
      	 $conn->updateDB();
      
   }

   /*== END ACTIONS ==*/

   if (isset($package_id) && $package_id > 0) {
      $actionTitle = "Редактиране";
      		
      	 $sql = "SELECT * FROM packages WHERE id='".$package_id."'	";
         $conn->setsql($sql);
      	 $conn->getTableRow();
      	 $resultPackage = $conn->result;
      	 
      	 
  } else {
      $actionTitle   = "Добавяне";
	  
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
<input type = "hidden" name = "package_id" value = "<?php print $package_id; ?>" />

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
	  <?php include("shopping_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("shopping_inc/left-2.php");  ?>  
  </div>
  
  <div id="HEADER" style="height:320px; background-image:url(images/header_bgr_blue.png);background-position:top; background-repeat:repeat-x;">          
         <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       		<?php  include("shopping_inc/baner-kvadrat.inc.php");  ?>  
     	</div>
  </div>    
     
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	 <fieldset style = "width: auto;">
   <?php
      print "<legend>&nbsp;Пакети | ".$actionTitle." на пакет&nbsp;</legend>\n";
   ?>
      <div style = "float: left; margin: 10px 10px 10px 5px; background-color: #efefef;">
         
         
         
         <div style = "margin: 10px 10px 10px 10px;">
            <label for = "package_name">Наименование на кирилица</label><br />
            <?php
               printf("<input type = \"text\" id = \"package_name\" name = \"package_name\" value = \"%s\" size = \"40\" />\n", $resultPackage['name']);
            ?>
         </div>
         
            
         <div style = "margin: 10px 10px 10px 10px;">
            <label for = "months">За период от</label><br />
            <?php
               printf("<input type = \"text\" id = \"months\" name = \"months\" value = \"%s\" size = \"40\" />\n", $resultPackage['months']);
            ?>
         </div>
         
         <div style = "margin: 10px 10px 10px 10px;">
            <label for = "total_price">Общо цена</label><br />
            <?php
               printf("<input type = \"text\" id = \"total_price\" name = \"total_price\" value = \"%s\" size = \"40\" />\n", $resultPackage['total_price']);
            ?>
         </div>
         
         <div style = "margin: 10px 10px 10px 10px;">
            <label for = "concession">Отстъпка</label><br />
            <?php
               printf("<input type = \"text\" id = \"concession\" name = \"concession\" value = \"%s\" size = \"40\" />\n", $resultPackage['concession'] );
            ?>
         </div>
         
         <div style = "margin: 10px 10px 10px 10px;">
            <label for = "credit_cost">Цена в Кредити</label><br />
            <?php
               printf("<input type = \"text\" id = \"credit_cost\" name = \"credit_cost\" value = \"%s\" size = \"40\" />\n", $resultPackage['credit_cost']);
            ?>
         </div>
         
         <div style = "margin: 10px 10px 10px 10px;">
            <label for = "is_VIP">VIP клеинт</label><br />
            <?php
             	  print " <select id = \"is_VIP\" name = \"is_VIP\">\n";
                  
                  printf("<option value = \"0\"%s>%s</option>\n",  (($resultPackage['is_VIP'] == 0) ? " selected" : ""), "обикновен клиент");
                  printf("<option value = \"1\"%s>%s</option>\n",  (($resultPackage['is_VIP'] == 1) ? " selected" : ""), "VIP клиент");
                  
                  print " </select>\n";                  
            ?>
         </div>
		 
		 
		 <div style = "margin: 10px 10px 10px 10px;">
            <label for = "has_video">Видео представяне</label><br />
            <?php
             	  print " <select id = \"has_video\" name = \"has_video\">\n";
                  
                  printf("<option value = \"0\"%s>%s</option>\n",  (($resultPackage['has_video'] == 0) ? " selected" : ""), "няма");
                  printf("<option value = \"1\"%s>%s</option>\n",  (($resultPackage['has_video'] == 1) ? " selected" : ""), "има видео представяне");
                  
                  print " </select>\n";                  
            ?>
         </div>
                
		 <div style = "margin: 10px 10px 10px 10px;">
            <label for = "is_Silver">Сребърен клиент</label><br />
            <?php
             	  print " <select id = \"is_Silver\" name = \"is_Silver\">\n";
                  
                  printf("<option value = \"0\"%s>%s</option>\n",  (($resultPackage['is_Silver'] == 0) ? " selected" : ""), "не е Сребърен");
                  printf("<option value = \"1\"%s>%s</option>\n",  (($resultPackage['is_Silver'] == 1) ? " selected" : ""), "Сребърен клиент");
                  
                  print " </select>\n";                  
            ?>
         </div>
		 
		 <div style = "margin: 10px 10px 10px 10px;">
            <label for = "is_Gold">Златен клиент</label><br />
            <?php
             	  print " <select id = \"is_Gold\" name = \"is_Gold\">\n";
                  
                  printf("<option value = \"0\"%s>%s</option>\n",  (($resultPackage['is_Gold'] == 0) ? " selected" : ""), "не е Златен");
                  printf("<option value = \"1\"%s>%s</option>\n",  (($resultPackage['is_Gold'] == 1) ? " selected" : ""), "Златен клиент");
                  
                  print " </select>\n";                  
            ?>
         </div>
                 
				 
		 <div style = "margin: 10px 10px 10px 10px;">
            <label for = "is_Featured">Специален клиент(излиза в ляво на квадратния банер)</label><br />
            <?php
             	  print " <select id = \"is_Featured\" name = \"is_Featured\">\n";
                  
                  printf("<option value = \"0\"%s>%s</option>\n",  (($resultPackage['is_Featured'] == 0) ? " selected" : ""), "не е Специален");
                  printf("<option value = \"1\"%s>%s</option>\n",  (($resultPackage['is_Featured'] == 1) ? " selected" : ""), "Специален клиент");
                  
                  print " </select>\n";                  
            ?>
         </div>
                 
                 
                 
        <div style = "margin: 10px 10px 10px 10px;">
            <label for = "is_Promo_cnt">Промоционални оферти (излизат на главната страница)</label><br />
           <?php
               printf("<input type = \"text\" id = \"is_Promo_cnt\" name = \"is_Promo_cnt\" value = \"%s\" size = \"40\" />\n", $resultPackage['is_Promo_cnt']);
            ?>
         </div>
                 
		 <div style = "margin: 10px 10px 10px 10px;">
            <label for = "pr_Stuff">право на PR-материал</label><br />
            <?php
             	  print " <select id = \"pr_Stuff\" name = \"pr_Stuff\">\n";
                  
                  printf("<option value = \"0\"%s>%s</option>\n",  (($resultPackage['pr_Stuff'] == 0) ? " selected" : ""), "няма PR-материал");
                  printf("<option value = \"1\"%s>%s</option>\n",  (($resultPackage['pr_Stuff'] == 1) ? " selected" : ""), "има право на PR-материал");
                  
                  print " </select>\n";                  
            ?>
         </div>
                 
       
         <div style = "margin: 10px 10px 10px 10px;">
         <?php
            if ($package_id > 0)
               print "<input type = \"submit\" name = \"save\" value = \"запиши\" class = \"buttonInv\" style = \"width: 265px; height: 30px; font-size: 14px;\">";
            else
               print "<input type = \"submit\" name = \"add\" value = \"запиши\" class = \"buttonInv\" style = \"width: 265px; height: 30px; font-size: 14px;\">";
         ?>
         </div>
      </div>

     
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


<?php
// -------------------- funkcii -----------------------------------------



?>