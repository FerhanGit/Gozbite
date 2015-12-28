<?php
   require_once("classes/Upload.class.php");
   class Lekarstvo {
      var $conn;
      var $id;
      var $lekarstvo_category;      
      var $lekarstvo_category_name;
      var $name;
      var $autor;
      var $autor_type;
      var $discovered_on;
      var $lekarstvo_simptom;      
      var $lekarstvo_simptom_name;
      var $location;
      var $location_id;
      var $related_lekarstvo;
      var $updated_on;      
      var $registered_on;   
      var $description;
      var $has_pic;
      var $lekarstvoRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function lekarstvo($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //lekarstvo

      /*== PREPARE AND LOAD QUERY ==*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) {
            $sql = sprintf("SELECT DISTINCT(l.lekarstvoID) as 'lekarstvoID',
								             l.title as 'title',
								              l.body as 'body',						             
								               l.autor_type as 'autor_type',
								                l.autor as 'autor',
									             l.source as 'source',
									              l.has_pic as 'has_pic',
										           l.date as 'date',
										            l.discovered_on as 'discovered_on'
										             FROM lekarstva l
											          WHERE l.lekarstvoID = %d
							                           ", $this->id);
             	 
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }	 	 	 	 	 	 	 	 	

            $this->lekarstvoRow = $this->conn->result;

            
                
              // Get Type Categories
            $sql="SELECT lc.id as 'lekarstvo_category_id', lc.name as 'lekarstvo_category_name' FROM lekarstva l, lekarstva_category lc, lekarstva_category_list lcl WHERE lcl.lekarstvo_id = l.lekarstvoID AND lcl.category_id = lc.id AND l.lekarstvoID = '".$this->id."' ";
			$this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->lekarstvo_category[$i]= $this->conn->result[$i]["lekarstvo_category_id"];
                  $this->lekarstvo_category_name[$i]= $this->conn->result[$i]["lekarstvo_category_name"];
               }
            }
            
            
                  
              // Get Type Simptoms
            $sql="SELECT ls.id as 'lekarstvo_simptom_id', ls.name as 'lekarstvo_simptom_name' FROM lekarstva l, lekarstva_simptom ls, lekarstva_simptoms_list lsl WHERE lsl.lekarstvo_id = l.lekarstvoID AND lsl.simptom_id = ls.id AND l.lekarstvoID = '".$this->id."' ";
			$this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->lekarstvo_simptom[$i]= $this->conn->result[$i]["lekarstvo_simptom_id"];
                  $this->lekarstvo_simptom_name[$i]= $this->conn->result[$i]["lekarstvo_simptom_name"];
               }
            }
            
            
            
            return true;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class lekarstvo: In prepareLoadQuery lekarstvo_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD lekarstvo DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
         	
         	
            $this->id               = $this->lekarstvoRow["lekarstvoID"];
            $this->name       		= $this->lekarstvoRow["title"];
            $this->body       		= $this->lekarstvoRow["body"];
            $this->has_pic      	= $this->lekarstvoRow["has_pic"];
            $this->discovered_on    = $this->lekarstvoRow["discovered_on"];
            $this->source    		= $this->lekarstvoRow["source"];
            $this->autor_type    	= $this->lekarstvoRow["autor_type"];
            $this->autor    		= $this->lekarstvoRow["autor"];
            $this->date    			= $this->lekarstvoRow["date"];
            $this->userID			= $_SESSION['userID'];
                 
    
    
         }
      } //End Load

      /*== CREATE lekarstvo ==*/
      function create($upPiclekarstvo) {

      /*
      	if (!isset($this->lekarstvolekarstvo_category) || ($this->lekarstvolekarstvo_category <= 0)) {
            $this->Error["Application Error ClsslekarstvoCrtlekarstvolekarstvo_category-Invalid Argument"] = "Class lekarstvo: In create lekarstvolekarstvo_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class lekarstvo: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class lekarstvo: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class lekarstvo: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class lekarstvo: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class lekarstvo: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class lekarstvo: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class lekarstvo: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class lekarstvo: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class lekarstvo: In create FUEL is not set";
            return false;
         }
	*/ 
     
						 					               
											                
    	$sql = sprintf("INSERT INTO lekarstva SET title='%s',
                                             body='%s',
                                             has_pic='%d',
                                             source='%s',
                                             autor_type='%s',
                                             autor='%d',
                                             discovered_on='%s',
                                             date=NOW()
                                          
                                          ON DUPLICATE KEY UPDATE
                                           
                                             title='%s',
                                             body='%s',
                                             has_pic='%d',
                                             source='%s',
                                             autor_type='%s',
                                             autor='%d',
                                             discovered_on='%s',
                                             date=NOW()
                                             ",$this->title,
    										 $this->body,
								             $this->has_pic,
								             $this->source,
								             $this->autor_type,
								             $this->autor,
								             $this->discovered_on,
								             $this->title,
    										 $this->body,
								             $this->has_pic,
								             $this->source,
								             $this->autor_type,
								             $this->autor,
								             $this->discovered_on);
		
                 
         $this->conn->setsql($sql);
         $this->id = $this->conn->insertDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         

     // ------------------------------- lekarstva CATEGORIES -------------------------
         
        if(is_array($this->lekarstvo_category) && (count($this->lekarstvo_category) > 0)) {
         	
         		
         	for ($n=0;$n<count($this->lekarstvo_category);$n++)
	 		 {    
		 		$sql="INSERT INTO lekarstva_category_list SET category_id='". $this->lekarstvo_category[$n]."' , lekarstvo_id='".$this->id."'";
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
	
	
	
	
	  // ------------------------------- lekarstva SIMPTOMS -------------------------
         
        if(is_array($this->lekarstvo_simptom) && (count($this->lekarstvo_simptom) > 0)) {
         	
         		
         	for ($n=0;$n<count($this->lekarstvo_simptom);$n++)
	 		 {    
		 		$sql="INSERT INTO lekarstva_simptoms_list SET simptom_id='". $this->lekarstvo_simptom[$n]."' , lekarstvo_id='".$this->id."'";
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
         
	
	
	
	
	
	
         if(is_array($upPiclekarstvo) && (count($upPiclekarstvo) > 0)) {
            $files = array();
            foreach ($upPiclekarstvo as $k => $l) {
                if(is_array($l) && (count($l) > 0))
                  foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // ../pics Manipulation and Upload
            $counter = 1;
            foreach($files as $file) {
               $upPic = new Upload($file);
               if ($upPic->uploaded) {
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $this->id."_".$counter;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = false;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/lekarstva/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('../pics/lekarstva/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class lekarstvo: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class lekarstvo: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO lekarstva_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  lekarstvoID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  lekarstvoID = %d
	      												   ",
	      												    $this->id."_".$counter.".jpg",
	      												     $this->id."_".$counter."_thumb.jpg",
	      												      $this->id,
	      												       $this->id."_".$counter.".jpg",
	      												        $this->id."_".$counter."_thumb.jpg",
	      												         $this->id);
		         $this->conn->setsql($sql);
		         $this->conn->insertDB();
		         if($this->conn->error) {
		            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
		               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
		            }
		            return false;
		         }
		         
               }
               $counter++;
               
              	
		         
            }
         }

         $this->has_pic = is_file('../pics/lekarstva/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE lekarstva SET has_pic = %d WHERE lekarstvoID = %d", $this->has_pic, $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
 // ======================================== KA4va VIDEO =====================================================   	
     	if($_FILES['imagefile']['name']<>'') 
   		{
   				$video_name = $this->id;    			
     
				if(file_exists("../videos/lekarstva/".$video_name.".flv"))
				{
					@unlink("../videos/lekarstva/".$video_name.".flv");
					@unlink("../videos/lekarstva/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"../videos/lekarstva/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="../videos/lekarstva/".$video_name.".flv";
				$path_to_tmp="../videos/lekarstva/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE lekarstva SET has_video=1 WHERE lekarstvoID = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   		}	      
	//=============================================================================================================
	

         	$sql=sprintf("UPDATE %s SET cnt_lekarstvo = (cnt_lekarstvo+1) WHERE %s = %d",($_SESSION['user_type']=='user')?'users':(($_SESSION['user_type']=='doctor')?'doctors':'hospitals') ,($_SESSION['user_type']=='user')?'userID':'id' ,  $_SESSION['userID']);
			$this->conn->setsql($sql);
			$this->conn->updateDB();
	
            $_SESSION['cnt_lekarstvo']++;  
         
            
            
            
         return true;
      } //End Create

      
      
      
      
      
      /*== UPDATE lekarstvo ==*/
      function update($upPiclekarstvo) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class lekarstvo: In update lekarstvo_ID is not set";
            return false;
         }
		
     /*
        if (!isset($this->lekarstvolekarstvo_category) || ($this->lekarstvolekarstvo_category <= 0)) {
            $this->Error["Application Error ClsslekarstvoCrtlekarstvolekarstvo_category-Invalid Argument"] = "Class lekarstvo: In create lekarstvolekarstvo_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class lekarstvo: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class lekarstvo: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class lekarstvo: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class lekarstvo: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class lekarstvo: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class lekarstvo: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class lekarstvo: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class lekarstvo: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class lekarstvo: In create FUEL is not set";
            return false;
         }

	*/
    
     										
                                             
         $sql = sprintf("UPDATE lekarstva SET title = '%s',
		                                   body = '%s',
		                                   has_pic = '%d',
		                                   source = '%s',
		                                   autor_type = '%s',
		                                   autor = '%d',
		                                   discovered_on = '%s', 
		                                   active = '0',
                                           date = NOW() WHERE lekarstvoID = %d", 
		                                   $this->title,
    									   $this->body,
								           $this->has_pic,
								           $this->source,
								           $this->autor_type,
								           $this->autor,
								           $this->discovered_on, $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrUpdt-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
         
 		
         
         
         // ------------------------------- lekarstva CATEGORIES -------------------------
         
        if(is_array($this->lekarstvo_category) && (count($this->lekarstvo_category) > 0)) 
        {
        	 $sql = sprintf("DELETE FROM lekarstva_category_list WHERE lekarstvo_id	= %d ", $this->id);
			 $this->conn->setsql($sql);
	         $this->conn->updateDB();
	         if($this->conn->error) {
	            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
	               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
	            }
	            return false;
	         }
         
         		
         	for ($n=0;$n<count($this->lekarstvo_category);$n++)
	 		 {    
		 		$sql="INSERT INTO lekarstva_category_list SET category_id='". $this->lekarstvo_category[$n]."' , lekarstvo_id='".$this->id."'";
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
         
	
	
	
	
	
	  // ------------------------------- lekarstva SIMPTOMS -------------------------
         
        if(is_array($this->lekarstvo_simptom) && (count($this->lekarstvo_simptom) > 0)) 
        {
        	 $sql = sprintf("DELETE FROM lekarstva_simptoms_list WHERE lekarstvo_id	= %d ", $this->id);
			 $this->conn->setsql($sql);
	         $this->conn->updateDB();
	         if($this->conn->error) {
	            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
	               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
	            }
	            return false;
	         }
         
         		
         	for ($n=0;$n<count($this->lekarstvo_simptom);$n++)
	 		 {    
		 		$sql="INSERT INTO lekarstva_simptoms_list SET simptom_id='". $this->lekarstvo_simptom[$n]."' , lekarstvo_id='".$this->id."'";
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
         
	  

         if(is_array($upPiclekarstvo) && (count($upPiclekarstvo) > 0)) {
            $files = array();
            foreach ($upPiclekarstvo as $k => $l) {
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
               	
             	  $imgBig = imagelekarstvoExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/lekarstva/');

                  if ($upPic->processed) {
                   	
                  	 $imgThumb = imagelekarstvoExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('../pics/lekarstva/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class lekarstvo: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class lekarstvo: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO lekarstva_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  lekarstvoID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  lekarstvoID = %d
	      												   ",
	      												    $imgBig.'.jpg',
	      												     $imgthumb.'.jpg',
	      												      $this->id,
	      												       $imgBig.'.jpg',
	      												     	$imgthumb.'.jpg',
	      												         $this->id);
		         $this->conn->setsql($sql);
		         $this->conn->insertDB();
		         if($this->conn->error) {
		            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
		               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
		            }
		            return false;
		         }
                 
					$counter++;
               }	
               
               
              
		         
		         
               
               
               
            }
         }

     // ======================================== KA4va VIDEO =====================================================   	
     	if($_FILES['imagefile']['name']<>'') 
   		{
   			$video_name = $this->id;    			
     
				if(file_exists("../videos/lekarstva/".$video_name.".flv"))
				{
					@unlink("../videos/lekarstva/".$video_name.".flv");
					@unlink("../videos/lekarstva/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"../videos/lekarstva/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="../videos/lekarstva/".$video_name.".flv";
				$path_to_tmp="../videos/lekarstva/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					//@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE lekarstva SET has_video=1 WHERE lekarstvoID = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   		}	    
	//=============================================================================================================
	
	
		
         return true;
      } //End Update

      
      
      /*== DELETE lekarstvo PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class lekarstvo: In deletePic lekarstvo_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class lekarstvo: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('../pics/lekarstva/'.$picFile))
               if(!@unlink('../pics/lekarstva/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class lekarstvo: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM lekarstva_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('../pics/lekarstva/'.$thumbnail)) if(!@unlink('../pics/lekarstva/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class lekarstvo: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('../pics/lekarstva/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_../pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE lekarstva SET has_pic = 0 WHERE lekarstvoID = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    
      
      
      /*== DELETE lekarstvo VIDEO ==*/
      function deleteVideo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class lekarstvo: In deleteVideo lekarstvo_ID is not set";
            return false;
         }

         $videoFile    	= $this->id.".flv";
         $thumbnail  	= $this->id."_thumb.jpg";

         if(strlen($videoFile) > 0) {
            if(is_file('../videos/lekarstva/'.$videoFile))
               if(!@unlink('../videos/lekarstva/'.$videoFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class lekarstvo: In deleteVideo -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
          }

         if(strlen($thumbnail) > 0) {
            if(is_file('../videos/lekarstva/'.$thumbnail))
             if(!@unlink('../videos/lekarstva/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class lekarstvo: In deleteVideo -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('../videos/lekarstva/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_../pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE lekarstva SET has_video = 0 WHERE lekarstvoID = %d",$this->id));
            $this->conn->updateDB();
         }
         
	      
         return true;
      }

    
      
      
      

      /*== DELETE lekarstvo ==*/
      function deletelekarstvo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class lekarstvo: In deleteOffr lekarstvo_ID is not set";
            return false;
         }

        

         $offPcs = glob('../pics/lekarstva/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class lekarstvo: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         
     // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("../videos/lekarstva/".$video_name.".flv"))
				{
					@unlink("../videos/lekarstva/".$video_name.".flv");
				}
				if(file_exists("../videos/lekarstva/".$video_name."._thumb.jpg"))
				{
					@unlink("../videos/lekarstva/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	

         $sql = sprintf("DELETE FROM lekarstva WHERE lekarstvoID = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
      	$sql=sprintf("DELETE FROM lekarstva_category_list WHERE lekarstvo_id = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
				
		
		$sql=sprintf("DELETE FROM lekarstva_pics WHERE lekarstvoID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
		
		$sql=sprintf("UPDATE %s SET cnt_lekarstvo = (cnt_lekarstvo-1) WHERE %s = %d",($_SESSION['user_type']=='user')?'users':(($_SESSION['user_type']=='doctor')?'doctors':'hospitals') ,($_SESSION['user_type']=='user')?'userID':'id' ,  $_SESSION['userID']);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
	
		$_SESSION['cnt_lekarstvo']--;
	
         return true;
      } //End Delete

		

   } //Class lekarstvo
?>
