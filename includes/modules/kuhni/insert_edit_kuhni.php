<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	

   	$conn = new mysqldb();
   
   		
	$insert_edit_kuhni = "";
	
	
// -------------------------------------- EDIT ----------------------------------------------------
	 

if($_REQUEST['edit']<>'' && isset($_REQUEST['edit_btn'])) 
{		 		
   $sql = "update kuhni set name='".$_REQUEST['name']."', info='".addslashes($_REQUEST['info'])."' WHERE id='".$_REQUEST['edit']."'";
   $conn->setsql($sql);
   $conn->updateDB(); 
   
   $insert_edit_kuhni .= "<script type='text/javascript'>
	       window.location.href='edit.php?pg=kuhni&edit=".$_REQUEST['edit']."';
	</script>";
}

elseif(isset($_REQUEST['insert_btn'])) 
{		 		
   $sql = "INSERT INTO kuhni set name='".$_REQUEST['name']."', info='".addslashes($_REQUEST['info'])."'";
   $conn->setsql($sql);
   $last_ID=$conn->insertDB(); 

   $insert_edit_kuhni .= "<script type='text/javascript'>
	       window.location.href='edit.php?pg=kuhni&edit=".$last_ID."';
	</script>";
}
	
	
	return $insert_edit_kuhni;
	  
	?>
