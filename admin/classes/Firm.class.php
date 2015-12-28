<?php
   require_once("classes/Upload.class.php");
   class hospital {
      var $conn;
      var $id;
      var $hospital_category;
      var $hospital_category_name;
      var $username;
      var $password;
      var $name;
      var $manager;
      var $phone;
      var $address;
      var $email;
      var $web;
      var $location;
      var $location_id;
      var $latitude;
      var $longitude;
      var $related_hospital;
      var $updated_on;      
      var $registered_on;   
      var $description;
      var $has_pic;
      var $has_video;
      var $logo;
      var $hospitalRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function hospital($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //hospital

      /*== PREPARE AND LOAD QUERY ==*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) {
            $sql = sprintf("SELECT DISTINCT(h.id) as 'id',
								             h.username as 'username',
								              h.name as 'name',
								               h.manager as 'manager',						             
								                h.phone as 'phone',
									             h.address as 'address',
									              h.email as 'email',
									               h.web as 'web',
									                h.has_pic as 'has_pic',
										             h.has_video as 'has_video',
										              l.name as 'location',
										               l.id as 'location_id',
										                lt.name as 'locType',
										                 h.registered_on as 'registered_on',
										                  h.updated_on as 'updated_on',
										                   h.description as 'description'
											                FROM hospitals h,
											                 locations l,
											                  location_types lt
											                   WHERE h.location_id 	= l.id
											                    AND h.id 				= %d
							                                     ", $this->id);
             	 	 
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->hospitalRow = $this->conn->result;

            
            
              // Get Type Details
            $sql="SELECT hc.id as 'hospital_category_id', hc.name as 'hospital_category_name' FROM hospitals h, hospital_category hc, hospitals_category_list hcl WHERE hcl.hospital_id = h.id AND hcl.category_id = hc.id AND h.id = '".$this->id."' ";
			$this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->hospital_category[$i]= $this->conn->result[$i]["hospital_category_id"];
                  $this->hospital_category_name[$i]= $this->conn->result[$i]["hospital_category_name"];
               }
            }
            
            
            
            return true;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class hospital: In prepareLoadQuery hospital_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD hospital DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
         	
         	
            $this->id               		= $this->hospitalRow["id"];
            $this->username    				= $this->hospitalRow["username"];
            $this->name       				= $this->hospitalRow["name"];
            $this->manager   				= $this->hospitalRow["manager"];
            $this->phone            		= $this->hospitalRow["phone"];
            $this->address         			= $this->hospitalRow["address"];
            $this->email         			= $this->hospitalRow["email"];
            $this->web   					= $this->hospitalRow["web"];
            $this->location         		= $this->hospitalRow["location"];
            $this->location_id      		= $this->hospitalRow["location_id"];
            $this->updated_on    			= $this->hospitalRow["updated_on"];
            $this->has_pic      			= $this->hospitalRow["has_pic"];
            $this->has_video      			= $this->hospitalRow["has_video"];
            $this->registered_on    		= $this->hospitalRow["registered_on"];
            $this->description      		= $this->hospitalRow["description"];
            $this->userID					= $_SESSION['userID'];
                 
    
    
         }
      } //End Load

      /*== CREATE hospital ==*/
      function create($upPichospital) {

      /*
      	if (!isset($this->hospitalhospital_category) || ($this->hospitalhospital_category <= 0)) {
            $this->Error["Application Error ClsshospitalCrthospitalhospital_category-Invalid Argument"] = "Class hospital: In create hospitalhospital_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class hospital: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class hospital: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class hospital: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class hospital: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class hospital: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class hospital: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hospital: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hospital: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hospital: In create FUEL is not set";
            return false;
         }
	*/ 
     
						 					               
											                
    	$sql = sprintf("INSERT INTO hospitals (username,
    										 password,
    										 name,
                                             manager,
                                             phone,
                                             address,
                                             email,
                                             web,
                                             location_id,
                                             has_pic,
                                             description,
                                             updated_by,
                                             registered_on,
                                             updated_on)
                                             VALUES ('%s',
								                     '%s',
								                     '%s',
								                     '%s',
								                     '%s',
								                     '%s',
								                     '%s',
								                     '%s',
								                     %d,
								                     %d,
								                     '%s',                            
								                     %d,                               
								                     NOW(),                                
								                     NOW())",$this->username,
								                     $this->password,
								                     $this->name,
								                     $this->manager,
								                     $this->phone,
								                     $this->address,
								                     $this->email,
								                     $this->web,
								                     $this->location_id,
								                     $this->has_pic,
								                     $this->description,
								                     $_SESSION['userID']);
								                                 
                                   
         $this->conn->setsql($sql);
         $this->id = $this->conn->insertDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
     // ------------------------------- DOCTOR CATEGORIES -------------------------
         
        if(is_array($this->hospital_category) && (count($this->hospital_category) > 0)) {
         	
         		
         	for ($n=0;$n<count($this->hospital_category);$n++)
	 		 {    
		 		$sql="INSERT INTO hospitals_category_list SET category_id='". $this->hospital_category[$n]."' , hospital_id='".$this->id."'";
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
         
	
	 	$logoPic = new Upload($this->logo);
         if ($logoPic->uploaded) {
         $logoPic->image_convert      = 'jpg';
         $logoPic->file_new_name_body = $this->id."_logo";
         $logoPic->image_resize       = true;
         $logoPic->image_x            = 140;
         $logoPic->image_ratio_y      = true;
         $logoPic->file_overwrite     = true;
         $logoPic->file_auto_rename   = false;
         $logoPic->process('../pics/firms/');
         $logoPic->clean();
         }
	
         if(is_array($upPichospital) && (count($upPichospital) > 0)) {
            $files = array();
            foreach ($upPichospital as $k => $l) {
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
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/firms/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = true;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('../pics/firms/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class hospital: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class hospital: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO hospital_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  hospitalID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  hospitalID = %d
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

         $this->has_pic = is_file('../pics/firms/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE hospitals SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
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

      /*== UPDATE hospital ==*/
      function update($upPichospital) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class hospital: In update hospital_ID is not set";
            return false;
         }
		
     /*
        if (!isset($this->hospitalhospital_category) || ($this->hospitalhospital_category <= 0)) {
            $this->Error["Application Error ClsshospitalCrthospitalhospital_category-Invalid Argument"] = "Class hospital: In create hospitalhospital_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class hospital: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class hospital: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class hospital: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class hospital: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class hospital: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class hospital: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hospital: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hospital: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hospital: In create FUEL is not set";
            return false;
         }

	*/
    
     
         $sql = sprintf("UPDATE hospitals SET username = '%s',
			                                   password = '%s',
			                                    name = '%s',
			                                     manager = '%s',
			                                      phone = '%s',
			                                       address = '%s',
			                                        email = '%s',
			                                         web = '%s',
			                                          location_id = %d,                                  
			                                   		   has_pic = %d,
			                                   		    description = '%s',
			                                     	     updated_by = %d,
			                                   			  updated_on = NOW() WHERE id = %d", 
			                                   			   $this->username,
			                                   			    $this->password,
			                                   			     $this->name,
			                                   			      $this->manager,
			                                   			       $this->phone,
			                                   				    $this->address,
			                                   				     $this->email,
			                                    			      $this->web,
			                                   				       $this->location_id,
			                                   					    $this->has_pic,                                   
			                                   					     $this->description,                                  
			                                   					      $_SESSION['userID'], $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrUpdt-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
         
 		
         
         
         
        // ------------------------------- DOCTOR CATEGORIES -------------------------
         
        if(is_array($this->hospital_category) && (count($this->hospital_category) > 0)) 
        {         	
        	 $sql = sprintf("DELETE FROM hospitals_category_list WHERE hospital_id	= %d ", $this->id);
			 $this->conn->setsql($sql);
	         $this->conn->updateDB();
	         if($this->conn->error) {
	            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
	               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
	            }
	            return false;
	         }
         		
         	for ($n=0;$n<count($this->hospital_category);$n++)
	 		 {    
		 		$sql="INSERT INTO hospitals_category_list SET category_id='". $this->hospital_category[$n]."' , hospital_id='".$this->id."'";
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
         
	
         
         
         $logoPic = new Upload($this->logo);
         if ($logoPic->uploaded) {
         $logoPic->image_convert      = 'jpg';
         $logoPic->file_new_name_body = $this->id."_logo";
         $logoPic->image_resize       = true;
         $logoPic->image_x            = 140;
         $logoPic->image_ratio_y      = true;
         $logoPic->file_overwrite     = true;
         $logoPic->file_auto_rename   = false;
         $logoPic->process('../pics/firms/');
         $logoPic->clean();
         }
        
        

         if(is_array($upPichospital) && (count($upPichospital) > 0)) {
            $files = array();
            foreach ($upPichospital as $k => $l) {
               foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // Pics Manipulation and Upload
            
             // iztriva faila ot servera predvaritelno,predi da go zapi6e nov
              /* 	 
               	  $offPcs = glob('pics/hospitals/'.$this->id."_*");
         

		         if(count($offPcs) > 0) {
		            foreach($offPcs as $val) {
		               if(strlen($val) > 0) {
		                  if(!@unlink($val)) {
		                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class hospital: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
		                     return false;
		                  }
		                  
		                    $sql=sprintf("DELETE FROM hospital_pics WHERE hospitalID = %d", $this->id);
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
               	
               	  $imgBig = imageHospitalExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/firms/');

                  if ($upPic->processed) {
                  	
                  	 $imgThumb = imageHospitalExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('../pics/firms/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class hospital: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class hospital: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO hospital_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  hospitalID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  hospitalID = %d
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

      
      
      /*== DELETE hospital PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class hospital: In deletePic hospital_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class hospital: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('../pics/firms/'.$picFile))
               if(!unlink('../pics/firms/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class hospital: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM hospital_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('../pics/firms/'.$thumbnail)) if(!unlink('../pics/firms/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class hospital: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('../pics/firms/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE hospitals SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

      
      
        
      /*== DELETE hospital Logo ==*/
      function deleteLogo($picFile) {
         
      	if(strlen($picFile) > 0) {
            if(is_file('../pics/firms/'.$picFile))
               if(!unlink('../pics/firms/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class hospital: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
              }
            
         }

         return true;
      }

    

      /*== DELETE hospital ==*/
      function deletehospital() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class hospital: In deleteOffr hospital_ID is not set";
            return false;
         }

        

         $offPcs = glob('../pics/firms/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class hospital: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         

         $sql = sprintf("DELETE FROM hospitals WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
      	$sql=sprintf("DELETE FROM hospital_pics WHERE hospitalID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
	
		
		
		// --------------Iztrivame i prileja6tite paketi--------------
		$sql = sprintf("DELETE FROM purchased_packages WHERE company_id = %d", $this->id);
     	$this->conn->setsql($sql);
     	$this->conn->updateDB();
     	if($this->conn->error) {
        	for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
           	$this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
        	}
        	return false;
     	}
     	
     	
	
         return true;
      } //End Delete

		

   } //Class hospital
?>
