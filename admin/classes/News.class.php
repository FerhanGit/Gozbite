<?php
   require_once("classes/Upload.class.php");
   class news {
      var $conn;
      var $newsID;
      var $id;
      var $news_category;
      var $news_category_name;
      var $title;
      var $body;
      var $autor_type;
      var $autor;
      var $source;
      var $updated_by;
      var $updated_on;      
      var $registered_on;   
      var $newsRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function news($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //news

      /*== PREPARE AND LOAD QUERY ==*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) {
            $sql = sprintf("SELECT DISTINCT(n.newsID) as 'newsID',
								             n.title as 'title',								             
								              n.body as 'body',
									           nc.id as 'news_category',
									            n.updated_by as 'updated_by',
										         n.updated_on as 'updated_on',
											      n.source as 'source'
											       FROM news n,
											        AND n.newsID = %d
							                         ", $this->id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->newsRow = $this->conn->result;

            
            
            
            // Get Type Details
            $sql="SELECT nc.id as 'news_category_id', nc.name as 'news_category_name' FROM news n, news_category nc, news_category_list ncl WHERE ncl.news_id = n.newsID AND ncl.category_id = nc.id AND n.newsID = '".$this->newsID."' ";
			$this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->news_category[$i]= $this->conn->result[$i]["news_category_id"];
                  $this->news_category_name[$i]= $this->conn->result[$i]["news_category_name"];
               }
            }
            
            
            
            

            return true;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class news: In prepareLoadQuery news_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD news DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
         	
         	
            $this->id               = $this->newsRow["id"];
            $this->title       		= $this->newsRow["title"];
            $this->body	   			= $this->newsRow["body"];
            $this->news_category    = $this->newsRow["news_category"];
            $this->source         	= $this->newsRow["source"];
            $this->autor         	= $this->newsRow["autor"];
            $this->autor_type       = $this->newsRow["autor_type"];
            $this->updated_by       = $this->newsRow["updated_by"];
            $this->updated_on      	= $this->newsRow["updated_on"];
            $this->userID			= $_SESSION['userID'];
                 
           
    
         }
      } //End Load

      /*== CREATE news ==*/
      function create($upPicnews) {

      /*
      	if (!isset($this->newsnews_category) || ($this->newsnews_category <= 0)) {
            $this->Error["Application Error ClssnewsCrtnewsnews_category-Invalid Argument"] = "Class news: In create newsnews_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class news: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class news: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class news: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class news: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class news: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class news: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class news: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class news: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class news: In create FUEL is not set";
            return false;
         }
	*/ 
      
      
    	$sql = sprintf("INSERT INTO news SET title = '%s',
                                             	 body = '%s',
                                             	  news_category = '%d',
                                             	   source = '%s',
                                             		autor_type = '%s',
                                             		 autor = '%d',
                                             		  date = NOW()
                                             	
                                             ON DUPLICATE KEY UPDATE
                                             
                                             	      title = '%s',
                                             		 body = '%s',
                                             		news_category = '%d',
                                             	   source = '%s',
                                                  autor_type = '%s',
                                                 autor = '%d',
                                                date = NOW()
                                               ",    	
    										  $this->title,
								               $this->body,
								                $this->news_category,
								             	 $this->source,
								             	  $this->autor_type,
								             	   $this->autor,								             			
								             		$this->title,
								             	   $this->body,
								             	  $this->news_category,
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

       // ------------------------------- news CATEGORIES -------------------------
         
        if(is_array($this->news_category) && (count($this->news_category) > 0)) 
        {         	
         		
         	for ($n=0;$n<count($this->news_category);$n++)
	 		 {    
		 		$sql="INSERT INTO news_category_list SET category_id='". $this->news_category[$n]."' , news_id='".$this->id."'";
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
    	
         	if(isset($upPicnews)) {
						
				if ((!empty($upPicnews['name'])))
				{
					$uploaddir = "../pics/news/";
					$uploadfile = $uploaddir . basename($upPicnews['name']);
				
					if (move_uploaded_file($upPicnews['tmp_name'], $uploadfile))
				 	{
				  			// --------------------Vkarva snimkite --------------------------------
							
							$pic_file=$this->get_pic_name($uploadfile,$uploaddir,$this->id.".jpg","300");           		
							$tumbnail=$this->get_pic_name($uploaddir.$pic_file,$uploaddir,$this->id."_thumb.jpg","60");  
					
					
							 $sql = sprintf("UPDATE news SET picURL = '%s' WHERE newsID = %d", $this->id.".jpg",   $this->id);
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
	

       
         	$sql=sprintf("UPDATE %s SET cnt_news = (cnt_news+1) WHERE %s = %d",($_SESSION['user_type']=='user')?'users':(($_SESSION['user_type']=='doctor')?'doctors':'hospitals') ,($_SESSION['user_type']=='user')?'userID':'id' ,  $_SESSION['userID']);
			$this->conn->setsql($sql);
			$this->conn->updateDB();
	
    		$_SESSION['cnt_news']++;	     
                
         
         return true;
      } //End Create

      /*== UPDATE news ==*/
      function update($upPicnews) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class news: In update news_ID is not set";
            return false;
         }
		
     /*
        if (!isset($this->newsnews_category) || ($this->newsnews_category <= 0)) {
            $this->Error["Application Error ClssnewsCrtnewsnews_category-Invalid Argument"] = "Class news: In create newsnews_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class news: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class news: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class news: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class news: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class news: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class news: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class news: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class news: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class news: In create FUEL is not set";
            return false;
         }

	*/
     
         $sql = sprintf("UPDATE news SET title = '%s',
                                          body = '%s',
                                           news_category = '%d',
                                            source = '%s',
                                             autor_type = '%s',
                                              autor = '%d',
                                               date = NOW()
                                   				WHERE newsID = %d",
        										$this->title,
							             	   $this->body,
							             	  $this->news_category,
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
         if(is_array($this->news_category) && (count($this->news_category) > 0)) {
         	
         		$sql="DELETE FROM news_category_list WHERE news_id='".$this->id."'";
				$this->conn->setsql($sql);
			 	$this->conn->updateDB();
			 	
         	for ($n=0;$n<count($this->news_category);$n++)
	 		 {    
		 		$sql="INSERT INTO news_category_list SET category_id='". $this->news_category[$n]."' , news_id='".$this->id."'";
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
    	
         	if(isset($upPicnews)) {
						
				if ((!empty($upPicnews['name'])))
				{
					$uploaddir = "../pics/news/";
					$uploadfile = $uploaddir . basename($upPicnews['name']);
				
					if (move_uploaded_file($upPicnews['tmp_name'], $uploadfile))
				 	{
				  			// --------------------Vkarva snimkite --------------------------------
							
							$pic_file=$this->get_pic_name($uploadfile,$uploaddir,$this->id.".jpg","300");           		
							$tumbnail=$this->get_pic_name($uploaddir.$pic_file,$uploaddir,$this->id."_thumb.jpg","60");  
					
					
							 $sql = sprintf("UPDATE news SET picURL = '%s' WHERE newsID = %d", $this->id.".jpg",   $this->id);
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

      
      
      /*== DELETE news PIC ==*/
      function deletePic() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class news: In deletePic news_ID is not set";
            return false;
         }

         
         $picFile    = $this->id.".jpg";
         $thumbnail  = $this->id."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('../pics/news/'.$picFile))
               if(!unlink('../pics/news/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class news: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("UPDATE news SET picURL='' WHERE newsID = %d'", $this->id);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('../pics/news/'.$thumbnail)) if(!unlink('../pics/news/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class news: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
          
	        
	      
	      
         return true;
      }

    

      /*== DELETE news ==*/
      function deleteNews() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class news: In deleteOffr news_ID is not set";
            return false;
         }

        

         $offPcs = glob('../pics/news/'.$this->id."*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class news: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         

         $sql = sprintf("DELETE FROM news WHERE newsID = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
      		$sql=sprintf("UPDATE %s SET cnt_news = (cnt_news-1) WHERE %s = %d",($_SESSION['user_type']=='user')?'users':(($_SESSION['user_type']=='doctor')?'doctors':'hospitals') ,($_SESSION['user_type']=='user')?'userID':'id' ,  $_SESSION['userID']);
			$this->conn->setsql($sql);
			$this->conn->updateDB();
			
			$_SESSION['cnt_news']--;
	
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

   } //Class news
?>
