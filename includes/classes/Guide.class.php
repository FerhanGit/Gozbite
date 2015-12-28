<?php
   require_once("includes/classes/Upload.class.php");
   class Guide {
      var $conn;
      var $id;
      var $guide_category;
      var $guide_category_name;
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
      var $guideRow;
      var $userID;
      var $tags;
      var $youtube_video;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Guide($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //guide

      
       function load() 
      {
         if(isset($this->whereclause) or isset($this->orderClause) or isset($this->limitClause)) 
         {
         
		  		 $sql=sprintf("SELECT g.id as 'guideID',
									   g.title as 'title',
										g.info as 'info',
										 g.firm_id as 'firm_id',
										  g.user_id as 'user_id',
										   g.is_VIP as 'is_VIP',
										    g.is_Promo as 'is_Promo',
										     g.is_Silver as 'is_Silver',
										      g.is_Gold as 'is_Gold',
										       g.rating as 'rating',
										        g.times_rated as 'times_rated',
										         g.has_pic as 'has_pic',
										          g.has_video as 'has_video',
										           g.youtube_video as 'youtube_video',
										            g.registered_on as 'registered_on',
										             g.updated_by as 'updated_by',
									    		      g.updated_on as 'updated_on',
									    		       g.activated_deactivated_by as 'activated_deactivated_by',
									    		        g.active as 'active'
											  		     FROM guides g
												          WHERE 1=1
												           %s  %s  %s ", $this->whereClause, $this->orderClause, $this->limitClause);

		      	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	
            $this->conn->setsql($sql);
            $this->conn->getTableRows();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->guideRow = $this->conn->result;
			$this->guideRowsCount = $this->conn->numberrows;
            
            
            if($this->guideRowsCount > 0)
            { 
		        // Get Type Categories
				for($k = 0; $k < $this->guideRowsCount; $k++)
				{
				    
					
					
				//------------- FIRM AND HOTELS ----------------------------------------------------
			
					if($this->guideRow[$k]['firm_id'] > 0)
					{
						$sql="SELECT  f.name as 'firm', f.email as 'email', f.phone as 'phone', fc.id as 'firm_cat_id', fc.name as 'firm_cat_name', f.location_id as 'location_id', f.cnt_guide as 'cnt_guide' FROM guides g, firms f, firms_category_list fcl, firm_category fc  WHERE f.id = g.firm_id AND fcl.firm_id = f.id AND fc.id = fcl.category_id AND f.id = '".$this->guideRow[$k]['firm_id']."' ";
						$this->conn->setsql($sql);
						$this->conn->getTableRow();
						$this->guideRow[$k]['Firm'] = $this->conn->result;
						
					}
					
					if($this->guideRow[$k]['user_id'] > 0)
					{						
						$sql="SELECT userID as 'userID', CONCAT(first_name, ' ', last_name) as 'user', email as 'email', location_id as 'location_id', cnt_guide as 'cnt_guide' FROM users WHERE userID = '".$this->guideRow[$k]['user_id']."' ";
						$this->conn->setsql($sql);
						$this->conn->getTableRow();
						$this->guideRow[$k]['User'] = $this->conn->result;
						
					}
					
					
				// =================================================================================
	
	
	
	
				
				
		                      
	            // ============================= PICTURES =========================================
				           
					$sql="SELECT * FROM guide_pics WHERE guideID='".$this->guideRow[$k]['guideID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->guideRow[$k]['numPics']  	= $this->conn->numberrows;
					$resultGuidesPics[$k] 			= $this->conn->result;	
					
					for($i = 0; $i < $this->guideRow[$k]['numPics']; $i++) {
						$this->guideRow[$k]['resultPics']['url_big'][$i] 	= $resultGuidesPics[$k][$i]["url_big"];
						$this->guideRow[$k]['resultPics']['url_thumb'][$i] 	= $resultGuidesPics[$k][$i]["url_thumb"];
					}
			
					
	
				// =============================== Cnt ========================================	
		
		
					$sql="SELECT guide_id, SUM(cnt) as 'cnt' FROM log_guide WHERE guide_id='".$this->guideRow[$k]['guideID']."' GROUP BY guide_id LIMIT 1";
					$this->conn->setsql($sql);
					$this->conn->getTableRow();
					$this->guideRow[$k]['cnt'] 	= $this->conn->result['cnt'];					
					
				// =============================== COMMENTS ========================================	
				
					
					$sql="SELECT commentID, sender_name , sender_email , autor_type, autor, comment_body , parentID , created_on  FROM guide_comment WHERE guideID='".$this->guideRow[$k]['guideID']."' ORDER BY created_on DESC";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->guideRow[$k]['numComments'] 	= $this->conn->numberrows;
					$resultGuidesComment[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->guideRow[$k]['numComments']; $i++) {
						$this->guideRow[$k]['Comments'][$i] = $resultGuidesComment[$k][$i];					
					}
					
					
					
					//--------------------------- TAGS ------------------------------------------
		
					$sql="SELECT * FROM guide_tags WHERE guideID='".$this->guideRow[$k]['guideID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$postTagsCount 		= $this->conn->numberrows;
					$resultGuidesTags[$k]= $this->conn->result;	
						
					if($postTagsCount > 0) {
						$this->guideRow[$k]['Tags'] = explode(',',$resultGuidesTags[$k][$i]['tags']);					
					}
					$this->guideRow[$k]['numTags'] = count($this->guideRow[$k]['Tags']);
					
					
					
					
					
				}   
	              
	                  
	            foreach($this->guideRow as $guideRow)
	            {
	            	if((($_SESSION['user_type'] == 'firm' && $_SESSION['userID'] == $guideRow['firm_id']) OR ($_SESSION['user_type'] == 'user' && $_SESSION['userID'] == $guideRow['user_id'])) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)
	            	{
	            		$finalResults[$guideRow['guideID']] = $guideRow; //  Vzemame samo aktivnite opisanie, no za avtorite i admina davame vsi4ki
	            	}
	            	elseif($guideRow['active'] == 1) 
	            	{
	            		$finalResults[$guideRow['guideID']] = $guideRow;
	            	}	
	            	
	            }
           
            	return $finalResults;
            }
            
            return false;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class post: In prepareLoadQuery post_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      
      
      
      

      /*== CREATE guide ==*/
      function create($upPicGuide) 
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
			
			
			$body = "<br /><br />Въведено е Справочно Описание със следните данни:<br /><br />";
	        $body .= "<br />Наименование: ".$this->title;
			$body .= "<br />Със снимка: ".$this->has_pic;
			$body .= "<br />Описание: ".$this->info;
			$body .= "<br />userID: ".$this->user_id;
            $body .= "<br />firmID: ".$this->firm_id;
            $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Novo Spravochno Opisanie v GoZbiTe.Com";
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
			
		
			                                   	
    	$sql = sprintf("INSERT INTO guides SET title = '%s',
	                                   			firm_id = %d,
	                                   			 user_id = %d,
	                                   			  youtube_video = '%s',
	                                   			   has_pic = %d,
                                			   	 	info = '%s',
	                                   				 active = '1',
	                                               	  updated_by = %d,
	                                   				   updated_on = NOW(),
	                                            		registered_on = NOW()
                                             			 ON DUPLICATE KEY UPDATE
                                                         title = '%s',
	                                   					firm_id = %d,
	                                   			 	   user_id = %d,
	                                   			 	  youtube_video = '%s',
	                                   			  	 has_pic = %d,
	                                   			    info = '%s',
	                                   	   		   active = '1',
	                                     		  updated_by = %d,
	                                   			 updated_on = NOW(),
	                                   			registered_on = NOW()
                                       			",
    											 $this->title,
                                               	  $this->firm_id,
                                              	   $this->user_id,
                                              	    $this->youtube_video,
                                     	   			 $this->has_pic,                                   
                                      				  $this->info,                                  
                                					   $_SESSION['userID'],
                                						$this->title,
                                						 $this->firm_id,
                                              	          $this->user_id,
                                              	 		   $this->youtube_video,
								                         	$this->has_pic,                                   
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
		  			$body .= "<br /><br />Вие току-що публикувахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Справочно Описание със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=guides&guideD=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да го редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=guides&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Novo Spravochno Opisanie v GoZbiTe.Com";
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
         
         $sql = sprintf("INSERT INTO guide_tags SET tags = '%s',
	      											  guideID = %d
	      											   ON DUPLICATE KEY UPDATE
	      											    tags = '%s',
		      										     guideID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         	$this->conn->setsql($sql);
         	$this->conn->insertDB();
         
         //***********************************************************************************************
         
         
     
         
         
         // ====================================== USER/FIRM cnt_guide  ========================================
         
	        if($this->firm_id > 0)
	        {	        	
	        	$sql = sprintf("UPDATE firms SET cnt_guide=cnt_guide+1 WHERE id = %d ",$this->firm_id);
		        $this->conn->setsql($sql);
		        $this->conn->updateDB();
		        if($this->conn->error) {
		           for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
		              $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
		        	}
	            	return false;
         		}
         		$_SESSION['cnt_guide']++;
			}  
			elseif($this->user_id > 0)
	        {
	        	$sql = sprintf("UPDATE users SET cnt_guide=cnt_guide+1 WHERE userID = %d ",$this->user_id);
		        $this->conn->setsql($sql);
		        $this->conn->updateDB();
		        if($this->conn->error) {
		           for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
		              $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
		        	}
	            	return false;
         		}
         
				$_SESSION['cnt_guide']++;
			}  
	   
         // =====================================================================================================
         

         if(is_array($upPicGuide) && (count($upPicGuide) > 0)) {
            $files = array();
            foreach ($upPicGuide as $k => $l) {
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
                  $upPic->process('pics/guides/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('pics/guides/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class guide: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class guide: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO guide_pics SET url_big = '%s',
		      												   url_thumb = '%s',
		      												    guideID = %d		
		      												ON DUPLICATE KEY UPDATE		      											
		      												    url_big = '%s',
			      											   url_thumb = '%s',
			      											  guideID = %d
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

         $this->has_pic = is_file('pics/guides/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE guides SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
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
     
				if(file_exists("videos/guides/".$video_name.".flv"))
				{
					@unlink("videos/guides/".$video_name.".flv");
					@unlink("videos/guides/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/guides/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/guides/".$video_name.".flv";
				$path_to_tmp="videos/guides/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE guides SET has_video = 1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   		}		      
	//=============================================================================================================
	
              
	 
	 
			// ----------- Пращаме мейл до всички приятели на този потребител и ги уведомяваме за това действие (SAMO ZA USER-i!!!) ---------- //
			
				if($this->user_id > 0)
				{
					if($this->user_id != 1) // За админ не пращаме нищо
					{

						$linkToAutor = '<a href="http://GoZbiTe.Com/разгледай-потребител-'.$this->user_id.','.str_replace(" ","_",get_guide_user_name_BY_userID($this->user_id)).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">'.get_guide_user_name_BY_userID($this->user_id).'</a>';
						$linkToGuide = '<a href="http://GoZbiTe.Com/разгледай-справочник-'.$this->id.','.str_replace(" ","_",$this->title).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">'.$this->title.'</a>';
												
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
								
								
								$bodyForFriends = "Здравейте ".$FriendName.",<br /><br />Вашият приятел ".$linkToAutor." в кулинарния портал GoZbiTe.Com току-що публикува описание за - ".$linkToGuide."<br /><br />";
						        $bodyForFriends = eregi_replace("[\]",'',$bodyForFriends);
													
					            $mail->Subject    = "Vash priqtel dobavi opisanie v spravochnika na GoZbiTe.Com";
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

      /*== UPDATE guide ==*/
      function update($upPicGuide) 
      {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class guide: In update guide_ID is not set";
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
			
			
			$body = "<br /><br />Приета е заявка за редактиране на Справочно Описание със следните данни:<br /><br />";
	        $body .= "<br />Наименование: ".$this->title;
			$body .= "<br />Със снимка: ".$this->has_pic;
			$body .= "<br />Описание: ".$this->info;
			$body .= "<br />userID: ".$this->user_id;
            $body .= "<br />firmID: ".$this->firm_id;
            $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Redaktirane na Spravochno Opisanie v GoZbiTe.Com";
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

						$linkToAutor = '<a href="http://GoZbiTe.Com/разгледай-потребител-'.$this->user_id.','.str_replace(" ","_",get_guide_user_name_BY_userID($this->user_id)).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">'.get_guide_user_name_BY_userID($this->user_id).'</a>';
						$linkToGuide = '<a href="http://GoZbiTe.Com/разгледай-справочник-'.$this->id.','.str_replace(" ","_",$this->title).'_храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">'.$this->title.'</a>';
												
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
								
								
								$bodyForFriends = "Здравейте ".$FriendName.",<br /><br />Вашият приятел ".$linkToAutor." в кулинарния портал GoZbiTe.Com току-що редактира свое описание за - ".$linkToGuide."<br /><br />";
						        $bodyForFriends = eregi_replace("[\]",'',$bodyForFriends);
													
					            $mail->Subject    = "Vash priqtel redaktira opisanie v spravochnika na GoZbiTe.Com";
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
		
				
         $sql = sprintf("UPDATE guides SET title = '%s',
                                   			 firm_id = %d,
                                   			  user_id = %d,
                                   			   youtube_video = '%s',
                                   			 	has_pic = %d,
                                   				 info = '%s',
                                   			      active = '1',
                                                   updated_by = %d,
                                   				    updated_on = NOW()
                                   					 WHERE id = %d", 
         											 $this->title,
                                   					$this->firm_id,
                                              	   $this->user_id,
                                              	  $this->youtube_video,
			                                   	 $this->has_pic,                                   
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
		  			$body .= "<br /><br />Вие току-що редактирахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Справочно Описание със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=guides&guideD=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да го редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=guides&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Redaktirano Spravochno Opisanie v GoZbiTe.Com";
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
         
         $sql = sprintf("DELETE FROM guide_tags WHERE guideID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
			         	
         $sql = sprintf("INSERT INTO guide_tags SET tags = '%s',
	      											  guideID = %d
	      											   ON DUPLICATE KEY UPDATE
	      											    tags = '%s',
		      										     guideID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         $this->conn->setsql($sql);
         $this->conn->insertDB();
         
    //***********************************************************************************************
      	
         
               
         
         if(is_array($upPicGuide) && (count($upPicGuide) > 0)) {
            $files = array();
            foreach ($upPicGuide as $k => $l) {
               foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // Pics Manipulation and Upload
            
             // iztriva faila ot servera predvaritelno,predi da go zapi6e nov
              /* 	 
               	  $offPcs = glob('pics/guides/'.$this->id."_*");
         

		         if(count($offPcs) > 0) {
		            foreach($offPcs as $val) {
		               if(strlen($val) > 0) {
		                  if(!@@unlink($val)) {
		                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class guide: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
		                     return false;
		                  }
		                  
		                    $sql=sprintf("DELETE FROM guide_pics WHERE guideID = %d", $this->id);
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
               	
               	  $imgBig = imageGuideExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('pics/guides/');

                  if ($upPic->processed) {
                  	
                  	 $imgThumb = imageGuideExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('pics/guides/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class guide: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class guide: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO guide_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  guideID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  guideID = %d
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
     
				if(file_exists("videos/guides/".$video_name.".flv"))
				{
					@unlink("videos/guides/".$video_name.".flv");
					@unlink("videos/guides/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/guides/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce) ;				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/guides/".$video_name.".flv";
				$path_to_tmp="videos/guides/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE guides SET has_video=1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
   	}							
				      
	//=============================================================================================================
		
		
         return true;
      } //End Update

      
      
      /*== DELETE guide PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class guide: In deletePic guide_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class guide: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('pics/guides/'.$picFile))
               if(!@unlink('pics/guides/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class guide: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM guide_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('pics/guides/'.$thumbnail)) if(!@unlink('pics/guides/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class guide: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('pics/guides/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE guides SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    
      
    /*=============== DELETE guide VIDEO ====================*/
    
      function deleteVideo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class bolest: In deleteVideo bolest_ID is not set";
            return false;
         }

         $videoFile    	= $this->id.".flv";
         $thumbnail  	= $this->id."_thumb.jpg";

         if(strlen($videoFile) > 0) {
            if(is_file('videos/guides/'.$videoFile))
               if(!@unlink('videos/guides/'.$videoFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$videoFile." cannot be deleted!";
                  return false;
               }
          }

         if(strlen($thumbnail) > 0) {
            if(is_file('videos/guides/'.$thumbnail))
             if(!@unlink('videos/guides/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('videos/guides/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE guides SET has_video = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	      
         return true;
      }

   //========================================================== 
     
      
      
          
      /*== DELETE guide Logo ==*/
      function deleteLogo($picFile) {
             
         if(strlen($picFile) > 0) {
            if(is_file('pics/guides/'.$picFile))
               if(!@unlink('pics/guides/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class guides: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
              }
            
         }

         return true;
      }


      /*== DELETE guide ==*/
      function deleteGuide() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class guide: In deleteOffr guide_ID is not set";
            return false;
         }

        
         
         
         $sql = sprintf("DELETE FROM guides WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
            
                 
         

         $offPcs = glob('pics/guides/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class guide: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         
    // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("videos/guides/".$video_name.".flv"))
				{
					@unlink("videos/guides/".$video_name.".flv");
				}
				if(file_exists("videos/guides/".$video_name."._thumb.jpg"))
				{
					@unlink("videos/guides/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	
	
			// ====================================== USER/FIRM cnt_guide  ========================================
         
				$sql="SELECT g.title as 'title', g.firm_id as 'firm_id', g.user_id as 'user_id' FROM guides g WHERE g.id = '".$this->id."'";
				$this->conn->setsql($sql);
				$this->conn->getTableRow();
				$resultGuideToDelete=$this->conn->result;
				
	
	        if($resultGuideToDelete['firm_id'] > 0)
	        {
	        	$sql=sprintf("UPDATE firms SET cnt_guide=cnt_guide-1 WHERE id = %d ",$resultGuideToDelete['firm_id']);
	        	$this->conn->setsql($sql);
				$this->conn->updateDB();		
				$_SESSION['cnt_guide']--;
			}  
			elseif($resultGuideToDelete['user_id'] > 0)
	        {
	        	$sql=sprintf("UPDATE users SET cnt_guide=cnt_guide-1 WHERE userID = %d ",$resultGuideToDelete['user_id']);
	        	$this->conn->setsql($sql);
				$this->conn->updateDB();
				$_SESSION['cnt_guide']--;
			}  
	   
         // =====================================================================================================
         
			 
       
           
         
 	//**************************************** Изтриваме Таговете **************************************
         
         $sql = sprintf("DELETE FROM guide_tags WHERE guideID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
		    	
     //***********************************************************************************************
      	
         
         
         
      	$sql=sprintf("DELETE FROM guide_pics WHERE guideID = %d", $this->id);
		$this->this->conn->setsql($sql);
		$this->this->conn->updateDB();
		
		
	     	
     	
     	// --------------Iztrivame i ot LOG tablicata --------------
		$sql = sprintf("DELETE FROM  log_guide WHERE guide_id = %d", $this->id);
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
			
			
			$body = "<br /><br />Приета е заявка за изтриване на Справочно Описание със следните данни:<br /><br />";
	        $body .= "<br />ID: ".$this->id;
			$body .= "<br />Наименование: ".$resultGuideToDelete['title'];
			$body .= "<br />userID: ".$resultGuideToDelete['user_id'];
            $body .= "<br />firmID: ".$resultGuideToDelete['firm_id'];
            $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Iztrivane na Spravochno Opisanie v GoZbiTe.Com";
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

		

   } //Class guide
?>
