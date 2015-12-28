<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	require_once("includes/classes/Recipe.class.php");

   	$conn = new mysqldb();
   
   		
	$insert_edit_recipe = "";
	
	

	
	


// ------------------------- INSERT Bolest -----------------------------------------
if ((isset($_REQUEST['insert_btn'])) && ($_REQUEST['info']!="") && ($_REQUEST['title']!="") && ($_REQUEST['recipe_category']!="") )
{
			
	 	$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
		
		$Recipe = new Recipe($conn);
		
		$Recipe->firm_id 			= $_REQUEST['slujebno_firm'] > 0 ? $_REQUEST['slujebno_firm'] : ($_SESSION['user_type']=='firm' ? $_SESSION['userID'] : 0);
		$Recipe->user_id 			= $_REQUEST['slujebno_user'] > 0 ? $_REQUEST['slujebno_user'] : ($_SESSION['user_type']=='user' ? $_SESSION['userID'] : 0);
		$Recipe->title 				= $_REQUEST['title'];
		$Recipe->products 			= $_REQUEST['recipes_products'];
		$Recipe->tags 				= $_REQUEST['recipe_tags'];
		$Recipe->recipe_kuhni 		= $_REQUEST['recipe_kuhni'];
		$Recipe->recipe_category	= $_REQUEST['recipe_sub_category']?$_REQUEST['recipe_sub_category']:$_REQUEST['recipe_category'];
		$Recipe->youtube_video		= $_REQUEST['youtube_video'];
		$Recipe->info 				= $_REQUEST['info'];
		$Recipe->is_Promo			= ($_REQUEST['is_Promo'] == 1)?1:0;
		$Recipe->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$Recipe->updated_by			= $_SESSION['userID'];
		$Recipe->updated_on			= 'NOW()';		
		$Recipe->registered_on 		= 'NOW()';
			
	    if($Recipe->create($_FILES["pics"]))
	    $recipeID = $Recipe->id;
	    $last_ID = $recipeID;
		

	
	$insert_edit_recipe .='<script type="text/javascript">
       //	alert(\'Благодарим Ви! Веднага след като бъде прегледано от администратора Вашата рецепта ще бъде публикувано!\'); 
     	window.location.href=\'редактирай-рецепта-'.$last_ID.','.myTruncateToCyrilic(get_recipe_nameByRecipeID($last_ID),200,'_','') .'.html\';
	</script>';

}	
// --- Край на INSERT ----------------------
	 



// -------------------------------------- EDIT ----------------------------------------------------
	 
		 
	 if (isset($_REQUEST['edit_btn']))
	 {
	 	$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
		
	 	$Recipe = new Recipe($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$Recipe->id = $editID;
		
		$Recipe->firm_id 			= $_REQUEST['slujebno_firm'] > 0 ? $_REQUEST['slujebno_firm'] : ($_SESSION['user_type']=='firm' ? $_SESSION['userID'] : 0);
		$Recipe->user_id 			= $_REQUEST['slujebno_user'] > 0 ? $_REQUEST['slujebno_user'] : ($_SESSION['user_type']=='user' ? $_SESSION['userID'] : 0);
		$Recipe->title 				= $_REQUEST['title'];
		$Recipe->products 			= $_REQUEST['recipes_products'];
		$Recipe->tags 				= $_REQUEST['recipe_tags'];
		$Recipe->recipe_kuhni 		= $_REQUEST['recipe_kuhni'];
		$Recipe->recipe_category	= $_REQUEST['recipe_sub_category']?$_REQUEST['recipe_sub_category']:$_REQUEST['recipe_category'];
		$Recipe->youtube_video		= $_REQUEST['youtube_video'];
		$Recipe->info 				= $_REQUEST['info'];
		$Recipe->is_Promo			= ($_REQUEST['is_Promo'] == 1)?1:0;
		$Recipe->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$Recipe->updated_by			= $_SESSION['userID'];
		$Recipe->updated_on			= 'NOW()';
		
		 if($Recipe->update($_FILES["pics"]))
	    $recipeID = $Recipe->id;
	    $last_ID = $recipeID;
		
		
	
	$insert_edit_recipe .='<script type="text/javascript">
       //	alert(\'Благодарим Ви! Веднага след като бъде прегледано от администратора Вашата рецепта ще бъде публикувано!\'); 
     	window.location.href=\'редактирай-рецепта-'.$last_ID.','.myTruncateToCyrilic(get_recipe_nameByRecipeID($last_ID),200,'_','') .'.html\';
	</script>';

					
		
	} // krai na edit	





if (isset($_REQUEST['deletePic']) && isset($_SESSION['valid_user']))
{
	$Recipe = new Recipe($conn);
	
	$picParts = explode("_",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$Recipe->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$Recipe->deletePic($matches[0][0]);	
	
	$insert_edit_recipe .='	<script type="text/javascript">
       window.location.href="редактирай-рецепта-'.$editID.','.myTruncateToCyrilic(get_recipe_nameByRecipeID($editID),200,'_','') .'.html";
	</script> ';

	
}



if (isset($_REQUEST['delete']) && $_REQUEST['delete'] > 0 && $_SESSION['user_kind'] == 2)
{
	$Recipe = new Recipe($conn);
	
	$deleteID=$_REQUEST['delete'];
	$Recipe->id = $deleteID; 	
    $Recipe->deleteRecipe();		

    
	$insert_edit_recipe .='<script type="text/javascript">
       	// alert(\'Описанието беше успешно изтрито!\'); 
     	window.location.href=\'начална-страница,коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари.html\';
	</script>';
		
}



if (isset($_REQUEST['deleteVideo']) && isset($_SESSION['valid_user']))
{
	$Recipe = new Recipe($conn);
	$editID=$_REQUEST['deleteVideo'];
	$Recipe->id = $editID;
		
	$Recipe->deleteVideo();	

	$insert_edit_recipe .='<script type="text/javascript">
       window.location.href="редактирай-рецепта-'.$editID.','.myTruncateToCyrilic(get_recipe_nameByRecipeID($editID),200,'_','') .'.html";
	</script>';

	
}

  


	
	return $insert_edit_recipe;
	  
	?>
