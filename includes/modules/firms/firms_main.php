<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();


	   	
   	$firms_main = "";
	
   	$clauses = array();
 	$clauses['where_clause'] = '';
	$clauses['order_clause'] = ' ORDER BY RAND(), f.is_Gold DESC, f.is_Silver DESC, f.updated_on DESC';
	$clauses['limit_clause'] = ' LIMIT 1';
	$lasts = FIRMS::getItemsList($clauses);
	foreach ($lasts as $firmID => $firmInfo)
	{
		$last_item = $firmInfo;
	}
		

			
$firms_main .= '<script type="text/javascript">
					makeViewLog(\'firm\',\''.$last_item['firmID'].'\');
				</script>';
			
	
	
	
$firms_main .= '<div class="actual_theme" style="width:660px; text-align:center; color:#FF6600; font-size:16px; padding-bottom:3px; margin-bottom:0px; border-top:1px solid #CDC8B4; border-bottom:2px solid #FF6600;">	
	<h4>Актуално</h4> 
</div>

<div class="actual_theme">	
<p>
	

	
	<div id="tabs_inside" style="width:660px;">

		<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style=" font-size:14px; font-weight:bold;" href="разгледай-фирма-'.$last_item['firmID'].','.myTruncateToCyrilic($last_item['name'],200,'_','') .'.html" >'.$last_item['name'].'</a></h3>
		<br />';
				
		
				
		 if(is_file('pics/firms/'.$last_item['firmID'].'_logo.jpg')) 
		 $logoFile = 'pics/firms/'.$last_item['firmID'].'_logo.jpg'; 
		 else $logoFile = "pics/firms/no_logo.png";

 
			 	
		    list($width, $height, $type, $attr) = getimagesize($logoFile);
			$pic_width_or_height = 140;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
			if (($height) && ($width))	
			{
				if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
				else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
			}
			
			
			
			
			//------------------------------------ Other Last Posts -------------------------------------//
			 	$response = '';
		  		$response .= '<h3 style="margin: 0px 0px 10px 0px; padding-left:5px; font-size:12px;  font-weight:bold; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style="font-weight:bold;"  href="фирми-all_firms,най_добрата_сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html" >Още Заведения/Фирми</a></h3>';
		
		  	// ===================== Vzemame kategoriqta na gorniq lekar i pokazvame o6te lekari ot tazi kategoriq ==========//
			    $Firms_By_Cats = "";
		  		$ItmsRelatedByCat = getFirmIDsByCat($last_item['Cats']);	
		  		if(is_array($ItmsRelatedByCat))
			    {
			    	$ItmsRelatedByCat = array_diff($ItmsRelatedByCat, array($last_item['firmID']));			    		
			    	if(count($ItmsRelatedByCat) > 0)
				    {
				    	$Firms_By_Cats = " AND f.id IN (".implode(',',$ItmsRelatedByCat).")";
				    }
			    }	
			    // Ako nqmame lekari ot tazi kategoriq pokazvame nai-novite lekari		   
			// =============================================================================================================//
		  		$clauses['where_clause'] = " AND f.id NOT IN ('".$last_item['firmID']."') ".$Firms_By_Cats;
				$clauses['order_clause'] = ' ORDER BY f.is_Gold DESC, f.is_Silver DESC, RAND(), f.updated_on DESC';
				$clauses['limit_clause'] = ' LIMIT 3';
				$related_items = FIRMS::getItemsList($clauses);
			    
				$response .= '<table style="margin:5px;">';
					
				foreach($related_items as $Itm)
				{
				 
					 if(is_file('pics/firms/'.$Itm['firmID'].'_logo.jpg')) 
					 $logoFileRelatedPosts = 'pics/firms/'.$Itm['firmID'].'_logo.jpg'; 
					 else $logoFileRelatedPosts = "pics/firms/no_logo.png";

  				 	list($widthRelatedPosts, $heightRelatedPosts, $typeRelatedPosts, $attrRelatedPosts) = getimagesize($logoFileRelatedPosts);
					$pic_width_or_heightRelatedPosts = 50;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightRelatedPosts) && ($widthRelatedPosts))	
					{
						if($widthRelatedPosts >= $heightRelatedPosts)	{$newheighRelatedPosts = ($heightRelatedPosts/$widthRelatedPosts)*$pic_width_or_heightRelatedPosts; $newwidthRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
						else					{$newwidthRelatedPosts = ($widthRelatedPosts/$heightRelatedPosts)*$pic_width_or_heightRelatedPosts; $newheightRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
					}
				
				  
			$response .= '<tr>';
			$response .= '<td><a href="разгледай-фирма-'.$Itm['firmID'].','.myTruncateToCyrilic($Itm['name'],200,"_","").'.html" ><div  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:60px; height:60px; padding:2px;  vertical-align:middle; display:table-cell; background-color:#F9F9F9;" align="center" ><img width="'.($newwidthRelatedPosts?$newwidthRelatedPosts:50).'"  src="'.$logoFileRelatedPosts.'" /></div></a>';
			$response .= '</td>';
			$response .= '<td>';
			
			$response .= '<div class="postBig">';
			$response .= '<div class="detailsDiv" style="float:left;cursor:pointer; width:170px;margin-bottom:10px; border-top:2px solid #FF6600; padding:5px; background-color:#F1F1F1;">';
							
		    $response .= '<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-фирма-'.$Itm['firmID'].','.myTruncateToCyrilic($Itm['name'],200,"_","").'.html" style="font-size:12px; font-weight:bold;" >'.$Itm['name'].'</a></h3>';
		    $response .= '<a href="разгледай-фирма-'.$Itm['firmID'].','.myTruncateToCyrilic($Itm['name'],200,"_","").'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >';				    		
		    $response .= '&rarr; '.$Itm['Cats'][0]['firm_category_name'].' <br />'; 
			$response .= '</a>'; 
	    	$response .= '</div>'; 
	    	$response .= '</div>';
	    	
	    	$response .= '</td>';
	 		$response .= '</tr>';
			
				}
			  $response .= '</table>';
	    	 	    
			//----------------------------------------------------------------------------------------------------//
			
					
		$firms_main .= '<a href="разгледай-фирма-'.$last_item['firmID'].','.myTruncateToCyrilic($last_item['name'],200,'_','') .'.html" ><div style="float:left;"><div  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style=" margin:5px;  border:1px solid #CCCCCC; width:150px; height:150px; vertical-align:middle; display:table-cell; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:140).'"  src="'.$logoFile.'" /></div></div></a>
		<div style="float:right; width:250px; padding:5px; border-left:1px double #CDC8B4;">';
		$firms_main .= $response;
		$firms_main .= "</div>";

		$firms_main .= '<div class="detailsDiv" style="float:left; width:220px; margin-bottom:20px; margin-right:0px; margin-left:5px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		<div class="postBig">
			<h4>Детайли</h4>	
				<div>Населено място &rarr; <a class="read_more_link" target="_blank" href="http://gozbite.com/разгледай-дестинация-'.$last_item['location_id'].','.myTruncateToCyrilic(locationTracker($last_item['location_id']),200,'_','').'.html">'.locationTracker($last_item['location_id']).'</a></div>
				<div>Адрес &rarr; '.$last_item['address'].'</div>
				<div>Телефон &rarr; '.$last_item['phone'].'</div>
				<div>Е-мейл &rarr; '.$last_item['email'].'</div>
				<div>Уеб страница &rarr; '.$last_item['web'].'</div>	
			<h4>Категории</h4>';
			                                 	
			if ($last_item['numCats'] > 0)  
			{
				for ($z=0;$z<$last_item['numCats'];$z++)
				{
					$firms_main .= '<h3 align="left">&rarr; <a  class="read_more_link" href="фирми-категория-'.$last_item['Cats'][$z]['firm_category_id'] .','.myTruncateToCyrilic($last_item['Cats'][$z]['firm_category_name'],100,'_','') .'.html" >'.$last_item['Cats'][$z]['firm_category_name'] .'</a></h3>';							 		
		    	}
			}			
						
$firms_main .= '</div></div>';

$firms_main .= "<a href='разгледай-фирма-".$last_item['firmID'].",".myTruncateToCyrilic($last_item['name'],200,'_','') .".html'> <img src='images/promo_view_btn.gif' /></a>
		
		
		</div><br style='clear:left;'/>
		
	</p>	
</div>";


			
			
return $firms_main;

?>