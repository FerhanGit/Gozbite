<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


    require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
	   	
   	$drink_search = "";
	$drink_search .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
   	$drink_search .= '<div style="';
    $drink_search .=(($_REQUEST['search'] != '1')?'':'display:none;');
    $drink_search .= 'margin:10px;"><u><a href=\'javascript:void(0);\' onclick="';
    $drink_search .= 'new Effect.toggle($(\'searchDiv\'),\'Blind\'); if ($(\'searchDiv\').visible()) {$(\'search_div_link\').update(\'Ново търсене\');} else {$(\'search_div_link\').update(\'Скрий търсачката\');}">';
    $drink_search .= '<div id="search_div_link"><u>Ново търсене</u></div></a></u></div>';
    $drink_search .= '<div id="searchDiv" style="margin-top:10px; width:620px;';
    $drink_search .= (($_REQUEST['search'] != '1')?'display:none':'').'" >';

	
//		 $drink_search .= '<div id="fastSearchDiv" style=" margin-left:0px; margin-top:10px; height:20px; width:100px;">
//								<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" />												
//						   </div>	';
//			
					if (isset($_REQUEST['search_btn']))
					{
						log_search('drink');						
					}
$drink_search .= '
				 
			 		<table>
			             <tr>  
                             
                       <td valign="top">
                       <table>
                        <tr>
                       	 <td>   
						 	<div style="margin:10px;margin-left:0px;width:300px;"> 
			                	<b>Вид Напитка:</b><br/>  
			                	<select  style="width:300px;"  name="drink_category" id="drink_category" onchange="getFastSearchDrinks(document.getElementById(\'drink_category\').value,document.getElementById(\'title\').value);">
								<option value ="">избери</option>';
				          
			                 		$sql="SELECT * FROM drink_category WHERE parentID = 0 ORDER BY  rank, name";
									$conn->setsql($sql);
									$conn->getTableRows();
									$resultCat=$conn->result;
									$numCat=$conn->numberrows;
							
									for ($i=0;$i<$numCat;$i++)
					               	{
					               		$drink_search .= '<option value = "'.($resultCat[$i]['id'].'"   '.(($_REQUEST['drink_category']?$_REQUEST['drink_category']:$_REQUEST['category'])==$resultCat[$i]['id']?'selected':'')).'  >'.$resultCat[$i]['name'].'</option> ';
					          		} 
					          $drink_search .= '
								  </select>
						 	</div>	
						</td> 
                       </tr>
                              		                    
				</table>   
				</td>                 
	             <td style="margin:10px;margin-left:0px;width:300px;"> 
	            	 <b>Ключова дума:</b><img src=\'images/help.png\' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Ключова дума!] body=[&rarr; Въведене търсена от Вас <span style="color:#FF6600;font-weight:bold;">дума или израз</span> и системата ще извърши търсене за напитки, съдържащи тази <span style="color:#FF6600;font-weight:bold;">дума или израз</span>.]\' /><br /><input type="text" style="width:300px;" name="title" id="title" value="'.$_REQUEST['title'].'"  onkeyUp="getFastSearchDrinks(document.getElementById(\'drink_category\').value,document.getElementById(\'title\').value);">
				 </td>    
            </tr>  ';

$drink_search .= '<tr>         
        		<td id = "city" style = " width:300px; margin-right:10px; overflow-y: auto;overflow-x: none;">
                 Подреди по: <br />    
                 	<select style="width:300px;" name="orderby" id="orderby" >
                                <option value="">Избери</option>
                                <option value="updated_on" '.(($_REQUEST['orderby'] == "updated_on")?"selected":"").'>Дата</option>
                                <option value="title" '.(($_REQUEST['orderby'] == "drink_title")?"selected":"").'>Име</option>
                    </select>
               </td>   
                   
                 <td id = "city" style = " width:300px; margin-right:10px; overflow-y: auto;overflow-x: none;">
	                                По колко на страница?: <br />                                           	
				 		<select style="width:50px;" name="limit" id="limit">
				  			<option value="5"  '.(($_REQUEST['limit'] == 5)?"selected":"").' >5</option>
							<option value="10"  '.((!isset($_REQUEST['limit']) OR $_REQUEST['limit'] == 10)?"selected":"").'  >10</option>
							<option value="20"  '.(($_REQUEST['limit'] == 20)?"selected":"").'  >20</option>
							<option value="50"  '.(($_REQUEST['limit'] == 50)?"selected":"").'  >50</option>
							<option value="100"  '.(($_REQUEST['limit'] == 100)?"selected":"").' >100</option>				  			
				  		</select>				  		
	                  </td>                              
             </tr>  
			</table>';   
			
$drink_search .= '<div id="fastSearchDiv" style=" margin-left:0px; margin-top:10px; height:20px; width:100px;">
								<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" />												
						   </div>	';
				       
                              
		$drink_search .= '</div>
				</div>';
				
				  
		$drink_search.= "<script type='text/javascript'>
			jQuery(document).ready(function($) {	   
				getFastSearchDrinks(document.getElementById('drink_category').value,document.getElementById('title').value)
			});
		</script>";

   	  	        
		        
	return $drink_search;
	  
	?>