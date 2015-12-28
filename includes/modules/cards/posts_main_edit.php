<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
 	$posts_main_edit = "";

   	$edit=$_REQUEST['edit'];



	if (isset($edit))
	{
		$editID=$edit;
		
		$clauses = array();
	   	$clauses['where_clause'] = " AND p.postID = '".$editID."'";
		$clauses['order_clause'] = '';
		$clauses['limit_clause'] = ' LIMIT 1';
		$post_edit_info = $this->getItemsList($clauses);
	
		if(!$post_edit_info)
		{
			return false;
		}
		$resultEdit = $post_edit_info[$editID];	
		
				
		/* Ne dopuskame redakciq na chujdi statii */
		if($resultEdit['autor'] != $_SESSION['userID'] && $_SESSION['user_kind'] != 2) exit;
		
	
	}

	
$posts_main_edit .= '<div id="search_form" style=" margin-top:0px; width:650px;">

<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #6DCA31; padding:5px; background-color:#F1F1F1;">

<div class="postBig">';
 		
	
	$posts_main_edit .= '<div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
		  		if (eregi("^[0-9]+",$edit))
		  		{	
		  			$posts_main_edit .= '<input type="submit" value="Редактирай Статията" id="edit_btn" title="Редактирай Статията" name="edit_btn" onclick="return checkForCorrectDataPost();">';	
		  		
		  	 
		  		}
		  
		  	
		  		if (!eregi("^[0-9]+",$edit))
		  		{	
		  	
		  			$posts_main_edit .= '<input type="submit" value="Добави Статията" id="insert_btn" title="Добави Статията" name="insert_btn"  onclick="return checkForCorrectDataPost();">';	
		  		
		  	 
		  		}
					  	
				  		
				
	$posts_main_edit .= ' </div>
				  <br /><br /><br />
				  
				  <input type=\'hidden\' name=\'MAX_FILE_SIZE\' value=\'999999999\'>
				  <input type=\'hidden\' name=\'edit\' value=\''.$edit.'\'>
				  <input type=\'hidden\' name=\'autor\' value=\''.$resultEdit['autor'].'\'>
				  <input type=\'hidden\' name=\'autor_type\' value=\''.$resultEdit['autor_type'].'\'>
				
				<table>
				<tr>  
				<td style="margin:10px;margin-left:0px;width:300px;" valign="top"> 
		            <label for = "post_category">Категория*</label><br>';
		           
		               $posts_main_edit .= "     <select name = \"post_category\" id = \"post_category\" size = \"15\" align = \"left\" style = \"width:250px; margin-right: 10px;\">\n";
		               $posts_main_edit .= "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
		               require_once("includes/classes/PostCategoriesList.class.php");
		               $CCList = new PostCategoriesList($conn);
		               if($CCList->load())
		                   $posts_main_edit .=$CCList->showselectlist(0, "", $resultEdit['category_id']);
		               $posts_main_edit .= "     </select>\n";
		            
		               	               
		$posts_main_edit .= '</td>
		       
			 <td valign="top">
			     
				  Заглавие на Статията *<br /> <textarea rows = "2" cols = "53"  name="post_title" id="post_title" >'.$resultEdit['title'].'</textarea>
			 	  <br /><br />
			 	  
			 	  Източник на Статията *<br /> <input type="text" size="20" style="width:350px;"   name="post_source" id="post_source" value="'.$resultEdit['source'].'" />
				  <br /> <br />';
		    
	    	if($resultEdit['numTags'] > 0) 
			{				 	
				for($i=0, $cn=1; $i<$resultEdit['numTags']; $i++, $cn++) 
				{						
					$post_edit_tags[] = $resultEdit['Tags'][$i];						
				} 
			}	
		$posts_main_edit .= 'Етикети към Статията <font style="font-size:10px;">(ключови думи, разделени със запетайки)</font> <br /> <textarea   maxlength="250" onkeyup="return ismaxlength(this)" rows = "2" cols = "53"  name="post_tags" id="post_tags" >'.implode(",",$post_edit_tags).'</textarea>';				  				  
				
		$posts_main_edit .= ' <br /> <br />
				  
			 </td>
		</tr>
		 <tr>
		
	
  		<td colspan="2">
  		<!--  		
  		Текст на Статията*<br />   		 
  		<textarea id="post_body" name="post_body">'.$resultEdit['body'].'</textarea>
  		<script type="text/javascript">
			CKEDITOR.replace( \'post_body\' );
		</script>  		
  		-->
  		<br />
				 Текст на Статията*<br /> ';
			
				 include_once("FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('post_body') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '640';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = $resultEdit['body'];
		        $posts_main_edit .= $oFCKeditor->CreateHtml();
			
	$posts_main_edit .= '<br /> <br />
		 </td>
		 </tr>				 
					
			<tr>
			<td colspan="2">
           		 	            		 		
           		 <table><tr>
           		 	<td valign="top">
	           		  Основна Снимка
					 	<div id="picsDv">';
											  		
                  			$posts_main_edit .=  "<div style = \"margin: 0px 0px 5px 0px;\">\n";
                  			$posts_main_edit .=  " <input type = \"file\" name = \"post_pic\">";
                  			$posts_main_edit .=  "</div>\n";	               	  		
	           		      
	           		 	$posts_main_edit .= '</div>	
           		 	
                  	</td>
                  	<td valign="top"> ';
	                  
							  if ($resultEdit['picURL']!='')
							  {  
							  	$posts_main_edit .= "<div style='float:left; margin:0px; width:200px;' >";
								  
						    			
					       			$posts_main_edit .= '<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60" onclick = "get_pic(\'big_pic\', \''.$resultEdit['picURL'].'\' ); "';
					       			 if($resultEdit['picURL']!='') 
					       			 {
					       			 	$posts_main_edit .= 'src=\'pics/posts/'.$resultEdit['picURL'].'\' />';
					       			 }
					       			 else $posts_main_edit .= 'src=\'no_photo_thumb.png\' />';
					       			 $posts_main_edit .= '</div>

					       			<div style="float:left;cursor:pointer;" >
					       				<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-снимка-на-статия-'.$resultEdit['picURL'].','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],50,'_',''):'Статии_за_здраве').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
					       			</div>';
					   
								  
								  $posts_main_edit .= '</div>';
							}
				        
				         
			        $posts_main_edit .= '</td></tr>
			        <tr><td colspan="2"> <br /> <hr style="width:640px"> <br /></td></tr>
                  	<tr><td valign="top">
                  	
		                  	<div style="float:left;margin:10px;margin-left:0px;width:220px;"> 
							 Още Снимки:
									<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
		                  	
		                  	</div>
           		 			
   		 			   
         	
           		 	</td><td valign="top">';
	           		 	 
							    $posts_main_edit .= "<div style='float:left; margin-left:20px; width:400px;' >";
							    							    
								if($resultEdit['numPics'] > 0) 
								{ 									
									  foreach ($resultEdit['resultPics']['url_thumb'] as $pics_thumb)
							   		  {		  	         			
											$posts_main_edit .= '<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60"';
					       					$posts_main_edit .= 'src=\'pics/posts/'.$pics_thumb.'\' />';
							       			$posts_main_edit .= '</div>
							       			<div style="float:left;cursor:pointer;" >
							       			<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-друга-снимка-на-статия-'.$pics_thumb.','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],50,'_',''):'Статии_за_здраве').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
							       			</div>';
											
							   		  }										
								 }
  
								  $posts_main_edit .= "</div>";
							
				                    
			         
			         $posts_main_edit .= '</td></tr></table>
           		 </td>
			 </tr>	
           	<tr>
           	<td colspan="2">         		 	
        
           	<fieldset  style="width:640px">	
            <legend>.:: Видео Представяне ::.</legend>';
            
            
            	$video_name = $edit;
            	
				if(file_exists("../videos/posts/".$video_name.".flv"))
				{
					$video = "videos/posts/".$video_name.".flv";
					
					$posts_main_edit .= '<br>
					
					<div id="videoDIV"  style="margin-left:0px;">
					<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
						<script type="text/javascript">
							var FO = {movie:"flash_flv_player/flvplayer.swf",width:"350",height:"200",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
							flashvars:"file=../videos/posts/'.$video_name.'.flv'.'&image=../videos/posts/'.$video_name.'_thumb.jpg'.'" };
							UFO.create(FO, "player1");
						</script>
					</div>
					
					<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-видео-на-статия-'.$editID.','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],50,'_',''):'Статии_за_здраве').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>';
	       			
				    
				} 
				         				
				$posts_main_edit .= ' <label>Прикачи видео: </label><input type="file" name="imagefile"> (Само ".flv" формат)<br>';
				
				
				if(is_array($_REQUEST)) {
				      for(reset($_REQUEST); $filedName = key ($_REQUEST); next($_REQUEST)) {
				         $$filedName = $_REQUEST[$filedName];
				      }
				   }
				//$big_resize= "-s 320x240 -r 15  -b 768"; 
				//$normal_resize= "-s 320x240 -r 15  -b 160";
				//$small_resize= "-s 240x180 -r 8  -b 90";  
				
				
				
		
				
				$posts_main_edit .= '<br />
				Видео от YOUTUBE.COM:
					<input type="text" style="width:380px;" name="youtube_video" id="youtube_video" value = "';
				$posts_main_edit .= (strlen($resultEdit['youtube_video']) > 0) ? $resultEdit['youtube_video'] : ""; 
				$posts_main_edit .= '">
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
	  	
	  		$posts_main_edit .= '<input type="submit" value="Редактирай Статията" id="edit_btn" title="Редактирай Статията" name="edit_btn"  onclick="return checkForCorrectDataPost();">	';
	  		
	  	
	  		}
	  	
	  	
	  		if (!eregi("^[0-9]+",$edit))
	  		{	
	  
	  		$posts_main_edit .= ' <input type="submit" value="Добави  Статията" id="insert_btn" title="Добави Статията" name="insert_btn"  onclick="return checkForCorrectDataPost();">	';
	  		
	  
	  		}
	  	
	
	  $posts_main_edit .= ' </div>
		 </div> </div>		     		 	
 </div>
 <br style="clear:left;">';
	

	        
	    
	return $posts_main_edit;
	  
	?>
