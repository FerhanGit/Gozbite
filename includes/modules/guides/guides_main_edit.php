<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
 	$guides_main_edit = "";

   	$edit=$_REQUEST['edit'];



	if (isset($edit))
	{
		$editID=$edit;
		
		$clauses = array();
	   	$clauses['where_clause'] = " AND g.id = '".$editID."'";
		$clauses['order_clause'] = '';
		$clauses['limit_clause'] = ' LIMIT 1';
		$guide_edit_info = $this->getItemsList($clauses);
	
		if(!$guide_edit_info)
		{
			return false;
		}
		$resultEdit = $guide_edit_info[$editID];	
		
				
		/* Ne dopuskame redakciq na chujdi statii */
		if($resultEdit['autor'] != $_SESSION['userID'] && $_SESSION['user_kind'] != 2) exit;
		
		
		if($resultEdit['numTags'] > 0) 
		{				 	
			for($i=0, $cn=1; $i<$resultEdit['numTags']; $i++, $cn++) 
			{						
				$guide_edit_tags[] = $resultEdit['Tags'][$i];						
			} 
		}	
	
	}

	
$guides_main_edit .= '<div id="search_form" style=" margin-top:0px; width:650px;">

<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">';
 		
	
	$guides_main_edit .= '<div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
		  		if (eregi("^[0-9]+",$edit))
		  		{	
		  			$guides_main_edit .= '<input type="submit" value="Редактирай" id="edit_btn" title="Редактирай" name="edit_btn" onclick="return checkForCorrectDataGuide();">';	
		  		
		  	 
		  		}
		  
		  	
		  		if (!eregi("^[0-9]+",$edit))
		  		{	
		  	
		  			$guides_main_edit .= '<input type="submit" value="Добави" id="insert_btn" title="Добави" name="insert_btn"  onclick="return checkForCorrectDataGuide();">';	
		  		
		  	 
		  		}
					  	
				  		
				
	$guides_main_edit .= ' </div>
				  <br /><br /><br />
				  
				  <input type=\'hidden\' name=\'MAX_FILE_SIZE\' value=\'999999999\'>
				  <input type=\'hidden\' name=\'edit\' value=\''.$edit.'\'>
				  <input type=\'hidden\' name=\'autor\' value=\''.$resultEdit['autor'].'\'>
				  <input type=\'hidden\' name=\'autor_type\' value=\''.$resultEdit['autor_type'].'\'>';
				
				  
				  
			if (isset($_SESSION['valid_user']) && $_SESSION['user_type'] == 'user' && $_SESSION['user_kind'] == 2) 
			{
		  $guides_main_edit .= '
		<table><tr><td>
		
				
				  Заведение/Фирма : <br />
                  <div style = " width:250px; margin-right:10px; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                  <select style="width:250px;" name="slujebno_firm" id="slujebno_firm" >				
                  <option value ="">избери</option>		';
                 

                  	$sql="SELECT id, name FROM firms ORDER BY name";
					$conn->setSQL($sql);
                  	$conn->getTableRows();
                    $resultCategories=$conn->result;
                    $numCategories = $conn->numberrows;
                    if( $numCategories > 0) 
                    {                                                                              
                      	for($i = 0; $i < $numCategories; $i++) 
                      	{      
							  $guides_main_edit .= '<option value = "'.$resultCategories[$i]['id'].'"';
							  if ($resultCategories[$i]['id'] == $resultEdit['firm_id'])   $guides_main_edit .= "selected";
							    $guides_main_edit .= '>'.$resultCategories[$i]['name'].'</option>';
				 		} 
                                      
           			}                                 
               	
                     $guides_main_edit .= '             
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
						  $guides_main_edit .= '<option value = "'.$resultCategories[$i]['userID'].'"';
						  if ($resultCategories[$i]['userID'] == $resultEdit['user_id'])   $guides_main_edit .= "selected";
						    $guides_main_edit .= '>'.$resultCategories[$i]['name'].'</option> ';
					  } 
                                      
           			}                                 
                $guides_main_edit .= ' 
                                
                  </select>
                  </div>  
               </td></tr></table>';
	                  
                           
           		}                                 
              
               
               
               
               $guides_main_edit .= '
               
               
				<table  style = " width:650px;margin: 0px 10px 10px 10px;" border="0" align="center">
	 	<tr>
            <td colspan="4" align="left"><p style="width:200px;">Наименование на описанието*: <br /></p><input type="text" style="width:600px;" name="title" id="title" value = \''.$resultEdit['title'].'\'><br /> </td>
        </tr>
    </table> 
		     
		<table style = " width:650px; border="0" align="center">
  		<tr><td>				
		 <div style="margin:10px;margin-left:0px;"> 
			<fieldset style="width:650px;margin-bottom:20px; margin-top:20px; padding-top:10px; padding-bottom:10px;">
            <legend>&nbsp;&nbsp;Описание: </legend>		';		
				 	
            	 include_once("FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('info') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '640';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = $resultEdit['info'];
		         $guides_main_edit .= $oFCKeditor->CreateHtml();
		         
		         
$guides_main_edit .= '		         
				</fieldset>
			</div>
		</td></tr>	
			
		 <tr><td> Етикети към описанието <font style="font-size:10px;">(ключови думи, разделени със запетайки)</font> <br /> <textarea    maxlength="250" onkeyup="return ismaxlength(this)" rows = "2" cols = "48"  name="guide_tags" id="guide_tags" >'.implode(",",$guide_edit_tags).'</textarea>
				  
			</td></tr>

		<tr><td>		
			<fieldset style="float:left; width:650px;  margin-bottom:20px; margin-top:20px; padding-top:10px; padding-bottom:10px;">
            <legend>&nbsp;&nbsp;Снимки: </legend>		 	
			<table><tr><td>
            		<div style="float:left; margin:10px;margin-left:0px;width:220px;"> 
						<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
                  	</div>
          	</td><td>';
                  	
    
			  if ($resultEdit['numPics'] > 0)
			  {  
		  		  $guides_main_edit .= "<div style='float:left; margin:0px; margin-left:20px; width:200px;' >";
				  foreach ($resultEdit['resultPics']['url_thumb'] as $pics_thumb)
		   		  {	
		        	$guides_main_edit .= '<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60"';
   					$guides_main_edit .= 'src=\'pics/guides/'.$pics_thumb.'\' />';
	       			$guides_main_edit .= '</div>
	       			<div style="float:left;cursor:pointer;" >
	       			<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-снимка-на-справочник-'.$pics_thumb.','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],200,'_',''):'Справочник_Описания').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
	       			</div>';
	    
				  }
				  $guides_main_edit .= "</div>";
			}
      
          $guides_main_edit .= ' 		 	
         </td></tr></table>
         </fieldset>			  
		</td></tr>	 
		
		
		
		  	<tr>
           	<td colspan="2">         		 	
        
           	<fieldset  style="width:640px">	
            <legend>.:: Видео Представяне ::.</legend>';
            
            
            	$video_name = $edit;
            	
				if(file_exists("../videos/guides/".$video_name.".flv"))
				{
					$video = "videos/guides/".$video_name.".flv";
					
					$guides_main_edit .= '<br>
					
					<div id="videoDIV"  style="margin-left:0px;">
					<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
						<script type="text/javascript">
							var FO = {movie:"flash_flv_player/flvplayer.swf",width:"350",height:"200",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
							flashvars:"file=../videos/guides/'.$video_name.'.flv'.'&image=../videos/guides/'.$video_name.'_thumb.jpg'.'" };
							UFO.create(FO, "player1");
						</script>
					</div>
					
					<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-видео-на-справочник-'.$editID.','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],200,'_',''):'Статии').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>';
	       			
				    
				} 
				         				
				$guides_main_edit .= ' <label>Прикачи видео: </label><input type="file" name="imagefile"> (Само ".flv" формат)<br>';
				
				
				if(is_array($_REQUEST)) {
				      for(reset($_REQUEST); $filedName = key ($_REQUEST); next($_REQUEST)) {
				         $$filedName = $_REQUEST[$filedName];
				      }
				   }
				//$big_resize= "-s 320x240 -r 15  -b 768"; 
				//$normal_resize= "-s 320x240 -r 15  -b 160";
				//$small_resize= "-s 240x180 -r 8  -b 90";  
				
				
				
		
				
				$guides_main_edit .= '<br />
				Видео от YOUTUBE.COM:
					<input type="text" style="width:380px;" name="youtube_video" id="youtube_video" value = "';
				$guides_main_edit .= (strlen($resultEdit['youtube_video']) > 0) ? $resultEdit['youtube_video'] : ""; 
				$guides_main_edit .= '">
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
	  $guides_main_edit .= '<input type=\'checkbox\' id=\'active'.$_REQUEST['edit'].'\' name=\'active'.$_REQUEST['edit'].'\' '.((($resultEdit["active"] == 1) ? 'checked' : '')).' onclick="if(this.checked) {set_active(1,\'guide\','.$_REQUEST['edit'].','.$_SESSION['userID'].');} else{set_active(0,\'guide\','.$_REQUEST['edit'].','.$_SESSION['userID'].');} "/> Описанието е активно.<a href=\'#\' id=\'aktivirane_spravochnik\' style=\'z-index:1000;\' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Активирай/Деактивирай Справочно Описание] body=[Можете да изберете дали Вашето справочно описание да бъде видимо за останалите читатели на GoZBiTe.Com или не!]\'><img src=\'images/help.png\' /></a>';
}

$guides_main_edit .= '
        <br /><br />
      <div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
	  		if (eregi("^[0-9]+",$edit))
	  		{	
	  	
	  		$guides_main_edit .= '<input type="submit" value="Редактирай" id="edit_btn" title="Редактирай" name="edit_btn"  onclick="return checkForCorrectDataGuide();">	';
	  		
	  	
	  		}
	  	
	  	
	  		if (!eregi("^[0-9]+",$edit))
	  		{	
	  
	  		$guides_main_edit .= ' <input type="submit" value="Добави" id="insert_btn" title="Добави" name="insert_btn"  onclick="return checkForCorrectDataGuide();">	';
	  		
	  
	  		}
	  	
	
	  $guides_main_edit .= ' </div>
		 </div> </div>		     		 	
 </div>
 <br style="clear:left;">';
	

	        
	    
	return $guides_main_edit;
	  
	?>
