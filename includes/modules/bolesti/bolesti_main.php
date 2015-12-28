<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();


	   	
   	$bolesti_main = "";
	
   	$clauses = array();
 	$clauses['where_clause'] = '';
	$clauses['order_clause'] = ' ORDER BY IF(RAND()<0.5,b.date,RAND()) DESC';
	$clauses['limit_clause'] = ' LIMIT 1';
	$lasts = $this->getItemsList($clauses);
	foreach ($lasts as $bolestID => $bolestInfo)
	{
		$last_item = $bolestInfo;
	}
			
$bolesti_main .=  '<script type="text/javascript">
						makeViewLog(\'bolest\',\''.$last_item['bolestID'].'\');
					</script>';	
	
$bolesti_main .= '<div class="actual_theme" style="text-align:center; color:#FF6600; font-size:16px; padding-bottom:3px; margin-bottom:0px; border-top:1px solid #CDC8B4; border-bottom:2px solid #FF6600;">	
	<h4>Актуално</h4> 
</div>

<div class="actual_theme">	
<p>
	

	
	<div id="tabs_inside" style="width:660px;">

		<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style=" font-size:14px; font-weight:bold;" href="разгледай-болест-'.$last_item['bolestID'].','.myTruncateToCyrilic($last_item['title'],50,'_','') .'.html" >'.$last_item['title'].'</a></h3>
		<br />';
				
		
	  
			if(is_file("pics/bolesti/".$last_item['resultPics']['url_big'][0])) $picFile= "pics/bolesti/".$last_item['resultPics']['url_big'][0];
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
		  		$response .= '<h3 style="margin: 0px 0px 10px 0px; padding-left:5px; font-size:12px;  font-weight:bold; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style="font-weight:bold;"  href="болести-all_bolesti,още_симптоми_лечение_и_описания_на_заболявания.html" >Още Описания на Заболявания</a></h3>';
		
			    	
		  		$clauses['where_clause'] = " AND b.bolestID NOT IN ('".$last_item['bolestID']."')";
				$clauses['order_clause'] = ' ORDER BY IF(RAND()<0.5,b.date,RAND()) DESC';
				$clauses['limit_clause'] = ' LIMIT 5';
				$related_items = $this->getItemsList($clauses);
	
					
				foreach($related_items as $Itm)
				{
				   if(is_file('pics/bolesti/'.$Itm['resultPics']['url_thumb'][0])) $picFileRelatedPosts= 'pics/bolesti/'.$Itm['resultPics']['url_thumb'][0];
				   else $picFileRelatedPosts = 'pics/bolesti/no_photo_thumb.png';
				   		 
				 	list($widthRelatedPosts, $heightRelatedPosts, $typeRelatedPosts, $attrRelatedPosts) = getimagesize($picFileRelatedPosts);
					$pic_width_or_heightRelatedPosts = 50;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightRelatedPosts) && ($widthRelatedPosts))	
					{
						if($widthRelatedPosts >= $heightRelatedPosts)	{$newheighRelatedPosts = ($heightRelatedPosts/$widthRelatedPosts)*$pic_width_or_heightRelatedPosts; $newwidthRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
						else					{$newwidthRelatedPosts = ($widthRelatedPosts/$heightRelatedPosts)*$pic_width_or_heightRelatedPosts; $newheightRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
					}
				
				   $response .=	'<div style="width:250px;font-size:12px;font-family: "Trebuchet MS", Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-болест-'.$Itm['bolestID'].','.myTruncateToCyrilic($Itm['title'],50,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\'; document.getElementById(\'postImgDiv_'.$Itm['bolestID'].'\').style.borderColor=\'#0099FF\';" onMouseout="this.style.backgroundColor=\'transparent\';  document.getElementById(\'postImgDiv_'.$Itm['bolestID'].'\').style.borderColor=\'#CCCCCC\';">';
				   $response .= '<table><tr>';
				   $response .= '<td valign="top">';
				   $response .= '<a href="разгледай-болест-'.$Itm['bolestID'].','.myTruncateToCyrilic($Itm['title'],50,"_","").'.html" ><div id="postImgDiv_'.$Itm['bolestID'].'" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:60px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidthRelatedPosts?$newwidthRelatedPosts:50).'"  src="'.$picFileRelatedPosts.'" /></div></a>';
				   $response .= '</td><td valign="top"><div style="margin-left:5px; width:180px;" ><a href="разгледай-болест-'.$Itm['bolestID'].','.myTruncateToCyrilic($Itm['title'],50,"_","").'.html" style="color:#666666;" >'.myTruncate($Itm['title'], 90, " ").'</a></div>';
				   $response .= '</td></tr></table>';	            
				   $response .= '</div>';
				}
			   	    
			//----------------------------------------------------------------------------------------------------//
			
			
		
		
			
					
		$bolesti_main .= '<a href="разгледай-болест-'.$last_item['bolestID'].','.myTruncateToCyrilic($last_item['title'],50,'_','') .'.html" ><div  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="float:left; margin:5px;  border:1px solid #CCCCCC; width:190px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:180).'"  src="'.$picFile.'" /></div></a>
		<div style="float:right; width:250px; padding:5px; border-left:1px double #CDC8B4;">';
		$bolesti_main .= $response;
		$bolesti_main .= "</div>".strip_tags(myTruncate($last_item['body'], 2000, ' ', ' ... '),'<br><br /><a><p><b><strong>')."<a href='разгледай-болест-".$last_item['bolestID'].",".myTruncateToCyrilic($last_item['title'],50,'_','') .".html'> <img src='images/promo_view_btn.gif' /></a>
		
		
		</div><br style='clear:left;'/>
		
		
		
	</p>	
</div>";
		        
		        
	    
	return $bolesti_main;
	  
	?>
