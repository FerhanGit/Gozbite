<?php
  
    require_once("../functions.php");
	require_once("../config.inc.php");
	require_once("../bootstrap.inc.php");
   
   	$conn = new mysqldb();
   	$response = '';

	if(isset($_REQUEST['postID']) && !empty($_REQUEST['postID']))
	{
	   $itemID = $_REQUEST['postID'];
	  
	
		$sql="UPDATE posts SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE postID = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM posts WHERE postID = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}

	if(isset($_REQUEST['drinkID']) && !empty($_REQUEST['drinkID']))
	{
	   $itemID = $_REQUEST['drinkID'];
	  
	
		$sql="UPDATE drinks SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM drinks WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}
	
	if(isset($_REQUEST['firmID']) && !empty($_REQUEST['firmID']))
	{
	   $itemID = $_REQUEST['firmID'];
	  
	
		$sql="UPDATE firms SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM dirms WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}

	
	if(isset($_REQUEST['recipeID']) && !empty($_REQUEST['recipeID']))
	{
	   $itemID = $_REQUEST['recipeID'];
	  
	
		$sql="UPDATE recipes SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM recipes WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}
	
	
	if(isset($_REQUEST['guideID']) && !empty($_REQUEST['guideID']))
	{
	   $itemID = $_REQUEST['guideID'];
	  
	
		$sql="UPDATE guides SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM guides WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}
	
	if(isset($_REQUEST['bolestID']) && !empty($_REQUEST['bolestID']))
	{
	   $itemID = $_REQUEST['bolestID'];
	  
	
		$sql="UPDATE bolesti SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE bolestID = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM bolesti WHERE bolestID = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}
	
	
	if(isset($_REQUEST['locationID']) && !empty($_REQUEST['locationID']))
	{
	   $itemID = $_REQUEST['locationID'];
	  
	
		$sql="UPDATE locations SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM locations WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}
	
	if(isset($_REQUEST['questionID']) && !empty($_REQUEST['questionID']))
	{
	   $itemID = $_REQUEST['questionID'];
	  
	
		$sql="UPDATE questions SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE questionID = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM questions WHERE questionID = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}
	
	if(isset($_REQUEST['aphorismID']) && !empty($_REQUEST['aphorismID']))
	{
	   $itemID = $_REQUEST['aphorismID'];
	  
	
		$sql="UPDATE aphorisms SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE aphorismID = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM aphorisms WHERE aphorismID = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}
	
	if(isset($_REQUEST['cardID']) && !empty($_REQUEST['cardID']))
	{
	   $itemID = $_REQUEST['cardID'];
	  
	
		$sql="UPDATE cards SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM cards WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}
	
	
	
	if(isset($_REQUEST['kuhnqID']) && !empty($_REQUEST['kuhnqID']))
	{
	   $itemID = $_REQUEST['kuhnqID'];
	  
	
		$sql="UPDATE kuhni SET rating =(rating + '".$_REQUEST['rated']."')/2 , times_rated = (times_rated + 1) WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->updateDB();
	
		$sql="SELECT rating, times_rated FROM kuhni WHERE id = '".$itemID."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$RatingResult = $conn->result;
	
		$response .= 'Рейтинг  '.$RatingResult['rating'].' от '.$RatingResult['times_rated'].' гласа';
	
	}

   print  $response;

  ?>

 