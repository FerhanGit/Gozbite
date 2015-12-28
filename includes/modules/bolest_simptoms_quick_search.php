<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/



	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
   	$bolest_simptoms_quick_search = "";
	
	
   	
   		$bolest_simptoms_quick_search .= '<div class="boxRight main_same_height_first_line">
			<div class="title" style="margin-bottom:0px">Провери Здравето си</div>
			 <div class="contentBox_first_line">
		    	<p>
		    	<table><tr>
				 <td ALIGN="Left" VALIGN="Top">
					<table><tr><td>
						 <label>Симптоми, които сте забелязали</label><br /><br />
						 
					 		<div>
								<input type="text" size="30" id="inputString" name="inputString" AUTOCOMPLETE=OFF  onkeyup="if(this.value.length > 2 ) { lookupHomePage(this.value);}" value="Търси..." onfocus="if(this.value!=\'Търси...\'){this.value=this.value;} else {this.value=\'\';}" onblur="if(this.value==\'\'){this.value = \'Търси...\';} else {this.value = this.value;}" >
							</div>
							
						<div onclick="$(\'suggestions\').hide();">
							<div class="suggestionsBox" id="suggestions" style="display: none; z-index: 1000; -moz-border-radius:7px; -webkit-border-radius:7px; min-width: 300px;">
								<img src="images/top_arrow.gif" style="position: relative; top: -10px; left: 50px;" alt="upArrow" />
								<div class="suggestionList" id="autoSuggestionsList" style="color:#FFFFFF;"></div>
							</div>
						</div>				
						
						<label class = "txt12"><a href="javascript:void(0);" title = "Въведете първите няколко символа и изберете от предложения списък.">Подсказка за Симптоми:</label>&nbsp;<br /><br />
                     			
                     				
						<SELECT NAME="bolest_simptom" ID="bolest_simptom"  SIZE="12"  STYLE="width: 290px;" onclick="document.searchform.action =\'разгледай-болести,характерен_симптом_\'+this.options[this.selectedIndex].text+\'.html\'; document.searchform.submit();" >';
                                    
									$sql = sprintf("SELECT * FROM bolest_simptoms ORDER BY name");
                                    $conn->setSQL($sql);
                                    $conn->getTableRows();
                                    $resultSimptoms=$conn->result;
                                    $numSimptoms = $conn->numberrows;
                                    if( $numSimptoms> 0) {                                       
                                       	 for($i = 0; $i < $numSimptoms; $i++) 
                                       	 {  
                                       	 	$bolest_simptoms_quick_search .= '<option value = "'.$resultSimptoms[$i]['id'].'"';
                                       	 	if(in_array($resultSimptoms[$i]['id'],is_array($_REQUEST['bolest_simptom'])?$_REQUEST['bolest_simptom']:explode(',',$_REQUEST['bolest_simptom']))) 
                                       	 	{
                                       	 		$bolest_simptoms_quick_search .= '\'selected\''; 
                                       	 	}
                                       	 	$bolest_simptoms_quick_search .= '>'.$resultSimptoms[$i]['name'];
                                       	 	$bolest_simptoms_quick_search .= '</option>';
                                       	 }                                      
                                    }   
                            
						$bolest_simptoms_quick_search .='</SELECT>	
						<input type="hidden" value="Търси" id="search_btn" name="search_btn" />
						</td>
						</tr></table>
					</TD>					
		     </tr></table>
	    	</p>			
		 </div>
	</div>';
   
   	
		
	return $bolest_simptoms_quick_search;
	  
	?>
