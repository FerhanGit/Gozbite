<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


    require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
	   	
   	$posts_search = "";
	$posts_search .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #6DCA31; padding:5px; background-color:#F1F1F1;">';
   	$posts_search .= '<div style="';
        $posts_search .=(($_REQUEST['search'] != '1')?'':'display:none;');
        $posts_search .= 'margin:10px;"><u><a href=\'javascript:void(0);\' onclick="';
        $posts_search .= 'new Effect.toggle($(\'searchDiv\'),\'Blind\'); if ($(\'searchDiv\').visible()) {$(\'search_div_link\').update(\'Ново търсене\');} else {$(\'search_div_link\').update(\'Скрий търсачката\');}">';
        $posts_search .= '<div id="search_div_link"><u>Ново търсене</u></div></a></u></div>';
        $posts_search .= '<div id="searchDiv" style="margin-top:10px; width:620px;';
        $posts_search .= (($_REQUEST['search'] != '1')?'display:none':'').'" >';

	$posts_search .= ' <div id="fastSearchDiv" style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">					
					<input type="submit" value="Търси" id="search_btn" title="търси" name="search_btn" >											
				  </div>';
				 
					if (isset($_REQUEST['search_btn']))
					{
						log_search('post');						
					}
				
        $posts_search .= '<table><tr>
             	<td colspan="2">
                        <fieldset style="float:left;width:620px;margin-bottom:20px;">
                               <legend>&nbsp;Дата на публикация</legend> <br /> ';       
                          
                                $posts_search .= sprintf("    от <input onfocus=\"getFastSearchPosts(document.getElementById('post_category').value,document.getElementById('post_body').value,document.getElementById('fromDate').value,document.getElementById('toDate').value)\" onkeyUp=\"getFastSearchPosts(document.getElementById('post_category').value,document.getElementById('post_title').value,document.getElementById('post_body').value,document.getElementById('fromDate').value,document.getElementById('toDate').value)\"  type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $_REQUEST['fromDate']);
                                $posts_search .= sprintf("    до <input onfocus=\"getFastSearchPosts(document.getElementById('post_category').value,document.getElementById('post_body').value,document.getElementById('fromDate').value,document.getElementById('toDate').value)\" onkeyUp=\"getFastSearchPosts(document.getElementById('post_category').value,document.getElementById('post_title').value,document.getElementById('post_body').value,document.getElementById('fromDate').value,document.getElementById('toDate').value)\" type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $_REQUEST['toDate']);
					     
	$posts_search .= ' </fieldset>   
			 	</td>
			 </tr>    
  				
			 <tr>
	          	<td style="margin:10px;margin-left:0px;width:300px;" valign="top"> 
		            <label for = "post_category">Категория</label><br>';
		           
		               $posts_search .=  "     <select name = \"post_category\" id = \"post_category\"  size = \"12\" align = \"left\" style = \"float:left;width:300px;margin-right: 10px;\" onchange=\"getFastSearchPosts(this.value,document.getElementById('post_body').value,document.getElementById('fromDate').value,document.getElementById('toDate').value)\" >";
		               $posts_search .=  "        <option value = \"\" style = \"color: #ca0000;\">избор...</option>\n";
		               require_once("includes/classes/PostCategoriesList.class.php");
		               $CCList = new PostCategoriesList($conn);
		               if($CCList->load())
                                  $posts_search .= $CCList->showselectlist(0, "", $_REQUEST['post_category']?$_REQUEST['post_category']:($_REQUEST['category']?$_REQUEST['category']:0), $return);
		               $posts_search .=  "     </select>\n";
		              
		         $posts_search .= "</td>	
		          <td valign='top'>
			         <table>
			         <tr> 
			              <td style='margin:10px;margin-left:0px;width:300px;'> 		
		                       Ключова дума в текста на Статията: <img src='images/help.png' title='offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Ключова дума!] body=[&rarr; Въведене търсена от Вас <span style=\"color:#FF6600;font-weight:bold;\">дума или израз</span> и системата ще извърши търсене за статии, съдържащи тази <span style=\"color:#FF6600;font-weight:bold;\">дума или израз</span>.]' /><br />  <input type='text' name='post_body' id='post_body'  style='overflow:no;width:300px;' value='".$_REQUEST['post_body']."' onkeyUp=\"getFastSearchPosts(document.getElementById('post_category').value,this.value,document.getElementById('fromDate').value,document.getElementById('toDate').value)\" />
			             </td>             
		             </tr> ";		
		         $posts_search .= ' <tr>  
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
                                                <option value="post_title" '.(($_REQUEST['orderby'] == "post_title")?"selected":"").'>Заглавие</option>
                                                <option value="post_body" '.(($_REQUEST['orderby'] == "post_body")?"selected":"").'>Съдържание</option>
                                                <option value="post_category" '.(($_REQUEST['orderby'] == "post_category")?"selected":"").'>Категория</option>
                                        </select>
	                   </td>                              
	                </tr>            
                  			
	             </table>
              	</td>	
		      </tr> 
  			  
                         	
			</table>            
                              
		</div></div> <br style="clear:left;"/>';
				
				  
				  	        
		        
	return $posts_search;
	  
	?>
