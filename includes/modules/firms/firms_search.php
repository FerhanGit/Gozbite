<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


    require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
	   	
   	$firms_search = "";
	$firms_search .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
	<div style="'.(($_REQUEST['search'] != '1')?'':'display:none;').'margin:10px;"><u><a href="javascript:void(0);" onclick=" new Effect.toggle($(\'searchDiv\'),\'Blind\'); if ($(\'searchDiv\').visible()) {$(\'search_div_link\').update(\'Ново търсене\');} else {$(\'search_div_link\').update(\'Скрий търсачката\');}"><div id="search_div_link"><u>Ново търсене</u></div></a></u></div>
<div id="searchDiv" style="margin-top:10px; width:620px;'.(($_REQUEST['search'] != '1')?'display:none':'').'" >';

	
//            $firms_search .= '<div id="fastSearchDiv" style=" margin-left:0px; margin-top:10px; height:20px; width:100px;">
//						<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" >												
//				 </div>';	
	
					if (isset($_REQUEST['search_btn']))
					{
						log_search('firm');						
					}
			
				$firms_search .= '<table>
			   
             <tr>         
             
              		<td style = " width:320px; margin-right:10px; overflow-y: auto;overflow-x: none;">
                            <fieldset style="width:300px;margin-bottom:20px; margin-top:0px; padding-top:10px; padding-bottom:10px;">
                            <legend>&nbsp;<b>Населено място*</b>   <a href=\'#\' id=\'destinaciq\' style=\'z-index:1000;\'><img src=\'images/help.png\' /></a></legend>
                            
                           		<div>
									<input type="text" size="30" id="inputString" AUTOCOMPLETE=OFF  name="inputString" onkeyup="if(this.value.length > 2 ) { lookupLocation(this.value);}" value="Търси..." onfocus="if(this.value!=\'Търси...\'){this.value=this.value;} else {this.value=\'\';}" onblur="if(this.value==\'\'){this.value = \'Търси...\';} else {this.value = this.value;}" >
								</div>
								
								<div class="suggestionsBox" id="suggestions" style="display: none; z-index: 1000; -moz-border-radius:7px; -webkit-border-radius:7px;" onclick=" hidemsgArea();">
									<img src="images/top_arrow.gif" style="position: relative; top: -10px; left: 50px;" alt="upArrow" />
									<div class="suggestionList" id="autoSuggestionsList" style="color:#FFFFFF;" onchange="getFastSearchFirms(document.getElementById(\'firm_category\').value,document.getElementById(\'firm_name\').value,document.getElementById(\'manager\').value,document.getElementById(\'phone\').value,document.getElementById(\'email\').value,document.getElementById(\'cityName\').value,document.getElementById(\'description\').value);" onmouseout="hidemsgArea();"></div>
								</div>				
								<!-- KRAI NA TARSACHKATA -->
								<label class = "txt12"><a href="javascript:void(0);" title = "Въведете първите няколко символа и изберете от предложения списък.">Подсказка за населеното място:</a></label>&nbsp;<br /><br />';
                            		
								
                               
					               $firms_search .=  "     <select name = \"cityName\" id = \"cityName\" size = \"15\" align = \"left\" style = \"float:left;width:280px;margin-right: 10px;\" onchange=\"getFastSearchFirms(document.getElementById('firm_category').value,document.getElementById('firm_name').value,document.getElementById('manager').value,document.getElementById('phone').value,document.getElementById('email').value,document.getElementById('cityName').value,document.getElementById('description').value);\" >";
					               $firms_search .=  "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
					              // printf(" <option value = \"14880\" %s>&nbsp; Обиколен маршрут </option>",((14880 == $_REQUEST['cityName']) ? " selected" : ""));
               					    require_once("includes/classes/FirmLocationsListSearch.class.php");
					               $CCList = new FirmLocationsList($conn);
					               if($CCList->load())
					                  $firms_search .= $CCList->showselectlist(0, "", $_REQUEST['cityName']?$_REQUEST['cityName']:0);
					               $firms_search .= "     </select>\n";
					          
                           		
                              $firms_search .= '	
                           		 <div style = "width:300px;">*Показани са само населените места с налични заведения/фирми.</div>
		     
                              </fieldset>
                       </td>                
                       
                                                          
                       <td style="margin:10px;padding-left:10px;width:300px;"  valign="top" >       
					         <table>
					         <tr>
				 <td> 
				  <b>Категория:</b> <br /> <select name="firm_category" id="firm_category" style="width:300px;" onchange="getFastSearchFirms(document.getElementById(\'firm_category\').value,document.getElementById(\'firm_name\').value,document.getElementById(\'manager\').value,document.getElementById(\'phone\').value,document.getElementById(\'email\').value,document.getElementById(\'cityName\').value,document.getElementById(\'description\').value)">
	 				<option value ="">избери</option>';
	              
	                 		$sql="SELECT * FROM firm_category WHERE parentID = 0 ORDER BY rank, name";
							$conn->setsql($sql);
							$conn->getTableRows();
							$resultCat=$conn->result;
							$numCat=$conn->numberrows;
							for ($i=0;$i<$numCat;$i++)
			                {    
						 	  $firms_search .= ' <option value = "'.$resultCat[$i]['id'].'"   '.(($_REQUEST['firm_category']?$_REQUEST['firm_category']:$_REQUEST['category'])==$resultCat[$i]['id']?'selected':'').'  >'.$resultCat[$i]['name'].'</option> ';
			                             
			             	} 
	              $firms_search .= ' 
					  </select>
				</td>
			</tr>
			 <tr>
			 	<td style="margin:10px;margin-left:0px;width:300px;"> 
					 <b>Наименование:</b><br /><input type="text" style="width:300px;" name="firm_name" id="firm_name" value="'.$_REQUEST['firm_name'].'" onkeyUp="getFastSearchFirms(document.getElementById(\'firm_category\').value,document.getElementById(\'firm_name\').value,document.getElementById(\'manager\').value,document.getElementById(\'phone\').value,document.getElementById(\'email\').value,document.getElementById(\'cityName\').value,document.getElementById(\'description\').value)" >
				 </td>
			</tr>
			 <tr>
	             <td style="margin:10px;margin-left:0px;width:300px;"> 		
					 <b>Лице за контакти:</b><br /><input type="text" style="width:300px;" name="manager" id="manager"  value="'.$_REQUEST['manager'].'" onkeyUp="getFastSearchFirms(document.getElementById(\'firm_category\').value,document.getElementById(\'firm_name\').value,document.getElementById(\'manager\').value,document.getElementById(\'phone\').value,document.getElementById(\'email\').value,document.getElementById(\'cityName\').value,document.getElementById(\'description\').value)" >
				 </td>             
             </tr> 
  			  <tr>  
	             <td style="margin:10px;margin-left:0px;width:300px;"> 		
					 <b>Телефон:</b><br /><input type="text" style="width:300px;" name="phone" id="phone"  value="'.$_REQUEST['phone'].'" onkeyUp="getFastSearchFirms(document.getElementById(\'firm_category\').value,document.getElementById(\'firm_name\').value,document.getElementById(\'manager\').value,document.getElementById(\'phone\').value,document.getElementById(\'email\').value,document.getElementById(\'cityName\').value,document.getElementById(\'description\').value)" >
				  </td>  
			</tr>
			 <tr>           
	             <td style="margin:10px;margin-left:0px;width:300px;"> 	
					<b>E-mail:</b><br /><input type="text" style="width:300px;" name="email" id="email"  value="'.$_REQUEST['email'].'" onkeyUp="getFastSearchFirms(document.getElementById(\'firm_category\').value,document.getElementById(\'firm_name\').value,document.getElementById(\'manager\').value,document.getElementById(\'phone\').value,document.getElementById(\'email\').value,document.getElementById(\'cityName\').value,document.getElementById(\'description\').value)" >
                 </td>
              </tr> 
              
							   <tr>         
			            		 <td style="margin:10px;margin-left:0px;width:300px;">       
							          <b>Ключова дума:</b><br /><input type="text" name="description" id="description"  style="overflow:no;width:300px;"  value="'.$_REQUEST['description'].'" onkeyUp="getFastSearchFirms(document.getElementById(\'firm_category\').value,document.getElementById(\'firm_name\').value,document.getElementById(\'manager\').value,document.getElementById(\'phone\').value,document.getElementById(\'email\').value,document.getElementById(\'cityName\').value,document.getElementById(\'description\').value)" />
		                   		 </td>
		                   	</tr>
		                    <tr> 
		                         <td  id = "city" style = " overflow-y: auto;overflow-x: none;">
		                                 <b>По колко на страница?:</b><br /> <select style="width:200px;" name="limit" id="limit" >
							  				<option value="">Избери</option>
							  				<option value="5"  '.(($_REQUEST['limit'] == 5)?'selected':'').' >5</option>
											<option value="10"  '.(($_REQUEST['limit'] == 10)?'selected':'').' >10</option>
											<option value="20"  '.(($_REQUEST['limit'] == 20)?'selected':'').' >20</option>
											<option value="50"  '.(($_REQUEST['limit'] == 550)?'selected':'').' >50</option>
											<option value="100"  '.(($_REQUEST['limit'] == 100)?'selected':'').' >100</option>				  			
						  				</select>
		                              </td>                              
		                     </tr>
		                     <tr>         
			            	        <td  id = "city" style = " overflow-y: auto;overflow-x: none;">
		                               <b>Подреди по:</b><br /> <select style="width:300px;" name="orderby" id="orderby" >
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
		                              </td> 
		                      </tr>
		                     
					      </table>

						</td>
                   </tr>
                   </table>'; 
                       

        $firms_search .= '<div id="fastSearchDiv" style=" margin-left:0px; margin-top:10px; height:20px; width:100px;">
						<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" >												
				 </div>';
                     
		$firms_search .= '</div>
		</div>
		<br style="clear:left;"/>';
		     
		        
		        
	$firms_search .= "<script type='text/javascript'>
		jQuery(document).ready(function($) { getFastSearchFirms(document.getElementById('firm_category').value,document.getElementById('firm_name').value,document.getElementById('manager').value,document.getElementById('phone').value,document.getElementById('email').value,document.getElementById('cityName').value,document.getElementById('description').value);	
		});
	</script>";

   
	return $firms_search;
	  
	?>