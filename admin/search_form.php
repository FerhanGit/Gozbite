<?php
include_once("inc/dblogin.inc.php");

?>


<div id="search_form" style="float:left; margin-top:10px; width:520px;">

				    <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
					<input type="image" value="Търси" src="images/btn_blue.png" id="search_btn" title="търси" name="search_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
											
				  </div>
				  <br /><br /><br />
				  			  				  				  
				
                      <fieldset style="width:480px">
				       <legend>&nbsp;Дата на публикация&nbsp;</legend>        
                       <?php     
							printf("    от <input type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $fromDate);
							printf("    до <input type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $toDate);
					   ?>   
					    </fieldset>   
				  		<br />  				  
    <table  border="0" align="center">
    			    				
                      <tr>
                        <td align="right">Марка:</td>                        
                        <td><select style="float:left;width:100px;" name="marka" id="marka" onchange = "if(this.value > 0) { getModel('ModelDv', this.value); document.getElementById('ModelDv').focus(); } else { document.getElementById('ModelDv').innerHTML = '';}">
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT * FROM marka";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultMarka=$conn->result;
						$numMarka=$conn->numberrows;
						for ($i=0;$i<$numMarka;$i++)
               {?>      
			 	  <option value = "<?=$resultMarka[$i]['id']?>" <?php if ($resultMarka[$i]['id'] == $_REQUEST['marka']) print "selected";?>><?=$resultMarka[$i]['name']?></option> 
                             
               <?php } ?>
				  </select></td>
                          <td align="right">Модел:</td>
                          <td><div style="float:left;margin:0px;margin-left:0px;" id="ModelDv">
                              <select style="width:100px;" name="model" id="model" >				
                            <option value ="">избери</option>		
                            <?php 
                                   
                                    $sql="SELECT * FROM model WHERE marka='".$_REQUEST['marka']."'";
                                    $conn->setsql($sql);
                                    $conn->getTableRows();
                                    $resultModel=$conn->result;
                                    $numModel=$conn->numberrows;
                                    for ($i=0;$i<$numModel;$i++)
                           {?>      
                              <option value = "<?=$resultModel[$i]['id']?>" <?php if ($resultModel[$i]['id'] == $_REQUEST['model']) print "selected";?>><?=$resultModel[$i]['name']?></option> 
                                         
                           <?php } ?>
                            </select> 
                    </div></td>
                        </tr>
                       
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
			 	  <option value = "<?=$resultCurrency[$i]['id']?>" <?php if ($resultCurrency[$i]['id'] == $_REQUEST['currency']) print "selected";?>><?=$resultCurrency[$i]['name']?></option> 
                             
               <?php } ?>
				</select> 
				 </div></td>
                    	<td align="right">Цена:</td>
                        <td><div style="float:left;margin:0px;margin-left:0px;">  
				  <input style="width:100px;" type="text" size="20" value="<?php if ($_REQUEST['price']) print $_REQUEST['price'];?>" name="price" id="price" />
				  </div></td>
                      </tr>    
                                                       
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
			 	  <option value = "<?=$resultAvtoType[$i]['id']?>" <?php if ($resultAvtoType[$i]['id'] == $_REQUEST['avto_type']) print "selected";?>><?=$resultAvtoType[$i]['name']?></option> 
                             
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
                            <option value = "<?=$resultColor[$i]['id']?>" <?php if ($resultColor[$i]['id'] == $_REQUEST['color']) print "selected";?>>
                              <?=$resultColor[$i]['name']?>
                            </option>
                            <?php }?>
                          </select>
                      	</div></td>
                      </tr>
                      
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
			 	  <option value = "<?=$resultFuel[$i]['id']?>" <?php if ($resultFuel[$i]['id'] == $_REQUEST['fuel']) print "selected";?>><?=$resultFuel[$i]['name']?></option> 
                             
               <?php }?>
				  </select>
				   </div></td>
                      	<td align="right">Пробег до:</td>
                      	<td><div style="float:left;margin:0px;margin-left:0px;"> 
				 <input style="width:100px;" type="text" size="20" value="<?php if ($resultEdit['probeg']) print $_REQUEST['probeg'];?>"  name="probeg" id="probeg" /> км.
				</div></td>
                   </tr>                                    
                      
                   <br />           
                    <tr>    					
    					<td colspan="2" align="left">Населено място:
                              <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none; height: 200px; border: 1px solid #cccccc;">
                              <input type = "hidden" name = "lctnID" id = "lctnID" value = "<?php print (strlen($lctnID) > 0) ? $lctnID : ""; ?>"  />
                             <input type = "hidden" id = "q" name = "q" value = "" />
                               <?php
                             
                                 
                                    $sql = sprintf("SELECT id, name FROM locations WHERE loc_type_id IN (2) ORDER BY name");
                                    $conn->setSQL($sql);
                                    $conn->getTableRows();
                                    $resultCity=$conn->result;
                                    $numCity = $conn->numberrows;
                                    if( $numCity> 0) {
                                       
                                       	print "	<ul style = \"margin: 0; padding: 0;\">\n";
                                       	 for($i = 0; $i < $numCity; $i++) 
                                       	 { 
                                       	 	
                                       	 	 printf("<li><input type = \"checkbox\" id = \"cityName%d\" name = \"cityName[%d]\" value = \"%d\" style = \"border: 0; vertical-align: middle;\"%s />&nbsp;<label for = \"cityName%d\" style = \"color: #444; vertical-align: middle;\">%s</label></li>\n", $i, $resultCity[$i]["id"], $resultCity[$i]["id"], (($_REQUEST['cityName'][$resultCity[$i]["id"]]) ? " checked" : ""), $i, $resultCity[$i]["name"]);
                                       	
                                       	 }
                                      
                                         print "</ul>\n";
                                    }                                 
                                 
                                
                              ?>
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
                                       	 { 
                                       	 	 printf("<li><input type = \"checkbox\" id = \"details%d\" name = \"details[%d]\" value = \"%s\" style = \"border: 0; vertical-align: middle;\"%s />&nbsp;<label for = \"details%d\" style = \"color: #444; vertical-align: middle;\">%s</label></li>\n", $i, $resultDetails[$i]["id"], $resultDetails[$i]["name"], (($_REQUEST['details'][$resultDetails[$i]["id"]]) ? " checked" : ""), $i, $resultDetails[$i]["name"]);
                                       	 	
                                       	 }
                                      
                                         print "</ul>\n";
                                    }                                 
                                 
                                
                              ?>
                              </div>                              
                              </td>
                                 					   					
    					</tr>
						<br />
    				<tr>
                      	<td align="right">Ключова дума:</td>
                        <td colspan="3"><input type="text" name="description"  style="overflow:no;width:270px;" /></td>
                    </tr>
                       
                    <br />      
                    <tr>    					
    					<td colspan="2" align="left">По колко на страница?:
                              <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                                <select style="width:100px;" name="limit" id="limit" >
					  				<option value="">Избери</option>
					  				<option value="5" <?php if ($_REQUEST['limit'] == '5') print "selected";?>>5</option>
					  				<option value="10" <?php if ($_REQUEST['limit'] == '10') print "selected";?>>10</option>
					  				<option value="20" <?php if ($_REQUEST['limit'] == '20') print "selected";?>>20</option>
					  				<option value="50" <?php if ($_REQUEST['limit'] == '50') print "selected";?>>50</option>
					  				<option value="100" <?php if ($_REQUEST['limit'] == '100') print "selected";?>>100</option>				  			
				  				</select>
                              </div>                              
                              </td>                                                            
                              <td colspan="2" align="left">Подреди по:
                              <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                                <select style="width:100px;" name="orderby" id="orderby" >
					  				<option value="">Избери</option>
					  				<option value="price" <?php if ($_REQUEST['orderby'] == 'price') print "selected";?>>Цена</option>
					  				<option value="date" <?php if ($_REQUEST['orderby'] == 'date') print "selected";?>>Дата</option>
					  				<option value="marka" <?php if ($_REQUEST['orderby'] == 'marka') print "selected";?>>Марка</option>
					  				<option value="date_made" <?php if ($_REQUEST['orderby'] == 'date_made') print "selected";?>>Година на производство</option>
					  				<option value="population" <?php if ($_REQUEST['orderby'] == 'population') print "selected";?>>Популярност</option>
					  			</select>
                              </div>                              
                              </td>
                                 					   					
    					</tr>
    				   					
    </table>

			 
				   
<br />  
				<div style="float:left;margin:10px;margin-left:0px;"> 
					&nbsp;&nbsp;Само обяви със снимки <input type="checkbox" name="picCheck" id="picCheck">
							
           		 </div>					  
				 
				  </div>
				  
				  