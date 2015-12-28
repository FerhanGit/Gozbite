<?php
   require_once("classes/Upload.class.php");
   class Bolest {
      var $conn;
      var $id;
      var $bolest_category;      
      var $bolest_category_name;
      var $name;
      var $autor;
      var $autor_type;
      var $discovered_on;
      var $bolest_simptom;      
      var $bolest_simptom_name;
      var $location;
      var $location_id;
      var $related_bolest;
      var $updated_on;      
      var $registered_on;   
      var $description;
      var $has_pic;
      var $bolestRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function bolest($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //bolest

      /*== PREPARE AND LOAD QUERY ==*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) {
            $sql = sprintf("SELECT DISTINCT(b.bolestID) as 'id',
								             b.title as 'title',
								              b.body as 'body',						             
								               b.autor_type as 'autor_type',
								                b.autor as 'autor',
									             b.source as 'source',
									              b.has_pic as 'has_pic',
										           b.date as 'date',
										            b.discovered_on as 'discovered_on'
										             FROM bolesti b
											          WHERE b.bolestID = %d
							                           ", $this->id);
             	 
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }	 	 	 	 	 	 	 	 	

            $this->bolestRow = $this->conn->result;

            
                
              // Get Type Categories
            $sql="SELECT bc.id as 'bolest_category_id', bc.name as 'bolest_category_name' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND b.bolestID = '".$this->id."' ";
			$this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->bolest_category[$i]= $this->conn->result[$i]["bolest_category_id"];
                  $this->bolest_category_name[$i]= $this->conn->result[$i]["bolest_category_name"];
               }
            }
            
            
                  
              // Get Type Simptoms
            $sql="SELECT bs.id as 'bolest_simptom_id', bs.name as 'bolest_simptom_name' FROM bolesti b, bolest_simptom bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND b.bolestID = '".$this->id."' ";
			$this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->bolest_simptom[$i]= $this->conn->result[$i]["bolest_simptom_id"];
                  $this->bolest_simptom_name[$i]= $this->conn->result[$i]["bolest_simptom_name"];
               }
            }
            
            
            
            return true;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class bolest: In prepareLoadQuery bolest_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD bolest DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
         	
         	
            $this->id               = $this->bolestRow["id"];
            $this->name       		= $this->bolestRow["title"];
            $this->body       		= $this->bolestRow["body"];
            $this->has_pic      	= $this->bolestRow["has_pic"];
            $this->discovered_on    = $this->bolestRow["discovered_on"];
            $this->source    		= $this->bolestRow["source"];
            $this->autor_type    	= $this->bolestRow["autor_type"];
            $this->autor    		= $this->bolestRow["autor"];
            $this->date    			= $this->bolestRow["date"];
            $this->userID			= $_SESSION['userID'];
                 
    
    
         }
      } //End Load

      /*== CREATE bolest ==*/
      function create($upPicbolest) {

      /*
      	if (!isset($this->bolestbolest_category) || ($this->bolestbolest_category <= 0)) {
            $this->Error["Application Error ClssbolestCrtbolestbolest_category-Invalid Argument"] = "Class bolest: In create bolestbolest_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class bolest: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class bolest: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class bolest: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class bolest: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class bolest: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class bolest: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class bolest: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class bolest: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class bolest: In create FUEL is not set";
            return false;
         }
	*/ 
     
						 					               
											                
    	$sql = sprintf("INSERT INTO bolesti (title,
                                             body,
                                             has_pic,
                                             source,
                                             autor_type,
                                             autor,
                                             discovered_on,
                                             date)
                                             VALUES ('%s',
								                     '%s',
								                     '%d',
								                     '%s',
								                     '%s',
								                     '%d',								                                                  
								                     '%s',                                
								                     NOW())",$this->title,
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
         
         

     // ------------------------------- BOLESTI CATEGORIES -------------------------
         
        if(is_array($this->bolest_category) && (count($this->bolest_category) > 0)) {
         	
         		
         	for ($n=0;$n<count($this->bolest_category);$n++)
	 		 {    
		 		$sql="INSERT INTO bolesti_category_list SET category_id='". $this->bolest_category[$n]."' , bolest_id='".$this->id."'";
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
	
	
	
	
	  // ------------------------------- BOLESTI SIMPTOMS -------------------------
         
        if(is_array($this->bolest_simptom) && (count($this->bolest_simptom) > 0)) {
         	
         		
         	for ($n=0;$n<count($this->bolest_simptom);$n++)
	 		 {    
		 		$sql="INSERT INTO bolesti_simptoms_list SET simptom_id='". $this->bolest_simptom[$n]."' , bolest_id='".$this->id."'";
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
         
	
	
	
	
	
	
         if(is_array($upPicbolest) && (count($upPicbolest) > 0)) {
            $files = array();
            foreach ($upPicbolest as $k => $l) {
               foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // Pics Manipulation and Upload
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
                  $upPic->process('../pics/bolesti/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('../pics/bolesti/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class bolest: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class bolest: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO bolesti_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  bolestID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  bolestID = %d
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

         $this->has_pic = is_file('../pics/bolesti/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE bolesti SET has_pic = %d WHERE bolestID = %d", $this->has_pic, $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
         
                
         
         return true;
      } //End Create

      /*== UPDATE bolest ==*/
      function update($upPicbolest) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class bolest: In update bolest_ID is not set";
            return false;
         }
		
     /*
        if (!isset($this->bolestbolest_category) || ($this->bolestbolest_category <= 0)) {
            $this->Error["Application Error ClssbolestCrtbolestbolest_category-Invalid Argument"] = "Class bolest: In create bolestbolest_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class bolest: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class bolest: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class bolest: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class bolest: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class bolest: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class bolest: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class bolest: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class bolest: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class bolest: In create FUEL is not set";
            return false;
         }

	*/
    
     										
                                             
         $sql = sprintf("UPDATE bolesti SET title = '%s',
		                                   body = '%s',
		                                   has_pic = '%d',
		                                   source = '%s',
		                                   autor_type = '%s',
		                                   autor = '%d',
		                                   discovered_on = '%s', 
		                                   date = NOW() WHERE bolestID = %d", 
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
         
         
         
 		
         
         
         // ------------------------------- BOLESTI CATEGORIES -------------------------
         
        if(is_array($this->bolest_category) && (count($this->bolest_category) > 0)) 
        {
        	 $sql = sprintf("DELETE FROM bolesti_category_list WHERE bolest_id	= %d ", $this->id);
			 $this->conn->setsql($sql);
	         $this->conn->updateDB();
	         if($this->conn->error) {
	            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
	               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
	            }
	            return false;
	         }
         
         		
         	for ($n=0;$n<count($this->bolest_category);$n++)
	 		 {    
		 		$sql="INSERT INTO bolesti_category_list SET category_id='". $this->bolest_category[$n]."' , bolest_id='".$this->id."'";
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
         
	
	
	
	
	
	  // ------------------------------- BOLESTI SIMPTOMS -------------------------
         
        if(is_array($this->bolest_simptom) && (count($this->bolest_simptom) > 0)) 
        {
        	 $sql = sprintf("DELETE FROM bolesti_simptoms_list WHERE bolest_id	= %d ", $this->id);
			 $this->conn->setsql($sql);
	         $this->conn->updateDB();
	         if($this->conn->error) {
	            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
	               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
	            }
	            return false;
	         }
         
         		
         	for ($n=0;$n<count($this->bolest_simptom);$n++)
	 		 {    
		 		$sql="INSERT INTO bolesti_simptoms_list SET simptom_id='". $this->bolest_simptom[$n]."' , bolest_id='".$this->id."'";
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
         
	
	
         
         
        
         

         if(is_array($upPicbolest) && (count($upPicbolest) > 0)) {
            $files = array();
            foreach ($upPicbolest as $k => $l) {
               foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // Pics Manipulation and Upload
            
             // iztriva faila ot servera predvaritelno,predi da go zapi6e nov
              /* 	 
               	  $offPcs = glob('../pics/bolests/'.$this->id."_*");
         

		         if(count($offPcs) > 0) {
		            foreach($offPcs as $val) {
		               if(strlen($val) > 0) {
		                  if(!@unlink($val)) {
		                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class bolest: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
		                     return false;
		                  }
		                  
		                    $sql=sprintf("DELETE FROM bolest_pics WHERE bolestID = %d", $this->id);
							$this->conn->setsql($sql);
							$this->conn->updateDB();
		                  
		               }
		            }
		         }
         */
               	 // ------------------------------------------------------------
               	  
         
		
            $counter = 1;
            
            foreach($files as $file) {
            	
            	
               $upPic = new Upload($file);
               if ($upPic->uploaded) {
               	
               	  $imgBig = imageBolestExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/bolesti/');

                  if ($upPic->processed) {
                  	
                  	 $imgThumb = imageBolestExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('../pics/bolesti/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class bolest: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class bolest: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO bolesti_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  bolestID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  bolestID = %d
	      												   ",
	      												    $imgBig.'.jpg',
	      												     $imgThumb.'.jpg',
	      												      $this->id,
	      												       $imgBig.'.jpg',
	      												     	$imgThumb.'.jpg',
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

        		
		
         return true;
      } //End Update

      
      
      /*== DELETE bolest PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class bolest: In deletePic bolest_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class bolest: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('../pics/bolesti/'.$picFile))
               if(!unlink('../pics/bolesti/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM bolesti_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('../pics/bolesti/'.$thumbnail)) if(!unlink('../pics/bolesti/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('../pics/bolesti/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE bolesti SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    

      /*== DELETE bolest ==*/
      function deletebolest() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class bolest: In deleteOffr bolest_ID is not set";
            return false;
         }

        

         $offPcs = glob('../pics/bolesti/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class bolest: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         

         $sql = sprintf("DELETE FROM bolesti WHERE bolestID = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
      	$sql=sprintf("DELETE FROM bolesti_pics WHERE bolestID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
	
		
	
         return true;
      } //End Delete

		

   } //Class bolest
?>
