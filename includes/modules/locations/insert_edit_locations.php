<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	require_once("includes/classes/Location.class.php");

   	$conn = new mysqldb();
   
   		
	$insert_edit_location = "";
	
	

	
	// -------------------------------------- EDIT ----------------------------------------------------
	 
		 
 if (isset($_REQUEST['edit_btn']))
 {
 	
 	if(empty($_REQUEST['edit'])) $_REQUEST['edit'] = $_REQUEST['cityName'];
	
	
	
	
	$sql="SELECT id FROM locations WHERE id = '".$_REQUEST['edit']."' AND info <> '' ";
	$conn->setsql($sql);
	$conn->getTableRows();	
	$numLocExist = $conn->numberrows;
		
	
	if(($_SESSION['user_kind'] != 2) && ($numLocExist > 0))     // ako usera ne e admin i ve4e sa6testvuva opisanie - не го вкарваме новото описание
	{
	 
		$insert_edit_location .='<script type="text/javascript">
	       	 	alert(\'Тази дестинация вече е описана от друг потребител, моля изберете друга!\');
			    window.location.href=\'опиши-дестинация,описание_на_градове_села_курорти_дестинации_от_цял_свят.html\';
		</script>';
			  
	}
	else 
	{
		$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
		
	 	$Location = new Location($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$Location->id = $editID;
			            
		$Location->autor_type 			= $_SESSION['user_type'];
		$Location->autor 				= $_SESSION['userID'];
		$Location->info 				= $_REQUEST['info'];
		$Location->tags 				= $_REQUEST['location_tags'];
		$Location->youtube_video		= $_REQUEST['youtube_video'];
		$Location->latitude				= $_REQUEST['latitude'];
		$Location->longitude			= $_REQUEST['longitude'];
		
		
		if($Location->update($_FILES["pics"]))
	    $locationID = $Location->id;
	    $last_ID = $locationID;
		

	
		$insert_edit_location .='<script type="text/javascript">
	       	alert(\'Благодарим Ви! Веднага след като бъде прегледано от администратора Вашата Дестинация/Населено място ще бъде публикувано!\'); 
	     	 window.location.href=\'редактирай-дестинация-'.$last_ID.','.myTruncateToCyrilic(get_location_type_and_nameBylocationID($last_ID),200," ","").'.html\';
		</script>';
		
	}
	
	
	 	

		
	} // krai na edit	





if (isset($_REQUEST['deletePic']) && isset($_SESSION['valid_user']))
{
	$Location = new Location($conn);
	
	$picParts = explode("_",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$Location->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$Location->deletePic($matches[0][0]);	
	
	$insert_edit_location .='<script type="text/javascript">
       window.location.href=\'редактирай-дестинация-'.$editID.','.myTruncateToCyrilic(get_location_type_and_nameBylocationID($editID),200," ","").'.html\';
	</script>'; 


	
}




if (isset($_REQUEST['delete']) && $_REQUEST['delete'] > 0 && $_SESSION['user_kind'] == 2)
{
	$Location = new Location($conn);
	
	$deleteID=$_REQUEST['delete'];
	$Location->id = $deleteID; 	
    $Location->deleteLocation();		

    
	$insert_edit_location .='<script type="text/javascript">
       	alert(\'Описанието беше успешно изтрито!\'); 
     	window.location.href=\'начална-страница,коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари.html\';
	</script>';
		
}



if (isset($_REQUEST['deleteVideo']) && isset($_SESSION['valid_user']))
{
	$Location = new Location($conn);
	$editID=$_REQUEST['deleteVideo'];
	$Location->id = $editID;
		
	$Location->deleteVideo();	

	
	$insert_edit_location .='<script type="text/javascript">
       window.location.href=\'редактирай-дестинация-'.$editID.','.myTruncateToCyrilic(get_location_type_and_nameBylocationID($editID),200," ","").'.html\';
	</script>'; 

	
}

  


	
	return $insert_edit_location;
	  
	?>
