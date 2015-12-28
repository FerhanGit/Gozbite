<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
 	$recipes_main_edit = "";
 	
   	$edit=$_REQUEST['edit'];



	if (isset($edit))
	{
		$editID=$edit;
		
		$clauses = array();
	   	$clauses['where_clause'] = " AND r.id = '".$editID."'";
		$clauses['order_clause'] = '';
		$clauses['limit_clause'] = ' LIMIT 1';
		$recipe_edit_info = $this->getItemsList($clauses);
	
		if(!$recipe_edit_info)
		{
			return false;
		}
		$resultEdit = $recipe_edit_info[$editID];	
		
				
		/* Ne dopuskame redakciq na chujdi recipes */
		if($resultEdit['autor'] != $_SESSION['userID'] && $_SESSION['user_kind'] != 2) exit;
		
		
		if($resultEdit['Cats'] > 0) 
		{				 	
			for($i=0; $i<$resultEdit['numCats']; $i++) 
			{						
				$recipe_edit_cats_ids[$i] = $resultEdit['Cats'][$i]['recipe_category_id'];			
				$recipe_edit_cats_names[$i] = $resultEdit['Cats'][$i]['recipe_category_name'];						
			} 
		}	
		
		
		if($resultEdit['Products'] > 0) 
		{				 	
			for($i=0; $i<$resultEdit['numProducts']; $i++) 
			{						
				$recipe_edit_products_ids[$i] 	= $resultEdit['Products'][$i]['recipe_product_id'];			
				$recipe_edit_products_names[$i]  = $resultEdit['Products'][$i]['recipe_product_name'];						
			} 
		}	
	
		
	
	}


$recipes_main_edit .= '<div id="search_form" style=" margin-top:0px; width:650px;">

<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">';
 		

		if(isset($_REQUEST['edit_btn']) OR isset($_REQUEST['insert_btn']))
		{
			$recipes_main_edit .= "<br /><br />Благодарим Ви! Веднага след като бъде прегледана от администратора Вашата рецепта ще бъде публикувана!<br /><br />";
		}
		
	
	$recipes_main_edit .= '<div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
		  		if (eregi("^[0-9]+",$edit))
		  		{	
		  			$recipes_main_edit .= '<input type="submit" value="Редактирай" id="edit_btn" title="Редактирай" name="edit_btn" onclick="return checkForCorrectDataRecipe(document.searchform);">';	
		  		
		  	 
		  		}
		  
		  	
		  		if (!eregi("^[0-9]+",$edit))
		  		{	
		  	
		  			$recipes_main_edit .= '<input type="submit" value="Добави" id="insert_btn" title="Добави" name="insert_btn"  onclick="return checkForCorrectDataRecipe(document.searchform);">';	
		  		
		  	 
		  		}
					  	
				  		
				
	$recipes_main_edit .= ' </div>
				  <br /><br /><br />
				  
				  <input type=\'hidden\' name=\'MAX_FILE_SIZE\' value=\'999999999\'>
				  <input type=\'hidden\' name=\'edit\' value=\''.$edit.'\'>
				  <input type=\'hidden\' name=\'firm_id\' value=\''.$resultEdit['firm_id'].'\'>
				  <input type=\'hidden\' name=\'user_id\' value=\''.$resultEdit['user_id'].'\'>';
	
	
			if (isset($_SESSION['valid_user']) && $_SESSION['user_type'] == 'user' && $_SESSION['user_kind'] == 2) 
			{
		 $recipes_main_edit .='
		<table><tr><td>
		
				
				  Заведение/Фирма : <br />
                  <div style = " width:250px; margin-right:10px; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                  <select style="width:250px;" name="slujebno_firm" id="slujebno_firm" >				
                  <option value ="">избери</option>';	
                 

                  	$sql="SELECT id, name FROM firms ORDER BY name";
					$conn->setSQL($sql);
                  	$conn->getTableRows();
                    $resultCategories=$conn->result;
                    $numCategories = $conn->numberrows;
                    if( $numCategories > 0) 
                    {                                                                              
                      	for($i = 0; $i < $numCategories; $i++) 
                      	{     
							 $recipes_main_edit .='<option value = "'.$resultCategories[$i]['id'].'"';
							 if ($resultCategories[$i]['id'] == $resultEdit['firm_id']) 
							  $recipes_main_edit .= "selected";
							   $recipes_main_edit .='>'.$resultCategories[$i]['name'].'</option> ';
			 			} 
                                      
           			}                                 
              
                 $recipes_main_edit .='                
                  </select>
                  </div>  
                  
               </td><td>
                              
				  Потребител : <br />
                  <div style = " width:250px; margin-right:10px; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                  <select style="width:250px;" name="slujebno_user" id="slujebno_user" >				
                  <option value ="">избери</option>	';	
                

                  	$sql="SELECT userID, CONCAT(first_name,' ',last_name) as name FROM users ORDER BY name";
					$conn->setSQL($sql);
                  	$conn->getTableRows();
                    $resultCategories=$conn->result;
                    $numCategories = $conn->numberrows;
                    if( $numCategories > 0) 
                    {                                                                              
                      	for($i = 0; $i < $numCategories; $i++) 
                      	{     
							 $recipes_main_edit .='<option value = "'.$resultCategories[$i]['userID'].'"';
							 if ($resultCategories[$i]['userID'] == $resultEdit['user_id']) 
							 $recipes_main_edit .= "selected";
							 $recipes_main_edit .='>'.$resultCategories[$i]['name'].'</option> ';
				 		} 
                                      
           			}                                 
               	 $recipes_main_edit .='
                                
                  </select>
                  </div>  
               </td></tr></table>';
	                  
                            
           		}                                 
             
               
           $recipes_main_edit .='
               	  
				<table  style = " width:650px;margin: 0px 10px 10px 10px;" border="0" align="center">
				 	<tr>
                        <td colspan="4" align="left"><p style="width:200px;">Наименование на рецептата*: <br /></p><input type="text" style="width:600px;" name="title" id="title" value = "'.$resultEdit['title'].'"><br /> </td>
                    </tr>
                      <br />
                    
                     <tr>    		
    					<td colspan="2" align="left" valign="top">
    						<br /> 
                            Вид на рецептата* :
                              <div id = "city" style = " width:200px; margin-right:10px; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                              <select style="width:200px;" name="recipe_category[]" id="recipe_category" >				
                              <option value ="">избери</option>	';	
                            
                             
                                    $sql="SELECT id, name FROM recipe_category ORDER BY rank, name";
									$conn->setSQL($sql);
                                    $conn->getTableRows();
                                    $resultCategoriesEdit=$conn->result;
                                    $numCategoriesEdit = $conn->numberrows;
                                    if( $numCategoriesEdit > 0) 
                                    {
                                                                              
                                       	 for($k = 0; $k < $numCategoriesEdit; $k++) 
                                       	 {
                                       	 	$recipes_main_edit .='<option value = "'.$resultCategoriesEdit[$k]['id'].'"';
           									if ($resultCategoriesEdit[$k]['id'] == $recipe_edit_cats_ids[0]) 
           									{
           										$recipes_main_edit .= "selected"; 
           									}
           									$recipes_main_edit .='>'.$resultCategoriesEdit[$k]['name'].'</option>'; 
							                             
										 } 
                                      
                                     }                                 
                                  
                  $recipes_main_edit .='       
                              </select>
                              </div> 
	                                
                                 <br />   
	                           Национална Кухня :
                              <div id = "city" style = " width:200px; margin-right:10px; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                              <select style="width:200px;" name="recipe_kuhni[]" id="recipe_kuhni" >	';			
                             	
                             
                                    $sql="SELECT id, name FROM kuhni ORDER BY name";
									$conn->setSQL($sql);
                                    $conn->getTableRows();
                                    $resultKuhniEdit=$conn->result;
                                    $numKuhniEdit = $conn->numberrows;
                                    if( $numKuhniEdit > 0) 
                                    {                                                                              
                                        for($k = 0; $k < $numKuhniEdit; $k++) 
                                        {     
                                            $recipes_main_edit .='<option value = "'.$resultKuhniEdit[$k]['id'].'"';
                                            if ($resultKuhniEdit[$k]['id'] == $resultEdit['Kuhnq']['kuhnq_id']) 
                                            {
                                                $recipes_main_edit .= "selected";
                                            } elseif($resultKuhniEdit[$k]['id'] == 1) { // Българска кухня
                                                  
                                                $recipes_main_edit .= "selected"; 
                                            }
                                                $recipes_main_edit .='>'.$resultKuhniEdit[$k]['name'].'</option> ';					                             
                                        }                                       
                                    }                                 
                                   
                               $recipes_main_edit .=' 
                             
                              </select>
                              </div> 
                               
					      </td>                          
                          <td colspan="2" align="left" valign="top">
                                                  
                              
                          	<div style = "margin: 10px 10px 10px 10px;">';				     
			
							
						      		$recipes_main_edit .= "<fieldset style ='width:340px; padding:10px;'><legend>Необходими ПРОДУКТИ <a href='#' id='recipes_products_help' style='z-index:1000;'><img src='images/help.png' /></a></legend> <br />";
								
					         		 $recipes_main_edit .='<input type="button" onclick="addInputs(\'recipe\');" name="addField" value="Добави нов продукт" />';
					         		 
					         	
						                 		
										 $recipes_main_edit .= " <table id=\"products_table\" cellpadding = \"0\" cellspacing = \"0\" border = \"0\"><tr><td>Продукт/Съставка</td></tr>";
						              		for($i = 0; $i < count($recipe_edit_products_ids); $i++) 
						              		{
								                 $recipes_main_edit .= "    <tr>";
								              	 $recipes_main_edit .= sprintf(" <td><input type = \"text\" id = \"recipes_products%d\" name = \"recipes_products[]\" value = \"%s\" size = \"50\"></td>", $recipe_edit_products_ids[$i],  $recipe_edit_products_names[$i]);
								                 		
												 $recipes_main_edit .= "    </tr>";
								             }
						              $recipes_main_edit .= " </table></fieldset>"; 
						        $recipes_main_edit .='
							 </div>
                         </td>				   					
    					</tr>
    					<br />                  
                                     
    					               
                                              
    </table> ';
    
    
               $recipes_main_edit .='				
				<table>
				<tr><td>				
				 <div style="margin:10px;margin-left:0px;"> 
					<fieldset style="width:650px;margin-bottom:20px; margin-top:20px; padding-top:10px; padding-bottom:10px;">
		            <legend>&nbsp;&nbsp;Начин на приготвяне: </legend>	';			
						 	
		            	
							 include_once("FCKeditor/fckeditor.php");
					         $oFCKeditor = new FCKeditor('info') ;
					         $oFCKeditor->BasePath   = "FCKeditor/";
					         $oFCKeditor->Width      = '640';
					         $oFCKeditor->Height     = '300' ;
					         $oFCKeditor->Value      = $resultEdit['info'];
					        $recipes_main_edit .= $oFCKeditor->CreateHtml();
					        
			$recipes_main_edit .='			
						</fieldset>
					</div>
				</td></tr>	
		
		
		
				<tr>  
				<td style="margin:10px;margin-left:0px;width:300px;" valign="top">'; 
		             	  
		    	if($resultEdit['numTags'] > 0) 
				{				 	
					for($i=0, $cn=1; $i<$resultEdit['numTags']; $i++, $cn++) 
					{						
						$recipe_edit_tags[] = $resultEdit['Tags'][$i];						
					} 
				}	
				$recipes_main_edit .= 'Етикети към Описанието <font style="font-size:10px;">(ключови думи, разделени със запетайки)</font> <br /> <textarea   maxlength="250" onkeyup="return ismaxlength(this)" rows = "2" cols = "45"  name="recipe_tags" id="recipe_tags" >'.implode(",",$recipe_edit_tags).'</textarea>';				  				  
				
				$recipes_main_edit .= ' <br /> <br />
				  
			 </td>
		</tr>
			
			<tr>
			<td colspan="2">
           		 	            		 		
           		 <table>
                  	<tr><td valign="top">
                  	
		                  	<div style="float:left;margin:10px;margin-left:0px;width:220px;"> 
							 Снимки:
									<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
		                  	
		                  	</div>
           		 			
   		 			   
         	
           		 	</td><td valign="top">';
	           		 	 
							    $recipes_main_edit .= "<div style='float:left; margin-left:20px; width:400px;' >";
							    							    
								if($resultEdit['numPics'] > 0) 
								{ 									
									  foreach ($resultEdit['resultPics']['url_thumb'] as $pics_thumb)
							   		  {		  	         			
											$recipes_main_edit .= '<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60"';
					       					$recipes_main_edit .= 'src=\'pics/recipes/'.$pics_thumb.'\' />';
							       			$recipes_main_edit .= '</div>
							       			<div style="float:left;cursor:pointer;" >
							       			<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-снимка-на-рецепта-'.$pics_thumb.','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],50,'_',''):'Статии_за_здраве').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
							       			</div>';
											
							   		  }										
								 }
  
								  $recipes_main_edit .= "</div>";
							
				                    
			         
			         $recipes_main_edit .= '</td></tr></table>
           		 </td>
			 </tr>	
           	<tr>
           	<td colspan="2">         		 	
        
           	<fieldset  style="width:640px">	
            <legend>.:: Видео Представяне ::.</legend>';
            
            
            	$video_name = $edit;
            	
				if(file_exists("../videos/recipes/".$video_name.".flv"))
				{
					$video = "videos/recipes/".$video_name.".flv";
					
					$recipes_main_edit .= '<br>
					
					<div id="videoDIV"  style="margin-left:0px;">
					<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
						<script type="text/javascript">
							var FO = {movie:"flash_flv_player/flvplayer.swf",width:"350",height:"200",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
							flashvars:"file=../videos/recipes/'.$video_name.'.flv'.'&image=../videos/recipes/'.$video_name.'_thumb.jpg'.'" };
							UFO.create(FO, "player1");
						</script>
					</div>
					
					<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-видео-на-рецепта-'.$editID.','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],50,'_',''):'Статии_за_здраве').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>';
	       			
				    
				} 
				         				
				$recipes_main_edit .= ' <label>Прикачи видео: </label><input type="file" name="imagefile"> (Само ".flv" формат)<br>';
				
				
				if(is_array($_REQUEST)) {
				      for(reset($_REQUEST); $filedName = key ($_REQUEST); next($_REQUEST)) {
				         $$filedName = $_REQUEST[$filedName];
				      }
				   }
				//$big_resize= "-s 320x240 -r 15  -b 768"; 
				//$normal_resize= "-s 320x240 -r 15  -b 160";
				//$small_resize= "-s 240x180 -r 8  -b 90";  
				
				
				
		
				
				$recipes_main_edit .= '<br />
				Видео от YOUTUBE.COM:
					<input type="text" style="width:380px;" name="youtube_video" id="youtube_video" value = "';
				$recipes_main_edit .= (strlen($resultEdit['youtube_video']) > 0) ? $resultEdit['youtube_video'] : ""; 
				$recipes_main_edit .= '">
				<br /><br />
						
				
			</fieldset>		
						
	 
	   </td>
       </tr>
       </table>
       	 	<br /><br />
      Полетата отбелязани с "*" са задължителни.	   
      <br /><br />';
      
      
    
if ($_REQUEST['edit'] > 0)
{
	 $recipes_main_edit .= '<input type=\'checkbox\' id=\'active'.$_REQUEST['edit'].'\' name=\'active'.$_REQUEST['edit'].'\' '.((($resultEdit["active"] == 1) ? 'checked' : '')).' onclick=\'if(this.checked) {set_active(1,"recipe",'.$_REQUEST['edit'].','.$_SESSION['userID'].');} else{set_active(0,"recipe",'.$_REQUEST['edit'].','.$_SESSION['userID'].');} \'/> Рецептата е активна.<a href=\'#\' id=\'aktivirane_recipe\' style=\'z-index:1000;\'><img src=\'images/help.png\' /></a>';

}	 

$recipes_main_edit .= '<br /> <br />';

 

if(isset($_REQUEST['edit']) && $_REQUEST['edit'] > 0) // Показваме информацията за СПЕЦИАЛИТЕТ само ако редактираме рецептата, не когато я въвеждаме!
{
	$recipes_main_edit .= " <br /><hr><br />
	<h3 style=\"color:#FF6600; font-weight:bold;\">Направи рецептата си Специалитет!</h3><hr style=\"border:1px dashed #000000;\"><p style=\"color:#000000;\"> &rarr; Изпрати SMS на кратък номер <span style=\"color:#FF6600;font-weight:bold;\">1093</span> и въведи получения код в полето, което ще видиш след като кликнеш на бутона '<span style=\"color:#FF6600;font-weight:bold;\">Въведи КОД-а и направи СПЕЦИАЛИТЕТ</span>'.<br /> &rarr; Една седмица Вашата рецепта ще е в секция <span style=\"color:#FF6600;font-weight:bold;\">Специалитет</span> на главната ни страница!<br />  &rarr; За да използваш услугата изпрати SMS с текст <span style=\"color:#FF6600;font-weight:bold;\">izbran</span> на номер <span style=\"color:#FF6600;font-weight:bold;\">1093</span> (цена с ДДС - 1.20лв.).  </p>
	<a href = \"javascript://\" onclick = \"window.open('includes/tools/checkSMScodeSpecialitet.php?content=recipe&content_id=".$_REQUEST['edit']."', 'sndWin', 'top=0, left=0, width=400px, height=250px, resizable=no, toolbars=no, scrollbars=yes');\" class = \"smallOrange\"><img style=\"margin-left:5px;\" src=\"images/make_specialitet_btn.png\" alt=\"Въведи КОД-а и направи СПЕЦИАЛИТЕТ\" width=\"300\" height=\"20\"></a>";
    
    $recipes_main_edit .= "<br /><br />";
            
    $recipes_main_edit .= "
        <table width='100%' style='padding-left:5px;'><tr><td style='background-color:#F1F1F1; width:100px;'>Период</td><td style='background-color:#F1F1F1; width:100px;'>Цена</td><td  style='background-color:#F1F1F1; '></td></tr>
        <tr style='background-color:#C7C7C7;'><td>1 седмица</td><td>1.20 лв.</td>
        <td  style='background-color:#C7C7C7;' >
        <style>
			INPUT.epay-button         { border: solid  1px #FFF; background-color: #168; padding: 4px; color: #FFF; background-image: none; padding-left: 5px; padding-right: 5px; }
			INPUT.epay-button:hover   { border: solid  1px #ABC; background-color: #179; padding: 4px; color: #FFF; background-image: none; padding-left: 5px; padding-right: 5px; }
		</style>
		
		<form action='https://www.epay.bg/' method='post'>
		<input type='hidden' name='PAGE' value='paylogin'>
		<input type='hidden' name='MIN' value='6042735676'>
		<input type='hidden' name='INVOICE' value=''>
		<input type='hidden' name='TOTAL' value='1.20'>
		<input type='hidden' name='DESCR' value='Napravi SPECIALITET za 1 sedmica'>
		<input type='hidden' name='URL_OK' value='http://www.gozbite.com'>
		<input type='hidden' name='URL_CANCEL' value='http://www.gozbite.com'>
		<input class='epay-button' type='submit' name='BUTTON:EPAYNOW' value='Плащане on-line през ePay.bg' onclick='sendMailWhenEpayBg(1.20);'>
		</form>
    </td></tr></table>";
     
    $recipes_main_edit .= "<br /><hr><br />";
    
}

$recipes_main_edit .= '

      <div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
	  		if (eregi("^[0-9]+",$edit))
	  		{	
	  	
	  		$recipes_main_edit .= '<input type="submit" value="Редактирай" id="edit_btn" title="Редактирай" name="edit_btn"  onclick="return checkForCorrectDataRecipe(document.searchform);">	';
	  		
	  	
	  		}
	  	
	  	
	  		if (!eregi("^[0-9]+",$edit))
	  		{	
	  
	  		$recipes_main_edit .= ' <input type="submit" value="Добави" id="insert_btn" title="Добави" name="insert_btn"  onclick="return checkForCorrectDataRecipe(document.searchform);">	';
	  		
	  
	  		}
	  	
	
	  $recipes_main_edit .= ' </div>
		 </div> </div>		     		 	
 </div>
 <br style="clear:left;">';
	

	        
	    
	return $recipes_main_edit;
	  
	?>
