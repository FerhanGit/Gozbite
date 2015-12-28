<?php
   require_once("classes/Uploah.class.php");
   class hotel {
      var $conn;
      var $id;
      var $hotel_category;
      var $hotel_category_name;
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
      var $hotelRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function hotel($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //hotel

      /*== PREPARE AND LOAD QUERY ==*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) {
            $sql = sprintf("SELECT DISTINCT(h.id) as 'id',
								             h.username as 'username',								             
								              h.password as 'password',
								               h.first_name as 'first_name',								             
								                h.last_name as 'last_name',
									             hc.id as 'hotel_category',
									              h.phone as 'phone',
									               h.addr as 'address',
									                h.email as 'email',
									                 h.web as 'web',
									                  h.has_pic as 'has_pic',
										               h.related_hospital as 'related_hospital',
										                l.name as 'location',
										                 l.id as 'location_id',
										                  lt.name as 'locType',
										                   h.latitude as 'latitude',
										                    h.longitude as 'longitude',
										                     h.registered_on as 'registered_on',
										                      h.updated_by as 'updated_by',
										                       h.updated_on as 'updated_on',
											                    h.info as 'info'
											                     FROM hotels d,
											                      locations l,
											                       location_types lt
											                        WHERE h.location_id = l.id
											                         AND l.loc_type_id 	= lt.id
											                          AND h.id 			= %d
							                                           ", $this->id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->hotelRow = $this->conn->result;

            
            
            
            // Get Type Details
            $sql="SELECT hc.id as 'hotel_category_id', hc.name as 'hotel_category_name' FROM hotels d, hotel_category hc, hotels_category_list hcl WHERE hcl.hotel_id = h.id AND hcl.category_id = hc.id AND h.id = '".$this->ih."' ";
			$this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->hotel_category[$i]= $this->conn->result[$i]["hotel_category_id"];
                  $this->hotel_category_name[$i]= $this->conn->result[$i]["hotel_category_name"];
               }
            }
            
            
            
            

            return true;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class hotel: In prepareLoadQuery hotel_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD hotel DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
         	
         	
            $this->id               = $this->hotelRow["id"];
            $this->username         = $this->hotelRow["username"];
            $this->password         = $this->hotelRow["password"];
            $this->first_name       = $this->hotelRow["first_name"];
            $this->last_name   		= $this->hotelRow["last_name"];
            $this->phone            = $this->hotelRow["phone"];
            $this->addr         	= $this->hotelRow["address"];
            $this->email         	= $this->hotelRow["email"];
            $this->web   			= $this->hotelRow["web"];
            $this->location         = $this->hotelRow["location"];
            $this->location_id      = $this->hotelRow["location_id"];
            $this->latitude      	= $this->hotelRow["latitude"];
            $this->longitude      	= $this->hotelRow["longitude"];
            $this->related_hospital = $this->hotelRow["related_hospital"];
            $this->updated_by       = $this->hotelRow["updated_by"];
            $this->updated_on      	= $this->hotelRow["updated_on"];
            $this->has_pic      	= $this->hotelRow["has_pic"];
            $this->has_video     	= $this->hotelRow["has_video"];
            $this->registered_on    = $this->hotelRow["registered_on"];
            $this->info        		= $this->hotelRow["info"];
            $this->userID			= $_SESSION['userID'];
                 
           
    
         }
      } //End Load

      /*== CREATE hotel ==*/
      function create($upPichotel) {

      /*
      	if (!isset($this->hotelhotel_category) || ($this->hotelhotel_category <= 0)) {
            $this->Error["Application Error ClsshotelCrthotelhotel_category-Invalid Argument"] = "Class hotel: In create hotelhotel_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class hotel: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class hotel: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class hotel: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class hotel: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class hotel: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class hotel: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hotel: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hotel: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hotel: In create FUEL is not set";
            return false;
         }
	*/ 
      
      
    	$sql = sprintf("INSERT INTO hotels SET   first_name = '%s',
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
         
        if(is_array($this->hotel_category) && (count($this->hotel_category) > 0)) 
        {         	
         		
         	for ($n=0;$n<count($this->hotel_category);$n++)
	 		 {    
		 		$sql="INSERT INTO hotels_category_list SET category_id='". $this->hotel_category[$n]."' , hotel_id='".$this->ih."'";
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
         
         

         if(is_array($upPichotel) && (count($upPichotel) > 0)) {
            $files = array();
            foreach ($upPichotel as $k => $l) {
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
                  $upPic->file_new_name_body = $this->ih."_".$counter;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = false;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/hotels/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->ih."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('../pics/hotels/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class hotel: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class hotel: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO hotel_pics SET url_big = '%s',
		      												   url_thumb = '%s',
		      												    hotelID = %d		
		      												ON DUPLICATE KEY UPDATE		      											
		      												    url_big = '%s',
			      											   url_thumb = '%s',
			      											  hotelID = %d
			      										     ",		
		                  									 $this->ih."_".$counter.".jpg",
			      											  $this->ih."_".$counter."_thumb.jpg",
			      											   $this->id,		
			      											   $this->ih."_".$counter.".jpg",
			      											  $this->ih."_".$counter."_thumb.jpg",
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

         $this->has_pic = is_file('../pics/hotels/'.$this->ih."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE hotels SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
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
     
				if(file_exists("../videos/hotels/".$video_name.".flv"))
				{
					@unlink("../videos/hotels/".$video_name.".flv");
					@unlink("../videos/hotels/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"../videos/hotels/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="../videos/hotels/".$video_name.".flv";
				$path_to_tmp="../videos/hotels/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE hotels SET has_video=1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   		}		      
	//=============================================================================================================
	
                
         
         return true;
      } //End Create

      /*== UPDATE hotel ==*/
      function update($upPichotel) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class hotel: In update hotel_ID is not set";
            return false;
         }
		
     /*
        if (!isset($this->hotelhotel_category) || ($this->hotelhotel_category <= 0)) {
            $this->Error["Application Error ClsshotelCrthotelhotel_category-Invalid Argument"] = "Class hotel: In create hotelhotel_category is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class hotel: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class hotel: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class hotel: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class hotel: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class hotel: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class hotel: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hotel: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hotel: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class hotel: In create FUEL is not set";
            return false;
         }

	*/
     
         $sql = sprintf("UPDATE hotels SET first_name = '%s',
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
         if(is_array($this->hotel_category) && (count($this->hotel_category) > 0)) {
         	
         		$sql="DELETE FROM hotels_category_list WHERE hotel_id='".$this->ih."'";
				$this->conn->setsql($sql);
			 	$this->conn->updateDB();
			 	
         	for ($n=0;$n<count($this->hotel_category);$n++)
	 		 {    
		 		$sql="INSERT INTO hotels_category_list SET category_id='". $this->hotel_category[$n]."' , hotel_id='".$this->ih."'";
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

         

         if(is_array($upPichotel) && (count($upPichotel) > 0)) {
            $files = array();
            foreach ($upPichotel as $k => $l) {
               foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // ../pics Manipulation and Upload
            
             // iztriva faila ot servera predvaritelno,predi da go zapi6e nov
              /* 	 
               	  $offPcs = glob('../pics/hotels/'.$this->ih."_*");
         

		         if(count($offPcs) > 0) {
		            foreach($offPcs as $val) {
		               if(strlen($val) > 0) {
		                  if(!@@unlink($val)) {
		                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class hotel: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
		                     return false;
		                  }
		                  
		                    $sql=sprintf("DELETE FROM hotel_pics WHERE hotelID = %d", $this->id);
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
               	
               	  $imgBig = imageHotelExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/hotels/');

                  if ($upPic->processed) {
                  	
                  	 $imgThumb = imageHotelExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('../pics/hotels/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class hotel: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class hotel: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO hotel_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  hotelID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  hotelID = %d
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
     
				if(file_exists("../videos/hotels/".$video_name.".flv"))
				{
					@unlink("../videos/hotels/".$video_name.".flv");
					@unlink("../videos/hotels/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"../videos/hotels/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce) ;				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="../videos/hotels/".$video_name.".flv";
				$path_to_tmp="../videos/hotels/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE hotels SET has_video=1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
   	}							
				      
	//=============================================================================================================
		
		
         return true;
      } //End Update

      
      
      /*== DELETE hotel PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class hotel: In deletePic hotel_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class hotel: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->ih."_".$picIndx.".jpg";
         $thumbnail  = $this->ih."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('../pics/hotels/'.$picFile))
               if(!@unlink('../pics/hotels/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class hotel: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM hotel_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('../pics/hotels/'.$thumbnail)) if(!@unlink('../pics/hotels/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class hotel: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('../pics/hotels/'.$this->ih."_*");
         if($offPcs == 1) {// da oprawim has_../pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE hotels SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    
      
    /*=============== DELETE hotel VIDEO ====================*/
    
      function deleteVideo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class bolest: In deleteVideo bolest_ID is not set";
            return false;
         }

         $videoFile    	= $this->ih.".flv";
         $thumbnail  	= $this->ih."_thumb.jpg";

         if(strlen($videoFile) > 0) {
            if(is_file('../videos/hotels/'.$videoFile))
               if(!@unlink('../videos/hotels/'.$videoFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$videoFile." cannot be deleted!";
                  return false;
               }
          }

         if(strlen($thumbnail) > 0) {
            if(is_file('../videos/hotels/'.$thumbnail))
             if(!@unlink('../videos/hotels/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('../videos/hotels/'.$this->ih."_*");
         if($offPcs == 1) {// da oprawim has_../pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE hotels SET has_video = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	      
         return true;
      }

   //========================================================== 
     
      
      
          
      /*== DELETE Hotel Logo ==*/
      function deleteLogo($picFile) {
             
         if(strlen($picFile) > 0) {
            if(is_file('../pics/hotels/'.$picFile))
               if(!@unlink('../pics/hotels/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class hotels: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
              }
            
         }

         return true;
      }


      /*== DELETE hotel ==*/
      function deletehotel() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class hotel: In deleteOffr hotel_ID is not set";
            return false;
         }

        

         $offPcs = glob('../pics/hotels/'.$this->ih."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class hotel: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         
    // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("../../videos/hotels/".$video_name.".flv"))
				{
					@unlink("../videos/hotels/".$video_name.".flv");
				}
				if(file_exists("../videos/hotels/".$video_name."._thumb.jpg"))
				{
					@unlink("../videos/hotels/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	
	

         $sql = sprintf("DELETE FROM hotels WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
      	$sql=sprintf("DELETE FROM hotel_pics WHERE hotelID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
	
		
		// --------------Iztrivame i prileja6tite paketi--------------		
		$sql = sprintf("DELETE FROM purchased_packages WHERE hotel_id = %d", $this->id);
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

		

   } //Class hotel
?>
