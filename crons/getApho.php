<?php
	header('Content-type: text/html;charset=utf-8');
		
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
	//$pg_max_per_insert	= $_GET['pg'] + 10;
	
	$pg_max_per_insert = 830;
	
	while($pg <= $pg_max_per_insert)
	{
		$page_url 	= 'http://fb-like-bg.info/index.php?p='.$pg;
  	
  
 
  	if($page_url == '') 
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

preg_match_all('/<div class=\"fraza_txt\">(.*?)<a(.*?)>(.*?)<\/a>(.*?)/is', $patna_obstanovka, $matches);
//preg_match('/\<div class\=[\"]{0,1}fraza[\"]{0,1}\>(.*?)\<\/div\>/s', $patna_obstanovka, $matches);


foreach($matches[3] as $aphorism)
{
	if (isset($aphorism) && ($aphorism != ""))
	{
	                
    	$body = removeBadTags($aphorism);		// Remove Bad tags from text
			
    								                
    	print $body."<br />\n";	
    	
    	$sql = sprintf("INSERT INTO aphorisms SET title = '%s',
                                             	 body = '%s',
                                             	 autor_type = '%s',
                                             		 autor = '%d',
                                             		  active = '1',
                                             		    date = NOW()
                                             	
                                             ON DUPLICATE KEY UPDATE
                                             
                                             	  autor_type = '%s',
                                                 autor = '%d',
                                                active = '1'
                                              ",    	
    										  'GoZbiTe.Com',
								               $body,
								                'user',
								             	   1,	
								             	   'user',
								               1								             			
								             );
								                                 
         if($test <> 1)  
         {                       
	       //  $conn->setsql($sql);
	       //  $lastID = $conn->insertDB();
         }

	}
        
} 
 $pg++;
 
}
   
?>