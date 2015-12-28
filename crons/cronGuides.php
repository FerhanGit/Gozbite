<?php
	header('Content-type: text/html;charset=utf-8');
		
	//======================================================================================================================================================================
	//	Задаваме в GET параметрите 2 параметъра - cat_id (int)  и id (int), където cat_id е ID от таблицата recipe_category , а id е "rec" параметъра от сайта vkusnotijki
	//======================================================================================================================================================================

   	require_once("../inc/dblogin.inc.php");			
	require_once('../classes/Snoopy.class.php');			

	
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
	
	
	
	$item_id 	= (!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0);
  
  
 
  	if($item_id == 0) 
	{
		print "Няма зададени ID-та";
		exit;
	}
	
	
 	$SBA_URL = 'http://www.gotvetesmen.com/useful/products/index.php?alphabet=&pageID='.$item_id;

 	$tags = '';
			
  	   	     



$patna_obstanovka = download_url($SBA_URL); 
//$patna_obstanovka = trim(iconv('windows-1251','UTF-8',$patna_obstanovka));

$res=split('<body>',$patna_obstanovka);
$patna_obstanovka = $res[1];
$patna_obstanovka = str_replace('</body>','',$patna_obstanovka);
$patna_obstanovka = str_replace('</html>','',$patna_obstanovka);

print $patna_obstanovka;
//preg_match_all("/<table width='100%'  border='0' cellpadding='0' cellspacing='0' id='recipe'>(.*)<\/table>/i", $patna_obstanovka, $matches);
$patna_obstanovka2 = ExtractString($patna_obstanovka, '<table width="100%"  border="0" cellpadding="0" cellspacing="0" id="recipe">', '</table>');
$patna_obstanovka2 = removeBadTags($patna_obstanovka2);		// Remove Bad tags from text


$bodyto = ExtractString($patna_obstanovka2, '<td colspan="2" class="rzg2">', '<td align="left" width="80%">');	
$title2 = ExtractString($patna_obstanovka2, '<td colspan="2" class="rzg1">', '<br />');	
$title 	= str_ireplace('Рецепта за','',$title2);
$bodyto = strip_tags($bodyto,'<br /><br/></br><br>'); // Заменяме всички tr с нов ред за да има разстояние м/у редовете
$bodyto = str_replace(array('"',';','\''),array('','',''),$bodyto); 



$bodyto = $bodyto."end";
$opisanie = ExtractString($bodyto, 'Начин на приготвяне:', 'end');

if(eregi('<br /><br />', substr($opisanie,0,20))) // Proverqvame dali zapo4va s <br /><br />
{
	$opisanie = ExtractString($opisanie, '<br /><br />', '<br /><br />');
}


  $sql = "SELECT tags FROM `drink_tags` WHERE 1 ";
  $conn->setsql($sql);
  $conn->getTableRows();
  $resultsTags = $conn->result;
  foreach ($resultsTags as $rezArr)
  {
  	 $tags .= str_replace(',,',',',implode(',',$rezArr)).',';	 
  }
  
  
  $tagsArr1 = explode(',',$tags);
  $tagsArr = array_unique($tagsArr1);
  
  
  	$sql = sprintf("INSERT INTO guides SET title = '%s',
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
		                                                $opisanie);
								                  
                                   
    // $conn->setsql($sql);
    // $lastID = $conn->insertDB();
         
         
	  if($lastID > 0)
	  {
	  	
  			$tagsToInsertArr[] = trim('');
  			
	  	  		
	         //**************************************** Качваме Таговете **************************************
	         if(!empty($tagsToInsertArr))
	         {
	         	$tagsToInsertArr = array_unique($tagsToInsertArr);
	         	
	         	 $tagsToInsert = implode(',',$tagsToInsertArr);
	         	
		         $sql = sprintf("INSERT INTO guide_tags SET tags = '%s',
			      											  guideID = %d
			      											   ON DUPLICATE KEY UPDATE
			      											    tags = '%s',
				      										     guideID = %d
		      											   		 ",
		      											        $tagsToInsert,
		      											       $lastID,
		      											      $tagsToInsert,
		      											     $lastID);
		        // 	$conn->setsql($sql);
		        // 	$conn->insertDB();
	         }
	         
	         //***********************************************************************************************
     
	         
	         
	          $sql = sprintf("INSERT INTO guide_pics SET url_big = '%s',
		      												   url_thumb = '%s',
		      												    guideID = %d		
		      												ON DUPLICATE KEY UPDATE		      											
		      												    url_big = '%s',
			      											   url_thumb = '%s',
			      											  guideID = %d
			      										     ",		
		                  									 $this->id."_".$counter.".jpg",
			      											  $this->id."_".$counter."_thumb.jpg",
			      											   $this->id,		
			      											   $this->id."_".$counter.".jpg",
			      											  $this->id."_".$counter."_thumb.jpg",
			      										     $this->id);
		       //  $this->conn->setsql($sql);
		       //  $this->conn->insertDB();
		         
		         
			         
	  }
  
  		
  
	
		
		
		
		//*************************************************************************************************************************************
		// КРАЙ НА ВКАРВАНЕ НА ПЪТНАТА ОБСТАНОВКА НА СБА
		//*************************************************************************************************************************************
		
	
   
?>