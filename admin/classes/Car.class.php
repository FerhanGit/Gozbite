<?php
   require_once("classes/Upload.class.php");
   class Car {
      var $conn;
      var $id;
      var $marka;
      var $model;
      var $updated_by;
      var $price;
      var $color;
      var $probeg;
      var $fuel;
      var $location;
      var $avto_type;
      var $created_by;
      var $currency;
      var $year_made;
      var $description;
      var $has_pic;
      var $detail_id;
      var $details;
      var $detail_name;
      var $CarRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Car($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //Car

      /*== PREPARE AND LOAD QUERY ==*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) {
            $sql = sprintf("SELECT DISTINCT(c.id) as 'id',
						             mk.name as 'marka',
						              md.name as 'model',
						               c.price as 'price',
						                l.name as 'location',
						                 cr.name as 'currency',
						                  at.name as 'avto_type' ,
						                   cl.name as 'color',
						                    f.name as 'fuel',
						                     c.updated_on as 'updated_on',
						                      c.created_by as 'created_by',	                     
						                       c.year_made as 'year_made',
						                        c.description as 'description',
						                         c.probeg as 'probeg',
						                          c.has_pic as 'has_pic'
						                           FROM cars c,
						                            marka mk,
						                             model md,
						                              currency cr,
						                               avto_type at,
						                                color cl,
						                                 fuel f,
						                                  locations l,
						                                   cars_details cd 
						                                    WHERE c.marka=mk.id
						                                     AND c.model=md.id
						                                      AND c.avto_type=at.id 
						                                       AND c.color=cl.id 
						                                        AND c.fuel = f.id
						                                         AND c.currency = cr.id
						                                          AND c.location_id = l.id
						                                           AND c.id = %d
						                                            ", $this->id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->CarRow = $this->conn->result;

            // Get Type Details
            $sql = sprintf("SELECT cd.detail_id as 'detail_id', cdl.name as 'detail' FROM cars_details cd, cars_details_list cdl WHERE cd.detail_id=cdl.id AND cd.car_id = %d", $this->id);
            $this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->details[$i]= $this->conn->result[$i]["detail_id"];
                  $this->detail_name[$i]= $this->conn->result[$i]["detail"];
               }
            }

            return true;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class Car: In prepareLoadQuery Car_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD Car DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
         	
         	
            $this->id               = $this->CarRow["id"];
            $this->marka            = $this->CarRow["marka"];
            $this->model            = $this->CarRow["model"];
            $this->avto_type   		= $this->CarRow["avto_type"];
            $this->color            = $this->CarRow["color"];
            $this->picCheck         = $this->CarRow["picCheck"];
            $this->fromDate         = $this->CarRow["fromDate"];
            $this->location   		= $this->CarRow["location"];
            $this->fuel             = $this->CarRow["fuel"];
            $this->price         	= $this->CarRow["price"];
            $this->currency         = $this->CarRow["currency"];
            $this->probeg       	= $this->CarRow["probeg"];
            $this->description      = $this->CarRow["description"];
            $this->has_pic      	= $this->CarRow["has_pic"];
            $this->updated_on       = $this->CarRow["updated_on"];
            $this->year_made        = $this->CarRow["year_made"];
            $this->created_by       = $this->CarRow["created_by"];
            $this->updated_by       = $this->CarRow["updated_by"];
            $this->userID			= $_SESSION['userID'];
                        
    
         }
      } //End Load

      /*== CREATE Car ==*/
      function create($upPicArr) {

      /*
      	if (!isset($this->marka) || ($this->marka <= 0)) {
            $this->Error["Application Error ClssCarCrtMarka-Invalid Argument"] = "Class Car: In create MARKA is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class Car: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class Car: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class Car: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class Car: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class Car: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class Car: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class Car: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class Car: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class Car: In create FUEL is not set";
            return false;
         }
	*/
    	$sql = sprintf("INSERT INTO cars (marka,
                                             model,
                                             price,
                                             probeg,
                                             color,
                                             fuel,
                                             avto_type,
                                             location_id,
                                             has_pic,
                                             currency,
                                             description,
                                             year_made,
                                             updated_by,
                                             created_by,
                                             updated_on)
                                             VALUES (%d,
								                     %d,
								                     %0.2f,
								                     %d,
								                     %d,
								                     %d,
								                     %d,
								                     %d,
								                     %d,
								                     %d,
								                     '%s',
								                     '%s',                             
								                     %d,
								                     %d,                                
								                     NOW())", $this->marka,
								                     $this->model,
								                     $this->price,
								                     $this->probeg,
								                     $this->color,
								                     $this->fuel,
								                     $this->avto_type,
								                     $this->location_id,
								                     $this->has_pic,
								                     $this->currency,
								                     $this->description,
								                     $this->year_made,
								                     $this->updated_by,
								                     $this->created_by);
								                                 
                                   
         $this->conn->setsql($sql);
         $this->id = $this->conn->insertDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
         // Set Type Details
         if(is_array($this->details) && (count($this->details) > 0)) {
         	for ($n=0;$n<count($this->details);$n++)
	 		 {    
		 		$sql="INSERT INTO cars_details SET detail_id='". $this->details[$n]."' , car_id='".$this->id."'";
				$this->conn->setsql($sql);
			 	$this->conn->updateDB();
	 		 }

            if($this->conn->error) {
               for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
                  $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
               }
               return false;
            }
         }

         if(is_array($upPicArr) && (count($upPicArr) > 0)) {
            $files = array();
            foreach ($upPicArr as $k => $l) {
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
                  $upPic->file_new_name_body = $this->id."_".$counter."_";
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 300;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = false;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/cars/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('../pics/cars/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class Car: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class Car: ".$upPic->error;
                     return false;
                  }
               }
               $counter++;
            }
         }

         $this->has_pic = is_file('../pics/cars/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE cars SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
         
         $sql = sprintf("INSERT INTO pics SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
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

      /*== UPDATE Car ==*/
      function update($upPicArr) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class Car: In update Car_ID is not set";
            return false;
         }
		
     /*
        if (!isset($this->marka) || ($this->marka <= 0)) {
            $this->Error["Application Error ClssCarCrtMarka-Invalid Argument"] = "Class Car: In create MARKA is not set";
            return false;
         }

         if (!isset($this->model) || ($this->model <= 0)) {
            $this->Error["Application Error ClssOffrCrtActnID-Invalid Argument"] = "Class Car: In create MODEL is not set";
            return false;
         }

         if (!isset($this->price) || ($this->price <= 0)) {
            $this->Error["Application Error ClssOffrCrtCmpnID-Invalid Argument"] = "Class Car: In create PRICE is not set";
            return false;
         }

         if (!isset($this->probeg) || ($this->probeg <= 0)) {
            $this->Error["Application Error ClssOffrCrtTpID-Invalid Argument"] = "Class Car: In create PROBEG is not set";
            return false;
         }

         if (!isset($this->color) || ($this->color <= 0)) {
            $this->Error["Application Error ClssOffrCrtPrc-Invalid Argument"] = "Class Car: In create COLOR is not set";
            return false;
         }

         if (!isset($this->currency) || ($this->currency <= 0)) {
            $this->Error["Application Error ClssOffrCrtCrrncID-Invalid Argument"] = "Class Car: In create CURRENCY is not set";
            return false;
         }

         if (!isset($this->description) || (strlen($this->description) == 0)) {
            $this->Error["Application Error ClssOffrCrtDscrptn-Invalid Argument"] = "Class Car: In create DESCRIPTION is not set";
            return false;
         }
         
         if (!isset($this->updated_by) || ($this->updated_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class Car: In create UPDATED_BY is not set";
            return false;
         }
         
         if (!isset($this->created_by) || ($this->created_by <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class Car: In create CREATED_BY is not set";
            return false;
         }
         
          if (!isset($this->fuel) || ($this->fuel <= 0)) {
            $this->Error["Application Error ClssOffrCrtUpdtdBy-Invalid Argument"] = "Class Car: In create FUEL is not set";
            return false;
         }

	*/
         $sql = sprintf("UPDATE cars SET marka = %d,
                                   model = %d,
                                   price = %0.2f,
                                   probeg = %d,
                                   color = '%d',
                                   fuel = '%d',
                                   avto_type = '%d',
                                   location_id = %d,                                  
                                   currency = %d,
                                   description = '%s',
                                   updated_by = %d,
                                   updated_on = NOW() WHERE id = %d", $this->marka,
                                   $this->model,
                                   $this->price,
                                   $this->probeg,
                                   $this->color,
                                   $this->fuel,
                                   $this->avto_type,
                                   $this->location_id,
                                   $this->currency,                                   
                                   $this->description,                                   
                                   $this->updateDBy, $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrUpdt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

        

         // Set  Details
         if(is_array($this->details) && (count($this->details) > 0)) {
            $sql = sprintf("DELETE FROM cars_details WHERE car_id = %d", $this->id);
            $this->conn->setsql($sql);
            $this->conn->updateDB();

           	for ($n=0;$n<count($this->details);$n++)
	 		{    
		 		$sql=sprintf("INSERT INTO cars_details SET detail_id= %d  , car_id= %d ", $this->details[$n], $this->id);
				$this->conn->setsql($sql);
			 	$this->conn->updateDB();
	 		}

            if($this->conn->error) {
               for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
                  $this->Error["SQL ERROR ClssOffrUpdt-".$key] = $this->conn->error[$key];
               }
               return false;
            }
         }

         if(is_array($upPicArr) && (count($upPicArr) > 0)) {
            $files = array();
            foreach ($upPicArr as $k => $l) {
               foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // Pics Manipulation and Upload
            
             // iztriva faila ot servera predvaritelno,predi da go zapi6e nov
               	 
               	  $offPcs = glob('../pics/cars/'.$this->id."_*");
         

		         if(count($offPcs) > 0) {
		            foreach($offPcs as $val) {
		               if(strlen($val) > 0) {
		                  if(!@unlink($val)) {
		                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class Car: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
		                     return false;
		                  }
		                  
		                    $sql=sprintf("DELETE FROM pics WHERE carID = %d", $this->id);
							$this->conn->setsql($sql);
							$this->conn->updateDB();
		                  
		               }
		            }
		         }
         
               	 // ------------------------------------------------------------
               	  
         
		
            $counter = 1;
            foreach($files as $file) {
            	
            	
               $upPic = new Upload($file);
               if ($upPic->uploaded) {
               	
               	                 	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = imageExists($this->id, $counter, 1);
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 300;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('../pics/cars/');

                  if ($upPic->processed) {
                     $upPic->file_new_name_body = imageExists($this->id, $counter, 2);
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('../pics/cars/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class Car: ".$upPic->error;
                        return false;
                     }
                     
          			$sql=sprintf("INSERT INTO pics SET  url_big = '%s' , url_thumb = '%s' , carID = %d" , $this->id."_".$counter."_.jpg" , $this->id."_".$counter."_thumb.jpg" , $this->id);
					$this->conn->setsql($sql);
					$this->conn->updateDB();
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class Car: ".$upPic->error;
                     return false;
                  }
                  
                  
                 
					
               }
               $counter++;
            }
         }

         $this->has_pic = is_file('../pics/cars/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE cars SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrUpdt-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
        		
		
         return true;
      } //End Update

      /*== DELETE Car PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class Car: In deletePic Car_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class Car: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx."_.jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('../pics/cars/'.$picFile))
               if(!@unlink('../pics/cars/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class Car: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
               
            $sql=sprintf("DELETE FROM pics WHERE url_big = '%s'", $picFile);
			$this->conn->setsql($sql);
			$this->conn->updateDB();
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('../pics/cars/'.$thumbnail)) if(!@unlink('../pics/cars/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class Car: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }

         if($picIndx == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE cars SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    

      /*== DELETE Car ==*/
      function deleteCar() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class Car: In deleteOffr Car_ID is not set";
            return false;
         }

         $sql = sprintf("DELETE FROM cars_details WHERE car_id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         $offPcs = glob('../pics/cars/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class Car: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         

         $sql = sprintf("DELETE FROM cars WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
      	$sql=sprintf("DELETE FROM pics WHERE carID=%d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
	
		
	
         return true;
      } //End Delete

		

   } //Class Car
?>
