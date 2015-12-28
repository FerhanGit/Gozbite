<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$firm_big = "";
   	
	$clauses = array();
   	$clauses['where_clause'] = " AND f.id = '".$_REQUEST['firmID']."'";
	$clauses['order_clause'] = '';
	$clauses['limit_clause'] = ' LIMIT 1';
	$firm_big_info = $this->getItemsList($clauses);

	if(!$firm_big_info)
	{
		return false;
	}
	$firmBig = $firm_big_info[$_REQUEST['firmID']];	

	if(is_file('pics/firms/'.$firmBig['firmID'].'_logo.jpg')) 
	{
		$logoFile = 'pics/firms/'.$firmBig['firmID'].'_logo.jpg'; 
	}
	else 
	{
		$logoFile = "pics/firms/no_logo.png";
	}

		 	
	list($width, $height, $type, $attr) = getimagesize($logoFile);
	$pic_width_or_height = 140;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
	if (($height) && ($width))	
	{
		if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
		else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
	}
		
			
			
	$firm_big .= '<script type="text/javascript">
					makeViewLog(\'firm\',\''.$firmBig['firmID'].'\');
				</script>';
			

//$firm_big .=print_r($firmBig,1);

$firm_big .= '<div style="margin-bottom:20px;" id="next_previousDIV"></div>';
			

$firm_big .= '<div class="detailsDivMap" style="width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<div id="myMap" style="width: 660px; height: 290px;"></div>';
					 $firm_big .= require("mapFirms.php");
$firm_big .= '</div><br style="clear:left;"/>';
$firm_big .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

	<div id="track1" class="track" style="margin-right:5px; width: 130px; margin-bottom:3px;" >
	   <div id="handle1" class="handle" style="width: 30px;" ><p id="changed" style="color:#FFFFFF; text-align:center;  font-size:10px; font-weight:bold; line-height:1.2;">12px</p></div>
	</div>';
	
/*
$firm_big .= '
	<script type="text/javascript">
		new Control.Slider(\'handle1\' , \'track1\',
		{
			range: $R(10,28),
			values: [10,12,14,18,24,28],
			sliderValue: 12,
			onChange: function(v){
				var objTextBody = document.getElementById("firmBodyDiv");		
			   	objTextBody.style.fontSize = v+"px";
			   	 $(\'changed\').innerHTML = v+\'px\';
			   	
			},
			onSlide: function(v) {
			  	var objTextBody = document.getElementById("firmBodyDiv");
			  	objTextBody.style.fontSize = v+"px";
			  	 $(\'changed\').innerHTML = v+\'px\';
			}
		} );
	</script>';
*/	
	
$firm_big .= '	
<div class="postBig">
<h4><div style=" float:left; margin-left:6px; width:440px;color:#0099FF;font-weight:bold;" >'.$firmBig['name'].'</div>
	<div style=" float:right; margin-right:5px; font-weight:bold; color:#ff6600;" ><u>Разгледано '.($firmBig['cnt']?$firmBig['cnt']:1).' пъти</u></div>';
	
	if(($firmBig['firmID'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'firm') or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1) 
	{
		$firm_big .= ' <div style="float:right; margin-right:5px;" ><a href="редактирай-фирма-'.$firmBig['firmID'].','.myTruncateToCyrilic($firmBig['name'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a>';
		if($firmBig['gold'] == '1')
		{
			$firm_big .= '<img style="margin-left:5px;" src="images/star_gold.gif" width="14" height="14">';
		} 
		elseif($firmBig['silver'] == '1') 
		{ 
			$firm_big .= '<img style="margin-left:5px;" src="images/star_grey.gif" width="14" height="14">';
		}
		$firm_big .= '</div>';
	}
	else 
	{
		$firm_big .= '<div style="float:right; margin-right:5px;" >';
		if($firmBig['gold'] == '1') 
		{
			$firm_big .= '<img style="margin-left:5px;" src="images/star_gold.gif" width="14" height="14">';
		} 
		elseif($firmBig['silver'] == '1') 
		{ 
			$firm_big .= '<img style="margin-left:5px;" src="images/star_grey.gif" width="14" height="14">';
		} 
		$firm_big .= '</div>';
	}
	if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) 
	{	
		$firm_big .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-фирма-'.$firmBig['firmID'].','.myTruncateToCyrilic($firmBig['name'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
	}
	$firm_big .= '
	
	<br style="clear:both;"/>	
</h4>

<br />						 

	<div style="float:left; margin-left:0px;margin-right:20px; width:150px; overflow:hidden;  border:1px double #0099FF;" ><div ><img width="150" src="'.((is_file("pics/firms/".$firmBig['firmID']."_logo.jpg"))?"pics/firms/".$firmBig['firmID']."_logo.jpg":"pics/firms/no_logo.png").'" /></div></div>
		
	
       			
	<p id="firmBodyDiv">
		'.insertADV($firmBig['description']).'
	</p>
	
	<br style="clear:both;"/>	
	
<h4 align="right">
	<a href="рецепти-firmID='.$_REQUEST['firmID'].',вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Рецепти от '.$firmBig['name'] .'</a> | 
	<a href="напитки-firmID='.$_REQUEST['firmID'].',вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Напитки от '.$firmBig['name'] .'</a> |
	<a href="справочник-firmID='.$_REQUEST['firmID'].',вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Описания от '.$firmBig['name'] .'</a>  	
</h4>';
	



 if($firmBig['numTags'] > 0) 
 {
 	$firm_big .= '<table><tr><td> 
		     <div class="postBig">
				<div class="detailsDiv" style="float:left; width:640px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<h4 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;">
						<div style="margin-left:6px; height:22px; width:450px;color:#0099FF;font-weight:bold;" >Етикети</div>		
					</h4>';
					 
						$firm_big .= '	<table cellpadding="2"><tr>';
						for($i=0, $cn=1; $i<$firmBig['numTags']; $i++, $cn++) 
						{						
							$firm_big .= '<td width="125"><h4 style="font-size:12px; padding-left:5px; margin-top:2px;"><a  style="font-size:12px;" href="фирми-description='.$firmBig['Tags'][$i].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кафене_механа_дискотека_клуб_кръчма.html">'.$firmBig['Tags'][$i].'</a></h4></td>';
							if($cn % 5 == 0) { $firm_big .=  "</tr><tr>"; }
							if($cn == $firmBig['numTags']) { $firm_big .=  "</tr>"; }
						} 
						$firm_big .= '</table>';
					 
				$firm_big .= '</div>
			</div>
		</td></tr></table>';
}	

$firm_big .= '<div id="options">';


/*
$firm_big .= '

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
    

$firm_big .= '
		<div style="float:right;margin-right:10px;">
			<div style="float:left; margin-right:2px;" >
				<fb:like href="http://www.GoZBiTe.Com/разгледай-фирма-'.$firmBig['firmID'].','.myTruncateToCyrilic($firmBig['name'],200,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="21" action="like" colorscheme="light"></fb:like>								
				<span style="background:transparent; color:#6B9D09; font-size:12px; font-weight:bold;">Сподели в: </span>
				<a href="http://www.facebook.com/sharer.php?u=http://www.GoZBiTe.Com/разгледай-фирма-'.$firmBig['firmID'].','.myTruncateToCyrilic($firmBig['name'],200,'_','') .'.html&amp;t='.$firmBig['name'].'" target="_blank"><img src="images/facebook.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;
				<a href="http://twitter.com/home?status='.myTruncateToCyrilic($firmBig['name'],200,'_','') .', http://www.GoZBiTe.Com/разгледай-фирма-'.$firmBig['firmID'].','.myTruncateToCyrilic($firmBig['name'],200,'_','') .'.html" target="_blank"><img src="images/twitter.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>				
			</div>';

			$firm_big .=  sprintf("<a href = \"javascript://\" onclick = \"window.open('includes/tools/sendStuffToFriend.php?firmID=%d', 'sndWin', 'top=0, left=0, width=440px, height=400px, resizable=yes, toolbars=no, scrollbars=yes');\" class = \"smallOrange\">", $firmBig['firmID']);
			$firm_big .= '<img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a>';
			$firm_big .=  sprintf("<a href = \"javascript://\" onclick = \"window.print();\" class = \"smallOrange\">", $firmBig['firmID']);
			$firm_big .= '<img style="margin-left:5px;" src="images/print.gif" alt="Разпечатай" width="14" height="14"></a>';
$firm_big .= '			
		</div>
		
	</div>


<br style="clear:both;"/>

<div class="detailsDiv" style="float:left; width:250px; margin-bottom:20px; margin-right:5px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';			

if ($firmBig['has_pic'] == '1')
{  
		$firm_big .= '<h4>Още снимки</h4>			
	<ul id="thumbs">';

	$i=0;
	foreach ($firmBig['resultPics']['url_thumb'] as $pics_thumb)
	{ 	
	  	if(is_file('pics/firms/'.$pics_thumb))
	  	{ 
			$firm_big .= '<li class="thumbDiv"><a href="pics/firms/';
			$firm_big .= $firmBig['resultPics']['url_big'][$i];    			
			$firm_big .= '" class=\'lightview\' rel=\'gallery[myset]\'><img width="60" height="60" onclick = "$(\'big_pic\').src=\'pics/firms/';
			$firm_big .= $firmBig['resultPics']['url_big'][$i];    		
			$firm_big .= '\'; "  src="';
			$firm_big .= 'pics/firms/'.$pics_thumb; 
			$firm_big .= '" /></a></li>';
			
			$i++;
	 	}
	}
$firm_big .= '</ul>';
}     				
$firm_big .= '</div>';




$firm_big .= '		
<div class="detailsDiv" style="float:left; width:370px; margin-bottom:20px; margin-left:15px;  border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		
		
		<h4>Категории</h4>';
	                                    	
		 // ------------------------------ DETAILS LIST -------------------------------		
	 		if ($firmBig['numCats'] > 0)  
			{
				for ($z=0;$z<$firmBig['numCats'];$z++)
				{
					$firm_big .= '<h3 align="left">&rarr; <a class="read_more_link"  href="фирми-категория-'.$firmBig['Cats'][$z]['firm_category_id'] .','.myTruncateToCyrilic($firmBig['Cats'][$z]['firm_category_name'],100,'_','') .'.html" >'.$firmBig['Cats'][$z]['firm_category_name'] .'</a></h3>';
							 		
		    	}
			}		
					
		// ---------------------------------------------------------------------------		
			
			
$firm_big .= '
		<h4>Детайли</h4>	
		
		<table>';
					   

		$firm_big .= "<tr><td style='color:#666666; font-weight:bold; width:130px;'>Населено място </td><td style='color:#666666; font-weight:bold;'> &rarr;</td><td><a  class='read_more_link' href='разгледай-дестинация-".$firmBig['location_id'].",".myTruncateToCyrilic($firmBig['locType']." ".$firmBig['location'],200,'_','')."_описание_на_градове_села_курорти_дестинации_от_цял_свят.html'>".$firmBig['locType'].' '.$firmBig['location']."</a></td></tr>"; 
		$firm_big .= "<tr><td style='color:#666666; font-weight:bold; width:130px;'>Адрес </td><td style='color:#666666; font-weight:bold;'> &rarr;</td><td>  ".$firmBig['address']."</td></tr>"; 
		$firm_big .= "<tr><td style='color:#666666; font-weight:bold; width:130px;'>Телефон </td><td style='color:#666666; font-weight:bold;'> &rarr;</td><td> ".$firmBig['phone']."</td></tr>"; 
		$firm_big .= "<tr><td style='color:#666666; font-weight:bold; width:130px;'>Е-мейл </td><td style='color:#666666; font-weight:bold;'> &rarr;</td><td> ".$firmBig['email']."</td></tr>"; 
		$firm_big .= "<tr><td style='color:#666666; font-weight:bold; width:130px;'>Лице за контакти </td><td style='color:#666666; font-weight:bold;'> &rarr;</td><td> ".$firmBig['manager']."</td></tr>"; 
		$firm_big .= "<tr><td style='color:#666666; font-weight:bold; width:130px;'>Уеб </td><td style='color:#666666; font-weight:bold;'> &rarr;</td><td> ".$firmBig['web']."</td></tr>"; 
		$firm_big .= "<tr><td style='color:#666666; font-weight:bold; width:130px;'>Регистрирано </td><td style='color:#666666; font-weight:bold;'> &rarr;</td><td> ".convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($firmBig['registered_on']))) ."</td></tr>"; 
		$firm_big .= "</table>";
		
	
		
		
$firm_big .= '			
</div>';



	if(($firmBig['has_video'] == '1' OR !empty($firmBig['youtube_video'])))
	{ 

		$firm_big .= '<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		<h4>Видео Представяне</h4>
		
		<br style="clear:both;"/>';	
	
		
            $video_name = $firmID;
            	
			if(file_exists("videos/firms/".$video_name.".flv"))
			{
				$video = "videos/firms/".$video_name.".flv";
				
				$firm_big .= '<br>
				
				<div id="videoDIV"  style="margin-left:0px;">
				<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
					<script language=\'javascript\' type=\'text/javascript\'>
						var FO = {movie:"flash_flv_player/flvplayer.swf",width:"300",height:"170",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
						flashvars:"file=../videos/firms/'.$video_name.'.flv'.'&image=../videos/firms/'.$video_name.'_thumb.jpg'.'" };
						UFO.create(FO, "player1");
					</script>
				</div>';
									
			     
			}
			elseif(!empty($firmBig['youtube_video'])) 
			{
					  				
				$firm_big .= '<object type="application/x-shockwave-flash" style="width:450px; height:350px;" data="'.$firmBig['youtube_video'].'">
				<param name="movie" value="'.$firmBig['youtube_video'].'" />
				</object> ';
			
			
			}				
						
		$firm_big .= '</div>';
	
	} 
	
	
	
$firm_big .= '	
<div class="detailsDiv" style="float:left; width:650px; margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		
		<a href="javascript://" onclick=" new Effect.toggle($(\'writeComments\'),\'Blind\'); "><h4>Коментирай</h4></a>
	
			<div id="writeComments" style="width:100%;  ">';
			

$firm_big .= '<table><tr><td align="left" valign="top">
	    		 	<fb:comments xid="gozbite_firm_'.$firmBig['firmID'].'" numposts="10" width="650"></fb:comments>
				</td>
				<td width="20">&nbsp;</td>
				<td align="right" valign="top">';
 
	    		//$firm_big .= require("includes/modules/googleAdsense_300x250px.php"); // Pokazva GoogleAdsense    			
	    			
$firm_big .= '</td></tr></table>    		 		   		 	
	
			</div>
			
</div>

</div>
<br style="clear:left;"/>
</div>';
			
			
return $firm_big;

?>