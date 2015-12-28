<?php
  
   require_once("../inc/dblogin.inc.php");
   
 
   
   $itemID = $_REQUEST['firmID'];
   $response = '';
  
	$sql="UPDATE hospitals SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE id = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->updateDB();
	
	
	$sql="SELECT rating, times_rated FROM hospitals WHERE id = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$RatingResult = $conn->result;
	
	
	$response .= 'Рейтинг '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласa';
	
	
   print  $response;
  ?>
 