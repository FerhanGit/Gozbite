<?php
	ini_set('max_execution_time', '5750');
ini_set('memory_limit','256M');

	
	require_once("../functions.php");
	require_once("../config.inc.php");
	require_once("../bootstrap.inc.php");
   
   	$conn = new mysqldb();
  
   
   
   
   define("PUBLICLOGOSURL", "http://GoZbiTe.Com/pics/aphorisms/");
   define("UPLOADIMGDIR", realpath(dirname(__FILE__).'/..')."/pics/aphorisms/");

  
   
   	$sql = sprintf("SELECT last_insert_date FROM aphorisms_last_insert");
	$conn->setsql($sql);
	$conn->getTableRow();
	$result_last_date   = $conn->result;	
   
   
   
	$conn =  new mysqldb();							    
	
// -------------------------------- SELECT na vsi4ki Статии без тези от категория "Пътна Обстановка" ---------------------------------------	
	$sql = sprintf("SELECT * FROM aphorisms WHERE active = '1' ORDER BY date DESC LIMIT 30000 ");	
    $conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	
	
	$dom = new DOMDocument('1.0','windows-1251');
	$aphorisms = $dom->createElement('aphorisms');
	$dom->appendChild($aphorisms);
// ------------------------------------------------------------------------------------------------		

	for ($i=0; $i<$nums; $i++)
	{
		if(strtotime($result_last_date) > strtotime($result[$i]['date'])) 
		{			
			continue; // Прескачаме тези афоризми, които са с дата по-стара от последно вкараните!
		}
		
		
// --------------------------------- Offer-TAG ---------------------------------------------------
		$aphorism= $dom->createElement('aphorism');
		$aphorisms->appendChild($aphorism);
// ------------------------------------------------------------------------------------------------			
		

		
// -------------------------------------- Estate_Type-TAG -----------------------------------------			
		$image=$dom->createElement('image');
		$aphorism->appendChild($image);
			
			
		//$offrPc = "http://GoZbiTe.Com/pics/aphorisms/".$result[$i]["picURL"];

		if(is_file('../../pics/aphorisms/'.$result[$i]["picURL"])) $picFile= 'http://GoZbiTe.Com/pics/aphorisms/'.$result[$i]["picURL"];
	   else $picFile = 'http://GoZbiTe.Com/pics/aphorisms/no_photo_big.jpg';
	   
	  			
			$MainPicFile = $picFile;								
		
			    
		$image_value=$dom->createTextNode($MainPicFile);
		$image->appendChild($image_value);
		
// ------------------------------------------------------------------------------------------------			
		
// --------------------------------------- Region-TAG ---------------------------------------------			
		$index = explode(".",$result[$i]["picURL"]); 
		//$offrPc = "http://GoZbiTe.Com/pics/aphorisms/".$index[0]."_thumb.jpg";
	   	    	
		if(is_file('../../pics/aphorisms/'.$index[0]."_thumb.jpg")) $picFileThumb= 'http://GoZbiTe.Com/pics/aphorisms/'.$index[0]."_thumb.jpg";
	    else $picFileThumb = 'http://GoZbiTe.Com/pics/aphorisms/no_photo_thumb.jpg';
	   		
			$MainPicFileThumb = $picFileThumb;								
		
		$thumb=$dom->createElement('thumb');
		$aphorism->appendChild($thumb);
		$thumb_value=$dom->createTextNode($MainPicFileThumb);
		$thumb->appendChild($thumb_value);
// ------------------------------------------------------------------------------------------------			
		
// ----------------------------------------- Price-TAG --------------------------------------------				
		$story_title=$dom->createElement('source');
		$aphorism->appendChild($story_title);
		$title = str_replace('</p>','',$result[$i]['title']);
		$title = str_replace('<p>','',$title);
		$story_title_value= $dom->createTextNode($title);
		$story_title->appendChild($story_title_value);
// ------------------------------------------------------------------------------------------------			
		
// ------------------------------------------ Sqm-TAG ---------------------------------------------
		$description=$dom->createElement('body');
		$aphorism->appendChild($description);
		$descr = str_replace('</p>','',$result[$i]['body']);
		$descr = str_replace('<p>','',$descr);
		$descr = strip_tags($descr);
		$description_value=$dom->createCDATASection($descr);
		$description->appendChild($description_value);
// ------------------------------------------------------------------------------------------------				


	
// ------------------------------------------ Sqm-TAG ---------------------------------------------
		
		$date=$dom->createElement('date');
		$aphorism->appendChild($date);
		$date_value=$dom->createTextNode($result[$i]['date']);
		$date->appendChild($date_value);
// ------------------------------------------------------------------------------------------------				
	
	
// ------------------------------------------ Sqm-TAG ---------------------------------------------
		
		$unix_time=$dom->createElement('unix_time');
		$aphorism->appendChild($unix_time);
		$unix_time_value=$dom->createTextNode(strtotime($result[$i]['date']));
		$unix_time->appendChild($unix_time_value);
// ------------------------------------------------------------------------------------------------				
		
	}
	
	// Update-ваме датата на последния експорт.

		 $sql = "UPDATE aphorisms_last_insert SET last_insert_date = NOW()";
         $conn->setsql($sql);
	 	 $conn->updateDB(); 
	   

	header('Content-Type: application/xml');
	$dom->formatOutput = true;
	print $dom->saveXML();
	//$dom->save('aphorisms.xml');
	
	?>