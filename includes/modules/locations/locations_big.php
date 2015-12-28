<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$location_big = "";
   	
	$clauses = array();
   	$clauses['where_clause'] = " AND l.id = '".$_REQUEST['locationID']."'";
	$clauses['order_clause'] = '';
	$clauses['limit_clause'] = ' LIMIT 1';
	$location_big_info = $this->getItemsList($clauses);

	if(!$location_big_info)
	{
		return false;
	}
	$locationBig = $location_big_info[$_REQUEST['locationID']];	

	
	 if(is_file("pics/locations/".$locationBig['resultPics']['url_big'][0])) $picFile= "pics/locations/".$locationBig['resultPics']['url_big'][0];
	 else $picFile = 'pics/locations/no_photo_big.png';
		  

		 	
    list($width, $height, $type, $attr) = getimagesize($picFile);
	$pic_width_or_height = 140;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
	if (($height) && ($width))	
	{
		if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
		else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
	}
		
			
			
	$location_big .= '<script type="text/javascript">
					makeViewLog(\'location\',\''.$locationBig['locationID'].'\');
				</script>';
			

//$location_big .=print_r($locationBig,1);

$location_big .= '<div style="margin-bottom:20px;" id="next_previousDIV"></div>';
			

$location_big .= '<div class="detailsDivMap" style="width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<div id="myMap" style="width: 660px; height: 290px;"></div>';
					 $location_big .= require("mapLocations.php");
$location_big .= '</div><br style="clear:left;"/>';
$location_big .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

	<div id="track1" class="track" style="margin-right:5px; width: 130px; margin-bottom:3px;" >
	   <div id="handle1" class="handle" style="width: 30px;" ><p id="changed" style="color:#FFFFFF; text-align:center;  font-size:10px; font-weight:bold; line-height:1.2;">12px</p></div>
	</div>';
	
	/*
$location_big .= '	
	<script type="text/javascript">
		new Control.Slider(\'handle1\' , \'track1\',
		{
			range: $R(10,28),
			values: [10,12,14,18,24,28],
			sliderValue: 12,
			onChange: function(v){
				var objTextBody = document.getElementById("locationBodyDiv");		
			   	objTextBody.style.fontSize = v+"px";
			   	 $(\'changed\').innerHTML = v+\'px\';
			   	
			},
			onSlide: function(v) {
			  	var objTextBody = document.getElementById("locationBodyDiv");
			  	objTextBody.style.fontSize = v+"px";
			  	 $(\'changed\').innerHTML = v+\'px\';
			}
		} );
	</script>';
	*/
	
	
$location_big .= '	
	
<div class="postBig">
<h4><div style=" float:left; margin-left:6px; width:440px;color:#0099FF;font-weight:bold;" >'.$locationBig['locType']." ".$locationBig['location_name'].'</div>
	<div style=" float:right; margin-right:5px; font-weight:bold; color:#ff6600;" ><u>Разгледано '.($locationBig['cnt']?$locationBig['cnt']:1).' пъти</u></div>';
	
	if((($locationBig['autor'] == $_SESSION['userID'] && $_SESSION['user_type'] == $locationBig['autor_type']) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {	
		$location_big .= '	<div style="float:right; margin-right:5px;" ><a href="редактирай-дестинация-'.$locationBig['locationID'].','.myTruncateToCyrilic($locationBig['locType']." ".$locationBig['location_name'],200,"_","") .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>';
	}
	if((($_SESSION['user_kind'] == 2) or $_SESSION['userID']==1)) {	
		$location_big .= '	<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-дестинация-'.$locationBig['locationID'].','.myTruncateToCyrilic($locationBig['locType']." ".$locationBig['location_name'],200,"_","").'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
	}
	
	$location_big .= '
	<br style="clear:both;"/>	
</h4>

<br />						 

	<div style="float:left; margin-left:0px;margin-right:20px; width:150px; overflow:hidden;  border:1px double #0099FF;" ><div ><img width="150" src="'.$picFile.'" /></div></div>
		
	
       			
	<p id="locationBodyDiv">
		'.insertADV($locationBig['info']).'
	</p>
	
	<br style="clear:both;"/>	

<h4 align="left">
	<a href="фирми-cityName='.$locationBig['locationID'].',заведения_ресторанти_механи_барове_пицарии_търговци_Фирми_от_'.myTruncateToCyrilic($locationBig['locType']." ".$locationBig['location_name'],200,"_","").'.html">Заведения/Фирми от '.$locationBig['locType'].' '.$locationBig['location_name'] .'</a>
</h4>';
	



 if($locationBig['numTags'] > 0) 
 {
 	$location_big .= '<table><tr><td> 
		     <div class="postBig">
				<div class="detailsDiv" style="float:left; width:640px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<h4 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;">
						<div style="margin-left:6px; height:22px; width:450px;color:#0099FF;font-weight:bold;" >Етикети</div>		
					</h4>';
					 
						$location_big .= '	<table cellpadding="2"><tr>';
						 for($i=0, $cn=1; $i<$locationBig['numTags']; $i++, $cn++) 
						 {						
							$location_big .= '<td width="125"><h4 style="font-size:12px; padding-left:5px; margin-top:2px;"><a  style="font-size:12px;" href="дестинации-info='.$locationBig['Tags'][$i].',населени_места_дестинации_курорти_градове_села.html">'.$locationBig['Tags'][$i].'</a></h4></td>';
							if($cn % 5 == 0) { $location_big .=  "</tr><tr>"; }
							if($cn == $locationBig['numTags']) { $location_big .=  "</tr>"; }
						 } 
						$location_big .= '</table>';
					 
				$location_big .= '</div>
			</div>
		</td></tr></table>';
}	

$location_big .= '<div id="options">';


/*
$location_big .= '

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


$location_big .= '
		<div style="float:right;margin-right:10px;">
			<div style="float:left; margin-right:2px;" >
				<fb:like href="http://www.GoZBiTe.Com/разгледай-дестинация-'.$locationBig['locationID'].','.myTruncateToCyrilic($locationBig['locType']." ".$locationBig['location_name'],200,"_","") .'.html" layout="button_count"	show_faces="false" width="50" height="21" action="like" colorscheme="light"></fb:like>								
				<span style="background:transparent; color:#6B9D09; font-size:12px; font-weight:bold;">Сподели в: </span>
				<a href="http://www.facebook.com/sharer.php?u=http://www.GoZBiTe.Com/разгледай-дестинация-'.$locationBig['locationID'].','.myTruncateToCyrilic($locationBig['locType']." ".$locationBig['location_name'],200,"_","") .'.html&amp;t='.$locationBig['location_name'].'" target="_blank"><img src="images/facebook.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;
				<a href="http://twitter.com/home?status='.myTruncateToCyrilic($locationBig['locType']." ".$locationBig['location_name'],200,"_","") .', http://www.GoZBiTe.Com/разгледай-дестинация-'.$locationBig['locationID'].','.myTruncateToCyrilic($locationBig['locType']." ".$locationBig['location_name'],200,"_","") .'.html" target="_blank"><img src="images/twitter.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>				
			</div>';

			$location_big .=  sprintf("<a href = \"javascript://\" onclick = \"window.open('includes/tools/sendStuffToFriend.php?locationID=%d', 'sndWin', 'top=0, left=0, width=440px, height=400px, resizable=yes, toolbars=no, scrollbars=yes');\" class = \"smallOrange\">", $locationBig['locationID']);
			$location_big .= '<img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a>';
			$location_big .=  sprintf("<a href = \"javascript://\" onclick = \"window.print();\" class = \"smallOrange\">", $locationBig['locationID']);
			$location_big .= '<img style="margin-left:5px;" src="images/print.gif" alt="Разпечатай" width="14" height="14"></a>';
$location_big .= '			
		</div>
		
	</div>


<br style="clear:both;"/>

<div class="detailsDiv" style="float:left; width:250px; margin-bottom:20px; margin-right:5px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';			

  
	$location_big .= '<h4>Още снимки</h4>			
	<ul id="thumbs">';

	$i=0;
	foreach ($locationBig['resultPics']['url_thumb'] as $pics_thumb)
	{ 	
	  	if(is_file('pics/locations/'.$pics_thumb))
	  	{ 
			$location_big .= '<li class="thumbDiv"><a href="pics/locations/';
			$location_big .= $locationBig['resultPics']['url_big'][$i];    			
			$location_big .= '" class=\'lightview\' rel=\'gallery[myset]\'><img width="60" height="60" onclick = "$(\'big_pic\').src=\'pics/locations/';
			$location_big .= $locationBig['resultPics']['url_big'][$i];    		
			$location_big .= '\'; "  src="';
			$location_big .= 'pics/locations/'.$pics_thumb; 
			$location_big .= '" /></a></li>';
			
			$i++;
	 	}
	}
$location_big .= '</ul>';
     				
$location_big .= '</div>';





if(($locationBig['has_video'] == '1' OR !empty($locationBig['youtube_video'])))
{ 

	$location_big .= '<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
	<h4>Видео Представяне</h4>
	
	<br style="clear:both;"/>';	

	
        $video_name = $locationID;
        	
		if(file_exists("videos/locations/".$video_name.".flv"))
		{
			$video = "videos/locations/".$video_name.".flv";
			
			$location_big .= '<br>
			
			<div id="videoDIV"  style="margin-left:0px;">
			<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
				<script language=\'javascript\' type=\'text/javascript\'>
					var FO = {movie:"flash_flv_player/flvplayer.swf",width:"300",height:"170",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
					flashvars:"file=../videos/locations/'.$video_name.'.flv'.'&image=../videos/locations/'.$video_name.'_thumb.jpg'.'" };
					UFO.create(FO, "player1");
				</script>
			</div>';
								
		     
		}
		elseif(!empty($locationBig['youtube_video'])) 
		{
				  				
			$location_big .= '<object type="application/x-shockwave-flash" style="width:450px; height:350px;" data="'.$locationBig['youtube_video'].'">
			<param name="movie" value="'.$locationBig['youtube_video'].'" />
			</object> ';
		
		
		}				
					
	$location_big .= '</div>';

} 
	
	
	
$location_big .= '	
<div class="detailsDiv" style="float:left; width:650px; margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		
		<a href="javascript://" onclick=" new Effect.toggle($(\'writeComments\'),\'Blind\'); "><h4>Коментирай</h4></a>
	
			<div id="writeComments" style="width:100%;  ">';
			

$location_big .= '<table><tr><td align="left" valign="top">
	    		 	<fb:comments xid="gozbite_destinaciq_'.$locationBig['locationID'].'" numposts="10" width="650"></fb:comments>
				</td>
				<td width="20">&nbsp;</td>
				<td align="right" valign="top">';
 
//$location_big .= require("includes/modules/googleAdsense_300x250px.php"); // Pokazva GoogleAdsense   		
	    			
$location_big .= '</td></tr></table>    		 		   		 	
	
			</div>
			
</div>

</div>
<br style="clear:left;"/>
</div>';
			
			
return $location_big;

?>