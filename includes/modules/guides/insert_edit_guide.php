<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	require_once("includes/classes/Post.class.php");

   	$conn = new mysqldb();
   
   		
	$insert_edit_guide = "";
	
	

// -------------------------------------- EDIT ----------------------------------------------------
	 
			
if (isset($_REQUEST['edit_btn']))
{
	 	
		$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
		
	 	$Guide = new Guide($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$Guide->id = $editID;
		
		$Guide->firm_id 			= $_REQUEST['slujebno_firm'] > 0 ? $_REQUEST['slujebno_firm'] : ($_SESSION['user_type']=='firm' ? $_SESSION['userID'] : 0);
		$Guide->user_id 			= $_REQUEST['slujebno_user'] > 0 ? $_REQUEST['slujebno_user'] : ($_SESSION['user_type']=='user' ? $_SESSION['userID'] : 0);
		$Guide->title 				= $_REQUEST['title'];
		$Guide->tags 				= $_REQUEST['guide_tags'];
		$Guide->youtube_video		= $_REQUEST['youtube_video'];
		$Guide->info 				= $_REQUEST['info'];
		$Guide->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$Guide->updated_by			= $_SESSION['userID'];
		$Guide->updated_on			= 'NOW()';
		
		 if($Guide->update($_FILES["pics"]))
	    $guideID = $Guide->id;
	    $last_ID = $guideID;
		
	    
	    
	    
 	$insert_edit_guide .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледана от администратора Вашето Справочно Описание ще бъде публикувано!\'); 
     	window.location.href=\'редактирай-справочник-'.$_REQUEST['edit'].','.myTruncateToCyrilic(get_guide_nameByGuideID($_REQUEST['edit']),200,'_','') .'.html\';
	</script>';

		  	 
// --------------------------------------------------------------------------------
	
} // krai na edit	




// ------------------------- INSERT hospital -----------------------------------------


if ((isset($_REQUEST['insert_btn'])) && ($_REQUEST['title']!="") )
{

		
		$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
		
		$Guide = new Guide($conn);
		
		$Guide->firm_id 			= $_REQUEST['slujebno_firm'] > 0 ? $_REQUEST['slujebno_firm'] : ($_SESSION['user_type']=='firm' ? $_SESSION['userID'] : 0);
		$Guide->user_id 			= $_REQUEST['slujebno_user'] > 0 ? $_REQUEST['slujebno_user'] : ($_SESSION['user_type']=='user' ? $_SESSION['userID'] : 0);
		$Guide->title 				= $_REQUEST['title'];
		$Guide->tags 				= $_REQUEST['guide_tags'];
		$Guide->youtube_video		= $_REQUEST['youtube_video'];
		$Guide->info 				= $_REQUEST['info'];
		$Guide->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$Guide->updated_by			= $_SESSION['userID'];
		$Guide->updated_on			= 'NOW()';		
		$Guide->registered_on 		= 'NOW()';
			
	    if($Guide->create($_FILES["pics"]))
	    $guideID = $Guide->id;
	    $last_ID = $guideID;
	    
   
	$insert_edit_guide .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледана от администратора Вашето Справочно Описание ще бъде публикувано!\'); 
     	window.location.href=\'редактирай-справочник-'.$last_ID.','.myTruncateToCyrilic(get_guide_nameByGuideID($last_ID),200,'_','') .'.html\';
	</script>';
 
		 
}	
// --- Край на INSERT ----------------------
	 

	 


if (isset($_REQUEST['deletePic']) && isset($_SESSION['valid_user']))
{
	$Guide = new Guide($conn);
	
	$picParts = explode("_",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$Guide->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$Guide->deletePic($matches[0][0]);	
	
		 
	$insert_edit_guide .='<script type="text/javascript">
       window.location.href="редактирай-справочник-'.$editID.','.myTruncateToCyrilic(get_guide_nameByGuideID($editID),200,'_','') .'.html";
	</script> ';
 
}



if (isset($_REQUEST['delete']) && $_REQUEST['delete'] > 0 && $_SESSION['user_kind'] == 2)
{
	
	$Guide = new Guide($conn);
	
	$deleteID=$_REQUEST['delete'];
	$Guide->id = $deleteID; 	
    $Guide->deleteGuide();	
    
	$insert_edit_guide .='<script type="text/javascript">
       	alert(\'Описанието беше успешно изтрито!\'); 
     	window.location.href=\'публикувай-справочник,храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html\';
	</script>';
		
}


	
if (isset($_REQUEST['deleteVideo']) && isset($_SESSION['valid_user']))
{
	$Guide = new Guide($conn);
	$editID=$_REQUEST['deleteVideo'];
	$Guide->id = $editID;
		
	$Guide->deleteVideo();	
	
	$insert_edit_guide .='<script type="text/javascript">
       window.location.href="редактирай-справочник-'.$editID.','.myTruncateToCyrilic(get_guide_nameByGuideID($editID),200,'_','') .'.html";
	</script> ';
	
}


 	
	
	return $insert_edit_guide;
	  
	?>
