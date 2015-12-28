<?php
include_once("../inc/dblogin.inc.php");

	$page = $_REQUEST['page']; 
	
//=========================================================

if (!isset($_SESSION['valid_user'])) 
{
?>
	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../login.php';</script> 
<?php 
exit;
}

// -------------------------------------------------------

if ($_SESSION['user_kind']<>2)
{
?>
	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../index.php';</script> 
<?php 
exit;
}

//==========================================================



// -------------------- IMPORT -----------------------------------------

$rssFeed = $_REQUEST['import_source'];
$cntNews = $_REQUEST['import_cnt'];

if ((isset($_REQUEST['import_btn'])))
{
	
	$xml = simplexml_load_file($rssFeed, null, LIBXML_NOCDATA);

	$cnt = 0;
	foreach($xml->channel->item as $val)
	{
		$cnt++;
		if($cnt > $cntNews)
		{
			break; 
		}
			$title = $val->title; 
			$url = $val->enclosure['url'];		
			$link=(string) $val->link;				
			$description=(string) $val->description;
			$body=(string) $val->body;
			if(empty($body)) $body=$description;
			$pubDate=(string) $val->pubDate;
 
		
	
	 
	 	    
	 		$sql="INSERT INTO news SET title='".$title."',
							 	body='".addslashes($body)."',
							 	news_category='3',
							 	source='$link',
							 	autor='оХБоли.Бг',
								picURL='',
								date=NOW()
								
								ON DUPLICATE KEY UPDATE
								title='".$title."',
							 	body='".addslashes($body)."',
							 	news_category='3',
							 	source='$link',
							 	autor='оХБоли.Бг',
								picURL='',
								date=NOW()
									 							
	 							";
		 $conn->setsql($sql);
		 $last_ID=$conn->insertDB();
		 
		 

		
// ----------------- za ka4vane na snimkite ---------------------------------------
		 if (!empty($url))
		 {
			
		 	// --------------------Vkarva snimkite --------------------------------
	 		
		 	$uploaddir = "../../pics/news/";
			$uploadfile = $url;
			
			$pic_file=get_pic_name($uploadfile,$uploaddir,$last_ID.".jpg","300");           		
			$tumbnail=get_pic_name($uploaddir.$pic_file,$uploaddir,$last_ID."_thumb.jpg","60");  
		
			$sql2="UPDATE news SET picURL='".$pic_file."' WHERE newsID='".$last_ID."'";	
			$conn->setsql($sql2); 			
			$conn->updateDB();		
			
			
		  }

	  	
	} // === end FOREACH ====
	
	
}	// === end if(isset(import_btn)) ====

// --- Край на INSERT ----------------------
	 
?>

<script type="text/javascript">
       window.location.href='../edit_news.php';
</script> 
	 	 	
<?php

// -------------------- funkcii -----------------------------------------



?>