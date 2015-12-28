<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
 	$bolesti_main_edit = "";

   	$edit=$_REQUEST['edit'];



	if (isset($edit))
	{
		$editID=$edit;
		
		$clauses = array();
	   	$clauses['where_clause'] = " AND b.bolestID = '".$editID."'";
		$clauses['order_clause'] = '';
		$clauses['limit_clause'] = ' LIMIT 1';
		$bolest_edit_info = $this->getItemsList($clauses);
	
		if(!$bolest_edit_info)
		{
			return false;
		}
		$resultEdit = $bolest_edit_info[$editID];	
		
				
		/* Ne dopuskame redakciq na chujdi bolesti */
		if($resultEdit['autor'] != $_SESSION['userID'] && $_SESSION['user_kind'] != 2) exit;
		
		
		if($resultEdit['Cats'] > 0) 
		{				 	
			for($i=0; $i<$resultEdit['numCats']; $i++) 
			{						
				$bolest_edit_cats_ids[$i] = $resultEdit['Cats'][$i]['bolest_category_id'];			
				$bolest_edit_cats_names[$i] = $resultEdit['Cats'][$i]['bolest_category_name'];						
			} 
		}	
		
		
		if($resultEdit['Simptoms'] > 0) 
		{				 	
			for($i=0; $i<$resultEdit['numSimptoms']; $i++) 
			{						
				$bolest_edit_simptoms_ids[$i] 	= $resultEdit['Simptoms'][$i]['bolest_simptom_id'];			
				$bolest_edit_simptoms_names[$i] = $resultEdit['Simptoms'][$i]['bolest_simptom_name'];						
			} 
		}	
	
	}


$bolesti_main_edit .= '<div id="search_form" style=" margin-top:0px; width:650px;">

<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F9F9F9;">
	Описвайки болестно състояние и придружаващите го симптоми Вие помагате на хиляди хора да се ориентират към правилния лекар и може би сапсявате стотици животи.
</div>

	
<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">';
 		
	
	$bolesti_main_edit .= '<div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
		  		if (eregi("^[0-9]+",$edit))
		  		{	
		  			$bolesti_main_edit .= '<input type="submit" value="Редактирай" id="edit_btn" title="Редактирай" name="edit_btn" onclick="return checkForCorrectDataBolest(document.searchform);">';	
		  		
		  	 
		  		}
		  
		  	
		  		if (!eregi("^[0-9]+",$edit))
		  		{	
		  	
		  			$bolesti_main_edit .= '<input type="submit" value="Добави" id="insert_btn" title="Добави" name="insert_btn"  onclick="return checkForCorrectDataBolest(document.searchform);">';	
		  		
		  	 
		  		}
					  	
				  		
				
	$bolesti_main_edit .= ' </div>
				  <br /><br /><br />
				  
				  <input type=\'hidden\' name=\'MAX_FILE_SIZE\' value=\'999999999\'>
				  <input type=\'hidden\' name=\'edit\' value=\''.$edit.'\'>
				  <input type=\'hidden\' name=\'autor\' value=\''.$resultEdit['autor'].'\'>
				  <input type=\'hidden\' name=\'autor_type\' value=\''.$resultEdit['autor_type'].'\'>
				
				<table>
				<tr>  
				<td style="margin:10px;margin-left:0px;width:300px;" valign="top"> 
		            <label for = "bolest_category">Категория*</label><br>';
		           
		               $bolesti_main_edit .= "     <select name = \"bolest_category[]\" id = \"bolest_category\" multiple size = \"15\" align = \"left\" style = \"float:left;width:300px;margin-right: 10px;\">";
		               $bolesti_main_edit .= "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
		               require_once("includes/classes/BolestCategoriesList.class.php");
		               $CCList = new BolestCategoriesList($conn);
		               if($CCList->load())
		                    $bolesti_main_edit .= $CCList->showSelectMultipleList(0, "", $bolest_edit_cats_ids?$bolest_edit_cats_ids:0);
		               $bolesti_main_edit .= "</select>\n";
		                $bolests_main_edit .= "За избор на повече от една категория, натиснете и задръжте клавиша <b>Ctrl</b> и изберете с левия бутон на мишката.";
		            
		               	               
		$bolesti_main_edit .= '</td>
		       
			 <td valign="top">
			     
				  Име на Болеста *<br /> <textarea rows = "2" cols = "45"  name="bolest_title" id="bolest_title" >'.$resultEdit['title'].'</textarea>
			 	  <br /><br />
			 	  
			 	  Източник на Описанието *<br /> <input type="text" size="20" style="width:300px;"   name="bolest_source" id="bolest_source" value="'.$resultEdit['source'].'" />
				  <br /> <br />';
		    
	    	if($resultEdit['numTags'] > 0) 
			{				 	
				for($i=0, $cn=1; $i<$resultEdit['numTags']; $i++, $cn++) 
				{						
					$bolest_edit_tags[] = $resultEdit['Tags'][$i];						
				} 
			}	
		$bolesti_main_edit .= 'Етикети към Описанието <font style="font-size:10px;">(ключови думи, разделени със запетайки)</font> <br /> <textarea   maxlength="250" onkeyup="return ismaxlength(this)" rows = "2" cols = "45"  name="bolest_tags" id="bolest_tags" >'.implode(",",$bolest_edit_tags).'</textarea>';				  				  
				
		$bolesti_main_edit .= ' <br /> <br />
				  
			 </td>
		</tr>
		<tr>
			 <td ALIGN="Left" VALIGN="Top">
					<table>
						<tr>
							<td>
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
								
								<label class = "txt12"><a href="javascript:void(0);" title = "Въведете първите няколко символа и изберете от предложения списък.">Подсказка за Симптоми:</label>&nbsp;<br /><br />
                            																	                           		
                         
					 		
								<SELECT NAME="ALL_SIMPTOMS[]" ID="ALL_SIMPTOMS" SIZE="8" MULTIPLE STYLE="width: 300px;" onDblClick="selectselected(ALL_SIMPTOMS,bolest_simptom);  selectAllOptions(bolest_simptom);"  onblur="selectAllOptions(bolest_simptom);">';
							 
                             
                                    $sql = sprintf("SELECT * FROM bolest_simptoms ORDER BY name");
                                    $conn->setSQL($sql);
                                    $conn->getTableRows();
                                    $resultSimptoms=$conn->result;
                                    $numSimptoms = $conn->numberrows;
                                    if( $numSimptoms> 0) {                                       
                                       	 for($i = 0; $i < $numSimptoms; $i++) 
                                       	 {  
                                       	 	$bolesti_main_edit .= '<option value = "'.$resultSimptoms[$i]['id'].'"';
                                       	 	if(in_array($resultSimptoms[$i]['id'],is_array($bolest_edit_simptoms_ids)?$bolest_edit_simptoms_ids:array())) {$bolesti_main_edit .= 'selected'; }
                                       	 	$bolesti_main_edit .= '>'.$resultSimptoms[$i]['name'].'</option>';
                                       	 }                                      
                                    }   
                              
		$bolesti_main_edit .= '	</SELECT>	
								
								
							</fieldset>	
                             
							</td>
							<td STYLE="width: 40px;" align="right">	
								<br /><br />			
								<INPUT TYPE="Button" VALUE="&gt;&gt;" onClick="selectall(ALL_SIMPTOMS,bolest_simptom);" STYLE="width: 30px;"><br />
								<INPUT TYPE="Button" VALUE="&gt;" onClick="selectselected(ALL_SIMPTOMS,bolest_simptom);" STYLE="width: 30px;"><br /><br />
								<INPUT TYPE="Button" VALUE="&lt;" onClick="removeselected(bolest_simptom);" STYLE="width: 30px;"><br />
								<INPUT TYPE="Button" VALUE="&lt;&lt;" onClick="removeall(bolest_simptom);" STYLE="width: 30px;"><br />
							</td>
						</tr>
						</table>
					</td>
					<td ALIGN="Left" VALIGN="Top">
						 <label>Избрани Симптоми</label><br />
						<SELECT NAME="bolest_simptom[]" ID="bolest_simptom" SIZE="12" MULTIPLE STYLE="width: 300px;" onDblClick="removeselected(bolest_simptom);" onmouseout="selectAllOptions(bolest_simptom);">';
						
                             
	                         if( $numSimptoms> 0) {                                       
	                           	 for($i = 0; $i < $numSimptoms; $i++) 
	                             {                                         	 
	                 				if(in_array($resultSimptoms[$i]['id'],is_array($bolest_edit_simptoms_ids)?$bolest_edit_simptoms_ids:array())) 
	                 				{                            					
	                             	
	                             	 	$bolesti_main_edit .= '<option value = "'.$resultSimptoms[$i]['id'].'" SELECTED >'.$resultSimptoms[$i]['name'].'</option>';
	                             	 
	                 				}
	                           	 }                                      
	                         }   
                           
$bolesti_main_edit .= '</SELECT>
					</td>
		     </tr>
		     <tr>
		     <td colspan="2">
		      <div style = "width:400px;">*За преместване на симптом от едно поле в друго може да щракнете 2 пъти ввърху него.</div><br />
		     </td>
		     </tr> 
		 <tr>
		
	
  		<td colspan="2">
  		
				 Текст на Описанието*<br /> ';
			
				 include_once("FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('bolest_body') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '640';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = ((strlen($resultEdit['body']) > 0) ? $resultEdit['body'] : ""); 
		        $bolesti_main_edit .= $oFCKeditor->CreateHtml();
			
	$bolesti_main_edit .= '<br /> <br />
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
	           		 	 
							    $bolesti_main_edit .= "<div style='float:left; margin-left:20px; width:400px;' >";
							    							    
								if($resultEdit['numPics'] > 0) 
								{ 									
									  foreach ($resultEdit['resultPics']['url_thumb'] as $pics_thumb)
							   		  {		  	         			
											$bolesti_main_edit .= '<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60"';
					       					$bolesti_main_edit .= 'src=\'pics/bolesti/'.$pics_thumb.'\' />';
							       			$bolesti_main_edit .= '</div>
							       			<div style="float:left;cursor:pointer;" >
							       			<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-снимка-на-болест-'.$pics_thumb.','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],50,'_',''):'Статии_за_здраве').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
							       			</div>';
											
							   		  }										
								 }
  
								  $bolesti_main_edit .= "</div>";
							
				                    
			         
			         $bolesti_main_edit .= '</td></tr></table>
           		 </td>
			 </tr>	
           	<tr>
           	<td colspan="2">         		 	
        
           	<fieldset  style="width:640px">	
            <legend>.:: Видео Представяне ::.</legend>';
            
            
            	$video_name = $edit;
            	
				if(file_exists("../videos/bolesti/".$video_name.".flv"))
				{
					$video = "videos/bolesti/".$video_name.".flv";
					
					$bolesti_main_edit .= '<br>
					
					<div id="videoDIV"  style="margin-left:0px;">
					<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
						<script type="text/javascript">
							var FO = {movie:"flash_flv_player/flvplayer.swf",width:"350",height:"200",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
							flashvars:"file=../videos/bolesti/'.$video_name.'.flv'.'&image=../videos/bolesti/'.$video_name.'_thumb.jpg'.'" };
							UFO.create(FO, "player1");
						</script>
					</div>
					
					<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-видео-на-болест-'.$editID.','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],50,'_',''):'Статии_за_здраве').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>';
	       			
				    
				} 
				         				
				$bolesti_main_edit .= ' <label>Прикачи видео: </label><input type="file" name="imagefile"> (Само ".flv" формат)<br>';
				
				
				if(is_array($_REQUEST)) {
				      for(reset($_REQUEST); $filedName = key ($_REQUEST); next($_REQUEST)) {
				         $$filedName = $_REQUEST[$filedName];
				      }
				   }
				//$big_resize= "-s 320x240 -r 15  -b 768"; 
				//$normal_resize= "-s 320x240 -r 15  -b 160";
				//$small_resize= "-s 240x180 -r 8  -b 90";  
				
				
				
		
				
				$bolesti_main_edit .= '<br />
				Видео от YOUTUBE.COM:
					<input type="text" style="width:380px;" name="youtube_video" id="youtube_video" value = "';
				$bolesti_main_edit .= (strlen($resultEdit['youtube_video']) > 0) ? $resultEdit['youtube_video'] : ""; 
				$bolesti_main_edit .= '">
				<br /><br />
						
				
			</fieldset>		
						
	 
	   </td>
       </tr>
       </table>
       	 	<br /><br />
      Полетата отбелязани с "*" са задължителни.	   
      <br /><br />
      
      <div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
	  		if (eregi("^[0-9]+",$edit))
	  		{	
	  	
	  		$bolesti_main_edit .= '<input type="submit" value="Редактирай" id="edit_btn" title="Редактирай" name="edit_btn"  onclick="return checkForCorrectDataBolest(document.searchform);">	';
	  		
	  	
	  		}
	  	
	  	
	  		if (!eregi("^[0-9]+",$edit))
	  		{	
	  
	  		$bolesti_main_edit .= ' <input type="submit" value="Добави" id="insert_btn" title="Добави" name="insert_btn"  onclick="return checkForCorrectDataBolest(document.searchform);">	';
	  		
	  
	  		}
	  	
	
	  $bolesti_main_edit .= ' </div>
		 </div> </div>		     		 	
 </div>
 <br style="clear:left;">';
	

	        
	    
	return $bolesti_main_edit;
	  
	?>
