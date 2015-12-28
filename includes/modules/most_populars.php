<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/



	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
   	
   	
	$most_populars = "";
	$most_populars .= '<div class="post">
						<p>
						<script type="text/javascript">


var countSlide = 0;
function autoUpdateSlideMain()
{
	
	var typeContentArr = new Array(5);
	typeContentArr[0]="#postsContent";
	typeContentArr[1]="#recipesContent";
	typeContentArr[2]="#drinksContent";
	typeContentArr[3]="#firmsContent";
	typeContentArr[4]="#guidesContent";  
	
	var typeBoxArr = new Array(5);
	typeBoxArr[0]="#postsBox";
	typeBoxArr[1]="#recipesBox";
	typeBoxArr[2]="#drinksBox";
	typeBoxArr[3]="#firmsBox";
	typeBoxArr[4]="#guidesBox"; 
	
	
	jQuery(".hbox_ajax a").removeClass("active");
	jQuery(typeBoxArr[countSlide]).addClass("active");
	jQuery(".ContBox").hide(); 
	jQuery(typeContentArr[countSlide]).show("slow");
	
	
		
	countSlide++; 
	if(countSlide == 5) {countSlide = 0;}
	
}

jQuery(document).ready(function($) {
 	
	jQuery("#postsBox").click(function() { window.clearInterval(t2); t2=window.setInterval("autoUpdateSlideMain()", 20000);  countSlide = 1; jQuery(".hbox_ajax a").removeClass("active");
	jQuery("#postsBox").addClass("active"); jQuery("div.ContBox").hide(); jQuery("#postsContent").show("slow"); return false;});
	
	jQuery("#recipesBox").click(function() { window.clearInterval(t2); t2=window.setInterval("autoUpdateSlideMain()", 20000);  countSlide = 2; jQuery(".hbox_ajax a").removeClass("active");
	jQuery("#recipesBox").addClass("active"); jQuery("div.ContBox").hide(); jQuery("#recipesContent").show("slow"); return false;});
	
	jQuery("#drinksBox").click(function() { window.clearInterval(t2); t2=window.setInterval("autoUpdateSlideMain()", 20000);  countSlide = 3; jQuery(".hbox_ajax a").removeClass("active");
	jQuery("#drinksBox").addClass("active"); jQuery("div.ContBox").hide(); jQuery("#drinksContent").show("slow"); return false;});
	
	jQuery("#firmsBox").click(function() { window.clearInterval(t2); t2=window.setInterval("autoUpdateSlideMain()", 20000);  countSlide = 4; jQuery(".hbox_ajax a").removeClass("active");
	jQuery("#firmsBox").addClass("active"); jQuery("div.ContBox").hide(); jQuery("#firmsContent").show("slow"); return false;});
	
	jQuery("#guidesBox").click(function() { window.clearInterval(t2); t2=window.setInterval("autoUpdateSlideMain()", 20000);  countSlide =0; jQuery(".hbox_ajax a").removeClass("active");
	jQuery("#guidesBox").addClass("active"); jQuery("div.ContBox").hide(); jQuery("#guidesContent").show("slow"); return false;});
	
		
	t2=window.setInterval("autoUpdateSlideMain()", 20000);
	autoUpdateSlideMain();
	
});
		
</script>



<div class="postBig">
<h4>
<div class="hbox hbox_ajax"> 
<div> 
	<div> 
		<h1> 
			<a href="#" id="postsBox"  class="active">Статии<!--<span>»</span>--></a> <span>&nbsp;</span> 
			<a href="#" id="recipesBox">Рецепти<!--<span>»</span>--></a> <span>&nbsp;</span> 
			<a href="#" id="drinksBox">Напитки<!--<span>»</span>--></a> <span>&nbsp;</span> 
			<a href="#" id="firmsBox" >Заведения/Фирми<!--<span>»</span>--></a> <span>&nbsp;</span> 
			<a href="#" id="guidesBox">Справочник<!--<span>»</span>--></a>
		</h1> 												
	</div> 
</div> 
</div> 
</h4>		




<div class="detailsDiv" style="float:left; width:660px;margin-bottom:10px; border-top:3px solid #0099FF;  padding-top:0px; background-color:#FFF; min-height:150px;">
	<div class="detailsDiv" style="float:left; width:650px; color:#FFFFFF; font-weight:bold; margin-bottom:5px; padding:5px; padding-top:0px; background-color:#39C6EE;">
		
		<div id="postsContent" class="ContBox">		
			<table style="width:650px;">	
			<tr align="center"><td width="50%"><u>Популярни</u></td><td><u>Нови</u></td></tr>';
			
			
				//$sql="SELECT p.postID as 'postID', SUM(lp.cnt) as 'cnt', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc, log_post lp WHERE p.post_category=pc.id AND lp.post_id=p.postID GROUP BY p.postID ORDER BY cnt DESC LIMIT 3 ";
				$sql="SELECT p.postID as 'postID',p.rating/p.times_rated as 'rating_average', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id  AND p.active = '1'  AND (NOW() BETWEEN date AND (date + INTERVAL 48 MONTH )) ORDER BY p.rating DESC, p.times_rated  DESC LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultPostsPopular = $conn->result;
				$numPostsPopular = $conn->numberrows;
				
				$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id AND p.active = '1' GROUP BY p.postID ORDER BY date DESC LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultPostsLast = $conn->result;
				$numPostsLast = $conn->numberrows;
				
								
				for($n=0; $n<3; $n++)
				{
					if(is_file('pics/posts/'.$resultPostsPopular[$n]['picURL'])) $picFilePopular[$n]= 'pics/posts/'.$resultPostsPopular[$n]['picURL'];
					else $picFilePopular[$n] = 'pics/posts/no_photo_thumb.png';
					
					list($widthPopular, $heightPopular, $type, $attr) = getimagesize($picFilePopular[$n]);
					$pic_width_or_heightPopular = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightPopular) && ($widthPopular))	
					{
						if($widthPopular >= $heightPopular)	{$newheightPopular = ($heightPopular/$widthPopular)*$pic_width_or_heightPopular; $newwidthPopular	=	$pic_width_or_heightPopular;	}
						else					{$newwidthPopular = ($widthPopular/$heightPopular)*$pic_width_or_heightPopular; $newheightPopular	=	$pic_width_or_heightPopular;	}
					}
					
					
					if(is_file('pics/posts/'.$resultPostsLast[$n]['picURL'])) $picFileLast[$n]= 'pics/posts/'.$resultPostsLast[$n]['picURL'];
					else $picFileLast[$n] = 'pics/posts/no_photo_thumb.png';
					
					list($widthLast, $heightLast, $type, $attr) = getimagesize($picFileLast[$n]);
					$pic_width_or_heightLast = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightLast) && ($widthLast))	
					{
						if($widthLast >= $heightLast)	{$newheightLast = ($heightLast/$widthLast)*$pic_width_or_heightLast; $newwidthLast	=	$pic_width_or_heightLast;	}
						else					{$newwidthLast = ($widthLast/$heightLast)*$pic_width_or_heightLast; $newheightLast	=	$pic_width_or_heightLast;	}
					}
					
					
	   	   			$linkPopular = "прочети-статия-".$resultPostsPopular[$n]['postID'].",".myTruncateToCyrilic($resultPostsPopular[$n]['title'],200,' ','').".html";
					$linkLast = "прочети-статия-".$resultPostsLast[$n]['postID'].",".myTruncateToCyrilic($resultPostsLast[$n]['title'],200,' ','').".html";
					$textLinkPopular[$n] = "<span id='rarrPopular_".$n."' style='color:#FF6600;'>&rarr;</span>&nbsp;<a onMouseover=\"jQuery('#postSRCPopular').attr('src', '".$picFilePopular[$n]."'); jQuery('#postSRCPopular_link').href='".$linkPopular."';  jQuery('#rarrPopular_".$n."').css('color', '#FFFFFF'); \" onMouseout=\" jQuery('#rarrPopular_".$n."').css('color', '#FF6600'); \" href='".$linkPopular."'>".$resultPostsPopular[$n]['title']."</a>";
					$textLinkLast[$n] = "<span  id='rarrLast_".$n."' style='color:#FF6600;'>&rarr;</span>&nbsp;<a onMouseover=\"jQuery('#postSRCLast').attr('src', '".$picFileLast[$n]."'); jQuery('#postSRCLast_link').href='".$linkPopular."'; jQuery('#rarrLast_".$n."').css('color', '#FFFFFF'); \" onMouseout=\" jQuery('#rarrLast_".$n."').css('color', '#FF6600'); \"  href='".$linkLast."'>".$resultPostsLast[$n]['title']."</a>";
				
				}	
				
				
				
				$most_populars .= '<tr>
					<td>
						<table><tr>
								<td><div align="center" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:84px; height:84px; padding:2px; background-color:#F9F9F9; display:table-cell; vertical-align:middle" ><a id="postSRCPopular_link"  href="прочети-статия-'.$resultPostsPopular[0]['postID'].','.myTruncateToCyrilic($resultPostsPopular[0]['title'],200,'_','') .'.html"><img id="postSRCPopular" width="'.($newwidthPopular?$newwidthPopular:80).'" src="'.$picFilePopular[0].'" /></a></div></td>
								<td><table>';
								
									for($n=0; $n<3; $n++)
									{
										$most_populars .=  '<tr><td>'.$textLinkPopular[$n].'</td></tr>';
									}
																
								$most_populars .= '</table></td>
								</tr></table>
					</td>
					<td>
						<table><tr>
								<td><div align="center" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:84px; height:84px; padding:2px; background-color:#F9F9F9; display:table-cell; vertical-align:middle" ><a id="postSRCLast_link" href="прочети-статия-'.$resultPostsLast[0]['postID'].','.myTruncateToCyrilic($resultPostsLast[0]['title'],200,'_','') .'.html"><img id="postSRCLast" width="'.($newwidthLast?$newwidthLast:80).'" src="'.$picFileLast[0].'" /></a></div></td>
								<td><table>';
							
									for($n=0; $n<3; $n++)
									{
										$most_populars .= '<tr><td>'.$textLinkLast[$n].'</td></tr>';
									}
																
								$most_populars .= '</table></td>
								</tr></table>
					</td>
					
					</tr>
								
			</table>			
		</div>	
	
		
		<div id="recipesContent" class="ContBox" style="display:none;">		
			<table style="width:650px;">	
			<tr align="center"><td width="50%"><u>Популярни</u></td><td><u>Нови</u></td></tr>';
			
			
				$sql="SELECT r.id as 'id', r.title as 'title', r.has_pic as 'has_pic', r.registered_on as 'registered_on' FROM recipes r WHERE r.active = '1' AND (NOW() BETWEEN r.registered_on AND (r.registered_on + INTERVAL 48 MONTH )) ORDER BY  r.rating DESC, r.times_rated  DESC LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultRecipesPopular = $conn->result;
				$numRecipesPopular = $conn->numberrows;
				
				$sql="SELECT r.id as 'id', r.title as 'title', r.has_pic as 'has_pic', r.registered_on as 'registered_on' FROM recipes r WHERE r.active = '1' AND (NOW() BETWEEN r.registered_on AND (r.registered_on + INTERVAL 48 MONTH )) ORDER BY registered_on DESC LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultRecipesLast = $conn->result;
				$numRecipesLast = $conn->numberrows;
				
				
				
				for($n=0; $n<3; $n++)
				{
												
						if ($resultRecipesPopular[$n]['has_pic']=='1')
						{
							$sql="SELECT * FROM recipe_pics WHERE recipeID='".$resultRecipesPopular[$n]['id']."'";
							$conn->setsql($sql);
							$conn->getTableRows();
							$resultPicsPopular[$n] = $conn->result;
							$numPicsPopular[$n] = $conn->numberrows;
						}
						
						if ($resultRecipesLast[$n]['has_pic']=='1')
						{
							$sql="SELECT * FROM recipe_pics WHERE recipeID='".$resultRecipesLast[$n]['id']."'";
							$conn->setsql($sql);
							$conn->getTableRows();
							$resultPicsLast[$n] = $conn->result;
							$numPicsLast[$n] = $conn->numberrows;
						}
					
					
				   		if($numPicsPopular[$n]>0 && is_file('pics/recipes/'.$resultPicsPopular[$n][0]['url_thumb'])) $picFilePopular[$n] = 'pics/recipes/'.$resultPicsPopular[$n][0]['url_thumb'];
				   		else $picFilePopular[$n] = 'pics/recipes/no_photo_thumb.png';
		
				   		if($numPicsLast[$n]>0 && is_file('pics/recipes/'.$resultPicsLast[$n][0]['url_thumb'])) $picFileLast[$n] = 'pics/recipes/'.$resultPicsLast[$n][0]['url_thumb'];
				   		else $picFileLast[$n] = 'pics/recipes/no_photo_thumb.png';
   		
							  
					$textLinkRecipesPopular[$n] = "<span id='rarrRecipePopular_".$n."' style='color:#FF6600;'>&rarr;</span>&nbsp;<a onMouseover=\"jQuery('#recipeSRCPopular').attr('src', '".$picFilePopular[$n]."');jQuery('#recipeSRCPopular_link').href='разгледай-рецепта-".$resultRecipesPopular[$n]['id'].",".myTruncateToCyrilic($resultRecipesPopular[$n]['title'],200,'_','').".html';jQuery('#rarrRecipePopular_".$n."').css('color', '#FFFFFF'); \" onMouseout=\" jQuery('#rarrRecipePopular_".$n."').css('color', '#FF6600'); \" href='разгледай-рецепта-".$resultRecipesPopular[$n]['id'].",".myTruncateToCyrilic($resultRecipesPopular[$n]['title'],200,'_','').".html'>".$resultRecipesPopular[$n]['title']."</a>";
					$textLinkRecipesLast[$n] = "<span  id='rarrRecipeLast_".$n."' style='color:#FF6600;'>&rarr;</span>&nbsp;<a onMouseover=\"jQuery('#recipeSRCLast').attr('src', '".$picFileLast[$n]."'); jQuery('#recipeSRCLast_link').href='разгледай-рецепта-".$resultRecipesLast[$n]['id'].",".myTruncateToCyrilic($resultRecipesLast[$n]['title'],200,'_','').".html'; jQuery('#rarrRecipeLast_".$n."').css('color', '#FFFFFFF'); \" onMouseout=\" jQuery('#rarrRecipeLast_".$n."').css('color', '#FF6600'); \"  href='разгледай-рецепта-".$resultRecipesLast[$n]['id'].",".myTruncateToCyrilic($resultRecipesLast[$n]['title'],200,'_','').".html'>".$resultRecipesLast[$n]['title']."</a>";
				
				}	
				
				
					$most_populars .= '<tr>
					<td>
						<table><tr>
								<td><div align="center" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:84px; height:84px; padding:2px; background-color:#F9F9F9; display:table-cell; vertical-align:middle" ><a id="recipeSRCPopular_link"  href="разгледай-рецепта-'.$resultRecipesPopular[0]['id'].','.myTruncateToCyrilic($resultRecipesPopular[0]['title'],200,'_','').'.html"><img id="recipeSRCPopular" width="80" height="80" src="'.$picFilePopular[0].'" /></a></div></td>
								<td><table>';								
									for($n=0; $n<3; $n++)
									{
										$most_populars .= '<tr><td>'.$textLinkRecipesPopular[$n].'</td></tr>';
									}
						$most_populars .= '</table></td>
								</tr></table>
					</td>
					<td>
						<table><tr>
								<td><div align="center" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:84px; height:84px; padding:2px; background-color:#F9F9F9; display:table-cell; vertical-align:middle" ><a  id="recipeSRCLast_link"  href="разгледай-рецепта-'.$resultRecipesLast[0]['id'].','.myTruncateToCyrilic($resultRecipesLast[0]['title'],200,'_','').'.html"><img id="recipeSRCLast" width="80" height="80" src="'.$picFileLast[0].'" /></a></div></td>
								<td><table>';
								
									for($n=0; $n<3; $n++)
									{
										$most_populars .= '<tr><td>'.$textLinkRecipesLast[$n].'</td></tr>';
									}
								$most_populars .= '</table></td>
								</tr></table>
					</td>
					
					</tr>
								
			</table>			
		</div>		
		
		
		
		



		<div id="drinksContent" class="ContBox" style="display:none;">		
			<table style="width:650px;">	
			<tr align="center"><td width="50%"><u>Популярни</u></td><td><u>Нови</u></td></tr>';
			
			
				$sql="SELECT d.id as 'id', d.title as 'title', d.has_pic as 'has_pic', d.registered_on as 'registered_on' FROM drinks d WHERE d.active = '1' AND (NOW() BETWEEN d.registered_on AND (d.registered_on + INTERVAL 48 MONTH )) ORDER BY  d.rating DESC, d.times_rated  DESC LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultDrinksPopular = $conn->result;
				$numDrinksPopular = $conn->numberrows;
				
				$sql="SELECT d.id as 'id', d.title as 'title', d.has_pic as 'has_pic', d.registered_on as 'registered_on' FROM drinks d WHERE d.active = '1' AND (NOW() BETWEEN d.registered_on AND (d.registered_on + INTERVAL 48 MONTH )) ORDER BY registered_on DESC LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultDrinksLast = $conn->result;
				$numDrinksLast = $conn->numberrows;
				
				
			
				for($n=0; $n<3; $n++)
				{
					if ($resultDrinksPopular[$n]['has_pic']=='1')
					{
						$sql="SELECT * FROM drink_pics WHERE drinkID='".$resultDrinksPopular[$n]['id']."'";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultPicsPopular[$n] = $conn->result;
						$numPicsPopular[$n] = $conn->numberrows;
					}
					
					if ($resultDrinksLast[$n]['has_pic']=='1')
					{
						$sql="SELECT * FROM drink_pics WHERE drinkID='".$resultDrinksLast[$n]['id']."'";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultPicsLast[$n] = $conn->result;
						$numPicsLast[$n] = $conn->numberrows;
					}
					
				   		if($numPicsPopular[$n]>0 && is_file('pics/drinks/'.$resultPicsPopular[$n][0]['url_thumb'])) $picFilePopular[$n] = 'pics/drinks/'.$resultPicsPopular[$n][0]['url_thumb'];
				   		else $picFilePopular[$n] = 'pics/drinks/no_photo_thumb.png';
		
				   		if($numPicsLast[$n]>0 && is_file('pics/drinks/'.$resultPicsLast[$n][0]['url_thumb'])) $picFileLast[$n] = 'pics/drinks/'.$resultPicsLast[$n][0]['url_thumb'];
				   		else $picFileLast[$n] = 'pics/drinks/no_photo_thumb.png';
		
					   					   		
							  
					$textLinkDrinksPopular[$n] = "<span id='rarrDrinkPopular_".$n."' style='color:#FF6600;'>&rarr;</span>&nbsp;<a onMouseover=\"jQuery('#drinkSRCPopular').attr('src', '".$picFilePopular[$n]."'); jQuery('#drinkSRCPopular_link').href='разгледай-напитка-".$resultDrinksPopular[$n]['id'].",".myTruncateToCyrilic($resultDrinksPopular[$n]['title'],200,'_','').".html';jQuery('#rarrDrinkPopular_".$n."').css('color', '#FFFFFF'); \" onMouseout=\" jQuery('#rarrDrinkPopular_".$n."').css('color', '#FF6600'); \" href='разгледай-напитка-".$resultDrinksPopular[$n]['id'].",".myTruncateToCyrilic($resultDrinksPopular[$n]['title'],200,'_','').".html'>".$resultDrinksPopular[$n]['title']."</a>";
					$textLinkDrinksLast[$n] = "<span  id='rarrDrinkLast_".$n."' style='color:#FF6600;'>&rarr;</span>&nbsp;<a onMouseover=\"jQuery('#drinkSRCLast').attr('src', '".$picFileLast[$n]."'); jQuery('#drinkSRCLast_link').href='разгледай-напитка-".$resultDrinksLast[$n]['id'].",".myTruncateToCyrilic($resultDrinksLast[$n]['title'],200,'_','').".html'; jQuery('#rarrDrinkLast_".$n."').css('color', '#FFFFFF'); \" onMouseout=\" jQuery('#rarrDrinkLast_".$n."').css('color', '#FF6600'); \"  href='разгледай-напитка-".$resultDrinksLast[$n]['id'].",".myTruncateToCyrilic($resultDrinksLast[$n]['title'],200,'_','').".html'>".$resultDrinksLast[$n]['title']."</a>";
									
				}	
				
			$most_populars .= '<tr>
					<td>
						<table><tr>
								<td><div align="center" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:84px; height:84px; padding:2px; background-color:#F9F9F9; display:table-cell; vertical-align:middle" ><a id="drinkSRCPopular_link"  href="разгледай-напитка-'.$resultDrinksPopular[0]['id'].','.myTruncateToCyrilic($resultDrinksPopular[0]['title'],200,'_','').'.html"><img id="drinkSRCPopular" width="80" height="80" src="'.$picFilePopular[0].'" /></a></div></td>
								<td><table>';								
								
									for($n=0; $n<3; $n++)
									{
										$most_populars .= '<tr><td>'.$textLinkDrinksPopular[$n].'</td></tr>';
									}
			$most_populars .= '</table></td>
								</tr></table>
					</td>
					<td>
						<table><tr>
								<td><div align="center" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:84px; height:84px; padding:2px; background-color:#F9F9F9; display:table-cell; vertical-align:middle" ><a  id="drinkSRCLast_link"  href="разгледай-напитка-'.$resultDrinksLast[0]['id'].','.myTruncateToCyrilic($resultDrinksLast[0]['title'],200,'_','').'.html"><img id="drinkSRCLast" width="80" height="80" src="'.$picFileLast[0].'" /></a></div></td>
								<td><table>';
								
									for($n=0; $n<3; $n++)
									{
										$most_populars .= '<tr><td>'.$textLinkDrinksLast[$n].'</td></tr>';
									}
			$most_populars .= '</table></td>
								</tr></table>
					</td>
					
					</tr>
								
			</table>	
			
			
		</div>		
		
		
		
			
		
		<div id="firmsContent" class="ContBox" style="display:none;">		
			<table style="width:650px;">	
			<tr align="center"><td width="50%"><u>Популярни</u></td><td><u>Нови</u></td></tr>';
			
			
				//$sql="SELECT f.id as 'id', SUM(lf.cnt) as 'cnt', f.name as 'name', f.updated_on as 'updated_on', l.name as 'location', lt.name as 'locType' FROM firms h, log_firms lh, locations l, location_types lt WHERE  f.location_id = l.id  AND l.loc_type_id = lt.id AND lf.firm_id=f.id GROUP BY f.id ORDER BY cnt DESC LIMIT 3 ";
				$sql="SELECT f.id as 'id', f.rating/f.times_rated as 'rating_average', f.name as 'name', f.updated_on as 'updated_on', l.name as 'location', lt.name as 'locType' FROM firms f, locations l, location_types lt WHERE  f.location_id = l.id  AND l.loc_type_id = lt.id AND f.active = '1'  AND (NOW() BETWEEN f.updated_on AND (f.updated_on + INTERVAL 48 MONTH )) ORDER BY  f.rating DESC, f.times_rated  DESC LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultFirmsPopular = $conn->result;
				$numFirmsPopular = $conn->numberrows;
				
				$sql="SELECT f.id as 'id', f.name as 'name', f.updated_on as 'updated_on' , l.name as 'location', lt.name as 'locType'  FROM firms f, locations l, location_types lt WHERE  f.location_id = l.id  AND l.loc_type_id = lt.id AND f.active = '1' GROUP BY f.id ORDER BY updated_on DESC LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultFirmsLast = $conn->result;
				$numFirmsLast = $conn->numberrows;
				
				
				
				for($n=0;$n<3;$n++)
				{
					
					if(is_file("pics/firms/".$resultFirmsPopular[$n]['id']."_logo.jpg")) $picFilePopular[$n] = "pics/firms/".$resultFirmsPopular[$n]['id']."_logo.jpg";
				   	else $picFilePopular[$n] = 'pics/firms/no_logo.png';
			
				   	list($widthPopular, $heightPopular, $type, $attr) = getimagesize($picFilePopular[$n]);
					$pic_width_or_heightPopular = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightPopular) && ($widthPopular))	
					{
						if($widthPopular >= $heightPopular)	{$newheightPopular = ($heightPopular/$widthPopular)*$pic_width_or_heightPopular; $newwidthPopular	=	$pic_width_or_heightPopular;	}
						else					{$newwidthPopular = ($widthPopular/$heightPopular)*$pic_width_or_heightPopular; $newheightPopular	=	$pic_width_or_heightPopular;	}
					}
	
					
					
					if(is_file("pics/firms/".$resultFirmsLast[$n]['id']."_logo.jpg")) $picFileLast[$n] = "pics/firms/".$resultFirmsLast[$n]['id']."_logo.jpg";
				   	else $picFileLast[$n] = 'pics/firms/no_logo.png';
			
				   	list($widthLast, $heightLast, $type, $attr) = getimagesize($picFileLast[$n]);
					$pic_width_or_heightLast = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($heightLast) && ($widthLast))	
					{
						if($widthLast >= $heightLast)	{$newheightLast = ($heightLast/$widthLast)*$pic_width_or_heightLast; $newwidthLast	=	$pic_width_or_heightLast;	}
						else					{$newwidthLast = ($widthLast/$heightLast)*$pic_width_or_heightLast; $newheightLast	=	$pic_width_or_heightLast;	}
					}   

					$linkPopular = "разгледай-фирма-".$resultFirmsPopular[$n]['id'].",".myTruncateToCyrilic($resultFirmsPopular[$n]['name'],200,' ','').".html";
					$linkLast = "разгледай-фирма-".$resultFirmsLast[$n]['id'].",".myTruncateToCyrilic($resultFirmsLast[$n]['name'],200,' ','').".html";
					
			   	   	$textLinkFirmsPopular[$n] = "<span id='rarrFirmPopular_".$n."' style='color:#FF6600;'>&rarr;</span>&nbsp;<a onMouseover=\"jQuery('#firmSRCPopular').attr('src', '".$picFilePopular[$n]."');  jQuery('#firmSRCPopular_link').href='".$linkPopular."';jQuery('#rarrFirmPopular_".$n."').css('color', '#FFFFFF'); \" onMouseout=\" jQuery('#rarrFirmPopular_".$n."').css('color', '#FF6600'); \" href='".$linkPopular."'>".$resultFirmsPopular[$n]['name']." - ".$resultFirmsPopular[$n]['locType']." ".$resultFirmsPopular[$n]['location']."</a>";
					$textLinkFirmsLast[$n] = "<span  id='rarrFirmLast_".$n."' style='color:#FF6600;'>&rarr;</span>&nbsp;<a onMouseover=\"jQuery('#firmSRCLast').attr('src', '".$picFileLast[$n]."'); jQuery('#firmSRCLast_link').href='".$linkLast."'; jQuery('#rarrFirmLast_".$n."').css('color', '#FFFFFF'); \" onMouseout=\" jQuery('#rarrFirmLast_".$n."').css('color', '#FF6600'); \"  href='".$linkLast."'>".$resultFirmsLast[$n]['name']." - ".$resultFirmsLast[$n]['locType']." ".$resultFirmsLast[$n]['location']."</a>";
				
				}
			$most_populars .= '<tr>
					<td>
						<table><tr>								
								<td><div align="center" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:84px; height:84px; padding:2px; background-color:#F9F9F9; display:table-cell; vertical-align:middle" ><a id="firmSRCPopular_link"  href="разгледай-фирма-'.$resultFirmsPopular[0]['id'].','.myTruncateToCyrilic($resultFirmsPopular[0]['name'],200,'_','') .'.html"><img id="firmSRCPopular"  width="'.($newwidthPopular?$newwidthPopular:80).'" src="'.$picFilePopular[0].'" /></a></div></td>
								<td><table>';
								
									for($n=0; $n<3; $n++)
									{
										$most_populars .= '<tr><td>'.$textLinkFirmsPopular[$n].'</td></tr>';
									}
								$most_populars .= '</table></td>
								</tr></table>
					</td>
					<td>
						<table><tr>
								<td><div align="center" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:84px; height:84px; padding:2px; background-color:#F9F9F9; display:table-cell; vertical-align:middle" ><a  id="firmSRCLast_link"  href="разгледай-фирма-'.$resultFirmsLast[0]['id'].','.myTruncateToCyrilic($resultFirmsLast[0]['name'],200,'_','') .'.html"><img id="firmSRCLast" width="'.($newwidthLast?$newwidthLast:80).'" src="'.$picFileLast[0].'" /></a></div></td>
								<td><table>';
								
									for($n=0; $n<3; $n++)
									{
										$most_populars .= '<tr><td>'.$textLinkFirmsLast[$n].'</td></tr>';
									}
								$most_populars .= '</table></td>
								</tr></table>
					</td>
					
					</tr>
								
			</table>				
		</div>	
		
		
		
		<div id="guidesContent" class="ContBox" style="display:none;">		
			<table style="width:650px;">	
			<tr align="center"><td width="50%"><u>Популярни</u></td><td><u>Нови</u></td></tr>';
			
			
		
				$sql="SELECT g.id as 'id', g.title as 'title', g.has_pic as 'has_pic', g.registered_on as 'registered_on' FROM guides g WHERE g.active = '1' AND (NOW() BETWEEN g.registered_on AND (g.registered_on + INTERVAL 48 MONTH )) ORDER BY  g.rating DESC, g.times_rated  DESC LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultGuidesPopular = $conn->result;
				$numGuidesPopular = $conn->numberrows;
				
				$sql="SELECT g.id as 'id', g.title as 'title', g.has_pic as 'has_pic', g.registered_on as 'registered_on' FROM guides g WHERE g.active = '1' AND (NOW() BETWEEN g.registered_on AND (g.registered_on + INTERVAL 48 MONTH )) ORDER BY registered_on DESC LIMIT 3 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultGuidesLast = $conn->result;
				$numGuidesLast = $conn->numberrows;
				
				
			
							
				for($n=0; $n<3; $n++)
				{
					if ($resultGuidesPopular[$n]['has_pic']=='1')
					{
						$sql="SELECT * FROM guide_pics WHERE guideID='".$resultGuidesPopular[$n]['id']."'";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultPicsPopular[$n] = $conn->result;
						$numPicsPopular[$n] = $conn->numberrows;
					}
					
					if ($resultGuidesLast[$n]['has_pic']=='1')
					{
						$sql="SELECT * FROM guide_pics WHERE guideID='".$resultGuidesLast[$n]['id']."'";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultPicsLast[$n] = $conn->result;
						$numPicsLast[$n] = $conn->numberrows;
					}
				
					
					if(is_file("pics/guides/".$resultPicsPopular[$n][0]['url_thumb'])) $picFilePopular[$n] = "pics/guides/".$resultPicsPopular[$n][0]['url_thumb'];
				   	else $picFilePopular[$n] = 'pics/guides/no_photo_thumb.png';
			
				   	list($width, $height, $type, $attr) = getimagesize($picFilePopular[$n]);
					$pic_width_or_height = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($height) && ($width))	
					{
						if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
						else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
					}
	
					
					
					if(is_file("pics/guides/".$resultPicsLast[$n][0]['url_thumb'])) $picFileLast[$n] = "pics/guides/".$resultPicsLast[$n][0]['url_thumb'];
				   	else $picFileLast[$n] = 'pics/guides/no_photo_thumb.png';
			
				   	list($width, $height, $type, $attr) = getimagesize($picFileLast[$n]);
					$pic_width_or_height = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($height) && ($width))	
					{
						if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
						else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
					}   
		

					$linkPopular = "разгледай-справочник-".$resultGuidesPopular[$n]['id'].",".myTruncateToCyrilic($resultGuidesPopular[$n]['title'],200,' ','').".html";
					$linkLast = "разгледай-справочник-".$resultGuidesLast[$n]['id'].",".myTruncateToCyrilic($resultGuidesLast[$n]['title'],200,' ','').".html";
							  
					$textLinkGuidesPopular[$n] = "<span id='rarrGuidePopular_".$n."' style='color:#FF6600;'>&rarr;</span>&nbsp;<a onMouseover=\"jQuery('#guideSRCPopular').attr('src', '".$picFilePopular[$n]."');   jQuery('#guideSRCPopular_link').href='".$linkPopular."';jQuery('#rarrGuidePopular_".$n."').css('color', '#FFFFFF'); \" onMouseout=\" jQuery('#rarrGuidePopular_".$n."').css('color', '#FF6600'); \" href='".$linkPopular."'>".$resultGuidesPopular[$n]['title']."</a>";
					$textLinkGuidesLast[$n] = "<span  id='rarrGuideLast_".$n."' style='color:#FF6600;'>&rarr;</span>&nbsp;<a onMouseover=\"jQuery('#guideSRCLast').attr('src', '".$picFileLast[$n]."');  jQuery('#guideSRCLast_link').href='".$linkLast."'; jQuery('#rarrGuideLast_".$n."').css('color', '#FFFFFF'); \" onMouseout=\" jQuery('#rarrGuideLast_".$n."').css('color', '#FF6600'); \"  href='".$linkLast."'>".$resultGuidesLast[$n]['title']."</a>";
				
					
				}	
				
				$most_populars .= '<tr>
					<td>
						<table><tr>
								<td><div align="center" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:84px; height:84px; padding:2px; background-color:#F9F9F9; display:table-cell; vertical-align:middle" ><a id="guideSRCPopular_link"  href="разгледай-справочник-'.$resultGuidesPopular[0]['id'].','.myTruncateToCyrilic($resultGuidesPopular[0]['title'],200,'_','') .'.html"><img id="guideSRCPopular" width="'.($newwidth?$newwidth:80).'" src="'.$picFilePopular[0].'" /></a></div></td>
								<td><table>';
							
									for($n=0; $n<3; $n++)
									{
										$most_populars .= '<tr><td>'.$textLinkGuidesPopular[$n].'</td></tr>';
									}
				$most_populars .= '</table></td>
								</tr></table>
					</td>
					<td>
						<table><tr>
								<td><div align="center" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:84px; height:84px; padding:2px; background-color:#F9F9F9; display:table-cell; vertical-align:middle" ><a  id="guideSRCLast_link"  href="разгледай-справочник-'.$resultGuidesLast[0]['id'].','.myTruncateToCyrilic($resultGuidesPopular[0]['title'],200,'_','') .'.html"><img id="guideSRCLast" width="'.($newwidth?$newwidth:80).'" src="'.$picFileLast[0].'" /></a></div></td>
								<td><table>';
								
									for($n=0; $n<3; $n++)
									{
										$most_populars .= '<tr><td>'.$textLinkGuidesLast[$n].'</td></tr>';
									}
				$most_populars .= '</table></td>
								</tr></table>
					</td>
					
					</tr>
								
			</table>	
						
						
		</div>		
		
		

			
		
		
			
		<br style="clear:both;"/>									
	</div>	
		<br style="clear:both;"/>	
</div>

</div>	

	
<br style="clear:left;"/>


						</p>	
					</div>';
		
	return $most_populars;
	  
	?>