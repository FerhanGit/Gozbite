<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();


   	// Фикс за администратора - той трябва да вижда всички оферти! Останалите виждат само активните!
	if($_SESSION['user_kind'] == 2 OR $_SESSION['user_kind'] != 2) $andActive = '';
	else $andActive = " AND g.active = '1' ";

	
	if(!isset($_REQUEST['guideID']) OR empty($_REQUEST['guideID']))
	{
		$clauses = array();
 		$clauses['where_clause'] = " $andActive ";
		$clauses['order_clause'] = ' ORDER BY if(rand()<0.5,g.registered_on,RAND())';
		$clauses['limit_clause'] = ' LIMIT 1';
		$lasts = $this->getItemsList($clauses);
		foreach ($lasts as $guideID => $randomGuideInfo)
		{
			$_REQUEST['guideID'] = $guideID;
		}
	}
	
	
	
	
	   	
   	$guides_main = "";
	
   	$clauses = array();
 	$clauses['where_clause'] = " AND g.id = '".$_REQUEST['guideID']."'";
	$clauses['order_clause'] = '';
	$clauses['limit_clause'] = ' LIMIT 1';
	$lasts = $this->getItemsList($clauses);
	foreach ($lasts as $guideID => $guideInfo)
	{
		$guideBig = $guideInfo;
	}
			
	//log_post($guideBig['postID']); // сложено е тук, защото за guides_main.php няма postID в main.php

$guides_main .=	'<script type="text/javascript">
						makeViewLog(\'guide\',\''.$guideBig['guideID'].'\');
					</script>';
	
	
$guides_main .= '
<div class="actual_theme" style="text-align:center; color:#FF6600; font-size:16px; padding-bottom:3px; margin-bottom:0px; border-top:1px solid #CDC8B4; border-bottom:2px solid #FF6600;">	
<h4>'.$guideBig['title'];
		if($guideInfo['active'] != 1) 
		{ 
			$guides_main .= '<span style="color:#FF0000;" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Неактивно Описание!] body=[&rarr; Описанието е деактивирано от страна на неговия автор или от администратора на портала.]\'> | Неактивно! </span>';
		}
$guides_main .= '</h4> ';
	 
		if(($guideBig['firm_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'firm') OR ($guideBig['user_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'user') or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1) 
		{	
			$guides_main .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-справочник-'.$guideBig['guideID'].','.myTruncateToCyrilic($guideBig['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a>';
			if($guideBig['gold'] == '1')
			{
				$guides_main .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
			} 
			elseif($guideBig['silver'] == '1') 
			{
				$guides_main .= '<img style="margin-left:5px;" src="images/star_grey.gif">';
			}
			$guides_main .= '</div>';
	} 
	else
	{ 
			$guides_main .= '<div style="float:right; margin-right:5px;" >';
			if($guideBig['gold'] == '1') 
			{ 
				$guides_main .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
			} 
			elseif($guideBig['silver'] == '1') 
			{ 
				$guides_main .= '<img style="margin-left:5px;" src="images/star_grey.gif">';
			}
			$guides_main .= '</div>';
	}
	if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) 
	{	
		$guides_main .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-справочник-'.$guideBig['guideID'].','.myTruncateToCyrilic($guideBig['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
	}	
$guides_main .= '								
</div>

<div class="actual_theme">	
<p>
	

	
	<div id="tabs_inside" style="width:660px;">

		
	<div id="track1" class="track" style="margin-right:5px; width: 130px; margin-bottom:3px;" >
	   <div id="handle1" class="handle" style="width: 30px;" ><p id="changed" style="color:#FFFFFF; text-align:center;  font-size:10px; font-weight:bold; line-height:1.2;">12px</p></div>
	</div>';
	
/*	
$guides_main .= '
	<script type="text/javascript">
		new Control.Slider(\'handle1\' , \'track1\',
		{
			range: $R(10,28),
			values: [10,12,14,18,24,28],
			sliderValue: 12,
			onChange: function(v){
				var objTextBody = document.getElementById("tabs_inside");		
			   	objTextBody.style.fontSize = v+"px";
			   	 $(\'changed\').innerHTML = v+\'px\';
			   	
			},
			onSlide: function(v) {
			  	var objTextBody = document.getElementById("tabs_inside");
			  	objTextBody.style.fontSize = v+"px";
			  	 $(\'changed\').innerHTML = v+\'px\';
			}
		} );
	</script>';	
*/
	
				
$guides_main .= '<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style=" font-size:14px; font-weight:bold;" href="разгледай-справочник-'.$guideBig['guideID'].','.myTruncateToCyrilic($guideBig['title'],200,'_','') .'.html" >'.$guideBig['title'].'</a></h3>';
		
		 
		
			if(is_file("pics/guides/".$guideBig['resultPics']['url_big'][0])) $picFile= "pics/guides/".$guideBig['resultPics']['url_big'][0];
		   	else $picFile = 'pics/guides/no_photo_big.png';
		   	
		    list($width, $height, $type, $attr) = getimagesize($picFile);
			$pic_width_or_height = 180;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
			if (($height) && ($width))	
			{
				if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
				else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
			}
			
			
			
			
			
			//------------------------------------ Related Guides -------------------------------------//
			 	$response = '';
		  		$response .= '<h3 style="margin: 0px 0px 10px 0px; padding-left:5px; font-size:12px;  font-weight:bold; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style="font-weight:bold;"  href="справочник-all_guides,справочник_полезни_съвети.html" >Още от Справочника</a></h3>';
				
			    $clauses['where_clause'] = " AND g.id NOT IN ('".$guideBig['guideID']."')";
				$clauses['order_clause'] = ' ORDER BY g.registered_on DESC';
				$clauses['limit_clause'] = ' LIMIT 5';
				$related_items = GUIDES::getItemsList($clauses);
	
				foreach($related_items as $Itm)
				{
				   if(is_file('pics/guides/'.$Itm['resultPics']['url_thumb'][0])) $picFileRelatedPosts= 'pics/guides/'.$Itm['resultPics']['url_thumb'][0];
				   else $picFileRelatedPosts = 'pics/guides/no_photo_thumb.png';
				   		 
				 	list($widthRelatedPosts, $heightRelatedPosts, $typeRelatedPosts, $attrRelatedPosts) = getimagesize($picFileRelatedPosts);
					$pic_width_or_heightRelatedPosts = 50;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightRelatedPosts) && ($widthRelatedPosts))	
					{
						if($widthRelatedPosts >= $heightRelatedPosts)	{$newheighRelatedPosts = ($heightRelatedPosts/$widthRelatedPosts)*$pic_width_or_heightRelatedPosts; $newwidthRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
						else					{$newwidthRelatedPosts = ($widthRelatedPosts/$heightRelatedPosts)*$pic_width_or_heightRelatedPosts; $newheightRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
					}
				
				   $response .=	'<div style="width:250px;font-size:12px;font-family: "Trebuchet MS", Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-справочник-'.$Itm['guideID'].','.myTruncateToCyrilic($Itm['title'],200,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\'; document.getElementById(\'postImgDiv_'.$Itm['guideID'].'\').style.borderColor=\'#0099FF\';" onMouseout="this.style.backgroundColor=\'transparent\';  document.getElementById(\'postImgDiv_'.$Itm['guideID'].'\').style.borderColor=\'#CCCCCC\';">';
				   $response .= '<table><tr>';
				   $response .= '<td valign="top">';
				   $response .= '<a href="разгледай-справочник-'.$Itm['guideID'].','.myTruncateToCyrilic($Itm['title'],200,"_","").'.html" ><div id="postImgDiv_'.$Itm['guideID'].'" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:60px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidthRelatedPosts?$newwidthRelatedPosts:50).'"  src="'.$picFileRelatedPosts.'" /></div></a>';
				   $response .= '</td><td valign="top"><div style="margin-left:5px; width:180px;" ><a href="разгледай-справочник-'.$Itm['guideID'].','.myTruncateToCyrilic($Itm['title'],200,"_","").'.html" style="color:#666666;" >'.myTruncate($Itm['title'], 90, " ").'</a></div>';
				   $response .= '</td></tr></table>';	            
				   $response .= '</div>';
				}
				
				
				
		//----------------------------------------------------------------------------------------------------//
			
			
		$guides_main .= '
		<a  href="'.$picFile.'" class=\'lightview\' rel=\'gallery\' ><div  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="float:left; margin:5px;  border:1px solid #CCCCCC; width:190px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:180).'"  src="'.$picFile.'" /></div></a>
		<div style="float:right; width:280px; padding:5px; border-left:1px double #CDC8B4;">'.$response.'</div>
		'.insertADV(strip_tags($guideBig['info'],'<br><br /><a>')).'
		
		
		
				
		</div><br style="clear:left;"/>
		
				
		
	</p>	
</div>


<br style="clear:left;"/>

<div class="postBig">';
	

if($guideBig['numTags'] > 0) 
 {
 	$guides_main .= '<table><tr><td> 
		     <div class="postBig">
				<div class="detailsDiv" style="float:left; width:640px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<h4 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;">
						<div style="margin-left:6px; height:22px; width:450px;color:#0099FF;font-weight:bold;" >Етикети</div>		
					</h4>';
					 
						$guides_main .= '	<table cellpadding="2"><tr>';
						 for($i=0, $cn=1; $i<$guideBig['numTags']; $i++, $cn++) 
						 {						
							$guides_main .= '<td width="125"><h4 style="font-size:12px; padding-left:5px; margin-top:2px;"><a  style="font-size:12px;" href="справочник-етикет-'.$guideBig['Tags'][$i].',още_справочни_описания.html">'.$guideBig['Tags'][$i].'</a></h4></td>';
							if($cn % 5 == 0) { $guides_main .=  "</tr><tr>"; }
							if($cn == $guideBig['numTags']) { $guides_main .=  "</tr>"; }
						 } 
						$guides_main .= '</table>';
					 
				$guides_main .= '</div>
			</div>
		</td></tr></table>';

}	




$guides_main .= '<div id="options">';

/*
$guides_main .= '

<!-- HTML CODE -->
<div class="exemple3" data-average="6" data-id="'.$_REQUEST['postID'].'" style=" float:left;width:200; margin-top:0px; color:#ffffff;"></div>

<!-- JS to add -->
<script type="text/javascript">
  jQuery(document).ready(function(){
	jQuery(".exemple3").jRating({
	  step:true,
	  length : 6, // nb of stars
	  decimalLength:1 // number of decimal in the rate
	});
  });
</script>

';*/


		
$guides_main .= '
		<div style="float:right;margin-right:10px;">
			<div style="float:left; margin-right:2px;" >
				<iframe src="http://www.facebook.com/plugins/like.php?href=http://www.gozbite.com/разгледай-справочник-'.$guideBig['guideID'].','.myTruncateToCyrilic($guideBig['title'],200,'_','') .'.html&amp;layout=button_count&amp;show_faces=true&amp;width=50&amp;action=like&amp;font=trebuchet+ms&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:21px;" allowTransparency="true"></iframe>
				<span style="background:transparent; color:#FFFFFF; font-size:12px; font-weight:bold;">Сподели в: </span>
				<a href="http://www.facebook.com/sharer.php?u=http://www.gozbite.com/разгледай-справочник-'.$guideBig['guideID'].','.myTruncateToCyrilic($guideBig['title'],200,'_','') .'.html&amp;t='.$guideBig['title'].'" target="_blank"><img src="images/facebook.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;
				<a href="http://twitter.com/home?status='.myTruncateToCyrilic($guideBig['title'],200,'_','') .', http://www.gozbite.com/разгледай-справочник-'.$guideBig['guideID'].','.myTruncateToCyrilic($guideBig['title'],200,'_','') .'.html" target="_blank"><img src="images/twitter.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;<a href="http://www.google.com/buzz/post" data-locale="bg" target="_blank"><img src="i/ico/google.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>
			</div>';
			
						
			$guides_main .= '<div style="float:right; margin-right:2px;" >';
			$guides_main .= '<a href = "javascript://void(0);" onclick = \'window.open("includes/tools/sendStuffToFriend.php?guideID='.$guideBig['guideID'].'", "sndWin", "top=0, left=0, width=440px, height=500px, resizable=yes, toolbars=no, scrollbars=yes");\' class = "smallOrange"><img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a></div>';
			$guides_main .= '<div style="float:right; margin-right:2px;" >';
			$guides_main .= '<a href = "javascript://" onclick = "window.print();"  class = "smallOrange"><img style="margin-left:5px;" src="images/print.gif" alt="Разпечатай" width="14" height="14"></a></div>';
			//$guides_main .= '</div></div>';

	
$guides_main .= '</div>
		
	</div>


<br style="clear:both;"/>	';



	$guides_main .= '<div class="detailsDiv" style="float:left; width:375px; margin-bottom:20px; margin-right:5px; margin-left:5px;border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
  		<h4>Още снимки</h4>			
			<ul id="thumbs_posts">';
	  		   				
	if ($guideBig['has_pic']=='1')
	{  	  
		$i=0;
		foreach ($guideBig['resultPics']['url_thumb'] as $pics_thumb)
		{	
			if(is_file('pics/guides/'.$pics_thumb))
			{ 
				$guides_main .= '<li class="thumbDiv"><a href="pics/guides/'.$guideBig['resultPics']['url_big'][$i].'"';
				$guides_main .= ' class="lightview" rel="gallery[myset]"><img width="60" height="60" onclick = "$(\'big_pic\').src="pics/guides/'.$guideBig['resultPics']['url_big'][$i].';"" src="pics/guides/'.$pics_thumb.'" /></a></li>';               	
							
				$i++;
			}		 		  	         			
		}
	}

		 $guides_main .= '
		 </ul> 				
</div>';

		 
$guides_main .= '
<div class="detailsDiv" style="float:right; width:250px; margin-bottom:20px; margin-left:5px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">  		
 
 <h4>Представено от</h4>	
 <div class="detailsDiv" style="float:left; width:250px;margin-bottom:20px; border-top:3px solid #0099FF;  padding-top:0px; background-color:#FFF;">';
	if($guideBig['firm_id'] > 0) 
	{
		$guides_main .= '<div class="detailsDiv" style="float:left; width:240px;margin-bottom:5px; padding:5px; padding-top:0px; background-color:#39C6EE;">
		<div style=" float:left; color:#FFF;font-weight:bold;" >		
			<h4 style=" float:left; margin-left:0px; background-color:transparent; background-image:url(\'\');"><a style="color:#FFF;" href="разгледай-фирма-'.$guideBig['firm_id'].','.myTruncateToCyrilic($guideBig['Firm']['firm'],200,'_','') .'.html">'.$guideBig['Firm']['firm'].'</a></h4>		
		</div>
		<br style="clear:both;"/>	
		
			<table>';
   				
   				if($guideBig['Firm']['email'] != '') $guides_main .= "<tr><td style='color:#666666; font-weight:bold;'> &rarr;</td><td style='color:#FFFFFF; font-weight:bold;'> ".$guideBig['Firm']['email']."</td></tr>"; 
				if($guideBig['Firm']['phone'] != '') $guides_main .= "<tr><td style='color:#666666; font-weight:bold;'> &rarr;</td> <td style='color:#FFFFFF; font-weight:bold;'>".$guideBig['Firm']['phone']."</td></tr>"; 
			$guides_main .= '
			</table>	
			
			
	</div>
		<br style="clear:both;"/>	
	<table><tr>
	<td width="150"><a href="разгледай-фирма-'.$guideBig['firm_id'].','.myTruncateToCyrilic($guideBig['Firm']['firm'],200,'_','') .'.html"><img width="150"  src="'.(is_file("pics/firms/".$guideBig['firm_id']."_logo.jpg"))?"image.php?i=pics/firms/".$guideBig['firm_id']."_logo.jpg&fh=&fv=&ed=&gr=&rw=150&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5":"pics/firms/no_logo.png".'"/></a></td>
	<td valign="top"><a href="справочник-firmID='.$guideBig['firm_id'] .',храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">Още справочник от '.$guideBig['Firm']['firm'].'</a><br /><hr  style="margin:5px; border-bottom: 1px solod #FF6600;">
		<a href="рецепти-firmID='.$guideBig['firm_id'].','.str_replace(' ','_',$guideBig['Firm']['firm']).'_вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Още рецепти от '.$guideBig['Firm']['firm'].'</a><br /><hr style="margin:5px; border-bottom: 1px solod #FF6600;">
		<a href="напитки-firmID='.$guideBig['firm_id'].','.str_replace(' ','_',$guideBig['Firm']['firm']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">Още напитки от '.$guideBig['Firm']['firm'].'</a></td></tr></table>';
	}
	
	
	if($guideBig['user_id'] > 0) 
	{
	
		if(is_file("pics/users/".$guideBig['user_id']."_avatar.jpg")) $picFileUser= "pics/users/".$guideBig['user_id']."_avatar.jpg";
		else $picFileUser = 'pics/users/no_photo_thumb.png';
	
		list($widthUser, $heightUser, $typeUser, $attrUser) = getimagesize($picFileUser);
		$pic_width_or_heightUser = 100;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($heightUser) && ($widthUser))	
		{
			if($widthUser >= $heightUser)	{$newheightUser = ($heightUser/$widthUser)*$pic_width_or_heightUser; $newwidthUser	=	$pic_width_or_heightUser;	}
			else					{$newwidthUser = ($widthUser/$heightUser)*$pic_width_or_heightUser; $newheighUsert	=	$pic_width_or_heightUser;	}
	}	
	$guides_main .= '
			<div class="detailsDiv" style="float:left;width:240px;margin-bottom:5px; padding:5px; padding-top:0px; background-color:#39C6EE;">
				<div style=" float:left; color:#FFF;font-weight:bold;" >		
					<h4 style=" float:left; margin-left:0px; background-color:transparent; background-image:url(\'\');"><a style="color:#FFF;" href="разгледай-потребител-'.$guideBig['user_id'].','.str_replace(' ','_',$guideBig['user']).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">'.$guideBig['User']['user']  .'</a></h4>		
				</div>
						<br style="clear:both;"/>		
			</div>
		    	   	
		<br style="clear:both;"/>	
	
			<table><tr><td align="center" valign="top">
					<a href="разгледай-потребител-'.$guideBig['user_id'].','.str_replace(' ','_',$guideBig['User']['user']).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">
					<div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" ><img width="'.$newwidthUser.'" height="'.$newheightUser.'" src="'.$picFileUser.'" /></div></a>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						<a href="http://gozbite.com/разгледай-дестинация-'.$guideBig['User']['location_id'].','.myTruncateToCyrilic(locationTracker($guideBig['User']['location_id']),100,"_","").'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html">'.locationTracker($guideBig['User']['location_id']).'</a>
					</div>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						<a href="справочник-userID='.$guideBig['user_id'].','.str_replace(' ','_',$guideBig['User']['user']).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">Справочни описания: '.$guideBig['User']['cnt_guide'].'</a>
					</div>
				</td>
				<td valign="top"><a href="справочник-userID='.$guideBig['user_id'].','.str_replace(' ','_',$guideBig['User']['user']).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">Още справочни описания от '.$guideBig['User']['user'].'</a><br /><hr  style="margin:5px; border-bottom: 1px solod #FF6600;">
				<a href="рецепти-userID='.$guideBig['user_id'].','.str_replace(' ','_',$guideBig['User']['user']).'_вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Още рецепти от '.$guideBig['User']['user'].'</a><br /><hr style="margin:5px; border-bottom: 1px solod #FF6600;">
				<a href="напитки-userID='.$guideBig['user_id'].','.str_replace(' ','_',$guideBig['User']['user']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">Още напитки от '.$guideBig['User']['user'].'</a></td>
	
				</tr></table>';
				
	 }
	
$guides_main .= '	
</div>


	<br style="clear:both;"/>	
</div>';



	$video_name = $guideBig['guideID'];
	if(file_exists("videos/guides/".$video_name.".flv") OR !empty($guideBig['youtube_video']))
	{ 
$guides_main .= '
<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
	<h4>Видео Представяне</h4>';
	
		if(file_exists("videos/hotels/".$video_name.".flv"))
		{
	$guides_main .= '
			<div style = "float:left;margin: 10px 10px 10px 10px;width:500px;">
            <label><br /><br />.:: Видео Представяне ::.</label><br /><br />';
       
            	
					$video = "videos/guides/".$video_name.".flv";
					$guides_main .= '
					<br>
				
					<div id="videoDIV"  style="margin-left:0px;">
					<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
						<script language="javascript" type="text/javascript">
							var FO = {movie:"flash_flv_player/flvplayer.swf",width:"300",height:"170",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
							flashvars:"file=../videos/guides/'.$video_name.'.flv&image=../videos/guides/'.$video_name.'_thumb.jpg" };
							UFO.create(FO, "player1");
						</script>
					</div>
									
	   </div>';
	 } 
		elseif(!empty($guideBig['youtube_video'])) 
		{
		$guides_main .= '		  				
			<object type="application/x-shockwave-flash" style="width:450px; height:350px;" data="'.$guideBig['youtube_video'].'">
			<param name="movie" value="'.$guideBig['youtube_video'].'" />
			</object> ';
		
		
		}				
			
		
	$guides_main .= '   
</div>	';
 } 

$guides_main .= '
	
<div class="detailsDiv" style="float:left; width:650px; margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
			
			<a href="javascript://" onclick=" new Effect.toggle($(\'writeComments\'),\'Blind\'); "><h4>Коментирай</h4></a>
			
			 <div id="writeComments" style="width:100%;  ">
			 
			
    		 	 <table><tr><td align="left" valign="top">
	    		 	<fb:comments xid="gozbite_guide_'.$guideBig['guideID'].'" numposts="10" width="650" send_notification_uid="1544088151"></fb:comments>
				</td>
				<td width="20">&nbsp;</td>
				<td align="right" valign="top">';
	    			
//$guides_main .= require("includes/modules/googleAdsense_300x250px.php"); // Pokazva GoogleAdsense   
$guides_main .= '	    			
	    		</td></tr></table>
	
			</div>
			
		
		  		
			
		</div>				
</div>

<br style="clear:left;"/>';
		        
		        
	    
	return $guides_main;
	  
	?>