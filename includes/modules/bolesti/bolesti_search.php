<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


    require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
	   	
   	$bolesti_search = "";
	$bolesti_search .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
   	$bolesti_search .= '<div style="';
    $bolesti_search .=(($_REQUEST['search'] != '1')?'':'display:none;');
    $bolesti_search .= 'margin:10px;"><u><a href=\'javascript:void(0);\' onclick="';
    $bolesti_search .= 'new Effect.toggle($(\'searchDiv\'),\'Blind\'); if ($(\'searchDiv\').visible()) {$(\'search_div_link\').update(\'Ново търсене\');} else {$(\'search_div_link\').update(\'Скрий търсачката\');}">';
    $bolesti_search .= '<div id="search_div_link"><u>Ново търсене</u></div></a></u></div>';
    $bolesti_search .= '<div id="searchDiv" style="margin-top:10px; width:620px;';
    $bolesti_search .= (($_REQUEST['search'] != '1')?'display:none':'').'" >';

//	$bolesti_search .= ' <div id="fastSearchDiv" style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">					
//					<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" >											
//				  </div>';
//				 
					if (isset($_REQUEST['search_btn']))
					{
						log_search('bolest');						
					}
				
        $bolesti_search .= '<table>
			 <tr>
	          	<td style="margin:10px;margin-left:0px;width:300px;" valign="top"> 
		            <label for = "bolest_category">Категория</label><br>';
		           
		               $bolesti_search .=  "     <select name = \"bolest_category\" id = \"bolest_category\"  size = \"12\" align = \"left\" style = \"float:left;width:300px;margin-right: 10px;\" onchange=\"getFastSearchBolesti(document.getElementById('bolest_category').value,document.getElementById('bolest_body').value,getSelectedSimptoms())\" >";
		               $bolesti_search .=  "        <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
		               require_once("includes/classes/BolestCategoriesList.class.php");
		               $CCList = new BolestCategoriesList($conn);
		               if($CCList->load())
							$bolesti_search .= $CCList->showselectlist(0, "", $_REQUEST['bolest_category']?$_REQUEST['bolest_category']:($_REQUEST['category']?$_REQUEST['category']:0));
		               $bolesti_search .=  "     </select>\n";
		              
		         $bolesti_search .= "</td>	
		          <td valign='top'>
			         <table>
			         <tr> 
			              <td style='margin:10px;margin-left:0px;width:300px;'> 		
		                       Ключова дума в описанието на Болеста: <img src='images/help.png' title='offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Ключова дума!] body=[&rarr; Въведене търсена от Вас <span style=\"color:#FF6600;font-weight:bold;\">дума или израз</span> и системата ще извърши търсене за статии, съдържащи тази <span style=\"color:#FF6600;font-weight:bold;\">дума или израз</span>.]' /><br />  <input type='text' name='bolest_body' id='bolest_body'  style='overflow:no;width:300px;' value='".$_REQUEST['bolest_body']."' onkeyUp=\"getFastSearchBolesti(document.getElementById('bolest_category').value,document.getElementById('bolest_body').value,getSelectedSimptoms())\" />
			             </td>             
		             </tr> ";		
		         $bolesti_search .= ' <tr>  
		             <td id = "city" style = " width:300px; margin-right:10px; overflow-y: auto;overflow-x: none;">
	                                По колко на страница?: <br />                                           	
				 		<select style="width:50px;" name="limit" id="limit">
				  			<option value="5"  '.(($_REQUEST['limit'] == 5)?"selected":"").'  selected>5</option>
							<option value="10"  '.((!isset($_REQUEST['limit']) OR $_REQUEST['limit'] == 10)?"selected":"").'  >10</option>
							<option value="20"  '.(($_REQUEST['limit'] == 20)?"selected":"").'  >20</option>
							<option value="50"  '.(($_REQUEST['limit'] == 50)?"selected":"").'  >50</option>
							<option value="100"  '.(($_REQUEST['limit'] == 100)?"selected":"").' >100</option>				  			
				  		</select>				  		
	                  </td>                             
	                  </tr> 		
		              <tr>          
	                  <td id = "city" style = " width:300px; margin-right:10px; overflow-y: auto;overflow-x: none;">
	                             Подреди по: <br />    
	                             	<select style="width:300px;" name="orderby" id="orderby" >
                                                <option value="">Избери</option>
                                                <option value="date" '.(($_REQUEST['orderby'] == "date")?"selected":"").'>Дата</option>
                                                <option value="bolest_title" '.(($_REQUEST['orderby'] == "bolest_title")?"selected":"").'>Заглавие</option>
                                                <option value="bolest_body" '.(($_REQUEST['orderby'] == "bolest_body")?"selected":"").'>Съдържание</option>
                                                <option value="bolest_category" '.(($_REQUEST['orderby'] == "bolest_category")?"selected":"").'>Категория</option>
                                        </select>
	                   </td>                              
	                </tr>            
                  			
	             </table>
	             
	             
	             
	             
	             
	             
	             
	             
	             
	             <br /><br />		
                </td>  
			 </tr> 
			 <tr>
			 <td ALIGN="Left" VALIGN="Top">
				<table><tr><td>
						<fieldset>
                       		<legend>&nbsp;Търси Симптом</legend>
                        
							<div>
								<input type="text" size="30" id="inputString" name="inputString" AUTOCOMPLETE=OFF  onkeyup="if(this.value.length > 2 ) { lookup(this.value);}" value="Търси..." onfocus="if(this.value!=\'Търси...\'){this.value=this.value;} else {this.value=\'\';}" onblur="if(this.value==\'\'){this.value = \'Търси...\';} else {this.value = this.value;}" >
							</div>
							
							<div onclick="$(\'suggestions\').hide();">
								<div class="suggestionsBox" id="suggestions" style="display: none; z-index: 1000; -moz-border-radius:7px; -webkit-border-radius:7px; min-width: 300px;">
									<img src="images/top_arrow.gif" style="position: relative; top: -10px; left: 50px;" alt="upArrow" />
									<div class="suggestionList" id="autoSuggestionsList" style="color:#FFFFFF;"></div>
								</div>
							</div>				
							<!-- KRAI NA TARSACHKATA -->
							<label class = "txt12"><a href="javascript:void(0);" title = "Въведете първите няколко символа и изберете от предложения списък.">Подсказка за Симптоми:</label>&nbsp;<br /><br />
                     						
						 	
							<SELECT NAME="ALL_SIMPTOMS[]" ID="ALL_SIMPTOMS" SIZE="8" MULTIPLE STYLE="width: 290px;" onDblClick="selectselected(ALL_SIMPTOMS,bolest_simptom); selectAllOptions(bolest_simptom); getFastSearchBolesti(document.getElementById(\'bolest_category\').value,document.getElementById(\'bolest_body\').value,getSelectedSimptoms());">';
								
	                             
	                                    $sql = sprintf("SELECT * FROM bolest_simptoms ORDER BY name");
	                                    $conn->setSQL($sql);
	                                    $conn->getTableRows();
	                                    $resultSimptoms=$conn->result;
	                                    $numSimptoms = $conn->numberrows;
	                                    if( $numSimptoms> 0) {                                       
	                                       	 for($i = 0; $i < $numSimptoms; $i++) 
	                                       	 {  
	                                       	 	$bolesti_search .= '<option value = "'.$resultSimptoms[$i]['id'].'"';
		          								if(in_array($resultSimptoms[$i]['id'],is_array($_REQUEST['bolest_simptom'])?$_REQUEST['bolest_simptom']:explode(',',$_REQUEST['bolest_simptom']))) 
		          								{
		         									$bolesti_search .= 'selected'; 
		          								}
		          								$bolesti_search .= '>'.$resultSimptoms[$i]['name'].'</option>';
	                                       	 }                                      
	                                    }   
	                              
						$bolesti_search .= '	</SELECT>	
							
						</fieldset>	
						
						
						</td>
						<td STYLE="width: 40px;" align="right">	
						<br /><br />			
						<INPUT TYPE="Button" VALUE="&gt;&gt;" onClick="selectall(ALL_SIMPTOMS,bolest_simptom);" STYLE="width: 30px;"><br />
						<INPUT TYPE="Button" VALUE="&gt;" onClick="selectselected(ALL_SIMPTOMS,bolest_simptom);" STYLE="width: 30px;"><br /><br />
						<INPUT TYPE="Button" VALUE="&lt;" onClick="removeselected(bolest_simptom);" STYLE="width: 30px;"><br />
						<INPUT TYPE="Button" VALUE="&lt;&lt;" onClick="removeall(bolest_simptom);" STYLE="width: 30px;"><br />
						</td>
						</tr></table>
					</TD>
					<TD ALIGN="Left" VALIGN="Top">
						 <label>Симптоми, които сте забелязали</label><br />
						<SELECT NAME="bolest_simptom[]" ID="bolest_simptom" SIZE="12" MULTIPLE STYLE="width: 290px;" onDblClick="removeselected(bolest_simptom);" onmouseout="selectAllOptions(bolest_simptom); getFastSearchBolesti(document.getElementById(\'bolest_category\').value,document.getElementById(\'bolest_body\').value,getSelectedSimptoms());">';
						
                             
	                         if( $numSimptoms> 0) {                                       
	                           	 for($i = 0; $i < $numSimptoms; $i++) 
	                             {                                         	 
	                 				if(in_array($resultSimptoms[$i]['id'],is_array($_REQUEST['bolest_simptom'])?$_REQUEST['bolest_simptom']:explode(',',$_REQUEST['bolest_simptom']))) 
	                 				{                            					
	                             	 
	                             	 	$bolesti_search .= '<option value = "'.$resultSimptoms[$i]['id'].'" SELECTED >'.$resultSimptoms[$i]['name'].'</option>';
	                             	
	                 				}
	                           	 }                                      
	                         }   
                          
						$bolesti_search .= '</SELECT>
					</td>
		     </tr>
			  <tr>
		     <td colspan="2">
		      <div style = "width:600px;">*За преместване на симптом от едно поле в друго може да щракнете 2 пъти ввърху него.</div><br />
		     </td>
		     </tr> 
			</table>  
			   
	             
	             
	             
	             
	             
	             
              	</td>	
		      </tr> 
  			  
                         	
			</table> ';           
                 

$bolesti_search .= ' <div id="fastSearchDiv" style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">					
					<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" >											
				  </div>';
		
		$bolesti_search .= '</div></div>';
				
		$bolesti_search.= "<script type='text/javascript'>
			jQuery(document).ready(function($) {	   
				getFastSearchBolesti(document.getElementById('bolest_category').value,document.getElementById('bolest_body').value,getSelectedSimptoms())
			});
			</script>";
		
   	  
				  	        
		        
	return $bolesti_search;
	  
	?>