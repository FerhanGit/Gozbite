<?php

/*
* ����� ����� �� �������� �������� , � ����� �� ������� ���� ���� - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$comment = "";
   	
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
	
	     if (!empty($_REQUEST['comment_body']) && $_REQUEST['recipeID'] > 0)
	     {
	     		 
	        if (!isset($_SESSION['valid_user'])) 
	        {
	        	$comment .= '<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href=\'вход,вход_в_системата_на_кулинарния_портал_GoZbiTe.Com.html\';</script> ';
	    		return $comment;			        	
	        	exit;
	        }
	    	 
	    	 	    
	       $sql="INSERT INTO recipe_comment SET recipeID='".$_REQUEST['recipeID']."',
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
		    	$sql="UPDATE ".(($_SESSION['user_type']=='user')?'users':'firms')." SET cnt_comment = (cnt_comment+1) WHERE username='".$_SESSION['valid_user']."'";
		    	$conn->setsql($sql);
		    	$conn->updateDB();
		    	
		    	$_SESSION['cnt_comment'] ++;
		    	
		    	
		    	
		    	
		    	  // ==================================== MAIL SEND ============================================
	    	
				  		$sql="SELECT recipeID, sender_name, sender_email FROM recipe_comment WHERE recipeID = '".$_REQUEST['recipeID']."' GROUP BY sender_email";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCommentNew = $conn->result;
						$numCommentNew = $conn->numberrows;
				   
						if($numCommentNew > 0)
						{
							for($n=0; $n<$numCommentNew; $n++)
							{
								//error_reporting(E_ALL);
								error_reporting(E_STRICT);
								
								date_default_timezone_set('Europe/Sofia');
								//date_default_timezone_set(date_default_timezone_get());
								
								include_once('classes/phpmailer/class.phpmailer.php');
								
								$mail             = new PHPMailer();
								$mail->CharSet       = "UTF-8";
								$mail->IsSendmail(); // telling the class to use SendMail transport
								
								$body ="<div style=\"width:600px; \">";
								$body .= "Уважаеми, <b><font color='#FF6600'>".$resultCommentNew[$n]['sender_name']."</font></b>, Има нов коментар свързан с Вашето мнение относно рецепта '".get_recipe_nameByrecipeID($_REQUEST['recipeID'])."', публикувана в кулинарния портал GoZbiTe.Com!<br /><br />";
						   		
						   		 $body .= "<div style=\"width:600px; float:left; margin: 0px 0px 50px 0px;\">	
						   		 			За да го прочетете последвайте този линк <a href='http://GoZbiTe.Com/разгледай-рецепта-".$_REQUEST['recipeID'].",".myTruncateToCyrilic(get_recipe_nameByrecipeID($_REQUEST['recipeID']),50,'_','').".html'>Виж коментара</a>.
						   					</div>";
						   		 
								 $body .= "</div>";
								 
							 
								$body  = eregi_replace("[\]",'',$body);
								
											
								$mail->From       = "office@gozbite.com";
								$mail->FromName   = "GoZbiTe.Com" ;
								
								//$mail->AddReplyTo("office@gozbite.com"); // tova moje da go zadadem razli4no ot $mail->From
								
								$mail->WordWrap = 100; 
								$mail->Subject    = "Nov otgovor na Vashiq komentar v GoZbiTe.Com";
								$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
								$mail->MsgHTML($body);
								
								$mail->Priority = 1;
								$mail->ClearAddresses();
								$mail->AddAddress($resultCommentNew[$n]['sender_email']);
								$mail->AddAddress("office@gozbite.com");
								
								//$mail->ClearAttachments();
								//$mail->AddAttachment("images/phpmailer.gif");             // attachment
								
								if(!$mail->Send()) {
								  //$MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo; 
								} else {
								  //$MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в GoZbiTe.Com.</span><br />";
								}
							
							}
							
						}
						// ================================= KRAI na MAIL-a =========================================
			
		    }
	    }
	    else 
	    {
	        $comment .= '<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href=\'разгледай-рецепта-'.$_REQUEST['recipeID'].','.myTruncateToCyrilic(get_recipe_nameByRecipeID($_REQUEST['recipeID']),200,'_','').'.html\';</script> ';
	       
	    }
	 }
   }
   else 
   {
	    $comment .= '<script type="text/javascript">alert("Не сте попълнили Кода за сигурност!");window.location.href=\'разгледай-рецепта-'.$_REQUEST['recipeID'].','.myTruncateToCyrilic(get_recipe_nameByRecipeID($_REQUEST['recipeID']),200,'_','').'.html\';</script> ';
	   
	}
   
}



return $comment;

?>