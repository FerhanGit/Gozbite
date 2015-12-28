<?php
   require_once("includes/classes/Upload.class.php");
   class Firm {
      var $conn;
      var $id;
      var $firm_category;
      var $firm_category_name;
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
      var $related_firm;
      var $updated_on;      
      var $registered_on;   
      var $latitude;   
      var $longitude;   
      var $description;
      var $has_pic;
      var $has_video;
      var $logo;
      var $firmRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Firm($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //firm


      function load() {
       if(isset($this->whereclause) or isset($this->orderClause) or isset($this->limitClause)) 
       {
         
		    $sql = sprintf("SELECT DISTINCT(f.id) as 'firmID',
								             f.username as 'username',								             
								              f.password as 'password',
								               f.name as 'name',								             
								                f.manager as 'manager',						             
								                 f.phone as 'phone',
									              f.address as 'address',
									               f.email as 'email',
									                f.web as 'web',
									                 f.rating as 'rating',
									                  f.times_rated as 'times_rated',
									                   f.has_pic as 'has_pic',
										                f.has_video as 'has_video',
										                 f.youtube_video as 'youtube_video',
										                  l.name as 'location',
										                   l.id as 'location_id',
										                    lt.name as 'locType',
										                     f.latitude as 'latitude',
										                      f.longitude as 'longitude',
										                       f.registered_on as 'registered_on',
										                        f.updated_by as 'updated_by',
										                         f.updated_on as 'updated_on',
											                      f.description as 'description',
											                       f.is_Silver as 'silver',
											                        f.is_Gold as 'gold', 
											                         f.is_VIP as 'is_VIP', 
											                         f.is_VIP_from as 'is_VIP_from', 
											                        f.is_VIP_end as 'is_VIP_end', 
											                       f.is_VIP_code as 'is_VIP_code',
											                      f.is_Featured as 'is_Featured',
											                     f.is_Featured_from as 'is_Featured_from', 
											                    f.is_Featured_end as 'is_Featured_end', 
											                   f.is_Featured_code as 'is_Featured_code', 
											                  f.is_Featured_end as 'is_Featured_end', 
											                 f.is_Featured_end as 'is_Featured_end', 
											                f.cnt_recipe as 'cnt_recipe', 
											               f.cnt_drink as 'cnt_drink', 
											              f.cnt_guide as 'cnt_guide', 
											             f.cnt_post as 'cnt_post', 
											            f.cnt_destination as 'cnt_destination', 
											           f.cnt_comment as 'cnt_comment', 
											          f.used_credits as 'used_credits', 
											         f.bulstat as 'bulstat', 
											        f.mol as 'mol', 
											       f.last_login as 'last_login', 
											      f.active as 'active' 
											     FROM firms f,
											    locations l,
											   location_types lt
											  WHERE f.location_id = l.id
											  AND l.loc_type_id   = lt.id
											  AND f.active = 1
										      %s  %s  %s ", $this->whereClause, $this->orderClause, $this->limitClause);
		    
		  		 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 				  	 		 	 	 	 	 	 	 	
            $this->conn->setsql($sql);
            $this->conn->getTableRows();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->firmRow 		= $this->conn->result;
			$this->firmRowsCount= $this->conn->numberrows;
            
            
            if($this->firmRowsCount > 0)
            { 
		        // Get Type Categories
				for($k = 0; $k < $this->firmRowsCount; $k++)
				{
				            
		            
				//------------- Categories ----------------------------------------------------
																		
					$sql="SELECT fc.id as 'firm_category_id', fc.name as 'firm_category_name' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id AND f.id = '".$this->firmRow[$k]['firmID']."' ";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->firmRow[$k]['numCats'] = $this->conn->numberrows;
					$resultFirmsCat[$k] 		  = $this->conn->result;	
						
					for($i = 0; $i < $this->firmRow[$k]['numCats']; $i++) {
						$this->firmRow[$k]['Cats'][$i] = $resultFirmsCat[$k][$i];					
					}
	            // ============================= PICTURES =========================================
			
	           
					$sql="SELECT * FROM firm_pics WHERE firmID='".$this->firmRow[$k]['firmID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->firmRow[$k]['numPics'] = $this->conn->numberrows;
					$resultFirmsPics[$k] 			= $this->conn->result;	
					
					for($i = 0; $i < $this->firmRow[$k]['numPics']; $i++) {
						$this->firmRow[$k]['resultPics']['url_big'][$i] 	= $resultFirmsPics[$k][$i]["url_big"];
						$this->firmRow[$k]['resultPics']['url_thumb'][$i] = $resultFirmsPics[$k][$i]["url_thumb"];
					}
			
					
	
				// =============================== Cnt ========================================	
		
		
					$sql="SELECT firm_id, SUM(cnt) as 'cnt' FROM log_firm WHERE firm_id='".$this->firmRow[$k]['firmID']."' GROUP BY firm_id LIMIT 1";
					$this->conn->setsql($sql);
					$this->conn->getTableRow();
					$this->firmRow[$k]['cnt']		= $this->conn->result['cnt'];
										
				// =============================== COMMENTS ========================================	
				
					
					$sql="SELECT commentID, sender_name , sender_email , autor_type, autor, comment_body , parentID , created_on  FROM firm_comment WHERE firmID='".$this->firmRow[$k]['firmID']."' ORDER BY created_on DESC";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->firmRow[$k]['numComments'] = $this->conn->numberrows;
					$resultFirmsComment[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->firmRow[$k]['numComments']; $i++) {
						$this->firmRow[$k]['Comments'][$i] = $resultFirmsComment[$k][$i];					
					}
					
					
					
					//--------------------------- TAGS ------------------------------------------
		
					$sql="SELECT * FROM firm_tags WHERE firmID='".$this->firmRow[$k]['firmID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$firmTagsCount 		= $this->conn->numberrows;
					$resultFirmsTags[$k]	= $this->conn->result;	
						
					if($firmTagsCount > 0) {
						$this->firmRow[$k]['Tags'] = explode(',',$resultFirmsTags[$k][$i]['tags']);					
					}
					$this->firmRow[$k]['numTags'] = count($this->firmRow[$k]['Tags']);
					
					
						
					
				}   
	             
				 
	                  
	            foreach($this->firmRow as $firmRow)
	            {
	            	$finalResults[$firmRow['firmID']] = $firmRow;
	            }
           
            	return $finalResults;
            }
            
            return false;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class doctor: In prepareLoadQuery doctor_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      
      
     function create($upPicfirm) 
     {

     

      
		$this->description = removeBadTags($this->description);		// Remove Bad tags from text
											                
    	$sql = sprintf("INSERT INTO firms (username,
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
                                             youtube_video,
                                             updated_by,
                                             latitude,
                                             longitude,
                                             active,                                                 
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
								                     '%s',                            
								                     %d,
								                     %0.20f,
								                     %0.20f,
								                     '1',                               
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
								                     $this->youtube_video,
								                     $_SESSION['userID'],
								                     $this->latitude,
								                     $this->longitude);
								                                 
                                   
         $this->conn->setsql($sql);
         $this->id = $this->conn->insertDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
     // ------------------------------- firm CATEGORIES -------------------------
         
        if(is_array($this->firm_category) && (count($this->firm_category) > 0)) {
         	
         		
         	for ($n=0;$n<count($this->firm_category);$n++)
	 		 {    
		 		$sql="INSERT INTO firms_category_list SET category_id='". $this->firm_category[$n]."' , firm_id='".$this->id."'";
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
         
	      
	//**************************************** Качваме Таговете **************************************
         
         $sql = sprintf("INSERT INTO firm_tags SET  tags = '%s',
	      											 firmID = %d
	      											  ON DUPLICATE KEY UPDATE
	      											   tags = '%s',
		      										    firmID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         	$this->conn->setsql($sql);
         	$this->conn->insertDB();
         
    //***********************************************************************************************
        

    
	
	 	$logoPic = new Upload($this->logo);
         if ($logoPic->uploaded) {
         $logoPic->image_convert      = 'jpg';
         $logoPic->file_new_name_body = $this->id."_logo";
         $logoPic->image_resize       = true;
         $logoPic->image_x            = 140;
         $logoPic->image_ratio_y      = true;
         $logoPic->file_overwrite     = false;
         $logoPic->file_auto_rename   = false;
         $logoPic->process('pics/firms/');
         $logoPic->clean();
         }
	
         if(is_array($upPicfirm) && (count($upPicfirm) > 0)) {
            $files = array();
            foreach ($upPicfirm as $k => $l) {
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
                  $upPic->process('pics/firms/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('pics/firms/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class firm: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class firm: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO firm_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  firmID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  firmID = %d
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

         $this->has_pic = is_file('pics/firms/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE firms SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
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
     
				if(file_exists("videos/firms/".$video_name.".flv"))
				{
					@unlink("videos/firms/".$video_name.".flv");
					@unlink("videos/firms/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/firms/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/firms/".$video_name.".flv";
				$path_to_tmp="videos/firms/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE firms SET has_video = 1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   	}		      
	//=============================================================================================================
	
	
                
			   
      	//+++++++++++++++++++++++++++++++++++++ SEND MAIL +++++++++++++++++++++++++++++++++++++++++++++++++
      
      		//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			
			$body  = "<br /><br /><a href='http://GoZbiTe.Com/вход,вход_в_системата_на_кулинарния_портал_GoZbiTe.Com.html'><img style='border: 0px;' src='http://GoZbiTe.Com/images/logce.png'></a><br /><br />";			  	
		  	$body .= "<br /><br />В портала GoZbiTe.Com е приета заявка за регистрация на Заведение/Фирма ".addslashes($this->name)." със следните данни: <br /><br />";
	        $body .= "<br />Потребителско име: ".$this->username;
			$body .= "<br />Парола: ".$_REQUEST['password'];
			$body .= "<br />Наименование: ".$this->name;
			$body .= "<br />Лице за контакти: ".$this->manager;
			$body .= "<br />Телефон: ".$this->phone;
			$body .= "<br />Адрес: ".$this->address;
			$body .= "<br />Е-мейл: ".$this->email;
			$body .= "<br />Уеб Сайт: ".$this->web;
			$body .= "<br />Местоположение: ".get_location_nameBylocationID($this->location_id);
			$body .= "<br />Описание: ".$this->description;
			$body  = eregi_replace("[\]",'',$body);
			
								                     
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Vashiqt profil v GoZbiTe.Com - ".addslashes($this->name);
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 3;
			$mail->ClearAddresses();
			$mail->AddAddress($this->email);
			$mail->AddCC("office@gozbite.com");
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!$mail->Send()) {
			 // echo "Грешка при изпращане: " . $mail->ErrorInfo; 
			} else {
			 // echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
			}
      	
      //++++++++++++++++++++++++++++++++++++++++++ END MAIL ++++++++++++++++++++++++++++++++++++++++++++++++++
      			 
      
      
         
         return true;
      } //End Create

      /*== UPDATE firm ==*/
      function update($upPicfirm) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class firm: In update firm_ID is not set";
            return false;
         }
		
     
     	   
      
		$this->description = removeBadTags($this->description);		// Remove Bad tags from text
											                
    	$sql = sprintf("UPDATE firms SET username = '%s',
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
			                                     	     youtube_video = '%s',
			                                     	      updated_by = %d,
			                                   			   latitude = %0.20f,
			                                   			    longitude = %0.20f,
			                                   			     active = '1',
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
			                                   					          $this->youtube_video,                                  
			                                   					           $_SESSION['userID'],
			                                   					            $this->latitude,
			                                   					             $this->longitude, $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrUpdt-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
         
 		
         
         
         
        // ------------------------------- DOCTOR CATEGORIES -------------------------
         
        if(is_array($this->firm_category) && (count($this->firm_category) > 0)) 
        {         	
        	 $sql = sprintf("DELETE FROM firms_category_list WHERE firm_id	= %d ", $this->id);
			 $this->conn->setsql($sql);
	         $this->conn->updateDB();
	         if($this->conn->error) {
	            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
	               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
	            }
	            return false;
	         }
         		
         	for ($n=0;$n<count($this->firm_category);$n++)
	 		 {    
		 		$sql="INSERT INTO firms_category_list SET category_id='". $this->firm_category[$n]."' , firm_id='".$this->id."'";
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
         
	     
                
	//**************************************** Качваме Таговете **************************************
         
         $sql = sprintf("DELETE FROM firm_tags WHERE firmID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
			         	
         $sql = sprintf("INSERT INTO firm_tags SET tags = '%s',
	      											  firmID = %d
	      											   ON DUPLICATE KEY UPDATE
	      											    tags = '%s',
		      										     firmID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         $this->conn->setsql($sql);
         $this->conn->insertDB();
         
    //***********************************************************************************************
      
    

         
         
         $logoPic = new Upload($this->logo);
         if ($logoPic->uploaded) {
         $logoPic->image_convert      = 'jpg';
         $logoPic->file_new_name_body = $this->id."_logo";
         $logoPic->image_resize       = true;
         $logoPic->image_x            = 140;
         $logoPic->image_ratio_y      = true;
         $logoPic->file_overwrite     = true;
         $logoPic->file_auto_rename   = false;
         $logoPic->process('pics/firms/');
         $logoPic->clean();
         }
        
         

         if(is_array($upPicfirm) && (count($upPicfirm) > 0)) {
            $files = array();
            foreach ($upPicfirm as $k => $l) {
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
               	
               	  $imgBig = imagefirmExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('pics/firms/');

                  if ($upPic->processed) {
                  	
                  	 $imgThumb = imagefirmExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('pics/firms/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class firm: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class firm: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO firm_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  firmID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  firmID = %d
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
     
				if(file_exists("videos/firms/".$video_name.".flv"))
				{
					@unlink("videos/firms/".$video_name.".flv");
					@unlink("videos/firms/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/firms/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/firms/".$video_name.".flv";
				$path_to_tmp="videos/firms/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE firms SET has_video=1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   }			      
	//=============================================================================================================
	
	
	
	
		//+++++++++++++++++++++++++++++++++++++ SEND MAIL +++++++++++++++++++++++++++++++++++++++++++++++++
      
      		//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			
			$body  = "<br /><br /><a href='http://GoZbiTe.Com/вход,вход_в_системата_на_кулинарния_портал_GoZbiTe.Com.html'><img style='border: 0px;' src='http://GoZbiTe.Com/images/logce.png'></a><br /><br />";			  	
		  	$body .= "<br /><br />В портала GoZbiTe.Com е редактирана информацията за Заведение/Фирма ".addslashes($this->name)." със следните данни: <br /><br />";
	        $body .= "<br />Потребителско име: ".$this->username;
			$body .= "<br />Парола (кодирана): ".$_REQUEST['password'];
			$body .= "<br />Наименование: ".$this->name;
			$body .= "<br />Лице за контакти: ".$this->manager;
			$body .= "<br />Телефон: ".$this->phone;
			$body .= "<br />Адрес: ".$this->address;
			$body .= "<br />Е-мейл: ".$this->email;
			$body .= "<br />Уеб Сайт: ".$this->web;
			$body .= "<br />Местоположение: ".get_location_nameBylocationID($this->location_id);
			$body .= "<br />Описание: ".$this->description;
			$body  = eregi_replace("[\]",'',$body);
			
								                     
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Redaktiran profil na ".addslashes($this->name)." v GoZbiTe.Com";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 3;
			$mail->ClearAddresses();
			$mail->AddAddress($this->email);
			$mail->AddCC("office@gozbite.com");
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!$mail->Send()) {
			 // echo "Грешка при изпращане: " . $mail->ErrorInfo; 
			} else {
			 // echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
			}
      	
      //++++++++++++++++++++++++++++++++++++++++++ END MAIL ++++++++++++++++++++++++++++++++++++++++++++++++++
      		
         
      
      
		
         return true;
      } //End Update

      
      
      /*== DELETE firm PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class firm: In deletePic firm_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class firm: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('pics/firms/'.$picFile))
               if(!@unlink('pics/firms/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class firm: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM firm_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('pics/firms/'.$thumbnail)) if(!@unlink('pics/firms/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class firm: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('pics/firms/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE firms SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

      
   //*=============== DELETE doctor VIDEO ====================*/
    
      function deleteVideo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class bolest: In deleteVideo bolest_ID is not set";
            return false;
         }

         $videoFile    	= $this->id.".flv";
         $thumbnail  	= $this->id."_thumb.jpg";

         if(strlen($videoFile) > 0) {
            if(is_file('videos/firms/'.$videoFile))
               if(!@unlink('videos/firms/'.$videoFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$videoFile." cannot be deleted!";
                  return false;
               }
          }

         if(strlen($thumbnail) > 0) {
            if(is_file('videos/firms/'.$thumbnail))
             if(!@unlink('videos/firms/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('videos/firms/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE firms SET has_video = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	      
         return true;
      }

   //========================================================== 
     
      
        
      /*== DELETE firm Logo ==*/
      function deleteLogo($picFile) {
         
      	if(strlen($picFile) > 0) {
            if(is_file('pics/firms/'.$picFile))
               if(!@unlink('pics/firms/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class firm: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
              }
            
         }

         return true;
      }

    

      /*== DELETE firm ==*/
      function deletefirm() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class firm: In deleteOffr firm_ID is not set";
            return false;
         }

        
    $sql = sprintf("DELETE FROM firms WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         $offPcs = glob('pics/firms/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class firm: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }


     // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("videos/firms/".$video_name.".flv"))
				{
					@unlink("videos/firms/".$video_name.".flv");
				}
				if(file_exists("videos/firms/".$video_name."._thumb.jpg"))
				{
					@unlink("videos/firms/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	
	

     
	//**************************************** Изтриваме Таговете **************************************
         
         $sql = sprintf("DELETE FROM firm_tags WHERE firmID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
		    	
     //***********************************************************************************************
         
	 
	 
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
	
	
      	$sql=sprintf("DELETE FROM firm_pics WHERE firmID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
		
		$sql=sprintf("DELETE FROM recipes WHERE firm_id = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
		$sql=sprintf("DELETE FROM drinks WHERE firm_id = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
		
		$sql=sprintf("DELETE FROM guides WHERE firm_id = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
		$sql=sprintf("DELETE FROM posts WHERE autor_type = 'firm' AND autor = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
		
	
	
     	// --------------Iztrivame i kategoriite na firmata --------------
		$sql = sprintf("DELETE FROM  firms_category_list WHERE firm_id = %d", $this->id);
     	$this->conn->setsql($sql);
     	$this->conn->updateDB();
     	if($this->conn->error) {
        	for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
           	$this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
        	}
        	return false;
     	}
	
     	
     	// --------------Iztrivame i ot LOG tablicata --------------
	$sql = sprintf("DELETE FROM  log_firm WHERE firm_id = %d", $this->id);
     	$this->conn->setsql($sql);
     	$this->conn->updateDB();
     	if($this->conn->error) 
	{
		for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
	   	$this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
		}
		return false;
     	}
     	
     	
     	
     	
         return true;
      } //End Delete

		

   } //Class firm
?>
