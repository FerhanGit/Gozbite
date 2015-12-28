<?php
	
	//$file = "import/excel/ceza.php";
   	ini_set('max_execution_time', '1750');
	include("inc/dblogin.inc.php");
	
	$And_Company 					= $_REQUEST['companyID']?" AND f.id='".$_REQUEST['companyID']."'":'';	
    $And_Only_Not_Payed_Package 	= $_REQUEST['only_not_payed']?" AND ppn.is_payed='".!$_REQUEST['only_not_payed']."'":'';
    $And_Only_Not_Payed_Supplement  = $_REQUEST['only_not_payed']?" AND psn.is_payed='".!$_REQUEST['only_not_payed']."'":'';
   
    
    if(isset($_REQUEST['delete_ordered_package']) && !empty($_REQUEST['delete_ordered_package']))
    {
    		$sql = "DELETE FROM purchased_msh_packages WHERE id='".$_REQUEST['delete_ordered_package']."'";
            $conn->setsql($sql);
            $conn->updateDB();
    } 
    
   
    
 // -------------------------------------------------------------------------------------
 
    if(isset($_REQUEST['delete_package'])  && !empty($_REQUEST['delete_package']))
    {
    		$sql = "DELETE FROM msh_packages WHERE id='".$_REQUEST['delete_package']."'";
            $conn->setsql($sql);
            $conn->updateDB();
    } 
    
   
   	
  
   	
?>	

<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>ЛАРГО.БГ - Административна част | ФИРМИ | Начало</title>
    <link rel = "Stylesheet" href = "css/autosuggest_inquisitor.css" type = "text/css" media = "screen" charset = "utf-8" />
   <script type = "text/javascript" src = "js/bsn.AutoSuggest_c_2.0.js"></script>
   <script type = "text/javascript" src = "js/shared_functions.js"></script>
    <script type = "text/javascript" src = "js/calendar.js"></script>
   <script type = "text/javascript" src = "js/calendar_conf.js"></script>
   <script type = "text/javascript" src = "js/prototype_1_6.js"></script>   
   <script type = "text/javascript" src = "js/scriptaculous.js"></script>
   <script type = "text/javascript">
      addCalendar("CalFDate", "Изберете дата", "fromDate", "itemform");
      addCalendar("CalTDate", "Изберете дата", "toDate", "itemform");
      

          
      function set_payed(value,PackorSupps,id,companyID)
      {
      		if(value==1) action='Е платен!';
      		else action = 'Не е платен!';
      		alert('Вие токущо указахте, че продукта '+action);
      		
    		var pars = 'companyID=' + companyID + '&is_payed='+ value +'&id='+ id + '&PackorSupps=' + PackorSupps;
    		new Ajax.Request('ajax_activate_and_set_payed_msh_packages.php', {method: 'post',parameters: pars }) 
      	
      }
      
      function set_active(value,PackorSupps,id,companyID)
      {
      		if(value==1) action='Активирахте';
      		else action = 'Деактивирахте';
      		alert('Вие токущо '+action+' продукта!');
      	
	    	var pars = 'companyID=' + companyID + '&is_active='+ value +'&id='+ id + '&PackorSupps=' + PackorSupps ;
			new Ajax.Request('ajax_activate_and_set_payed_msh_packages.php', {method: 'post',parameters: pars }) 
      }
       </script>
   <link rel="stylesheet" type="text/css" href="css/admin_styles.css">
  
</head>
<body>
<form name='itemform' action="" method='post' enctype = 'multipart/form-data'>
<input type = "hidden" name = "GoOut">
<div id = "header"><h1>ЛАРГО.БГ - Административна част | ФИРМИ |MySecondHome ПАКЕТИ</h1></div>
<?php
   include_once("inc/menu.inc.php");
   
?>
<div id = "content">




<!-- Pregled -->
   <fieldset style="width:800px">
      <legend onclick=" Effect.toggle($('packagesDIV'),'Appear');">&nbsp;Преглед&nbsp;</legend>

      
<div id="packagesDIV" style="margin:0px;">
      <div style = "padding: 15px;">Добре дошли в административния инструмент за автоматизирано въвеждане на MySecondHome пакети <b>на ЛАРГО.БГ</b>.<br /><br /></div>
   
<div style="margin:10px;">
           <?php
               $sql = "SELECT id, name FROM firms ORDER BY name";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
                  print "<select name = \"companyID\" id = \"companyID\" onchange=\";document.itemform.submit(); \">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($companyID == $cmpnsArr[$i]["id"]) ? " selected" : ""), $cmpnsArr[$i]["name"]);
                  }
                  print "</select>\n";
               }
            ?>
</div>

<div style="margin:10px;">
         <input type="checkbox" id="Only_Not_Payed" name="Only_Not_Payed" onclick="if(this.checked) {$('only_not_payed').setValue('1'); document.itemform.submit();} else {$('only_not_payed').setValue('0'); document.itemform.submit();}" <?=$_REQUEST['Only_Not_Payed']?"checked":""?> />Само неплатилите/Всички!
         <input type="hidden" name="only_not_payed" id="only_not_payed" value="" />
       
</div>
         
<div style="margin:10px;">
 <fieldset>
<legend> MySecondHome Пакети</legend>          
            <?php
               $sql = "SELECT pmp.id as 'id', f.id as 'firm_id', f.name as 'firm', mp.name as 'package' , IF(mp.months=3,'3 Месечен','12 Месечен') as 'per_month',  mp.total_price  as 'package_price', pmp.is_payed as 'is_payed', pmp.active as 'active', pmp.start_date as 'start_date', pmp.end_date as 'end_date' , IF((pmp.start_date + INTERVAL 3 DAY)> NOW(),1,0) as 'tree_days',  IF((pmp.end_date > NOW()),1,0) as 'expired'   FROM purchased_msh_packages pmp, msh_packages mp, firms f WHERE pmp.company_id=f.id AND pmp.package_id=mp.id $And_Company $And_Only_Not_Payed_Package ORDER BY firm";
               $conn->setsql($sql);
               $conn->getTableRows();
               $packageArr   = $conn->result;
               $cPackageArr  = $conn->numberrows;
               if($cPackageArr > 0) {
                  print "<table><tr align='center' style='padding:2px; font-weight:900' bgcolor='#FF6600'><td>Фирма</td><td>Пакет</td><td>За период</td><td>Единична Цена</td><td>Платен</td><td>Активен</td><td>От дата</td><td>До дата</td><td>Действия</td></tr>";
				 $row=1;
				
                  for($i = 0; $i < $cPackageArr; $i++) {
                 if($row == 1)
				 { $bgcolor = '#FEF3DA'; $row = 2; }
				 else {$bgcolor = '#FEDAC5';  $row=1;}
				   printf("<tr style=\"padding:2px;\" bgcolor='%s' align='center'><td>%s</td><td>%s</td><td>%s</td><td>%s EUR</td><td><input type='checkbox' id='is_payed%d' name='is_payed%d' %s onclick='if(this.checked) {set_payed(1,\"package\",%d,%d);} else{set_payed(0,\"package\",%d,%d);}'/></td><td><input type='checkbox' id='active%d' name='active%d' %s onclick='if(this.checked) {set_active(1,\"package\",%d,%d);} else{set_active(0,\"package\",%d,%d);}'/></td><td bgcolor='%s'>%s</td><td bgcolor='%s'>%s</td><td><a href='javascript:document.itemform.submit();' onclick=\"if(confirm('Сигурни ли сте?')) $('delete_ordered_package').setValue(%d); else{ return false;}\" >изтрий</a></td></tr>",$bgcolor, $packageArr[$i]["firm"],$packageArr[$i]["package"],(!eregi('[0_9]',$packageArr[$i]["per_month"])?$packageArr[$i]["per_month"]:$packageArr[$i]["per_year"]), $packageArr[$i]["package_price"] , $i, $i, ($packageArr[$i]["is_payed"]==1)?'checked':'', $packageArr[$i]["id"], $packageArr[$i]["firm_id"], $packageArr[$i]["id"], $packageArr[$i]["firm_id"],  $i, $i, ($packageArr[$i]["active"]==1)?'checked':'', $packageArr[$i]["id"],  $packageArr[$i]["firm_id"], $packageArr[$i]["id"], $packageArr[$i]["firm_id"], ($packageArr[$i]["tree_days"]==0 && $packageArr[$i]["is_payed"]==0)?'red':$bgcolor , $packageArr[$i]["start_date"], ($packageArr[$i]["expired"]==0)?'orange':$bgcolor , $packageArr[$i]["end_date"], $packageArr[$i]["id"]);
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
<fieldset style="float:left; margin:20px;width:800px;">
      <legend onclick=" Effect.toggle($('editDIV'),'Appear');">&nbsp;Редактиране на MySecondHome Пакети&nbsp;</legend>

      
<div id="editDIV" style="margin:10px;">

<div style="margin:10px;">
 <fieldset>
<legend>Добави Нов MySecondHome Пакет</legend>       
            
	<a href="edit_msh_packages.php" target="_self">Добави нов пакет</a>
 </fieldset>
</div>

         
<div style="margin:10px;">
<fieldset >
<legend>Пакети на MySecondHome за Агенции и Строители</legend>          
            <?php
               $sql = "SELECT id, name, months FROM msh_packages";
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
 <div style="width:740px; float:left;">
     <div style="float:left;width:200px;margin:2px 2px 2px 2px;padding:5px;background-color:#FF6600;font-weight:900;"><a style="color:#000000; text-decoration:none;" href=javascript:void(0); ><?=$resultPackages[$i]['name']." (".$resultPackages[$i]['months']." месеца)"?></a></div>
     <div align="center" style="float:left;width:80px;margin:2px 2px 2px 2px;padding:5px;background-color:<?=$bgcolor?>;"><a href='edit_msh_packages.php?package_id=<?=$resultPackages[$i]['id']?>' >Редактирай</a></div>
     <div align="center" style="float:left;width:60px;margin:2px 2px 2px 2px;padding:5px;background-color:<?=$bgcolor?>;"><a href='javascript:document.itemform.submit();' onclick="if(confirm('Сигурни ли сте?')) $('delete_package').setValue(<?=$resultPackages[$i]['id']?>); else{ return false;}" >изтрий</a></div>
	         
	
     
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
</form>

</body>
</html>