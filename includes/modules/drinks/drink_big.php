<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$drink_big = "";
   	
	$clauses = array();
   	$clauses['where_clause'] = " AND d.id = '".$_REQUEST['drinkID']."'";
	$clauses['order_clause'] = '';
	$clauses['limit_clause'] = ' LIMIT 1';
	$drink_big_info = $this->getItemsList($clauses);

	if(!$drink_big_info)
	{
		return false;
	}
	$drinkBig = $drink_big_info[$_REQUEST['drinkID']];	
		
	$drink_big .=  '<script type="text/javascript">
						makeViewLog(\'drink\',\''.$drinkBig['drinkID'].'\');
					</script>';
	
//$drink_big .=print_r($drinkBig,1);
		
$drink_big .= '
<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">

<div style="float:left; margin-bottom:20px;" id="next_previousDIV"></div>
<br style="clear:both;"/>

<h4 style="color:#FF8400;">
	<div style=" float:left; margin-left:0px; width:550px; color:#0099FF; font-weight:bold;" >';
	if($drinkBig['active'] != 1) 
	{ 
		$drink_big .= '<span style="color:#FF0000;" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Неактивна Напитка!] body=[&rarr; Напитката е деактивирана от страна на нейния автор или от администратора на портала.]\'> | Неактивно! </span>';
	}
							
					
 $drink_big .= $drinkBig['title'].'</div>';
 
		if(($drinkBig['firm_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'firm') OR ($drinkBig['user_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'user') or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1) 
		{	
			$drink_big .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-напитка-'.$drinkBig['drinkID'].','.myTruncateToCyrilic($drinkBig['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a>';
			if($drinkBig['gold'] == '1')
			{
				$drink_big .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
			} 
			elseif($drinkBig['silver'] == '1') 
			{ 
				$drink_big .= '<img style="margin-left:5px;" src="images/star_grey.gif">';
			} 
			if($drinkBig['is_Featured'] == '1' && strtotime($drinkBig['is_Featured_end']) > time()) 
			{ 
				$drink_big .= '<img style="margin-left:5px;"  height="20" src="images/specialitet.png" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Специалитет!] body=[&rarr; Тази напитка е със статут на <span style="color:#FF6600;font-weight:bold;">специалитет</span>. Ако желаете и Вашата готварска рецепта или напита да бъде <span style="color:#FF6600;font-weight:bold;">специалитет на сайта</span> вижте поясненията при редактиране на описанието и.] \'>';
			} 
		    $drink_big .= '</div>';
	 	} 
	 	else 
	 	{	
			$drink_big .= '<div style="float:right; margin-right:5px;" >';
			if($drinkBig['gold'] == '1') 
			{ 
				$drink_big .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
			} 
			elseif($drinkBig['silver'] == '1') 
			{ 
			  	$drink_big .= '<img style="margin-left:5px;" src="images/star_grey.gif">'; 
			} 
			if($drinkBig['is_Featured'] == '1' && strtotime($drinkBig['is_Featured_end']) > time()) 
			{ 
				$drink_big .= '<img style="margin-left:5px;"  height="20" src="images/specialitet.png" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Специалитет!] body=[&rarr; Тази напитка е със статут на <span style="color:#FF6600;font-weight:bold;">специалитет</span>. Ако желаете и Вашата готварска рецепта или напита да бъде <span style="color:#FF6600;font-weight:bold;">специалитет на сайта</span> вижте поясненията при редактиране на описанието и.] \'>';
			} 
			  $drink_big .= '</div>';
	 } 
	if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) 
	{	
		$drink_big .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-напитка-'.$drinkBig['drinkID'].','.myTruncateToCyrilic($drinkBig['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
	}	
	$drink_big .= '
	<br style="clear:both;"/>	
</h4>

<div class="detailsDiv" style="float:left; width:650px;margin-bottom:5px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
	<div style=" float:left; margin-left:5px; font-weight:bold; color:#FFF;" ><h3 align="left"><a style="font-size:14px; font-weight:bold; color:#FFF;" href="напитки-категория-'.$drinkBig['Cats'][0]['drink_category_id'] .','.myTruncateToCyrilic($drinkBig['Cats'][0]['drink_category_name'],200,'_','') .'.html">'.$drinkBig['Cats'][0]['drink_category_name'] .'</a></h3></div>								
	<br style="clear:both;"/>	
</div>';
	
					 
$drink_big .= '<div id="options">';

/*
$drink_big .= '

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
    

$drink_big .= '
		<div style="float:right;margin-right:10px;">
			<div style="float:left; margin-right:2px;" >
				<iframe src="http://www.facebook.com/plugins/like.php?href=http://www.gozbite.com/разгледай-напитка-'.$drinkBig['drinkID'].','.myTruncateToCyrilic($drinkBig['title'],200,'_','') .'.html&amp;layout=button_count&amp;show_faces=true&amp;width=50&amp;action=like&amp;font=trebuchet+ms&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:21px;" allowTransparency="true"></iframe>
				<span style="background:transparent; color:#FFFFFF; font-size:12px; font-weight:bold;">Сподели в: </span>
				<a href="http://www.facebook.com/sharer.php?u=http://www.gozbite.com/разгледай-напитка-'.$drinkBig['drinkID'].','.myTruncateToCyrilic($drinkBig['title'],200,'_','') .'.html&amp;t='.$drinkBig['title'].'" target="_blank"><img src="images/facebook.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;
				<a href="http://twitter.com/home?status='.myTruncateToCyrilic($drinkBig['title'],200,'_','') .', http://www.gozbite.com/разгледай-напитка-'.$drinkBig['drinkID'].','.myTruncateToCyrilic($drinkBig['title'],200,'_','') .'.html" target="_blank"><img src="images/twitter.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;<a href="http://www.google.com/buzz/post" data-locale="bg" target="_blank"><img src="i/ico/google.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>
			</div>';
			
						
			$drink_big .= '<div style="float:right; margin-right:2px;" >';
			$drink_big .= '<a href = "javascript://void(0);" onclick = \'window.open("includes/tools/sendStuffToFriend.php?drinkID='.$drinkBig['drinkID'].'", "sndWin", "top=0, left=0, width=440px, height=500px, resizable=yes, toolbars=no, scrollbars=yes");\' class = "smallOrange"><img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a></div>';
			$drink_big .= '<div style="float:right; margin-right:2px;" >';
			$drink_big .= '<a href = "javascript://" onclick = "window.print();"  class = "smallOrange"><img style="margin-left:5px;" src="images/print.gif" alt="Разпечатай" width="14" height="14"></a></div>';
			//$drink_big .= '</div></div>';

	
$drink_big .= '</div>
		
	</div>';

$drink_big .= '
<br style="clear:both;"/>	

<div class="detailsDiv" style="float:left; width:250px; margin-bottom:20px; margin-right:5px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';

	if(is_file("pics/drinks/".$drinkBig['resultPics']['url_big'][0])) $picFile= "pics/drinks/".$drinkBig['resultPics']['url_big'][0];
	else $picFile = 'pics/drinks/no_photo_big.png';
		
	list($width, $height, $type, $attr) = getimagesize($picFile);
	$pic_width_or_height = 230;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
	if (($height) && ($width))	
	{
		if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
		else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
	
	}
			
		

$drink_big .= '
<a href="'.$picFile.'" class=\'lightview\' rel=\'gallery\' ><div  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="float:left; margin:5px;  border:1px solid #CCCCCC; width:240px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:230).'"  src="'.$picFile.'" /></div></a>
		<br style="clear:both;"/>	
<h4>Още снимки</h4>			
<ul id="thumbs">';


  
	   				
if ($drinkBig['has_pic']=='1')
{  	  
	$i=0;
	foreach ($drinkBig['resultPics']['url_thumb'] as $pics_thumb)
	{	
		if(is_file('pics/drinks/'.$pics_thumb))
		{ 
			$drink_big .= '<li class="thumbDiv"><a href="pics/drinks/'.$drinkBig['resultPics']['url_big'][$i].'"';
			$drink_big .= ' class="lightview" rel="gallery[myset]"><img width="60" height="60" onclick = "$(\'big_pic\').src="pics/drinks/'.$drinkBig['resultPics']['url_big'][$i].';"" src="pics/drinks/'.$pics_thumb.'" /></a></li>';               	
						
			$i++;
		}		 		  	         			
	}
}
	
$drink_big .= '   
 </ul>
  
 <h4>Представено от</h4>	
 <div class="detailsDiv" style="float:left; width:250px;margin-bottom:20px; border-top:3px solid #0099FF;  padding-top:0px; background-color:#FFF;">';
	
 if($drinkBig['firm_id'] > 0) 
 {
	$drink_big .= '<div class="detailsDiv" style="float:left; width:240px;margin-bottom:5px; padding:5px; padding-top:0px; background-color:#39C6EE;">
		<div style=" float:left; color:#FFF;font-weight:bold;" >		
			<h4 style=" float:left; margin-left:0px; background-color:transparent; background-image:url(\'\');"><a style="color:#FFF;" href="разгледай-фирма-'.$drinkBig['firm_id'].','.myTruncateToCyrilic($drinkBig['Firm']['firm'],200,'_','') .'.html">'.$drinkBig['Firm']['firm'].'</a></h4>		
		</div>
		<br style="clear:both;"/>	
		
			<table>';
   			
   				if($drinkBig['Firm']['email'] != '') $drink_big .= "<tr><td style='color:#666666; font-weight:bold;'> &rarr;</td><td style='color:#FFFFFF; font-weight:bold;'> ".$drinkBig['Firm']['email']."</td></tr>"; 
				if($drinkBig['Firm']['phone'] != '') $drink_big .= "<tr><td style='color:#666666; font-weight:bold;'> &rarr;</td> <td style='color:#FFFFFF; font-weight:bold;'>".$drinkBig['Firm']['phone']."</td></tr>"; 
	$drink_big .= '
			</table>	
			
			
	</div>
		<br style="clear:both;"/>	
	<table><tr>
	<td width="150"><a href="разгледай-фирма-'.$drinkBig['firm_id'].','.myTruncateToCyrilic($drinkBig['Firm']['firm'],200,'_','') .'.html"><img width="150"  src="'.(is_file("pics/firms/".$drinkBig['firm_id']."_logo.jpg"))?"image.php?i=pics/firms/".$drinkBig['firm_id']."_logo.jpg&fh=&fv=&ed=&gr=&rw=150&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5":"pics/firms/no_logo.png".'"/></a></td>
	<td valign="top"><a href="напитки-firmID='.$drinkBig['firm_id'].','.str_replace(' ','_',$drinkBig['Firm']['firm']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">Още напитки от '.$drinkBig['Firm']['firm'].'</a><br /><hr  style="margin:5px; border-bottom: 1px solod #FF6600;">
	<a href="рецепти-firmID='.$drinkBig['firm_id'].','.str_replace(' ','_',$drinkBig['Firm']['firm']).'_вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Още рецепти от '.$drinkBig['Firm']['firm'].'</a><br /><hr style="margin:5px; border-bottom: 1px solod #FF6600;">
	<a href="справочник-firmID='.$drinkBig['firm_id'].','.str_replace(' ','_',$drinkBig['Firm']['firm']).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">Още справочни описания от '.$drinkBig['Firm']['firm'].'</a></td>
	</tr></table>';
	
}
	
	
	if($drinkBig['user_id'] > 0) 
	{
	
		if(is_file("pics/users/".$drinkBig['user_id']."_avatar.jpg")) $picFileUser= "pics/users/".$drinkBig['user_id']."_avatar.jpg";
		else $picFileUser = 'pics/users/no_photo_thumb.png';
	
		list($widthUser, $heightUser, $typeUser, $attrUser) = getimagesize($picFileUser);
		$pic_width_or_heightUser = 100;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($heightUser) && ($widthUser))	
		{
			if($widthUser >= $heightUser)	{$newheightUser = ($heightUser/$widthUser)*$pic_width_or_heightUser; $newwidthUser	=	$pic_width_or_heightUser;	}
			else					{$newwidthUser = ($widthUser/$heightUser)*$pic_width_or_heightUser; $newheighUsert	=	$pic_width_or_heightUser;	}
		}	
	$drink_big .= '	<div class="detailsDiv" style="float:left;width:240px;margin-bottom:5px; padding:5px; padding-top:0px; background-color:#39C6EE;">
				<div style=" float:left; color:#FFF;font-weight:bold;" >		
					<h4 style=" float:left; margin-left:0px; background-color:transparent; background-image:url(\'\');"><a style="color:#FFF;" href="разгледай-потребител-'.$drinkBig['user_id'].','.str_replace(' ','_',$drinkBig['User']['user']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.$drinkBig['User']['user']  .'</a></h4>		
				</div>
						<br style="clear:both;"/>		
			</div>
		    	   	
		<br style="clear:both;"/>	
	
			<table><tr><td align="center" valign="top">
					<a href="разгледай-потребител-'.$drinkBig['user_id'].','.str_replace(' ','_',$drinkBig['User']['user']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">
					<div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" ><img width="'.$newwidthUser.'" height="'.$newheightUser.'" src="'.$picFileUser.'" /></div></a>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						<a href="http://gozbite.com/разгледай-дестинация-'.$drinkBig['User']['location_id'].','.myTruncateToCyrilic(locationTracker($drinkBig['User']['location_id']),100,"_","").'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html">'.locationTracker($drinkBig['User']['location_id']).'</a>
					</div>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						<a href="напитки-userID='.$drinkBig['user_id'].','.str_replace(' ','_',$drinkBig['User']['user']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">Рецепти за Напитки: '.$drinkBig['User']['cnt_drink'].'</a>
					</div>
				</td>
				<td valign="top"><a href="напитки-userID='.$drinkBig['user_id'].','.str_replace(' ','_',$drinkBig['User']['user']).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">Още напитки от '.$drinkBig['User']['user'].'</a><br /><hr  style="margin:5px; border-bottom: 1px solod #FF6600;">
				<a href="рецепти-userID='.$drinkBig['user_id'].','.str_replace(' ','_',$drinkBig['User']['user']).'_вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Още рецепти от '.$drinkBig['User']['user'].'</a><br /><hr style="margin:5px; border-bottom: 1px solod #FF6600;">
				<a href="справочник-userID='.$drinkBig['user_id'].','.str_replace(' ','_',$drinkBig['User']['user']).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">Още справочни описания от '.$drinkBig['User']['user'].'</a></td>
					
				</tr></table>';
				
	} 
	
$drink_big .= '	
</div>


	<br style="clear:both;"/>	
</div>


<div class="detailsDiv" style="float:left; width:370px; margin-bottom:20px; margin-left:15px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		
<h4>Продукти</h4>	

	<table>';
	
	  	if (count($drinkBig['Products']) > 0) 
		{
			foreach ($drinkBig['Products'] as $resultDrinkProducts)
			{			 		
				$drink_big .=  "<tr><td style='color:#666666; font-weight:bold;'> &rarr;</td> <td>  <font style='color:#FF6600;'>".$resultDrinkProducts['drink_product_name']."</font> </td></tr>"; 
		 
	    	}
		}	
			
$drink_big .= '
	</table>		
						

	<div id="track1" class="track" style="margin-right:5px; width: 130px; margin-bottom:3px;" >
	   <div id="handle1" class="handle" style="width: 30px;" ><p id="changed" style="color:#FFFFFF; text-align:center;  font-size:10px; font-weight:bold; line-height:1.2;">12px</p></div>
	</div>';
	
/*	
$drink_big .= '<script type="text/javascript">
		new Control.Slider(\'handle1\' , \'track1\',
		{
			range: $R(10,28),
			values: [10,12,14,18,24,28],
			sliderValue: 12,
			onChange: function(v){
				var objTextBody = document.getElementById("drinkBodyDiv");		
			   	objTextBody.style.fontSize = v+"px";
			   	 $(\'changed\').innerHTML = v+\'px\';
			   	
			},
			onSlide: function(v) {
			  	var objTextBody = document.getElementById("drinkBodyDiv");
			  	objTextBody.style.fontSize = v+"px";
			  	 $(\'changed\').innerHTML = v+\'px\';
			}
		} );
	</script>';
	*/	


$drink_big .= '	
	<h4>Начин на Приготвяне</h4>
	
	<br style="clear:both;"/>	

	<p id="drinkBodyDiv">
		'.insertADV($drinkBig['info']).'	
	</p>			
</div>
<br style="clear:both;"/>	';

	
	
 

	if($drinkBig['has_video'] == '1' OR !empty($drinkBig['youtube_video']))
	{ 
$drink_big .= '
	<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		<h4>Видео Представяне</h4>
		
		<br style="clear:both;"/>	';
	
	
            $video_name = $drinkID;
            	
			if(file_exists("videos/drinks/".$video_name.".flv"))
			{
				$video = "videos/drinks/".$video_name.".flv";
				
				$drink_big .= '
				<br>
				
				<div id="videoDIV"  style="margin-left:0px;">
				<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
					<script language="javascript" type="text/javascript">
						var FO = {movie:"flash_flv_player/flvplayer.swf",width:"300",height:"170",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
						flashvars:"file=../videos/drinks/'.$video_name.'.flv&image=../videos/drinks/'.$video_name.'_thumb.jpg" };
						UFO.create(FO, "player1");
					</script>
				</div>';
									
		     
			}
			elseif(!empty($drinkBig['youtube_video'])) 
			{
				$drink_big .= '	  				
				<object type="application/x-shockwave-flash" style="width:450px; height:350px;" data="'.$drinkBig['youtube_video'].'">
				<param name="movie" value="'.$drinkBig['youtube_video'].'" />
				</object> ';
			
		
			}				
						
$drink_big .= '	</div>	';

 } 




if($drinkBig['numTags'] > 0) 
 {
 	$drink_big .= '<table><tr><td> 
		     <div class="postBig">
				<div class="detailsDiv" style="float:left; width:640px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<h4 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;">
						<div style="margin-left:6px; height:22px; width:450px;color:#0099FF;font-weight:bold;" >Други напитки съдържащи:</div>		
					</h4>';
					 
						$drink_big .= '	<table cellpadding="2"><tr>';
						 for($i=0, $cn=1; $i<$drinkBig['numTags']; $i++, $cn++) 
						 {						
							$drink_big .= '<td width="125"><h4 style="font-size:12px; padding-left:5px; margin-top:2px;"><a  style="font-size:12px;" href="напитки-етикет-'.$drinkBig['Tags'][$i].',още_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.$drinkBig['Tags'][$i].'</a></h4></td>';
							if($cn % 5 == 0) { $drink_big .=  "</tr><tr>"; }
							if($cn == $drinkBig['numTags']) { $drink_big .=  "</tr>"; }
						 } 
						$drink_big .= '</table>';
					 
				$drink_big .= '</div>
			</div>
		</td></tr></table>';

}	


	
$drink_big .= '	
<div class="detailsDiv" style="float:left; width:650px; margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
			
			<a href="javascript://" onclick=" new Effect.toggle($(\'writeComments\'),\'Blind\'); "><h4>Коментирай</h4></a>
			
			 <div id="writeComments" style="width:100%;  ">
			 <!--
				 <table><tr><td align="left">
				 	 <table><tr><td colspan="2">
    				 		<input type="hidden" name="drinkID" value="'.$_REQUEST['drinkID'].'"/>
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
	    		 	<fb:comments xid="gozbite_drink_'.$drinkBig['drinkID'].'" numposts="10" width="650" send_notification_uid="1544088151"></fb:comments>
				</td>
				<td width="20">&nbsp;</td>
				<td align="right" valign="top">';
	    		//$drink_big .= require("includes/modules/googleAdsense_300x250px.php"); // Pokazva GoogleAdsense 
	    		$drink_big .= '</td></tr></table>
	    		
			</div>
						
			
	<!--		
			<h4 style="cursor:pointer; font-size:12px;" onclick=" new Effect.toggle($(\'readComments\'),\'Blind\'); if ($(\'readComments\').visible()) {$(\'search_div_link\').update(\'Покажи Коментарите ('.($numDrinkComment?$numDrinkComment:0).')\');} else {$(\'search_div_link\').update(\'Скрий Коментарите ('.($numDrinkComment?$numDrinkComment:0).')\');}"><div id="search_div_link" class="detailsDiv">Скрий Коментарите ('.($numDrinkComment?$numDrinkComment:0).')</div></h4>

			<div id="readcomments" style="width:100%;  overflow: scroll; ">';
				if($numDrinkComment>0)
		    	{
		    	    for($i=0;$i<$numDrinkComment;$i++)
		    	    {
		    	

			    	    //************ Автора за всяка тема ****************
					$sql="SELECT ".(($resultDrinkComment[$i]['autor_type']=='user')?" CONCAT(first_name, ' ', last_name)":'name')." as 'autor_name', username as 'autor_username' FROM ".(($resultDrinkComment[$i]['autor_type']=='user')?'users':'firms')." WHERE ".(($resultDrinkComment[$i]['autor_type']=='user')?'userID':'id')." = '".$resultDrinkComment[$i]['autor']."' LIMIT 1";
					$conn->setsql($sql);
					$conn->getTableRow();
					$resultMneniqAvtor = $conn->result['autor_name'];
					$resultMneniqAvtorUsername = $conn->result['autor_username'];
					
					if($resultDrinkComment[$i]['autor'] == 1 && $resultDrinkComment[$i]['autor_type'] == 'user')
					{
						$resultMneniqAvtor = 'Админ';
					}
					
	    	    	if($resultDrinkComment[$i]['sender_name'] != '')
					{
						$resultMneniqAvtor = $resultDrinkComment[$i]['sender_name'];
					}
		
					if($resultDrinkComment[$i]['autor_type']=='user')
					{
						if(is_file("pics/users/".$resultDrinkComment[$i]['autor']."_avatar.jpg")) $picFile= "pics/users/".$resultDrinkComment[$i]['autor']."_avatar.jpg";
					   	else $picFile = 'pics/users/no_photo_thumb.png';
					}
					elseif($resultDrinkComment[$i]['autor_type']=='firm')
					{
						if(is_file("pics/firms/".$resultDrinkComment[$i]['autor']."_logo.jpg")) $picFile= "pics/firms/".$resultDrinkComment[$i]['autor']."_logo.jpg";
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
						
			    	$sql="SELECT cnt_comment FROM ".(($resultDrinkComment[$i]['autor_type']=='user')?'users':'firms')." WHERE ".(($resultDrinkComment[$i]['autor_type']=='user')?'userID':'id')." = '".$resultDrinkComment[$i]['autor']."' LIMIT 1";
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
				
$drink_big .= '	
			 
				 	
			<div class="detailsDiv" style="float:left; width:620px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFF;">
				<table><tr><td valign="top">
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						'.(($resultDrinkComment[$i]['autor_type'] == 'user') ? '<a href="разгледай-потребител-'.$resultDrinkComment[$i]['autor'].',вкусни_готварски_напитки_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.$resultMneniqAvtor : '<a href="разгледай-фирма-'.$resultDrinkComment[$i]['autor'].',вкусни_готварски_напитки_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.$resultMneniqAvtor )  .'
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
					<h4 style="color:#FF8400">'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($resultDrinkComment[$i]['created_on']))).'</h4>
				
					<div class="detailsDiv" style="float:left; width:460px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE; color:#FFFFFF;">
						'.stripslashes($resultDrinkComment[$i]['comment_body']).'						
			        </div>
				</td></tr></table>
				
				<hr style="float:left;margin-top:20px;color: #eee;background-color: #eee; height:1px; border:0; width:600px;" />  
				
				<br style="clear:both;" />
			</div>';
		    	   		    	    
	               
		    	 
	                } 
		    	}    	   	
		    	
	    	$drink_big .= '	
			</div>
				
			-->
	    					
</div>

</div>
<br style="clear:left;"/>';
		
		
 if(empty($_REQUEST['drink_category'])) $_REQUEST['drink_category'] = get_drink_categoryBydrinkID($_GET['drinkID']);
			
    if (($_REQUEST['drink_category']!="") or ($_REQUEST['category']!="")) 
	{
		$sql="SELECT name FROM drink_category WHERE id='".($_REQUEST['category']?$_REQUEST['category']:$_REQUEST['drink_category'])."'";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCatName = $conn->result['name'];
		
		$drink_big .= require_once("moreDrinks.php");              
     }
     
$drink_big .= '</div>';


return $drink_big;

?>