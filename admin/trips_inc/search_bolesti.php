<?php
include_once("../inc/dblogin.inc.php");

?>



<div style="float:left; margin-top:10px; width:420px;color:#FF0000;">

				    <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
					<input type="image" value="Търси" src="images/btn_red.png" id="search_btn" title="търси" name="search_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
											
				  </div>				  			  				  				  
				
                      <fieldset style="width:380px;margin-bottom:0px;">
				       <legend>&nbsp;Дата на публикация&nbsp;</legend>        
                       <?php     
							printf("    от <input type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $fromDate);
							printf("    до <input type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $toDate);
					   ?>   
					    </fieldset>   
				  
	<div style="float:left; margin-left:0px; margin-top:0px; margin-bottom:0px;">
								  
   <table style="margin:0px;">						
				<tr>
                      	<td align="right">Раздел:</td>
                        <td colspan="3">
                       	 <select name="bolest_category" id="bolest_category" onchange="getSubCats(this.value);">
						<option value ="">избери</option>
		               <?php
		                 		$sql="SELECT id,name FROM bolest_category WHERE parentID = 0 ORDER BY name";
								$conn->setsql($sql);
								$conn->getTableRows();
								$resultCat=$conn->result;
								$numCat=$conn->numberrows;
						
								for ($i=0;$i<$numCat;$i++)
				               {?>      
							 	  <option value = "<?=$resultCat[$i]['id']?>"   <?=$_REQUEST['bolest_category']==$resultCat[$i]['id']?'selected':''?>  ><?=$resultCat[$i]['name']?></option> 
				                             
				               <?php } ?>
						  </select>
				
				 	
				 	  
				    <div id="SubCatsDiv"> </div>
                        </td>
                    </tr>
				 <br /> <br />
				 <tr>
                      	<td align="right">Ключова дума в заглавието на Болеста:</td>
                        <td colspan="3"><input type="text" name="bolest_title" id="bolest_title"  style="overflow:no;width:200px;" /></td>
                    </tr>
				 <br /> <br />
				 <tr>
                      	<td align="right">Ключова дума в текста на Болеста:</td>
                        <td colspan="3"><input type="text" name="bolest_body" id="bolest_body"  style="overflow:no;width:200px;" /></td>
                    </tr>
				 <br /> <br />

				 <tr>
                      	<td align="right">Автор на Болеста:</td>
                        <td colspan="3"><input type="text" name="bolest_autor" id="bolest_autor"  style="overflow:no;width:200px;" /></td>
                    </tr>
				 <br /> <br />	
				 
				 <tr>
                      	<td align="right">Ключова дума в източника на Болеста:</td>
                        <td colspan="3"><input type="text" name="bolest_source" id="bolest_source"  style="overflow:no;width:200px;" /></td>
                    </tr>
				 <br /> <br />		 
				 						 
						<tr>    					
    					<td colspan="2" align="left">По колко на страница?:
                              <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                                <select style="width:100px;" name="limit" id="limit" >
					  				<option value="">Избери</option>
					  				<option value="5">5</option>
					  				<option value="10">10</option>
					  				<option value="20">20</option>
					  				<option value="50">50</option>
					  				<option value="100">100</option>				  			
				  				</select>
                              </div>                             
                              </td>
                              
                              
                              <td colspan="2" align="left">Подреди по:
                              <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                                <select style="width:100px;" name="orderby" id="orderby" >
					  				<option value="">Избери</option>
					  				<option value="date">Дата</option>
					  				<option value="nеws_autor">Автор</option>
					  				<option value="nеws_title">Заглавие</option>
					  				<option value="nеws_body">Съдържание</option>
					  				<option value="nеws_category">Категория</option>
					  				<option value="nеws_source">Източник</option>
					  				
					  			</select>
                              </div>                              
                              </td>
                                 					   					
    					</tr>
    					<br />
    					<tr>
    					 <td colspan="4" align="left">Симптоми:
                              <div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none; height: 200px;width: 200px; border: 1px solid #cccccc;">
                              
                               <?php
                             
                                 
                                    $sql = sprintf("SELECT * FROM bolest_simptoms ORDER BY name");
                                    $conn->setSQL($sql);
                                    $conn->getTableRows();
                                    $resultSimptoms=$conn->result;
                                    $numSimptoms = $conn->numberrows;
                                    if( $numSimptoms> 0) {
                                       
                                       	print "	<ul style = \"margin: 0; padding: 0;\">\n";
                                       	 for($i = 0; $i < $numSimptoms; $i++) 
                                       	 { ?>
                                       	 	<li><input  type = "checkbox" id = "bolest_simptom<?=$i?>" name = "bolest_simptom[]" value = "<?=$resultSimptoms[$i]['id']?>" style = "border: 0; vertical-align: middle;"/>&nbsp;<label for = "bolest_simptom<?=$i?>" style = "color: #444; vertical-align: middle;"><?=$resultSimptoms[$i]['name']?></label></li>
                                       	 <?php }
                                      
                                         print "</ul>\n";
                                    }                                 
                                 
                                
                              ?>
                              </div>                              
                              </td>
    						
    					</tr>
				  </table>

							  
				 
				</div>
				
				 
				   
				<br />  
				<div style="float:left;margin:10px;margin-left:0px;"> 
					Само със снимки <input type="checkbox" name="picCheck" id="picCheck">
				</div>
				
          
	 </div>
				  
				  