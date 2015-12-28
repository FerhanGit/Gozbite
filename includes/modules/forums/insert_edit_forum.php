<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	require_once("includes/classes/Forum.class.php");

   	$conn = new mysqldb();
   
   		
	$insert_edit_forum = "";
	
	

// -------------------------------------- EDIT ----------------------------------------------------
	 
			
if (isset($_REQUEST['edit_question_btn']) && $_REQUEST['edit_forum'] > 0)
{
	 	
	 	$forum = new Forum($conn);
	 	
	 	$forum->id=$_REQUEST['edit_forum'];
		 		
		$forum->parent_id		= $_REQUEST['parentID'];
		$forum->question_body	= $_REQUEST['question_body'];		
		$forum->autor_type 		= $_REQUEST['autor_type'];
		$forum->autor 			= $_REQUEST['autor'];
		$forum->question_title 	= $_REQUEST['question_title'];
		$forum->question_category = $_REQUEST['question_category'];
		
	 
	    $forum->update();
	    
	     
	   
	$insert_edit_forum .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледана от администратора Вашата Тема ще бъде публикувана!\'); 
     	window.location.href=\'разгледай-форум-тема-'.($_REQUEST['parentID'] > 0 ? $_REQUEST['parentID'] : $_REQUEST['edit_forum']).','.myTruncateToCyrilic($_REQUEST['question_title'],200,'_','') .'.html#question_'.$_REQUEST['edit_forum'].'\';
	</script>';

		  	 
// --------------------------------------------------------------------------------
	
} // krai na edit	




// ------------------------- INSERT Tema -----------------------------------------

if (isset($_REQUEST['insert_question_btn']) && ($_REQUEST['question_title']!="") && ($_REQUEST['question_body']!="") && ($_REQUEST['question_category']!=""))
{ 	 	 	
	 
		$forum = new Forum($conn);
	 	
	 		
		$forum->parent_id		= $_REQUEST['parentID'];
		$forum->question_body	= $_REQUEST['question_body'];		
		$forum->autor_type 		= $_SESSION['user_type'];
		$forum->autor 			= $_SESSION['userID'];
		$forum->question_title 	= $_REQUEST['question_title'];
		$forum->question_category		= $_REQUEST['question_category'];
		
			
	    if($forum->create())
	    $forumID = $forum->id;
	    $last_ID = $forumID;
	    
   
	$insert_edit_forum .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледана от администратора Вашата Статия ще бъде публикувана!\'); 
     	window.location.href=\'разгледай-форум-тема-'.$last_ID.','.myTruncateToCyrilic($_REQUEST['question_title'],200,'_','') .'.html\';
	</script>';
 
		 
}	
// --- Край на INSERT ----------------------
	 

	 
if (isset($_REQUEST['deleteQuestion']) && $_REQUEST['deleteQuestion'] > 0 && $_SESSION['user_kind'] == 2)
{
	$forum = new Forum($conn);
	
	$deleteID=$_REQUEST['deleteQuestion'];
	$forum->id = $deleteID; 	
	$forum->load();
    $forum->deleteQuestion();	
    
	$insert_edit_forum .='<script type="text/javascript">
       	alert(\'Темата беше успешно изтрита!\'); 
     	window.location.href=\'разгледай-форум,интересни_кулинарни_теми_потърси_съвет_или_помогни.html\';
	</script>';
		
}

 
if (isset($_REQUEST['deleteAnser']) && $_REQUEST['deleteAnser'] > 0 && $_SESSION['user_kind'] == 2)
{
	$forum = new Forum($conn);
	
	$deleteID=$_REQUEST['deleteAnser'];
	$forum->id = $deleteID; 	
	$forum->load();
    $forum->deleteAnser();	
    
	$insert_edit_forum .='<script type="text/javascript">
       	alert(\'Коментара беше успешно изтрит!\'); 
     	window.location.href=\'разгледай-форум,интересни_кулинарни_теми_потърси_съвет_или_помогни.html\';
	</script>';
		
}


	
	return $insert_edit_forum;
	  
	?>
