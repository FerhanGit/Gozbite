<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/



	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
   	$theme_of_week = "";
	
	
   	
	//++++++++++++++++++++++++++++++++++++++++ Theme Of The Week +++++++++++++++++++++++++++++++++++++++++//
	
		$sql="SELECT * FROM theme_of_week WHERE active=1 LIMIT 1";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultThemeOfWeek=$conn->result;
		
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

   	if(count($resultThemeOfWeek) > 0) 
   	{
   		$theme_of_week .= '<div class="actual_theme" style="text-align:center; color:#FF6600; font-size:16px; padding-bottom:3px; margin-bottom:0px; border-top:1px solid #CDC8B4; border-bottom:2px solid #FF6600;">	
	<h4>Тема на Седмицата</h4> 
</div>

<div class="actual_theme">	
<p>
	

	
	<div id="tabs_inside" style="width:660px;">

		<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style=" font-size:14px; font-weight:bold;" href="разгледай-тема-на-седмицата-'.$resultThemeOfWeek['themeID'].',актуални_статии_за_здравето_'.$resultThemeOfWeek['theme_title'].'.html" >'.$resultThemeOfWeek['theme_title'].'</a></h3>
		<br />';
		
		if($_SESSION['user_kind'] == 2) {
			$theme_of_week .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-тема-на-седмицата-'.$resultThemeOfWeek['themeID'].',актуални_статии_за_здравето.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>
		
			<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-тема-на-седмицата-'.$resultThemeOfWeek['themeID'].',актуални_статии_за_здравето.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
		}
		
		$theme_of_week .= '<table><tr>';
		 
			if(is_file("pics/theme_of_week/".$resultThemeOfWeek['picURL'])) $picFile= "pics/theme_of_week/".$resultThemeOfWeek['picURL'];
		   	else $picFile = 'pics/theme_of_week/no_photo_big.png';
		   	
		    list($width, $height, $type, $attr) = getimagesize($picFile);
			$pic_width_or_height = 180;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
			if (($height) && ($width))	
			{
				if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
				else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
			}
			
			
			
			
			//------------------------------------ Related Posts -------------------------------------//
			 	$response = '';
		  		$response .= '<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px;  font-weight:bold; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style="font-weight:bold;"  href="javascript:void();" >Свързани Статии</a></h3>';
		
			    	
				$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category = pc.id  AND p.active = '1' AND p.postID IN (SELECT post_id FROM theme_of_week_posts WHERE theme_id = '".$resultThemeOfWeek['themeID']."') ORDER BY RAND() LIMIT 3";
				$conn->setsql($sql);
				$conn->getTableRows();
				$Itm  = $conn->result;	
				$numItms = $conn->numberrows;
			
				for($i=0;$i<$numItms;$i++)
				{
				   if(is_file('pics/posts/'.$Itm[$i]['picURL'])) $picFileRelatedPosts= 'pics/posts/'.$Itm[$i]['picURL'];
				   else $picFileRelatedPosts = 'pics/posts/no_photo_thumb.png';
				   		 
				 	list($widthRelatedPosts, $heightRelatedPosts, $typeRelatedPosts, $attrRelatedPosts) = getimagesize($picFileRelatedPosts);
					$pic_width_or_heightRelatedPosts = 50;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightRelatedPosts) && ($widthRelatedPosts))	
					{
						if($widthRelatedPosts >= $heightRelatedPosts)	{$newheighRelatedPosts = ($heightRelatedPosts/$widthRelatedPosts)*$pic_width_or_heightRelatedPosts; $newwidthRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
						else					{$newwidthRelatedPosts = ($widthRelatedPosts/$heightRelatedPosts)*$pic_width_or_heightRelatedPosts; $newheightRelatedPosts	=	$pic_width_or_heightRelatedPosts;	}
					}
				
				   $response .=	'<div style="width:280px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'прочети-статия-'.$Itm[$i]['postID'].','.myTruncateToCyrilic($Itm[$i]['title'],50,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\'; document.getElementById(\'postImgDiv_'.$Itm[$i]['postID'].'\').style.borderColor=\'#0099FF\';" onMouseout="this.style.backgroundColor=\'transparent\';  document.getElementById(\'postImgDiv_'.$Itm[$i]['postID'].'\').style.borderColor=\'#CCCCCC\';">';
				   $response .= '<table><tr>';
				   $response .= '<td valign="top">';
				   $response .= '<a href="прочети-статия-'.$Itm[$i]['postID'].','.myTruncateToCyrilic($Itm[$i]['title'],50,"_","").'.html" ><div id="postImgDiv_'.$Itm[$i]['postID'].'" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:60px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidthRelatedPosts?$newwidthRelatedPosts:50).'"  src="'.$picFileRelatedPosts.'" /></div></a>';
				   $response .= '</td><td valign="top"><div style="margin-left:5px; width:210px;" ><a href="прочети-статия-'.$Itm[$i]['postID'].','.myTruncateToCyrilic($Itm[$i]['title'],50,"_","").'.html" style="color:#666666;" >'.myTruncate($Itm[$i]['title'], 90, " ").'</a></div>';
				   $response .= '</td></tr></table>';	            
				   $response .= '</div>';
				}
			   	    
			//----------------------------------------------------------------------------------------------------//
			
				
			//=========================================== Related Bolesti =========================================//
				
				$response .= '<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px;  font-weight:bold; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a style="font-weight:bold;" href="javascript:void();" >Свързани Заболявания</a></h3>';
					
				$sql="SELECT b.bolestID as 'bolestID', b.date as 'date', b.title as 'title', b.body as 'body', b.has_pic as 'has_pic', b.autor_type as 'autor_type', b.autor as 'autor', b.source as 'source' FROM bolesti b WHERE 1=1 AND b.active = '1' AND b.bolestID IN (SELECT bolest_id FROM theme_of_week_bolesti WHERE theme_id = '".$resultThemeOfWeek['themeID']."')  ORDER BY RAND() LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$Itm  = $conn->result;	
				$numItms = $conn->numberrows;
			
				   			 
		   			 
				for($i=0;$i<$numItms;$i++)
				{
					// ============================= CATEGORIES =========================================
			
					$sql="SELECT bc.id as 'bolest_category_id', bc.name as 'bolest_category_name' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND b.active = '1' AND b.bolestID = '".$Itm[$i]['bolestID']."' ";
					$conn->setsql($sql);
					$conn->getTableRows();
					$numBolestBigCats[$i]  		= $conn->numberrows;
					$resultBolestBigCats[$i] 	= $conn->result;
				
					
					if ($Itm[$i]['has_pic']=='1')
					{
						$sql="SELECT * FROM bolesti_pics WHERE bolestID='".$Itm[$i]['bolestID']."'";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultPicsMain2[$i]=$conn->result;
						$numPicsMain2[$i]=$conn->numberrows;
					}
					
					 if(is_file('pics/bolesti/'.$resultPicsMain2[$i][0]['url_thumb'])) $picFileRelatedBolesti= 'pics/bolesti/'.$resultPicsMain2[$i][0]['url_thumb'];
		   			 else $picFileRelatedBolesti = 'pics/bolesti/no_photo_thumb.png';
		   			 $picFileRelatedBolesti =  "image.php?i=".$picFileRelatedBolesti."&fh=&fv=&ed=&gr=&rw=140&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5";
			   			  			 		 
				 	list($widthRelatedBolesti, $heightRelatedBolesti, $typeRelatedBolesti, $attrRelatedBolesti) = getimagesize($picFileRelatedBolesti);
					$pic_width_or_heightRelatedBolesti = 50;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightRelatedBolesti) && ($widthRelatedBolesti))	
					{
						if($widthRelatedBolesti >= $heightRelatedBolesti)	{$newheighRelatedBolesti = ($heightRelatedBolesti/$widthRelatedBolesti)*$pic_width_or_heightRelatedBolesti; $newwidthRelatedBolesti	=	$pic_width_or_heightRelatedBolesti;	}
						else					{$newwidthRelatedBolesti = ($widthRelatedBolesti/$heightRelatedBolesti)*$pic_width_or_heightRelatedBolesti; $newheightRelatedBolesti	=	$pic_width_or_heightRelatedBolesti;	}
					}
				
				   $response .=	'<div style="width:280px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-болест-'.$Itm[$i]['bolestID'].','.myTruncateToCyrilic($Itm[$i]['title'],50,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\'; document.getElementById(\'bolestImgDiv_'.$Itm[$i]['bolestID'].'\').style.borderColor=\'#0099FF\';" onMouseout="this.style.backgroundColor=\'transparent\';  document.getElementById(\'bolestImgDiv_'.$Itm[$i]['bolestID'].'\').style.borderColor=\'#CCCCCC\';">';
				   $response .= '<table><tr>';
				   $response .= '<td valign="top">';
				   $response .= '<a href="разгледай-болест-'.$Itm[$i]['bolestID'].','.myTruncateToCyrilic($Itm[$i]['title'],50,"_","").'.html" ><div id="bolestImgDiv_'.$Itm[$i]['bolestID'].'" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:60px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidthRelatedBolesti?$newwidthRelatedBolesti:50).'"  src="'.$picFileRelatedBolesti.'" /></div></a>';
				   $response .= '</td><td valign="top"><div style="margin-left:5px; width:210px;" ><a href="разгледай-болест-'.$Itm[$i]['bolestID'].','.myTruncateToCyrilic($Itm[$i]['title'],50,"_","").'.html"  style="color:#666666;">'.myTruncate($Itm[$i]['title'], 90, " ").'</a></div>';
				   $response .= '</td></tr></table>';	            
				   $response .= '</div>';
				}
			   	    
			//=====================================================================================================//
		
			
					
					
		$theme_of_week .= '<td valign="top" style="width:380px;"><a href="разгледай-тема-на-седмицата-'.$resultThemeOfWeek['themeID'].',актуални_статии_за_здравето_'.$resultThemeOfWeek['theme_title'].'.html" ><div  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="float:left; margin:5px;  border:1px solid #CCCCCC; width:190px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:180).'"  src="'.$picFile.'" /></div></a>
		<p>'.myTruncate($resultThemeOfWeek['theme_body'], 1200, " ", " ... ").'<a href=\'разгледай-тема-на-седмицата-'.$resultThemeOfWeek['themeID'].',актуални_статии_за_здравето_'.$resultThemeOfWeek['theme_title'].'.html\'> <img src=\'images/promo_view_btn.gif\' /></a></p>
		</td>
		<td valign="top" style="width:280px; padding:5px; border-left:1px double #CDC8B4;">'.$response.'</td>
		
		</tr></table>
		
		</div><br style="clear:left;"/>
		
		
		
	</p>	
</div>';
   	}
   	
		
	return $theme_of_week;
	  
	?>
