<?php
   require_once("classes/Upload.class.php");
   class doctor {
      var $conn;
      var $id;
      var $doctor_category;
      var $doctor_category_name;
      var $username;
      var $password;
      var $first_name;
      var $last_name;
      var $phone;
      var $addr;
      var $email;
      var $web;
      var $location;
      var $location_id;
      var $latitude;
      var $longitude;
      var $related_hospital;
      var $updated_by;
      var $updated_on;      
      var $registered_on;   
      var $info;
      var $has_pic;
      var $has_video;
      var $doctorRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function doctor($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //doctor

      /*== PREPARE AND LOAD QUERY ==*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) {
            $sql = sprintf("SELECT DISTINCT(d.id) as 'id',
								             d.username as 'username',								             
								              d.password as 'password',
								               d.first_name as 'first_name',								             
								                d.last_name as 'last_name',
									             dc.id as 'doctor_category',
									              d.phone as 'phone',
									               d.addr as 'address',
									                d.email as 'email',
									                 d.web as 'web',
									                  d.has_pic as 'has_pic',
										               d.related_hospital as 'related_hospital',
										                l.name as 'location',
										                 l.id as 'location_id',
										                  lt.name as 'locType',
										                   d.latitude as 'latitude',
										                    d.longitude as 'longitude',
										                     d.registered_on as 'registered_on',
										                      d.updated_by as 'updated_by',
										                       d.updated_on as 'updated_on',
											                    d.info as 'info'
											                     FROM doctors d,
											                      locations l,
											                       location_types lt
											                        WHERE d.location_id = l.id
											                         AND l.loc_type_id 	= lt.id
											                          AND d.id 			= %d
							                                           ", $this->id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->doctorRow = $this->conn->result;

            
            
            
            // Get Type Details
            $sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$this->id."' ";
			$this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->doctor_category[$i]= $this->conn->result[$i]["doctor_category_id"];
                  $this->doctor_category_name[$i]= $this->conn->result[$i]["doctor_category_name"];
               }
            }
            
            
            
            

            return true;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class doctor: In prepareLoadQuery doctor_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD doctor DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
         	
         	
            $this->id               = $this->doctorRow["id"];
            $this->username         = $this->doctorRow["username"];
            $this->password         = $this->doctorRow["password"];
            $this->first_name       = $this->doctorRow["first_name"];
            $this->last_name   		= $this->doctorRow["last_name"];
            $this->phone            = $this->doctorRow["phone"];
            $this->addr         	= $this->doctorRow["address"];
            $this->email         	= $this->doctorRow["email"];
            $this->web   			= $this->doctorRow["web"];
            $this->location         = $this->doctorRow["location"];
            $this->location_id      = $this->doctorRow["location_id"];
            $this->latitude      	= $this->doctorRow["latitude"];
            $this->longitude      	= $this->doctorRow["longitude"];
            $this->related_hospital = $this->doctorRow["related_hospital"];
            $this->updated_by       = $this->doctorRow["updated_by"];
            $this->updated_on      	= $this->doctorRow["updated_on"];
            $this->has_pic      	= $this->doctorRow["has_pic"];
            $this->has_video     	= $this->doctorRow["has_video"];
            $this->registered_on    = $this->doctorRow["registered_on"];
            $this->info        		= $this->doctorRow["info"];
            $this->userID			= $_SESSION['userID'];
                 
           
    
         }
      } //End Load

      /*== CREATE doctor ==*/
      function create($upPicdoctor) {

      /*
      	if (!isset($this->doctordoctor_category) || ($this->doctordoctor_category <= 0)) {
            $this->Error["Application Error ClssdoctorCrtdoctordoctor_category-Invalid Argument"] = "Class doctor: In create doctordoctor_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class doctor: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class doctor: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class doctor: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class doctor: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class doctor: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class doctor: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class doctor: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class doctor: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class doctor: In create FUEL is not set";
            return false;
         }
	*/ 
      
      
    	$sql = sprintf("INSERT INTO doctors SET   first_name = '%s',
                                             	   last_name = '%s',
                                             	    phone = '%s',
                                             	     addr = '%s',
                                             		  email = '%s',
                                             		   web = '%s',
                                             		    location_id = %d,
                                             		     latitude   = %0.20f,
                                             		      longitude = %0.20f,
                                             		       has_pic = %d,
                                             			    related_hospital = '%s',
                                             			     info = '%s',
                                             			      updated_by = %d,
                                             			       registered_on = NOW(),
                                             				    updated_on =NOW()                                             
                                             ON DUPLICATE KEY UPDATE
                                             				first_name = '%s',
                                             			   last_name = '%s',
                                             			  phone = '%s',
                                             			 addr = '%s',
                                             			email = '%s',
                                            		   web = '%s',
                                             		  location_id = %d,
                                             		 latitude   = %0.20f,
                                             		longitude = %0.20f,
                                             	   has_pic = %d,
                                             	  related_hospital = '%s',
                                             	 info = '%s',
                                             	updated_by = %d,
                                               registered_on = NOW(),
                                              updated_on =NOW()
                                             ",
    	
    										    $this->first_name,
								                 $this->last_name,
								                  $this->phone,
								             	   $this->addr,
								             	    $this->email,
								             	     $this->web,
								             		  $this->location_id,
								             		   $this->latitude,
								             		    $this->longitude,
								             		     $this->has_pic,
								             		      $this->related_hospital,
								             		       $this->info,
								             			    $_SESSION['userID'],
								             			
								             			    $this->first_name,
									             		   $this->last_name,
									             		  $this->phone,
									             		 $this->addr,
									             		$this->email,
									            	   $this->web,
									             	  $this->location_id,
									             	 $this->latitude,
									             	$this->longitude,
									               $this->has_pic,
									              $this->related_hospital,
									             $this->info,
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
         
        if(is_array($this->doctor_category) && (count($this->doctor_category) > 0)) 
        {         	
         		
         	for ($n=0;$n<count($this->doctor_category);$n++)
	 		 {    
		 		$sql="INSERT INTO doctors_category_list SET category_id='". $this->doctor_category[$n]."' , doctor_id='".$this->id."'";
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
         
         

         if(is_array($upPicdoctor) && (count($upPicdoctor) > 0)) {
            $files = array();
            foreach ($upPicdoctor as $k => $l) {
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
                  $upPic->process('../pics/doctors/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('../pics/doctors/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class doctor: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class doctor: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO doctor_pics SET url_big = '%s',
		      												   url_thumb = '%s',
		      												    doctorID = %d		
		      												ON DUPLICATE KEY UPDATE		      											
		      												    url_big = '%s',
			      											   url_thumb = '%s',
			      											  doctorID = %d
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

         $this->has_pic = is_file('../pics/doctors/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE doctors SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
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
     
				if(file_exists("../videos/doctors/".$video_name.".flv"))
				{
					@unlink("../videos/doctors/".$video_name.".flv");
					@unlink("../videos/doctors/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"../videos/doctors/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="../videos/doctors/".$video_name.".flv";
				$path_to_tmp="../videos/doctors/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE doctors SET has_video=1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   		}		      
	//=============================================================================================================
	
                
         
         return true;
      } //End Create

      /*== UPDATE doctor ==*/
      function update($upPicdoctor) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class doctor: In update doctor_ID is not set";
            return false;
         }
		
     /*
        if (!isset($this->doctordoctor_category) || ($this->doctordoctor_category <= 0)) {
            $this->Error["Application Error ClssdoctorCrtdoctordoctor_category-Invalid Argument"] = "Class doctor: In create doctordoctor_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class doctor: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class doctor: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class doctor: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class doctor: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class doctor: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class doctor: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class doctor: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class doctor: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class doctor: In create FUEL is not set";
            return false;
         }

	*/
     
         $sql = sprintf("UPDATE doctors SET first_name = '%s',
                                   			   last_name = '%s',
                                   			    phone = '%s',
                                   			     addr = '%s',
                                   				  email = '%s',
                                   				   web = '%s',
                                   				    location_id = %d,                                  
                                   				     latitude   = %0.20f,
                                             		  longitude = %0.20f,
                                             		   has_pic = %d,
                                   					    related_hospital = '%s',
                                   					     info = '%s',
                                   					      updated_by = %d,
                                   					       updated_on = NOW()
                                   					        WHERE id = %d", $this->first_name,
			                                   		     $this->last_name,
			                                   		    $this->phone,
			                                   		   $this->addr,
			                                   		  $this->email,
			                                   	     $this->web,
			                                   	    $this->location_id,
			                                       $this->latitude,
			                                      $this->longitude,
			                                     $this->has_pic,                                   
			                                    $this->related_hospital,                                   
			                                   $this->info,                                  
			                                  $_SESSION['userID'],
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
         if(is_array($this->doctor_category) && (count($this->doctor_category) > 0)) {
         	
         		$sql="DELETE FROM doctors_category_list WHERE doctor_id='".$this->id."'";
				$this->conn->setsql($sql);
			 	$this->conn->updateDB();
			 	
         	for ($n=0;$n<count($this->doctor_category);$n++)
	 		 {    
		 		$sql="INSERT INTO doctors_category_list SET category_id='". $this->doctor_category[$n]."' , doctor_id='".$this->id."'";
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

         

         if(is_array($upPicdoctor) && (count($upPicdoctor) > 0)) {
            $files = array();
            foreach ($upPicdoctor as $k => $l) {
               foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // ../pics Manipulation and Upload
            
             // iztriva faila ot servera predvaritelno,predi da go zapi6e nov
              /* 	 
               	  $offPcs = glob('../pics/doctors/'.$this->id."_*");
         

		         if(count($offPcs) > 0) {
		            foreach($offPcs as $val) {
		               if(strlen($val) > 0) {
		                  if(!@@unlink($val)) {
		                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class doctor: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
		                     return false;
		                  }
		                  
		                    $sql=sprintf("DELETE FROM doctor_pics WHERE doctorID = %d", $this->id);
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
               	
               	  $imgBig = imageDoctorExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/doctors/');

                  if ($upPic->processed) {
                  	
                  	 $imgThumb = imageDoctorExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('../pics/doctors/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class doctor: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class doctor: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO doctor_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  doctorID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  doctorID = %d
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

        	
         
    // ======================================== KA4va VIDEO =====================================================   	
    if($_FILES['imagefile']['name']<>'') 
   	{
   			$video_name = $this->id;    			
     
				if(file_exists("../videos/doctors/".$video_name.".flv"))
				{
					@unlink("../videos/doctors/".$video_name.".flv");
					@unlink("../videos/doctors/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"../videos/doctors/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce) ;				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="../videos/doctors/".$video_name.".flv";
				$path_to_tmp="../videos/doctors/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE doctors SET has_video=1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
   	}							
				      
	//=============================================================================================================
		
		
         return true;
      } //End Update

      
      
      /*== DELETE doctor PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class doctor: In deletePic doctor_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class doctor: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('../pics/doctors/'.$picFile))
               if(!@unlink('../pics/doctors/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class doctor: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM doctor_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('../pics/doctors/'.$thumbnail)) if(!@unlink('../pics/doctors/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class doctor: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('../pics/doctors/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_../pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE doctors SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    
      
    /*=============== DELETE doctor VIDEO ====================*/
    
      function deleteVideo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class bolest: In deleteVideo bolest_ID is not set";
            return false;
         }

         $videoFile    	= $this->id.".flv";
         $thumbnail  	= $this->id."_thumb.jpg";

         if(strlen($videoFile) > 0) {
            if(is_file('../videos/doctors/'.$videoFile))
               if(!@unlink('../videos/doctors/'.$videoFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$videoFile." cannot be deleted!";
                  return false;
               }
          }

         if(strlen($thumbnail) > 0) {
            if(is_file('../videos/doctors/'.$thumbnail))
             if(!@unlink('../videos/doctors/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('../videos/doctors/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_../pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE doctors SET has_video = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	      
         return true;
      }

   //========================================================== 
     
      
      
          
      /*== DELETE Doctor Logo ==*/
      function deleteLogo($picFile) {
             
         if(strlen($picFile) > 0) {
            if(is_file('../pics/doctors/'.$picFile))
               if(!@unlink('../pics/doctors/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class doctors: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
              }
            
         }

         return true;
      }


      /*== DELETE doctor ==*/
      function deletedoctor() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class doctor: In deleteOffr doctor_ID is not set";
            return false;
         }

        

         $offPcs = glob('../pics/doctors/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class doctor: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         
    // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("../../videos/doctors/".$video_name.".flv"))
				{
					@unlink("../videos/doctors/".$video_name.".flv");
				}
				if(file_exists("../videos/doctors/".$video_name."._thumb.jpg"))
				{
					@unlink("../videos/doctors/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	
	

         $sql = sprintf("DELETE FROM doctors WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
      	$sql=sprintf("DELETE FROM doctor_pics WHERE doctorID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
	
		
		// --------------Iztrivame i prileja6tite paketi--------------		
		$sql = sprintf("DELETE FROM purchased_packages WHERE doctor_id = %d", $this->id);
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

		

   } //Class doctor
?>
