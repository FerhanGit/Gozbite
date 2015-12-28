<?php
$pageName = 'shopping';
include_once("inc/dblogin.inc.php");

	$And_Company 					= $_REQUEST['companyID']?" AND h.id='".$_REQUEST['companyID']."'":'';	
    $And_Doctor 					= $_REQUEST['doctorID']?" AND d.id='".$_REQUEST['doctorID']."'":'';	
    $And_Only_Not_Payed_Package 	= $_REQUEST['only_not_payed']?" AND ppn.is_payed='".!$_REQUEST['only_not_payed']."'":'';
    $And_Only_Not_Payed_Supplement  = $_REQUEST['only_not_payed']?" AND psn.is_payed='".!$_REQUEST['only_not_payed']."'":'';
   
    
    if(isset($_REQUEST['delete_ordered_package']) && !empty($_REQUEST['delete_ordered_package']))
    {
    		$sql = "SELECT company_id, doctor_id FROM purchased_packages WHERE id='".$_REQUEST['delete_ordered_package']."'";
            $conn->setsql($sql);
			$conn->getTableRow();
			$resultID = $conn->result;
			
			
			$sql = "DELETE FROM purchased_packages WHERE id='".$_REQUEST['delete_ordered_package']."'";
            $conn->setsql($sql);
            $conn->updateDB();
			
			if($resultID['company_id'] > 0)
			{
				$sql = "UPDATE hospitals SET is_Silver = '0', is_Gold = '0' WHERE id='".$resultID['company_id']."'";
				$conn->setsql($sql);
				$conn->updateDB();
			}
			if($resultID['doctor_id'] > 0)
			{
				$sql = "UPDATE doctors SET is_Silver = '0', is_Gold = '0' WHERE id='".$resultID['doctor_id']."'";
				$conn->setsql($sql);
				$conn->updateDB();
			}
    } 
    
   
    
 // -------------------------------------------------------------------------------------
 
    if(isset($_REQUEST['delete_package'])  && !empty($_REQUEST['delete_package']))
    {
    		$sql = "DELETE FROM packages WHERE id='".$_REQUEST['delete_package']."'";
            $conn->setsql($sql);
            $conn->updateDB();
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
	 
	     
      function set_payed(value,PackorSupps,id,companyID,companyOrDoctor_field)
      {
      		if(value==1) action='Е платен!';
      		else action = 'Не е платен!';
      		alert('Вие токущо указахте, че продукта '+action);
      		
    		var pars = 'companyID=' + companyID + '&companyOrDoctor_field='+ companyOrDoctor_field + '&is_payed='+ value +'&id='+ id + '&PackorSupps=' + PackorSupps;
    		new Ajax.Request('ajax_activate_and_set_payed_packages.php', {method: 'post',parameters: pars }) 
      	
      }
      
      function set_active(value,PackorSupps,id,companyID,companyOrDoctor_field)
      {
      		if(value==1) action='Активирахте';
      		else action = 'Деактивирахте';
      		alert('Вие токущо '+action+' продукта!');
      	
	    	var pars = 'companyID=' + companyID + '&companyOrDoctor_field='+ companyOrDoctor_field + '&is_active='+ value +'&id='+ id + '&PackorSupps=' + PackorSupps ;
			new Ajax.Request('ajax_activate_and_set_payed_packages.php', {method: 'post',parameters: pars }) 
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
      <div style = "padding: 15px;">Добре дошли в административния инструмент за автоматизирано въвеждане на пакети <b>на ОхБоли.БГ</b>.<br /><br /></div>
   
<div style="margin:10px;">
<fieldset>   
<legend> Избери Болница : </legend>  
           <?php
               $sql = "SELECT id, name FROM hospitals ORDER BY name";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
                  print "<select style=\"width:300px;\" name = \"companyID\" id = \"companyID\" onchange=\";document.searchform.submit(); \">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($_REQUEST['companyID'] == $cmpnsArr[$i]["id"]) ? " selected" : ""), $cmpnsArr[$i]["name"]);
                  }
                  print "</select>\n";
               }
            ?>
</fieldset>  
</div>
 
<div style="margin:10px;">
<fieldset>  
<legend> Избери Лекар : </legend>   
           <?php
               $sql = "SELECT id, CONCAT(first_name,' ',last_name) as 'doctor' FROM doctors ORDER BY doctor";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
                  print "<select style=\"width:300px;\" name = \"doctorID\" id = \"doctorID\" onchange=\";document.searchform.submit(); \">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($_REQUEST['doctorID'] == $cmpnsArr[$i]["id"]) ? " selected" : ""), $cmpnsArr[$i]["doctor"]);
                  }
                  print "</select>\n";
               }
            ?>
</fieldset>  
</div>

<div style="margin:10px;">
         <input type="checkbox" id="Only_Not_Payed" name="Only_Not_Payed" onclick="if(this.checked) {$('only_not_payed').setValue('1'); document.searchform.submit();} else {$('only_not_payed').setValue('0'); document.searchform.submit();}" <?=$_REQUEST['Only_Not_Payed']?"checked":""?> />Само неплатилите/Всички!
         <input type="hidden" name="only_not_payed" id="only_not_payed" value="" />
       
</div>
         
<div style="margin:10px;">
 <fieldset>
<legend> Пакети Болници</legend>          
            <?php
               $sql = "SELECT pp.id as 'id', h.id as 'firm_id', h.name as 'firm', p.name as 'package' , IF(p.months=1,'1 Месечен','12 Месечен') as 'per_month',  p.total_price  as 'package_price', p.credit_cost  as 'credit_cost', pp.is_payed as 'is_payed', pp.active as 'active', pp.used_credits as 'used_credits', pp.start_date as 'start_date', pp.end_date as 'end_date' , IF((pp.start_date + INTERVAL 3 DAY)> NOW(),1,0) as 'tree_days',  IF((pp.end_date > NOW()),1,0) as 'expired' FROM purchased_packages pp, packages p, hospitals h WHERE pp.company_id=h.id AND pp.package_id=p.id $And_Company $And_Only_Not_Payed_Package ORDER BY firm";
               $conn->setsql($sql);
               $conn->getTableRows();
               $packageArr   = $conn->result;
               $cPackageArr  = $conn->numberrows;
               if($cPackageArr > 0) {
                  print "<table><tr align='center' style=' color: #FFFFFF; padding:2px; font-weight:900' bgcolor='#FF6600'><td>Фирма</td><td>Пакет</td><td>За период</td><td>Единична Цена</td><td>Цена в Кредити</td><td>Платен</td><td>Платен с Кредити</td><td>Активен</td><td>От дата</td><td>До дата</td><td>Действия</td></tr>";
				 $row=1;
				
                  for($i = 0; $i < $cPackageArr; $i++) {
                 if($row == 1)
				 { $bgcolor = '#FEF3DA'; $row = 2; }
				 else {$bgcolor = '#FEDAC5';  $row=1;}
				   printf("<tr style=\"padding:2px;\" bgcolor='%s' align='center'><td>%s</td><td>%s</td><td>%s</td><td>%s лв.</td><td>%s кредита</td><td><input type='checkbox' id='is_payed%d' name='is_payed%d' %s onclick='if(this.checked) {set_payed(1,\"package\",%d,%d,\"company_id\");} else{set_payed(0,\"package\",%d,%d,\"company_id\");}'/></td><td>%s</td><td><input type='checkbox' id='active%d' name='active%d' %s onclick='if(this.checked) {set_active(1,\"package\",%d,%d,\"company_id\");} else{set_active(0,\"package\",%d,%d,\"company_id\");}'/></td><td bgcolor='%s' style=\"color: #336699;\" >%s</td><td bgcolor='%s' style=\"color: #336699;\" >%s</td><td><a href='javascript:document.searchform.submit();' onclick=\"if(confirm('Сигурни ли сте?')) $('delete_ordered_package').setValue(%d); else{ return false;}\" >изтрий</a></td></tr>",$bgcolor, $packageArr[$i]["firm"],$packageArr[$i]["package"],(!eregi('[0_9]',$packageArr[$i]["per_month"])?$packageArr[$i]["per_month"]:$packageArr[$i]["per_year"]), $packageArr[$i]["package_price"] , $packageArr[$i]["credit_cost"] , $i, $i, ($packageArr[$i]["is_payed"]==1)?'checked':'', $packageArr[$i]["id"], $packageArr[$i]["firm_id"], $packageArr[$i]["id"], $packageArr[$i]["firm_id"], ($packageArr[$i]["used_credits"]>0?'Да':'Не') , $i, $i, ($packageArr[$i]["active"]==1)?'checked':'', $packageArr[$i]["id"],  $packageArr[$i]["firm_id"], $packageArr[$i]["id"], $packageArr[$i]["firm_id"], ($packageArr[$i]["tree_days"]==0 && $packageArr[$i]["is_payed"]==0)?'red':$bgcolor , $packageArr[$i]["start_date"], ($packageArr[$i]["expired"]==0)?'orange':$bgcolor , $packageArr[$i]["end_date"], $packageArr[$i]["id"]);
                  }
                  print "</table>";
               }
            ?>
 </fieldset>
</div>
     
<div style="margin:10px;">
 <fieldset>
<legend> Пакети Лекари</legend>          
            <?php
			   $sql = "SELECT pp.id as 'id', d.id as 'doctor_id', CONCAT(d.first_name,' ',d.last_name) as 'doctor', p.name as 'package' , IF(p.months=1,'1 Месечен','12 Месечен') as 'per_month',  p.total_price  as 'package_price', p.credit_cost  as 'credit_cost', pp.is_payed as 'is_payed', pp.active as 'active', pp.used_credits as 'used_credits', pp.start_date as 'start_date', pp.end_date as 'end_date' , IF((pp.start_date + INTERVAL 3 DAY)> NOW(),1,0) as 'tree_days',  IF((pp.end_date > NOW()),1,0) as 'expired' FROM purchased_packages pp, packages p, doctors d WHERE pp.doctor_id=d.id AND pp.package_id=p.id $And_Doctor $And_Only_Not_Payed_Package ORDER BY doctor";
               $conn->setsql($sql);
               $conn->getTableRows();
               $packageArr   = $conn->result;
               $cPackageArr  = $conn->numberrows;
               if($cPackageArr > 0) {
                  print "<table><tr align='center' style=' color: #FFFFFF; padding:2px; font-weight:900' bgcolor='#FF6600'><td>Фирма</td><td>Пакет</td><td>За период</td><td>Единична Цена</td><td>Цена в Кредити</td><td>Платен</td><td>Платен с Кредити</td><td>Активен</td><td>От дата</td><td>До дата</td><td>Действия</td></tr>";
				 $row=1;
				
                  for($i = 0; $i < $cPackageArr; $i++) {
                 if($row == 1)
				 { $bgcolor = '#FEF3DA'; $row = 2; }
				 else {$bgcolor = '#FEDAC5';  $row=1;}
				   printf("<tr style=\"padding:2px;\" bgcolor='%s' align='center'><td>%s</td><td>%s</td><td>%s</td><td>%s лв.</td><td>%s кредита</td><td><input type='checkbox' id='is_payed%d' name='is_payed%d' %s onclick='if(this.checked) {set_payed(1,\"package\",%d,%d,\"doctor_id\");} else{set_payed(0,\"package\",%d,%d,\"doctor_id\");}'/></td><td>%s</td><td><input type='checkbox' id='active%d' name='active%d' %s onclick='if(this.checked) {set_active(1,\"package\",%d,%d,\"doctor_id\");} else{set_active(0,\"package\",%d,%d,\"doctor_id\");}'/></td><td bgcolor='%s' style=\"color: #336699;\" >%s</td><td bgcolor='%s' style=\"color: #336699;\" >%s</td><td><a href='javascript:document.searchform.submit();' onclick=\"if(confirm('Сигурни ли сте?')) $('delete_ordered_package').setValue(%d); else{ return false;}\" >изтрий</a></td></tr>",$bgcolor, $packageArr[$i]["doctor"],$packageArr[$i]["package"],(!eregi('[0_9]',$packageArr[$i]["per_month"])?$packageArr[$i]["per_month"]:$packageArr[$i]["per_year"]), $packageArr[$i]["package_price"] ,$packageArr[$i]["credit_cost"] , $i, $i, ($packageArr[$i]["is_payed"]==1)?'checked':'', $packageArr[$i]["id"], $packageArr[$i]["doctor_id"], $packageArr[$i]["id"], $packageArr[$i]["doctor_id"],  ($packageArr[$i]["used_credits"]>0?'Да - с '.$packageArr[$i]["used_credits"].' кредита' :'Не') , $i, $i, ($packageArr[$i]["active"]==1)?'checked':'', $packageArr[$i]["id"],  $packageArr[$i]["doctor_id"], $packageArr[$i]["id"], $packageArr[$i]["doctor_id"], ($packageArr[$i]["tree_days"]==0 && $packageArr[$i]["is_payed"]==0)?'red':$bgcolor , $packageArr[$i]["start_date"], ($packageArr[$i]["expired"]==0)?'orange':$bgcolor , $packageArr[$i]["end_date"], $packageArr[$i]["id"]);
                  }
                  print "</table>";
               }
            ?>
 </fieldset>
</div>

<div style="margin:10px;float:left;">
<fieldset>
<legend>Легенда</legend>
<div style="float:left;"><div style="background-color:orange; width:50px; height:20px;float:left;"></div> <div  style="float:left;margin-left:10px;"> - Изтекла активност!</div></div>
<br /><br /><div style="float:left;"><div style="background-color:red; width:50px; height:20px;float:left;"></div> <div style="float:left;margin-left:10px;"> - Неплатен! </div></div>
</fieldset>
</div>
<input type="hidden" name="delete_ordered_package" id="delete_ordered_package" value="" />
<input type="hidden" name="delete_ordered_supplement" id="delete_ordered_supplement" value="" />
      
   </fieldset>            
  </div>
   <!-- Krai na PREGLED -->  
   
   
   
   
   
   
<!-- Redaktirane на Пакети -->
<fieldset style="float:left; margin:20px;width:600px;">
      <legend onclick=" Effect.toggle($('editDIV'),'Appear');">&nbsp;Редактиране на MySecondHome Пакети&nbsp;</legend>

      
<div id="editDIV" style="margin:10px;">

<div style="margin:10px;">
 <fieldset>
<legend>Добави Нов MySecondHome Пакет</legend>       
            
	<a href="edit_packages.php" target="_self">Добави нов пакет</a>
 </fieldset>
</div>

         
<div style="margin:10px;">
<fieldset >
<legend>Пакети на ОхБоли за Болници и Лекари</legend>          
            <?php
               $sql = "SELECT id, name, months FROM packages";
			   $conn->setsql($sql);
			   $conn->getTableRows();
			   $resultPackages=$conn->result;
			   $numPackages=$conn->numberrows;
			  
             if($numPackages > 0) {
                 
				 $row=1;
				 print "<div style=\"width:300px;\">";
				
                for ($i=0;$i<$numPackages;$i++) 
                {
                 	if($row == 1)
				 	{$bgcolor = '#FEF3DA'; $row = 2; }
				 	else {$bgcolor = '#FEDAC5';  $row=1;}
				   
		?>		
 <div style="width:540px; float:left;">
     <div style="float:left;width:200px;margin:2px 2px 2px 2px;padding:5px;background-color:#FF6600;font-weight:900;"><a style="color:#000000; text-decoration:none;" href=javascript:void(0); ><?=$resultPackages[$i]['name']." (".$resultPackages[$i]['months']." месеца)"?></a></div>
     <div align="center" style="float:left;width:80px;margin:2px 2px 2px 2px;padding:5px;background-color:<?=$bgcolor?>;"><a href='edit_packages.php?package_id=<?=$resultPackages[$i]['id']?>' >Редактирай</a></div>
     <div align="center" style="float:left;width:60px;margin:2px 2px 2px 2px;padding:5px;background-color:<?=$bgcolor?>;"><a href='javascript:document.searchform.submit();' onclick="if(confirm('Сигурни ли сте?')) $('delete_package').setValue(<?=$resultPackages[$i]['id']?>); else{ return false;}" >изтрий</a></div>
	         
	
     
</div>
  


        <?php
                }
                 
                 print "</div>";
              } 
            ?>
   </fieldset>
</div>


       


<input type="hidden" name="delete_package" id="delete_package" value="" />
<input type="hidden" name="delete_supplement" id="delete_supplement" value="" />
       
   </fieldset>            
  </div>
   <!-- Krai na Redaktirane Пакети-->  
   
   
   
      
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