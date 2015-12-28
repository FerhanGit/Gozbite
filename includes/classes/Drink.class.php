<?php
   require_once("includes/classes/Upload.class.php");
   class Drink {
      var $conn;
      var $id;
      var $drink_category;
      var $drink_category_name;
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
      var $drinkRow;
      var $userID;
      var $tags;
      var $youtube_video;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Drink($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //drink

      
      
      function load() 
      {
         if(isset($this->whereclause) or isset($this->orderClause) or isset($this->limitClause)) 
         {
         
		  		 $sql=sprintf("SELECT d.id as 'drinkID',
									   d.title as 'title',
										d.info as 'info',
										 d.firm_id as 'firm_id',
										  d.user_id as 'user_id',
										   d.is_VIP as 'is_VIP',
										    d.is_Promo as 'is_Promo',
										     d.is_Silver as 'is_Silver',
										      d.is_Gold as 'is_Gold',
										       d.is_Featured as 'is_Featured',
										        d.is_Featured_from as 'is_Featured_from',
										         d.is_Featured_end as 'is_Featured_end',
										          d.is_Featured_code as 'is_Featured_code',
										           d.rating as 'rating',
										            d.times_rated as 'times_rated',
										             d.has_pic as 'has_pic',
										              d.has_video as 'has_video',
										               d.youtube_video as 'youtube_video',
										                d.registered_on as 'registered_on',
										                 d.updated_by as 'updated_by',
									    		          d.updated_on as 'updated_on',
									    		           d.activated_deactivated_by as 'activated_deactivated_by',
									    		            d.active as 'active'
											  		         FROM drinks d
												              WHERE 1=1
												               %s  %s  %s ", $this->whereClause, $this->orderClause, $this->limitClause);

		           	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	
            $this->conn->setsql($sql);
            $this->conn->getTableRows();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->drinkRow = $this->conn->result;
			$this->drinkRowsCount = $this->conn->numberrows;
            
            
            if($this->drinkRowsCount > 0)
            { 
		        // Get Type Categories
				for($k = 0; $k < $this->drinkRowsCount; $k++)
				{
				            
		            
			      
				//------------- Categories ----------------------------------------------------
																		
					$sql="SELECT dc.id as 'drink_category_id', dc.name as 'drink_category_name' FROM drinks d, drink_category dc, drinks_category_list dcl WHERE dcl.drink_id = d.id AND dcl.category_id = dc.id AND d.id = '".$this->drinkRow[$k]['drinkID']."' ";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->drinkRow[$k]['numCats'] = $this->conn->numberrows;
					$resultDrinksCat[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->drinkRow[$k]['numCats']; $i++) {
						$this->drinkRow[$k]['Cats'][$i] = $resultDrinksCat[$k][$i];					
					}
	         		     
				
				
				//------------- FIRM AND HOTELS ----------------------------------------------------
			
					if($this->drinkRow[$k]['firm_id'] > 0)
					{
						$sql="SELECT  f.name as 'firm', f.email as 'email', f.phone as 'phone', fc.id as 'firm_cat_id', fc.name as 'firm_cat_name', f.location_id as 'location_id', f.cnt_drink as 'cnt_drink' FROM drinks d, firms f, firms_category_list fcl, firm_category fc  WHERE f.id = d.firm_id AND fcl.firm_id = f.id AND fc.id = fcl.category_id AND f.id = '".$this->drinkRow[$k]['firm_id']."' ";
						$this->conn->setsql($sql);
						$this->conn->getTableRow();
						$this->drinkRow[$k]['Firm'] = $this->conn->result;
						
					}
					
					if($this->drinkRow[$k]['user_id'] > 0)
					{						
						$sql="SELECT userID as 'userID', CONCAT(first_name, ' ', last_name) as 'user', email as 'email', location_id as 'location_id', cnt_drink as 'cnt_drink' FROM users WHERE userID = '".$this->drinkRow[$k]['user_id']."' ";
						$this->conn->setsql($sql);
						$this->conn->getTableRow();
						$this->drinkRow[$k]['User'] = $this->conn->result;
						
					}
					
					
				// =================================================================================
	
	
	
	
				// =========================== Products ======================================	

					$sql="SELECT dp.id as 'drink_product_id', dp.product as 'drink_product_name' FROM drinks d, drinks_products dp WHERE dp.drink_id= d.id AND d.id = '".$this->drinkRow[$k]['drinkID']."'  ORDER BY dp.id ";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->drinkRow[$k]['numProducts'] = $this->conn->numberrows;
					$resultDrinksSimptoms[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->drinkRow[$k]['numProducts']; $i++) {
						$this->drinkRow[$k]['Products'][$i] = $resultDrinksSimptoms[$k][$i];					
					}
					
				
		            
		                      
	            // ============================= PICTURES =========================================
				           
					$sql="SELECT * FROM drink_pics WHERE drinkID='".$this->drinkRow[$k]['drinkID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->drinkRow[$k]['numPics']  	= $this->conn->numberrows;
					$resultDrinksPics[$k] 			= $this->conn->result;	
					
					for($i = 0; $i < $this->drinkRow[$k]['numPics']; $i++) {
						$this->drinkRow[$k]['resultPics']['url_big'][$i] 	= $resultDrinksPics[$k][$i]["url_big"];
						$this->drinkRow[$k]['resultPics']['url_thumb'][$i] 	= $resultDrinksPics[$k][$i]["url_thumb"];
					}
			
					
	
				// =============================== Cnt ========================================	
		
		
					$sql="SELECT drink_id, SUM(cnt) as 'cnt' FROM log_drink WHERE drink_id='".$this->drinkRow[$k]['drinkID']."' GROUP BY drink_id LIMIT 1";
					$this->conn->setsql($sql);
					$this->conn->getTableRow();
					$this->drinkRow[$k]['cnt'] 	= $this->conn->result['cnt'];					
					
				// =============================== COMMENTS ========================================	
				
					
					$sql="SELECT commentID, sender_name , sender_email , autor_type, autor, comment_body , parentID , created_on  FROM drink_comment WHERE drinkID='".$this->drinkRow[$k]['drinkID']."' ORDER BY created_on DESC";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->drinkRow[$k]['numComments'] 	= $this->conn->numberrows;
					$resultDrinksComment[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->drinkRow[$k]['numComments']; $i++) {
						$this->drinkRow[$k]['Comments'][$i] = $resultDrinksComment[$k][$i];					
					}
					
					
					
					//--------------------------- TAGS ------------------------------------------
		
					$sql="SELECT * FROM drink_tags WHERE drinkID='".$this->drinkRow[$k]['drinkID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$postTagsCount 		= $this->conn->numberrows;
					$resultDrinksTags[$k]= $this->conn->result;	
						
					if($postTagsCount > 0) {
						$this->drinkRow[$k]['Tags'] = explode(',',$resultDrinksTags[$k][$i]['tags']);					
					}
					$this->drinkRow[$k]['numTags'] = count($this->drinkRow[$k]['Tags']);
					
					
					
					
					
				}   
	              
				
				
		              
	            foreach($this->drinkRow as $drinkRow)
	            {
	            	if((($_SESSION['user_type'] == 'firm' && $_SESSION['userID'] == $drinkRow['firm_id']) OR ($_SESSION['user_type'] == 'user' && $_SESSION['userID'] == $drinkRow['user_id'])) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)
	            	{
	            		$finalResults[$drinkRow['drinkID']] = $drinkRow; //  Vzemame samo aktivnite napitki, no za avtorite i admina davame vsi4ki
	            	}
	            	elseif($drinkRow['active'] == 1) 
	            	{
	            		$finalResults[$drinkRow['drinkID']] = $drinkRow;
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

      
      
      

      /*== CREATE drink ==*/
      function create($upPicDrink) 
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
			
			
			$body = "<br /><br />Приета е заявка за публикуване на Напитка със следните данни:<br /><br />";
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
			$mail->Subject    = "Nova Napitka v GoZbiTe.Com";
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
			
		
			                                   	
    	$sql = sprintf("INSERT INTO drinks SET title = '%s',
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
		  			$body .= "<br /><br />Вие току-що публикувахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Напитка със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=drinks&drinkD=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да я редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=drinks&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Nova Napitka v GoZbiTe.Com";
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
			
			
			
         
         
         
         
       // ------------------------------- drink CATEGORIES -------------------------
         
        if(is_array($this->drink_category) && (count($this->drink_category) > 0)) 
        {         	
         		
         	for ($n=0;$n<count($this->drink_category);$n++)
	 		 {    
		 		$sql="INSERT INTO drinks_category_list SET category_id='". $this->drink_category[$n]."' , drink_id='".$this->id."'";
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
         
         $sql = sprintf("INSERT INTO drink_tags SET tags = '%s',
	      											  drinkID = %d
	      											   ON DUPLICATE KEY UPDATE
	      											    tags = '%s',
		      										     drinkID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         	$this->conn->setsql($sql);
         	$this->conn->insertDB();
         
         //***********************************************************************************************
         
         
      // Set Price Details
         	
          if(is_array($this->products)) {
            $sql = sprintf("DELETE FROM drinks_products WHERE drink_id = %d", $this->id);
            $this->conn->setsql($sql);
         	$this->conn->UpdateDB();
         	
	       for ($n=0; $n < count($this->products); $n++) 
	       {
		       	if(($this->products[$n] != ''))
		       	{
		           $sql = sprintf("INSERT INTO drinks_products SET drink_id = %d, product = '%s'",$this->id, $this->products[$n]);
		           $this->conn->setsql($sql); 
		           $this->conn->insertDB();
		       	}
	       }
         	
            if($this->conn->error) {
               for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
                  $this->Error["SQL ERROR ClssOffrUpdt-".$key] = $this->conn->error[$key];
               }
               return false;
            }
         }
	
         
         
         // ====================================== USER/FIRM cnt_drink  ========================================
         
			if($this->firm_id > 0)
	        {	        	
	        	$sql = sprintf("UPDATE firms SET cnt_drink=cnt_drink+1 WHERE id = %d ",$this->firm_id);
		        $this->conn->setsql($sql);
		        $this->conn->updateDB();
		        if($this->conn->error) {
		           for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
		              $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
		        	}
	            	return false;
         		}
         		$_SESSION['cnt_drink']++;
			}  
			elseif($this->user_id > 0)
	        {
	        	$sql = sprintf("UPDATE users SET cnt_drink=cnt_drink+1 WHERE userID = %d ",$this->user_id);
		        $this->conn->setsql($sql);
		        $this->conn->updateDB();
		        if($this->conn->error) {
		           for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
		              $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
		        	}
	            	return false;
         		}
         
				$_SESSION['cnt_drink']++;
			}  
			
         // =====================================================================================================
         

         if(is_array($upPicDrink) && (count($upPicDrink) > 0)) {
            $files = array();
            foreach ($upPicDrink as $k => $l) {
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
                  $upPic->process('pics/drinks/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('pics/drinks/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class drink: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class drink: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO drink_pics SET url_big = '%s',
		      												   url_thumb = '%s',
		      												    drinkID = %d		
		      												ON DUPLICATE KEY UPDATE		      											
		      												    url_big = '%s',
			      											   url_thumb = '%s',
			      											  drinkID = %d
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

         $this->has_pic = is_file('pics/drinks/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE drinks SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
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
     
				if(file_exists("videos/drinks/".$video_name.".flv"))
				{
					@unlink("videos/drinks/".$video_name.".flv");
					@unlink("videos/drinks/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/drinks/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/drinks/".$video_name.".flv";
				$path_to_tmp="videos/drinks/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE drinks SET has_video = 1 WHERE id = %d ", $this->id);
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
						$linkToRecipe = '<a href="http://GoZbiTe.Com/разгледай-напитка-'.$this->id.','.str_replace(" ","_",$this->title).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.$this->title.'</a>';
												
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
								
								
								$bodyForFriends = "Здравейте ".$FriendName.",<br /><br />Вашият приятел ".$linkToAutor." в кулинарния портал GoZbiTe.Com току-що публикува рецепта за напитка - ".$linkToRecipe."<br /><br />";
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

      /*== UPDATE drink ==*/
      function update($upPicDrink) 
      {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class drink: In update drink_ID is not set";
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
			
			
			$body = "<br /><br />Приета е заявка за редактиране на Напитка със следните данни:<br /><br />";
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
			$mail->Subject    = "Redaktirane na Napitka v GoZbiTe.Com";
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
						$linkToRecipe = '<a href="http://GoZbiTe.Com/разгледай-напитка-'.$this->id.','.str_replace(" ","_",$this->title).'_екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.$this->title.'</a>';
												
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
								
								
								$bodyForFriends = "Здравейте ".$FriendName.",<br /><br />Вашият приятел ".$linkToAutor." в кулинарния портал GoZbiTe.Com току-що редактира своята рецепта за напитка - ".$linkToRecipe."<br /><br />";
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
		
				
         $sql = sprintf("UPDATE drinks SET title = '%s',
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
		  			$body .= "<br /><br />Вие току-що редактирахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Напитка със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=drinks&drinkD=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да я редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=drinks&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Redaktirana Napitka v GoZbiTe.Com";
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
			
			
			
         
         
         
         
         
         
         
              // Set Type Details
         if(is_array($this->drink_category) && (count($this->drink_category) > 0)) {
         	
         		$sql="DELETE FROM drinks_category_list WHERE drink_id='".$this->id."'";
				$this->conn->setsql($sql);
			 	$this->conn->updateDB();
			 	
         	for ($n=0;$n<count($this->drink_category);$n++)
	 		 {    
		 		$sql="INSERT INTO drinks_category_list SET category_id='". $this->drink_category[$n]."' , drink_id='".$this->id."'";
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

         
         
              
 	//**************************************** Качваме Таговете **************************************
         
         $sql = sprintf("DELETE FROM drink_tags WHERE drinkID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
			         	
         $sql = sprintf("INSERT INTO drink_tags SET tags = '%s',
	      											  drinkID = %d
	      											   ON DUPLICATE KEY UPDATE
	      											    tags = '%s',
		      										     drinkID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         $this->conn->setsql($sql);
         $this->conn->insertDB();
         
    //***********************************************************************************************
      	
         
         
            	
          if(is_array($this->products) && (count($this->products) > 0)) {
            $sql = sprintf("DELETE FROM drinks_products WHERE drink_id = %d", $this->id);
            $this->conn->setsql($sql);
         	$this->conn->UpdateDB();
         	
	       for ($n=0; $n < count($this->products); $n++) 
	       {
		       	if(($this->products[$n] != '') && ($this->products[$n] != ''))
		       	{
		           $sql = sprintf("INSERT INTO drinks_products SET drink_id = %d, product = '%s'",$this->id, $this->products[$n]);
		           $this->conn->setsql($sql); 
		           $this->conn->insertDB();
		       	}
	       }
         	
            if($this->conn->error) {
               for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
                  $this->Error["SQL ERROR ClssOffrUpdt-".$key] = $this->conn->error[$key];
               }
               return false;
            }
         }
	
	
	
		  

         
         
         
         if(is_array($upPicDrink) && (count($upPicDrink) > 0)) {
            $files = array();
            foreach ($upPicDrink as $k => $l) {
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
               	
               	  $imgBig = imageDrinkExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('pics/drinks/');

                  if ($upPic->processed) {
                  	
                  	 $imgThumb = imageDrinkExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('pics/drinks/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class drink: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class drink: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO drink_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  drinkID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  drinkID = %d
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
     
				if(file_exists("videos/drinks/".$video_name.".flv"))
				{
					@unlink("videos/drinks/".$video_name.".flv");
					@unlink("videos/drinks/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/drinks/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce) ;				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/drinks/".$video_name.".flv";
				$path_to_tmp="videos/drinks/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE drinks SET has_video=1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
   	}							
				      
	//=============================================================================================================
		
		
         return true;
      } //End Update

      
      
      /*== DELETE drink PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class drink: In deletePic drink_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class drink: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('pics/drinks/'.$picFile))
               if(!@unlink('pics/drinks/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class drink: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM drink_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('pics/drinks/'.$thumbnail)) if(!@unlink('pics/drinks/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class drink: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('pics/drinks/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE drinks SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    
      
    /*=============== DELETE drink VIDEO ====================*/
    
      function deleteVideo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class drink: In deleteVideo drink_ID is not set";
            return false;
         }

         $videoFile    	= $this->id.".flv";
         $thumbnail  	= $this->id."_thumb.jpg";

         if(strlen($videoFile) > 0) {
            if(is_file('videos/drinks/'.$videoFile))
               if(!@unlink('videos/drinks/'.$videoFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class drink: In deleteVideo -> The file ".$videoFile." cannot be deleted!";
                  return false;
               }
          }

         if(strlen($thumbnail) > 0) {
            if(is_file('videos/drinks/'.$thumbnail))
             if(!@unlink('videos/drinks/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class drink: In deleteVideo -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('videos/drinks/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE drinks SET has_video = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	      
         return true;
      }

   //========================================================== 
     
      
      
          
      /*== DELETE drink Logo ==*/
      function deleteLogo($picFile) {
             
         if(strlen($picFile) > 0) {
            if(is_file('pics/drinks/'.$picFile))
               if(!@unlink('pics/drinks/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class drinks: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
              }
            
         }

         return true;
      }


      /*== DELETE drink ==*/
      function deleteDrink() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class drink: In deleteOffr drink_ID is not set";
            return false;
         }

        

         $offPcs = glob('pics/drinks/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class drink: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         
    // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("videos/drinks/".$video_name.".flv"))
				{
					@unlink("videos/drinks/".$video_name.".flv");
				}
				if(file_exists("videos/drinks/".$video_name."._thumb.jpg"))
				{
					@unlink("videos/drinks/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	
	
			// ====================================== USER/FIRM cnt_drink  ========================================
         
				$sql="SELECT d.title as 'title', d.firm_id as 'firm_id', d.user_id as 'user_id' FROM drinks d WHERE d.id = '".$this->id."'";
				$this->conn->setsql($sql);
				$this->conn->getTableRow();
				$resultDrinkToDelete=$this->conn->result;
				
	
	        if($resultDrinkToDelete['firm_id'] > 0)
	        {
	        	$sql=sprintf("UPDATE firms SET cnt_drink=cnt_drink-1 WHERE id = %d ",$resultDrinkToDelete['firm_id']);
	        	$this->conn->setsql($sql);
				$this->conn->updateDB();		
				$_SESSION['cnt_drink']--;
			}  
			elseif($resultDrinkToDelete['user_id'] > 0)
	        {
	        	$sql=sprintf("UPDATE users SET cnt_drink=cnt_drink-1 WHERE userID = %d ",$resultDrinkToDelete['user_id']);
	        	$this->conn->setsql($sql);
				$this->conn->updateDB();
				$_SESSION['cnt_drink']--;
			}  
	   
         // =====================================================================================================
        
			

         $sql = sprintf("DELETE FROM drinks WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
            
                 
         
         
         $sql = sprintf("DELETE FROM drinks_products WHERE drink_id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
           
         
 	//**************************************** Изтриваме Таговете **************************************
         
         $sql = sprintf("DELETE FROM drink_tags WHERE drinkID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
		    	
     //***********************************************************************************************
      	
         
         
         
      	$sql=sprintf("DELETE FROM drink_pics WHERE drinkID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
		
		// --------------Iztrivame i kategoriite na ofertata --------------
		$sql = sprintf("DELETE FROM  drinks_category_list WHERE drink_id = %d", $this->id);
     	$this->conn->setsql($sql);
     	$this->conn->updateDB();
     	if($this->conn->error) {
        	for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
           	$this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
        	}
        	return false;
     	}
     	
     	
     	
     	
     	// --------------Iztrivame i ot LOG tablicata --------------
		$sql = sprintf("DELETE FROM  log_drink WHERE drink_id = %d", $this->id);
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
			
			
			$body = "<br /><br />Приета е заявка за изтриване на Напитка със следните данни:<br /><br />";
	        $body .= "<br />ID: ".$this->id;
			$body .= "<br />Наименование: ".$resultDrinkToDelete['title'];
			$body .= "<br />userID: ".$resultDrinkToDelete['user_id'];
            $body .= "<br />firmID: ".$resultDrinkToDelete['firm_id'];
            $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Iztrivane na Napitka v GoZbiTe.Com";
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

		

   } //Class drink
?>
