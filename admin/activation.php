<?php 

$pageName = 'activation';
include_once("inc/dblogin.inc.php");

	if (empty($_POST) || !isset($_REQUEST['only_not_active']) || empty($_REQUEST['only_not_active'])) {
		$And_Only_Not_Active = " AND active ='0'";
		
		$And_Firm = $And_Only_Not_Active;	
	    	$And_User = $And_Only_Not_Active;	
	    	$And_Post = $And_Only_Not_Active;	
	    	$And_Question = $And_Only_Not_Active;	
	}
	else { 
		$And_Firm = (!empty($_REQUEST['firmID']) ? " AND f.id = '" . $_REQUEST['firmID'] . "'" : '');	
    		$And_User = (!empty($_REQUEST['userID']) ? " AND u.userID = '" . $_REQUEST['userID'] . "'" : '');	
    		$And_Post = (!empty($_REQUEST['postID']) ? " AND p.postID = '" . $_REQUEST['postID'] . "'" : '');	
    		$And_Question = (!empty($_REQUEST['questionID']) ? " AND q.questionID = '" . $_REQUEST['questionID'] . "'" : '');	
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
	 
      function set_active(value,type,typeID)
      {		
      		if(value==1) action='Активирахте';
      		else action = 'Деактивирахте';
      		alert('Вие токущо '+action+' продукта!');
      
	    	var pars = 'typeID=' + typeID + '&is_active='+ value + '&type=' + type ;
			new Ajax.Request('ajax_activating.php', {method: 'post',parameters: pars }) 
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



<div id="CONTAINER" style="margin:0px;width:auto; ">
	
  <div id="LEFT-1" style="float:left; width:160px;margin:0px;">
	  <?php include("activation_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("activation_inc/left-2.php");  ?>  
  </div>
  
  <div id="HEADER" style="height:320px; background-image:url(images/header_bgr_blue.png);background-position:top; background-repeat:repeat-x;">          
         <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       		<?php  include("activation_inc/baner-kvadrat.inc.php");  ?>  
     	</div>
  </div>    
     
  <div id="CENTER" style="float:left;margin-left:0px;width:620px;">
 	 <fieldset style="width:620px">
      <legend onclick=" Effect.toggle($('packagesDIV'),'Appear');">&nbsp;Преглед&nbsp;</legend>

      
<div id="packagesDIV" style="margin:0px;">
      <div style = "padding: 15px;">Добре дошли в административния инструмент за автоматизирано въвеждане на пакети <b>на GoZbiTe.Com</b>.<br /><br /></div>
   

<fieldset>   
<legend onclick=" Effect.toggle($('selectFirmDiv'),'Appear');">&nbsp;Избери Заведение/Фирма:&nbsp;</legend>
<div id="selectFirmDiv" style="margin:10px;">
           <?php
               $sql = "SELECT id, name FROM firms ORDER BY name";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
                  print "<select style=\"width:300px;\" name = \"firmID\" id = \"firmID\" onchange=\"document.searchform.submit(); \">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($_REQUEST['firmID'] == $cmpnsArr[$i]["id"]) ? " selected" : ""), $cmpnsArr[$i]["name"]);
                  }
                  print "</select>\n";
               }
            ?>
	</div>
</fieldset>  

 

<fieldset>   
<legend onclick=" Effect.toggle($('selectUserDiv'),'Appear');">&nbsp;Избери Потребител :&nbsp;</legend>
<div id="selectUserDiv" style="margin:10px;">
           <?php
               $sql = "SELECT userID, CONCAT(first_name,' ',last_name) as 'user' FROM users ORDER BY user";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
                  print "<select style=\"width:300px;\" name = \"userID\" id = \"userID\" onchange=\"document.searchform.submit(); \">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["userID"], (($_REQUEST['userID'] == $cmpnsArr[$i]["userID"]) ? " selected" : ""), $cmpnsArr[$i]["user"]);
                  }
                  print "</select>\n";
               }
            ?>
</div>
</fieldset>  


<fieldset>   
<legend onclick=" Effect.toggle($('selectPostDiv'),'Appear');">&nbsp;Избери Статия :&nbsp;</legend>
<div id="selectPostDiv" style="margin:10px;">
           <?php
			   $sql = "SELECT postID as 'id', title as 'post' FROM posts ORDER BY post";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
                  print "<select style=\"width:300px;\" name = \"postID\" id = \"postID\" onchange=\"document.searchform.submit(); \">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($_REQUEST['postID'] == $cmpnsArr[$i]["id"]) ? " selected" : ""), substr($cmpnsArr[$i]["post"],0,100));
                  }
                  print "</select>\n";
               }
            ?>
</div>
</fieldset>  




<fieldset>   
<legend onclick=" Effect.toggle($('selectQuestionDiv'),'Appear');">&nbsp;Избери от Форума :&nbsp;</legend>
<div id="selectQuestionDiv" style="margin:10px;">
           <?php
			   $sql = "SELECT questionID as 'id', question_body as 'question' FROM questions ORDER BY question";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
                  print "<select style=\"width:300px;\" name = \"questionID\" id = \"questionID\" onchange=\"document.searchform.submit(); \">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($_REQUEST['questionID'] == $cmpnsArr[$i]["id"]) ? " selected" : ""), substr($cmpnsArr[$i]["question"],0,100));
                  }
                  print "</select>\n";
               }
            ?>
</div>
</fieldset>  


<div style="margin:10px;">
         <input type="checkbox" id="Only_Not_Active" name="Only_Not_Active" onclick="if(this.checked) {$('only_not_active').setValue('1'); document.searchform.submit();} else {$('only_not_active').setValue('0'); document.searchform.submit();}" <?=((($_REQUEST['only_not_active'] != 0) OR ($_REQUEST['Only_Not_Active'] == 1)) ? " checked " : "")?> />Само неактивни/Всички!
         <input type="hidden" name="only_not_active" id="only_not_active" value="" />
       
</div>
         
         
<?php if(!empty($_REQUEST['firmID'])) { ?>
<fieldset>   
<legend onclick=" Effect.toggle($('FirmDiv'),'Appear');">&nbsp;Заведения/Фирми:&nbsp;</legend>
<div id="FirmDiv" style="margin:10px;">        
            <?php
               $sql = "SELECT f.id as 'firm_id', f.name as 'firm', f.active as 'active', f.registered_on 'registered_on', f.last_login as 'last_login' FROM  firms f WHERE 1=1 $And_Firm ORDER BY firm";
               $conn->setsql($sql);
               $conn->getTableRows();
               $packageArr   = $conn->result;
               $cPackageArr  = $conn->numberrows;
               if($cPackageArr > 0) {
                  print "<table><tr align='center' style=' color: #FFFFFF; padding:2px; font-weight:900' bgcolor='#FF6600'><td>Заведения/Фирми</td><td>Активност</td><td>Дата на Ресистрация</td><td>Последно логване</td></tr>";
				 $row=1;
				
                  for($i = 0; $i < $cPackageArr; $i++) {
                 if($row == 1)
				 { $bgcolor = '#FEF3DA'; $row = 2; }
				 else {$bgcolor = '#FEDAC5';  $row=1;}
				   printf("<tr style=\"padding:2px;\" bgcolor='%s' align='center'><td><a href='http://gozbite.com/разгледай-фирма-%d,%s.html'>%s</a></td><td><input type='checkbox' id='active%d' name='active%d' %s onclick='if(this.checked) {set_active(1,\"firm\",%d);} else{set_active(0,\"firm\",%d);} '/></td><td style=\"color: #336699;\" >%s</td><td style=\"color: #336699;\" >%s</td></tr>",$bgcolor, $packageArr[$i]["firm_id"], $packageArr[$i]["firm"], $packageArr[$i]["firm"], $i, $i, ($packageArr[$i]["active"]==1)?'checked':'', $packageArr[$i]["firm_id"], $packageArr[$i]["firm_id"], $packageArr[$i]["registered_on"], $packageArr[$i]["last_login"]);
                  }
                  print "</table>";
               }
            ?>
</div>
</fieldset>
<?php } ?

    
<?php if (!empty($_REQUEST['userID'])) { ?>    
<fieldset>   
<legend onclick=" Effect.toggle($('UserDiv'),'Appear');">&nbsp; Потребители :&nbsp;</legend>
<div id="UserDiv" style="margin:10px;">       
            <?php
               $sql = "SELECT u.userID as 'user_id', CONCAT(u.first_name,' ',u.last_name) as 'user', u.active as 'active', u.date_register 'date_register', u.last_login as 'last_login' FROM  users u WHERE 1=1 $And_User ORDER BY user";
               echo $sql;$conn->setsql($sql);
               $conn->getTableRows();
               $packageArr   = $conn->result;
               $cPackageArr  = $conn->numberrows;
               if($cPackageArr > 0) {
                  print "<table><tr align='center' style=' color: #FFFFFF; padding:2px; font-weight:900' bgcolor='#FF6600'><td>Потребител</td><td>Активност</td><td>Дата на Регистрация</td><td>Последно логване</td></tr>";
				 $row=1;
				
                  for($i = 0; $i < $cPackageArr; $i++) {
                 if($row == 1) 
				 { $bgcolor = '#FEF3DA'; $row = 2; }
				 else {$bgcolor = '#FEDAC5';  $row=1;}
				   printf("<tr style=\"padding:2px;\" bgcolor='%s' align='center'><td><a href='http://gozbite.com/разгледай-потребител-%d,%s_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html'>%s</a></td><td><input type='checkbox' id='active%d' name='active%d' %s onclick='if(this.checked) {set_active(1,\"user\",%d);} else{set_active(0,\"user\",%d);} '/></td><td style=\"color: #336699;\" >%s</td><td style=\"color: #336699;\" >%s</td></tr>",$bgcolor, $packageArr[$i]["user_id"], $packageArr[$i]["user"], $packageArr[$i]["user"], $i, $i, ($packageArr[$i]["active"]==1)?'checked':'', $packageArr[$i]["user_id"], $packageArr[$i]["user_id"], $packageArr[$i]["date_register"], $packageArr[$i]["last_login"]);
                  }
                  print "</table>";
               }
            ?>
</div>
</fieldset>
<?php } ?>




<?php if (!empty($_REQUEST['postID'])) { ?>     
<fieldset>   
<legend onclick=" Effect.toggle($('PostDiv'),'Appear');">&nbsp; Статии :&nbsp;</legend>
<div id="PostDiv" style="margin:10px;">       
            <?php
               $sql = "SELECT p.postID as 'post_id', p.title as 'post', p.active as 'active', p.date 'registered_on' FROM  posts p WHERE 1=1 $And_Post ORDER BY post";
               $conn->setsql($sql);
               $conn->getTableRows();
               $packageArr   = $conn->result;
               $cPackageArr  = $conn->numberrows;
               if($cPackageArr > 0) {
                  print "<table><tr align='center' style=' color: #FFFFFF; padding:2px; font-weight:900' bgcolor='#FF6600'><td>Новина</td><td>Активност</td><td>Дата на Ресистрация</td></tr>";
				 $row=1;
				
                  for($i = 0; $i < $cPackageArr; $i++) {
                 if($row == 1) 
				 { $bgcolor = '#FEF3DA'; $row = 2; }
				 else {$bgcolor = '#FEDAC5';  $row=1;}
				   printf("<tr style=\"padding:2px;\" bgcolor='%s' align='center'><td><a href='http://gozbite.com/прочети-статия-%d,%s.html'>%s</a></td><td><input type='checkbox' id='active%d' name='active%d' %s onclick='if(this.checked) {set_active(1,\"post\",%d);} else{set_active(0,\"post\",%d);} '/></td><td style=\"color: #336699;\" >%s</td></tr>",$bgcolor, $packageArr[$i]["post_id"], strip_tags(substr($packageArr[$i]["post"],0,100)), substr($packageArr[$i]["post"],0,100), $i, $i, ($packageArr[$i]["active"]==1)?'checked':'', $packageArr[$i]["post_id"], $packageArr[$i]["post_id"], $packageArr[$i]["registered_on"]);
                  }
                  print "</table>";
               }
            ?>
</div>
</fieldset>
<?php } ?>

     
     
<?php if (!empty($_REQUEST['questionID'])) { ?>     
<fieldset>   
<legend onclick=" Effect.toggle($('QuestionsDiv'),'Appear');">&nbsp; Форум:&nbsp;</legend>
<div id="QuestionsDiv" style="margin:10px;">        
            <?php
               $sql = "SELECT q.questionID as 'question_id', q.question_body as 'question', q.active as 'active', q.created_on as 'registered_on' FROM  questions q WHERE 1=1 $And_Question ORDER BY question";
               $conn->setsql($sql);
               $conn->getTableRows();
               $packageArr   = $conn->result;
               $cPackageArr  = $conn->numberrows;
               if($cPackageArr > 0) {
                  print "<table><tr align='center' style=' color: #FFFFFF; padding:2px; font-weight:900' bgcolor='#FF6600'><td>Тема</td><td>Активност</td><td>Дата на Ресистрация</td></tr>";
				 $row=1;
				
                  for($i = 0; $i < $cPackageArr; $i++) {
                 if($row == 1) 
				 { $bgcolor = '#FEF3DA'; $row = 2; }
				 else {$bgcolor = '#FEDAC5';  $row=1;}
				   printf("<tr style=\"padding:2px;\" bgcolor='%s' align='center'><td><a href='http://gozbite.com/разгледай-форум-тема-%d,%s.html#question_19'>%s</a></td><td><input type='checkbox' id='active%d' name='active%d' %s onclick='if(this.checked) {set_active(1,\"question\",%d);} else{set_active(0,\"question\",%d);} '/></td><td style=\"color: #336699;\" >%s</td></tr>",$bgcolor, $packageArr[$i]["question_id"], strip_tags(substr($packageArr[$i]["question"],0,100)), substr($packageArr[$i]["question"],0,100), $i, $i, ($packageArr[$i]["active"]==1)?'checked':'', $packageArr[$i]["question_id"], $packageArr[$i]["question_id"], $packageArr[$i]["registered_on"]);
                  }
                  print "</table>";
               }
            ?>
</div>
</fieldset>
<?php } ?>

       
  </div>
   <!-- Krai na PREGLED -->  
  
  </div>
  
</div> <!-- END CONTAINER DIV -->
   
<div id="FOOTER" style=" float:left;width:auto; margin-top:20px;">
	 <?php include("inc/footer.inc.php");  ?>  
</div>


</form>
</body>
</html>
