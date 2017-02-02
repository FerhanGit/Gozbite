<?php
ini_set('max_execution_time', '5750');
ini_set('memory_limit','512M');
	//header('Content-type: text/html;charset=utf-8');

		ini_set('display_errors', 1);
		error_reporting(E_ALL);

	//======================================================================================================================================================================
	//	Задаваме в GET параметрите 2 параметъра - cat_id (int)  и id (int), където cat_id е ID от таблицата recipe_category , а id е "rec" параметъра от сайта vkusnotijki
	//======================================================================================================================================================================

   	require_once("../includes/header.inc.php");
	require_once('../includes/classes/Snoopy.class.php');



	function download_url($url)
	{
	   	//echo "<br>Downloading $url";
	   	//return;
	   	$fragments=parse_url($url);
	   	$snoopy = new Snoopy();
	   	$snoopy->read_timeout=30;
	   	$snoopy->agent="Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)";
	  	$snoopy->referer=$fragments['scheme'].'://'.$fragments['host'].'/';
	   	$snoopy->fetch($url);
	   	if ($snoopy->status < 200 || $snoopy->status >= 300)
	       return null;
	   	return $snoopy->results;
	}

	function ExtractString($str, $start, $end)
	{
		$str_low = strtolower($str);
		$pos_start = strpos($str_low, $start);
		$pos_end = strpos($str_low, $end, ($pos_start + strlen($start)));
		if ( ($pos_start !== false) && ($pos_end !== false) )
		{
			$pos1 = $pos_start + strlen($start);
			$pos2 = $pos_end - $pos1;
			return substr($str, $pos1, $pos2);
		}
	}


	$test 				= $_GET['test'];
	$pg 				= $_GET['pg'];
	$rs 				= $_GET['rs'] ? $_GET['rs'] : 0;
	$cat_id				= $_GET['gozbite_cat'];

		$page_url 	= 'http://receptite.co.cc/articles.php?cat_id='.$_GET['receptite_cat'].'&rowstart='.$rs ;



  	if($page_url == '' OR empty($_GET['receptite_cat']) OR empty($_GET['gozbite_cat']))
	{
		print "Няма зададена страница";
		exit;
	}


 	//$SBA_URL = 'http://vkusnotiiki.net/recipe.php?rec='.$item_id;
	$SBA_URL = $page_url;
 	$tags = '';






$patna_obstanovka = download_url($SBA_URL);
//$patna_obstanovka = trim(iconv('windows-1251','UTF-8',$patna_obstanovka));

$res=split('<body>',$patna_obstanovka);
$patna_obstanovka = $res[1];
$patna_obstanovka = str_replace('</body>','',$patna_obstanovka);
$patna_obstanovka = str_replace('</html>','',$patna_obstanovka);
//preg_match_all('/<div class=\"fraza_txt\">(.*?)<a(.*?)>(.*?)<\/a>(.*?)/is', $patna_obstanovka, $matches);

preg_match_all("/<td width='350'>(.*?)<a href=\'([^>].*?)\'>/is", $patna_obstanovka, $matches);
//$patna_obstanovka2 = ExtractString($patna_obstanovka, '<td width=\'350\'>', '</td>');
//$patna_obstanovka2 = removeBadTags($patna_obstanovka2);		// Remove Bad tags from text
$matches5 = array_slice($matches[2],1);

foreach($matches5 as $matches2)
{
	$matches3=explode("'",$matches2);

	$SBA_URL = 'http://receptite.co.cc/'.$matches3[0];

	$patna_obstanovkaR = download_url($SBA_URL);
	//$patna_obstanovka = trim(iconv('windows-1251','UTF-8',$patna_obstanovka));

	$resR=split('<body>',$patna_obstanovkaR);
	$patna_obstanovkaR = $resR[1];
	$patna_obstanovkaR = str_replace('</body>','',$patna_obstanovkaR);
	$patna_obstanovkaR = str_replace('</html>','',$patna_obstanovkaR);

	preg_match_all("/<div align=\'center\'><h1>(.*?)<\/h1>(.*?)<img src=\'(.*?)\'(.*?)<strong>(.*?)<\/strong>(.*?)<u>Начин на приготвяне:<\/u><br \/>(.*?)<\/td>(.*?)<\/table>/is", $patna_obstanovkaR, $matchesR);





$title = $matchesR[1][0];
$nachin = $matchesR[7][0];

$produkti = str_replace('</br>','<br>',$matchesR[5][0]);
$produkti = str_replace('<br/>','<br>',$produkti);
$produkti = str_replace('<br />','<br>',$produkti);
$produktiArr = split('<br>',$produkti); // ================ PRODUKTITE ==================== //



  $sql = "SELECT tags FROM `recipe_tags` WHERE 1 ORDER BY RAND() LIMIT 5000";
  $conn->setsql($sql);
  $conn->getTableRows();
  $resultsTags = $conn->result;
  $tags = '';
  foreach ($resultsTags as $rezArr)
  {
  	 $tags .= str_replace(',,',',',implode(',',$rezArr)).',';
  }


  $tagsArr1 = explode(',',$tags);

  $tagsArr = array_unique($tagsArr1);

  if(empty($title)) continue;

  	$sql = sprintf("INSERT INTO recipes SET title = '%s',
                                   			 user_id = 1,
                                   			  info = '%s',
                                   			   active = '1',
                                               	updated_by = 1,
                                   				 updated_on = NOW(),
                                            	  registered_on = NOW()
                                         		   ON DUPLICATE KEY UPDATE
                                                    active = '1',
                                     		         updated_on = NOW()
		                                       		  ",
		    										   $title,
		                                                $nachin);


     $conn->setsql($sql);
     $lastID = $conn->insertDB();

		if($conn->error) {
			for(reset($conn->error); $key = key($conn->error); next($conn->error)) {
			   $Error["SQL ERROR ClssOffrCrt-".$key] = $conn->error[$key];
			}
		 }


	  if($lastID > 0)
	  {

	  		$sql="INSERT INTO recipes_category_list SET category_id='".$cat_id."' , recipe_id='".$lastID."' ON DUPLICATE KEY UPDATE category_id='".$cat_id."' , recipe_id='".$lastID."'";
			$conn->setsql($sql);
			$conn->insertDB();

			if($conn->error) {
				for(reset($conn->error); $key = key($conn->error); next($conn->error)) {
				   $Error["SQL ERROR ClssOffrCrt-".$key] = $conn->error[$key];
				}
			 }

			$sql = sprintf("INSERT INTO kuhni_list SET recipe_id = %d, kuhnq_id = 1", $lastID);
		    $conn->setsql($sql);
		    $conn->insertDB();

			if($conn->error) {
				for(reset($conn->error); $key = key($conn->error); next($conn->error)) {
				   $Error["SQL ERROR ClssOffrCrt-".$key] = $conn->error[$key];
				}
			 }

		$tagsToInsertArr = array();

	  	foreach ($produktiArr as $productItem)
	  	{
	  		if(empty($productItem)) continue;

			$productItem = strip_tags($productItem);

           	$sql = sprintf("INSERT INTO recipes_products SET recipe_id = %d, product = '%s' ON DUPLICATE KEY UPDATE date = NOW()",$lastID, trim($productItem));
           	$conn->setsql($sql);
           	$conn->insertDB();

			if($conn->error) {
				for(reset($conn->error); $key = key($conn->error); next($conn->error)) {
				   $Error["SQL ERROR ClssOffrCrt-".$key] = $conn->error[$key];
				}
			 }

	  		foreach ($tagsArr as $tagItem)
  			{
  				if(empty($tagItem)) continue;

		  		// Tuk slagame Koda za INSERT na producti
		  		if(eregi($tagItem, $productItem))
		  		{
		  			$tagsToInsertArr[] = trim($tagItem);
		  		}
		  	}
  		}



		         //**************************************** Качваме Таговете **************************************
		         if(!empty($tagsToInsertArr))
		         {
		         	$tagsToInsertArr = array_unique($tagsToInsertArr);

		         	 $tagsToInsert = implode(',',$tagsToInsertArr);
		         	if(!empty($tagsToInsert))
					{
						 $sql = sprintf("INSERT INTO recipe_tags SET tags = '%s',
																	  recipeID = %d
																	   ON DUPLICATE KEY UPDATE
																		tags = '%s',
																		 recipeID = %d
																		 ",
																		trim($tagsToInsert),
																	   $lastID,
																	  trim($tagsToInsert),
																	 $lastID);
							$conn->setsql($sql);
							$conn->insertDB();
							 if($conn->error) {
								for(reset($conn->error); $key = key($conn->error); next($conn->error)) {
								   $Error["SQL ERROR ClssOffrCrt-".$key] = $conn->error[$key];
								}
							 }
					}
		         }

		         //***********************************************************************************************



		if(count($matchesR[3])>0  && sizeof($matchesR[3][0])>10)
	 	{

		 	// --------------------Vkarva snimkite --------------------------------

		 	$file = $matchesR[3][0];


			$counter = 1;

			$uploaddir = "../pics/recipes/";
			$uploadfile = $file;

			$pic_file=get_pic_name($uploadfile,$uploaddir, $lastID."_".$counter.".jpg","500");
			$tumbnail=get_pic_name($uploaddir.$pic_file,$uploaddir, $lastID."_".$counter."_thumb.jpg","80");



                  $sql = sprintf("INSERT INTO recipe_pics SET url_big = '%s',
		      												   url_thumb = '%s',
		      												    recipeID = %d
		      												ON DUPLICATE KEY UPDATE
		      												    url_big = '%s',
			      											   url_thumb = '%s',
			      											  recipeID = %d
			      										     ",
		                  									 $lastID."_".$counter.".jpg",
			      											  $lastID."_".$counter."_thumb.jpg",
			      											   $lastID,
			      											   $lastID."_".$counter.".jpg",
			      											  $lastID."_".$counter."_thumb.jpg",
			      										     $lastID);
		         $conn->setsql($sql);
		         $conn->insertDB();

				if($conn->error) {
					for(reset($conn->error); $key = key($conn->error); next($conn->error)) {
					   $Error["SQL ERROR ClssOffrCrt-".$key] = $conn->error[$key];
					}
				 }


				 $has_pic = is_file('../pics/recipes/'.$lastID."_1_thumb.jpg") ? 1 : 0;

				 $sql = sprintf("UPDATE recipes SET has_pic = %d WHERE id = %d", $has_pic, $lastID);
				 $conn->setsql($sql);
				 $conn->updateDB();

				if($conn->error) {
					for(reset($conn->error); $key = key($conn->error); next($conn->error)) {
					   $Error["SQL ERROR ClssOffrCrt-".$key] = $conn->error[$key];
					}
				 }







	  }


	// =================================== SEND MAIL TO USER =========================================

						//error_reporting(E_ALL);
					error_reporting(E_STRICT);

					date_default_timezone_set('Europe/Sofia');
					//date_default_timezone_set(date_default_timezone_get());

					include_once('../includes/classes/phpmailer/class.phpmailer.php');

					$mail             = new PHPMailer();
					$mail->CharSet       = "UTF-8";
					$mail->IsSendmail(); // telling the class to use SendMail transport


					$mail->From       = "fismailov@mailjet.com";
					$mail->FromName   = "Служебен Мейл";

					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From

					$mail->WordWrap = 100;
					$mail->Subject    = "Auto Insert v GoZbiTe.Com";
					$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
					$mail->MsgHTML($Error);

					$mail->Priority = 1;
					$mail->ClearAddresses();
					$mail->AddAddress('fismailov@mailjet.com');

					//$mail->ClearAttachments();
					//$mail->AddAttachment("images/phpmailer.gif");             // attachment

					if(!$mail->Send()) {
					  echo "Грешка при изпращане: " . $mail->ErrorInfo;
					} else {
					  echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
					}


			print_r($Error);
			// ===============================================================================================


  }

}

		//*************************************************************************************************************************************
		// КРАЙ НА ВКАРВАНЕ НА ПЪТНАТА ОБСТАНОВКА НА СБА
		//*************************************************************************************************************************************



?>