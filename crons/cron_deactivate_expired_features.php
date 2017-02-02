<?php

//========================================================================================================================
//	Този скрипт се извиква от CRON-а всеки ден е 24:00 ч. и служи за деактивиране на старите фичъри,
//	както и деактивиране на специалитети с изтекъл срок на активност (Този срок се задава при публикуване на специалитета "toDate")
//========================================================================================================================

    //require_once('../includes/header.inc.php');
    require_once("/home/gozbetr3/public_html/includes/header.inc.php");

    //error_reporting(E_ALL);
    error_reporting(E_STRICT);
    date_default_timezone_set('Europe/Sofia');
    //require_once('../includes/classes/phpmailer/class.phpmailer.php');
    include_once('/home/gozbetr3/public_html/includes/classes/phpmailer/class.phpmailer.php');


  $Period = '7';

   //******************************************************************************************
   //  THIS SCRIPT RUN BY CRON AND DEACTIVATE OLD PURCHASED PACKAGES AND ALL FEATURES IN DB TABLES
   //  "FIRMS", "RECIPES", "DRINKS"
   //******************************************************************************************

   // ==================================== MAIL SEND - Уведомителен ============================================

			$mail             = new PHPMailer();
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport

			$mail_body = "<img src='http://GoZbiTe.Com/images/logce.png'><br /><br /><br /><br />";
			$mail_body .= "Стартиран е Cron-а за Деактивиране на Фитчъри<br /><br />";

			$mail->From       = "fismailov@mailjet.com";
			$mail->FromName   = "Cron.GoZbiTe.Com" ;
			$mail->WordWrap = 100;
			$mail->Subject    = "CRON STARTIRAN ";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($mail_body);

			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress("fismailov@mailjet.com");

			if(!$mail->Send()) {
			  $MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo;
			} else {
			  $MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в GoZbiTe.Com.</span><br />";
			}

	// ================================= KRAI na MAIL-a =========================================



	// Specialiteti Recepti

  	    $sql = "SELECT id FROM recipes WHERE is_Featured = 1 AND is_Featured_end < NOW()";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultExpiredFeaturedRecipes = $conn->result;
		$numExpiredFeaturedRecipes = $conn->numberrows;
		if($numExpiredFeaturedRecipes > 0)
		{
			for($i = 0; $i < $numExpiredFeaturedRecipes; $i++)
			{
				//**************************************** USERS ********************************************

				if($resultExpiredFeaturedRecipes[$i]['id'] > 0)
				{
					$sql = "UPDATE recipes SET is_Featured = '0' WHERE id ='".$resultExpiredFeaturedRecipes[$i]['id']."'";
					$conn->setsql($sql);
					$conn->updateDB();


					// ==================================== MAIL SEND ============================================

							$mail             = new PHPMailer();
							$mail->CharSet       = "UTF-8";
							$mail->IsSendmail(); // telling the class to use SendMail transport

							$mail_body = "<img src='http://GoZbiTe.Com/images/logce.png'><br /><br /><br /><br />";


							$mail_body .= "Деактивирана е рецепта-специалитет <strong>".get_recipe_nameByRecipeID($resultExpiredFeaturedRecipes[$i]['id'])."</strong>:<br /><br />";



							$mail->From       = "fismailov@mailjet.com";
							$mail->FromName   = "Cron.GoZbiTe.Com" ;

							//$mail->AddReplyTo("office@gozbite.com"); // tova moje da go zadadem razli4no ot $mail->From

							$mail->WordWrap = 100;
							$mail->Subject    = "Deaktivirana Recepta-Specialitet  ".get_recipe_nameByRecipeID($resultExpiredFeaturedRecipes[$i]['id']);
							$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
							$mail->MsgHTML($mail_body);

							$mail->Priority = 1;
							$mail->ClearAddresses();
							$mail->AddAddress("fismailov@mailjet.com");


							if(!$mail->Send()) {
							  $MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo;
							} else {
							  $MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в GoZbiTe.Com.</span><br />";
							}


					// ================================= KRAI na MAIL-a =========================================


				}

			}
		}

	// Specialiteti Napitki

		$sql = "SELECT id FROM drinks WHERE is_Featured = 1 AND is_Featured_end < NOW()";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultExpiredFeaturedDrinks = $conn->result;
		$numExpiredFeaturedDrinks = $conn->numberrows;
		if($numExpiredFeaturedDrinks > 0)
		{
			for($i = 0; $i < $numExpiredFeaturedDrinks; $i++)
			{
				if($resultExpiredFeaturedDrinks[$i]['id'] > 0)
				{
					$sql = "UPDATE drinks SET is_Featured = '0' WHERE id ='".$resultExpiredFeaturedDrinks[$i]['id']."'";
					$conn->setsql($sql);
					$conn->updateDB();


					// ==================================== MAIL SEND ============================================


							$mail             = new PHPMailer();
							$mail->CharSet       = "UTF-8";
							$mail->IsSendmail(); // telling the class to use SendMail transport

							$mail_body = "<img src='http://GoZbiTe.Com/images/logce.png'><br /><br /><br /><br />";


							$mail_body .= "Деактивирана е напитка-специалитет <strong>".get_drink_nameByDrinkID($resultExpiredFeaturedDrinks[$i]['id'])."</strong>:<br /><br />";



							$mail->From       = "fismailov@mailjet.com";
							$mail->FromName   = "Cron.GoZbiTe.Com" ;

							//$mail->AddReplyTo("office@gozbite.com"); // tova moje da go zadadem razli4no ot $mail->From

							$mail->WordWrap = 100;
							$mail->Subject    = "Deaktivirana Napitka-Specialitet  ".get_drink_nameByDrinkID($resultExpiredFeaturedDrinks[$i]['id']);
							$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
							$mail->MsgHTML($mail_body);

							$mail->Priority = 1;
							$mail->ClearAddresses();
							$mail->AddAddress("fismailov@mailjet.com");


							if(!$mail->Send()) {
							  $MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo;
							} else {
							  $MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в GoZbiTe.Com.</span><br />";
							}


					// ================================= KRAI na MAIL-a =========================================


				}

			}
		}



// VIP FIRMI

		$sql = "SELECT id FROM firms WHERE is_VIP = 1 AND is_VIP_end < NOW()";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultExpiredVIPFirms = $conn->result;
		$numExpiredVIPFirms = $conn->numberrows;
		if($numExpiredVIPFirms > 0)
		{
			for($i = 0; $i < $numExpiredVIPFirms; $i++)
			{
				if($resultExpiredVIPFirms[$i]['id'] > 0)
				{
					$sql = "UPDATE firms SET is_VIP = '0' WHERE id ='".$resultExpiredVIPFirms[$i]['id']."'";
					$conn->setsql($sql);
					$conn->updateDB();


					// ==================================== MAIL SEND ============================================

							$mail             = new PHPMailer();
							$mail->CharSet       = "UTF-8";
							$mail->IsSendmail(); // telling the class to use SendMail transport

							$mail_body = "<img src='http://GoZbiTe.Com/images/logce.png'><br /><br /><br /><br />";


							$mail_body .= "Деактивирана е VIP фирма <strong>".get_firm_nameByFirmID($resultExpiredVIPFirms[$i]['id'])."</strong>:<br /><br />";



							$mail->From       = "fismailov@mailjet.com";
							$mail->FromName   = "Cron.GoZbiTe.Com" ;

							//$mail->AddReplyTo("office@gozbite.com"); // tova moje da go zadadem razli4no ot $mail->From

							$mail->WordWrap = 100;
							$mail->Subject    = "Deaktivirana VIP FIRMA  ".get_firm_nameByFirmID($resultExpiredVIPFirms[$i]['id']);
							$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
							$mail->MsgHTML($mail_body);

							$mail->Priority = 1;
							$mail->ClearAddresses();
							$mail->AddAddress("fismailov@mailjet.com");


							if(!$mail->Send()) {
							  $MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo;
							} else {
							  $MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в GoZbiTe.Com.</span><br />";
							}


					// ================================= KRAI na MAIL-a =========================================


				}

			}
		}






// Featured FIRMI

		$sql = "SELECT id FROM firms WHERE is_Featured = 1 AND is_Featured_end < NOW()";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultExpiredFeaturedFirms = $conn->result;
		$numExpiredFeaturedFirms = $conn->numberrows;
		if($numExpiredFeaturedFirms > 0)
		{
			for($i = 0; $i < $numExpiredFeaturedFirms; $i++)
			{
				if($resultExpiredFeaturedFirms[$i]['id'] > 0)
				{
					$sql = "UPDATE firms SET is_Featured = '0' WHERE id ='".$resultExpiredFeaturedFirms[$i]['id']."'";
					$conn->setsql($sql);
					$conn->updateDB();


					// ==================================== MAIL SEND ============================================


							$mail             = new PHPMailer();
							$mail->CharSet       = "UTF-8";
							$mail->IsSendmail(); // telling the class to use SendMail transport

							$mail_body = "<img src='http://GoZbiTe.Com/images/logce.png'><br /><br /><br /><br />";


							$mail_body .= "Деактивирана е 'На Фокус' фирма <strong>".get_firm_nameByFirmID($resultExpiredFeaturedFirms[$i]['id'])."</strong>:<br /><br />";



							$mail->From       = "fismailov@mailjet.com";
							$mail->FromName   = "Cron.GoZbiTe.Com" ;

							//$mail->AddReplyTo("office@gozbite.com"); // tova moje da go zadadem razli4no ot $mail->From

							$mail->WordWrap = 100;
							$mail->Subject    = "Deaktivirana NA FOKUS FIRMA  ".get_firm_nameByFirmID($resultExpiredFeaturedFirms[$i]['id']);
							$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
							$mail->MsgHTML($mail_body);

							$mail->Priority = 1;
							$mail->ClearAddresses();
							$mail->AddAddress("fismailov@mailjet.com");


							if(!$mail->Send()) {
							  $MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo;
							} else {
							  $MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в GoZbiTe.Com.</span><br />";
							}


					// ================================= KRAI na MAIL-a =========================================


				}

			}
		}





		//*************************************************************************************************************************************
		// КРАЙ
		//*************************************************************************************************************************************



?>