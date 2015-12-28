<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	require_once("includes/classes/Aphorism.class.php");

   	$conn = new mysqldb();
   
   		
	$insert_edit_aphorism = "";
	
	

// -------------------------------------- EDIT ----------------------------------------------------
	 
			
if (isset($_REQUEST['edit_btn']))
{
	 
	 	$aphorism = new Aphorism($conn);	 	
	 	$aphorism->id=$_REQUEST['edit'];
		 		
		$aphorism->title			= $_REQUEST['aphorism_title'];
		$aphorism->body				= $_REQUEST['aphorism_body'];		
		$aphorism->autor 			= $_REQUEST['autor'];
		$aphorism->autor_type 		= $_REQUEST['autor_type'];
		$aphorism->date				= 'NOW()';
			
	 
	     if($aphorism->update($_FILES["aphorism_pic"]))
	        
	  
	   
	$insert_edit_aphorism .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледан от администратора Вашият Афоризъм ще бъде публикуван!\'); 
     	window.location.href=\'редактирай-афоризъм-'.$_REQUEST['edit'].','.myTruncateToCyrilic(get_aphorism_nameByAphorismID($_REQUEST['edit']),50,'_','') .'.html\';
	</script>';

		  	 
// --------------------------------------------------------------------------------
	
} // krai na edit	




// ------------------------- INSERT hospital -----------------------------------------

if (isset($_REQUEST['insert_btn']) && ($_REQUEST['aphorism_title']!="") && ($_REQUEST['aphorism_body']!=""))
{

		$aphorism = new Aphorism($conn);
	 	
	 			
		$aphorism->title			= $_REQUEST['aphorism_title'];
		$aphorism->body				= $_REQUEST['aphorism_body'];		
		$aphorism->autor 			= $_SESSION['userID'];
		$aphorism->autor_type 		= $_SESSION['user_type'];
		$aphorism->date				= 'NOW()';
			
	    if($aphorism->create($_FILES["aphorism_pic"]))
	    $aphorismID = $aphorism->id;
	    $last_ID = $aphorismID;
	    
	 
   
	$insert_edit_aphorism .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледан от администратора Вашият Афоризъм ще бъде публикуван!\'); 
     	window.location.href=\'редактирай-афоризъм-'.$last_ID.','.myTruncateToCyrilic(get_aphorism_nameByAphorismID($last_ID),50,'_','') .'.html\';
	</script>';
 
		 
}	
// --- Край на INSERT ----------------------
	 

	 


if (isset($_REQUEST['deletePic']) && isset($_SESSION['valid_user']))
{
	$aphorism = new Aphorism($conn);
	
	$picParts = explode(".",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$aphorism->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$aphorism->deletePic();	
	
		 
	$insert_edit_aphorism .='<script type="text/javascript">
       window.location.href="редактирай-афоризъм-'.$editID.','.myTruncateToCyrilic(get_aphorism_nameByAphorismID($editID),50,'_','') .'.html";
	</script> ';
 
}



if (isset($_REQUEST['delete']) && $_REQUEST['delete'] > 0 && $_SESSION['user_kind'] == 2)
{
	$aphorism = new Aphorism($conn);
	
	$deleteID=$_REQUEST['delete'];
	$aphorism->id = $deleteID; 	
	$aphorism->load();
    $aphorism->deleteAphorism();	

   
	$insert_edit_aphorism .='<script type="text/javascript">
       	alert(\'Афоризмът Беше успешно изтрит!\'); 
     	window.location.href=\'начална-страница,статии_за_здравето_лекарства_заболявания_болници_лекари.html\';
	</script>';
		
}
 	
	
	return $insert_edit_aphorism;
	  
	?>
