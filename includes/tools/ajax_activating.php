<?php

   require_once("../../includes/functions.php");
	require_once("../../includes/config.inc.php");
	require_once("../../includes/bootstrap.inc.php");

	$conn = new mysqldb();
		
  
  
   $is_active=$_REQUEST['is_active'];
   $typeID=$_REQUEST['typeID'];
   $type=$_REQUEST['type'];
   $activated_deactivated_by = $_REQUEST['activated_deactivated_by'];
   											 
	if($type == 'firm')
	{	     	   	
	   	$sql = "UPDATE firms SET active = '".$is_active."' WHERE id='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	
	elseif($type == 'user')
	{	     	   	
	   	$sql = "UPDATE users SET active = '".$is_active."' WHERE userID='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'recipe')
	{	     	   	
	   	$sql = "UPDATE recipes SET active = '".$is_active."', activated_deactivated_by = '".$activated_deactivated_by."' WHERE id='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'drink')
	{	     	   	
	   	$sql = "UPDATE drinks SET active = '".$is_active."', activated_deactivated_by = '".$activated_deactivated_by."' WHERE id='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'guide')
	{	     	   	
	   	$sql = "UPDATE guides SET active = '".$is_active."', activated_deactivated_by = '".$activated_deactivated_by."' WHERE id='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}	
	elseif($type == 'post')
	{	     	   	
	   	$sql = "UPDATE posts SET active = '".$is_active."' WHERE postID='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'aphorism')
	{	     	   	
	   	$sql = "UPDATE aphorisms SET active = '".$is_active."' WHERE aphorismID='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'question')
	{	     	   	
	   	$sql = "UPDATE questions SET active = '".$is_active."' WHERE questionID='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
   
?>