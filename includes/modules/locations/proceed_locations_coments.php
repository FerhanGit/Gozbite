<?php

/*
* ����� ����� �� �������� �������� , � ����� �� ������� ���� ���� - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$comment = "";
   	
   
// ------------------СТАРТ на Вкарване на Коментари -----------------------
   
//=========================================================
 if (isset($_REQUEST['insert_comment_btn']))
 {
      if(isset($_REQUEST['verificationcode'])) {
	
	include("verificationimage/verification_image.class.php");
	$image = new verification_image();
	// do this when the form is submitted
	$correct_code=false;
	if($image->validate_code($_REQUEST['verificationcode'])) 
	{		
		$correct_code=true;
		$_SESSION['verification_key']="";
		
	    if (!empty($_REQUEST['comment_body']) && $_REQUEST['locationID'] > 0)
	     {
	     		 
	        if (!isset($_SESSION['valid_user'])) 
	        {
	      
	        	$comment .= "<script type='text/javascript'>alert('Не сте оторизиран за тази секция');window.location.href='вход,вход_в_системата_на_туристическия_портал_izlet_bg.html';</script> ";
	     
			return $comment;
	        exit;
	        }
	    	 
	    	 	    
	       $sql="INSERT INTO location_comment SET locationID='".$_REQUEST['locationID']."',
	        							 	comment_body='".addslashes($_REQUEST['comment_body'])."',
	        							 	sender_name='".$_REQUEST['sender_name']."',
	        							 	sender_email='".$_SESSION['user_email']."',
	        								autor	=	'".$_SESSION['userID']."',
	        							 	autor_type	=	'".$_SESSION['user_type']."',
	        							 	created_on=NOW()    									 							
	        	 							";
	    	$conn->setsql($sql);
	    	$last_ID=$conn->insertDB();
	    		 
	    	
	    	 if($last_ID>0)
		    {
		    	$sql="UPDATE ".(($_SESSION['user_type']=='user')?'users':(($_SESSION['user_type']=='firm')?'firms':'hotels'))." SET cnt_comment = (cnt_comment+1) WHERE username='".$_SESSION['valid_user']."'";
		    	$conn->setsql($sql);
		    	$conn->updateDB();
		    	
		    	$_SESSION['cnt_comment'] ++;
		    }
	    	
		    
		    
		     // ==================================== MAIL SEND ============================================
    	
		   if(isset($_REQUEST['locationID']) AND $_REQUEST['locationID'] > 0) 	
		   {
		   		$sql="SELECT locationID, sender_name, sender_email, autor, autor_type FROM location_comment WHERE locationID='".$_REQUEST['locationID']."' GROUP BY autor_type, autor";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultQuestionMails = $conn->result;
				$numQuestionMails = $conn->numberrows;
		   }	
			   
			if($numQuestionMails > 0)
			{
				for($n=0; $n<$numQuestionMails; $n++)
				{
				
				// ****************************** Автора  *******************************
					$resultMneniqAvtor = $resultQuestionMails[$n]['sender_name'];	
					
					$resultMneniqEmail = $resultQuestionMails[$n]['sender_email'];	
				//***********************************************************************
				
					//error_reporting(E_ALL);
					error_reporting(E_STRICT);
					
					date_default_timezone_set('Europe/Sofia');
					//date_default_timezone_set(date_default_timezone_get());
					
					include_once('classes/phpmailer/class.phpmailer.php');
					
					$mail             = new PHPMailer();
					$mail->CharSet       = "UTF-8";
					$mail->IsSendmail(); // telling the class to use SendMail transport
					
					$body ="<div style=\"width:600px; \">";
					$body .= "Уважаеми, <b><font color='#FF6600'>".$resultMneniqAvtor."</font></b>, Има нов коментар в отговор на Вашия относно Дестинация в портала GoZbiTe.Com!<br /><br />";
			   		
			   		 $body .= "<div style=\"width:600px; float:left; margin: 0px 0px 50px 0px;\">	
			   		 			За да го прочетете последвайте този линк <a href='http://gozbite.com/разгледай-дестинация-".$_REQUEST['locationID'].",".myTruncateToCyrilic(get_location_nameBylocationID($_REQUEST['locationID']),50,' ','').".html'>Виж Дестинацията</a>.
			   					</div>";
			   		 
					 $body .= "</div>";
					 
				 
					$body  = eregi_replace("[\]",'',$body);
					
								
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Info.GoZbiTe.Com" ;
					
					//$mail->AddReplyTo("office@izlet.bg"); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Nov komentar v gozbite.com";
					$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
					$mail->MsgHTML($body);
					
					$mail->Priority = 1;
					$mail->ClearAddresses();
					$mail->AddAddress($resultMneniqEmail);
					$mail->AddAddress("office@gozbite.com");
					
					//$mail->ClearAttachments();
					//$mail->AddAttachment("images/phpmailer.gif");             // attachment
					
					if(!$mail->Send()) {
					  //$MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo; 
					} else {
					  //$MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в иЗЛеТ.Бг.</span><br />";
					}
				
				}
				
			}
			// ================================= KRAI na MAIL-a =========================================
			
						
	    }
	    
	}
	
   }
}
//================== Край на Вкарване на Коментари =======================================



return $comment;

?>