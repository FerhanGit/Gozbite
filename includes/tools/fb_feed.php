<?php

	//error_reporting(E_ALL);
   	//ini_set('display_errors', 1);
   	
   	ini_set('max_execution_time', '1750');
	
	require_once("../functions.php");
	require_once("../config.inc.php");
	require_once("../bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
   
   	define("PUBLICLOGOSURL", "http://gozbite.com/pics/posts/");
   	define("UPLOADIMGDIR", realpath(dirname(__FILE__).'/..')."/pics/posts/");

  
      
					    
	
// -------------------------------- SELECT na vsi4ki Oferti ---------------------------------------	
	$sql = sprintf("SELECT * FROM posts WHERE picURL <> '' AND active = '1' ORDER BY date DESC LIMIT 5");
	
    $conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	
	
	$dom = new DOMDocument('1.0','windows-1251');
	$posts = $dom->createElement('posts');
	$dom->appendChild($posts);
// ------------------------------------------------------------------------------------------------		

	for ($i=0;$i<$nums;$i++)
	{
		
// --------------------------------- Offer-TAG ---------------------------------------------------
		$post= $dom->createElement('post');
		$posts->appendChild($post);
// ------------------------------------------------------------------------------------------------			
		

		
// -------------------------------------- Estate_Type-TAG -----------------------------------------			
		$image=$dom->createElement('image');
		$post->appendChild($image);
			
			
		//$offrPc = "http://ohboli.bg/pics/posts/".$result[$i]["picURL"];

		if(is_file('pics/posts/'.$result[$i]["picURL"])) $picFile= 'pics/posts/'.$result[$i]["picURL"];
	   else $picFile = 'pics/posts/no_photo_big.png';
	   
	  			
			$MainPicFile = $picFile;								
		
			    
		$image_value=$dom->createTextNode($MainPicFile);
		$image->appendChild($image_value);
		
// ------------------------------------------------------------------------------------------------			
		
// --------------------------------------- Region-TAG ---------------------------------------------			
		$index = explode(".",$result[$i]["picURL"]); 
		//$offrPc = "http://ohboli.bg/pics/posts/".$index[0]."_thumb.jpg";
	   	    	
		if(is_file('pics/posts/'.$index[0]."_thumb.jpg")) $picFileThumb= 'pics/posts/'.$index[0]."_thumb.jpg";
	    else $picFileThumb = 'pics/posts/no_photo_thumb.png';
	   		
			$MainPicFileThumb = $picFileThumb;								
		
		$thumb=$dom->createElement('thumb');
		$post->appendChild($thumb);
		$thumb_value=$dom->createTextNode($MainPicFileThumb);
		$thumb->appendChild($thumb_value);
// ------------------------------------------------------------------------------------------------			
		
// ----------------------------------------- Price-TAG --------------------------------------------				
		$story_title=$dom->createElement('story_title');
		$post->appendChild($story_title);
		$title = str_replace('</p>','',$result[$i]['title']);
		$title = str_replace('<p>','',$title);
		$story_title_value= $dom->createTextNode($title);
		$story_title->appendChild($story_title_value);
// ------------------------------------------------------------------------------------------------			
		
// ------------------------------------------ Sqm-TAG ---------------------------------------------
		$description=$dom->createElement('description');
		$post->appendChild($description);
		$descr = str_replace('</p>','',$result[$i]['body']);
		$descr = str_replace('<p>','',$descr);
		$description_value=$dom->createTextNode($descr);
		$description->appendChild($description_value);
// ------------------------------------------------------------------------------------------------				
		
	
// ------------------------------------------ Link-TAG ---------------------------------------------
		$link=$dom->createElement('link');
		$post->appendChild($link);
		$link4e = "http://gozbite.com/index.php?pg=posts?postID=".$result[$i]['postID'];
		$link_value=$dom->createTextNode($link4e);
		$link->appendChild($link_value);
// ------------------------------------------------------------------------------------------------				
		
		
	}
	
	

	header('Content-Type: application/xml');
	$dom->formatOutput = true;
	$dom->saveXML();
	//$dom->save('postsr.xml');
	
	?>