<?php
  
  require_once '../header.inc.php';


 
   
   $type = $_REQUEST['type'];
   $username = $_REQUEST['username'];
   $response = "";
 
   if ($type == 'firm')
		$sql="SELECT username FROM firms WHERE username = '".$username."' ";
	elseif($type == 'user')
		$sql="SELECT username FROM users WHERE username = '".$username."' ";
	
	$conn->setsql($sql);
	$conn->getTableRows();
	$Itm  = $conn->result;	
   	if($conn->numberrows > 0 ) $response = "exist";
       
   
   print $response;
  ?>
 