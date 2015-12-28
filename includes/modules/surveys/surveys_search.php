<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


    require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
	   	
   	$survey_search = "";
	$survey_search .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #6DCA31; padding:5px; background-color:#F1F1F1;">';
   	$survey_search .= '<div style="';
        $survey_search .=(($_REQUEST['search'] != '1')?'':'display:none;');
        $survey_search .= 'margin:10px;"><u><a href=\'javascript:void(0);\' onclick="';
        $survey_search .= 'new Effect.toggle($(\'searchDiv\'),\'Blind\'); if ($(\'searchDiv\').visible()) {$(\'search_div_link\').update(\'Ново търсене\');} else {$(\'search_div_link\').update(\'Скрий търсачката\');}">';
        $survey_search .= '<div id="search_div_link"><u>Ново търсене</u></div></a></u></div>';
        $survey_search .= '<div id="searchDiv" style="margin-top:10px; width:620px;';
        $survey_search .= (($_REQUEST['search'] != '1')?'display:none':'').'" >';

	$survey_search .= ' <div id="fastSearchDiv" style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">					
					<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" >											
				  </div>';
				 
				
        $survey_search .= '<table> 
        <tr><td colspan="2">
				  <div style="margin:10px;margin-left:0px;width:620px;"> 
                        <fieldset style="width:420px;margin-bottom:20px;">
				       <legend>&nbsp;Дата на публикация</legend> <br />  ';      
                        
							$survey_search .= sprintf("    от <input type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $_REQUEST['fromDate']);
							$survey_search .= sprintf("    до <input type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $_REQUEST['toDate']);
$survey_search .= '					   
					    </fieldset>   					 
			 	</div> 
</td></tr>
 				
			 <tr>';
		              
		         $survey_search .= "	
		          <td valign='top'>
			         <table>
			         <tr> 
			              <td style='margin:10px;margin-left:0px;width:300px;'> 		
		                       Ключова дума в текста на Анкетата: <img src='images/help.png' title='offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Ключова дума!] body=[&rarr; Въведене търсена от Вас <span style=\"color:#FF6600;font-weight:bold;\">дума или израз</span> и системата ще извърши търсене за анкети, съдържащи тази <span style=\"color:#FF6600;font-weight:bold;\">дума или израз</span>.]' /><br />  <input type='text' name='search_survey_body' id='search_survey_body'  style='overflow:no;width:300px;' value='".$_REQUEST['survey_body']."' />
			             </td>             
		             </tr> ";		
		         $survey_search .= ' <tr>  
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
                                                <option value="search_survey_body" '.(($_REQUEST['orderby'] == "search_survey_body")?"selected":"").'>Съдържание</option>
                                        </select>
	                   </td>                              
	                </tr>            
                  			
	             </table>
              	</td>	
		      </tr> 
  			  
                         	
			</table>            
                              
		</div></div> <br style="clear:left;"/>';
				
				  
				  	        
		        
	return $survey_search;
	  
	?>

