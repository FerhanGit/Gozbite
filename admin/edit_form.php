<?php
include_once("inc/dblogin.inc.php");

$edit=$_REQUEST['edit'];


if (isset($edit))
{
	$editID=$edit;
	$sql="SELECT * FROM cars WHERE id='".$edit."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultEdit=$conn->result;
	
	
	$sql="SELECT * FROM cars_details WHERE car_id='".$edit."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultDetailsEdit=$conn->result;
    $numDetailsEdit=$conn->numberrows;
	
    if ($resultEdit['has_pic']=='1')
	{
		$sql="SELECT * FROM pics WHERE carID='".$edit."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPics=$conn->result;
		$numPics=$conn->numberrows;
	}
	
}


?>

<div id="search_form" style="float:left; margin-top:0px; width:520px;">

				    <div style="float:left; margin-left:0px; margin-top:0px; margin-bottom:0px; width:100px;">
					
				    <?php if (isset($edit))
				  		{	
				  	?>
				  		<input type="image" value="Редактирай" src="images/btn_gren.png" id="edit_btn" title="Редактирай" name="edit_btn" style="border: 0pt none ; " height="20" type="image" width="96">
				  	
				  	<?php 
				  		}
				  	?>
				  	
				  	<?php if (!isset($edit))
				  		{	
				  	?>
				  		<input type="image" value="Въведи" src="images/btn_gren.png" id="insert_btn" title="Въведи" name="insert_btn" style="border: 0pt none ; " height="20" type="image" width="96">
					
				  	<?php 
				  		}
				  	?>
					  </div>
				  
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
				  <input type='hidden' name='edit' value='<?=$edit?>'>
				<table  border="0" align="center">
		
                      <tr>
                        <td align="right">Марка:</td>                        
                        <td><select style="width:100px;" name="marka" id="marka" onchange = "if(this.value > 0) { getModel('ModelDv', this.value); document.getElementById('ModelDv').focus(); } else { document.getElementById('ModelDv').innerHTML = '';}">
	
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
				  </select></td>				  
                          <td align="right">Модел:</td>
                          <td><div style="float:left;margin:0px;margin-left:0px;" id="ModelDv">
                          <select style="width:100px;" name="model" id="model" >				
                            <option value ="">избери</option>		
                            <?php 
                                    if(isset($edit))
                                    {
                                    $sql="SELECT * FROM model WHERE marka='".$resultEdit['marka']."'";
                                    $conn->setsql($sql);
                                    $conn->getTableRows();
                                    $resultModel=$conn->result;
                                    $numModel=$conn->numberrows;
                                    for ($i=0;$i<$numModel;$i++)
                           {?>      
                              <option value = "<?=$resultModel[$i]['id']?>" <?php if ($resultModel[$i]['id'] == $resultEdit['model']) print "selected";?>><?=$resultModel[$i]['name']?></option> 
                                         
                           <?php }} ?>
                            </select> 
                            </div>
                    	</td>
                    	
                        </tr>
                        <br />
                      <tr>
                        <td align="right">Валута:</td>
                        <td><div style="float:left;margin:0px;margin-left:0px;">  
				  <select style="width:100px;" name="currency" id="currency" >				
				<option value ="">избери</option>		
				<?php 
						
						$sql="SELECT * FROM currency ";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCurrency=$conn->result;
						$numCurrency=$conn->numberrows;
						for ($i=0;$i<$numCurrency;$i++)
						{
               ?>      
			 	  <option value = "<?=$resultCurrency[$i]['id']?>" <?php if ($resultCurrency[$i]['id'] == $resultEdit['currency']) print "selected";?>><?=$resultCurrency[$i]['name']?></option> 
                             
               <?php } ?>
				</select> 
				 </div></td>
                    	<td align="right">Цена:</td>
                        <td><div style="float:left;margin:0px;margin-left:0px;">  
				  <input style="width:100px;" type="text" size="20" value="<?=$resultEdit['price']?>" name="price" id="price" />
				  </div></td>
                      </tr>    
                      <br />                                    
                      <tr>
                        <td align="right">Тип автомобил:</td>
                        <td><div style="float:left;margin:0px;margin-left:0px;"> 
				<select name="avto_type" id="avto_type" style="width:100px;" >
				  <option value="">Избери</option>
				  <?php
                 		$sql="SELECT DISTINCT(name),id FROM avto_type";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultAvtoType=$conn->result;
						$numAvtoType=$conn->numberrows;
						for ($i=0;$i<$numAvtoType;$i++)
               {?>      
			 	  <option value = "<?=$resultAvtoType[$i]['id']?>" <?php if ($resultAvtoType[$i]['id'] == $resultEdit['avto_type']) print "selected";?>><?=$resultAvtoType[$i]['name']?></option> 
                             
               <?php }?>
				  </select>
				   </div></td>
                        <td align="right">Цвят:</td>
                        <td><div style="float:left;margin:0px;margin-left:0px;">
                      	  <select style="width:100px;" name="color" id="color" >
                            <option value="">Избери</option>
                            <?php
                 		$sql="SELECT DISTINCT(name),id FROM color";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultColor=$conn->result;
						$numColor=$conn->numberrows;
						for ($i=0;$i<$numColor;$i++)
               {?>
                            <option value = "<?=$resultColor[$i]['id']?>" <?php if ($resultColor[$i]['id'] == $resultEdit['color']) print "selected";?>>
                              <?=$resultColor[$i]['name']?>
                            </option>
                            <?php }?>
                          </select>
                      	</div></td>
                      </tr>
                      <br />
                      <tr>
                        <td align="right">Гориво:</td>
                      	<td><div style="float:left;margin:0px;margin-left:0px;"> 
					<select style="width:100px;" name="fuel" id="fuel" >
				  <option value="">Избери</option>
				  <?php
                 		$sql="SELECT DISTINCT(name),id FROM fuel";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultFuel=$conn->result;
						$numFuel=$conn->numberrows;
						for ($i=0;$i<$numFuel;$i++)
               {?>      
			 	  <option value = "<?=$resultFuel[$i]['id']?>" <?php if ($resultFuel[$i]['id'] == $resultEdit['fuel']) print "selected";?>><?=$resultFuel[$i]['name']?></option> 
                             
               <?php }?>
				  </select>
				   </div></td>
                      	<td align="right">Пробег до:</td>
                      	<td><div style="float:left;margin:0px;margin-left:0px;"> 
				 <input style="width:100px;" type="text" size="20" value="<?php if ($resultEdit['probeg']) print $resultEdit['probeg'];?>"  name="probeg" id="probeg" /> км.
				</div></td>
                      </tr>  
                      <br />    
                      
                       <tr>    	
                    				
    					<td colspan="2" align="left">Населено място:
                              <div id = "city" style = "float:left; width:200px; margin-right:10px; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
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
                              </td>
                              
                              
                              <td colspan="2" align="left">Детайли:
                              <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none; height: 200px; border: 1px solid #cccccc;">
                              
                               <?php
                             
                                 
                                    $sql = sprintf("SELECT id, name FROM cars_details_list ORDER BY name");
                                    $conn->setSQL($sql);
                                    $conn->getTableRows();
                                    $resultDetails=$conn->result;
                                    $numDetails = $conn->numberrows;
                                    if( $numDetails> 0) {
                                       
                                       	print "	<ul style = \"margin: 0; padding: 0;\">\n";
                                       	 for($i = 0; $i < $numDetails; $i++) 
                                       	 { ?>
                                       	 	<li><input  type = "checkbox" id = "details<?=$i?>" name = "details[]" value = "<?=$resultDetails[$i]['id']?>" <?php for ($p=0;$p<$numDetailsEdit;$p++) if ($resultDetailsEdit[$p]['detail_id']==$resultDetails[$i]['id']) {print "checked";} else print "";?>  style = "border: 0; vertical-align: middle;"/>&nbsp;<label for = "details<?=$i?>" style = "color: #444; vertical-align: middle;"><?=$resultDetails[$i]['name']?></label></li>
                                       	 <?php }
                                      
                                         print "</ul>\n";
                                    }                                 
                                 
                                
                              ?>
                              </div>                              
                              </td>
                                 					   					
    					</tr>
    					<br />                  
                                      
                      
    </table>

						
				 <div style="float:left;margin:10px;margin-left:0px;"> 
				&nbsp;&nbsp;Описание: 
				  <?php 
				 include_once("FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('description') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '480';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = $resultEdit['description'];
		         $oFCKeditor->Create();
			?> 
				   </div>
				   
					<div style="float:left;margin:10px;margin-left:0px;"> 
					 <fieldset style="width:200px">
				        <legend>&nbsp;Снимки&nbsp;</legend>   
							<input type = "file" name = "pics[]">
	                  		<input type = "file" name = "pics[]">
	                  		<input type = "file" name = "pics[]">
	                  		<input type = "file" name = "pics[]">
	                  		<input type = "file" name = "pics[]">
                  		</fieldset>
                  	</div>
                  	
                  	<div style="float:left;margin-top:18px;margin-left:10px;">
        <?php
			  if ($resultEdit['has_pic']=='1')
			  {  print "<div style='float:left; margin:0px; height:276px; width:200px;' >";
				  for ($i=0;$i<$numPics;$i++)
				  { 
		?>        			
	       			<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60" onclick = "get_pic('big_pic', '<?=$resultPics[$i]['url_big']?>' ); "  src="../pics/cars/<?php if($resultEdit['has_pic']=='1') print $resultPics[$i]['url_thumb']; else print "no_photo_thumb.png";?>" />
	       			</div>
	       			<div style="float:left;cursor:pointer;" >
	       			<a href="?deletePic=<?=$resultPics[$i]['url_big']?>"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
	       			</div>
	     <?php 
				  }
				  print "</div>";
			}
         ?>
           		 	</div>				  
				 
           		 	
 </div>