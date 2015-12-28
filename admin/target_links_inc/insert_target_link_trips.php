<?php
	
	
	include("../inc/dblogin.inc.php");
	
?>	



<form name='itemform' action="" method='post' enctype = 'multipart/form-data'>

<div id = "content" style="width:400px">
   <fieldset style="width:400px">
      <legend>&nbsp;Таргетирани връзки&nbsp; - Екскурзии</legend>
      <div style = "padding: 15px;">Административен инструмент за автоматизирано управление на таргетирани връзки.<br /><br /></div>
    Датите, Категорията, Локацията и Транспорта са задължутелни!
 <?php     
printf("    от <input type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $fromDate);
printf("    до <input type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $toDate);
 ?>      
		 
 
		
           
       <div style = "margin: 10px 10px 10px 10px;">
            <br /><label for = "firmID">Агенция/Превозвач:</label>&nbsp;&nbsp;
            <?php
               $sql = "SELECT DISTINCT(f.id) as 'id', f.name as 'name', l.name as 'location' FROM firms f, locations l WHERE f.location_id=l.id ORDER BY f.name";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
  		          print "<select name = \"firmID\" id = \"firmID\">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($firmID == $cmpnsArr[$i]["id"]) ? " selected" : ""), $cmpnsArr[$i]["name"]." /офис ".$cmpnsArr[$i]['location']."/");
                  }
                  print "</select>\n";
               }
            ?>
         </div>
         
         
          <div style = "margin: 10px 10px 10px 10px;">
            <br /><label for = "hotelID">Хотел:</label>&nbsp;&nbsp;
            <?php
               $sql = "SELECT DISTINCT(h.id) as 'id', h.name as 'name', l.name as 'location' FROM hotels h, locations l WHERE h.location_id = l.id ORDER BY name";
               $conn->setsql($sql);
               $conn->getTableRows();
               $cmpnsArr   = $conn->result;
               $cCmpnsArr  = $conn->numberrows;
               if($cCmpnsArr > 0) {
  		          print "<select name = \"hotelID\" id = \"hotelID\">\n";
                  print "  <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
                  for($i = 0; $i < $cCmpnsArr; $i++) {
                     printf(" <option value = \"%d\"%s>%s</option>\n", $cmpnsArr[$i]["id"], (($hotelID == $cmpnsArr[$i]["id"]) ? " selected" : ""), $cmpnsArr[$i]["name"]." /офис ".$cmpnsArr[$i]['location']."/");
                  }
                  print "</select>\n";
               }
            ?>
         </div>
         
   
   
                    
 			 			
 			Категории:<div  id = "category" style = "width:200px; overflow-y: auto;overflow-x: none;">  
 			<select style="width:200px;" name="trip_category" id="trip_category" >				
            <option value ="">избери</option>		                            
             <?php
                             
               $sql = sprintf("SELECT id, name FROM trip_category ORDER BY name");
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
      <br />  <br />  <br />
                
               Транспорт:<div  id = "transportDiv" style = "width:200px; overflow-y: auto;overflow-x: none;">  
 			<select style="width:200px;" name="transport" id="transport" >				
            <option value ="">избери</option>		                            
             <?php
                             
               $sql = sprintf("SELECT id, name FROM transports ORDER BY name");
               $conn->setSQL($sql);
               $conn->getTableRows();
               $resultTransports=$conn->result;
               $numTransports = $conn->numberrows;
               if( $numTransports> 0) {
                                       
                for($i = 0; $i < $numTransports; $i++) 
                { 
                ?>
                		<option value = "<?=$resultTransports[$i]['id']?>" ><?=$resultTransports[$i]['name']?></option> 
				<?php   
                }
                                      
                       
                }                                 
                                 
                                
                ?>
                </select>                            
      
      <br /><br /><br />
      
      
         Дестинация:<div  id = "loc_id_DIV" style = "width:200px; overflow-y: auto;overflow-x: none;">  
 			<select style="width:200px;" name="loc_id" id="loc_id" >				
            <option value ="">избери</option>		                            
             <?php
                             
               $sql = sprintf("SELECT id, name FROM locations WHERE loc_type_id IN (2, 16, 4, 19) ORDER BY name"); // Samo gradovete, kurorti i sela
               $conn->setSQL($sql);
               $conn->getTableRows();
               $resultLocations=$conn->result;
               $numLocations = $conn->numberrows;
               if( $numLocations> 0) {
                                       
                for($i = 0; $i < $numLocations; $i++) 
                { 
                ?>
                		<option value = "<?=$resultLocations[$i]['id']?>" ><?=$resultLocations[$i]['name']?></option> 
				<?php   
                }
                                      
                       
                }                                 
                                 
                                
                ?>
                </select>                            
      
      <br /><br /><br />
      <?php 
	
		
if ((!isset($_POST['loc_ic']))&&(!isset($_POST['start_date']))&&(!isset($_POST['end_date'])))
{   
		
	$sql="SELECT DISTINCT(tl.id) as 'id', tl.category as 'category', tl.firm_id as 'firm', tl.hotel_id as 'hotel', tl.loc_id as 'location', l.name as 'location_name',  lt.name as 'locType', tl.transport_type as 'transport_type', tl.fromD as 'fromD', tl.toD as 'toD'  FROM target_links_trips tl, transports tr, trip_category tc, locations l, location_types lt  ORDER BY toD"; 
	$conn->setsql($sql);
    $conn->getTableRows();
    $result=$conn->result;
    $num=$conn->numberrows;
  
      print "<br /><input type='submit' name='vavedi' value='Запиши' />";
    print '<div style="overflow:auto; height:400px;width:420px;"><table border="1"><tr bgcolor="#999999"><td><b>Номер</b></td><td><b>Агенция/Превозвач</b></td><td><b>Хотел</b></td><td><b>Категория</b></td><td><b>Дестинация</b></td><td><b>Транспорт</b></td><td><b>Стартова Дата</b></td><td><b>Крайна Дата</b></td></tr>';
    for ($i=0;$i<$num;$i++)
    {
    
    // -------------------------------- Zaqvkite -----------------------------------------

 		$sql="SELECT id,name FROM trip_category WHERE id IN (".$result[$i]['category'].")"; 
		$conn->setsql($sql);
   		$conn->getTableRows();
   		$resultCategory=$conn->result; 
   		$numCategory=$conn->numberrows;
   		  		
   		
   		$sql="SELECT id,name FROM transports WHERE id IN (".$result[$i]['transport_type'].")"; 
		$conn->setsql($sql);
   		$conn->getTableRows();
   		$resultTransports=$conn->result; 
   		$numTransports=$conn->numberrows;
		
		
		$sql="SELECT name FROM firms WHERE id = '".$result[$i]['firm']."'"; 
		$conn->setsql($sql);
   		$conn->getTableRow();
   		$firmName=$conn->result['name']; 
		
		$sql="SELECT name FROM hotels WHERE id = '".$result[$i]['hotel']."'"; 
		$conn->setsql($sql);
   		$conn->getTableRow();
   		$hotelName=$conn->result['name']; 
   		
   		  		
   		   		   		    	
    // ------------------------------------------------------------------------------------
    	if ($i%2==0)  $bgcolor='#ccff66';
    	else $bgcolor='#ffebd7';
    	?>
    	<tr bgcolor="<?=$bgcolor?>"><td><?php print $i+1;?><a onclick="if(!confirm('Сигурни ли сте?')) {return false;}" href="?delete=<?=$result[$i]['id']?>"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></td>
		<td><?=$firmName?$firmName:' --- '?></td><td><?=$hotelName?$hotelName:' --- '?></td><td>
 <?php
    	for ($p=0;$p<$numCategory;$p++)
    	{	
   			print $resultCategory[$p]['name']."<br />";
    	} 
    	
    	print "</td><td>".$result[$i]['location_name']."</td><td>";
    	
    	for ($p=0;$p<$numTransports;$p++)
    	{	
   			print $resultTransports[$p]['name']."<br />";
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
