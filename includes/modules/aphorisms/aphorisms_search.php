<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


    require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
	   	
   	$aphorisms_search = "";
	$aphorisms_search .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
   	$aphorisms_search .= '<div style="';
        $aphorisms_search .=(($_REQUEST['search'] != '1')?'':'display:none;');
        $aphorisms_search .= 'margin:10px;"><u><a href=\'javascript:void(0);\' onclick="';
        $aphorisms_search .= 'new Effect.toggle($(\'searchDiv\'),\'Blind\'); if ($(\'searchDiv\').visible()) {$(\'search_div_link\').update(\'Ново търсене\');} else {$(\'search_div_link\').update(\'Скрий търсачката\');}">';
        $aphorisms_search .= '<div id="search_div_link"><u>Ново търсене</u></div></a></u></div>';
        $aphorisms_search .= '<div id="searchDiv" style="margin-top:10px; width:620px;';
        $aphorisms_search .= (($_REQUEST['search'] != '1')?'display:none':'').'" >';

//	$aphorisms_search .= ' <div id="fastSearchDiv" style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">					
//					<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" >											
//				  </div>';
//				 
				
        $aphorisms_search .= '<table><tr>
             	<td colspan="2">
                        <fieldset style="width:620px;margin-bottom:20px;">
                               <legend>&nbsp;Дата на публикация</legend> <br /> ';       
                          
                                $aphorisms_search .= sprintf("  от <input onfocus=\"getFastSearchAphorisms(document.getElementById('aphorism_body').value, document.getElementById('fromDate').value, document.getElementById('toDate').value)\"  onKeyUp=\"getFastSearchAphorisms(document.getElementById('aphorism_body').value, document.getElementById('fromDate').value, document.getElementById('toDate').value)\" type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $_REQUEST['fromDate']);
                                $aphorisms_search .= sprintf("  до <input onfocus=\"getFastSearchAphorisms(document.getElementById('aphorism_body').value, document.getElementById('fromDate').value, document.getElementById('toDate').value)\"  onKeyUp=\"getFastSearchAphorisms(document.getElementById('aphorism_body').value, document.getElementById('fromDate').value, document.getElementById('toDate').value)\" type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $_REQUEST['toDate']);
					     
	$aphorisms_search .= ' </fieldset>   
			 	</td>
			 </tr>    
  				  				
			 <tr>';
		              
		         $aphorisms_search .= "	
		          <td valign='top'>
			         <table>
			         <tr> 
			              <td style='margin:10px;margin-left:0px;width:300px;'> 		
		                       Ключова дума в текста на Афоризма: <img src='images/help.png' title='offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Ключова дума!] body=[&rarr; Въведене търсена от Вас <span style=\"color:#FF6600;font-weight:bold;\">дума или израз</span> и системата ще извърши търсене за афоризми, съдържащи тази <span style=\"color:#FF6600;font-weight:bold;\">дума или израз</span>.]' /><br />  <input type='text' name='aphorism_body' id='aphorism_body'  style='overflow:no;width:300px;' value='".$_REQUEST['aphorism_body']."' onkeyUp=\"getFastSearchAphorisms(document.getElementById('aphorism_body').value, document.getElementById('fromDate').value, document.getElementById('toDate').value)\" />
			             </td>             
		             </tr> ";		
		         $aphorisms_search .= ' <tr>  
		             <td id = "city" style = " width:300px; margin-right:10px; overflow-y: auto;overflow-x: none;">
	                                По колко на страница?: <br />                                           	
				 		<select style="width:50px;" name="limit" id="limit" >
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
                                                <option value="aphorism_title" '.(($_REQUEST['orderby'] == "aphorism_title")?"selected":"").'>Източник</option>
                                                <option value="aphorism_body" '.(($_REQUEST['orderby'] == "aphorism_body")?"selected":"").'>Съдържание</option>
                                        </select>
	                   </td>                              
	                </tr>            
                  			
	             </table>
              	</td>	
		      </tr> 
  			                           	
			</table>';
                  

$aphorisms_search .= ' <div id="fastSearchDiv" style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">					
					<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" >											
				  </div>';
	
		$aphorisms_search .= '</div></div> <br style="clear:left;"/>';
				
				  
				  	        
		        
	return $aphorisms_search;
	  
	?>
