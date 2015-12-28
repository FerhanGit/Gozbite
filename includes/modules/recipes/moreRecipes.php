<?php  

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$more_recipes = "";
	
	if(empty($_REQUEST['recipe_category'])) $_REQUEST['recipe_category'] = $_REQUEST['category']; 
		 	$_REQUEST['recipe_category'] = $_REQUEST['recipe_sub_category']?$_REQUEST['recipe_sub_category']:$_REQUEST['recipe_category'];
		 	
			
	 		if ($_REQUEST['recipe_category']!="")  
			{
				$sql="SELECT rcl.recipe_id as 'recipe_id' FROM recipes r, recipe_category rc, recipes_category_list rcl WHERE rcl.recipe_id = r.id AND rcl.category_id = rc.id  AND (rcl.category_id = '".$_REQUEST['recipe_category']."' OR rcl.category_id IN (SELECT id FROM recipe_category WHERE parentID='".$_REQUEST['recipe_category']."') )";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numRecipesByCats    = $conn->numberrows;
				$resultRecipesByCats = $conn->result;
				for($n=0;$n<$numRecipesByCats;$n++)
				{
					$RecipesByCatsArr[]=$resultRecipesByCats[$n]['recipe_id'];
				}
				if(is_array($RecipesByCatsArr))
				$RecipesByCats = implode(',',$RecipesByCatsArr);
				else $RecipesByCats = '-1';
			}
			
			
	 		$and="";
	 		if ($RecipesByCats != "")  $and .= " AND r.id IN (".$RecipesByCats.")";
	 		if(!empty($_REQUEST['recipeID'])) $and .= " AND r.id != '".$_REQUEST['recipeID']."'";
					

	 	$sql="SELECT r.id as 'id', r.title as 'title', r.registered_on as 'registered_on', r.info as 'info', r.has_pic as 'has_pic', r.is_Silver as 'silver', r.is_Gold as 'gold', r.firm_id as 'firm_id', r.user_id as 'user_id', r.youtube_video as 'youtube_video', r.active as 'active' FROM recipes r WHERE 1=1  $and  ORDER BY RAND() LIMIT 9";
		$conn->setsql($sql);
    	$conn->getTableRows();
    	$resultMore=$conn->result;   
        $numMore=$conn->numberrows;
    	
    	if ($numMore > 0)
	    {	
	    	$more_recipes .= '
	    	<div class="LastComments">
			<div class="titleLastComments" style="margin-bottom:10px"> Още '.$resultCatName.' </div>
	      	<div class="contentBoxLastComments">
      		
	    	<table style="margin:5px;">
	    	<tr>';
	    
	    	for ($i = 0,$cntr = 1; $i < $numMore; $i++,$cntr++)
	    	{
			
					$sql="SELECT rc.id as 'recipe_category_id', rc.name as 'recipe_category_name' FROM recipes r, recipe_category rc, recipes_category_list rcl WHERE rcl.recipe_id = r.id AND rcl.category_id = rc.id AND r.id = '".$resultMore[$i]['id']."' ";
					$conn->setsql($sql);
					$conn->getTableRows();
					$numRecipesCats[$i]  	= $conn->numberrows;
					$resultRecipesCats[$i]  = $conn->result;
				
			  $more_recipes .= '					
    			<td valign="top">	
					<td valign="top"><a href="разгледай-рецепта-'.$resultMore[$i]['id'].','.myTruncateToCyrilic($resultMore[$i]['title'],200,'_','') .'.html"><div id="recipeMoreImgDiv_'.$resultMore[$i]['id'].'" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';" style="border:1px solid #CCCCCC; width:60px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="50"  src="'.((is_file("pics/recipes/".$resultMore[$i]['id']."_1_thumb.jpg"))?"pics/recipes/".$resultMore[$i]['id']."_1_thumb.jpg":"pics/recipes/no_photo_thumb.png").'" /></div></a>
					</td>
					<td width="130"  valign="top">
					<div class="detailsDiv" style="width:130px;cursor:pointer; margin-bottom:5px; border-top:3px solid #0099FF; padding:3px; background-color:#F1F1F1;">
					<a class="read_more_link" href="разгледай-рецепта-'.$resultMore[$i]['id'].','.myTruncateToCyrilic($resultMore[$i]['title'],200,'_','') .'.html"  style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" onMouseover="document.getElementById(\'recipeMoreImgDiv_'.$resultMore[$i]['id'].'\').style.borderColor=\'#0099FF\';" onMouseout="document.getElementById(\'recipeMoreImgDiv_'.$resultMore[$i]['id'].'\').style.borderColor=\'#CCCCCC\';">
				
				    	'.$resultMore[$i]['title'].'<br />
				    	
			    		</a></div></td>   				
	    		</td> ';
	    	
		    	if($cntr % 3 == 0 && $cntr <> $numMore)
		    	{
		    		$more_recipes .= "</tr><tr>";
		    	}
	    	}
	    	
	    	$more_recipes .= '
	    	</tr>
	    	</table>

		</div>
		</div>';
	    	
    	}
    	
    	
return $more_recipes;    	

?>
   