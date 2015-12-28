<?php

/*
* ����� ����� �� �������� �������� , � ����� �� ������� ���� ���� - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$comment = "";
   	


// ------------------����� �� �������� �� ��������� -----------------------
   
//=========================================================
 if (isset($_REQUEST['insert_comment_btn']))
 {
 	print_r($_REQUEST);
    if(isset($_REQUEST['verificationcode'])) {
	
	include("verificationimage/verification_image.class.php");
	$image = new verification_image();
	// do this when the form is submitted
	$correct_code=false;
	if($image->validate_code($_REQUEST['verificationcode'])) 
	{		
		$correct_code=true;
		$_SESSION['verification_key']="";
		
	    if (!empty($_REQUEST['comment_body']) && $_REQUEST['postID'] > 0)
	    {
	     		 
	        if (!isset($_SESSION['valid_user'])) 
	        {
	       		$comment .= '<script type="text/javascript">alert("�� ��� ���������� �� ���� ������");window.location.href="����,����_�_���������_��_��������_������_ohboli_bg.html";</script>'; 
	       		return $comment;
	        	exit;
	        }
	    	 
	    	 	    
	        $sql="INSERT INTO post_comment SET post_id='".$_REQUEST['postID']."',
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
		    	$sql="UPDATE ".(($_SESSION['user_type']=='user')?'users':(($_SESSION['user_type']=='doctor')?'doctors':'hospitals'))." SET cnt_comment = (cnt_comment+1) WHERE username='".$_SESSION['valid_user']."'";
		    	$conn->setsql($sql);
		    	$conn->updateDB();
		    	
		    	$_SESSION['cnt_comment'] ++;
		    	
		    	
		    	
		    	
		    	
		    	  // ==================================== MAIL SEND ============================================
	    	
				  		$sql="SELECT post_id, sender_name, sender_email FROM post_comment WHERE post_id = '".$_REQUEST['postID']."' GROUP BY sender_email";
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
								$body .= "��������, <b><font color='#FF6600'>".$resultCommentNew[$n]['sender_name']."</font></b>, ��� ��� �������� ������� � ������ ������ ������� �������� '".get_post_nameByPostID($_REQUEST['postID'])."', ����������� � �������� ������ ������.��!<br /><br />";
						   		
						   		 $body .= "<div style=\"width:600px; float:left; margin: 0px 0px 50px 0px;\">	
						   		 			�� �� �� ��������� ����������� ���� ���� <a href='http://gozbite.com/�������-������-".$_REQUEST['postID'].",".myTruncateToCyrilic(get_post_nameByPostID($_REQUEST['postID']),50,"_","") .".html'>��� ���������</a>.
						   					</div>";
						   		 
								 $body .= "</div>";
								 
							 
								$body  = eregi_replace("[\]",'',$body);
								
											
								$mail->From       = "office@gozbite.com";
								$mail->FromName   = "GoZBiTe.Com" ;
								
								//$mail->AddReplyTo("office@izlet.bg"); // tova moje da go zadadem razli4no ot $mail->From
								
								$mail->WordWrap = 100; 
								$mail->Subject    = "Nov otgovor na Vashiq komentar v GoZBiTe.Com";
								$mail->AltBody    = "�� �� ������ ���� �����, ���� ����������� �-���� ������, ����� �� �������� �������������� �� HTML ����������.!"; // optional, comment out and test
								$mail->MsgHTML($body);
								
								$mail->Priority = 1;
								$mail->ClearAddresses();
								$mail->AddAddress($resultCommentNew[$n]['sender_email']);
								$mail->AddAddress("office@gozbite.com");
								
								//$mail->ClearAttachments();
								//$mail->AddAttachment("images/phpmailer.gif");             // attachment
								
								if(!$mail->Send()) {
								  //$MessageText .= "������ ��� ��������� �� ��������: " . $mail->ErrorInfo; 
								} else {
								  //$MessageText .= "<br /><span>���������� ��!<br />������ ������ � ������ �������. �� ������ ���������� ��������� ������ �� �������������, � ����� ��� �� ������������ � �����.��.</span><br />";
								}
							
							}
							
						}
						// ================================= KRAI na MAIL-a =========================================
						
						
						
						
						
		    }
	    }
	    else 
	    {
	       $comment .= '<script type="text/javascript">alert("�� ��� ��������� �������������� ������!");window.location.href="�������-������-'.$_REQUEST['postID'].','.myTruncateToCyrilic(get_post_nameByPostID($_REQUEST['postID']),50,'_','') .'.html";</script>';	        
	    }
	}
   }
}
//================== ���� �� �������� �� ��������� =======================================



return $comment;

?>