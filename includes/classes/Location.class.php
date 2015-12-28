<?php
   require_once("includes/classes/Upload.class.php");
   class Location {
      var $conn;
      var $id;
      var $location_category;
      var $location_category_name;
      var $username;
      var $password;
      var $first_name;
      var $last_name;
      var $location;
      var $location_id;
      var $updated_by;
      var $updated_on;      
      var $registered_on;   
      var $info;
      var $has_pic;
      var $has_video;
      var $locationRow;
      var $userID;
      var $tags;
      var $youtube_video;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Location($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //location

      
      
      function load() 
      {
         if(isset($this->whereclause) or isset($this->orderClause) or isset($this->limitClause)) 
         {
         
		  		 $sql=sprintf("SELECT l.id as 'locationID',
									   l.name as 'location_name',
										lt.name as 'locType', 
										 l.info as 'info',
										  l.autor_type as 'autor_type',
										   l.autor as 'autor',
										    l.latinName as 'latinName',
										     l.loc_type_id as 'loc_type_id',
										      l.parent_id as 'parent_id',
										       l.level as 'level',
										        l.searchRate as 'searchRate',
										         l.root_loc_string as 'root_loc_string',
										          l.latitude as 'latitude',
										           l.longitude as 'longitude',
										            l.rating as 'rating',
										             l.times_rated as 'times_rated',
										              l.youtube_video as 'youtube_video'
										               FROM locations l,
										                location_types lt
												         WHERE l.loc_type_id = lt.id AND 1=1
												          %s  %s  %s ", $this->whereClause, $this->orderClause, $this->limitClause);

			     	 	 	     	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	
            $this->conn->setsql($sql);
            $this->conn->getTableRows();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->locationRow = $this->conn->result;
			$this->locationRowsCount = $this->conn->numberrows;
            
            
            if($this->locationRowsCount > 0)
            { 
		        // Get Type Categories
				for($k = 0; $k < $this->locationRowsCount; $k++)
				{
				            
		      
						            
		                      
	            // ============================= PICTURES =========================================
				           
					$sql="SELECT * FROM location_pics WHERE locationID='".$this->locationRow[$k]['locationID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->locationRow[$k]['numPics']  	= $this->conn->numberrows;
					$resultLocationsPics[$k] 			= $this->conn->result;	
					
					for($i = 0; $i < $this->locationRow[$k]['numPics']; $i++) {
						$this->locationRow[$k]['resultPics']['url_big'][$i] 	= $resultLocationsPics[$k][$i]["url_big"];
						$this->locationRow[$k]['resultPics']['url_thumb'][$i] 	= $resultLocationsPics[$k][$i]["url_thumb"];
					}
			
					
	
				// =============================== Cnt ========================================	
		
		
					$sql="SELECT location_id, SUM(cnt) as 'cnt' FROM log_location WHERE location_id='".$this->locationRow[$k]['locationID']."' GROUP BY location_id LIMIT 1";
					$this->conn->setsql($sql);
					$this->conn->getTableRow();
					$this->locationRow[$k]['cnt'] 	= $this->conn->result['cnt'];					
					
				// =============================== COMMENTS ========================================	
				
					
					$sql="SELECT commentID, sender_name , sender_email , autor_type, autor, comment_body , parentID , created_on  FROM location_comment WHERE locationID='".$this->locationRow[$k]['locationID']."' ORDER BY created_on DESC";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->locationRow[$k]['numComments'] 	= $this->conn->numberrows;
					$resultLocationsComment[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->locationRow[$k]['numComments']; $i++) {
						$this->locationRow[$k]['Comments'][$i] = $resultLocationsComment[$k][$i];					
					}
					
					
					
					//--------------------------- TAGS ------------------------------------------
		
					$sql="SELECT * FROM location_tags WHERE locationID='".$this->locationRow[$k]['locationID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$postTagsCount 		= $this->conn->numberrows;
					$resultLocationsTags[$k]= $this->conn->result;	
						
					if($postTagsCount > 0) {
						$this->locationRow[$k]['Tags'] = explode(',',$resultLocationsTags[$k][$i]['tags']);					
					}
					$this->locationRow[$k]['numTags'] = count($this->locationRow[$k]['Tags']);
					
					
					
					
					
				}   
	              
				
			         
	            foreach($this->locationRow as $locationRow)
	            {	            	
	            	$finalResults[$locationRow['locationID']] = $locationRow;	            		            	
	            }
           
            	return $finalResults;
            }
            
            return false;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class post: In prepareLoadQuery post_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      
      
      

      /*== CREATE location ==*/
      function create($upPicLocation) 
      {

    
     
      //+++++++++++++++++++++++++++++++++++++ SEND MAIL +++++++++++++++++++++++++++++++++++++++++++++++++
   
      		//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			
			$body = "<br /><br />Приета е заявка за описване на Дестинация със следните данни:<br /><br />";
	        $body .= "<br />Наименование: ".$this->locType.' '.$this->name;
			$body .= "<br />Описание: ".$this->info;
			$body .= "<br />Автор: ".$this->autor;
			$body .= "<br />Тип на Автора: ".$this->autor_type;
			 $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Nova Destinaciq v GoZbiTe.Com";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress("office@gozbite.com");
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!$mail->Send()) {
			 // echo "Грешка при изпращане: " . $mail->ErrorInfo; 
			} else {
			 // echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
			}
      	
	
      //++++++++++++++++++++++++++++++++++++++++++ END MAIL ++++++++++++++++++++++++++++++++++++++++++++++++++
      
			
		$this->info = removeBadTags($this->info);		// Remove Bad tags from text
			
		
			                                   	
    	$sql = sprintf("INSERT INTO locations SET name = '%s',
	                                   			 autor_type = '%s',
	                                   			  autor = %d,
	                                   			   youtube_video = '%s',
	                                   			  	info = '%s',
	                                   				 loc_type_id = %d,
	                                               	  latitude = '%s',
	                                   				   longitude = '%s'
                                             		    ON DUPLICATE KEY UPDATE
                                                       name = '%s',
	                                   				  autor_type = '%s',
	                                   			 	 autor = %d,
	                                   			 	youtube_video = '%s',
	                                   			   info = '%s',
	                                   	   		  loc_type_id = %d,
	                                     		 latitude = '%s',
	                                   			longitude = '%s'
	                                   			",
    											 $this->location_name,
                                               	  $this->autor_type,
                                              	   $this->autor,
                                              	    $this->youtube_video,
                                     	   			 $this->info,                                  
                                					  $this->loc_type_id,                                  
								              		   $this->latitude,                                  
								              			$this->longitude,
                                					   $this->location_name,
                                					  $this->autor_type,
                                              	     $this->autor,
                                                    $this->youtube_video,
								                   $this->info,
								                  $this->loc_type_id,                                  
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

         
         
         
         
           
			// =================================== SEND MAIL TO USER =========================================
			
						//error_reporting(E_ALL);
					error_reporting(E_STRICT);
					
					date_default_timezone_set('Europe/Sofia');
					//date_default_timezone_set(date_default_timezone_get());
					
					include_once('phpmailer/class.phpmailer.php');
					
					$mail             = new PHPMailer();
					$mail->CharSet       = "UTF-8";
					$mail->IsSendmail(); // telling the class to use SendMail transport
					
					$body  = "<a href='http://GoZbiTe.Com/вход,вход_в_системата_на_кулинарния_портал_GoZbiTe.Com.html'><img  style='border: 0px;' src='http://GoZbiTe.Com/images/logce.png'></a><br /><br />";			  	
		  			$body .= "Здравейте, ".(($_SESSION['user_type']=='user')?get_user_nameByUserID($_SESSION['userID']):get_firm_nameByFirmID($_SESSION['userID']))."<br /><br />";			  	
		  			$body .= "<br /><br />Вие току-що публикувахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Описание на Дестинация/Населено място със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=locations&locationD=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да го редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=locations&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Novo Naseleno Mqsto / Destinaciq в GoZbiTe.Com";
					$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
					$mail->MsgHTML($body);
					
					$mail->Priority = 1;
					$mail->ClearAddresses();
					$mail->AddAddress($_SESSION['email']);
					
					//$mail->ClearAttachments();
					//$mail->AddAttachment("images/phpmailer.gif");             // attachment
					
					if(!$mail->Send()) {
					 // echo "Грешка при изпращане: " . $mail->ErrorInfo; 
					} else {
					 // echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
					}
		      	
							
			
			// ===============================================================================================
			
			
			
         
         
         
         
    // ------------------------------- location TAGS -------------------------
         
        if(!empty($this->tags)) 
        {         	
         		
           //**************************************** Качваме Таговете **************************************
         
	         $sql = sprintf("INSERT INTO location_tags SET tags = '%s',
		      											  locationID = %d
		      											   ON DUPLICATE KEY UPDATE
		      											    tags = '%s',
			      										     locationID = %d
	      											   		 ",
	      											        $this->tags,
	      											       $this->id,
	      											      $this->tags,
	      											     $this->id);
	         	$this->conn->setsql($sql);
	         	$this->conn->insertDB();
	         
	         //***********************************************************************************************
         
         }
	// ----------------------------------------------------------------------------------
         
        
       
         
         // ====================================== USER/FIRM cnt_location  ========================================
         						
			$sql="UPDATE ".(($_SESSION['user_type']=='user')?'users':'firm')." SET cnt_location = (cnt_location+1) WHERE username='".$_SESSION['valid_user']."'";
			$this->conn->setsql($sql);
			$this->conn->updateDB();
	
    		$_SESSION['cnt_location']++;	     

         // =====================================================================================================
         

         if(is_array($upPicLocation) && (count($upPicLocation) > 0)) {
            $files = array();
            foreach ($upPicLocation as $k => $l) {
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
                  $upPic->process('pics/locations/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('pics/locations/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class location: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class location: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO location_pics SET url_big = '%s',
		      												   url_thumb = '%s',
		      												    locationID = %d		
		      												ON DUPLICATE KEY UPDATE		      											
		      												    url_big = '%s',
			      											   url_thumb = '%s',
			      											  locationID = %d
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

         $this->has_pic = is_file('pics/locations/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE locations SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
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
     
				if(file_exists("videos/locations/".$video_name.".flv"))
				{
					@unlink("videos/locations/".$video_name.".flv");
					@unlink("videos/locations/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/locations/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/locations/".$video_name.".flv";
				$path_to_tmp="videos/locations/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE locations SET has_video = 1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   		}		      
	//=============================================================================================================
	
                
	 
			// ----------- Пращаме мейл до всички приятели на този потребител и ги уведомяваме за това действие (SAMO ZA USER-i!!!) ---------- //
			
				if($this->user_id > 0)
				{
					if($this->user_id != 1) // За админ не пращаме нищо
					{

						$linkToAutor = '<a href="http://GoZbiTe.Com/разгледай-потребител-'.$this->user_id.','.str_replace(" ","_",get_recipe_user_name_BY_userID($this->user_id)).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.get_recipe_user_name_BY_userID($this->user_id).'</a>';
						$linkToLocation = '<a href="http://GoZbiTe.Com/разгледай-дестинация-'.$this->id.','.str_replace(" ","_",$this->location_name).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.$this->location_name.'</a>';
												
						$sql="SELECT * FROM friendships WHERE (sender = '".$this->user_id."' OR recipient = '".$this->user_id."') AND friendship_accepted = '1'";
				    	$this->conn->setsql($sql);
				    	$this->conn->getTableRows();
						$numFriends = $this->conn->numberrows;
				    	$resultFriends = $this->conn->result;      
				    	
				    	if($numFriends > 0)
				    	{
					    	for($n=0; $n<$numFriends; $n++) 
							{	
						
							 	$sql="SELECT * FROM users WHERE userID = '".($resultFriends[$n]['sender'] == $this->user_id ? $resultFriends[$n]['recipient'] : $resultFriends[$n]['sender'])."' LIMIT 1";
						    	$this->conn->setsql($sql);
						    	$this->conn->getTableRow();
								$resultFriendDetails = $this->conn->result;
								
								$FriendName = $resultFriendDetails['first_name'].' '.$resultFriendDetails['last_name'];
								$FriendEmail = $resultFriendDetails['email'];
								
								if($resultFriendDetails['userID'] == 1)
								{
									$FriendName = 'Админ';
								}
								
								
								$bodyForFriends = "Здравейте ".$FriendName.",<br /><br />Вашият приятел ".$linkToAutor." в кулинарния портал GoZbiTe.Com току-що публикувано описание на Дестинация/Населено място - ".$linkToLocation."<br /><br />";
						        $bodyForFriends = eregi_replace("[\]",'',$bodyForFriends);
													
					            $mail->Subject    = "Vash priqtel dobavi napitka v GoZbiTe.Com";
								$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
								$mail->MsgHTML($bodyForFriends);
								
								$mail->Priority = 2;
								$mail->ClearAddresses();
								$mail->AddAddress($FriendEmail);
								
								if(!$mail->Send()) {
								 // echo "Грешка при изпращане: " . $mail->ErrorInfo; 
								} else {
								 // echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
								}				
					
								
							}
				    	}
				    	
					}
		      
				}
							
			// ----------------------------------------------------------------------------------------------------------- //
      	

			
			
         
         return true;
      } //End Create

      /*== UPDATE location ==*/
      function update($upPicLocation) 
      {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class location: In update location_ID is not set";
            return false;
         }
	
          
         
      //+++++++++++++++++++++++++++++++++++++ SEND MAIL +++++++++++++++++++++++++++++++++++++++++++++++++
   
      		//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			
			$body = "<br /><br />Приета е заявка за редактиране на Дестинация със следните данни:<br /><br />";
	        $body .= "<br />Наименование: ".$this->locType.' '.$this->name;
			$body .= "<br />Описание: ".$this->info;
			$body .= "<br />Автор: ".$this->autor;
			$body .= "<br />Тип на Автора: ".$this->autor_type;
			 $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Redaktirana Destinaciq v GoZbiTe.Com";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress("office@gozbite.com");
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!$mail->Send()) {
			 // echo "Грешка при изпращане: " . $mail->ErrorInfo; 
			} else {
			 // echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
			}
      	
	
      //++++++++++++++++++++++++++++++++++++++++++ END MAIL ++++++++++++++++++++++++++++++++++++++++++++++++++
      
       		 
			// ----------- Пращаме мейл до всички приятели на този потребител и ги уведомяваме за това действие (SAMO ZA USER-i!!!) ---------- //
			
				if($this->user_id > 0)
				{
					if($this->user_id != 1) // За админ не пращаме нищо
					{

						$linkToAutor = '<a href="http://GoZbiTe.Com/разгледай-потребител-'.$this->user_id.','.str_replace(" ","_",get_recipe_user_name_BY_userID($this->user_id)).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.get_recipe_user_name_BY_userID($this->user_id).'</a>';
						$linkToLocation = '<a href="http://GoZbiTe.Com/разгледай-дестинация-'.$this->id.','.str_replace(" ","_",$this->location_name).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.$this->location_name.'</a>';
												
						$sql="SELECT * FROM friendships WHERE (sender = '".$this->user_id."' OR recipient = '".$this->user_id."') AND friendship_accepted = '1'";
				    	$this->conn->setsql($sql);
				    	$this->conn->getTableRows();
						$numFriends = $this->conn->numberrows;
				    	$resultFriends = $this->conn->result;      
				    	
				    	if($numFriends > 0)
				    	{
					    	for($n=0; $n<$numFriends; $n++) 
							{	
						
							 	$sql="SELECT * FROM users WHERE userID = '".($resultFriends[$n]['sender'] == $this->user_id ? $resultFriends[$n]['recipient'] : $resultFriends[$n]['sender'])."' LIMIT 1";
						    	$this->conn->setsql($sql);
						    	$this->conn->getTableRow();
								$resultFriendDetails = $this->conn->result;
								
								$FriendName = $resultFriendDetails['first_name'].' '.$resultFriendDetails['last_name'];
								$FriendEmail = $resultFriendDetails['email'];
								
								if($resultFriendDetails['userID'] == 1)
								{
									$FriendName = 'Админ';
								}
								
								
								$bodyForFriends = "Здравейте ".$FriendName.",<br /><br />Вашият приятел ".$linkToAutor." в кулинарния портал GoZbiTe.Com току-що редактира описание на населено място - ".$linkToLocation."<br /><br />";
						        $bodyForFriends = eregi_replace("[\]",'',$bodyForFriends);
													
					            $mail->Subject    = "Vash priqtel redaktira napitka v GoZbiTe.Com";
								$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
								$mail->MsgHTML($bodyForFriends);
								
								$mail->Priority = 2;
								$mail->ClearAddresses();
								$mail->AddAddress($FriendEmail);
								
								if(!$mail->Send()) {
								 // echo "Грешка при изпращане: " . $mail->ErrorInfo; 
								} else {
								 // echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
								}				
					
								
							}
				    	}
				    	
					}
		      
				}
							
			// ----------------------------------------------------------------------------------------------------------- //
      	

			
			
		$this->info = removeBadTags($this->info);		// Remove Bad tags from text
		
			
			$sql = sprintf("UPDATE locations SET autor_type = '%s',
	                                   			  autor = %d,
	                                   			   youtube_video = '%s',
	                                   			  	info = '%s',
	                                   				 latitude = '%s',
	                                   				  longitude = '%s'
                                             		   WHERE id = %d",
    											 	   $this->autor_type,
                                              	   	  $this->autor,
                                              	     $this->youtube_video,
                                     	   			$this->info,                                  
                                				   $this->latitude,                                  
								              	  $this->longitude,
								              	 $this->id);
              	
		
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrUpdt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

        
         
         
         
         
         
         
           
			// =================================== SEND MAIL TO USER =========================================
			
						//error_reporting(E_ALL);
					error_reporting(E_STRICT);
					
					date_default_timezone_set('Europe/Sofia');
					//date_default_timezone_set(date_default_timezone_get());
					
					include_once('phpmailer/class.phpmailer.php');
					
					$mail             = new PHPMailer();
					$mail->CharSet       = "UTF-8";
					$mail->IsSendmail(); // telling the class to use SendMail transport
					
					$body  = "<a href='http://GoZbiTe.Com/вход,вход_в_системата_на_кулинарния_портал_GoZbiTe.Com.html'><img style='border: 0px;' src='http://GoZbiTe.Com/images/logce.png'></a><br /><br />";			  	
		  			$body .= "Здравейте, ".(($_SESSION['user_type']=='user')?get_user_nameByUserID($_SESSION['userID']):get_firm_nameByFirmID($_SESSION['userID']))."<br /><br />";			  	
		  			$body .= "<br /><br />Вие току-що редактирахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Описание на Дестинация/Населено място със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=locations&locationD=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да го редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=locations&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Redaktirana Naseleno Mqsto / Destinaciq в GoZbiTe.Com";
					$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
					$mail->MsgHTML($body);
					
					$mail->Priority = 1;
					$mail->ClearAddresses();
					$mail->AddAddress($_SESSION['email']);
					
					//$mail->ClearAttachments();
					//$mail->AddAttachment("images/phpmailer.gif");             // attachment
					
					if(!$mail->Send()) {
					 // echo "Грешка при изпращане: " . $mail->ErrorInfo; 
					} else {
					 // echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
					}
		      	
							
			
			// ===============================================================================================
			
			
			
         
         
         
         
         
              
 	//**************************************** Качваме Таговете **************************************
         
         $sql = sprintf("DELETE FROM location_tags WHERE locationID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();

         if(!empty($this->tags))	
         {
	         $sql = sprintf("INSERT INTO location_tags SET tags = '%s',
		      											  locationID = %d
		      											   ON DUPLICATE KEY UPDATE
		      											    tags = '%s',
			      										     locationID = %d
	      											   		 ",
	      											        $this->tags,
	      											       $this->id,
	      											      $this->tags,
	      											     $this->id);
	         $this->conn->setsql($sql);
	         $this->conn->insertDB();
         }
    //***********************************************************************************************
      	
         
              
         
         
         if(is_array($upPicLocation) && (count($upPicLocation) > 0)) {
            $files = array();
            foreach ($upPicLocation as $k => $l) {
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
               	
               	  $imgBig = imageLocationExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('pics/locations/');

                  if ($upPic->processed) {
                  	
                  	 $imgThumb = imageLocationExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('pics/locations/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class location: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class location: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO location_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  locationID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  locationID = %d
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
     
				if(file_exists("videos/locations/".$video_name.".flv"))
				{
					@unlink("videos/locations/".$video_name.".flv");
					@unlink("videos/locations/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/locations/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce) ;				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/locations/".$video_name.".flv";
				$path_to_tmp="videos/locations/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE locations SET has_video=1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
   	}							
				      
	//=============================================================================================================
		
		
         return true;
      } //End Update

      
      
      /*== DELETE location PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class location: In deletePic location_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class location: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('pics/locations/'.$picFile))
               if(!@unlink('pics/locations/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class location: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM location_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('pics/locations/'.$thumbnail)) if(!@unlink('pics/locations/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class location: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('pics/locations/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE locations SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    
      
    /*=============== DELETE location VIDEO ====================*/
    
      function deleteVideo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class location: In deleteVideo location_ID is not set";
            return false;
         }

         $videoFile    	= $this->id.".flv";
         $thumbnail  	= $this->id."_thumb.jpg";

         if(strlen($videoFile) > 0) {
            if(is_file('videos/locations/'.$videoFile))
               if(!@unlink('videos/locations/'.$videoFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class location: In deleteVideo -> The file ".$videoFile." cannot be deleted!";
                  return false;
               }
          }

         if(strlen($thumbnail) > 0) {
            if(is_file('videos/locations/'.$thumbnail))
             if(!@unlink('videos/locations/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class location: In deleteVideo -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('videos/locations/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE locations SET has_video = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	      
         return true;
      }

   //========================================================== 
     
      

      /*== DELETE location ==*/
      function deleteLocation() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class location: In deleteOffr location_ID is not set";
            return false;
         }

        

         $offPcs = glob('pics/locations/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class location: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         
    // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("videos/locations/".$video_name.".flv"))
				{
					@unlink("videos/locations/".$video_name.".flv");
				}
				if(file_exists("videos/locations/".$video_name."._thumb.jpg"))
				{
					@unlink("videos/locations/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	
		$sql=sprintf("UPDATE %s SET cnt_location = (cnt_location-1) WHERE %s = %d",($this->autor_type=='user')?'users':'firms' ,($this->autor_type=='user')?'userID':'id' ,  $this->autor);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
			
		$_SESSION['cnt_location']--;
			
		
		
		
		
		
			

         $sql = sprintf("DELETE FROM locations WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
            
         
 	//**************************************** Изтриваме Таговете **************************************
         
         $sql = sprintf("DELETE FROM location_tags WHERE locationID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
		    	
     //***********************************************************************************************
      	
         
         
         
      	$sql=sprintf("DELETE FROM location_pics WHERE locationID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
	
     	
     	// --------------Iztrivame i ot LOG tablicata --------------
		$sql = sprintf("DELETE FROM  log_location WHERE location_id = %d", $this->id);
     	$this->conn->setsql($sql);
     	$this->conn->updateDB();
     	if($this->conn->error) {
        	for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
           	$this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
        	}
        	return false;
     	}
     	
	
     	      
	//+++++++++++++++++++++++++++++++++++++ SEND MAIL +++++++++++++++++++++++++++++++++++++++++++++++++
   
      		//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			
			$body = "<br /><br />Приета е заявка за изтриване на Дестинация със следните данни:<br /><br />";
	        $body .= "<br />ID: ".$this->id;
			$body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Iztrivane na Destinaciq v GoZbiTe.Com";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress("office@gozbite.com");
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!$mail->Send()) {
			 // echo "Грешка при изпращане: " . $mail->ErrorInfo; 
			} else {
			 // echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
			}
      	
	
      //++++++++++++++++++++++++++++++++++++++++++ END MAIL ++++++++++++++++++++++++++++++++++++++++++++++++++
      
		
     	
     	
         return true;
      } //End Delete

		

   } //Class location
?>
