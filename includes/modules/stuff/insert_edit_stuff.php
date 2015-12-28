<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	require_once("includes/classes/Post.class.php");

   	$conn = new mysqldb();
   
   		
	$insert_edit_page = "";
	
	

// -------------------------------------- EDIT ----------------------------------------------------
	 

if($_REQUEST['edit']<>'' && isset($_REQUEST['edit_Btn_Page'])) 
{		 		
   $sql = "update pages set title='".$_REQUEST['title']."', body='".$_REQUEST['body']."' WHERE abriviature='".$_REQUEST['edit']."'";
   $conn->setsql($sql);
   $conn->updateDB(); 

   $insert_edit_page .= "<script type='text/javascript'>
	       window.location.href='edit.php?pg=stuff&edit=".$_REQUEST['edit']."';
	</script>";
}
	
	
	return $insert_edit_page;
	  
	?>
