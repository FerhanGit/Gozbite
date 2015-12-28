<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$bolest_big = "";
   	
	$clauses = array();
   	$clauses['where_clause'] = " AND b.bolestID = '".$_REQUEST['bolestID']."'";
	$clauses['order_clause'] = '';
	$clauses['limit_clause'] = ' LIMIT 1';
	$bolest_big_info = $this->getItemsList($clauses);

	if(!$bolest_big_info)
	{
		return false;
	}
	$bolestBig = $bolest_big_info[$_REQUEST['bolestID']];	
		
	$bolest_big .=  '<script type="text/javascript">
						makeViewLog(\'bolest\',\''.$bolestBig['bolestID'].'\');
					</script>';
	
//$bolest_big .=print_r($bolestBig,1);
		
$bolest_big .= '
<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">

<div style="float:left; margin-bottom:20px;" id="next_previousDIV"></div>


<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
	<div style=" float:left; margin-left:6px; width:450px;color:#FFFFFF;font-weight:bold;" >'.$bolestBig['title'].'</div>
	
	<div id="track1" class="track" style="margin-right:5px; width: 130px; margin-bottom:3px;" >
	   <div id="handle1" class="handle" style="width: 30px;" ><p id="changed" style="color:#FFFFFF; text-align:center;  font-size:10px; font-weight:bold; line-height:1.2;">12px</p></div>
	</div>';
	/*
$bolest_big .= '<script type="text/javascript">
		new Control.Slider(\'handle1\' , \'track1\',
		{
			range: $R(10,28),
			values: [10,12,14,18,24,28],
			sliderValue: 12,
			onChange: function(v){
				var objTextBody = document.getElementById(\'tabs_inside\');		
			   	objTextBody.style.fontSize = v+"px";
			   	 $(\'#changed\').html(v+"px");
			   	
			},
			onSlide: function(v) {
			  	var objTextBody = document.getElementById(\'tabs_inside\');
			  	objTextBody.style.fontSize = v+"px";
			  	 $(\'#changed\').html(v+"px");
			}
		} );
	</script>	';
	*/
	
$bolest_big .= '<div style=" float:right; margin-right:5px; font-weight:bold; color:#ff6600;" ><u>Разгледано '.($bolestBig['cnt']?$bolestBig['cnt']:1).' пъти</u></div>';								
	
	if((($bolestBig['autor'] == $_SESSION['userID'] && $_SESSION['user_type']==$bolestBig['autor_type']) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {	
	$bolest_big .= '	<div style="float:right; margin-right:5px;" ><a href="редактирай-описание-болест-'.$bolestBig['bolestID'].','.myTruncateToCyrilic($bolestBig['title'],50,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>';
	}
	if((($_SESSION['user_kind'] == 2) or $_SESSION['userID']==1)) {	
	$bolest_big .= '	<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-болест-'.$bolestBig['bolestID'].','.myTruncateToCyrilic($bolestBig['title'],50,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
	}

		$bolest_big .= '<br style="clear:both;"/>							
</div>
<br />	
	

<div class="actual_theme">	
<p>
	

	
	<div id="tabs_inside" style="width:660px;">';

		
	
			if(is_file("pics/bolesti/".$bolestBig['resultPics']['url_big'][0])) $picFile= "pics/bolesti/".$bolestBig['resultPics']['url_big'][0];
		   	else $picFile = 'pics/bolesti/no_photo_big.png';
		   	
		    list($width, $height, $type, $attr) = getimagesize($picFile);
			$pic_width_or_height = 180;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
			if (($height) && ($width))	
			{
				if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
				else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
			}
			
			
			
			//------------------------------------ Other Last Posts -------------------------------------//
			 	$response = '';
		  		$response .= '<h3 style="margin: 0px 0px 10px 0px; padding-left:5px; font-size:12px;  font-weight:bold; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style="font-weight:bold;"  href="болести-all_bolesti,още_полезни_болести_за_здравето.html" >Още Описания на Заболявания</a></h3>';
		
			    	
		  		$clauses['where_clause'] = " AND b.bolestID NOT IN ('".$bolestBig['bolestID']."')";
				$clauses['order_clause'] = ' ORDER BY b.date DESC';
				$clauses['limit_clause'] = ' LIMIT 5';
				$related_items = $this->getItemsList($clauses);
	
					
				foreach($related_items as $Itm)
				{
				   if(is_file('pics/bolesti/'.$Itm['resultPics']['url_thumb'][0])) $picFileRelatedBolesti= 'pics/bolesti/'.$Itm['resultPics']['url_thumb'][0];
				   else $picFileRelatedBolesti = 'pics/bolesti/no_photo_thumb.png';
				   		 
				 	list($widthRelatedBolesti, $heightRelatedBolesti, $typeRelatedBolesti, $attrRelatedBolesti) = getimagesize($picFileRelatedBolesti);
					$pic_width_or_heightRelatedBolesti = 50;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightRelatedBolesti) && ($widthRelatedBolesti))	
					{
						if($widthRelatedBolesti >= $heightRelatedBolesti)	{$newheighRelatedBolesti = ($heightRelatedBolesti/$widthRelatedBolesti)*$pic_width_or_heightRelatedBolesti; $newwidthRelatedBolesti	=	$pic_width_or_heightRelatedBolesti;	}
						else					{$newwidthRelatedBolesti = ($widthRelatedBolesti/$heightRelatedBolesti)*$pic_width_or_heightRelatedBolesti; $newheightRelatedBolesti	=	$pic_width_or_heightRelatedBolesti;	}
					}
				
				   $response .=	'<div style="width:250px;font-size:12px;font-family: "Trebuchet MS", Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-болест-'.$Itm['bolestID'].','.myTruncateToCyrilic($Itm['title'],50,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\'; document.getElementById(\'bolestImgDiv_'.$Itm['bolestID'].'\').style.borderColor=\'#0099FF\';" onMouseout="this.style.backgroundColor=\'transparent\';  document.getElementById(\'bolestImgDiv_'.$Itm['bolestID'].'\').style.borderColor=\'#CCCCCC\';">';
				   $response .= '<table><tr>';
				   $response .= '<td valign="top">';
				   $response .= '<a href="разгледай-болест-'.$Itm['bolestID'].','.myTruncateToCyrilic($Itm['title'],50,"_","").'.html" ><div id="bolestImgDiv_'.$Itm['bolestID'].'" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:60px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidthRelatedBolesti?$newwidthRelatedBolesti:50).'"  src="'.$picFileRelatedBolesti.'" /></div></a>';
				   $response .= '</td><td valign="top"><div style="margin-left:5px; width:180px;" ><a href="разгледай-болест-'.$Itm['bolestID'].','.myTruncateToCyrilic($Itm['title'],50,"_","").'.html" style="color:#666666;" >'.myTruncate($Itm['title'], 90, " ").'</a></div>';
				   $response .= '</td></tr></table>';	            
				   $response .= '</div>';
				}
			   	    
			//----------------------------------------------------------------------------------------------------//
			
			
			
	$bolest_big .= '<a href="'.$picFile.'" class="lightview" rel="gallery" ><div  onMouseover="this.style.borderColor="#0099FF";" onMouseout="this.style.borderColor="#CCCCCC";"  style="float:left; margin:5px;  border:1px solid #CCCCCC; width:190px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:180).'"  src="'.$picFile.'" /></div></a>';
	$bolest_big .= '<div style="float:right; width:250px; padding:5px; border-left:1px double #CDC8B4;">';
    $bolest_big .= $response; 
    $bolest_big .= '</div>'.insertADV(strip_tags($bolestBig['body'],'<br><br /><a><p><b><strong>')).'</div>';
		
	$bolest_big .= '<br style="clear:left;"/>		
		
		
</p>	
</div>';


$bolest_big .= '<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
	<div style=" float:left; margin-right:5px; font-weight:bold; color:#FFFFFF;" ><h3 align="left"><font style="font-size:12px;">Категория:</font> <a style=" font-size:14px; color:#FFFFFF;" href="болести-категория-'.$bolestBig['Cats'][0]['bolest_category_id'].','.$page.','.myTruncateToCyrilic($bolestBig['Cats'][0]['bolest_category_name'],100,'_','') .'.html">'.$bolestBig['Cats'][0]['bolest_category_name'].'</a> | </h3></div>								
	<div style=" float:left; font-size:14px; margin-left:6px; width:250px;color:#FFFFFF; " ><i>'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($bolestBig['date']))) .'</i></div>
	<div style=" float:right; font-size:14px; margin-right:5px; color:#FFFFFF;" ><h3 align="left"><font style="font-size:12px;">Източник: </font><a target="_blank" style=" font-size:14px; color:#FFFFFF;" href="'.(eregi('http://',$bolestBig['source']) ? $bolestBig['source'] : ('http://'.$bolestBig['source'])).'">'.$bolestBig['source'].'</a></h3></div>								
	<br style="clear:both;"/>							
</div>
	
<br style="clear:both;"/>	';

 if($bolestBig['numTags'] > 0) 
 {
 	$bolest_big .= '<table><tr><td> 
		     <div class="postBig">
				<div class="detailsDiv" style="float:left; width:640px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<h4 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;">
						<div style="margin-left:6px; height:22px; width:450px;color:#0099FF;font-weight:bold;" >Етикети</div>		
					</h4>';
					 
						$bolest_big .= '	<table cellpadding="2"><tr>';
						 for($i=0, $cn=1; $i<$bolestBig['numTags']; $i++, $cn++) 
						 {						
							$bolest_big .= '<td width="125"><h4 style="font-size:12px; padding-left:5px; margin-top:2px;"><a  style="font-size:12px;" href="болести-bolest_body='.$bolestBig['Tags'][$i].',още_полезни_здравни_болести.html">'.$bolestBig['Tags'][$i].'</a></h4></td>';
							if($cn % 5 == 0) { $bolest_big .=  "</tr><tr>"; }
							if($cn == $bolestBig['numTags']) { $bolest_big .=  "</tr>"; }
						 } 
						$bolest_big .= '</table>';
					 
				$bolest_big .= '</div>
			</div>
		</td></tr></table>';

}	

$bolest_big .= '<div id="options">';

/*
$bolest_big .= '

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
    

$bolest_big .= '<div style="float:right;margin-right:10px;">
            <div style="float:left; margin-right:2px;" >
				<fb:like href="http://www.gozbite.com/разгледай-болест-'.$bolestBig['bolestID'].','.myTruncateToCyrilic(strip_tags($bolestBig['title']),100,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="21" action="like" colorscheme="light"></fb:like>								
				<span style="background:transparent; color:#FFFFFF; font-size:12px; font-weight:bold;">Сподели в: </span>
				<a href="http://www.facebook.com/sharer.php?u=http://www.gozbite.com/разгледай-болест-'.$bolestBig['bolestID'].','.myTruncateToCyrilic($bolestBig['title'],50,'_','') .'.html&amp;t='.$bolestBig['title'].'" target="_blank"><img src="images/facebook.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;
				<a href="http://twitter.com/home?status='.myTruncateToCyrilic($bolestBig['title'],200,'_','') .', http://www.gozbite.com/разгледай-болест-'.$bolestBig['bolestID'].','.myTruncateToCyrilic($bolestBig['title'],50,'_','') .'.html" target="_blank"><img src="images/twitter.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;<a href="http://www.google.com/buzz/post" data-locale="bg" target="_blank"><img src="i/ico/google.png" border="0" alt="" title="" width="16" hspace="1" height="16" class="absmiddle" /></a>
			</div>';
			
$bolest_big .= '<div style="float:right; margin-right:2px;" >';
$bolest_big .= '<a href = "javascript://void(0);" onclick = \'window.open("includes/tools/sendStuffToFriend.php?bolestID='.$bolestBig['bolestID'].'", "sndWin", "top=0, left=0, width=440px, height=500px, resizable=yes, toolbars=no, scrollbars=yes");\' class = "smallOrange"><img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a></div>';
$bolest_big .= '<div style="float:right; margin-right:2px;" >';
$bolest_big .= '<a href = "javascript://" onclick = "window.print();"  class = "smallOrange"><img style="margin-left:5px;" src="images/print.gif" alt="Разпечатай" width="14" height="14"></a></div>';
$bolest_big .= '</div></div>';


if($bolestBig['numPics'] > 0) 
{ 
	$bolest_big .= '<br style="clear:both;"/>	
	<div class="detailsDiv" style="float:left; width:250px; margin-bottom:20px; margin-right:5px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
  		
	  		<h4>Още снимки</h4>			
				<ul id="thumbs">';
		  	
			$i=0;
			foreach ($bolestBig['resultPics']['url_thumb'] as $pics_thumb)
	   		{	
   				if(is_file('pics/bolesti/'.$pics_thumb))
			  	{ 
					$bolest_big .= '<li class="thumbDiv"><a href="pics/bolesti/'.$bolestBig['resultPics']['url_big'][$i].'"';
	           		$bolest_big .= ' class="lightview" rel="gallery[myset]"><img width="60" height="60" onclick = "$(\'#big_pic\').attr(\'src\', \'pics/bolesti/'.$bolestBig['resultPics']['url_big'][$i].'\');" src="pics/bolesti/'.$pics_thumb.'" /></a></li>';               	
								
					$i++;
			 	}		 		  	         			
	   		}
			  
	$bolest_big .= '</ul> 				
	</div>';
} 



$bolest_big .= '<div class="detailsDiv" style="float:left; width:385px; margin-bottom:20px; margin-right:0px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		
		<h4>Категории</h4>	';			
		if (count($bolestBig['Cats']) > 0) 
		{ 
			foreach ($bolestBig['Cats'] as $resultBolestiCat)
			{
		 		$bolest_big .= '&rarr; <a class="read_more_link" style="font-size:14px;" href="болести-bolest_category='.$resultBolestiCat['bolest_category_id'].',болести_категория_'.myTruncateToCyrilic($resultBolestiCat['bolest_category_name'],200,'_','').'.html" >';
				$bolest_big .= $resultBolestiCat['bolest_category_name']."</a><br />"; 	
	    	}
		}
		
			
		$bolest_big .= '<h4>Симптоми</h4>';
		                                  	
		 // ------------------------------ DETAILS LIST -------------------------------					
			if (count($bolestBig['Simptoms']) > 0) 
			{
				foreach ($bolestBig['Simptoms'] as $resultBolestiSimptom)
				{			 		
					$bolest_big .= '&rarr; <a class="read_more_link" style="font-size:14px;" href="болести-bolest_simptom='.$resultBolestiSimptom['bolest_simptom_id'].',характерен_симптом_'.myTruncateToCyrilic($resultBolestiSimptom['bolest_simptom_name'],200,'_','').'.html" >';
					$bolest_big .= $resultBolestiSimptom['bolest_simptom_name']."</a><br />"; 
		    	}
			}		
		
								
$bolest_big .= '		
</div>';



if($bolestBig['has_video'] == '1' OR !empty($bolestBig['youtube_video']))
{ 
	$video_name = $_REQUEST['bolestID'];

	$bolest_big .= '<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
	<h4>Видео Представяне</h4>';
	
	if(file_exists("../videos/bolesti/".$video_name.".flv"))
	{
	
	$bolest_big .= '	<div style = "float:left;margin: 10px 10px 10px 10px;width:500px;">
            <label><br /><br />.:: Видео Представяне ::.</label><br /><br />';
            
            	
					$video = "videos/bolesti/".$video_name.".flv";
			
			$bolest_big .= '		<br>
					
					<div id="videoDIV"  style="margin-left:0px;">
					<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
						<script language="javascript" type="text/javascript">
							var FO = {movie:"flash_flv_player/flvplayer.swf",width:"500",height:"250",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
							flashvars:"file=../videos/bolesti/'.$video_name.'.flv'.'&image=../videos/bolesti/'.$video_name.'_thumb.jpg'.'" };
							UFO.create(FO, "player1");
						</script>
					</div>
									
	   </div>';
 	} 
	elseif(!empty($bolestBig['youtube_video'])) 
	{
				  				
		$bolest_big .= '	<object type="application/x-shockwave-flash" style="width:450px; height:350px;" data="'.$bolestBig['youtube_video'].'">
			<param name="movie" value="'.$bolestBig['youtube_video'].'" />
			</object> ';
		
		
	}	
				
	$bolest_big .= '</div>';	
}


			
		$bolest_big .= '<div class="detailsDiv" style="float:left; width:650px; margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		
			<a href="javascript://void(0);)" onclick=" $('#writeComments').toggle('slow');"><h4>Коментирай</h4></a>
			
			<div id="writeComments" style="width:100%;  ">
			
			<!--
				
				 <table><tr><td align="left">
				 	 <table><tr><td colspan="2">
    				 		<input type="hidden" name="bolestID" value="'.$_REQUEST['bolestID'].'"/>
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
						<input type="image" value="Добави" src="images/btn_gren_insert.png" onclick="if('.($_SESSION['userID']?'true':'false').') { alert(\'test\');)$(\'#insert_comment_btn\').val("Добави"); return checkForCorrectComment();} else{alert("Необходимо е да влезете в системата за да направите своя коментар.");return false;} " id="insert_comment_btn" title="Добави Коментар" name="insert_comment_btn" style="border: 0pt none ; display: inline;" height="20"  width="96">
					</td></tr>
    				</table>
    			</td><td width="20">&nbsp;</td><td align="right">';
				  //require_once("inc/googleAdsense_300x250px.inc.php"); // Pokazva GoogleAdsense   
$bolest_big .= '</td></tr></table>
    		 		-->
    		 	<table><tr><td align="left" valign="top">
	    		 	<fb:comments xid="gozbite_bolest_'.$bolestBig['bolestID'].'" numbolesti="10" width="650"  send_notification_uid="1544088151"></fb:comments>
				</td>
				<td width="20">&nbsp;</td>
				<td align="right" valign="top">';
//$bolest_big .= require("includes/modules/googleAdsense_300x250px.php"); // Pokazva GoogleAdsense   
$bolest_big .= '</td></tr></table>
    		 
			</div>';
				
$bolest_big .= '			
	<!--			
			
		<h4 style="cursor:pointer; font-size:12px;" onclick=" $('#readComments').toggle('slow');  if ($(\'#readComments\').is(":visible")) {$(\'#search_div_link\').html("Покажи Коментарите ('.($numPostsComment?$numPostsComment:0).')");} else {$(\'#search_div_link\').html("Скрий Коментарите ('.($numPostsComment?$numPostsComment:0).')");}"><div id="search_div_link" class="detailsDiv">Скрий Коментарите ('.($numPostsComment?$numPostsComment:0).')</div></h4>
			
		<div id="readComments" style=" width:100%; overflow: scroll; ">
					
			Благодарим на всички за коментарите. Вашите забележки ще бъдат взети в предвид. ';
			
			if($bolestBig['numComments']>0)
	    	{
	    	    for($i=0;$i<$bolestBig['numComments'];$i++)
	    	    {
	    	
			    	    //************ Автора за всяка тема ****************
			    
	    	    	$table = 'users';
	    	    	
					$sql="SELECT CONCAT(first_name, ' ', last_name) as 'autor_name', username as 'autor_username' FROM ".$table." WHERE userID = '".$bolestBig['Comments'][$i]['autor']."' LIMIT 1";
					$conn->setsql($sql);
					$conn->getTableRow();
					$resultMneniqAvtor = $conn->result['autor_name'];
					$resultMneniqAvtorUsername = $conn->result['autor_username'];
					
					if($bolestBig['Comments'][$i]['autor'] == 1 && $bolestBig['Comments'][$i]['autor_type'] == 'user')
					{
						$resultMneniqAvtor = 'Админ';
					}
					
	    	    	if($bolestBig['Comments'][$i]['sender_name'] != '')
					{
						$resultMneniqAvtor = $bolestBig['Comments'][$i]['sender_name'];
					}
		
					if($bolestBig['Comments'][$i]['autor_type']=='user')
					{
						if(is_file("../pics/users/".$bolestBig['Comments'][$i]['autor']."_avatar.jpg")) $picFile= "pics/users/".$bolestBig['Comments'][$i]['autor']."_avatar.jpg";
					   	else $picFile = 'pics/users/no_photo_thumb.png';
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
						
			    	$sql="SELECT cnt_comment FROM users WHERE userID = '".$bolestBig['Comments'][$i]['autor']."' LIMIT 1";
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
				
		 		
			 
				 	
			$bolest_big .= '<div class="detailsDiv" style="float:left; width:620px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFF;">
				<table><tr><td valign="top">
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						<a href="users.php?userID='.$bolestBig['Comments'][$i]['autor'].'">'.$resultMneniqAvtor.'</a>
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
					<h4 style="color:#FF8400">'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($bolestBig['Comments'][$i]['created_on']))).'</h4>
				
					<div class="detailsDiv" style="float:left; width:460px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE; color:#FFFFFF;">'. stripslashes($bolestBig['Comments'][$i]['comment_body']);							
     $bolest_big .= '</div>
				</td></tr></table>
				
				<hr style="float:left;margin-top:20px;color: #eee;background-color: #eee; height:1px; border:0; width:600px;" />  
				
				<br style="clear:both;" />
			</div>';
	    	    
                	    	
	    
                } 
	    	}    	   	
	    	
		    	
	    	
		$bolest_big .= '	</div>
			
			-->		
					
</div>

</div>
<br style="clear:left;"/></div>';


return $bolest_big;

?>