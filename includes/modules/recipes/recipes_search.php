<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


    require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
	   	
    $recipe_search = "";
	$recipe_search .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
   	$recipe_search .= '<div style="';
    $recipe_search .=(($_REQUEST['search'] != '1')?'':'display:none;');
    $recipe_search .= 'margin:10px;"><u><a href=\'javascript:void(0);\' onclick="';
    $recipe_search .= '$(\'#searchDivRecipes\').toggle(\'slow\'); if ($(\'#searchDivRecipes\').is(\':visible\')) {$(\'#search_div_link\').html(\'Ново търсене\');} else {$(\'#search_div_link\').html(\'Скрий търсачката\');}">';
    $recipe_search .= '<div id="search_div_link"><u>Ново търсене</u></div></a></u></div>';
    $recipe_search .= '<div id="searchDivRecipes" style="margin-top:10px; width:620px;';
    $recipe_search .= (($_REQUEST['search'] != '1')?'display:none':'').'" >';

    
	
//		 $recipe_search .= '<div id="fastSearchDiv" style=" margin-left:0px; margin-top:10px; height:20px; width:100px;">
//								<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" />												
//						   </div>	';
			
					if (isset($_REQUEST['search_btn']))
					{
						log_search('recipe');						
					}
$recipe_search .= '
				 
        <table>
            <tr>  
                <td valign="top">
                    <table>
                        <tr>
                            <td>   
						 	<div style="margin:10px;margin-left:0px;width:300px;"> 
			                	<b>Вид Рецепта:</b><br/>  
			                	<select  style="width:300px;"  name="recipe_category" id="recipe_category" onchange="getFastSearchRecipes(document.getElementById(\'recipe_category\').value,document.getElementById(\'title\').value,document.getElementById(\'kuhnq\').value);">
								<option value ="">избери</option>';
				          
			                 		$sql="SELECT * FROM recipe_category WHERE parentID = 0 ORDER BY  rank, name";
									$conn->setsql($sql);
									$conn->getTableRows();
									$resultCat=$conn->result;
									$numCat=$conn->numberrows;
							
									for ($i=0;$i<$numCat;$i++)
					               	{
					               		$recipe_search .= '<option value = "'.($resultCat[$i]['id'].'"   '.(($_REQUEST['recipe_category']?$_REQUEST['recipe_category']:$_REQUEST['category'])==$resultCat[$i]['id']?'selected':'')).'  >'.$resultCat[$i]['name'].'</option> ';
					          		} 
					          $recipe_search .= '
								  </select>
						 	</div>	
                            </td> 
                        </tr>
                    </table>   
				</td>                 
                <td style="margin:10px;margin-left:0px;width:300px;"> 
	            	 <b>Ключова дума:</b><img src=\'images/help.png\' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Ключова дума!] body=[&rarr; Въведене търсена от Вас <span style="color:#FF6600;font-weight:bold;">дума или израз</span> и системата ще извърши търсене за рецепти, съдържащи тази <span style="color:#FF6600;font-weight:bold;">дума или израз</span>.]\' /><br /><input type="text" style="width:300px;" name="title" id="title" value="'.$_REQUEST['title'].'"  onkeyUp="getFastSearchRecipes(document.getElementById(\'recipe_category\').value,document.getElementById(\'title\').value,document.getElementById(\'kuhnq\').value);">
				 </td>    
            </tr>  ';

$recipe_search .= '<tr>         
        		<td id = "city" style = " width:300px; margin-right:10px; overflow-y: auto;overflow-x: none;">
                    <div style="margin:10px;margin-left:0px;width:300px;"> 
                         <b>Национална Кухня:</b><br/>  
                         <select  style="width:300px;"  name="kuhnq" id="kuhnq" onchange="getFastSearchRecipes(document.getElementById(\'recipe_category\').value,document.getElementById(\'title\').value,document.getElementById(\'kuhnq\').value);">
                         <option value ="">избери</option>';

                             $sql="SELECT * FROM kuhni ORDER BY name";
                             $conn->setsql($sql);
                             $conn->getTableRows();
                             $resultKuhni=$conn->result;
                             $numKuhni=$conn->numberrows;

                             for ($i=0;$i<$numKuhni;$i++)
                             {
                                 $recipe_search .= '<option value = "'.($resultKuhni[$i]['id'].'"   '.($_REQUEST['kuhnq'] == $resultKuhni[$i]['id'] ? 'selected' : '')).'  >'.$resultKuhni[$i]['name'].'</option> ';
                             } 
                            $recipe_search .= '
                           </select>
                     </div>	
               </td>   
                   
                <td id = "city" style = " width:300px; margin-right:10px; overflow-y: auto;overflow-x: none;">
                    <table><tr>
                        <td>
                            Подреди по: <br />    
                            <select style="width:100px;" name="orderby" id="orderby" >
                                        <option value="">Избери</option>
                                        <option value="updated_on" '.(($_REQUEST['orderby'] == "updated_on")?"selected":"").'>Дата</option>
                                        <option value="title" '.(($_REQUEST['orderby'] == "recipe_title")?"selected":"").'>Име</option>
                            </select>
                        </td> 
                        <td style="padding-left:50px;">
                            По колко на страница?: <br />                                           	
                            <select style="width:100px;" name="limit" id="limit">
                                <option value="5"  '.(($_REQUEST['limit'] == 5)?"selected":"").' >5</option>
                                <option value="10"  '.((!isset($_REQUEST['limit']) OR $_REQUEST['limit'] == 10)?"selected":"").'  >10</option>
                                <option value="20"  '.(($_REQUEST['limit'] == 20)?"selected":"").'  >20</option>
                                <option value="50"  '.(($_REQUEST['limit'] == 50)?"selected":"").'  >50</option>
                                <option value="100"  '.(($_REQUEST['limit'] == 100)?"selected":"").' >100</option>				  			
                            </select>	
                        </td> 
                    </tr></table>  
                </td>                              
             </tr>  
            
                   
			</table>  ';
                            
                            
        $recipe_search .= '<div id="fastSearchDiv" style=" margin-left:0px; margin-top:10px; height:20px; width:100px;">
                <input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" />												
           </div>	';
			       
                              
		$recipe_search .= '</div>
				</div>';
				
				  
	$recipe_search .= "<script type='text/javascript'>
		jQuery(document).ready(function($) {	   
			getFastSearchRecipes(document.getElementById('recipe_category').value,document.getElementById('title').value,document.getElementById('kuhnq').value)
		}
	);</script>"; 	  	        
		        
	return $recipe_search;
	  
	?>