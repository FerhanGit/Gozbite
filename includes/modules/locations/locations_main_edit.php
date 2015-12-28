<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
 	$locations_main_edit = "";

   	$edit=$_REQUEST['edit'];



	if (isset($edit))
	{
		$editID=$edit;
		
		$clauses = array();
	   	$clauses['where_clause'] = " AND l.id = '".$editID."'";
		$clauses['order_clause'] = '';
		$clauses['limit_clause'] = ' LIMIT 1';
		$location_edit_info = $this->getItemsList($clauses);
	
		if(!$location_edit_info)
		{
			return false;
		}
		$resultEdit = $location_edit_info[$editID];	
		
				
		/* Ne dopuskame redakciq na chujdi locations */
		if($resultEdit['autor'] != $_SESSION['userID'] && $_SESSION['user_kind'] != 2) exit;
		
		
	
	}


$locations_main_edit .= '<div class="detailsDivMap" style="width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
							<div id="mymap" style="width: 660px; height: 290px;"></div>
								<div id="mapHelpDiv" style="margin-top:5px;margin-left:0px;  padding:5px; width: 520px; background-color:#F7F7F7;">Позиционирайте местоположенитео си върху картата като кликнете с левия бутон на мишката върху желаното място.</div>
						</div>';
	
$locations_main_edit .= '<div id="search_form" style=" margin-top:0px; width:650px;">

<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">';
 		

		if(isset($_REQUEST['edit_btn']) OR isset($_REQUEST['insert_btn']))
		{
			$locations_main_edit .= "<br /><br />Благодарим Ви! Веднага след като бъде прегледано от администратора Вашето описание ще бъде публикувано!<br /><br />";
		}
		
	
	$locations_main_edit .= '<div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
		  			
	$locations_main_edit .= '<input type="submit" value="Редактирай" id="edit_btn" title="Редактирай" name="edit_btn" onclick="return checkForCorrectDataLocation(document.searchform);">';	
		  		
				  		
	
		//	$pushpinIcon = "http://largo.bg/img/icon_firmi.gif";
		   	if(is_file('pics/locations/'.$resultEdit['resultPics'][0]['url_thumb']))  $picFileMap = 'pics/locations/'.$resultEdit['resultPics'][0]['url_thumb'];
			else $picFileMap = "pics/locations/no_photo_thumb.png";
			$baloonHTML1 .= "<span style='float:left;margin-right:10px;'><a href = 'разгледай-дестинация-".$resultEdit['location_id'].",".myTruncateToCyrilic($resultEdit['locType'].' '.$resultEdit['location_name'],200,' ','').".html'><img src='".$picFileMap."' /></a></span>";               
            $baloonHTML1 .= "<span style='float:left;'>".$resultEdit["locType"]." ".$resultEdit['location_name']."</span>";
            $baloonHTML2 .= "<span>".myTruncate($resultEdit["info"], 300, " ")."<a href = 'разгледай-дестинация-".$resultEdit['location_id'].",".myTruncateToCyrilic($resultEdit['locType'].' '.$resultEdit['location_name'],200,' ','').".html'> виж още</a></span>";

            $locations_main_edit .= require("map_edit_locations.php");		
			
            $locations_main_edit .= sprintf("<input type = \"hidden\" name = \"latitude\" id = \"latitude\" value = \"%0.20f\">\n", $resultEdit['latitude']);
			$locations_main_edit .= sprintf("<input type = \"hidden\" name = \"longitude\" id = \"longitude\" value = \"%0.20f\">\n", $resultEdit['longitude']);
		
		
           	
		
			
			
				
	$locations_main_edit .= ' </div>
				  <br /><br /><br />
				  
				  <input type=\'hidden\' name=\'MAX_FILE_SIZE\' value=\'999999999\'>
				  <input type=\'hidden\' name=\'edit\' value=\''.$edit.'\'>';
				  
	
			
           $locations_main_edit .='
               	  
				<table  style = " width:650px;margin: 0px 10px 10px 10px;" border="0" align="center">
				
				 	 <tr>    		
    					<td valign="top" style = " width:300px; margin-right:10px; overflow-y: auto;overflow-x: none;" >
                            <fieldset style="width:280px;margin-bottom:20px; margin-top:0px; padding-top:10px; padding-bottom:10px;">';

                      
                        		if($resultEdit['locationID'] > 0) 
		                    	{
                        
                        		 	$locations_main_edit .='<legend>&nbsp;Дестинация - <b style="color:#FF6600;">'.$resultEdit['locType'].' '.$resultEdit['location_name'].'</b> &nbsp;</legend>';
                        		 	$locations_main_edit .='<input type=\'hidden\' name=\'cityName\' id="cityName" value=\''.$resultEdit['locationID'].'\'>';
				  
                        	
		                    	}
                        		else 
                        		{
                        

                            		$locations_main_edit .=' <legend>&nbsp;Населено място*   <a href=\'#\' id=\'destinaciq\' style=\'z-index:1000;\'><img src=\'images/help.png\' /></a></legend>
                            
                           		<!--  TARSACHKATA -->
								<div>
									<input type="text" size="30" id="inputString" name="inputString" AUTOCOMPLETE=OFF onkeyup="if(this.value.length > 2 ) { lookupLocation(this.value);}" value="Търси..." onfocus="if(this.value!=\'Търси...\'){this.value=this.value;} else {this.value=\'\';}" onblur="if(this.value==\'\'){this.value = \'Търси...\';} else {this.value = this.value;}" >
								</div>
								
								<div class="suggestionsBox" id="suggestions" style="display: none; z-index: 1000; -moz-border-radius:7px; -webkit-border-radius:7px;" onclick=" hidemsgArea();">
									<img src="images/top_arrow.gif" style="position: relative; top: -10px; left: 50px;" alt="upArrow" />
									<div class="suggestionList" id="autoSuggestionsList" style="color:#FFFFFF;"  onclick="hidemsgArea();" onmouseout="hidemsgArea();"></div>
								</div>				
								<!-- KRAI NA TARSACHKATA -->
								<label class = "txt12"><a href="javascript:void(0);" title = "Въведете първите няколко символа и изберете от предложения списък.">Подсказка за населеното място:</label>&nbsp;<br /><br />';
                            		
                               
                             
					               $locations_main_edit .= "     <select name = \"cityName\" id = \"cityName\" size = \"15\" align = \"left\" style = \"float:left;width:280px;margin-right: 10px;\" onchange=\"return checkForExistDescription(this.value);\" >";
					               $locations_main_edit .= "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
					               //printf(" <option value = \"14880\" %s>&nbsp; Обиколен маршрут </option>",((14880 == $resultEdit['locationID']) ? " selected" : ""));
               					   require_once("includes/classes/FirmLocationsListEdit.class.php");
					               $CCList = new FirmLocationsList($conn);
					               if($CCList->load())
					                  $locations_main_edit .= $CCList->showselectlist(0, "", $resultEdit['locationID']?$resultEdit['locationID']:0);
					               $locations_main_edit .= "     </select>\n";
					                  
                              }
                              
                              $locations_main_edit .=' </fieldset>';
                              
$locations_main_edit .='                              
                       </td>                           
                          <td align="left" valign="top">
                                                  
                           <table>
                  	<tr><td valign="top" collspan="2">
                  	
		                  	<div style="float:left;margin:10px;margin-left:10px;width:220px;"> 
							 Снимки:
							 
							
									<span onclick="addFile()" style="cursor:pointer;"> + Добави още полета</span> <br />
									<ul id="files-root" style="list-style-type:none;">
									<li><input type="file" name="pics[]">
									<li><input type="file" name="pics[]">
									<li><input type="file" name="pics[]">
									<li><input type="file" name="pics[]">
									<li><input type="file" name="pics[]">
									</ul>
		                  												
									
		                  	
		                  	</div>';
           		 			
   		 			   
         	
           		 
							    $locations_main_edit .= "<div style='float:left; margin-left:20px; width:400px;' >";
							    							    
								if($resultEdit['numPics'] > 0) 
								{ 		
									$cntPics = 0;							
									  foreach ($resultEdit['resultPics']['url_thumb'] as $pics_thumb)
							   		  {		  
							   		  	
							   		  		         			
											$locations_main_edit .= '<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60"';
					       					$locations_main_edit .= 'src=\'pics/locations/'.$pics_thumb.'\' />';
							       			$locations_main_edit .= '</div>
							       			<div style="float:left;cursor:pointer;" >
							       			<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-снимка-на-дестинация-'.$pics_thumb.','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],200,'_',''):'Дестинации_населени_места').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
							       			</div>';
							       			
											$cntPics++;
											
											if($cntPics % 3 == 0) $locations_main_edit .= '<br style="clear:both;" />';
							   		  }										
								 }
  
								  $locations_main_edit .= "</div>";
							
			         
			         			$locations_main_edit .= '</td></tr></table>
                         </td>				   					
    					</tr>
    					<br />                  
                                     
    					               
                                              
    </table> ';
    
    
               $locations_main_edit .='				
				<table>
				<tr><td>				
				 <div style="margin:10px;margin-left:0px;"> 
					<fieldset style="width:650px;margin-bottom:20px; margin-top:20px; padding-top:10px; padding-bottom:10px;">
		            <legend>&nbsp;&nbsp;Описание: </legend>	';			
						 	
		            	
							 include_once("FCKeditor/fckeditor.php");
					         $oFCKeditor = new FCKeditor('info') ;
					         $oFCKeditor->BasePath   = "FCKeditor/";
					         $oFCKeditor->Width      = '620';
					         $oFCKeditor->Height     = '300' ;
					         $oFCKeditor->Value      = $resultEdit['info'];
					         $oFCKeditor->InstanceName='info';
					         $locations_main_edit .= $oFCKeditor->CreateHtml();
					        
			$locations_main_edit .='			
						</fieldset>
					</div>
				</td></tr>	
		
		
		
				<tr>  
				<td style="margin:10px;margin-left:0px;width:300px;" valign="top">'; 
		             	  
		    	if($resultEdit['numTags'] > 0) 
				{				 	
					for($i=0, $cn=1; $i<$resultEdit['numTags']; $i++, $cn++) 
					{						
						$location_edit_tags[] = $resultEdit['Tags'][$i];						
					} 
				}	
				$locations_main_edit .= 'Етикети към Описанието <font style="font-size:10px;">(ключови думи, разделени със запетайки)</font> <br /> <textarea   maxlength="250" onkeyup="return ismaxlength(this)" rows = "2" cols = "45"  name="location_tags" id="location_tags" >'.implode(",",$location_edit_tags).'</textarea>';				  				  
				
				$locations_main_edit .= ' <br /> <br />
				  
			 </td>
		</tr>
		
           	<tr>
           	<td colspan="2">         		 	
        
           	<fieldset  style="width:640px">	
            <legend>.:: Видео Представяне ::.</legend>';
            
            
            	$video_name = $edit;
            	
				if(file_exists("../videos/locations/".$video_name.".flv"))
				{
					$video = "videos/locations/".$video_name.".flv";
					
					$locations_main_edit .= '<br>
					
					<div id="videoDIV"  style="margin-left:0px;">
					<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
						<script type="text/javascript">
							var FO = {movie:"flash_flv_player/flvplayer.swf",width:"350",height:"200",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
							flashvars:"file=../videos/locations/'.$video_name.'.flv'.'&image=../videos/locations/'.$video_name.'_thumb.jpg'.'" };
							UFO.create(FO, "player1");
						</script>
					</div>
					
					<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-видео-на-дестинация-'.$editID.','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],200,'_',''):'Дестинации_населени_места').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>';
	       			
				    
				} 
				         				
				$locations_main_edit .= ' <label>Прикачи видео: </label><input type="file" name="imagefile"> (Само ".flv" формат)<br>';
				
				
				if(is_array($_REQUEST)) {
				      for(reset($_REQUEST); $filedName = key ($_REQUEST); next($_REQUEST)) {
				         $$filedName = $_REQUEST[$filedName];
				      }
				   }
				//$big_resize= "-s 320x240 -r 15  -b 768"; 
				//$normal_resize= "-s 320x240 -r 15  -b 160";
				//$small_resize= "-s 240x180 -r 8  -b 90";  
				
				
				
		
				
				$locations_main_edit .= '<br />
				Видео от YOUTUBE.COM:
					<input type="text" style="width:380px;" name="youtube_video" id="youtube_video" value = "';
				$locations_main_edit .= (strlen($resultEdit['youtube_video']) > 0) ? $resultEdit['youtube_video'] : ""; 
				$locations_main_edit .= '">
				<br /><br />
						
				
			</fieldset>		
						
	 
	   </td>
       </tr>
       </table>
       	 	<br /><br />
      Полетата отбелязани с "*" са задължителни.	   
      <br /><br />';
      
      

$locations_main_edit .= '

      <div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
	  		$locations_main_edit .= '<input type="submit" value="Редактирай" id="edit_btn" title="Редактирай" name="edit_btn" onclick="return checkForCorrectDataLocation(document.searchform);">';	
	
	  	
	  $locations_main_edit .= ' </div>
		 </div> </div>		     		 	
 </div>
 <br style="clear:left;">';
	

	        
	    
	return $locations_main_edit;
	  
	?>
