<?php
	
	
	include("../inc/dblogin.inc.php");
	
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
		 
 		 <div style = "margin: 10px 10px 10px 10px;">
            <br /><label for = "doctorID">Лекар:</label>&nbsp;&nbsp;
            <?php
               $sql = "SELECT DISTINCT(d.id) as 'id', CONCAT(d.first_name,' ',d.last_name) as 'name', l.name as 'location' FROM doctors d,locations l WHERE d.location_id=l.id ORDER BY name";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
  		          print "<select name = \"doctorID\" id = \"doctorID\">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($companyID == $cmpnsArr[$i]["id"]) ? " selected" : ""), $cmpnsArr[$i]["name"]." /".$cmpnsArr[$i]['location']."/");
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
                 
         
                    
 			 			
 			Категории:<div  id = "category" style = "width:200px; overflow-y: auto;overflow-x: none;">  
 			<select style="width:200px;" name="doctor_category" id="doctor_category" >				
            <option value ="">избери</option>		                            
             <?php
                             
               $sql = sprintf("SELECT id, name FROM doctor_category ORDER BY name");
               $conn->setSQL($sql);
               $conn->getTableRows();
               $resultCategorys=$conn->result;
               $numCategorys = $conn->numberrows;
               if( $numCategorys> 0) {
                                       
                for($i = 0; $i < $numCategorys; $i++) 
                { 
                ?>
                		<option value = "<?=$resultCategorys[$i]['id']?>" ><?=$resultCategorys[$i]['name']?></option> 
				<?php   
                }
                                      
                       
                }                                 
                                 
                                
                ?>
                </select>
                </div>                            
                       
      
      <br /><br /><br />
      <?php 
	
		
if ((!isset($_POST['doctorID']))&&(!isset($_POST['lctnID']))&&(!isset($_POST['start_date']))&&(!isset($_POST['end_date'])))
{   
		
	$sql="SELECT DISTINCT(tl.id) as 'id', CONCAT(d.first_name,' ',d.last_name) as 'doctor', l.name as 'location', tl.category as 'category', tl.fromD as 'fromD', tl.toD as 'toD'  FROM target_links_doctors tl, locations l, doctors d, doctor_category dc WHERE l.id=tl.loc_id AND tl.doctor_id=d.id AND dc.id=tl.category ORDER BY toD"; 
	$conn->setsql($sql);
    $conn->getTableRows();
    $result=$conn->result;
    $num=$conn->numberrows;
  
    print '<div style="overflow:auto; height:400px;width:420px;"><table border="1"><tr bgcolor="#999999"><td><b>Номер</b></td><td><b>Лекар</b></td><td><b>Населено място</b></td><td><b>Категория</b></td><td><b>Стартова Дата</b></td><td><b>Крайна Дата</b></td></tr>';
    for ($i=0;$i<$num;$i++)
    {
    
    // -------------------------------- Zaqvkite -----------------------------------------

 		$sql="SELECT id,name FROM doctor_category WHERE id IN (".$result[$i]['category'].")"; 
		$conn->setsql($sql);
   		$conn->getTableRows();
   		$resultCategory=$conn->result; 
   		$numCategory=$conn->numberrows;
   		  		
   		
   		
   		   		   		    	
    // ------------------------------------------------------------------------------------
    	if ($i%2==0)  $bgcolor='#ccff66';
    	else $bgcolor='#ffebd7';
    	?>
    	<tr bgcolor="<?=$bgcolor?>"><td><?php print $i+1;?><a onclick="if(!confirm('Сигурни ли сте?')) {return false;}" href="?delete=<?=$result[$i]['id']?>"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></td><td><?=$result[$i]['doctor']?></td><td><?=$result[$i]['location']?></td><td>

 <?php
    	for ($p=0;$p<$numCategory;$p++)
    	{	
   			print $resultCategory[$p]['name']."<br />";
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
