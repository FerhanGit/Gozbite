<?php
  
    require_once '../header.inc.php';

 
   
   $location_id = $_REQUEST['location_id'];
  
   $response = "";
  
   
   	$sql="SELECT id FROM locations WHERE id = '".$location_id."' AND (LENGTH(info) > 20) ";
	$conn->setsql($sql);
	$conn->getTableRows();		  
   	if($conn->numberrows > 0 ) $response = "exist";
       
   
   print $response;
  ?>
 