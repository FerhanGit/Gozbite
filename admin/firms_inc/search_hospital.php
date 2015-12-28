<?php

include_once("../inc/dblogin.inc.php");
?>


<div style="float:left; margin-top:10px; width:420px;color:#009900; ">

				    <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
			
				    <input type="hidden" name="search_btn" value="" />
					<input type="image" value="Търси" src="images/btn_search_green.png" onclick="$('search_btn').setValue('Търси');$('search_form').action='hospitals.php'" id="search_btn" title="търси" name="search_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
											
				  </div>
				  <br /><br /><br />
				  			  				  				  
				
                      <fieldset style="width:380px">
				       <legend>&nbsp;Дата на публикация&nbsp;</legend>        
                       <?php     
							printf("    от <input type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $fromDate);
							printf("    до <input type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $toDate);
					   ?>   
					    </fieldset>   
				  		<br />  <br />  
				  		Категория:  <select name="hospital_category" id="hospital_category" onchange="getSubCats(this.value);">>
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT id,name FROM hospital_category WHERE parentID = 0 ORDER BY name";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCat=$conn->result;
						$numCat=$conn->numberrows;
						for ($i=0;$i<$numCat;$i++)
               {?>      
			 	  <option value = "<?=$resultCat[$i]['id']?>"><?=$resultCat[$i]['name']?></option> 
                             
               <?php } ?>
				  </select>

				   <div id="SubCatsDiv"> </div>
				   
				   				  
   					<table  border="0" align="center">
				     <tr>
                        <td align="right">Наименование:</td>                        
                        <td><input type="text" style="width:100px;" name="firm_name" id="firm_name" >
						</td>
                          <td align="right">Управител:</td>
                          <td><input type="text" style="width:100px;" name="manager" id="manager" >
						</td>						
                     </tr>
                     
                        <br />
                        
                      <tr>
                        <td align="right">Телефон:</td>
                          <td><input type="text" style="width:100px;" name="phone" id="phone" >
						</td>
                    	<td align="right">E-mail:</td>
                         <td><input type="text" style="width:100px;" name="email" id="email" >
                         </td>
                      </tr>    
                      
                      <br />     
                                          
                    <tr>    	
                    				
    					<td colspan="2" align="left">Населено място:
                              <div id = "city" style = " width:200px; margin-right:10px; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
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
                              
                             <td align="right">Адрес:</td>
                         	 <td><textarea rows="3" cols="15" name="address" id="address" ></textarea>
                         </td>                            
                                 					   					
    					</tr>
    					<br />                  
                       
                    <tr>
                      	<td align="right">Ключова дума:</td>
                        <td colspan="3"><input type="text" name="description"  style="overflow:no;width:250px;" /></td>
                    </tr>
                    <br />
                    
                    <tr>    					
    					<td colspan="2" align="left">По колко на страница?:
                              <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                                <select style="width:100px;" name="limit" id="limit" >
					  				<option value="">Избери</option>
					  				<option value="5"  <?=($_REQUEST['limit'] == 5)?'selected':''?> >5</option>
									<option value="10"  <?=($_REQUEST['limit'] == 10)?'selected':''?> >10</option>
									<option value="20"  <?=($_REQUEST['limit'] == 20)?'selected':''?> >20</option>
									<option value="50"  <?=($_REQUEST['limit'] == 550)?'selected':''?> >50</option>
									<option value="100"  <?=($_REQUEST['limit'] == 100)?'selected':''?> >100</option>					  			
				  				</select>
                              </div>                              
                              </td>
                              
                              
                              <td colspan="2" align="left">Подреди по:
                              <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                                <select style="width:100px;" name="orderby" id="orderby" >
					  				<option value="">Избери</option>
					  				<option value="cityName">Местоположение</option>
					  				<option value="firm_name">Наименование</option>
					  				<option value="hospital_category">Категория</option>
					  				<option value="phone">Телефон</option>
					  				<option value="manager">Управител</option>
					  				<option value="address">Адрес</option>
					  				<option value="email">email</option>
					  				<option value="phone">Телефон</option>
					  				<option value="registered_on">Дата на регистрация</option>
					  			</select>
                              </div>                              
                              </td>
                                 					   					
    					</tr>
    				    					
    			</table>
    			

		</div>
				  
				  