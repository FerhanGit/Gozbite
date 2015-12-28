<?php

	include_once("../inc/dblogin.inc.php");

?>
<div id="search_form" style="float:left; margin-top:0px; width:420px;">

				    <div style="float:left; margin-left:0px; margin-top:0px; margin-bottom:0px; width:100px;">
					
				  
				  		<input type="image" value="Въведи" src="images/btn_gren.png" id="reg_doctorBtn" title="Въведи" name="reg_doctorBtn" style="float:left;border: 0pt none ; " height="20" type="image" width="96"  onclick="return checkForCorrectData();">
					
				    </div>
				  
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
				  <input type='hidden' name='edit' value='<?=$edit?>'>
				  
				  
				  
				  <br /><br />
				  
				 <div style = "margin: 10px 10px 10px 10px;">
		            <label for = "doctor_category">категории*</label><br>
		            <?php
		               print "     <select name = \"doctor_category[]\" id = \"doctor_category\" multiple size = \"15\" align = \"left\" style = \"margin-right: 10px;\">\n";
		               print "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
		               require_once("../classes/DoctorCategoriesList.class.php");
		               $CCList = new DoctorCategoriesList($conn);
		               if($CCList->load())
		                  $CCList->showSelectMultipleList(0, "", $resultEdtCat?$resultEdtCat:0);
		               print "     </select>\n";
		               print "<span class = \"txt10\">За избор на повече от една категория,<br />натиснете и задръжте клавиша <b>Ctrl</b><br />и изберете с левия бутон на мишката.</span>\n";
		            ?>
		         </div>                           
                   <br /><br /><br style="clear:left;" />     
				  
				<table  border="0" align="center">
				 	<tr>
                        <td align="left" colspan="2">Потребителско Име:</td>                        
                        <td colspan="2"><input type="text" style="width:200px;" name="username" id="username" ></td>                          						
                     </tr>
                     <tr>
                        <td align="right">Парола:</td>                        
                        <td><input type="password" style="width:100px;" name="password" id="password" >	</td>
                        <td align="right">Повтори Паролата:</td>
                        <td><input type="password" style="width:100px;" name="password2" id="password2" >	</td>						
                     </tr>
                     <tr>
                        <td align="right">Име:</td>                        
                        <td><input type="text" style="width:100px;" name="first_name" id="first_name" value = "<?php print (strlen($resultEdit['first_name']) > 0) ? $resultEdit['first_name'] : ""; ?>">
						</td>
                          <td align="right">Фамилия:</td>
                          <td><input type="text" style="width:100px;" name="last_name" id="last_name" value = "<?php print (strlen($resultEdit['last_name']) > 0) ? $resultEdit['last_name'] : ""; ?>">
						</td>						
                     </tr>
                       <br />
                        
                      <tr>
                        <td align="right">Телефон:</td>
                          <td><input type="text" style="width:100px;" name="phone" id="phone" value = "<?php print (strlen($resultEdit['phone']) > 0) ? $resultEdit['phone'] : ""; ?>" >
						</td>
                    	<td align="right">E-mail:</td>
                         <td><input type="text" style="width:100px;" name="email" id="email" value = "<?php print (strlen($resultEdit['email']) > 0) ? $resultEdit['email'] : ""; ?>" >
                         </td>
                      </tr>    
                      
		               
                      <br />
                      
                      <tr>
                        <td align="right">Уеб сраница:</td>                        
                        <td><input type="text" style="width:100px;" name="web" id="web" value = "<?php print (strlen($resultEdit['web']) > 0) ? $resultEdit['web'] : ""; ?>">
						</td>
                          <td align="right">Свързано Здравно Заведение:</td>
                          <td><input type="text" style="width:100px;" name="related_hospital" id="related_hospital" value = "<?php print (strlen($resultEdit['related_hospital']) > 0) ? $resultEdit['related_hospital'] : ""; ?>">
						</td>						
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
                              <td align="right">Адрес:</td>
                         	 <td><textarea rows="3" cols="15" name="address" id="address" ><?php print (strlen($resultEdit['addr']) > 0) ? $resultEdit['addr'] : ""; ?></textarea>
                         </td>                            
                              				   					
    					</tr>
    					<br />                  
                                      
                      
    </table>

						
				 <div style="float:left;margin:10px;margin-left:0px;"> 
				&nbsp;&nbsp;Описание: 
				  <?php 
				 include_once("../FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('info') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '400';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = $resultEdit['info'];
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
                  	
       		 
           		 	<div style="float:left;margin:10px;margin-left:0px;"> 
					 <fieldset style="width:400px">
				        <legend>&nbsp;Код за Сигурност&nbsp;</legend>   
				        <fieldset style="float:left;width:100px"><img src="verificationimage/picture.php" />
				        </fieldset>
							<input style="float:left;width:200px" type="text" name="verificationcode"  value="" />
							<span style="float:left;width:200px">В полето въведете кода показан на картинката.	</span>
                  		</fieldset>
                  	</div>
                  	
                  	
		<input type="image" value="Въведи" src="images/btn_gren.png" id="reg_doctorBtn" title="Въведи" name="reg_doctorBtn" style="float:left;border: 0pt none ; " height="20" type="image" width="96"  onclick="return checkForCorrectData();">
					
 </div>