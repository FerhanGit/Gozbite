<?php
   require_once("classes/Upload.class.php");
   class Card {
      var $conn;
      var $id;
      var $card_category;
      var $card_category_name;
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
     var $cardRow;
      var $userID;
      var $tags;
      var $card_kuhni;
      var $youtube_video;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Card($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //card

      /*== PREPARE AND LOAD QUERY ==*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) 
         {
            $sql = sprintf("SELECT DISTINCT(o.id) as 'id',
								             o.title as 'title',								             
								                oc.id as 'card_category',
									              o.has_pic as 'has_pic',
										               o.has_video as 'has_video',
										                o.is_Promo as 'is_Promo',
										                 o.registered_on as 'registered_on',
										                        o.updated_by as 'updated_by',
										                         o.updated_on as 'updated_on',
											                      o.info as 'info'
											                       o.youtube_video as 'youtube_video'
											                        FROM cards o,
											                         locations l,
											                          location_types lt
											                           WHERE o.location_id = l.id
											                            AND l.loc_type_id 	= lt.id
											                             AND o.id 			= %d
							                                              ", $this->id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->cardRow = $this->conn->result;

            
            
            
            // Get CATEGORY
            $sql="SELECT rc.id as 'card_category_id', rc.name as 'card_category_name' FROM cards r, card_category rc, cards_category_list rcl WHERE rcl.card_id = r.id AND rcl.category_id = rc.id AND r.id = '".$this->id."' ";
			$this->conn->setsql($sql);
            $this->conn->getTableRows();
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++) {
                  $this->card_category[$i]= $this->conn->result[$i]["card_category_id"];
                  $this->card_category_name[$i]= $this->conn->result[$i]["card_category_name"];
               }
            }
            
            
              
			

            return true;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class card: In prepareLoadQuery card_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD card DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
         	
         	
            $this->id               = $this->cardRow["id"];
            $this->username         = $this->cardRow["username"];
            $this->password         = $this->cardRow["password"];
            $this->first_name       = $this->cardRow["first_name"];
            $this->last_name   		= $this->cardRow["last_name"];
            $this->phone            = $this->cardRow["phone"];
            $this->addr         	= $this->cardRow["address"];
            $this->email         	= $this->cardRow["email"];
            $this->web   			= $this->cardRow["web"];
            $this->location         = $this->cardRow["location"];
            $this->location_id      = $this->cardRow["location_id"];
            $this->latitude      	= $this->cardRow["latitude"];
            $this->longitude      	= $this->cardRow["longitude"];
            $this->related_hospital = $this->cardRow["related_hospital"];
            $this->updated_by       = $this->cardRow["updated_by"];
            $this->updated_on      	= $this->cardRow["updated_on"];
            $this->has_pic      	= $this->cardRow["has_pic"];
            $this->has_video      	= $this->cardRow["has_video"];
            $this->youtube_video   	= $this->cardRow["youtube_video"];
            $this->is_Promo      	= $this->cardRow["is_Promo"];
            $this->registered_on    = $this->cardRow["registered_on"];
            $this->info        		= $this->cardRow["info"];
            $this->userID			= $_SESSION['userID'];
                 
           
    
         }
      } //End Load

      /*== CREATE card ==*/
      function create($upPicCard) {

     
      
      //+++++++++++++++++++++++++++++++++++++ SEND MAIL +++++++++++++++++++++++++++++++++++++++++++++++++
   
      		//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			
			$body = "<br /><br />Приета е заявка за публикуване на картичка/покана със следните данни:<br /><br />";
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
			$mail->Subject    = "Nova Karti4ka v GoZbiTe.Com";
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
			
		
			                                   	
    	$sql = sprintf("INSERT INTO cards SET title = '%s',
	                                   			 firm_id = %d,
	                                   			  user_id = %d,
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
                                              	    $this->has_pic,                                   
                                      				  $this->info,                                  
                                					   $_SESSION['userID'],
                                						$this->title,
														 $this->firm_id,
                                              	          $this->user_id,
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

         
       // ------------------------------- card CATEGORIES -------------------------
         
        if(is_array($this->card_category) && (count($this->card_category) > 0)) 
        {         	
         		
         	for ($n=0;$n<count($this->card_category);$n++)
	 		 {    
		 		$sql="INSERT INTO cards_category_list SET category_id='". $this->card_category[$n]."' , card_id='".$this->id."'";
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
         
     
       
       
         
			

         if(is_array($upPicCard) && (count($upPicCard) > 0)) {
            $files = array();
            foreach ($upPicCard as $k => $l) {
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
                  $upPic->process('pics/cards/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('pics/cards/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class card: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class card: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO card_pics SET url_big = '%s',
		      												   url_thumb = '%s',
		      												    cardID = %d		
		      												ON DUPLICATE KEY UPDATE		      											
		      												    url_big = '%s',
			      											   url_thumb = '%s',
			      											  cardID = %d
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

         $this->has_pic = is_file('pics/cards/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE cards SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
     
			// ----------- Пращаме мейл до всички приятели на този потребител и ги уведомяваме за това действие (SAMO ZA USER-i!!!) ---------- //
			
				if($this->user_id > 0)
				{
					if($this->user_id != 1) // За админ не пращаме нищо
					{

						$linkToAutor = '<a href="http://GoZbiTe.Com/разгледай-потребител-'.$this->user_id.','.str_replace(" ","_",get_card_user_name_BY_userID($this->user_id)).'_картички_с_месо_вегетариански_салати_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.get_card_user_name_BY_userID($this->user_id).'</a>';
						$linkToCard = '<a href="http://GoZbiTe.Com/разгледай-картичка-'.$this->id.','.str_replace(" ","_",$this->title).'_картички_с_месо_вегетариански_салати_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.$this->title.'</a>';
												
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
								
								
								$bodyForFriends = "Здравейте ".$FriendName.",<br /><br />Вашият приятел ".$linkToAutor." в кулинарния портал GoZbiTe.Com току-що публикува нова готварска картичка - ".$linkToCard."<br /><br />";
						        $bodyForFriends = eregi_replace("[\]",'',$bodyForFriends);
													
					            $mail->Subject    = "Vash priqtel dobavi recepta v GoZbiTe.Com";
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

      /*== UPDATE card ==*/
      function update($upPicCard) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class card: In update card_ID is not set";
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
			
			
			$body = "<br /><br />Приета е заявка за редактиране на картичка/покана със следните данни:<br /><br />";
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
			$mail->Subject    = "Redaktirane na Karti4ka v GoZbiTe.Com";
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

						$linkToAutor  = '<a href="http://GoZbiTe.Com/разгледай-потребител-'.$this->user_id.','.str_replace(" ","_",get_card_user_name_BY_userID($this->user_id)).'_картички_с_месо_вегетариански_салати_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.get_card_user_name_BY_userID($this->user_id).'</a>';
						$linkToCard = '<a href="http://GoZbiTe.Com/разгледай-картичка-'.$this->id.','.str_replace(" ","_",$this->title).'_картички_с_месо_вегетариански_салати_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.$this->title.'</a>';
												
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
								
								
								$bodyForFriends = "Здравейте ".$FriendName.",<br /><br />Вашият приятел ".$linkToAutor." в кулинарния портал GoZbiTe.Com току-що редактива своята готварска картичка - ".$linkToCard."<br /><br />";
						        $bodyForFriends = eregi_replace("[\]",'',$bodyForFriends);
													
					            $mail->Subject    = "Vash priqtel dobavi recepta v GoZbiTe.Com";
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
		
				
         $sql = sprintf("UPDATE cards SET title = '%s',
                                   			 firm_id = %d,
                                   			  user_id = %d,
                                   			   has_pic = %d,
                                   				 info = '%s',
                                   			      active = '1',
                                                   updated_by = %d,
                                   				    updated_on = NOW()
                                   					 WHERE id = %d", 
         											 $this->title,
                                   					$this->firm_id,
                                              	   $this->user_id,
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

        
              // Set Type Details
         if(is_array($this->card_category) && (count($this->card_category) > 0)) {
         	
         		$sql="DELETE FROM cards_category_list WHERE card_id='".$this->id."'";
				$this->conn->setsql($sql);
			 	$this->conn->updateDB();
			 	
         	for ($n=0;$n<count($this->card_category);$n++)
	 		 {    
		 		$sql="INSERT INTO cards_category_list SET category_id='". $this->card_category[$n]."' , card_id='".$this->id."'";
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

         
       
         
         
         
         if(is_array($upPicCard) && (count($upPicCard) > 0)) {
            $files = array();
            foreach ($upPicCard as $k => $l) {
               foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // Pics Manipulation and Upload
            
             // iztriva faila ot servera predvaritelno,predi da go zapi6e nov
              /* 	 
               	  $offPcs = glob('pics/cards/'.$this->id."_*");
         

		         if(count($offPcs) > 0) {
		            foreach($offPcs as $val) {
		               if(strlen($val) > 0) {
		                  if(!@@unlink($val)) {
		                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class card: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
		                     return false;
		                  }
		                  
		                    $sql=sprintf("DELETE FROM card_pics WHERE cardID = %d", $this->id);
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
               	
               	  $imgBig = imageCardExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('pics/cards/');

                  if ($upPic->processed) {
                  	
                  	 $imgThumb = imageCardExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('pics/cards/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class card: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class card: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO card_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  cardID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  cardID = %d
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

      
      
      /*== DELETE card PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class card: In deletePic card_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class card: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('pics/cards/'.$picFile))
               if(!@unlink('pics/cards/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class card: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM card_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('pics/cards/'.$thumbnail)) if(!@unlink('pics/cards/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class card: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('pics/cards/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE cards SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    
      
      
      /*== DELETE card ==*/
      function deleteCard() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class card: In deleteOffr card_ID is not set";
            return false;
         }

        

         $offPcs = glob('pics/cards/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class card: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
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
			
			
			$body = "<br /><br />Приета е заявка за изтриване на картичка/покана със следните данни:<br /><br />";
	        $body .= "<br />ID: ".$this->id;
			$body .= "<br />Наименование: ".$resultCardToDelete['title'];
			$body .= "<br />userID: ".$resultCardToDelete['user_id'];
            $body .= "<br />firmID: ".$resultCardToDelete['firm_id'];
            $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Iztrivane na Karti4ka v GoZbiTe.Com";
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
      
				
			

         $sql = sprintf("DELETE FROM cards WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
            
         
         
      	$sql=sprintf("DELETE FROM card_pics WHERE cardID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
		
		// --------------Iztrivame i kategoriite na ofertata --------------
		$sql = sprintf("DELETE FROM  cards_category_list WHERE card_id = %d", $this->id);
     	$this->conn->setsql($sql);
     	$this->conn->updateDB();
     	if($this->conn->error) {
        	for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
           	$this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
        	}
        	return false;
     	}
     	
     	
     	
     	
     	// --------------Iztrivame i ot LOG tablicata --------------
		$sql = sprintf("DELETE FROM log_card WHERE card_id = %d", $this->id);
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

		

   } //Class card
?>
