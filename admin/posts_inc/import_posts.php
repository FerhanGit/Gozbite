<?php
	
require_once("../inc/dblogin.inc.php");

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

$rssFeed=$_REQUEST['import_source'];

if ((isset($_REQUEST['import_btn'])))
{
	
	$xml=simplexml_load_file($rssFeed, null, LIBXML_NOCDATA);

	
	 	foreach($xml->channel->item as $val)
		{
		
			$title = $val->title; 
			$url = $val->enclosure['url'];		
			$link=(string) $val->link;				
			$description=(string) $val->description;
			$body=(string) $val->body;
			if(empty($body)) $body=$description;
			$pubDate=(string) $val->pubDate;
 
		
	
	 
	 	    
	 	$sql="INSERT INTO posts SET title='".$title."',
							 	body='".addslashes($body)."',
							 	post_category='49',
							 	source='$link',
							 	autor='Admin',
								picURL='',
								date=NOW()
								
								ON DUPLICATE KEY UPDATE
								title='".$title."',
							 	body='".addslashes($body)."',
							 	post_category='49',
							 	source='$link',
							 	autor='Admin',
								picURL='',
								date=NOW()
									 							
	 							";
		 $conn->setsql($sql);
		 $last_ID=$conn->insertDB();
		 
		 

		
// ----------------- za ka4vane na snimkite ---------------------------------------
	 if (!empty($url))
	 {
		
	 	// --------------------Vkarva snimkite --------------------------------
 		
	 	$uploaddir = "../../pics/posts/";
		$uploadfile = $url;
		
		$pic_file=get_pic_name($uploadfile,$uploaddir,$last_ID.".jpg","300");           		
		$tumbnail=get_pic_name($uploaddir.$pic_file,$uploaddir,$last_ID."_thumb.jpg","60");  
	
		$sql2="UPDATE posts SET picURL='".$pic_file."' WHERE postID='".$last_ID."'";	
		$conn->setsql($sql2); 			
		$conn->updateDB();		
		
	
		
	  }

	} // === end FOREACH ====
	
	
}	// === end if(isset(import_btn)) ====

// --- Край на INSERT ----------------------
	 
?>

<script type="text/javascript">
       window.location.href='../edit_posts.php';
</script> 
	 	 	
<?php

// -------------------- funkcii -----------------------------------------



?>