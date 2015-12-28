<?php
  
   	require_once("../../includes/functions.php");
	require_once("../../includes/config.inc.php");
	require_once("../../includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

 	$recipeID_previous = $_REQUEST['recipeID'];  
 	$recipeID_next = $_REQUEST['recipeID'];  
 	
	$response = '';
  
	$sql="SELECT MAX(r.id) as 'maxID', MIN(r.id) as 'minID' FROM recipes r ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$ItmMaxMin  = $conn->result;	
		
    function fetchPostInfo($currentRecipeID,$direction)
    {
    	$recipeID = $currentRecipeID + ($direction);			
    	global $conn, $ItmMaxMin, $response;
    	
    	$sql=sprintf("SELECT r.id as 'recipeID',
									   r.title as 'title',
										r.info as 'info',
										 r.firm_id as 'firm_id',
										  r.user_id as 'user_id',
										   r.has_pic as 'has_pic',
										    r.registered_on as 'registered_on',
										     r.updated_by as 'updated_by',
									    	  r.updated_on as 'updated_on',
									    	   r.activated_deactivated_by as 'activated_deactivated_by',
									    		r.active as 'active'
											  	 FROM recipes r
												  WHERE r.active = '1'
												   AND r.id = %d", $recipeID);

    	   
	$conn->setsql($sql);
	$conn->getTableRow();
	$Itm = $conn->result;
	$recipeRowsCount = $conn->numberrows;

	
	if($recipeRowsCount > 0)
	{
		$sql="SELECT * FROM recipe_pics WHERE recipeID='".$Itm['recipeID']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$Itm['numPics']  	= $conn->numberrows;
		$resultRecipesPics	= $conn->result;	
		 
		for($p = 0; $p < $Itm['numPics']; $p++) {
			$Itm['resultPics']['url_big'][$p] 	= $resultRecipesPics[$p]["url_big"];
			$Itm['resultPics']['url_thumb'][$p] = $resultRecipesPics[$p]["url_thumb"];
		}
		
		
		
		$sql="SELECT rc.id as 'recipe_category_id', rc.name as 'recipe_category_name' FROM recipes r, recipe_category rc, recipes_category_list rcl WHERE rcl.recipe_id = r.id AND rcl.category_id = rc.id AND r.id = '".$Itm['recipeID']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$Itm['numCats'] 	= $conn->numberrows;
		$resultRecipesCat	= $conn->result;	
			
		for($z= 0; $z < $Itm['numCats']; $z++) 
		{
			$Itm['Cats'][$z] = $resultRecipesCat[$z];					
		}
	


	}
	
		
			
				
    	
    	if(($direction === 1) && ($recipeID > $ItmMaxMin['maxID']))
	{
		return false;		
	}
    	elseif(($direction === -1) && ($recipeID < $ItmMaxMin['minID']))
	{
		return false;		 
	}
	
	if($recipeRowsCount == 0)
	{
		return fetchPostInfo($recipeID,$direction);	      	
	}
	
	return $Itm;
		
    }
	
    
    
	$Itm_Previous = fetchPostInfo($recipeID_previous,-1);
	$Itm_Next = fetchPostInfo($recipeID_next,1);
    
	$response .=	' <div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">';
	if($Itm_Previous['recipeID'] > 0) $response .=	'<div style=" float:left; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;">&larr; <a style="color:#FFF;font-weight:bold; text-decoration:none;" href="разгледай-рецепта-'.$Itm_Previous['recipeID'].','.myTruncateToCyrilic($Itm_Previous['title'],100,"_","").'.html">Предишна Рецепта</a></div>';
	else $response .=	'<div style=" float:left; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"></div>';
	if($Itm_Next['recipeID'] > 0) $response .=	'<div style=" float:right; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"><a style="color:#FFF;font-weight:bold; text-decoration:none;" href="разгледай-рецепта-'.$Itm_Next['recipeID'].','.myTruncateToCyrilic($Itm_Next['title'],100,"_","").'.html">Следваща Рецепта</a> &rarr;</div>';				
	else $response .=	'<div style=" float:right; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"></div>';				
	$response .=	'<br style="clear:both;"/>';							
	$response .=	'</div>';


        $response .=	'<table><tr><td width="320">';    

	
	if($Itm_Previous)
	{
						
		if(is_file("../../pics/recipes/".$Itm_Previous['resultPics']['url_thumb'][0])) 
		{
			$picFile= "pics/recipes/".$Itm_Previous['resultPics']['url_thumb'][0];
		}
		else 
		{
			$picFile = 'pics/recipes/no_photo_thumb.png';
		}
		   	 
		
		$response .=	'<div style="float:left;width:320px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-рецепта-'.$Itm_Previous['recipeID'].','.myTruncateToCyrilic($Itm_Previous['title'],100,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
		$response .= '<table align="left"><tr>';
		$response .= '<td>';
		$response .= '<div style="float:left; border:double; border-color:#333333;  margin-left:5px; height:35px; width:35px;" ><a href="разгледай-рецепта-'.$Itm_Previous['recipeID'].','.myTruncateToCyrilic($Itm_Previous['title'],100,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
		$response .= '</td><td><div style=" float:left; margin-left:5px; width:260px;" >'.myTruncate($Itm_Previous['title'], 90, " ").'</div>';
		$response .= '<div style="float:left; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;" ><b>'.$Itm_Previous['Cats'][0]['recipe_category_name'].'</b></div>';
					
		$response .= '</td></tr></table>';	            
		$response .= '</div>';
		
	}
   
	
	$response .=	'</td><td width="320">';
    
	
	if($Itm_Next)
	{
		
		if(is_file("../../pics/recipes/".$Itm_Next['resultPics']['url_thumb'][0])) 
		{
			$picFile= "pics/recipes/".$Itm_Next['resultPics']['url_thumb'][0];
		}
		else 
		{
			$picFile = 'pics/recipes/no_photo_thumb.png';
		}  		  		
		
		$response .=	'<div style="float:right;width:320px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-рецепта-'.$Itm_Next['recipeID'].','.myTruncateToCyrilic($Itm_Next['title'],100,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
		$response .= '<table align="right"><tr>';
		$response .= '<td>';
		$response .= '<div style=" float:right; margin-left:5px; width:260px;" >'.myTruncate($Itm_Next['title'], 90, " ").'</div>';
		$response .= '<div style="float:right; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;" ><b>'.$Itm_Next['Cats'][0]['recipe_category_name'].'</b></div>';
		$response .= '</td><td><div style="float:right; border:double; border-color:#333333;  margin-left:5px; height:35px; width:35px;" ><a href="разгледай-рецепта-'.$Itm_Next['recipeID'].','.myTruncateToCyrilic($Itm_Next['title'],100,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
					
		$response .= '</td></tr></table>';	            
		$response .= '</div>';
	
		
	}
	
	$response .=	'</td></tr></table>';
	
   print $response;
  ?>
 