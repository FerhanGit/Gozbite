<?php
	
	
	include("../inc/dblogin.inc.php");
	print_r($_REQUEST);exit;
?>	



<form name='itemform' action="" method='post' enctype = 'multipart/form-data'>

<div id = "content" style="width:400px">
   <fieldset style="width:400px">
      <legend>&nbsp;Таргетирани връзки&nbsp;</legend>
      <div style = "padding: 15px;">Административен инструмент за автоматизирано управление на таргетирани връзки.<br /><br /></div>
   
 <?php     
printf("    от <input type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $fromDate);
printf("    до <input type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $toDate);
 ?>      
		<div style = "vertical-align: bottom; margin: 0px 0px 10px 7px; text-align: left;">
          
               <br />	                       
    			  <label class = "txt12" style = "vertical-align: bottom;">Тип Фирма:</label>&nbsp;&nbsp;
    			  <select id = "firm_type" name = "firm_type" title = "избор на тип фирма" style = "width: 197px;" >
                  <option value = "">изберете тип фирма...</option>
                  <option value = "autohouse">Авто къща...</option>
                  <option value = "autoshop">Авто Магазин...</option>
                  </select><br /><br />
 			</div>
 			
 
 
      <div style = "margin: 10px 10px 10px 10px;">
            <br /><label for = "companyID">Фирма:</label>&nbsp;&nbsp;
            <?php
               $sql = "SELECT DISTINCT(ah.id) as 'id', ah.name as 'name', l.name as 'location' FROM auto_houses ah,locations l WHERE ah.location_id=l.id ORDER BY ah.name";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
  		          print "<select name = \"companyID\" id = \"companyID\">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($companyID == $cmpnsArr[$i]["id"]) ? " selected" : ""), $cmpnsArr[$i]["name"]." /офис ".$cmpnsArr[$i]['location']."/");
                  }
                  print "</select>\n";
               }
            ?>
         </div>
         
          <div style = "vertical-align: bottom; margin: 0px 0px 10px 7px; text-align: left;">
		<label class = "txt12" style = "vertical-align: bottom;">Населено място:</label>&nbsp;&nbsp;
         <input type = "hidden" name = "lctnID" id = "lctnID" value = "<?php print (strlen($lctnID) > 0) ? $lctnID : ""; ?>"  />
            <select style="width:200px;" name="cityName" id="cityName" >				
            <option value ="">избери</option>		
             <?php
                $sql = sprintf("SELECT id, name FROM locations WHERE loc_type_id IN (2) ORDER BY name");
                $conn->setSQL($sql);
                $conn->getTableRows();
                $resultCity=$conn->result;
                $numCity = $conn->numberrows;
                if( $numCity> 0) {
               		for($i = 0; $i < $numCity; $i++) 
               		{?>      
					   <option value = "<?=$resultCity[$i]['id']?>" <?php if ($resultCity[$i]['id'] == $resultEdit['location_id']) print "selected";?>><?=$resultCity[$i]['name']?></option> 
							                             
					<?php } 
                                      
                }                                 
                   ?>
                                
                             
             </select>
           </div>                   
                 
          <div style = "vertical-align: bottom; margin: 0 0 10px 7px; text-align: left;">
          <label class = "txt12" style = "vertical-align: bottom;">Марка:</label>&nbsp;&nbsp;
          <select style="width:100px;" name="marka" id="marka" >	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT * FROM marka";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultMarka=$conn->result;
						$numMarka=$conn->numberrows;
						for ($i=0;$i<$numMarka;$i++)
               {?>      
			 	  <option value = "<?=$resultMarka[$i]['id']?>" <?php if ($resultMarka[$i]['id'] == $resultEdit['marka']) print "selected";?>><?=$resultMarka[$i]['name']?></option> 
                             
               <?php } ?>
				  </select>				  
				 </div
          
 			<div style = "vertical-align: bottom; margin: 0 0 10px 7px; text-align: left;">
          
               <br />	                       
    			  <label class = "txt12" style = "vertical-align: bottom;">Действие:</label>&nbsp;&nbsp;
    			  <select id = "action_type" name = "action_type" title = "избор на действие" style = "width: 197px;" >
                  <option value = "">изберете действие...</option>
                  <option value = "1">При търсене...</option>
                  <option value = "2">При предлагане...</option>
                  </select><br /><br />
 			</div>
 			
 			
 			Детайли:<div  id = "details" style = " overflow-y: auto;overflow-x: none; height: 200px; ">                              
             <?php
                             
               $sql = sprintf("SELECT id, name FROM cars_details_list ORDER BY name");
               $conn->setSQL($sql);
               $conn->getTableRows();
               $resultDetails=$conn->result;
               $numDetails = $conn->numberrows;
               if( $numDetails> 0) {
                                       
               	print "	<ul style = \"margin: 0; padding: 0;\">\n";
                for($i = 0; $i < $numDetails; $i++) 
                { 
                 	 	print "<li><input  type = \"checkbox\" id = \"details".$i."\" name = \"details[]\" value = \"". $resultDetails[$i]['id']."\" style = \"border: 0; vertical-align: middle;\"/>&nbsp;<label for = \"details".$i."\" style = \"color: #444; vertical-align: middle;\">". $resultDetails[$i]['name']."</label></li>\n";
                }
                                      
                        print "</ul>\n";
                }                                 
                                 
                                
                ?>
                </div>                            
      
      <br /><br /><br />
      <?php 
	
		
if ((!isset($_POST['companyID']))&&(!isset($_POST['lctnID']))&&(!isset($_POST['start_date']))&&(!isset($_POST['end_date'])))
  
	{   
		
	$sql="SELECT DISTINCT(tl.id) as 'id', ah.name as 'firm_name', IF(tl.action_type=1, 'При търсене', 'При продажби') as 'action_type', l.name as 'location', m.name as 'marka', tl.firm_type as 'firm_type', tl.detail as 'detail', tl.fromD as 'fromD', tl.toD as 'toD'  FROM target_links tl, locations l, auto_houses ah, marka m, cars_details_list cdl WHERE tl.loc_id=l.id AND tl.marka=m.id AND tl.firm_id=ah.id ORDER BY toD"; 
	$conn->setsql($sql);
    $conn->getTableRows();
    $result=$conn->result;
    $num=$conn->numberrows;
  
    print '<div style="overflow:auto; height:400px;width:420px;"><table border="1"><tr bgcolor="#999999"><td><b>Номер</b></td><td><b>Фирма</b></td><td><b>Вид фирма</b></td><td><b>Местоположение</b></td><td><b>Marka</b></td><td><b>Действие</b></td><td><b>Детайли</b></td><td><b>Стартова Дата</b></td><td><b>Крайна Дата</b></td></tr>';
    for ($i=0;$i<$num;$i++)
    {
    
    // -------------------------------- Zaqvkite -----------------------------------------

 		$sql="SELECT id,name FROM  cars_details_list WHERE id IN (".$result[$i]['detail'].")"; 
		$conn->setsql($sql);
   		$conn->getTableRows();
   		$resultDetail=$conn->result; 
   		$numDetail=$conn->numberrows;
   		  		
   		   		   		    	
    // ------------------------------------------------------------------------------------
    	if ($i%2==0)  $bgcolor='#ccff66';
    	else $bgcolor='#ffebd7';
    	?>
    	<tr bgcolor="<?=$bgcolor?>"><td><?php print $i+1;?><a href="?delete=<?=$result[$i]['id']?>"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></td><td><?=$result[$i]['firm_name']?></td><td><?=$result[$i]['firm_type']?></td><td><?=$result[$i]['location']?></td><td><?=$result[$i]['marka']?></td><td><?=$result[$i]['action_type']?></td><td>

 <?php
    	for ($p=0;$p<$numDetail;$p++)
    	{	
   			print $resultDetail[$p]['name']."<br />";
    	} 
    	print "</td><td>".$result[$i]['fromD']."</td><td>".$result[$i]['toD']."</td></tr>";
    	
    }
    print '</table></div>';
    print "<br /><input type='submit' name='vavedi' value='Запиши' />";
	
}
?>
      
   </fieldset>
</div>
</form>
