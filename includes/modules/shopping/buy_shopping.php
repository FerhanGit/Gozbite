<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$shopping_buy = "";
   	
	
if(!empty($_REQUEST['buy_package']))
{
	$ID=$_REQUEST['buy_package'];
	
	
	$sql="INSERT INTO purchased_packages SET company_id='".(($_SESSION['user_type']=='hospital')?$_SESSION['userID']:'')."',
									 doctor_id='".(($_SESSION['user_type']=='doctor')?$_SESSION['userID']:'')."',
									 package_id='".$ID."',
									 is_payed='".(($_REQUEST['credits']>0)?1:0)."',
									 used_credits = '".(($_REQUEST['credits']>0)?$_REQUEST['credits']:0)."',
									 active='1',
									 start_date = NOW(),
									 end_date = (NOW() + INTERVAL ".$_REQUEST['time']." MONTH)
										 
									 ON DUPLICATE KEY UPDATE
									 company_id='".(($_SESSION['user_type']=='hospital')?$_SESSION['userID']:'')."',
									 doctor_id='".(($_SESSION['user_type']=='doctor')?$_SESSION['userID']:'')."',
									 package_id='".$ID."',
									 used_credits = '".(($_REQUEST['credits']>0)?$_REQUEST['credits']:0)."',
									 active='1'
									 "; 
	
	$conn->setsql($sql);
	$conn->insertDB();
	
	
	$is_VIP_Featured_end = "(NOW() + INTERVAL ".$_REQUEST['time']." MONTH)";
	   
		     
	// ----- Update-va dannite za Fakturata --------------------------------------------------------------------------------
			$sql="UPDATE ".(($_SESSION['user_type']=='hospital')?'hospitals':(($_SESSION['user_type']=='doctor')?'doctors':''))." SET mol='".$_REQUEST['mol']."' , bulstat='".$_REQUEST['bulstat']."' WHERE id='".$_SESSION['userID']."'"; 		
			$conn->setsql($sql);
			$conn->updateDB();			
	// ---------------------------------------------------------------------------------------------------------------------
	
	
	// ----- Update-va GOLD and SILVER  --------------------------------------------------------------------------------
			$sql="UPDATE ".(($_SESSION['user_type']=='hospital')?'hospitals':(($_SESSION['user_type']=='doctor')?'doctors':''))." SET is_Gold='".isGold($ID)."' , is_Silver='".isSilver($ID)."', is_VIP='".isVIP($ID)."', is_VIP_end=".(isVIP($ID) == 1 ? $is_VIP_Featured_end : "''").", is_Featured='".isFeatured($ID)."', is_Featured_end=".(isFeatured($ID) == 1 ? $is_VIP_Featured_end : "''")." WHERE id='".$_SESSION['userID']."'"; 		
			$conn->setsql($sql);
			$conn->updateDB();			
	// ---------------------------------------------------------------------------------------------------------------------
	if($_REQUEST['credits']>0)
	{
	// ----- Update-va izpolzvanite krediti na potrebitelq --------------------------------------------------------------------------------
			$sql="UPDATE ".(($_SESSION['user_type']=='hospital')?'hospitals':(($_SESSION['user_type']=='doctor')?'doctors':(($_SESSION['user_type']=='user')?'users':'')))." SET used_credits = (used_credits + ".(($_REQUEST['credits']>0)?$_REQUEST['credits']:0).") WHERE id='".$_SESSION['userID']."'"; 		
			$conn->setsql($sql);
			$conn->updateDB();	
			
			$_SESSION['used_credits'] += $_REQUEST['credits'];		
	// ---------------------------------------------------------------------------------------------------------------------
	}
	
	// ==================================== MAIL SEND ============================================
	
			//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('includes/classes/phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			//$body             = $mail->getFile('contents.html');
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			$body ="<div style=\"width:800px; \">";
			$body .= "Уважаеми, <b><font color='#FF6600'>".$_SESSION['name']."</font></b>, Вие си купихте:<br /><br />";
	   		$body .= "<div style=\"width:600px; float:left;\">
				   <div align=\"center\" style=\"float:left;width:120px; height:40px;margin:2px 2px 2px 2px;padding:5px;background-color:#FF6600;font-weight:900;color:#FFFFFF\">Пакет</div>
				   <div align=\"center\" style=\"float:left;width:120px; height:40px;margin:2px 2px 2px 2px;padding:5px;background-color:#FF6600;font-weight:900;color:#FFFFFF\">За период от</div>   
				   <div align=\"center\" style=\"float:left;width:120px; height:40px;margin:2px 2px 2px 2px;padding:5px;background-color:#FF6600;font-weight:900;color:#FFFFFF\">Цена на пакета</div>
				   <div align=\"center\" style=\"float:left;width:120px; height:40px;margin:2px 2px 2px 2px;padding:5px;background-color:#FF6600;font-weight:900;color:#FFFFFF\">Използвани Кредити</div>
				</div>";
				
	   		$body .= "<div style=\"width:600px; float:left; \">	
								<div align=\"center\" style=\"float:left;width:120px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:".$bgcolor.";font-weight:900;color:#FF6600\">".$_REQUEST['package_name']."</div>
								<div align=\"center\" style=\"float:left;width:120px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:".$bgcolor.";font-weight:900;color:#FF6600\">".$_REQUEST['time']." месеца</div>
								<div align=\"center\" style=\"float:left;width:120px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:".$bgcolor.";font-weight:900;color:#FF6600\">".$_REQUEST['price']." лв.</div>
								<div align=\"center\" style=\"float:left;width:120px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:".$bgcolor.";font-weight:900;color:#FF6600\">".($_REQUEST['credits']>0?$_REQUEST['credits']:0)." бр.</div>
							</div>";
	   		
	   		
	   		
	   		
//	   		$body .= "<div style=\"width:800px; float:left; margin: 50px 0px 0px 0px;\">	
//							<div align=\"center\" style=\"float:left;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#FF6600;font-weight:900;color:#FFFFFF\">Въведохте следните данни за фактурата:</div>				
//						</div>
//						<div style=\"width:800px; float:left; margin: 10px 0px 0px 0px;\">	
//									<div align=\"center\" style=\"float:left;width:150px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600\">Име на Фирмата:</div>
//									<div align=\"center\" style=\"float:left;width:150px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600\">Адрес по Регистрация:</div>
//									<div align=\"center\" style=\"float:left;width:150px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600\">Булстат:</div>
//									<div align=\"center\" style=\"float:left;width:150px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600\">МОЛ:</div>
//						</div>
//						<div style=\"width:800px; float:left; margin: 0px 0px 50px 0px;\">	
//									<div align=\"center\" style=\"float:left;width:150px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600\">".$_SESSION['name']."</div>
//									<div align=\"center\" style=\"float:left;width:150px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600\">".$_REQUEST['address']."</div>
//									<div align=\"center\" style=\"float:left;width:150px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600\">".$_REQUEST['bulstat']."</div>
//									<div align=\"center\" style=\"float:left;width:150px;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600\">".$_REQUEST['mol']."</div>
//						</div>						
//						";
	   		
	   		 $body .= "<div style=\"width:800px; float:left; margin: 0px 0px 50px 0px;\">	
	   		 			Вашият пакет ще бъде активиран незабавно".($_REQUEST['credits'] == 0?', щом бъде заплатена себестойността му ('.$_REQUEST['price'].' лв.)':'')."!<br /><br />
	   		 			Сметка за банков превод - <br /> 
						IBAN: BG45 CECB 9790 1078 9489 00<br />  
						BIC: CECBBGSF<br />
						Централна Кооперативна Банка<br /><br />

	   		 			За повече информация или въпроси Ви молим да се свържете с екипа на <a href='http://ohboli.bg/разгледай-страница-feedback,задайте_въпрос_напишете_коментар_препоръка_или_мнение.html'>оХБоли.Бг</a>.
	   					</div>";
	   		 
			 $body .= "</div>";
			 
		 
			$body  = eregi_replace("[\]",'',$body);
			
						
			$mail->From       = "ohboli@ohboli.bg";
			$mail->FromName   = "Marketing.oHBoli.Bg" ;
			
			//$mail->AddReplyTo("ohboli@ohboli.bg"); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Пакет от оХБоли.Бг";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress($_SESSION['user_email']);
			$mail->AddAddress("ohboli@ohboli.bg");
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!$mail->Send()) {
			  $MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo; 
			} else {
			  $MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в оХБоли.Бг.</span><br />";
			}
		

	// ================================= KRAI na MAIL-a =========================================
	
		   
		    
	}


return $shopping_buy;

?>