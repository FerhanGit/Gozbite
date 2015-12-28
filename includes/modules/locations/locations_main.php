<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();


	   	
   	$locations_main = "";
	
   	$clauses = array();
 	$clauses['where_clause'] = ' AND (LENGTH(l.info)>10 OR l.id IN (SELECT locationID FROM location_pics))';
	$clauses['order_clause'] = ' ORDER BY RAND()';
	$clauses['limit_clause'] = ' LIMIT 1';
	$lasts = LOCATIONS::getItemsList($clauses);
	foreach ($lasts as $locationID => $locationInfo)
	{
		$last_item = $locationInfo;
	}
		
//	$locations_main .= print_r($last_item,1);
			
$locations_main .= '<script type="text/javascript">
					makeViewLog(\'location\',\''.$last_item['locationID'].'\');
				</script>';
			
	
	
$locations_main .= '<div class="detailsDivMap" style="width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<div id="myMap" style="width: 660px; height: 290px;"></div>';
					 $locations_main .= require("mapLocations.php");
$locations_main .= '</div><br style="clear:left;"/>';
	
$locations_main .= '<div class="actual_theme" style="width:660px; text-align:center; color:#FF6600; font-size:16px; padding-bottom:3px; margin-bottom:0px; border-top:1px solid #CDC8B4; border-bottom:2px solid #FF6600;">	
	<h4>Препоръчана Дестинация</h4> 
</div>

<div class="actual_theme">	
<p>
	

	
	<div id="tabs_inside" style="width:660px;">

		<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style=" font-size:14px; font-weight:bold;" href="разгледай-дестинация-'.$last_item['locationID'].','.myTruncateToCyrilic($last_item['locType']." ".$last_item['location_name'],200,'_','') .'.html" >'.$last_item['locType']." ".$last_item['location_name'].'</a></h3>
		<br />';
				
		
				
		 
 			if(is_file("pics/locations/".$last_item['resultPics']['url_big'][0])) $picFile= "pics/locations/".$last_item['resultPics']['url_big'][0];
		   	else $picFile = 'pics/locations/no_photo_big.png';
		  
		   	
			 	
		    list($width, $height, $type, $attr) = getimagesize($picFile);
			$pic_width_or_height = 140;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
			if (($height) && ($width))	
			{
				if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
				else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
			}
			
			
			
			
			//------------------------------------ Other Last Posts -------------------------------------//
			 	$response = '';
		  		$response .= '<h3 style="margin: 0px 0px 10px 0px; padding-left:5px; font-size:12px;  font-weight:bold; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style="font-weight:bold;"  href="дестинации-,населени_места_дестинации_курорти_градове_села.html" >Още Дестинации</a></h3>';
		
		  	   
			// =============================================================================================================//
				$clauses['where_clause'] = " AND (LENGTH(l.info)>10 OR l.id IN (SELECT locationID FROM location_pics)) AND l.id NOT IN ('".$last_item['locationID']."')";
				$clauses['order_clause'] = ' ORDER BY RAND()';
				$clauses['limit_clause'] = ' LIMIT 5';
				$related_items = $this->getItemsList($clauses);

				$response .= '<table style="margin:5px;">';
					
				foreach($related_items as $Itm)
				{
					
					if(is_file('pics/locations/'.$Itm['resultPics']['url_thumb'][0])) $picFileRelatedPosts= 'pics/locations/'.$Itm['resultPics']['url_thumb'][0];
				    else $picFileRelatedPosts = 'pics/locations/no_photo_thumb.png';
				 
				   
  				 	list($widthRelatedPosts, $heightRelatedPosts, $typeRelatedPosts, $attrRelatedPosts) = getimagesize($picFileRelatedPosts);
					$pic_width_or_heightRelatedPosts = 50;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightRelatedPosts) && ($widthRelatedPosts))	
					{
						if($widthRelatedPosts >= $heightRelatedPosts)	{$newheighRelatedPosts = ($heightRelatedPosts/$widthRelatedPosts)*$pic_width_or_heightRelatedPosts; $newwidthRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
						else					{$newwidthRelatedPosts = ($widthRelatedPosts/$heightRelatedPosts)*$pic_width_or_heightRelatedPosts; $newheightRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
					}
				
				  
					$response .= '<tr>';
					$response .= '<td><a href="разгледай-дестинация-'.$Itm['locationID'].','.myTruncateToCyrilic($Itm['locType']." ".$Itm['location_name'],200,"_","").'.html" ><div  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:60px; height:60px; padding:2px;  vertical-align:middle; display:table-cell; background-color:#F9F9F9;" align="center" ><img width="'.($newwidthRelatedPosts?$newwidthRelatedPosts:50).'"  src="'.$picFileRelatedPosts.'" /></div></a>';
					$response .= '</td>';
					$response .= '<td>';
					
					$response .= '<div class="postBig">';
					$response .= '<div class="detailsDiv" style="float:left;cursor:pointer; width:170px;margin-bottom:10px; border-top:2px solid #FF6600; padding:5px; background-color:#F1F1F1;">';
									
				    $response .= '<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-дестинация-'.$Itm['locationID'].','.myTruncateToCyrilic($Itm['locType']." ".$Itm['location_name'],200,"_","").'.html" style="font-size:12px; font-weight:bold;" >'.$Itm['locType']." ".$Itm['location_name'].'</a></h3>';
				    $response .= '<a href="разгледай-дестинация-'.$Itm['locationID'].','.myTruncateToCyrilic($Itm['locType']." ".$Itm['location_name'],200,"_","").'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >';				    		
				    $response .= '</a>'; 
			    	$response .= '</div>'; 
			    	$response .= '</div>';
			    	
			    	$response .= '</td>';
			 		$response .= '</tr>';
					
				}
			  $response .= '</table>';
	    	 	    
			//----------------------------------------------------------------------------------------------------//
			
					
		$locations_main .= '<a href="разгледай-дестинация-'.$last_item['locationID'].','.myTruncateToCyrilic($last_item['locType']." ".$last_item['location_name'],200,'_','') .'.html" ><div style="float:left;"><div  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style=" margin:5px;  border:1px solid #CCCCCC; width:150px; height:150px; vertical-align:middle; display:table-cell; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:140).'"  src="'.$picFile.'" /></div></div></a>
		<div style="float:right; width:250px; padding:5px; border-left:1px double #CDC8B4;">';
		$locations_main .= $response;
		$locations_main .= "</div>";

	
		$locations_main .= insertADV(strip_tags(myTruncate($last_item['info'], 2000, " ", " ... "),'<br><br /><a>'));
					

$locations_main .= "<a href='разгледай-дестинация-".$last_item['locationID'].",".myTruncateToCyrilic($last_item['locType']." ".$last_item['location_name'],200,'_','') .".html'> <img src='images/promo_view_btn.gif' /></a>
		
		
		</div><br style='clear:left;'/>";

$locations_main .= '<h4 style="clear:left; margin: 10px 0px 0px 0px; padding-left:5px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;">
		
	<a style=" font-size:14px; font-weight:bold;" href="фирми-cityName='.$last_item['locationID'].',заведения_ресторанти_механи_барове_пицарии_търговци_Фирми_от_'.myTruncateToCyrilic($last_item['locType']." ".$last_item['location_name'],200,"_","").'.html">Заведения/Фирми от '.$last_item['locType']." ".$last_item['location_name'].'</a>
</h4>';
	
$locations_main .= "
	</p>	
</div>";


			
			
return $locations_main;

?>