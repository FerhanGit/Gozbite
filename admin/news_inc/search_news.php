<?php
include_once("../inc/dblogin.inc.php");

?>


<div style="float:left; margin-top:10px; width:420px;">

				    <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
					<input type="image" value="Търси" src="images/btn_blue.png" id="search_btn" title="търси" name="search_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
											
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
				Раздел:  <select name="news_category" id="news_category" onchange="getSubCats(this.value);">
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT * FROM news_category WHERE parentID = 0 ORDER BY name";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCat=$conn->result;
						$numCat=$conn->numberrows;
						for ($i=0;$i<$numCat;$i++)
               {?>      
			 	  <option value = "<?=$resultCat[$i]['id']?>"><?=$resultCat[$i]['name']?></option> 
                             
               <?php } ?>
				  </select>
				  <br /> <br />
				 
				  <div id="SubCatsDiv"> </div>
				   <br /> <br />
				  
   <table>						
				<tr>
                      	<td align="right">Ключова дума в заглавието на Новината:</td>
                        <td colspan="3"><input type="text" name="news_title" id="news_title"  style="overflow:no;width:200px;" /></td>
                    </tr>
				 <br /> <br />
				 <tr>
                      	<td align="right">Ключова дума в текста на Новината:</td>
                        <td colspan="3"><input type="text" name="news_body" id="news_body"  style="overflow:no;width:200px;" /></td>
                    </tr>
				 <br /> <br />

				 <tr>
                      	<td align="right">Автор на Статията:</td>
                        <td colspan="3"><input type="text" name="nеws_autor" id="nеws_autor"  style="overflow:no;width:200px;" /></td>
                    </tr>
				 <br /> <br />	
				 
				 <tr>
                      	<td align="right">Ключова дума в източника на Статията:</td>
                        <td colspan="3"><input type="text" name="nеws_source" id="nеws_source"  style="overflow:no;width:200px;" /></td>
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
    						
				  </table>

							  
				 
				
				
				 
				   
				<br />  
				<div style="float:left;margin:10px;margin-left:0px;"> 
					&nbsp;&nbsp;Снимки <input type="checkbox" name="picCheck" id="picCheck">
					
				
          
	 </div>
				  
				  