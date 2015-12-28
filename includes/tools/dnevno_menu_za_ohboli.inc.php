<?php 
	include_once("../header.inc.php");
	header('Content-type: text/html;charset=utf-8');
		
	$menuTitleArray['zakuska'] 	= 'Меню за твоята закуска!';
	$menuTitleArray['obqd'] 	= 'Меню за твоят обяд!';
	$menuTitleArray['vecherq'] 	= 'Меню за твоята вечеря!';
	$menuTitleArray['praznik'] 	= 'Меню за твоят празник!';
	
	
	$menuCatsArray['zakuska'] 	= '4,42,51,56,58,59';
	$menuCatsArray['obqd'] 		= '1,4,6,44,45,46,47,48,49,200,54,55,57';
	$menuCatsArray['vecherq'] 	= '1,2,3,5,6,41,44,45,46,47,48,49,54,55,57';
	$menuCatsArray['praznik'] 	= '43';
	
		
	$menuCatsDrinksArray['zakuska'] 	= '2,3,5,41,42';
	$menuCatsDrinksArray['obqd'] 		= '3,5,6,41,42,43,44';
	$menuCatsDrinksArray['vecherq'] 	= '1,4,43,44';
	$menuCatsDrinksArray['praznik'] 	= '7';
	
	
//Get the current hour
$current_time = date(G);

if ($current_time >= 1 && $current_time < 11) {
	$sega_e = 'zakuska';
}
elseif ($current_time < 1) {
	$sega_e = 'zakuska';
}
elseif ($current_time >= 11 && $current_time < 15) {
	$sega_e = 'obqd';
}
elseif ($current_time >= 15) {
	$sega_e = 'vecherq';
}


/*

$current_day = date(l);

//If it's Friday, display a message
if ($current_day = "Friday") {
echo $friday;
}

*/

	$sql="SELECT r.id as 'id', r.title as 'title', r.has_pic as 'has_pic', r.registered_on as 'registered_on' FROM recipes r, recipes_category_list rcl WHERE r.active = '1' AND rcl.recipe_id = r.id AND rcl.category_id IN (".$menuCatsArray[$sega_e].") GROUP BY rcl.category_id ORDER BY RAND(), r.registered_on DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$Menu  = $conn->result;
	$numMenus  = $conn->numberrows;
	
	
	
	$sql="SELECT d.id as 'id', d.title as 'title', d.has_pic as 'has_pic', d.registered_on as 'registered_on' FROM drinks d, drinks_category_list dcl WHERE d.active = '1' AND dcl.drink_id = d.id AND dcl.category_id IN (".$menuCatsDrinksArray[$sega_e].") GROUP BY dcl.category_id ORDER BY RAND(), d.registered_on DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$MenuDrinks  = $conn->result;
	$numMenusDrinks  = $conn->numberrows;
	
	

if($numMenus > 0 OR $numMenusDrinks > 0)
{
  ?>
  
  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="bg-BG" lang="bg-BG">

<head>

<script src="http://gozbite.com/js/scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="http://gozbite.com/js/scriptaculous/src/scriptaculous.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="http://gozbite.com/css/NiftyLayout.css" media="screen">
<script type="text/javascript" src="http://gozbite.com/js/niftycube.js"></script>



</head>
<body>


<script type="text/javascript">
window.onload=function(){
Nifty("div.boxRight","transparent");
}
</script>

   <div class="boxRight">
	<div class="title"><?=$menuTitleArray[$sega_e]?></div>
      

<div id="PrStuffDiv" align="center" style="padding-left:10px;  padding:10px 0px 10px 0px;">
  <div style=" margin:5px;">
  
  <table style="margin:5px;">
  
    <?php 
if($numMenus > 0)
{
?>

<tr><td colspan="2"><h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; font-weight:bold; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;">За ядене</h3></td></tr>
	   
<?php
	for($m=0;$m<$numMenus;$m++)
	{
				
		if ($Menu[$m]['has_pic']=='1')
		{
			$sql="SELECT * FROM recipe_pics WHERE recipeID='".$Menu[$m]['id']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultMenuPics[$m]=$conn->result;
			$numMenuPics[$m]=$conn->numberrows;
		}
		
	   if(is_file('../../pics/recipes/'.$resultMenuPics[$m][0]['url_thumb'])) $picFileMenu= 'http://gozbite.com/pics/recipes/'.$resultMenuPics[$m][0]['url_thumb'];
	   else $picFileMenu = 'http://gozbite.com/pics/recipes/no_photo_thumb.png';
	   	

	    list($width, $height, $type, $attr) = getimagesize($picFileMenu);
		$pic_width_or_height = 40;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($height) && ($width))	
		{
			if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
			else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
		}
	
	?>
	<tr>
		<td>
		
		<div class="postBig">
		<div class="detailsDiv" style="float:left;cursor:pointer; width:225px;margin-bottom:10px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
						
	   <h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(http://gozbite.com/images/gradient_tile.png) repeat 0 -5px;"><a target="_blank" href="http://gozbite.com/разгледай-рецепта-<?=$Menu[$m]['id']?>,<?=myTruncateToCyrilic($Menu[$m]['title'],200,' ','')?>.html" style="font-size:12px; font-weight:bold;" ><?=$Menu[$m]['title']?></a></h3>
	    <a target="_blank" href="http://gozbite.com/разгледай-рецепта-<?=$Menu[$m]['id']?>,<?=myTruncateToCyrilic($Menu[$m]['title'],200,' ','')?>.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" > </a> 
    	</div>
    	</div>
    	
    	</td>
 		<td><a target="_blank" href="http://gozbite.com/разгледай-рецепта-<?=$Menu[$m]['id']?>,<?=myTruncateToCyrilic($Menu[$m]['title'],200,' ','')?>.html" ><div id="menuImgDiv_<?=$Menu[$m]['id']?>"  onMouseover="this.style.borderColor='#0099FF';" onMouseout="this.style.borderColor='#CCCCCC';" style="border:1px solid #CCCCCC; width:50px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="<?=($newwidth?$newwidth:40)?>"  src="<?=$picFileMenu?>" /></div></a>
		</td>
		</tr> 	
		
			
<?php 
			
	}
}
	?>
	
	

	
	 <?php 
	 
if($numMenusDrinks > 0)
{
?>

<tr><td colspan="2"><h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; font-weight:bold; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;">За пиене</h3></td></tr>
	   
<?php
	for($m=0;$m<$numMenusDrinks;$m++)
	{
				
		if ($MenuDrinks[$m]['has_pic']=='1')
		{
			$sql="SELECT * FROM drink_pics WHERE drinkID='".$MenuDrinks[$m]['id']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultMenuDrinksPics[$m]=$conn->result;
			$numMenuDrinksPics[$m]=$conn->numberrows;
		}
		
	   if(is_file('../../pics/drinks/'.$resultMenuDrinksPics[$m][0]['url_thumb'])) $picFileMenuDrinks = 'http://gozbite.com/pics/drinks/'.$resultMenuDrinksPics[$m][0]['url_thumb'];
	   else $picFileMenuDrinks = 'http://gozbite.com/pics/drinks/no_photo_thumb.png';
	   	

	    list($width, $height, $type, $attr) = getimagesize($picFileMenuDrinks);
		$pic_width_or_height = 40;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($height) && ($width))	
		{
			if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
			else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
		}
	
	?>
	<tr>
		<td>
		
		<div class="postBig">
		<div class="detailsDiv" style="float:left;cursor:pointer; width:225px;margin-bottom:10px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
						
	   <h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(http://gozbite.com/images/gradient_tile.png) repeat 0 -5px;"><a target="_blank" href="http://gozbite.com/разгледай-напитка-<?=$MenuDrinks[$m]['id']?>,<?=myTruncateToCyrilic($MenuDrinks[$m]['title'],200,' ','')?>.html" style="font-size:12px; font-weight:bold;" ><?=$MenuDrinks[$m]['title']?></a></h3>
	    <a target="_blank" href="http://gozbite.com/разгледай-напитка-<?=$MenuDrinks[$m]['id']?>,<?=myTruncateToCyrilic($MenuDrinks[$m]['title'],200,' ','')?>.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >  </a> 
    	</div>
    	</div>
    	
    	</td>
 		<td><a target="_blank" href="http://gozbite.com/разгледай-напитка-<?=$MenuDrinks[$m]['id']?>,<?=myTruncateToCyrilic($MenuDrinks[$m]['title'],200,' ','')?>.html" ><div id="menuDrinksImgDiv_<?=$MenuDrinks[$m]['id']?>"  onMouseover="this.style.borderColor='#0099FF';" onMouseout="this.style.borderColor='#CCCCCC';" style="border:1px solid #CCCCCC; width:50px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="<?=($newwidth?$newwidth:40)?>"  src="<?=$picFileMenuDrinks?>" /></div></a>
		</td>
		</tr> 	
		
			
<?php 
			
	}
}
	?>
	
	
	
	</table>
	
  </div>
</div>

</div>

</body>
</html>

<?php } ?>
