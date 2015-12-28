<?php
$pageName = 'pr_stuff';
include_once("inc/dblogin.inc.php");

	$And_Firm					= $_REQUEST['firmID']?" AND firm_id='".$_REQUEST['firmID']."'":'';	
    $And_User					= $_REQUEST['userID']?" AND user_id='".$_REQUEST['userID']."'":'';	

    if($_REQUEST['insert_Btn_Pr'] == 'Въведи')
    {
    	if($_REQUEST['firmID'] > 0)
    	{
	     	$sql = "INSERT INTO pr_stuff SET body = '".$_REQUEST['pr_body']."', active = 1, firm_id = '".$_REQUEST['firmID']."' ON DUPLICATE KEY UPDATE body = '".$_REQUEST['pr_body']."'";
			$conn->setsql($sql);
			$conn->updateDB();
    	}
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
	 
	       
      function set_active(value, PR_Stuff_ID)
      {
      		if(value==1) action='Активирахте';
      		else action = 'Деактивирахте';
      		alert('Вие токущо '+action+' продукта!');
      	
	    	var pars = 'is_active='+ value + '&PR_Stuff_ID=' + PR_Stuff_ID ; 
			new Ajax.Request('ajax_activate_pr_stuff.php', {method: 'post',parameters: pars 
//			, onSuccess: function(transport) {
//    			alert(transport.responseText);
//  			}	
      }) 
      }
	  	        
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
<div id="test"></div>
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

<div id="test"></div>

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
 	 <fieldset style="width:660px">
      <legend onclick=" Effect.toggle($('packagesDIV'),'Appear');">&nbsp;Преглед&nbsp;</legend>

      
<div id="packagesDIV" style="margin:0px;">
      <div style = "padding: 15px;">Добре дошли в административния инструмент за автоматизирано въвеждане на PR-статия, която ще се визуализира в сайта <b>GoZbiTe.Com</b>.<br /><br /></div>
   
<div style="margin:10px;">
<fieldset>   
<legend> Избери Заведение/Фирма : </legend>  
           <?php
               $sql = "SELECT id, name FROM firms ORDER BY name";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
                  print "<select style=\"width:300px;\" name = \"firmID\" id = \"firmID\" onchange=\" document.getElementById('hotelID').value=''; document.searchform.submit(); \">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($_REQUEST['firmID'] == $cmpnsArr[$i]["id"]) ? " selected" : ""), $cmpnsArr[$i]["name"]);
                  }
                  print "</select>\n";
               }
            ?>
</fieldset>  
</div>
          
<div style="margin:10px;">
 <fieldset>
<legend> PR Материал</legend>          
<?php
        if(!empty($_REQUEST['firmID']) or !empty($_REQUEST['userID']))
        {
               $sql = "SELECT prID, firm_id, user_id, body, active FROM pr_stuff WHERE 1=1 $And_Firm $And_User ";
               $conn->setsql($sql);
               $conn->getTableRow();
               $prResult   = $conn->result;
               $prNum = $conn->numberrows;
               
        }
            ?>
            
            <input type='checkbox' id='active' name='active' <?=(($prResult['active']==1)?'CHECKED':'')?> onclick='if(this.checked) {set_active(1,<?=$prResult['prID']?>);} else {set_active(0,<?=$prResult['prID']?>);}'/> Активирай
            
				<div style="margin:5px;margin-left:0px;overflow:auto;"> 				
					<?php 
					 require_once("FCKeditor/fckeditor.php");
			         $oFCKeditor = new FCKeditor('pr_body') ;
			         $oFCKeditor->BasePath   = "FCKeditor/";
			         $oFCKeditor->Width      = '400';
			         $oFCKeditor->Height     = '300' ;
			         $oFCKeditor->Value      = (strlen($prResult['body']) > 0) ? $prResult['body'] : ""; 
			         $oFCKeditor->Create(); 
					?> 
				 </div>
			
			
				 

			<div style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">	
				<input type="submit" value="Въведи" id="insert_Btn_Pr" title="Въведи" name="insert_Btn_Pr" />				
			</div>
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='9999999999'>
				 
				  
	
 </fieldset>
</div>
     
     
   </fieldset>            
  </div>
   <!-- Krai na PREGLED -->  
   
   
   
   
   
      
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