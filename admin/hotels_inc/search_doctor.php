<?php

	include_once("../inc/dblogin.inc.php");
?>


<div style="<?=$_REQUEST['search_btn'] == 'Търси'?'':'display:none'?>"><a href="javascript:void(0);" onclick=" new Effect.toggle($('searchDiv'),'Blind'); ">Корекция на търсенето</a></div>
<div id="searchDiv" style="float:left; margin-top:10px; width:420px;<?=$_REQUEST['search_btn'] == 'Търси'?'display:none':''?>" >

	
		         <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
			
				    <input type="hidden" name="search_btn" value="" />
					<input type="image" value="Търси" src="images/btn_search_green.png" onclick="$('search_btn').setValue('Търси');$('search_form').action='doctors.php'" id="search_btn" title="търси" name="search_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
											
				  </div>
				  <div style="float:left;margin:10px;margin-left:0px;width:420px;"> 
                       <fieldset style="float:left;width:420px;margin-bottom:20px;">
				       <legend>&nbsp;Дата на публикация<br /></legend>        
                       <?php     
							printf("    от <input type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $fromDate);
							printf("    до <input type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $toDate);
					   ?>   
					    </fieldset>   

					<div style="margin:10px;margin-left:0px;width:200px;"> 
	                	Категория:<br/>  <select name="doctor_category" id="doctor_category" onchange="getSubCats(this.value);">
						<option value ="">избери</option>
		               <?php
		                 		$sql="SELECT id,name FROM doctor_category WHERE parentID = 0 ORDER BY name";
								$conn->setsql($sql);
								$conn->getTableRows();
								$resultCat=$conn->result;
								$numCat=$conn->numberrows;
						
								for ($i=0;$i<$numCat;$i++)
				               {?>      
							 	  <option value = "<?=$resultCat[$i]['id']?>"   <?=$_REQUEST['doctor_category']==$resultCat[$i]['id']?'selected':''?>  ><?=$resultCat[$i]['name']?></option> 
				                             
				               <?php } ?>
						  </select>
				
				 	</div>	
				 	  
				    <div id="SubCatsDiv"> </div>
                   
                   
			 </div> 
			 <div style="float:left;margin:10px;margin-left:0px;width:420px;">  	  
	             <div style="float:left;margin:10px;margin-left:0px;width:200px;"> 
	            	 Наименование:<br /><input type="text" style="width:200px;" name="firm_name" id="firm_name" value="<?=$_REQUEST['firm_name']?>">
				 </div>
	  		 
	             <div style="float:left;margin:10px;margin-left:0px;width:200px;"> 		
	             	Управител:<br /><input type="text" style="width:200px;" name="manager" id="manager" value="<?=$_REQUEST['manager']?>">
				 </div>             
             </div> 
  			  <div style="float:left;margin:10px;margin-left:0px;width:420px;">  
	             <div style="float:left;margin:10px;margin-left:0px;width:200px;"> 		
	            	 Телефон:<br /><input type="text" style="width:200px;" name="phone" id="phone" value="<?=$_REQUEST['phone']?>">
				  </div>             
	             <div style="float:left;margin:10px;margin-left:0px;width:200px;"> 	
	             	E-mail:<br /><input type="text" style="width:200px;" name="email" id="email" value="<?=$_REQUEST['email']?>">
                 </div>
              </div>   
             <div style="float:left;margin:10px;margin-left:0px;width:420px;">         
	            
                              <div id = "city" style = "float:left; width:200px; margin-right:10px; overflow-y: auto;overflow-x: none;">
                             Населено място: <br /> <input type = "hidden" name = "lctnID" id = "lctnID" value = "<?php print (strlen($lctnID) > 0) ? $lctnID : ""; ?>"  />
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
                        <div style="float:left;margin:10px;margin-left:0px;width:200px;">       
                              Адрес:<br /><textarea rows="3" cols="15" name="address" id="address" style="width:200px;"><?=$_REQUEST['address']?></textarea>
                         </div>
                   </div>
                   <div style="float:left;margin:10px;margin-left:0px;width:420px;">         
	            		 <div style="float:left;margin:10px;margin-left:0px;width:200px;">       
                        	 Ключова дума:<br /><input type="text" name="description"  style="overflow:no;width:200px;"  value="<?=$_REQUEST['description']?>"/>
                   		 </div>
                            
                         <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none;">
                                По колко на страница?:<br /> <select style="width:200px;" name="limit" id="limit" >
					  				<option value="">Избери</option>
					  				<option value="5"  <?=($_REQUEST['limit'] == 5)?'selected':''?> >5</option>
									<option value="10"  <?=($_REQUEST['limit'] == 10)?'selected':''?> >10</option>
									<option value="20"  <?=($_REQUEST['limit'] == 20)?'selected':''?> >20</option>
									<option value="50"  <?=($_REQUEST['limit'] == 550)?'selected':''?> >50</option>
									<option value="100"  <?=($_REQUEST['limit'] == 100)?'selected':''?> >100</option>				  			
				  				</select>
                              </div>                              
                     </div>  

                     <div style="float:left;margin:10px;margin-left:0px;width:420px;">         
	            	        <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none;">
                               Подреди по:<br /> <select style="width:200px;" name="orderby" id="orderby" >
					  				<option value="">Избери</option>
					  				<option value="cityName">Местоположение</option>
					  				<option value="firm_name">Наименование</option>
					  				<option value="phone">Телефон</option>
					  				<option value="manager">Управител</option>
					  				<option value="address">Адрес</option>
					  				<option value="email">email</option>
					  				<option value="phone">Телефон</option>
					  				<option value="registered_on">Дата на регистрация</option>
					  				<option value="population">Популярност</option>
					  			</select>
                              </div> 
                                                           
                            <div style="float:left;margin:10px;margin-left:0px;"> 
							&nbsp;&nbsp;Снимки <input type="checkbox" name="picCheck" id="picCheck">
							</div>       
				</div>             
                              
		</div>
				  
				  