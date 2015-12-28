<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	require_once("includes/classes/Post.class.php");

   	$conn = new mysqldb();
   
   		
	$insert_edit_post = "";
	
	

// -------------------------------------- EDIT ----------------------------------------------------
	 
			
if (isset($_REQUEST['edit_btn']))
{
	 	
		$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		
		
	 	$post = new Post($conn);
	 	
	 	$post->id=$_REQUEST['edit'];
		 		
		$post->title			= $_REQUEST['post_title'];
		$post->body				= $_REQUEST['post_body'];		
		$post->youtube_video	= $_REQUEST['youtube_video'];		
		$post->autor 			= $_REQUEST['autor'];
		$post->autor_type 		= $_REQUEST['autor_type'];
		$post->source 			= $_REQUEST['post_source'];
		$post->tags 			= $_REQUEST['post_tags'];
		$post->post_category	= $_REQUEST['post_sub_category']?$_REQUEST['post_sub_category']:$_REQUEST['post_category'];
		$post->updated_by		= $_SESSION['userID'];
		$post->date				= 'NOW()';
			
	 
	     if($post->update($_FILES["post_pic"]))
	     
	     
	     
	      // ================================= PICS UPLOAD ==================================================
	      
	      require_once("includes/classes/Upload.class.php");
	  
	 
	      
	        if(is_array($_FILES['pics']) && (count($_FILES['pics']) > 0)) {
	            $files = array();
	            foreach ($_FILES['pics'] as $k => $l) {
	               foreach ($l as $i => $v) {
	                  if (!array_key_exists($i, $files))
	                     $files[$i] = array();
	                  $files[$i][$k] = $v;
	               }
	            }
	
	            		
	            $counter = 1;
	            
	            foreach($files as $file) {
	            	
	            	
	               $upPic = new Upload($file);
	               if ($upPic->uploaded) {
	               	
	               	  $imgBig = imagePost_MoreExists($_REQUEST['edit'],$counter,1);               	
	                  $upPic->image_convert      = 'jpg';
	                  $upPic->file_new_name_body = $imgBig;
	                  $upPic->image_resize       = true;
	                  $upPic->image_x            = 500;
	                  $upPic->image_ratio_y      = true;
	                  $upPic->file_overwrite     = true;
	                  $upPic->file_auto_rename   = false;
	                  $upPic->process('pics/posts/');
	
	                  if ($upPic->processed) {
	                  	
	                  	 $imgThumb = imagePost_MoreExists($_REQUEST['edit'],$counter,2);
	                     $upPic->image_convert      = 'jpg';
						 $upPic->file_new_name_body = $imgThumb;
	                     $upPic->image_resize       = true;
	                     $upPic->image_ratio_crop   = true;
	                     $upPic->image_y            = 60;
	                     $upPic->image_x            = 60;
	                     $upPic->file_overwrite     = true;
	                     $upPic->file_auto_rename   = false;
	                     $upPic->process('pics/posts/');
	                     if($upPic->processed) {
	                        $upPic->clean();
	                        
                        	$sql = sprintf("INSERT INTO post_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  postID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  postID = %d
	      												   ",
	      												    $imgBig.'.jpg',
	      												     $imgThumb.'.jpg',
	      												      $_REQUEST['edit'],
	      												       $imgBig.'.jpg',
	      												     	$imgThumb.'.jpg',
	      												         $_REQUEST['edit']);
				         	$conn->setsql($sql);
				         	$conn->insertDB();
				        
		                 
						 	$counter++;
	                     } 
	                     
	          			
	                     
	                  } 
	                  
	                   
	               }	
	               
	            }
	            
	         }
	         
	    // ================================= END PICS UPLOAD ==================================================
	         
	  
	   
	$insert_edit_post .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледана от администратора Вашата Статия ще бъде публикувана!\'); 
     	window.location.href=\'редактирай-статия-'.$_REQUEST['edit'].','.myTruncateToCyrilic(get_post_nameByPostID($_REQUEST['edit']),200,'_','') .'.html\';
	</script>';

		  	 
// --------------------------------------------------------------------------------
	
} // krai na edit	




// ------------------------- INSERT hospital -----------------------------------------

if (isset($_REQUEST['insert_btn']) && ($_REQUEST['post_title']!="") && ($_REQUEST['post_body']!="") && ($_REQUEST['post_category']!="") && ($_REQUEST['post_source']!=""))
{

		$_REQUEST['youtube_video'] = str_replace("watch?","",$_REQUEST['youtube_video']);
		$_REQUEST['youtube_video'] = str_replace("=","/",$_REQUEST['youtube_video']);			
		 	 	 	
	 
		$post = new Post($conn);
	 	
	 			
		$post->title			= $_REQUEST['post_title'];
		$post->body				= $_REQUEST['post_body'];		
		$post->youtube_video	= $_REQUEST['youtube_video'];		
		$post->autor 			= $_SESSION['userID'];
		$post->autor_type 		= $_SESSION['user_type'];
		$post->source 			= $_REQUEST['post_source'];
		$post->tags 			= $_REQUEST['post_tags'];
		$post->post_category	= $_REQUEST['post_sub_category']?$_REQUEST['post_sub_category']:$_REQUEST['post_category'];
		$post->updated_by		= $_SESSION['userID'];
		$post->date				= 'NOW()';
			
	    if($post->create($_FILES["post_pic"]))
	    $postID = $post->id;
	    $last_ID = $postID;
	    
	   // ================================= PICS UPLOAD ==================================================  
	    
	   require_once("includes/classes/Upload.class.php");
	  
	
	       if(is_array($_FILES['pics']) && (count($_FILES['pics']) > 0)) {
	            $files = array();
	            foreach ($_FILES['pics'] as $k => $l) {
	               foreach ($l as $i => $v) {
	                  if (!array_key_exists($i, $files))
	                     $files[$i] = array();
	                  $files[$i][$k] = $v;
	               }
	            }
	
	            		
	            $counter = 1;
	            
	            foreach($files as $file) {
	            	
	            	
	               $upPic = new Upload($file);
	               if ($upPic->uploaded) {
	               	
	               	  $imgBig = imagePost_MoreExists($last_ID,$counter,1);               	
	                  $upPic->image_convert      = 'jpg';
	                  $upPic->file_new_name_body = $imgBig;
	                  $upPic->image_resize       = true;
	                  $upPic->image_x            = 500;
	                  $upPic->image_ratio_y      = true;
	                  $upPic->file_overwrite     = true;
	                  $upPic->file_auto_rename   = false;
	                  $upPic->process('pics/posts/');
	
	                  if ($upPic->processed) {
	                  	
	                  	 $imgThumb = imagePost_MoreExists($last_ID,$counter,2);
	                     $upPic->image_convert      = 'jpg';
						 $upPic->file_new_name_body = $imgThumb;
	                     $upPic->image_resize       = true;
	                     $upPic->image_ratio_crop   = true;
	                     $upPic->image_y            = 60;
	                     $upPic->image_x            = 60;
	                     $upPic->file_overwrite     = true;
	                     $upPic->file_auto_rename   = false;
	                     $upPic->process('pics/posts/');
	                     if($upPic->processed) {
	                        $upPic->clean();
	                        
	                        $sql = sprintf("INSERT INTO post_pics 
	      												SET url_big = '%s',
	      												 url_thumb = '%s',
	      												  postID = %d
	      												   ON DUPLICATE KEY UPDATE
	      												    url_big = '%s',
		      											     url_thumb = '%s',
		      												  postID = %d
		      												   ",
		      												    $imgBig.'.jpg',
		      												     $imgThumb.'.jpg',
		      												      $last_ID,
		      												       $imgBig.'.jpg',
		      												     	$imgThumb.'.jpg',
		      												         $last_ID);
				         	$conn->setsql($sql);
				         	$conn->insertDB();
				        
		                 
						 	$counter++;
	                     } 
	                     
	          			
	                     
	                  } 
	                  
	                   	
	               }	
	               
	            }
	            
	         }
	         
	         
	     // ================================= END PICS UPLOAD ==================================================
	 
   
	$insert_edit_post .='<script type="text/javascript">
       	alert(\'Благодарим Ви! Веднага след като бъде прегледана от администратора Вашата Статия ще бъде публикувана!\'); 
     	window.location.href=\'редактирай-статия-'.$last_ID.','.myTruncateToCyrilic(get_post_nameByPostID($last_ID),200,'_','') .'.html\';
	</script>';
 
		 
}	
// --- Край на INSERT ----------------------
	 

	 


if (isset($_REQUEST['deletePic']) && isset($_SESSION['valid_user']))
{
	$post = new Post($conn);
	
	$picParts = explode(".",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$post->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$post->deletePic();	
	
		 
	$insert_edit_post .='<script type="text/javascript">
       window.location.href="редактирай-статия-'.$editID.','.myTruncateToCyrilic(get_post_nameByPostID($editID),200,'_','') .'.html";
	</script> ';
 
}



if (isset($_REQUEST['deletePicMore']) && isset($_SESSION['valid_user']))
{
	$picParts = explode("_",$_REQUEST['deletePicMore']);
	$editID=$picParts[0];
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$picIndx = $matches[0][0];
	
	
	

        
         $picFile    = $editID."_".$picIndx.".jpg";
         $thumbnail  = $editID."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('../pics/posts/'.$picFile)){    
            	           
            	@unlink('../pics/posts/'.$picFile);  
            	
            	$sql=sprintf("DELETE FROM post_pics WHERE url_big = '%s'", $picFile);
				$conn->setsql($sql);
				$conn->updateDB();                
            }
            
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('../pics/posts/'.$thumbnail)) {
            	@unlink('../pics/posts/'.$thumbnail);               
            }
         }
		
         
	
	$insert_edit_post .='<script type="text/javascript">
       window.location.href="редактирай-статия-'.$editID.','.myTruncateToCyrilic(get_post_nameByPostID($editID),200,'_','') .'.html";
	</script> ';
}




if (isset($_REQUEST['delete']) && $_REQUEST['delete'] > 0 && $_SESSION['user_kind'] == 2)
{
	$post = new Post($conn);
	
	$deleteID=$_REQUEST['delete'];
	$post->id = $deleteID; 	
	$post->load();
    $post->deletePost();	
    
	$insert_edit_post .='<script type="text/javascript">
       	alert(\'Статията беше успешно изтрита!\'); 
     	window.location.href=\'начална-страница,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html\';
	</script>';
		
}


	
if (isset($_REQUEST['deleteVideo']) && isset($_SESSION['valid_user']))
{
	$post = new Post($conn);
	$editID=$_REQUEST['deleteVideo'];
	$post->id = $editID;
		
	$post->deleteVideo();	
	
	$insert_edit_post .='<script type="text/javascript">
       window.location.href="редактирай-статия-'.$editID.','.myTruncateToCyrilic(get_post_nameByPostID($editID),200,'_','') .'.html";
	</script> ';
	
}


 	
	
	return $insert_edit_post;
	  
	?>
