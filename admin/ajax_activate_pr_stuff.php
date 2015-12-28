<?php

   require_once("inc/dblogin.inc.php");
	
  
  
   $is_active 	= $_REQUEST['is_active'];
   $PR_Stuff_ID = $_REQUEST['PR_Stuff_ID'];
   
   											 
	if(!empty($PR_Stuff_ID))
	{	     	   	
	   	$sql = "UPDATE pr_stuff SET active = '".$is_active."' WHERE prID='".$PR_Stuff_ID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	
	
?>