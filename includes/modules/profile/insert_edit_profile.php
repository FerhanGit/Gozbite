<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	
   	$conn = new mysqldb();
   
   		
	$insert_edit_profile = "";
	
	
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
	 
		if ((isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['username'])) && (isset($_POST['password'])) && (isset($_POST['cityName'])) && (isset($_POST['email'])) )
		{
			 	    
			if (isset($_REQUEST['edit_userBtn']) && isset($_SESSION['valid_user']))
			{
				$sql="UPDATE users SET username='".$_POST['username']."',
									 		first_name='".$_POST['fname']."',
									 		last_name='".$_POST['lname']."',
									 		password= '".((strlen($_REQUEST['password']) == 32) ? $_REQUEST['password'] : md5($_REQUEST['password']))."',	
									 		email='".$_POST['email']."',
									 		phone='".$_POST['phone']."',
									 		city='".$_POST['city']."',
									 		location_id = '".$_REQUEST['cityName']."',
									 		address='".$_POST['address']."'
									 		WHERE userID ='".$_REQUEST['userID']."'
			 								";
				 $conn->setsql($sql);
				 $last_ID=$conn->updateDB();

			// =================================== Subscribe For Bulletin ===================================
				 if(isset($_REQUEST['subscribe_bulletin']))
				 {
			 		if($_REQUEST['email'] != '')
			 		{
						$sql="SELECT bulletinID FROM bulletins WHERE mail_toSend = '".$_REQUEST['email']."' ";
						$conn->setsql($sql);
						$conn->getTableRows();
						$Itm  = $conn->result;	
				   		if($conn->numberrows > 0 ) 
				   		{
				   			// "Този e-mail адрес вече е абониран за инфо бюлетин-а.";
				   		}
				   		else 
				   		{
				   			$sql="INSERT INTO bulletins SET mail_toSend = '".$_REQUEST['email']."', registered_on = NOW() ";
							$conn->setsql($sql);
							$conn->insertDB();
							// "Абонирахте се успешно за инфо бюлетин-а.";
				   		}
			 		}
				 }
			//===============================================================================================
			
			}
			elseif (isset($_REQUEST['insert_userBtn']))
			{
				$sql="INSERT INTO users SET username='".$_POST['username']."',
									 		first_name='".$_POST['fname']."',
									 		last_name='".$_POST['lname']."',
									 		password= '".((strlen($_REQUEST['password']) == 32) ? $_REQUEST['password'] : md5($_REQUEST['password']))."',	
									 		email='".$_POST['email']."',
									 		phone='".$_POST['phone']."',
									 		city='".$_POST['city']."',
									 		location_id = '".$_REQUEST['cityName']."',
									 		date_register = NOW(),
									 		address='".$_POST['address']."'									 		
			 								";
				 $conn->setsql($sql);
				 $last_ID = $conn->insertDB();
				 $_REQUEST['userID'] = $last_ID;
				 
				 // =================================== Subscribe For Bulletin ===================================
				 if(isset($_REQUEST['subscribe_bulletin']))
				 {
			 		if($_REQUEST['email'] != '')
			 		{
						$sql="SELECT bulletinID FROM bulletins WHERE mail_toSend = '".$_REQUEST['email']."' ";
						$conn->setsql($sql);
						$conn->getTableRows();
						$Itm  = $conn->result;	
				   		if($conn->numberrows > 0 ) 
				   		{
				   			// "Този e-mail адрес вече е абониран за инфо бюлетин-а.";
				   		}
				   		else 
				   		{
				   			$sql="INSERT INTO bulletins SET mail_toSend = '".$_REQUEST['email']."', registered_on = NOW() ";
							$conn->setsql($sql);
							$conn->insertDB();
							// "Абонирахте се успешно за инфо бюлетин-а.";
				   		}
			 		}
				 }
			//===============================================================================================
			
			}
			
			
			  // ================================= AVATAR UPLOAD ==================================================
	      
	      require_once("includes/classes/Upload.class.php");
	  
	 
	      
	      	$avatarPic = new Upload($_FILES['avatar']);
	        if ($avatarPic->uploaded) 
	        {
		         $avatarPic->image_convert      = 'jpg';
		         $avatarPic->file_new_name_body = $_REQUEST['userID']."_avatar";
		         $avatarPic->image_resize       = true;
		         $avatarPic->image_x            = 100;
		         $avatarPic->image_ratio_y      = true;
		         $avatarPic->file_overwrite     = true;
		         $avatarPic->file_auto_rename   = false;
		         $avatarPic->process('pics/users/');
		         $avatarPic->clean();
		         
		         $sql = sprintf("UPDATE users SET picURL = '%s' WHERE userID = %d", $_REQUEST['userID']."_avatar.jpg", $_REQUEST['userID']);
		         $conn->setsql($sql);
		         $conn->updateDB();
	       	}
	         
	    // ================================= END AVATAR UPLOAD ==================================================
	         
	    
	    
	    
	    
	      // ================================= PICS UPLOAD ==================================================
	      
	      require_once("includes/classes/Upload.class.php");
	  
	 
	    
	        if(is_array($_FILES['pics']) && (count($_FILES['pics']) > 0)) {
	            $files = array();
	            foreach ($_FILES['pics'] as $k => $l) {
	               foreach ($l as $i => $v) {
	                  if (!array_key_exists($i, $files))
	                     $files[$i] = array();
	                  $files[$i][$k] = $v;
	               }
	            }
	  
	            		
	            $counter = 1;
	            
	            foreach($files as $file) {
	            	
	            	
	               $upPic = new Upload($file);
	               if ($upPic->uploaded) {
	               	
	               	  $imgBig = imageUser_MoreExists($_REQUEST['userID'],$counter,1);               	
	                  $upPic->image_convert      = 'jpg';
	                  $upPic->file_new_name_body = $imgBig;
	                  $upPic->image_resize       = true;
	                  $upPic->image_x            = 500;
	                  $upPic->image_ratio_y      = true;
	                  $upPic->file_overwrite     = true;
	                  $upPic->file_auto_rename   = false;
	                  $upPic->process('pics/users/');
	
	                  if ($upPic->processed) {
	                  	
	                  	 $imgThumb = imageUser_MoreExists($_REQUEST['userID'],$counter,2);
	                     $upPic->file_new_name_body = $imgThumb;
	                     $upPic->image_resize       = true;
	                     $upPic->image_ratio_crop   = true;
	                     $upPic->image_y            = 60;
	                     $upPic->image_x            = 60;
	                     $upPic->file_overwrite     = true;
	                     $upPic->file_auto_rename   = false;
	                     $upPic->process('pics/users/');
	                     if($upPic->processed) {
	                        $upPic->clean();
	                     } 
	                     
	          			
	                     
	                  } 
	                  
	                   	$sql = sprintf("INSERT INTO user_pics 
	      												SET url_big = '%s',
	      												 url_thumb = '%s',
	      												  userID = %d
	      												   ON DUPLICATE KEY UPDATE
	      												    url_big = '%s',
		      											     url_thumb = '%s',
		      												  userID = %d
		      												   ",
		      												    $imgBig.'.jpg',
		      												     $imgThumb.'.jpg',
		      												      $_REQUEST['userID'],
		      												       $imgBig.'.jpg',
		      												     	$imgThumb.'.jpg',
		      												         $_REQUEST['userID']);
			         	$conn->setsql($sql);
			         	$conn->insertDB();
			        
	                 
					 	$counter++;
	               }	
	               
	            }
	            
	         }
	         
	    // ================================= END PICS UPLOAD ==================================================
	         
	  
	    	    
		 
			  // ПРАЩАМЕ Е–МЕЙЛ С ПАРОЛАТА!
			 	
				
//	      		error_reporting(E_ALL);
				error_reporting(E_STRICT);
				
				date_default_timezone_set('Europe/Sofia');
				//date_default_timezone_set(date_default_timezone_get());
				
				include_once('includes/classes/phpmailer/class.phpmailer.php');
				
				$mail             = new PHPMailer();
				//$body             = $mail->getFile('contents.html');
				$mail->CharSet       = "UTF-8";
				$mail->IsSendmail(); // telling the class to use SendMail transport
				
				$body 		 = "<a href='http://GoZbiTe.Com/вход,вход_в_системата_на_кулинарния_портал_GoZbiTe_Com.html'><img style='border:no;' src='http://GoZbiTe.Com/images/logce.png'></a><br /><br />";			  	
		  		$body 		.= "Здравейте, ".$_REQUEST['fname']." ".$_REQUEST['lname']."<br /><br />";			  	
		  		$body 		.= "Вашето потребителско име е ".$_REQUEST['username']."!<br />";			  	
		  		$body 		.= "Паролата Ви за достъп е ".$_REQUEST['password'].((strlen($_REQUEST['password']) == 32) ? ' (кодирана)' : '')."!<br /><br />";			  	
		  		$body 		.= "За да се възползвате от революционните възможности, които Ви предоставяме <a href='http://GoZbiTe.Com/вход,вход_в_системата_на_кулинарния_портал_GoZbiTe.Com.html'>Влезте в системата на GoZbiTe.Com</a>!<br /><br />";			  	
			  	$body 		.= "Екипът на GoZbiTe.Com Ви желае успех!<br />";			  	
		  		
		  	    $body  = eregi_replace("[\]",'',$body);
							
				$mail->From       = "office@gozbite.com";
				$mail->FromName   = "Екип GoZbiTe.Com";
				
				//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
				
				$mail->WordWrap = 100; 
				$mail->Subject    = "Vashiqt Profil v GoZbiTe.Com!";
				$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
				$mail->MsgHTML($body);
				
				$mail->Priority = 1;
				$mail->ClearAddresses();
				$mail->AddAddress($_REQUEST['email']);
				$mail->AddAddress("office@gozbite.com");
				
				//$mail->ClearAttachments();
				//$mail->AddAttachment("images/phpmailer.gif");             // attachment
				
				if(!$mail->Send()) {
				  //echo "По технически причини вашето съобщение не беше изпратено: " . $mail->ErrorInfo; 
				} else {
				  //echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
				}
				
				
				if(isset($_REQUEST['insert_userBtn']))
				{
					$insert_edit_profile .= '<script type="text/javascript">
				       window.location.href=\'вход-user,вход_в_системата_на_gozbite_com.html\';
					</script>'; 				
				}
				
		 		$insert_edit_profile .= '<script type="text/javascript">
			       window.location.href=\'редактирай-профил,изгради_социални_контакти_с_други_потребители.html\';
				</script> ';
				
			
		}

	}
}




if (isset($_REQUEST['deleteAvatar']) && isset($_SESSION['valid_user']))
{
		
	$picParts = explode("_",$_REQUEST['deleteAvatar']);
	$editID=$picParts[0];
		
	if($editID > 0) {
        if(is_file('pics/users/'.$_REQUEST['deleteAvatar']))
        {
           @unlink('pics/users/'.$_REQUEST['deleteAvatar']);
        }                            
     }
	
	$insert_edit_profile .= '<script type="text/javascript">
       window.location.href=\'редактирай-профил,изгради_социални_контакти_с_други_потребители.html\';
	</script> ';

	
}




if (isset($_REQUEST['deletePicMore']) && isset($_SESSION['valid_user']))
{
	$picParts = explode("_",$_REQUEST['deletePicMore']);
	$editID=$picParts[0];
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$picIndx = $matches[0][0];
	
	
	

        
         $picFile    = $editID."_".$picIndx.".jpg";
         $thumbnail  = $editID."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('pics/users/'.$picFile)){    
            	           
            	@unlink('pics/users/'.$picFile);  
            	
            	$sql=sprintf("DELETE FROM user_pics WHERE url_big = '%s'", $picFile);
				$conn->setsql($sql);
				$conn->updateDB();                
            }
            
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('pics/users/'.$thumbnail)) {
            	@unlink('pics/users/'.$thumbnail);               
            }
         }
		
         
	$insert_edit_profile .= '<script type="text/javascript">
       window.location.href=\'редактирай-профил,изгради_социални_контакти_с_други_потребители.html\';
	</script> ';

	
}

	
	
	return $insert_edit_profile;
	  
	?>
