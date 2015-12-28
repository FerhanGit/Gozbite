<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	require_once("includes/classes/Bolest.class.php");

   	$conn = new mysqldb();
   
   		
	$insert_edit_bolest = "";
	
	

	
	


// ------------------------- INSERT Bolest -----------------------------------------
if ((isset($_REQUEST['insert_btn'])) && ($_REQUEST['bolest_title']!="") && ($_REQUEST['bolest_body']!="") && ($_REQUEST['bolest_category']!="") )
{
		$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
			 	 	 	 	 	 	 	 	 	 	
	 
		$bolest = new Bolest($conn);
		
		$bolest->title 				= $_REQUEST['bolest_title'];
		$bolest->body 				= $_REQUEST['bolest_body'];
		$bolest->autor_type 		= $_SESSION['user_type'];
		$bolest->autor 				= $_SESSION['userID'];
		$bolest->source 			= $_REQUEST['bolest_source'];
		$bolest->tags 				= $_REQUEST['bolest_tags'];
		$bolest->bolest_category	= ($_REQUEST['bolest_sub_category']?$_REQUEST['bolest_sub_category']:$_REQUEST['bolest_category']);
		$bolest->bolest_simptom		= $_REQUEST['bolest_simptom'];
		$bolest->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$bolest->youtube_video		= $_REQUEST['youtube_video'];		
		$bolest->date		 		= 'NOW()';

		if($bolest->create($_FILES["pics"]))
	    $bolestID = $bolest->id;
	    $last_ID  = $bolestID;

	
	$insert_edit_bolest .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледано от администратора Вашето описание ще бъде публикувано!\'); 
     	window.location.href=\'редактирай-описание-болест-'.$last_ID.','.myTruncateToCyrilic(get_bolest_nameByBolestID($last_ID),200,'_','') .'.html\';
	</script>';

}	
// --- Край на INSERT ----------------------
	 



// -------------------------------------- EDIT ----------------------------------------------------
	 
		 
	 if (isset($_REQUEST['edit_btn']))
	 {
	 	$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
	 	
	 	$bolest = new Bolest($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$bolest->id = $editID;
		
		$bolest->title 				= $_REQUEST['bolest_title'];
		$bolest->body 				= $_REQUEST['bolest_body'];
		$bolest->autor_type 		= $_REQUEST['autor_type'];
		$bolest->autor 				= $_REQUEST['autor'];
		$bolest->source 			= $_REQUEST['bolest_source'];
		$bolest->tags 				= $_REQUEST['bolest_tags'];
		$bolest->bolest_category	= ($_REQUEST['bolest_sub_category']?$_REQUEST['bolest_sub_category']:$_REQUEST['bolest_category']);
		$bolest->bolest_simptom		= $_REQUEST['bolest_simptom'];
		$bolest->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$bolest->youtube_video		= $_REQUEST['youtube_video'];		
		$bolest->date				= 'NOW()';
	
	    if($bolest->update($_FILES["pics"]))
	    $bolestID = $bolest->id;
	    $last_ID  = $bolestID;
		
		 	
		$insert_edit_bolest .='<script type="text/javascript">
	       	alert(\'Благодарим Ви! Веднага след като бъде прегледано от администратора Вашето описание ще бъде публикувано!\'); 
	     	window.location.href=\'редактирай-описание-болест-'.$last_ID.','.myTruncateToCyrilic(get_bolest_nameByBolestID($last_ID),200,'_','') .'.html\';
		</script>';
			
		
	} // krai na edit	





if (isset($_REQUEST['deletePic']) && isset($_SESSION['valid_user']))
{
	$bolest = new Bolest($conn);
	
	$picParts = explode("_",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$bolest->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$bolest->deletePic($matches[0][0]);	
	
	$insert_edit_bolest .='	<script type="text/javascript">
       window.location.href="редактирай-описание-болест-'.$editID.','.myTruncateToCyrilic(get_bolest_nameByBolestID($editID),200,'_','') .'.html";
	</script> ';

	
}



if (isset($_REQUEST['delete']) && $_REQUEST['delete'] > 0 && $_SESSION['user_kind'] == 2)
{
	$bolest = new Bolest($conn);
	
	$deleteID=$_REQUEST['delete'];
	$bolest->id = $deleteID; 	
	$bolest->load();
    $bolest->deletebolest();	

    
	$insert_edit_bolest .='<script type="text/javascript">
       	alert(\'Описанието беше успешно изтрито!\'); 
     	window.location.href=\'начална-страница,статии_за_здравето_лекарства_заболявания_болници_лекари.html\';
	</script>';
		
}



if (isset($_REQUEST['deleteVideo']) && isset($_SESSION['valid_user']))
{
	$bolest = new Bolest($conn);
	$editID=$_REQUEST['deleteVideo'];
	$bolest->id = $editID;
		
	$bolest->deleteVideo();	

	$insert_edit_bolest .='<script type="text/javascript">
       window.location.href="редактирай-описание-болест-'.$editID.','.myTruncateToCyrilic(get_bolest_nameByBolestID($editID),200,'_','') .'.html";
	</script>';

	
}

  


	
	return $insert_edit_bolest;
	  
	?>
