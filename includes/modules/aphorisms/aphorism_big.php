<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$aphorism_big = "";
   	
	$clauses = array();
   	$clauses['where_clause'] = " AND a.aphorismID = '".$_REQUEST['aphorismID']."'";
	$clauses['order_clause'] = '';
	$clauses['limit_clause'] = ' LIMIT 1';
	$aphorism_big_info = $this->getItemsList($clauses);

	if(!$aphorism_big_info)
	{
		return false;
	}
	$aphorismBig = $aphorism_big_info[$_REQUEST['aphorismID']];	
		
	
//$aphorism_big .=print_r($aphorismBig,1);
		
$aphorism_big .= '
<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">

<div style="float:left; margin-bottom:20px;" id="next_previousDIV"></div>';



$aphorism_big .= '<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">';
	if($aphorismBig['title'] == 'GoZbiTe.Com')
{ 
	$aphorism_big .= '<div style=" float:left; margin-left:6px; width:370px;color:#FFF;font-weight:bold;" ><h3><a  style="font-weight:bold; color: #FFFFFF;" href="http://gozbite.com">'.$aphorismBig['title'].'</a></h3></div>';
} else {
	$aphorism_big .= '<div style=" float:left; margin-left:6px; width:370px;color:#FFF;font-weight:bold;" >'.$aphorismBig['title'].'</div>';
} 
	
$aphorism_big .= '	<div id="track1" class="track" style="margin-right:5px; width: 130px; margin-bottom:3px;" >
	   <div id="handle1" class="handle" style="width: 30px;" ><p id="changed" style="color:#FFFFFF; text-align:center;  font-size:10px; font-weight:bold; line-height:1.2;">12px</p></div>
	</div>';
	/*
$aphorism_big .= '<script type="text/javascript">
		new Control.Slider(\'handle1\' , \'track1\',
		{
			range: $R(10,28),
			values: [10,12,14,18,24,28],
			sliderValue: 12,
			onChange: function(v){
				var objTextBody = document.getElementById(\'tabs_inside\');		
			   	objTextBody.style.fontSize = v+"px";
			   	 $(\'changed\').innerHTML = v+"px";
			   	
			},
			onSlide: function(v) {
			  	var objTextBody = document.getElementById(\'tabs_inside\');
			  	objTextBody.style.fontSize = v+"px";
			  	 $(\'changed\').innerHTML = v+"px";
			}
		} );
	</script>	';
	*/
	
	
	if((($aphorismBig['autor'] == $_SESSION['userID'] && $_SESSION['user_type']==$aphorismBig['autor_type']) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {	
	$aphorism_big .= '	<div style="float:right; margin-right:5px;" ><a href="редактирай-афоризъм-'.$aphorismBig['aphorismID'].','.myTruncateToCyrilic($aphorismBig['body'],100,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>';
	}
	if((($_SESSION['user_kind'] == 2) or $_SESSION['userID']==1)) {	
	$aphorism_big .= '	<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-афоризъм-'.$aphorismBig['aphorismID'].','.myTruncateToCyrilic($aphorismBig['body'],100,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
	}

		$aphorism_big .= '<br style="clear:both;"/>							
</div>
<br />	
	

<div class="actual_theme">	
<p>
	

	
	<div id="tabs_inside" style="width:660px;">';

		
	
			if(is_file("pics/aphorisms/".$aphorismBig['picURL'])) $picFile= "pics/aphorisms/".$aphorismBig['picURL'];
		   	else $picFile = 'pics/aphorisms/no_photo_big.png';
		   	
		    list($width, $height, $type, $attr) = getimagesize($picFile);
			$pic_width_or_height = 180;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
			if (($height) && ($width))	
			{
				if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
				else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
			}
			
			
			
			//------------------------------------ Other Last Posts -------------------------------------//
			 	$response = '';
		  		$response .= '<h3 style="margin: 0px 0px 10px 0px; padding-left:5px; font-size:12px;  font-weight:bold; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style="font-weight:bold;"  href="афоризми-all_aphorisms,още_полезни_афоризми_за_здравето.html" >Още Афоризми</a></h3>';
		
			    	
		  		$clauses['where_clause'] = " AND a.aphorismID NOT IN ('".$aphorismBig['aphorismID']."')";
				$clauses['order_clause'] = ' ORDER BY RAND(), a.date DESC';
				$clauses['limit_clause'] = ' LIMIT 5';
				$related_items = $this->getItemsList($clauses);
	
					
				foreach($related_items as $Itm)
				{
				   if(is_file('pics/aphorisms/'.$Itm['picURL'])) $picFileRelatedPosts= 'pics/aphorisms/'.$Itm['picURL'];
				   else $picFileRelatedPosts = 'pics/aphorisms/no_photo_thumb.png';
				   		 
				 	list($widthRelatedPosts, $heightRelatedPosts, $typeRelatedPosts, $attrRelatedPosts) = getimagesize($picFileRelatedPosts);
					$pic_width_or_heightRelatedPosts = 50;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightRelatedPosts) && ($widthRelatedPosts))	
					{
						if($widthRelatedPosts >= $heightRelatedPosts)	{$newheighRelatedPosts = ($heightRelatedPosts/$widthRelatedPosts)*$pic_width_or_heightRelatedPosts; $newwidthRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
						else					{$newwidthRelatedPosts = ($widthRelatedPosts/$heightRelatedPosts)*$pic_width_or_heightRelatedPosts; $newheightRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
					}
				
				   $response .=	'<div style="width:250px;font-size:12px;font-family: "Trebuchet MS", Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'прочети-афоризъм-'.$Itm['aphorismID'].','.myTruncateToCyrilic($Itm['body'],100,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\'; document.getElementById(\'aphorismImgDiv_'.$Itm['aphorismID'].'\').style.borderColor=\'#0099FF\';" onMouseout="this.style.backgroundColor=\'transparent\';  document.getElementById(\'aphorismImgDiv_'.$Itm['aphorismID'].'\').style.borderColor=\'#CCCCCC\';">';
				   $response .= '<table><tr>';
				   $response .= '<td valign="top">';
				   $response .= '<a href="прочети-афоризъм-'.$Itm['aphorismID'].','.myTruncateToCyrilic($Itm['body'],100,"_","").'.html" ><div id="aphorismImgDiv_'.$Itm['aphorismID'].'" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:60px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidthRelatedPosts?$newwidthRelatedPosts:50).'"  src="'.$picFileRelatedPosts.'" /></div></a>';
				   $response .= '</td><td valign="top"><div style="margin-left:5px; width:180px;" ><a href="прочети-афоризъм-'.$Itm['aphorismID'].','.myTruncateToCyrilic($Itm['body'],100,"_","").'.html" style="color:#666666;" >'.myTruncate($Itm['body'], 100, " ").'</a></div>';
				   $response .= '</td></tr></table>';	            
				   $response .= '</div>';
				}
			   	    
			//----------------------------------------------------------------------------------------------------//
			
			
			
	$aphorism_big .= '<a href="'.$picFile.'" class="lightview" rel="gallery" ><div  onMouseover="this.style.borderColor="#0099FF";" onMouseout="this.style.borderColor="#CCCCCC";"  style="float:left; margin:5px;  border:1px solid #CCCCCC; width:190px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:180).'"  src="'.$picFile.'" /></div></a>';
	$aphorism_big .= '<div style="float:right; width:250px; padding:5px; border-left:1px double #CDC8B4;">';
    $aphorism_big .= $response; 
    $aphorism_big .= '</div>'.insertADV(strip_tags($aphorismBig['body'],'<br><br /><a><p><b><strong>')).'</div>';
		
	$aphorism_big .= '<br style="clear:left;"/>		
		
		
</p>	
</div>';


$aphorism_big .= '<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
	<div style=" float:left; font-size:14px; margin-left:6px; width:250px;color:#FFFFFF; " ><i>'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($aphorismBig['date']))) .'</i></div>
	<br style="clear:both;"/>							
</div>
	
<br style="clear:both;"/>	';


$aphorism_big .= '<div id="options">';
	
$aphorism_big .= '<div style="float:right;margin-right:10px;">
            <div style="float:left; margin-right:2px;" >
				<fb:like href="http://www.GoZBiTe.Com/прочети-афоризъм-'.$aphorismBig['aphorismID'].','.myTruncateToCyrilic(strip_tags($aphorismBig['body']),100,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="21" action="like" colorscheme="light"></fb:like>								
				<span style="background:transparent; color:#6B9D09; font-size:12px; font-weight:bold;">Сподели в: </span>
				<a href="http://www.facebook.com/sharer.php?u=http://www.GoZBiTe.Com/прочети-афоризъм-'.$aphorismBig['aphorismID'].','.myTruncateToCyrilic($aphorismBig['body'],100,'_','') .'.html&amp;t='.$aphorismBig['body'].'" target="_blank"><img src="images/facebook.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;
				<a href="http://twitter.com/home?status='.myTruncateToCyrilic($aphorismBig['body'],200,'_','') .', http://www.GoZBiTe.Com/прочети-афоризъм-'.$aphorismBig['aphorismID'].','.myTruncateToCyrilic($aphorismBig['body'],100,'_','') .'.html" target="_blank"><img src="images/twitter.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;<a href="http://www.google.com/buzz/aphorism" data-locale="bg" target="_blank"><img src="i/ico/google.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>
			</div>';
			
$aphorism_big .= '<div style="float:right; margin-right:2px;" >';
$aphorism_big .= '<a href = "javascript://void(0);" onclick = \'window.open("includes/tools/sendStuffToFriend.php?aphorismID='.$aphorismBig['aphorismID'].'", "sndWin", "top=0, left=0, width=440px, height=500px, resizable=yes, toolbars=no, scrollbars=yes");\' class = "smallOrange"><img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a></div>';
$aphorism_big .= '<div style="float:right; margin-right:2px;" >';
$aphorism_big .= '<a href = "javascript://" onclick = "window.print();"  class = "smallOrange"><img style="margin-left:5px;" src="images/print.gif" alt="Разпечатай" width="14" height="14"></a></div>';
$aphorism_big .= '</div></div>';


			
		$aphorism_big .= '<div class="detailsDiv" style="float:left; width:650px; margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		
			<a href="javascript://void(0);)" onclick=" new Effect.toggle($(\'writeComments\'),\'Blind\'); "><h4>Коментирай</h4></a>
			
			<div id="writeComments" style="width:100%;  ">
			
			<!--
				
				 <table><tr><td align="left">
				 	 <table><tr><td colspan="2">
    				 		<input type="hidden" name="aphorismID" value="'.$_REQUEST['aphorismID'].'"/>
    				  		Името Ви:<br /> <input type="text" name="sender_name" id="sender_name" maxlength="30" style="width:300px;"/>
    				 </td></tr>
					
    				 <tr><td colspan="2">	    				  				
    				 		Текст:<br /> 
    				 		<textarea rows = "4" cols = "40"  name="comment_body" id="comment_body" style="width:300px;"></textarea>
    				</td>
    				</tr>
					<tr><td style="width:200px;">					
				 		<br />
				 		<fieldset style="width:110px;" ><img src="../verificationimage/picture.php" /></fieldset>
			      		<br />
			      		<input style="width:110px;" type="text" name="verificationcode" value="" />
				 		<br />
						Въведете кода от картинката.						
					</td>
					<td style="width:100px;">
    					<input type="hidden" name="insert_comment_btn" value="" />					
						<input type="image" value="Добави" src="images/btn_gren_insert.png" onclick="if('.($_SESSION['userID']?'true':'false').') { alert(\'test\');)$(\'insert_comment_btn\').setValue("Добави"); return checkForCorrectComment();} else{alert("Необходимо е да влезете в системата за да направите своя коментар.");return false;} " id="insert_comment_btn" title="Добави Коментар" name="insert_comment_btn" style="border: 0pt none ; display: inline;" height="20"  width="96">
					</td></tr>
    				</table>
    			</td><td width="20">&nbsp;</td><td align="right">';
				  //require_once("inc/googleAdsense_300x250px.inc.php"); // Pokazva GoogleAdsense   
$aphorism_big .= '</td></tr></table>
    		 		-->
    		 	<table><tr><td align="left" valign="top">
	    		 	<fb:comments xid="gozbite_aphorism_'.$aphorismBig['aphorismID'].'" numaphorisms="10" width="650"  send_notification_uid="1544088151"></fb:comments>
				</td>
				<td width="20">&nbsp;</td>
				<td align="right" valign="top">';
//$aphorism_big .= require("includes/modules/googleAdsense_300x250px.php"); // Pokazva GoogleAdsense   
$aphorism_big .= '</td></tr></table>
    		 
			</div>';
				
$aphorism_big .= '			
	<!--			
			
		<h4 style="cursor:pointer; font-size:12px;" onclick=" new Effect.toggle($(\'readComments\'),\'Blind\'); if ($(\'readComments\').visible()) {$(\'search_div_link\').update("Покажи Коментарите ('.($numPostsComment?$numPostsComment:0).')");} else {$(\'search_div_link\').update("Скрий Коментарите ('.($numPostsComment?$numPostsComment:0).')");}"><div id="search_div_link" class="detailsDiv">Скрий Коментарите ('.($numPostsComment?$numPostsComment:0).')</div></h4>
			
		<div id="readComments" style=" width:100%; overflow: scroll; ">
					
			Благодарим на всички за коментарите. Вашите забележки ще бъдат взети в предвид. ';
			
			if($aphorismBig['numComments']>0)
	    	{
	    	    for($i=0;$i<$aphorismBig['numComments'];$i++)
	    	    {
	    	
			    	    //************ Автора за всяка тема ****************
			    
	    	    	$table = (($aphorismBig['Comments'][$i]['autor_type']=='user')?'users':(($aphorismBig['Comments'][$i]['autor_type']=='hospital')?'hospitals':'doctors'));
	    	    	
					$sql="SELECT ".(($aphorismBig['Comments'][$i]['autor_type']=='hospital')?"name":" CONCAT(first_name, ' ', last_name)")." as 'autor_name', username as 'autor_username' FROM ".$table." WHERE ".(($aphorismBig['Comments'][$i]['autor_type']=='user')?'userID':'id')." = '".$aphorismBig['Comments'][$i]['autor']."' LIMIT 1";
					$conn->setsql($sql);
					$conn->getTableRow();
					$resultMneniqAvtor = $conn->result['autor_name'];
					$resultMneniqAvtorUsername = $conn->result['autor_username'];
					
					if($aphorismBig['Comments'][$i]['autor'] == 1 && $aphorismBig['Comments'][$i]['autor_type'] == 'user')
					{
						$resultMneniqAvtor = 'Админ';
					}
					
	    	    	if($aphorismBig['Comments'][$i]['sender_name'] != '')
					{
						$resultMneniqAvtor = $aphorismBig['Comments'][$i]['sender_name'];
					}
		
					if($aphorismBig['Comments'][$i]['autor_type']=='user')
					{
						if(is_file("../pics/users/".$aphorismBig['Comments'][$i]['autor']."_avatar.jpg")) $picFile= "pics/users/".$aphorismBig['Comments'][$i]['autor']."_avatar.jpg";
					   	else $picFile = 'pics/users/no_photo_thumb.png';
					}
					elseif($aphorismBig['Comments'][$i]['autor_type']=='hospital')
					{
						if(is_file("../pics/firms/".$aphorismBig['Comments'][$i]['autor']."_logo.jpg")) $picFile= "pics/firms/".$aphorismBig['Comments'][$i]['autor']."_logo.jpg";
					   	else $picFile = 'pics/firms/no_logo.png';
					}
					else
					{
						if(is_file("../pics/doctors/".$aphorismBig['Comments'][$i]['autor']."_1_thumb.jpg")) $picFile= "pics/doctors/".$aphorismBig['Comments'][$i]['autor']."_1_thumb.jpg";
					   	else $picFile = 'pics/doctors/no_photo_thumb.png';
					}
				
					list($width, $height, $type, $attr) = getimagesize($picFile);
					$pic_width_or_height = 100;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($height) && ($width))	
					{
						if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
						else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
					}		
					
				//***********************************************************************
				
				//========================= Вземаме броя на мненията за всеки Участник =============================
						
			    	$sql="SELECT cnt_comment FROM ".(($aphorismBig['Comments'][$i]['autor_type']=='user')?'users':(($aphorismBig['Comments'][$i]['autor_type']=='hospital')?'hospitals':'doctors'))." WHERE ".(($aphorismBig['Comments'][$i]['autor_type']=='user')?'userID':'id')." = '".$aphorismBig['Comments'][$i]['autor']."' LIMIT 1";
			    	$conn->setsql($sql);
			    	$conn->getTableRow();
					$resultCntMneniqForAutor = $conn->result['cnt_comment'];
			    	
				//==================================================================================================
				
				//========================= Проверяваме дали участника е ОН-Лайн ===================================
						
			    	$sql="SELECT session_name FROM sessions WHERE session_name = '".$resultMneniqAvtorUsername."' LIMIT 1";
			    	$conn->setsql($sql);
			    	$conn->getTableRow();
					$resultAutorOnLine = (($conn->result['session_name'] != '')?1:0);
			    	
				//==================================================================================================
				
		 		
			 
				 	
			$aphorism_big .= '<div class="detailsDiv" style="float:left; width:620px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFF;">
				<table><tr><td valign="top">
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						'.(($aphorismBig['Comments'][$i]['autor_type'] == 'user') ? '<a href="users.php?userID='.$aphorismBig['Comments'][$i]['autor'].'">'.$resultMneniqAvtor : (($aphorismBig['Comments'][$i]['autor_type'] == 'hospital')? '<a href="hospitals.php?firmID='.$aphorismBig['Comments'][$i]['autor'].'">'.$resultMneniqAvtor :'<a href="doctors.php?doctorID='.$aphorismBig['Comments'][$i]['autor'].'">'.$resultMneniqAvtor))  .'
					</div>
					<div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" ><img width="'.$newwidth.'" height="'.$newheight.'" src="'.$picFile.'" /></div></a>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						Мнения:'.$resultCntMneniqForAutor.'
					</div>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						'.(($resultAutorOnLine == 1)?'<font color="green">Он-лайн</font>':'<font color="red">Оф-лайн</font>').'
					</div>					
				</td>
				<td style="border-right:1px dotted #CCCCCC; padding:2px; width:10px;"></td>
				<td valign="top">
					<h4 style="color:#FF8400">'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($aphorismBig['Comments'][$i]['created_on']))).'</h4>
				
					<div class="detailsDiv" style="float:left; width:460px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE; color:#FFFFFF;">'. stripslashes($aphorismBig['Comments'][$i]['comment_body']);							
     $aphorism_big .= '</div>
				</td></tr></table>
				
				<hr style="float:left;margin-top:20px;color: #eee;background-color: #eee; height:1px; border:0; width:600px;" />  
				
				<br style="clear:both;" />
			</div>';
	    	    
                	    	
	    
                } 
	    	}    	   	
	    	
		    	
	    	
		$aphorism_big .= '	</div>
			
			-->		
					
</div>

</div>
<br style="clear:left;"/></div>';


return $aphorism_big;

?>