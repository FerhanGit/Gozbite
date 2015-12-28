<?php
   require_once("classes/Upload.class.php");
   class Post {
      var $conn;
      var $postID;
      var $id;
      var $post_category;
      var $post_category_name;
      var $title;
      var $body;
      var $autor_type;
      var $autor;
      var $source;
      var $updated_by;
      var $updated_on;      
      var $registered_on;   
      var $postRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Post($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //post

      /*== PREPARE AND LOAD QUERY ==*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) {
            $sql = sprintf("SELECT DISTINCT(p.postID) as 'postID',
								             p.title as 'title',								             
								              p.body as 'body',
									           pc.id as 'post_category',
									            p.updated_by as 'updated_by',
										         p.updated_on as 'updated_on',
											      p.source as 'source'
											       FROM posts p,
											        AND p.postID = %d
							                         ", $this->id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->postRow = $this->conn->result;

            
            
            
            // Get Type Details
            $sql="SELECT pc.id as 'post_category_id', pc.name as 'post_category_name' FROM posts p, post_category pc, posts_category_list pcl WHERE pcl.post_id = p.postID AND pcl.category_id = pc.id AND p.postID = '".$this->postID."' ";
			$this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->post_category[$i]= $this->conn->result[$i]["post_category_id"];
                  $this->post_category_name[$i]= $this->conn->result[$i]["post_category_name"];
               }
            }
            
            
            
            

            return true;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class post: In prepareLoadQuery post_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD post DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
         	
         	
            $this->id               = $this->postRow["id"];
            $this->title       		= $this->postRow["title"];
            $this->body	   			= $this->postRow["body"];
            $this->post_category    = $this->postRow["post_category"];
            $this->source         	= $this->postRow["source"];
            $this->autor         	= $this->postRow["autor"];
            $this->autor_type       = $this->postRow["autor_type"];
            $this->updated_by       = $this->postRow["updated_by"];
            $this->updated_on      	= $this->postRow["updated_on"];
            $this->userID			= $_SESSION['userID'];
                 
           
    
         }
      } //End Load

      /*== CREATE post ==*/
      function create($upPicPost) {

      /*
      	if (!isset($this->postpost_category) || ($this->postpost_category <= 0)) {
            $this->Error["Application Error ClsspostCrtpostpost_category-Invalid Argument"] = "Class post: In create postpost_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class post: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class post: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class post: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class post: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class post: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class post: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class post: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class post: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class post: In create FUEL is not set";
            return false;
         }
	*/ 
      
      
    	$sql = sprintf("INSERT INTO posts SET title = '%s',
                                             	 body = '%s',
                                             	  post_category = '%d',
                                             	   source = '%s',
                                             		autor_type = '%s',
                                             		 autor = '%d',
                                             		  date = NOW()
                                             	
                                             ON DUPLICATE KEY UPDATE
                                             
                                             	      title = '%s',
                                             		 body = '%s',
                                             		post_category = '%d',
                                             	   source = '%s',
                                                  autor_type = '%s',
                                                 autor = '%d',
                                                date = NOW()
                                               ",    	
    										  $this->title,
								               $this->body,
								                $this->post_category,
								             	 $this->source,
								             	  $this->autor_type,
								             	   $this->autor,								             			
								             		$this->title,
								             	   $this->body,
								             	  $this->post_category,
								             	 $this->source,
								                 $this->autor_type,
								               $this->autor);
								                                 
                                   
         $this->conn->setsql($sql);
         $this->id = $this->conn->insertDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

       // ------------------------------- post CATEGORIES -------------------------
         
        if(is_array($this->post_category) && (count($this->post_category) > 0)) 
        {         	
         		
         	for ($n=0;$n<count($this->post_category);$n++)
	 		 {    
		 		$sql="INSERT INTO posts_category_list SET category_id='". $this->post_category[$n]."' , post_id='".$this->id."'";
				$this->conn->setsql($sql);
			 	$this->conn->insertDB();
	 		 }

            if($this->conn->error) {
               for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
                  $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
               }
               return false;
            }
         }
	// ----------------------------------------------------------------------------------
         
         
// ----------------- za ka4vane na snimkite ---------------------------------------
				
         	if(isset($upPicPost)) {
						
				if ((!empty($upPicPost['name'])))
				{
					$uploaddir = "../pics/posts/";
					$uploadfile = $uploaddir . basename($upPicPost['name']);
				
					if (move_uploaded_file($upPicPost['tmp_name'], $uploadfile))
				 	{
				  			// --------------------Vkarva snimkite --------------------------------
							
							$pic_file=$this->get_pic_name($uploadfile,$uploaddir,$this->id.".jpg","300");           		
							$tumbnail=$this->get_pic_name($uploaddir.$pic_file,$uploaddir,$this->id."_thumb.jpg","60");  
					
					
							 $sql = sprintf("UPDATE posts SET picURL = '%s' WHERE postID = %d", $this->id.".jpg",   $this->id);
					         $this->conn->setsql($sql);
					         $this->conn->updateDB();
					         if($this->conn->error) {
					            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
					               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
					            }
					            return false;
					         }		
				 		
					}
					unlink($uploadfile);
				}
						
				
				// --------------------------------------------------------------------------------
					
                  
                 
		         
            
         }

       
         	$sql=sprintf("UPDATE %s SET cnt_post = (cnt_post+1) WHERE %s = %d",($_SESSION['user_type']=='user')?'users':(($_SESSION['user_type']=='doctor')?'doctors':'hospitals') ,($_SESSION['user_type']=='user')?'userID':'id' ,  $_SESSION['userID']);
			$this->conn->setsql($sql);
			$this->conn->updateDB();
	
    		$_SESSION['cnt_post']++;	     
                
         
         return true;
      } //End Create

      /*== UPDATE post ==*/
      function update($upPicPost) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class post: In update post_ID is not set";
            return false;
         }
		
     /*
        if (!isset($this->postpost_category) || ($this->postpost_category <= 0)) {
            $this->Error["Application Error ClsspostCrtpostpost_category-Invalid Argument"] = "Class post: In create postpost_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class post: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class post: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class post: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class post: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class post: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class post: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class post: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class post: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class post: In create FUEL is not set";
            return false;
         }

	*/
     
         $sql = sprintf("UPDATE posts SET title = '%s',
                                           body = '%s',
                                            post_category = '%d',
                                             source = '%s',
                                              autor_type = '%s',
                                               autor = '%d',
                                                date = NOW()
                                   				 WHERE postID = %d",
         										 $this->title,
								             	$this->body,
								               $this->post_category,
								              $this->source,
								             $this->autor_type,
								            $this->autor,
			                               $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrUpdt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

        
              // Set Type Details
         if(is_array($this->post_category) && (count($this->post_category) > 0)) {
         	
         		$sql="DELETE FROM posts_category_list WHERE post_id='".$this->id."'";
				$this->conn->setsql($sql);
			 	$this->conn->updateDB();
			 	
         	for ($n=0;$n<count($this->post_category);$n++)
	 		 {    
		 		$sql="INSERT INTO posts_category_list SET category_id='". $this->post_category[$n]."' , post_id='".$this->id."'";
				$this->conn->setsql($sql);
			 	$this->conn->insertDB();
	 		 }

            if($this->conn->error) {
               for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
                  $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
               }
               return false;
            }
         }

         

  // --------------------------------------------------------------------------------
    	
         	if(isset($upPicPost)) {
						
				if ((!empty($upPicPost['name'])))
				{
					$uploaddir = "../pics/posts/";
					$uploadfile = $uploaddir . basename($upPicPost['name']);
				
					if (move_uploaded_file($upPicPost['tmp_name'], $uploadfile))
				 	{
				  			// --------------------Vkarva snimkite --------------------------------
							
							$pic_file=$this->get_pic_name($uploadfile,$uploaddir,$this->id.".jpg","300");           		
							$tumbnail=$this->get_pic_name($uploaddir.$pic_file,$uploaddir,$this->id."_thumb.jpg","60");  
					
					
							 $sql = sprintf("UPDATE posts SET picURL = '%s' WHERE postID = %d", $this->id.".jpg",   $this->id);
					         $this->conn->setsql($sql);
					         $this->conn->updateDB();
					         if($this->conn->error) {
					            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
					               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
					            }
					            return false;
					         }		
				 		
					}
					unlink($uploadfile);
				}
						
				
				
         }
// --------------------------------------------------------------------------------
					
        		
		
         return true;
      } //End Update

      
      
      /*== DELETE post PIC ==*/
      function deletePic() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class post: In deletePic post_ID is not set";
            return false;
         }

         
         $picFile    = $this->id.".jpg";
         $thumbnail  = $this->id."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('../pics/posts/'.$picFile))
               if(!unlink('../pics/posts/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class post: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("UPDATE posts SET picURL='' WHERE postID = %d'", $this->id);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('../pics/posts/'.$thumbnail)) if(!unlink('../pics/posts/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class post: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
          
	        
	      
	      
         return true;
      }

    

      /*== DELETE post ==*/
      function deletePost() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class post: In deleteOffr post_ID is not set";
            return false;
         }

        

         $offPcs = glob('../pics/posts/'.$this->id."*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class post: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         

         $sql = sprintf("DELETE FROM posts WHERE postID = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
      		$sql=sprintf("UPDATE %s SET cnt_post = (cnt_post-1) WHERE %s = %d",($_SESSION['user_type']=='user')?'users':(($_SESSION['user_type']=='doctor')?'doctors':'hospitals') ,($_SESSION['user_type']=='user')?'userID':'id' ,  $_SESSION['userID']);
			$this->conn->setsql($sql);
			$this->conn->updateDB();
			
			$_SESSION['cnt_post']--;
	
         return true;
      } //End Delete

		
      
       
		   
		function getFileExtension($str)  // Vra6ta extension-a na snimkata ,kato mu se podade URL-a !
		{
		
		   $i = strrpos($str,".");
		   if (!$i) { return ""; }
		
		   $l = strlen($str) - $i;
		   $ext = substr($str,$i+1,$l);
		
		   return $ext;
		
		}
		
		
			
	function get_pic_name($val, $dest_dir, $offert_pic_name, $pic_width=300)				// Vra6ta ime na snimkata,koeto se vkarva v DB sled tova
	{	
		$ime_pic		=	basename($val);								//originalno ime na snimkata
		$novo_ime		=	$offert_pic_name;								//novo ime(nomer na ofertata) + raz6irenieto na snimkata
		$new_name		=	$dest_dir.$novo_ime;												//promenq staroto ime na novoto
		@copy($val,$new_name);
		//unlink($new_place);
		//@rename($ime_pic,$novo_ime);		
		
		
		if (($this->getFileExtension($val)	==	"jpeg") or ($this->getFileExtension($val)	==	"jpg") or ($this->getFileExtension($val)	==	"JPEG") or ($this->getFileExtension($val)=="JPG"))
		{
			@$src 		= imagecreatefromjpeg($val);
			@list($width,$height)	=	getimagesize($val);
		
			$newwidth	=	$pic_width;
			if (($height) && ($width))	
			{
				$newheight = ($height/$width)*$pic_width;	
			}
		
			@$tmp 		= imagecreatetruecolor($newwidth,$newheight);
			@imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		
			$filename 	=	$new_name; 
			@imagejpeg($tmp,$filename,100);
	
			@imagedestroy($src);
			@imagedestroy($tmp);
			//@rename($ime_pic,$new_ime_pic);
			
			return $novo_ime;
		}
		
		elseif (($this->getFileExtension($val) == "GIF") or ($this->getFileExtension($val) == "gif"))
		{
			@$src 		= imagecreatefromgif($val);
			@list($width,$height)	=	getimagesize($val);
		
			$newwidth 	= $pic_width;
			if (($height) && ($width))	
			{	
				$newheight = ($height/$width)*$pic_width;	
			}
			
			@$tmp 		= imagecreatetruecolor($newwidth,$newheight);
			@imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		
			$filename 	= $new_name; 
			@imagegif($tmp,$filename,100);
	
			@imagedestroy($src);
			@imagedestroy($tmp);
			
			return $novo_ime;
		}	
		else return false;
	
		
		
	}
	


   } //Class post
?>
