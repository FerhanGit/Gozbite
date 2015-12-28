<?php
  
   require_once("../inc/dblogin.inc.php");
   

   
   $Active=$_REQUEST['Active'];
   
  
	$sql="UPDATE surveys SET active='0'";
    $conn->setsql($sql);
    $conn->updateDB();
	
    $sql="UPDATE surveys SET active='1' WHERE ID='".$_REQUEST['Active']."'";
    $conn->setsql($sql);
    $conn->updateDB();
	
	
  
  ?>
 