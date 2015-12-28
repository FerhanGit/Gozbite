<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$recipe_big = "";
   	
	$clauses = array();
   	$clauses['where_clause'] = " AND r.id = '".$_REQUEST['recipeID']."'";
	$clauses['order_clause'] = '';
	$clauses['limit_clause'] = ' LIMIT 1';
	$recipe_big_info = $this->getItemsList($clauses);

	if(!$recipe_big_info)
	{
		return false;
	}
	$recipeBig = $recipe_big_info[$_REQUEST['recipeID']];	
		
	$recipe_big .=  '<script type="text/javascript">
						makeViewLog(\'recipe\',\''.$recipeBig['recipeID'].'\');
					</script>';
	
//$recipe_big .=print_r($recipeBig,1);
		
$recipe_big .= '
<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">

<div style="float:left; margin-bottom:20px;" id="next_previousDIV"></div>
<br style="clear:both;"/>

<h4 style="color:#FF8400;">
	<div style=" float:left; margin-left:0px; width:550px; color:#0099FF; font-weight:bold;" >';
	 if($recipeBig['active'] != '1') 
	 { 
	 	$recipe_big .= '<span style="color:#FF0000;"> Неактивна! </span>';
	 } 
 $recipe_big .= $recipeBig['title'].'</div>';
 
		if(($recipeBig['firm_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'firm') OR ($recipeBig['user_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'user') or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1) 
		{	
			$recipe_big .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-рецепта-'.$recipeBig['recipeID'].','.myTruncateToCyrilic($recipeBig['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a>';
			if($recipeBig['gold'] == '1')
			{
				$recipe_big .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
			} 
			elseif($recipeBig['silver'] == '1') 
			{ 
				$recipe_big .= '<img style="margin-left:5px;" src="images/star_grey.gif">';
			} 
			if($recipeBig['is_Featured'] == '1' && strtotime($recipeBig['is_Featured_end']) > time()) 
			{ 
				$recipe_big .= '<img style="margin-left:5px;"  height="20" src="images/specialitet.png" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Специалитет!] body=[&rarr; Тази рецепта е със статут на <span style="color:#FF6600;font-weight:bold;">специалитет</span>. Ако желаете и Вашата готварска рецепта или напита да бъде <span style="color:#FF6600;font-weight:bold;">специалитет на сайта</span> вижте поясненията при редактиране на описанието и.] \'>';
			} 
		    $recipe_big .= '</div>';
	 	} 
	 	else 
	 	{	
			$recipe_big .= '<div style="float:right; margin-right:5px;" >';
			if($recipeBig['gold'] == '1') 
			{ 
				$recipe_big .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
			} 
			elseif($recipeBig['silver'] == '1') 
			{ 
			  	$recipe_big .= '<img style="margin-left:5px;" src="images/star_grey.gif">'; 
			} 
			if($recipeBig['is_Featured'] == '1' && strtotime($recipeBig['is_Featured_end']) > time()) 
			{ 
				$recipe_big .= '<img style="margin-left:5px;"  height="20" src="images/specialitet.png" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Специалитет!] body=[&rarr; Тази рецепта е със статут на <span style="color:#FF6600;font-weight:bold;">специалитет</span>. Ако желаете и Вашата готварска рецепта или напита да бъде <span style="color:#FF6600;font-weight:bold;">специалитет на сайта</span> вижте поясненията при редактиране на описанието и.] \'>';
			} 
			  $recipe_big .= '</div>';
	 } 
	if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) 
	{	
		$recipe_big .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-рецепта-'.$recipeBig['recipeID'].','.myTruncateToCyrilic($recipeBig['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
	}	
	$recipe_big .= '
	<br style="clear:both;"/>	
</h4>

<div class="detailsDiv" style="float:left; width:650px;margin-bottom:5px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
	<div style=" float:left; margin-left:5px; font-weight:bold; color:#FFF;" ><h3 align="left"><a style="font-size:14px; font-weight:bold; color:#FFF;" href="рецепти-категория-'.$recipeBig['Cats'][0]['recipe_category_id'] .','.myTruncateToCyrilic($recipeBig['Cats'][0]['recipe_category_name'],200,'_','') .'.html">'.$recipeBig['Cats'][0]['recipe_category_name'] .'</a></h3></div>	
	<div style=" float:right; margin-right:5px; font-weight:bold; color:#FFF;" ><h3 align="left"><a style="font-size:14px; font-weight:bold; color:#FFF;" href="разгледай-кухня-'.$recipeBig['Kuhnq']['kuhnq_id'] .','.myTruncateToCyrilic($recipeBig['Kuhnq']['kuhnq'],100,'_','') .'.html" >'.$recipeBig['Kuhnq']['kuhnq'] .' кухня</a></h3></div>								
	<br style="clear:both;"/>	
</div>';



$recipe_big .= '<div id="options">';


/*
$recipe_big .= '

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
	
$recipe_big .= '
		<div style="float:right;margin-right:10px;">
			<div style="float:left; margin-right:2px;" >
				<iframe src="http://www.facebook.com/plugins/like.php?href=http://www.gozbite.com/разгледай-рецепта-'.$recipeBig['recipeID'].','.myTruncateToCyrilic($recipeBig['title'],200,'_','') .'.html&amp;layout=button_count&amp;show_faces=true&amp;width=50&amp;action=like&amp;font=trebuchet+ms&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:21px;" allowTransparency="true"></iframe>
				<span style="background:transparent; color:#FFFFFF; font-size:12px; font-weight:bold;">Сподели в: </span>
				<a href="http://www.facebook.com/sharer.php?u=http://www.gozbite.com/разгледай-рецепта-'.$recipeBig['recipeID'].','.myTruncateToCyrilic($recipeBig['title'],200,'_','') .'.html&amp;t='.$recipeBig['title'].'" target="_blank"><img src="images/facebook.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;
				<a href="http://twitter.com/home?status='.myTruncateToCyrilic($recipeBig['title'],200,'_','') .', http://www.gozbite.com/разгледай-рецепта-'.$recipeBig['recipeID'].','.myTruncateToCyrilic($recipeBig['title'],200,'_','') .'.html" target="_blank"><img src="images/twitter.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;<a href="http://www.google.com/buzz/post" data-locale="bg" target="_blank"><img src="i/ico/google.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>
			</div>';
			
						
			$recipe_big .= '<div style="float:right; margin-right:2px;" >';
			$recipe_big .= '<a href = "javascript://void(0);" onclick = \'window.open("includes/tools/sendStuffToFriend.php?recipeID='.$recipeBig['recipeID'].'", "sndWin", "top=0, left=0, width=440px, height=500px, resizable=yes, toolbars=no, scrollbars=yes");\' class = "smallOrange"><img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a></div>';
			$recipe_big .= '<div style="float:right; margin-right:2px;" >';
			$recipe_big .= '<a href = "javascript://" onclick = "window.print();"  class = "smallOrange"><img style="margin-left:5px;" src="images/print.gif" alt="Разпечатай" width="14" height="14"></a></div>';
			//$recipe_big .= '</div></div>';

	
$recipe_big .= '</div>
		
	</div>';

$recipe_big .= '
<br style="clear:both;"/>	

<div class="detailsDiv" style="float:left; width:250px; margin-bottom:20px; margin-right:5px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';

	if(is_file("pics/recipes/".$recipeBig['resultPics']['url_big'][0])) $picFile= "pics/recipes/".$recipeBig['resultPics']['url_big'][0];
	else $picFile = 'pics/recipes/no_photo_big.png';
		
	list($width, $height, $type, $attr) = getimagesize($picFile);
	$pic_width_or_height = 230;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
	if (($height) && ($width))	
	{
		if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
		else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
	
	}
			
		

$recipe_big .= '
<a href="'.$picFile.'" class=\'lightview\' rel=\'gallery\' ><div  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="float:left; margin:5px;  border:1px solid #CCCCCC; width:240px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:230).'"  src="'.$picFile.'" /></div></a>
		<br style="clear:both;"/>	
<h4>Още снимки</h4>			
<ul id="thumbs">';


  
	   				
if ($recipeBig['has_pic']=='1')
{  	  
	$i=0;
	foreach ($recipeBig['resultPics']['url_thumb'] as $pics_thumb)
	{	
		if(is_file('pics/recipes/'.$pics_thumb))
		{ 
			$recipe_big .= '<li class="thumbDiv"><a href="pics/recipes/'.$recipeBig['resultPics']['url_big'][$i].'"';
			$recipe_big .= ' class="lightview" rel="gallery[myset]"><img width="60" height="60" onclick = "$(\'big_pic\').src="pics/recipes/'.$recipeBig['resultPics']['url_big'][$i].';"" src="pics/recipes/'.$pics_thumb.'" /></a></li>';               	
						
			$i++;
		}		 		  	         			
	}
}
	
$recipe_big .= '   
 </ul>
  
 <h4>Представено от</h4>	
 <div class="detailsDiv" style="float:left; width:250px;margin-bottom:20px; border-top:3px solid #0099FF;  padding-top:0px; background-color:#FFF;">';
	
 if($recipeBig['firm_id'] > 0) 
 {
	$recipe_big .= '<div class="detailsDiv" style="float:left; width:240px;margin-bottom:5px; padding:5px; padding-top:0px; background-color:#39C6EE;">
		<div style=" float:left; color:#FFF;font-weight:bold;" >		
			<h4 style=" float:left; margin-left:0px; background-color:transparent; background-image:url(\'\');"><a style="color:#FFF;" href="разгледай-фирма-'.$recipeBig['firm_id'].','.myTruncateToCyrilic($recipeBig['Firm']['firm'],200,'_','') .'.html">'.$recipeBig['Firm']['firm'].'</a></h4>		
		</div>
		<br style="clear:both;"/>	
		
			<table>';
   			
   				if($recipeBig['Firm']['email'] != '') $recipe_big .= "<tr><td style='color:#666666; font-weight:bold;'> &rarr;</td><td style='color:#FFFFFF; font-weight:bold;'> ".$recipeBig['Firm']['email']."</td></tr>"; 
				if($recipeBig['Firm']['phone'] != '') $recipe_big .= "<tr><td style='color:#666666; font-weight:bold;'> &rarr;</td> <td style='color:#FFFFFF; font-weight:bold;'>".$recipeBig['Firm']['phone']."</td></tr>"; 
	$recipe_big .= '
			</table>	
			
			
	</div>
		<br style="clear:both;"/>	
	<table><tr>
	<td width="150"><a href="разгледай-фирма-'.$recipeBig['firm_id'].','.myTruncateToCyrilic($recipeBig['Firm']['firm'],200,'_','') .'.html"><img width="150"  src="'.(is_file("pics/firms/".$recipeBig['firm_id']."_logo.jpg"))?"image.php?i=pics/firms/".$recipeBig['firm_id']."_logo.jpg&fh=&fv=&ed=&gr=&rw=150&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5":"pics/firms/no_logo.png".'"/></a></td>
	<td valign="top"><a href="напитки-firmID='.$recipeBig['firm_id'].','.str_replace(' ','_',$recipeBig['Firm']['firm']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">Още напитки от '.$recipeBig['Firm']['firm'].'</a><br /><hr  style="margin:5px; border-bottom: 1px solod #FF6600;">
	<a href="рецепти-firmID='.$recipeBig['firm_id'].','.str_replace(' ','_',$recipeBig['Firm']['firm']).'_вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Още рецепти от '.$recipeBig['Firm']['firm'].'</a><br /><hr style="margin:5px; border-bottom: 1px solod #FF6600;">
	<a href="справочник-firmID='.$recipeBig['firm_id'].','.str_replace(' ','_',$recipeBig['Firm']['firm']).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">Още справочни описания от '.$recipeBig['Firm']['firm'].'</a></td>
	</tr></table>';
	
}
	
	
	if($recipeBig['user_id'] > 0) 
	{
	
		if(is_file("pics/users/".$recipeBig['user_id']."_avatar.jpg")) $picFileUser= "pics/users/".$recipeBig['user_id']."_avatar.jpg";
		else $picFileUser = 'pics/users/no_photo_thumb.png';
	
		list($widthUser, $heightUser, $typeUser, $attrUser) = getimagesize($picFileUser);
		$pic_width_or_heightUser = 100;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($heightUser) && ($widthUser))	
		{
			if($widthUser >= $heightUser)	{$newheightUser = ($heightUser/$widthUser)*$pic_width_or_heightUser; $newwidthUser	=	$pic_width_or_heightUser;	}
			else					{$newwidthUser = ($widthUser/$heightUser)*$pic_width_or_heightUser; $newheighUsert	=	$pic_width_or_heightUser;	}
		}	
	$recipe_big .= '	<div class="detailsDiv" style="float:left;width:240px;margin-bottom:5px; padding:5px; padding-top:0px; background-color:#39C6EE;">
				<div style=" float:left; color:#FFF;font-weight:bold;" >		
					<h4 style=" float:left; margin-left:0px; background-color:transparent; background-image:url(\'\');"><a style="color:#FFF;" href="разгледай-потребител-'.$recipeBig['user_id'].','.str_replace(' ','_',$recipeBig['User']['user']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.$recipeBig['User']['user']  .'</a></h4>		
				</div>
						<br style="clear:both;"/>		
			</div>
		    	   	
		<br style="clear:both;"/>	
	
			<table><tr><td align="center" valign="top">
					<a href="разгледай-потребител-'.$recipeBig['user_id'].','.str_replace(' ','_',$recipeBig['User']['user']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">
					<div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" ><img width="'.$newwidthUser.'" height="'.$newheightUser.'" src="'.$picFileUser.'" /></div></a>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						<a href="http://gozbite.com/разгледай-дестинация-'.$recipeBig['User']['location_id'].','.myTruncateToCyrilic(locationTracker($recipeBig['User']['location_id']),100,"_","").'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html">'.locationTracker($recipeBig['User']['location_id']).'</a>
					</div>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						<a href="рецепти-userID='.$recipeBig['user_id'].','.str_replace(' ','_',$recipeBig['User']['user']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">Рецепти: '.$recipeBig['User']['cnt_recipe'].'</a>
					</div>
				</td>
				<td valign="top"><a href="напитки-userID='.$recipeBig['user_id'].','.str_replace(' ','_',$recipeBig['User']['user']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">Още напитки от '.$recipeBig['User']['user'].'</a><br /><hr  style="margin:5px; border-bottom: 1px solod #FF6600;">
				<a href="рецепти-userID='.$recipeBig['user_id'].','.str_replace(' ','_',$recipeBig['User']['user']).'_вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Още рецепти от '.$recipeBig['User']['user'].'</a><br /><hr style="margin:5px; border-bottom: 1px solod #FF6600;">
				<a href="справочник-userID='.$recipeBig['user_id'].','.str_replace(' ','_',$recipeBig['User']['user']).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">Още справочни описания от '.$recipeBig['User']['user'].'</a></td>
					
				</tr></table>';
				
	} 
	
$recipe_big .= '	
</div>


	<br style="clear:both;"/>	
</div>


<div class="detailsDiv" style="float:left; width:370px; margin-bottom:20px; margin-left:15px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		
<h4>Продукти</h4>	

	<table>';
	
	  	if (count($recipeBig['Products']) > 0) 
		{
			foreach ($recipeBig['Products'] as $resultRecipeProducts)
			{			 		
				$recipe_big .=  "<tr><td style='color:#666666; font-weight:bold;'> &rarr;</td> <td>  <font style='color:#FF6600;'>".$resultRecipeProducts['recipe_product_name']."</font> </td></tr>"; 
		 
	    	}
		}	
			
$recipe_big .= '
	</table>		
						
	
	<div id="track1" class="track" style="margin-right:5px; width: 130px; margin-bottom:3px;" >
	   <div id="handle1" class="handle" style="width: 30px;" ><p id="changed" style="color:#FFFFFF; text-align:center;  font-size:10px; font-weight:bold; line-height:1.2;">12px</p></div>
	</div>';
	
/*	
$recipe_big .= '
	
	<script type="text/javascript">
		new Control.Slider(\'handle1\' , \'track1\',
		{
			range: $R(10,28),
			values: [10,12,14,18,24,28],
			sliderValue: 12,
			onChange: function(v){
				var objTextBody = document.getElementById("recipeBodyDiv");		
			   	objTextBody.style.fontSize = v+"px";
			   	 $(\'changed\').innerHTML = v+\'px\';
			   	
			},
			onSlide: function(v) {
			  	var objTextBody = document.getElementById("recipeBodyDiv");
			  	objTextBody.style.fontSize = v+"px";
			  	 $(\'changed\').innerHTML = v+\'px\';
			}
		} );
	</script>';
*/

$recipe_big .= '
	<h4>Начин на Приготвяне</h4>
	
	<br style="clear:both;"/>	

	<p id="recipeBodyDiv">
		'.insertADV($recipeBig['info']).'	
	</p>			
</div>	
<br style="clear:both;"/>';

	
	
 

	if($recipeBig['has_video'] == '1' OR !empty($recipeBig['youtube_video']))
	{ 
$recipe_big .= '
	<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		<h4>Видео Представяне</h4>
		
		<br style="clear:both;"/>	';
	
	
            $video_name = $recipeID;
            	
			if(file_exists("videos/recipes/".$video_name.".flv"))
			{
				$video = "videos/recipes/".$video_name.".flv";
				
				$recipe_big .= '
				<br>
				
				<div id="videoDIV"  style="margin-left:0px;">
				<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
					<script language="javascript" type="text/javascript">
						var FO = {movie:"flash_flv_player/flvplayer.swf",width:"300",height:"170",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
						flashvars:"file=../videos/recipes/'.$video_name.'.flv&image=../videos/recipes/'.$video_name.'_thumb.jpg" };
						UFO.create(FO, "player1");
					</script>
				</div>';
									
		     
			}
			elseif(!empty($recipeBig['youtube_video'])) 
			{
				$recipe_big .= '	  				
				<object type="application/x-shockwave-flash" style="width:450px; height:350px;" data="'.$recipeBig['youtube_video'].'">
				<param name="movie" value="'.$recipeBig['youtube_video'].'" />
				</object> ';
			
		
			}				
						
$recipe_big .= '	</div>	';

 } 




if($recipeBig['numTags'] > 0) 
 {
 	$recipe_big .= '<table><tr><td> 
		     <div class="postBig">
				<div class="detailsDiv" style="float:left; width:640px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<h4 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;">
						<div style="margin-left:6px; height:22px; width:450px;color:#0099FF;font-weight:bold;" >Други рецепти съдържащи:</div>		
					</h4>';
					 
						$recipe_big .= '	<table cellpadding="2"><tr>';
						 for($i=0, $cn=1; $i<$recipeBig['numTags']; $i++, $cn++) 
						 {						
							$recipe_big .= '<td width="125"><h4 style="font-size:12px; padding-left:5px; margin-top:2px;"><a  style="font-size:12px;" href="рецепти-етикет-'.$recipeBig['Tags'][$i].',още_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.$recipeBig['Tags'][$i].'</a></h4></td>';
							if($cn % 5 == 0) { $recipe_big .=  "</tr><tr>"; }
							if($cn == $recipeBig['numTags']) { $recipe_big .=  "</tr>"; }
						 } 
						$recipe_big .= '</table>';
					 
				$recipe_big .= '</div>
			</div>
		</td></tr></table>';

}	


	
$recipe_big .= '	
<div class="detailsDiv" style="float:left; width:650px; margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
			
			<a href="javascript://" onclick=" new Effect.toggle($(\'writeComments\'),\'Blind\'); "><h4>Коментирай</h4></a>
			
			 <div id="writeComments" style="width:100%;  ">
			 <!--
				 <table><tr><td align="left">
				 	 <table><tr><td colspan="2">
    				 		<input type="hidden" name="recipeID" value="'.$_REQUEST['recipeID'].'"/>
    				  		Името Ви:<br /> <input type="text" name="sender_name" id="sender_name" maxlength="30" style="width:300px;"/>
    				 </td></tr>
					
    				 <tr><td colspan="2">	    				  				
    				 		Текст:<br /> 
    				 		<textarea rows = "4" cols = "40"  name="comment_body" id="comment_body" style="width:300px;"></textarea>
    				</td>
    				</tr>
					<tr><td style="width:200px;">					
				 		<br />
				 		<fieldset style="width:110px;" ><img src="verificationimage/picture.php" /></fieldset>
			      		<br />
			      		<input style="width:110px;" type="text" name="verificationcode" value="" />
				 		<br />
						Въведете кода от картинката.						
					</td>
					<td style="width:100px;">
    					<input type="hidden" name="insert_comment_btn" value="" />					
						<input type="image" value="Добави" src="images/btn_gren_insert.png" onclick="if('.($_SESSION['userID']?'true':'false').' {$(\'insert_comment_btn\').setValue(\'Добави\'); return checkForCorrectComment();} else{alert(\'Необходимо е да влезете в системата за да направите своя коментар.\');return false;} " id="insert_comment_btn" title="Добави Коментар" name="insert_comment_btn" style="border: 0pt none ; display: inline;" height="20"  width="96">
					</td></tr>
    				</table>
    			</td><td width="20">&nbsp;</td><td align="right">
    				<?php // require_once("inc/googleAdsense_300x250px.inc.php"); // Pokazva GoogleAdsense   ?>
    		 	</td></tr></table>
    		 	   --> 		 	    		 	
    		 		
    		 	<table><tr><td align="left" valign="top">
	    		 	<fb:comments xid="gozbite_recipe_'.$recipeBig['recipeID'].'" numposts="10" width="650" send_notification_uid="1544088151"></fb:comments>
				</td>
				<td width="20">&nbsp;</td>
				<td align="right" valign="top">';
	    		//$recipe_big .= require("includes/modules/googleAdsense_300x250px.php"); // Pokazva GoogleAdsense 
	    		$recipe_big .= '</td></tr></table>
	    		
			</div>
						
			
	<!--		
			<h4 style="cursor:pointer; font-size:12px;" onclick=" new Effect.toggle($(\'readComments\'),\'Blind\'); if ($(\'readComments\').visible()) {$(\'search_div_link\').update(\'Покажи Коментарите ('.($numRecipeComment?$numRecipeComment:0).')\');} else {$(\'search_div_link\').update(\'Скрий Коментарите ('.($numRecipeComment?$numRecipeComment:0).')\');}"><div id="search_div_link" class="detailsDiv">Скрий Коментарите ('.($numRecipeComment?$numRecipeComment:0).')</div></h4>

			<div id="readcomments" style="width:100%;  overflow: scroll; ">';
				if($numRecipeComment>0)
		    	{
		    	    for($i=0;$i<$numRecipeComment;$i++)
		    	    {
		    	

			    	    //************ Автора за всяка тема ****************
					$sql="SELECT ".(($resultRecipeComment[$i]['autor_type']=='user')?" CONCAT(first_name, ' ', last_name)":'name')." as 'autor_name', username as 'autor_username' FROM ".(($resultRecipeComment[$i]['autor_type']=='user')?'users':'firms')." WHERE ".(($resultRecipeComment[$i]['autor_type']=='user')?'userID':'id')." = '".$resultRecipeComment[$i]['autor']."' LIMIT 1";
					$conn->setsql($sql);
					$conn->getTableRow();
					$resultMneniqAvtor = $conn->result['autor_name'];
					$resultMneniqAvtorUsername = $conn->result['autor_username'];
					
					if($resultRecipeComment[$i]['autor'] == 1 && $resultRecipeComment[$i]['autor_type'] == 'user')
					{
						$resultMneniqAvtor = 'Админ';
					}
					
	    	    	if($resultRecipeComment[$i]['sender_name'] != '')
					{
						$resultMneniqAvtor = $resultRecipeComment[$i]['sender_name'];
					}
		
					if($resultRecipeComment[$i]['autor_type']=='user')
					{
						if(is_file("pics/users/".$resultRecipeComment[$i]['autor']."_avatar.jpg")) $picFile= "pics/users/".$resultRecipeComment[$i]['autor']."_avatar.jpg";
					   	else $picFile = 'pics/users/no_photo_thumb.png';
					}
					elseif($resultRecipeComment[$i]['autor_type']=='firm')
					{
						if(is_file("pics/firms/".$resultRecipeComment[$i]['autor']."_logo.jpg")) $picFile= "pics/firms/".$resultRecipeComment[$i]['autor']."_logo.jpg";
					   	else $picFile = 'pics/firms/no_logo.png';
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
						
			    	$sql="SELECT cnt_comment FROM ".(($resultRecipeComment[$i]['autor_type']=='user')?'users':'firms')." WHERE ".(($resultRecipeComment[$i]['autor_type']=='user')?'userID':'id')." = '".$resultRecipeComment[$i]['autor']."' LIMIT 1";
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
				
$recipe_big .= '	
			 
				 	
			<div class="detailsDiv" style="float:left; width:620px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFF;">
				<table><tr><td valign="top">
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						'.(($resultRecipeComment[$i]['autor_type'] == 'user') ? '<a href="разгледай-потребител-'.$resultRecipeComment[$i]['autor'].',вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.$resultMneniqAvtor : '<a href="разгледай-фирма-'.$resultRecipeComment[$i]['autor'].',вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.$resultMneniqAvtor )  .'
					</div>
					<div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" ><img width="'.$newwidth.'" height="'.$newheight.'" src="'.$picFile.'" /></div></a>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						Мнения:<?=$resultCntMneniqForAutor?>
					</div>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						'.(($resultAutorOnLine == 1)?'<font color="green">Он-лайн</font>':'<font color="red">Оф-лайн</font>').'
					</div>					
				</td>
				<td style="border-right:1px dotted #CCCCCC; padding:2px; width:10px;"></td>
				<td valign="top">
					<h4 style="color:#FF8400">'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($resultRecipeComment[$i]['created_on']))).'</h4>
				
					<div class="detailsDiv" style="float:left; width:460px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE; color:#FFFFFF;">
						'.stripslashes($resultRecipeComment[$i]['comment_body']).'						
			        </div>
				</td></tr></table>
				
				<hr style="float:left;margin-top:20px;color: #eee;background-color: #eee; height:1px; border:0; width:600px;" />  
				
				<br style="clear:both;" />
			</div>';
		    	   		    	    
	               
		    	 
	                } 
		    	}    	   	
		    	
	    	$recipe_big .= '	
			</div>
				
			-->
	    					
</div>

</div>
<br style="clear:left;"/>';
		
		
 if(empty($_REQUEST['recipe_category'])) $_REQUEST['recipe_category'] = get_recipe_categoryByrecipeID($_GET['recipeID']);
			
    if (($_REQUEST['recipe_category']!="") or ($_REQUEST['category']!="")) 
	{
		$sql="SELECT name FROM recipe_category WHERE id='".($_REQUEST['category']?$_REQUEST['category']:$_REQUEST['recipe_category'])."'";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCatName = $conn->result['name'];
		
		$recipe_big .= require_once("moreRecipes.php");              
     }
     
$recipe_big .= '</div>';


return $recipe_big;

?>