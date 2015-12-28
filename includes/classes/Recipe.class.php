<?php
   require_once("includes/classes/Upload.class.php");
   class Recipe {
      var $conn;
      var $id;
      var $recipe_category;
      var $recipe_category_name;
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
      var $recipeRow;
      var $userID;
      var $tags;
      var $recipe_kuhni;
      var $youtube_video;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Recipe($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //recipe

    
      
      function load() 
      {
         if(isset($this->whereclause) or isset($this->orderClause) or isset($this->limitClause)) 
         {
         	
		  		 $sql=sprintf("SELECT r.id as 'recipeID',
									   r.title as 'title',
										r.info as 'info',
										 r.firm_id as 'firm_id',
										  r.user_id as 'user_id',
										   r.is_VIP as 'is_VIP',
										    r.is_Promo as 'is_Promo',
										     r.is_Silver as 'is_Silver',
										      r.is_Gold as 'is_Gold',
										       r.is_Featured as 'is_Featured',
										        r.is_Featured_from as 'is_Featured_from',
										         r.is_Featured_end as 'is_Featured_end',
										          r.is_Featured_code as 'is_Featured_code',
										           r.rating as 'rating',
										            r.times_rated as 'times_rated',
										             r.has_pic as 'has_pic',
										              r.has_video as 'has_video',
										               r.youtube_video as 'youtube_video',
										                r.registered_on as 'registered_on',
										                 r.updated_by as 'updated_by',
									    		          r.updated_on as 'updated_on',
									    		           r.activated_deactivated_by as 'activated_deactivated_by',
									    		            r.from_vkusnotiiki_net  as 'from_vkusnotiiki_net ',
									    		             r.active as 'active'
											  		          FROM recipes r
												               WHERE 1=1 AND from_vkusnotiiki_net <> 1
												                %s  %s  %s ", $this->whereClause, $this->orderClause, $this->limitClause);

		           	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	
            $this->conn->setsql($sql);
            $this->conn->getTableRows();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->recipeRow = $this->conn->result;
			$this->recipeRowsCount = $this->conn->numberrows;
            
            
            if($this->recipeRowsCount > 0)
            { 
		        // Get Type Categories
				for($k = 0; $k < $this->recipeRowsCount; $k++)
				{
				            
		            
			      
				//------------- Categories ----------------------------------------------------
																		
					$sql="SELECT rc.id as 'recipe_category_id', rc.name as 'recipe_category_name' FROM recipes r, recipe_category rc, recipes_category_list rcl WHERE rcl.recipe_id = r.id AND rcl.category_id = rc.id AND r.id = '".$this->recipeRow[$k]['recipeID']."' ";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->recipeRow[$k]['numCats'] = $this->conn->numberrows;
					$resultRecipesCat[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->recipeRow[$k]['numCats']; $i++) {
						$this->recipeRow[$k]['Cats'][$i] = $resultRecipesCat[$k][$i];					
					}
	         		     
				
					
						
				//------------- FIRM AND HOTELS ----------------------------------------------------
			
					if($this->recipeRow[$k]['firm_id'] > 0)
					{
						$sql="SELECT  f.name as 'firm', f.email as 'email', f.phone as 'phone', fc.id as 'firm_cat_id', fc.name as 'firm_cat_name', f.location_id as 'location_id', f.cnt_recipe as 'cnt_recipe' FROM recipes r, firms f, firms_category_list fcl, firm_category fc  WHERE f.id = r.firm_id AND fcl.firm_id = f.id AND fc.id = fcl.category_id AND f.id = '".$this->recipeRow[$k]['firm_id']."' ";
						$this->conn->setsql($sql);
						$this->conn->getTableRow();
						$this->recipeRow[$k]['Firm'] = $this->conn->result;
						
					}
					
					if($this->recipeRow[$k]['user_id'] > 0)
					{						
						$sql="SELECT userID as 'userID', CONCAT(first_name, ' ', last_name) as 'user', email as 'email', location_id as 'location_id', cnt_recipe as 'cnt_recipe' FROM users WHERE userID = '".$this->recipeRow[$k]['user_id']."' ";
						$this->conn->setsql($sql);
						$this->conn->getTableRow();
						$this->recipeRow[$k]['User'] = $this->conn->result;
						
					}
					
					
				// =================================================================================
	
	
	
				
				
				
				// =========================== Products ======================================	

					$sql="SELECT rp.id as 'recipe_product_id', rp.product as 'recipe_product_name' FROM recipes r, recipes_products rp WHERE rp.recipe_id= r.id AND r.id = '".$this->recipeRow[$k]['recipeID']."' ORDER BY rp.id ";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->recipeRow[$k]['numProducts'] = $this->conn->numberrows;
					$resultRecipesSimptoms[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->recipeRow[$k]['numProducts']; $i++) {
						$this->recipeRow[$k]['Products'][$i] = $resultRecipesSimptoms[$k][$i];					
					}
					
				
		            
		                      
	            // ============================= PICTURES =========================================
				           
					$sql="SELECT * FROM recipe_pics WHERE recipeID='".$this->recipeRow[$k]['recipeID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->recipeRow[$k]['numPics']  	= $this->conn->numberrows;
					$resultRecipesPics[$k] 			= $this->conn->result;	
					
					for($i = 0; $i < $this->recipeRow[$k]['numPics']; $i++) {
						$this->recipeRow[$k]['resultPics']['url_big'][$i] 	= $resultRecipesPics[$k][$i]["url_big"];
						$this->recipeRow[$k]['resultPics']['url_thumb'][$i] 	= $resultRecipesPics[$k][$i]["url_thumb"];
					}
			
					
	
				// =============================== Cnt ========================================	
		
		
					$sql="SELECT recipe_id, SUM(cnt) as 'cnt' FROM log_recipe WHERE recipe_id='".$this->recipeRow[$k]['recipeID']."' GROUP BY recipe_id LIMIT 1";
					$this->conn->setsql($sql);
					$this->conn->getTableRow();
					$this->recipeRow[$k]['cnt'] 	= $this->conn->result['cnt'];					
					
				// =============================== COMMENTS ========================================	
				
					
					$sql="SELECT commentID, sender_name , sender_email , autor_type, autor, comment_body , parentID , created_on  FROM recipe_comment WHERE recipeID='".$this->recipeRow[$k]['recipeID']."' ORDER BY created_on DESC";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->recipeRow[$k]['numComments'] 	= $this->conn->numberrows;
					$resultRecipesComment[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->recipeRow[$k]['numComments']; $i++) {
						$this->recipeRow[$k]['Comments'][$i] = $resultRecipesComment[$k][$i];					
					}
					
					
					
					
					//--------------------------- Национална Кухня ------------------------------------------
	
						$sql="SELECT kl.recipe_id as 'recipe_id', k.name as 'kuhnq', kl.kuhnq_id as 'kuhnq_id'  FROM recipes r, kuhni k, kuhni_list kl WHERE kl.recipe_id = r.id AND kl.kuhnq_id = k.id  AND r.id = '".$this->recipeRow[$k]['recipeID']."'";
						$this->conn->setsql($sql);
						$this->conn->getTableRow();
						$this->recipeRow[$k]['numKuhnq'] = $this->conn->numberrows;
						$this->recipeRow[$k]['Kuhnq']	 = $this->conn->result;								
					
					// =================================================================================
	
	
	
					
					//--------------------------- TAGS ------------------------------------------
		
					$sql="SELECT * FROM recipe_tags WHERE recipeID='".$this->recipeRow[$k]['recipeID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$postTagsCount 		= $this->conn->numberrows;
					$resultRecipesTags[$k]= $this->conn->result;	
						
					if($postTagsCount > 0) {
						$this->recipeRow[$k]['Tags'] = explode(',',$resultRecipesTags[$k][$i]['tags']);					
					}
					$this->recipeRow[$k]['numTags'] = count($this->recipeRow[$k]['Tags']);
					
					
					
					
					
				}   
	              
	              
	            foreach($this->recipeRow as $recipeRow)
	            {
	            	
	            	if((($_SESSION['user_type'] == 'firm' && $_SESSION['userID'] == $recipeRow['firm_id']) OR ($_SESSION['user_type'] == 'user' && $_SESSION['userID'] == $recipeRow['user_id'])) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)
	            	{
	            		$finalResults[$recipeRow['recipeID']] = $recipeRow; //  Vzemame samo aktivnite recepti, no za avtorite i admina davame vsi4ki
	            	}
	            	elseif($recipeRow['active'] == 1) 
	            	{
	            		$finalResults[$recipeRow['recipeID']] = $recipeRow;
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

      
      
      /*== CREATE recipe ==*/
      function create($upPicRecipe) 
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
			
			
			$body = "<br /><br />Приета е заявка за публикуване на готварска рецепта със следните данни:<br /><br />";
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
			$mail->Subject    = "Nova Recepta v GoZbiTe.Com";
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
			
		
			                                   	
    	$sql = sprintf("INSERT INTO recipes SET title = '%s',
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
		  			$body .= "<br /><br />Вие току-що публикувахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> нова Готварска Рецепта със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=recipes&recipeID=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да я редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=recipes&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Nova Recepta v GoZbiTe.Com";
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
			
			
			
			
         
         
       // ------------------------------- recipe CATEGORIES -------------------------
         
        if(is_array($this->recipe_category) && (count($this->recipe_category) > 0)) 
        {         	
         		
         	for ($n=0;$n<count($this->recipe_category);$n++)
	 		 {    
		 		$sql="INSERT INTO recipes_category_list SET category_id='". $this->recipe_category[$n]."' , recipe_id='".$this->id."'";
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
         
      // ------------------------------- recipe Kuhni -------------------------
         
        if(is_array($this->recipe_kuhni) && (count($this->recipe_kuhni) > 0)) 
        {         	
         		
         	for ($n=0;$n<count($this->recipe_kuhni);$n++)
	 		 {    
		 		$sql="INSERT INTO kuhni_list SET kuhnq_id = '". $this->recipe_kuhni[$n]."' , recipe_id='".$this->id."'";
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
         
         $sql = sprintf("INSERT INTO recipe_tags SET tags = '%s',
	      											  recipeID = %d
	      											   ON DUPLICATE KEY UPDATE
	      											    tags = '%s',
		      										     recipeID = %d
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
            $sql = sprintf("DELETE FROM recipes_products WHERE recipe_id = %d", $this->id);
            $this->conn->setsql($sql);
         	$this->conn->UpdateDB();
         	
	       for ($n=0; $n < count($this->products); $n++) 
	       {
		       	if(($this->products[$n] != ''))
		       	{
		           $sql = sprintf("INSERT INTO recipes_products SET recipe_id = %d, product = '%s'",$this->id, $this->products[$n]);
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
	
         
          
         // ====================================== USER/FIRM cnt_recipe  ========================================
          
			if($this->firm_id > 0)
	        {	        	
	        	$sql = sprintf("UPDATE firms SET cnt_recipe=cnt_recipe+1 WHERE id = %d ",$this->firm_id);
		        $this->conn->setsql($sql);
		        $this->conn->updateDB();
		        if($this->conn->error) {
		           for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
		              $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
		        	}
	            	return false;
         		}
         		$_SESSION['cnt_recipe']++;
			}  
			elseif($this->user_id > 0)
	        {
	        	$sql = sprintf("UPDATE users SET cnt_recipe=cnt_recipe+1 WHERE userID = %d ",$this->user_id);
		        $this->conn->setsql($sql);
		        $this->conn->updateDB();
		        if($this->conn->error) {
		           for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
		              $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
		        	}
	            	return false;
         		}
         
				$_SESSION['cnt_recipe']++;
			}  
			
         // =====================================================================================================
         
         
			

         if(is_array($upPicRecipe) && (count($upPicRecipe) > 0)) {
            $files = array();
            foreach ($upPicRecipe as $k => $l) {
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
                  $upPic->process('pics/recipes/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('pics/recipes/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class recipe: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class recipe: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO recipe_pics SET url_big = '%s',
		      												   url_thumb = '%s',
		      												    recipeID = %d		
		      												ON DUPLICATE KEY UPDATE		      											
		      												    url_big = '%s',
			      											   url_thumb = '%s',
			      											  recipeID = %d
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

         $this->has_pic = is_file('pics/recipes/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE recipes SET has_pic = %d WHERE id = %d", $this->has_pic, $this->id);
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
     
				if(file_exists("videos/recipes/".$video_name.".flv"))
				{
					@unlink("videos/recipes/".$video_name.".flv");
					@unlink("videos/recipes/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/recipes/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/recipes/".$video_name.".flv";
				$path_to_tmp="videos/recipes/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE recipes SET has_video = 1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   		}		      
	//=============================================================================================================
	
            
			// ----------- Пращаме мейл до всички приятели на този потребител и ги уведомяваме за това действие (SAMO ZA USER-i!!!) ---------- //
			
				if($this->user_id > 0)
				{
					if($this->user_id != 1) // За админ не пращаме нищо
					{

						$linkToAutor = '<a href="http://GoZbiTe.Com/разгледай-потребител-'.$this->user_id.','.str_replace(" ","_",get_recipe_user_name_BY_userID($this->user_id)).'_рецепти_с_месо_вегетариански_салати_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.get_recipe_user_name_BY_userID($this->user_id).'</a>';
						$linkToRecipe = '<a href="http://GoZbiTe.Com/разгледай-рецепта-'.$this->id.','.str_replace(" ","_",$this->title).'_рецепти_с_месо_вегетариански_салати_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.$this->title.'</a>';
												
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
								
								
								$bodyForFriends = "Здравейте ".$FriendName.",<br /><br />Вашият приятел ".$linkToAutor." в кулинарния портал GoZbiTe.Com току-що публикува нова готварска рецепта - ".$linkToRecipe."<br /><br />";
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

      /*== UPDATE recipe ==*/
      function update($upPicRecipe) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class recipe: In update recipe_ID is not set";
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
			
			
			$body = "<br /><br />Приета е заявка за редактиране на готварска рецепта със следните данни:<br /><br />";
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
			$mail->Subject    = "Redaktirane na Recepta v GoZbiTe.Com";
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

						$linkToAutor  = '<a href="http://GoZbiTe.Com/разгледай-потребител-'.$this->user_id.','.str_replace(" ","_",get_recipe_user_name_BY_userID($this->user_id)).'_рецепти_с_месо_вегетариански_салати_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.get_recipe_user_name_BY_userID($this->user_id).'</a>';
						$linkToRecipe = '<a href="http://GoZbiTe.Com/разгледай-рецепта-'.$this->id.','.str_replace(" ","_",$this->title).'_рецепти_с_месо_вегетариански_салати_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.$this->title.'</a>';
												
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
								
								
								$bodyForFriends = "Здравейте ".$FriendName.",<br /><br />Вашият приятел ".$linkToAutor." в кулинарния портал GoZbiTe.Com току-що редактива своята готварска рецепта - ".$linkToRecipe."<br /><br />";
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
		
				
         $sql = sprintf("UPDATE recipes SET title = '%s',
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
		  			$body .= "<br /><br />Вие току-що редактирахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Готварска Рецепта със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=recipes&recipeID=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да я редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=recipes&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Redaktirana Recepta v GoZbiTe.Com";
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
         if(is_array($this->recipe_category) && (count($this->recipe_category) > 0)) {
         	
         		$sql="DELETE FROM recipes_category_list WHERE recipe_id='".$this->id."'";
				$this->conn->setsql($sql);
			 	$this->conn->updateDB();
			 	
         	for ($n=0;$n<count($this->recipe_category);$n++)
	 		 {    
		 		$sql="INSERT INTO recipes_category_list SET category_id='". $this->recipe_category[$n]."' , recipe_id='".$this->id."'";
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

         
         
       // ------------------------------- recipe Kuhni -------------------------
         
        if(is_array($this->recipe_kuhni) && (count($this->recipe_kuhni) > 0)) 
        {         
        
         		$sql="DELETE FROM kuhni_list WHERE recipe_id='".$this->id."'";
				$this->conn->setsql($sql);
			 	$this->conn->updateDB();	
         		
         	for ($n=0;$n<count($this->recipe_kuhni);$n++)
	 		 {    
		 		$sql="INSERT INTO kuhni_list SET kuhnq_id = '". $this->recipe_kuhni[$n]."' , recipe_id='".$this->id."'";
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
         
         $sql = sprintf("DELETE FROM recipe_tags WHERE recipeID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
			         	
         $sql = sprintf("INSERT INTO recipe_tags SET tags = '%s',
	      											  recipeID = %d
	      											   ON DUPLICATE KEY UPDATE
	      											    tags = '%s',
		      										     recipeID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         $this->conn->setsql($sql);
         $this->conn->insertDB();
         
    //***********************************************************************************************
      	
         
         
            	
          if(is_array($this->products) && (count($this->products) > 0)) {
            $sql = sprintf("DELETE FROM recipes_products WHERE recipe_id = %d", $this->id);
            $this->conn->setsql($sql);
         	$this->conn->UpdateDB();
         	
	       for ($n=0; $n < count($this->products); $n++) 
	       {
		       	if(($this->products[$n] != '') && ($this->products[$n] != ''))
		       	{
		           $sql = sprintf("INSERT INTO recipes_products SET recipe_id = %d, product = '%s'",$this->id, $this->products[$n]);
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
	
	
	
		  

         
         
         
         if(is_array($upPicRecipe) && (count($upPicRecipe) > 0)) {
            $files = array();
            foreach ($upPicRecipe as $k => $l) {
               foreach ($l as $i => $v) {
                  if (!array_key_exists($i, $files))
                     $files[$i] = array();
                  $files[$i][$k] = $v;
               }
            }

            // Pics Manipulation and Upload
            
             // iztriva faila ot servera predvaritelno,predi da go zapi6e nov
              /* 	 
               	  $offPcs = glob('pics/recipes/'.$this->id."_*");
         

		         if(count($offPcs) > 0) {
		            foreach($offPcs as $val) {
		               if(strlen($val) > 0) {
		                  if(!@@unlink($val)) {
		                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class recipe: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
		                     return false;
		                  }
		                  
		                    $sql=sprintf("DELETE FROM recipe_pics WHERE recipeID = %d", $this->id);
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
               	
               	  $imgBig = imageRecipeExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('pics/recipes/');

                  if ($upPic->processed) {
                  	
                  	 $imgThumb = imageRecipeExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('pics/recipes/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class recipe: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class recipe: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO recipe_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  recipeID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  recipeID = %d
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
     
				if(file_exists("videos/recipes/".$video_name.".flv"))
				{
					@unlink("videos/recipes/".$video_name.".flv");
					@unlink("videos/recipes/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/recipes/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce) ;				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/recipes/".$video_name.".flv";
				$path_to_tmp="videos/recipes/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE recipes SET has_video=1 WHERE id = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
   	}							
				      
	//=============================================================================================================
		
		
         return true;
      } //End Update

      
      
      /*== DELETE recipe PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class recipe: In deletePic recipe_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class recipe: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('pics/recipes/'.$picFile))
               if(!@unlink('pics/recipes/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class recipe: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM recipe_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('pics/recipes/'.$thumbnail)) if(!@unlink('pics/recipes/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class recipe: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('pics/recipes/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE recipes SET has_pic = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    
      
    /*=============== DELETE recipe VIDEO ====================*/
    
      function deleteVideo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class bolest: In deleteVideo bolest_ID is not set";
            return false;
         }

         $videoFile    	= $this->id.".flv";
         $thumbnail  	= $this->id."_thumb.jpg";

         if(strlen($videoFile) > 0) {
            if(is_file('videos/recipes/'.$videoFile))
               if(!@unlink('videos/recipes/'.$videoFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$videoFile." cannot be deleted!";
                  return false;
               }
          }

         if(strlen($thumbnail) > 0) {
            if(is_file('videos/recipes/'.$thumbnail))
             if(!@unlink('videos/recipes/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('videos/recipes/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE recipes SET has_video = 0 WHERE id = %d",$this->id));
            $this->conn->updateDB();
         }
         
	      
         return true;
      }

   //========================================================== 
     
      
      
          
      /*== DELETE recipe Logo ==*/
      function deleteLogo($picFile) {
             
         if(strlen($picFile) > 0) {
            if(is_file('pics/recipes/'.$picFile))
               if(!@unlink('pics/recipes/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class recipes: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
              }
            
         }

         return true;
      }


      /*== DELETE recipe ==*/
      function deleteRecipe() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class recipe: In deleteOffr recipe_ID is not set";
            return false;
         }

        
         $sql = sprintf("DELETE FROM recipes WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         

         $offPcs = glob('pics/recipes/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class recipe: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         
    // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("videos/recipes/".$video_name.".flv"))
				{
					@unlink("videos/recipes/".$video_name.".flv");
				}
				if(file_exists("videos/recipes/".$video_name."._thumb.jpg"))
				{
					@unlink("videos/recipes/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	
	
				// ====================================== USER/FIRM cnt_recipe  ========================================
         
				$sql="SELECT r.title as 'title', r.firm_id as 'firm_id', r.user_id as 'user_id' FROM recipes r WHERE r.id = '".$this->id."'";
				$this->conn->setsql($sql);
				$this->conn->getTableRow();
				$resultRecipeToDelete=$this->conn->result;
				
	
	        if($resultRecipeToDelete['firm_id'] > 0)
	        {
	        	$sql=sprintf("UPDATE firms SET cnt_recipe=cnt_recipe-1 WHERE id = %d ",$resultRecipeToDelete['firm_id']);
	        	$this->conn->setsql($sql);
				$this->conn->updateDB();		
				$_SESSION['cnt_recipe']--;
			}  
			elseif($resultRecipeToDelete['user_id'] > 0)
	        {
	        	$sql=sprintf("UPDATE users SET cnt_recipe=cnt_recipe-1 WHERE userID = %d ",$resultRecipeToDelete['user_id']);
	        	$this->conn->setsql($sql);
				$this->conn->updateDB();
				$_SESSION['cnt_recipe']--;
			}  
	   
         // =====================================================================================================
         	
			

            
                 
         
         
         $sql = sprintf("DELETE FROM recipes_products WHERE recipe_id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
           
         
 	//**************************************** Изтриваме Kuhni **************************************
         
         $sql = sprintf("DELETE FROM kuhni_list WHERE recipeID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
		    	
     //***********************************************************************************************
      	
         
         
       //**************************************** Изтриваме Таговете **************************************
         
         $sql = sprintf("DELETE FROM recipe_tags WHERE recipeID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
		    	
     //***********************************************************************************************
      	
         
         
         
      	$sql=sprintf("DELETE FROM recipe_pics WHERE recipeID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
		
		// --------------Iztrivame i kategoriite na ofertata --------------
		$sql = sprintf("DELETE FROM  recipes_category_list WHERE recipe_id = %d", $this->id);
     	$this->conn->setsql($sql);
     	$this->conn->updateDB();
     	if($this->conn->error) {
        	for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
           	$this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
        	}
        	return false;
     	}
     	
     	
     	
     	
     	// --------------Iztrivame i ot LOG tablicata --------------
		$sql = sprintf("DELETE FROM log_recipe WHERE recipe_id = %d", $this->id);
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
			
			
			$body = "<br /><br />Приета е заявка за изтриване на готварска рецепта със следните данни:<br /><br />";
	        $body .= "<br />ID: ".$this->id;
			$body .= "<br />Наименование: ".$resultRecipeToDelete['title'];
			$body .= "<br />userID: ".$resultRecipeToDelete['user_id'];
            $body .= "<br />firmID: ".$resultRecipeToDelete['firm_id'];
            $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Iztrivane na Recepta v GoZbiTe.Com";
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

		

   } //Class recipe
?>
