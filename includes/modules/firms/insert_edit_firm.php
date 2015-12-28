<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	require_once("includes/classes/Firm.class.php");

   	$conn = new mysqldb();
   
   		
	$insert_edit_firm = "";
	
if(isset($_REQUEST['verificationcode'])) 
{
	
	include("verificationimage/verification_image.class.php");
	$image = new verification_image();
	// do this when the form is submitted
	$correct_code=false;
	if($image->validate_code($_REQUEST['verificationcode'])) 
	{		
		$correct_code=true;
		$_SESSION['verification_key']="";

		
	// -------------------------------------- EDIT ----------------------------------------------------
		 
			 
if (isset($_REQUEST['edit_btn']) && isset($_SESSION['valid_user']))
{
	 	$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
		
		
	 	$firm = new Firm($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$firm->id = $editID;
		
		$firm->username				= $_REQUEST['username'];
		$firm->password				= ((strlen($_REQUEST['password']) == 32) ? $_REQUEST['password'] : md5($_REQUEST['password']));	// proverqvame dali e MD5 stringa (toest parolata ne e promenqna) , ako ne e go kodirame v md5 i zapisvame novata parola	
		$firm->name 				= $_REQUEST['firm_name'];
		$firm->manager 				= $_REQUEST['manager'];
		$firm->firm_category		= $_REQUEST['firm_sub_category']?$_REQUEST['firm_sub_category']:$_REQUEST['firm_category'];
		$firm->location_id 			= $_REQUEST['cityName']?$_REQUEST['cityName']:246;
		$firm->latitude 			= $_REQUEST['latitude'];
		$firm->longitude 			= $_REQUEST['longitude'];
		$firm->email 				= $_REQUEST['email'];
		$firm->address 				= $_REQUEST['address'];
		$firm->phone 				= $_REQUEST['phone'];
		$firm->web 					= $_REQUEST['web'];
		$firm->description			= $_REQUEST['description'];
		$firm->youtube_video		= $_REQUEST['youtube_video'];
		$firm->has_pic 				= (is_array($_FILES["pics"]))?1:0;
		$firm->updated_by			= $_SESSION['userID'];
		$firm->updated_on			= 'NOW()';
		$firm->logo					= $_FILES['pic_logo'];
			
	    if($firm->update($_FILES["pics"]))
	    $firmID = $firm->id;
	    $last_ID = $firmID;
			
			
			$insert_edit_firm .='
			<script type="text/javascript">
			       window.location.href=\'редактирай-фирма-'.$_REQUEST["edit"].','.myTruncateToCyrilic(get_firm_nameByFirmID($_REQUEST["edit"]),200,"_","").'.html\';
			</script> ';
			
		// --------------------------------------------------------------------------------
			
} // krai na edit	
		
		

			
		// ------------------------- INSERT firm -----------------------------------------
if ((isset($_REQUEST['insert_btn'])) && ($_REQUEST['firm_name']!="") && ($_REQUEST['manager']!="") && ($_REQUEST['firm_category']!="") && ($_REQUEST['cityName']!=""))
{
	 	 	 	 	 	 	 	 	 	 	
		$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
		 
	
		$firm = new Firm($conn);
		
		$firm->name 				= $_REQUEST['firm_name'];
		$firm->username				= $_REQUEST['username'];
		$firm->password				= md5($_REQUEST['password']);		
		$firm->manager 				= $_REQUEST['manager'];
		$firm->firm_category		= $_REQUEST['firm_sub_category']?$_REQUEST['firm_sub_category']:$_REQUEST['firm_category'];
		$firm->location_id 			= $_REQUEST['cityName']?$_REQUEST['cityName']:246;
		$firm->latitude 			= $_REQUEST['latitude'];
		$firm->longitude 			= $_REQUEST['longitude'];
		$firm->email 				= $_REQUEST['email'];
		$firm->address 				= $_REQUEST['address'];
		$firm->phone 				= $_REQUEST['phone'];
		$firm->web 					= $_REQUEST['web'];
		$firm->description			= $_REQUEST['description'];
		$firm->youtube_video		= $_REQUEST['youtube_video'];
		$firm->has_pic 				= (is_array($_FILES["pics"]))?1:0;
		$firm->updated_by			= $_SESSION['userID'];
		$firm->updated_on			= 'NOW()';
		$firm->registered_on 		= 'NOW()';
		$firm->logo					= $_FILES['pic_logo'];
			
	    if($firm->create($_FILES["pics"]))
	    $firmID = $firm->id;
	    $last_ID = $firmID;
	    
			$insert_edit_firm .='
			<script type="text/javascript">
			       window.location.href=\'редактирай-фирма-'.$firmID.','.myTruncateToCyrilic(get_firm_nameByFirmID($firmID),200,"_","").'.html\';
			</script> ';
		
		}	
	
		// --- Край на INSERT ----------------------				
	}
}			 




if (isset($_REQUEST['deletePic']) && isset($_SESSION['valid_user']))
{
	$firm = new Firm($conn);
	
	$picParts = explode("_",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$firm->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$firm->deletePic($matches[0][0]);	
	
	
	$insert_edit_firm .='<script type="text/javascript">
       window.location.href=\'редактирай-фирма-'.$editID.','.myTruncateToCyrilic(get_firm_nameByFirmID($editID),200,"_","").'.html\';
	</script>'; 	
}




if (isset($_REQUEST['deleteLogo']) && isset($_SESSION['valid_user']))
{
	$firm = new Firm($conn);
	
	$picParts = explode("_",$_REQUEST['deleteLogo']);
	$editID=$picParts[0];
	
	
	$firm->deleteLogo($_REQUEST['deleteLogo']);	
	
	
	$insert_edit_firm .='<script type="text/javascript">
       window.location.href=\'редактирай-фирма-'.$editID.','.myTruncateToCyrilic(get_firm_nameByFirmID($editID),200,"_","").'.html\';
	</script>'; 		
}




if (isset($_REQUEST['delete']) && $_SESSION['user_kind'] == 2)
{
	$firm = new Firm($conn);
	
	$deleteID=$_REQUEST['delete'];
	$firm->id = $deleteID; 	
    $firm->deletefirm();	
	
	$insert_edit_firm .='<script type="text/javascript">
       window.location.href=\'разгледай-фирми,сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html\';
	</script>';
		
}




if (isset($_REQUEST['deleteVideo']) && isset($_SESSION['valid_user']))
{
	$firm = new Firm($conn);
	$editID=$_REQUEST['deleteVideo'];
	$firm->id = $editID;
		
	
	$firm->deleteVideo();		
	
	$insert_edit_firm .='<script type="text/javascript">
       window.location.href=\'редактирай-фирма-'.$editID.','.myTruncateToCyrilic(get_firm_nameByFirmID($editID),200,"_","").'.html\';
	</script>'; 
}




	return $insert_edit_firm;
	  
	?>
