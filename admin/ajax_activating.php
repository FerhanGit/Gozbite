<?php

   require_once("inc/dblogin.inc.php");
	
  
  
   $is_active=$_REQUEST['is_active'];
   $typeID=$_REQUEST['typeID'];
   $type=$_REQUEST['type'];
   
   											 
	if($type == 'firm')
	{	     	   	
	   	$sql = "UPDATE firms SET active = '".$is_active."' WHERE id='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'hotel')
	{	     	   	
	   	$sql = "UPDATE hotels SET active = '".$is_active."'  WHERE id='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'user')
	{	     	   	
	   	$sql = "UPDATE users SET active = '".$is_active."'  WHERE userID='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'offer')
	{	     	   	
	   	$sql = "UPDATE offers SET active = '".$is_active."', activated_deactivated_by = '1'  WHERE id='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'trip')
	{	     	   	
	   	$sql = "UPDATE trips SET active = '".$is_active."', activated_deactivated_by = '1'  WHERE id='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'news')
	{	     	   	
	   	$sql = "UPDATE news SET active = '".$is_active."' WHERE newsID='".$typeID."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	elseif($type == 'post')
	{	     	   	
	   	$sql = "UPDATE posts SET active = '".$is_active."' WHERE postID='".$typeID."'";
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