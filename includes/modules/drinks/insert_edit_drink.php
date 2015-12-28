<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	require_once("includes/classes/Drink.class.php");

   	$conn = new mysqldb();
   
   		
	$insert_edit_drink = "";
	
	

	
	


// ------------------------- INSERT Bolest -----------------------------------------
if ((isset($_REQUEST['insert_btn'])) && ($_REQUEST['info']!="") && ($_REQUEST['title']!="") && ($_REQUEST['drink_category']!="") )
{
			
	 	$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
		
		$Drink = new Drink($conn);
		
		$Drink->firm_id 			= $_REQUEST['slujebno_firm'] > 0 ? $_REQUEST['slujebno_firm'] : ($_SESSION['user_type']=='firm' ? $_SESSION['userID'] : 0);
		$Drink->user_id 			= $_REQUEST['slujebno_user'] > 0 ? $_REQUEST['slujebno_user'] : ($_SESSION['user_type']=='user' ? $_SESSION['userID'] : 0);
		$Drink->title 				= $_REQUEST['title'];
		$Drink->products 			= $_REQUEST['drinks_products'];
		$Drink->tags 				= $_REQUEST['drink_tags'];
		$Drink->drink_category		= $_REQUEST['drink_sub_category']?$_REQUEST['drink_sub_category']:$_REQUEST['drink_category'];
		$Drink->youtube_video		= $_REQUEST['youtube_video'];
		$Drink->info 				= $_REQUEST['info'];
		$Drink->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$Drink->updated_by			= $_SESSION['userID'];
		$Drink->updated_on			= 'NOW()';		
		$Drink->registered_on 		= 'NOW()';
			
	    if($Drink->create($_FILES["pics"]))
	    $drinkID = $Drink->id;
	    $last_ID = $drinkID;
		

	
	$insert_edit_drink .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледано от администратора Вашата напитка ще бъде публикувано!\'); 
     	window.location.href=\'редактирай-напитка-'.$last_ID.','.myTruncateToCyrilic(get_drink_nameByDrinkID($last_ID),200,'_','') .'.html\';
	</script>';

}	
// --- Край на INSERT ----------------------
	 



// -------------------------------------- EDIT ----------------------------------------------------
	 
		 
	 if (isset($_REQUEST['edit_btn']))
	 {
	 	$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
		
	 	$Drink = new Drink($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$Drink->id = $editID;
		
		$Drink->firm_id 			= $_REQUEST['slujebno_firm'] > 0 ? $_REQUEST['slujebno_firm'] : ($_SESSION['user_type']=='firm' ? $_SESSION['userID'] : 0);
		$Drink->user_id 			= $_REQUEST['slujebno_user'] > 0 ? $_REQUEST['slujebno_user'] : ($_SESSION['user_type']=='user' ? $_SESSION['userID'] : 0);
		$Drink->title 				= $_REQUEST['title'];
		$Drink->products 			= $_REQUEST['drinks_products'];
		$Drink->tags 				= $_REQUEST['drink_tags'];
		$Drink->drink_category		= $_REQUEST['drink_sub_category']?$_REQUEST['drink_sub_category']:$_REQUEST['drink_category'];
		$Drink->youtube_video		= $_REQUEST['youtube_video'];
		$Drink->info 				= $_REQUEST['info'];
		$Drink->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$Drink->updated_by			= $_SESSION['userID'];
		$Drink->updated_on			= 'NOW()';
		
		 if($Drink->update($_FILES["pics"]))
	    $drinkID = $Drink->id;
	    $last_ID = $drinkID;
		

	
	$insert_edit_drink .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледано от администратора Вашата напитка ще бъде публикувано!\'); 
     	window.location.href=\'редактирай-напитка-'.$last_ID.','.myTruncateToCyrilic(get_drink_nameByDrinkID($last_ID),200,'_','') .'.html\';
	</script>';

					
		
	} // krai na edit	





if (isset($_REQUEST['deletePic']) && isset($_SESSION['valid_user']))
{
	$Drink = new Drink($conn);
	
	$picParts = explode("_",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$Drink->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$Drink->deletePic($matches[0][0]);	
	
	$insert_edit_drink .='	<script type="text/javascript">
       window.location.href="редактирай-напитка-'.$editID.','.myTruncateToCyrilic(get_drink_nameByDrinkID($editID),200,'_','') .'.html";
	</script> ';

	
}



if (isset($_REQUEST['delete']) && $_REQUEST['delete'] > 0 && $_SESSION['user_kind'] == 2)
{
	$Drink = new Drink($conn);
	
	$deleteID=$_REQUEST['delete'];
	$Drink->id = $deleteID; 	
    $Drink->deleteDrink();		

    
	$insert_edit_drink .='<script type="text/javascript">
       	alert(\'Описанието беше успешно изтрито!\'); 
     	window.location.href=\'начална-страница,коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари.html\';
	</script>';
		
}



if (isset($_REQUEST['deleteVideo']) && isset($_SESSION['valid_user']))
{
	$Drink = new Drink($conn);
	$editID=$_REQUEST['deleteVideo'];
	$Drink->id = $editID;
		
	$Drink->deleteVideo();	

	$insert_edit_drink .='<script type="text/javascript">
       window.location.href="редактирай-напитка-'.$editID.','.myTruncateToCyrilic(get_drink_nameByDrinkID($editID),200,'_','') .'.html";
	</script>';

	
}

  


	
	return $insert_edit_drink;
	  
	?>
