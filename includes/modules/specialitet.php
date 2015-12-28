<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/



	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
   	$specialitet = "";

	$nomer = rand(1,2); 
	$content = ($nomer == 1) ? 'recipe' : 'drink';
	$textove['recipe'] = 'рецепта';
	$textove['drink'] = 'напитка';

	
	$sql="SELECT r.id as 'id', r.title as 'title', r.registered_on as 'registered_on', r.info as 'info', r.has_pic as 'has_pic', r.is_Silver as 'silver', r.is_Gold as 'gold', r.firm_id as 'firm_id', r.user_id as 'user_id', r.youtube_video as 'youtube_video', r.active as 'active'   FROM ".$content."s r WHERE r.active=1 AND r.is_Featured = '1' AND r.is_Featured_end > NOW() ORDER BY RAND(), r.registered_on DESC LIMIT 1";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultRecipesActual=$conn->result;
	$numRecipesActual=$conn->numberrows;
	
	if($numRecipesActual != 1)
	{
		$content = ($nomer == 1) ? 'drink': 'recipe'; //Обръюаме ги за да не остава празна секцията
		
		$sql="SELECT r.id as 'id', r.title as 'title', r.registered_on as 'registered_on', r.info as 'info', r.has_pic as 'has_pic', r.is_Silver as 'silver', r.is_Gold as 'gold', r.firm_id as 'firm_id', r.user_id as 'user_id', r.youtube_video as 'youtube_video', r.active as 'active'   FROM ".$content."s r WHERE r.active=1 AND r.is_Featured = '1' AND r.is_Featured_end > NOW() ORDER BY RAND(), r.registered_on DESC LIMIT 1";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultRecipesActual=$conn->result;
		$numRecipesActual=$conn->numberrows;
	}
	
	//------------- Pics ----------------------------------------------------
	
	$sql="SELECT * FROM ".$content."_pics WHERE ".$content."ID='".$resultRecipesActual['id']."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultPics=$conn->result;
	$numPics=$conn->numberrows;
	
	
	$sql="SELECT ".$content."_id, SUM(cnt) as 'cnt' FROM log_".$content." WHERE ".$content."_id='".$resultRecipesActual['id']."' GROUP BY ".$content."_id";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultRecipesCnt=$conn->result;
	
	
	
if($numRecipesActual > 0)
{
		
	
$specialitet .= '
	<div class="actual_theme" style="text-align:center; color:#FF6600; font-size:16px; padding-bottom:3px; margin-bottom:0px; border-top:1px solid #CDC8B4; border-bottom:2px solid #FF6600;">	
		<h4>Специалитет</h4> 
	</div>
	
	<div class="actual_theme">	
	<p>
		
	
		
		<div id="tabs_inside" style="width:660px;">
	
			<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style=" font-size:14px; font-weight:bold;" href="разгледай-'.$textove[$content].'-'.$resultRecipesActual['id'].','.myTruncateToCyrilic($resultRecipesActual['title'],50,'_','') .'.html" >'.$resultRecipesActual['title'].'</a></h3>
			<br />';
					
			
		
				if(is_file("pics/".$content."s/".$resultPics[0]['url_big'])) $picFile= "pics/".$content."s/".$resultPics[0]['url_big'];
			   	else $picFile = 'pics/'.$content.'s/no_photo_big.png';
			   	
			    list($width, $height, $type, $attr) = getimagesize($picFile);
				$pic_width_or_height = 180;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
				if (($height) && ($width))	
				{
					if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
					else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
				}
				
				
				
				
				
				//------------------------------------ Related Recipes -------------------------------------//
				 	$response = '';
			  		
				 	if($content == 'recipe') {
						$response .= '<h3 style="margin: 0px 0px 10px 0px; padding-left:5px; font-size:12px;  font-weight:bold; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style="font-weight:bold;"  href="рецепти-специалитети,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" >Още Специалитети</a></h3>';
					}
					else{
						$response .= '<h3 style="margin: 0px 0px 10px 0px; padding-left:5px; font-size:12px;  font-weight:bold; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style="font-weight:bold;"  href="напитки-специалитети,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" >Още Специалитети</a></h3>';
					}
					
				    	
					$sql="SELECT r.id as 'id', r.title as 'title', r.registered_on as 'registered_on', r.info as 'info', r.has_pic as 'has_pic', r.is_Silver as 'silver', r.is_Gold as 'gold', r.is_Promo as 'is_Promo', r.firm_id as 'firm_id', r.user_id as 'user_id', r.youtube_video as 'youtube_video', r.active as 'active'   FROM ".$content."s r WHERE r.active='1' AND r.is_Featured = '1' AND r.is_Featured_end > NOW() AND r.id NOT IN ('".$resultRecipesActual['id']."') ORDER BY r.registered_on DESC LIMIT 5";
					$conn->setsql($sql);
					$conn->getTableRows();
					$Itm  = $conn->result;	
					$numItms = $conn->numberrows;
				
					for($i=0;$i<$numItms;$i++)
					{
						//------------- Pics ----------------------------------------------------
												
						if ($Itm[$i]['has_pic']=='1')
						{
							$sql="SELECT * FROM ".$content."_pics WHERE ".$content."ID='".$Itm[$i]['id']."'";
							$conn->setsql($sql);
							$conn->getTableRows();
							$resultPicsMain2[$i]=$conn->result;
							$numPicsMain2[$i]=$conn->numberrows;
						}
						
							if(is_file('pics/'.$content.'s/'.$resultPicsMain2[$i][0]['url_thumb'])) 
							{
								$picFileRelatedRecipes= 'pics/'.$content.'s/'.$resultPicsMain2[$i][0]['url_thumb'];
								$picFileRelatedRecipes =  "image.php?i=".$picFileRelatedRecipes."&fh=&fv=&ed=&gr=&rw=140&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5";
							}
				   			else 
				   			{
				   				$picFileRelatedRecipes = 'pics/'.$content.'s/no_photo_thumb.png';
				   			}
				   			  			 		 
						 	list($widthRelatedRecipes, $heightRelatedRecipes, $typeRelatedRecipes, $attrRelatedRecipes) = getimagesize($picFileRelatedRecipes);
							$pic_width_or_heightRelatedRecipes = 50;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
							if (($heightRelatedRecipes) && ($widthRelatedRecipes))	
							{
								if($widthRelatedRecipes >= $heightRelatedRecipes)	{$newheighRelatedRecipes = ($heightRelatedRecipes/$widthRelatedRecipes)*$pic_width_or_heightRelatedRecipes; $newwidthRelatedRecipes	=	$pic_width_or_heightRelatedRecipes;	}
								else					{$newwidthRelatedRecipes = ($widthRelatedRecipes/$heightRelatedRecipes)*$pic_width_or_heightRelatedRecipes; $newheightRelatedRecipes	=	$pic_width_or_heightRelatedRecipes;	}
							}
					
					   $response .=	'<div style="width:270px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-'.$textove[$content].'-'.$Itm[$i]['id'].','.myTruncateToCyrilic($Itm[$i]['title'],50,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\'; document.getElementById(\'locationImgDiv_'.$Itm[$i]['id'].'\').style.borderColor=\'#0099FF\';" onMouseout="this.style.backgroundColor=\'transparent\';  document.getElementById(\'locationImgDiv_'.$Itm[$i]['id'].'\').style.borderColor=\'#CCCCCC\';">';
					   $response .= '<table><tr>';
					   $response .= '<td valign="top">';
					   $response .= '<a href="разгледай-'.$textove[$content].'-'.$Itm[$i]['id'].','.myTruncateToCyrilic($Itm[$i]['title'],200,"_","").'.html" ><div id="locationImgDiv_'.$Itm[$i]['id'].'" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:60px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidthRelatedRecipes?$newwidthRelatedRecipes:50).'"  src="'.$picFileRelatedRecipes.'" /></div></a>';
					   $response .= '</td><td valign="top"><div style="margin-left:5px; width:220px;" ><a href="разгледай-'.$textove[$content].'-'.$Itm[$i]['id'].','.myTruncateToCyrilic($Itm[$i]['title'],50,"_","").'.html" style="color:#666666;">'.$Itm[$i]['title'].'</a></div>';
					   $response .= '</td></tr></table>';	            
					   $response .= '</div>';
						
					  
					}
				   	    
				//----------------------------------------------------------------------------------------------------//
				
				
$specialitet .= '<a href="разгледай-'.$textove[$content].'-'.$resultRecipesActual['id'].','.myTruncateToCyrilic($resultRecipesActual['title'],200,'_','') .'.html" ><div  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="float:left; margin:5px;  border:1px solid #CCCCCC; width:190px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:180).'"  src="'.$picFile.'" /></div></a>
			<div style="float:right; width:280px; padding:5px; border-left:1px double #CDC8B4;">'.$response.'</div>
			'.strip_tags(myTruncate($resultRecipesActual['info'], 2000, " ", " ... "),'<br><br /><a>').'
			<a href=\'разгледай-'.$textove[$content].'-'.$resultRecipesActual['id'].','.myTruncateToCyrilic($resultRecipesActual['title'],200,"_","") .'.html\'> <img src=\'images/promo_view_btn.gif\' /></a>
			
			
			
					
			</div><br style="clear:left;"/>
			
					
			
		</p>	
	</div>';
	

}



return $specialitet;
?>
