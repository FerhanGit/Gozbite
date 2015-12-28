<?php
   require_once("includes/classes/Upload.class.php");
   class Bolest {
      var $conn;
      var $id;
      var $bolest_category;      
      var $bolest_category_name;
      var $name;
      var $autor;
      var $autor_type;
      var $discovered_on;
      var $bolest_simptom;      
      var $bolest_simptom_name;
      var $location;
      var $location_id;
      var $related_bolest;
      var $updated_on;      
      var $registered_on;   
      var $description;
      var $has_pic;
      var $bolestRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Bolest($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //bolest

      
         function load() 
         {
         	if(isset($this->whereclause) or isset($this->orderClause) or isset($this->limitClause)) 
         	{
         
		  
		  		 $sql=sprintf("SELECT b.bolestID as 'bolestID',
							   b.title as 'title',
								b.body as 'body',
								 b.autor as 'autor',
								  b.autor_type as 'autor_type',
								   b.source as 'source',
								    b.rating as 'rating',
								     b.times_rated as 'times_rated',
								      b.has_pic as 'has_pic',
								       b.has_video as 'has_video',
								        b.youtube_video as 'youtube_video',
								         b.discovered_on as 'discovered_on',
								          b.date as 'date',
							    		   b.active as 'active'
									  		FROM bolesti b
										     WHERE b.active = '1'
										     %s  %s  %s ", $this->whereClause, $this->orderClause, $this->limitClause);

		         
            $this->conn->setsql($sql);
            $this->conn->getTableRows();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->bolestRow = $this->conn->result;
			$this->bolestRowsCount = $this->conn->numberrows;
            
            
            if($this->bolestRowsCount > 0)
            { 
		        // Get Type Categories
				for($k = 0; $k < $this->bolestRowsCount; $k++)
				{
				            
		            
			      
				//------------- Categories ----------------------------------------------------
																		
					$sql="SELECT bc.id as 'bolest_category_id', bc.name as 'bolest_category_name' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND b.bolestID = '".$this->bolestRow[$k]['bolestID']."' ";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->bolestRow[$k]['numCats'] = $this->conn->numberrows;
					$resultBolestiCat[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->bolestRow[$k]['numCats']; $i++) {
						$this->bolestRow[$k]['Cats'][$i] = $resultBolestiCat[$k][$i];					
					}
	         		     
				
				
				// =========================== SIMPTOMS ======================================	

					$sql="SELECT bs.id as 'bolest_simptom_id', bs.name as 'bolest_simptom_name' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND b.bolestID = '".$this->bolestRow[$k]['bolestID']."' ";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->bolestRow[$k]['numSimptoms'] = $this->conn->numberrows;
					$resultBolestiSimptoms[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->bolestRow[$k]['numSimptoms']; $i++) {
						$this->bolestRow[$k]['Simptoms'][$i] = $resultBolestiSimptoms[$k][$i];					
					}
					
				
		            
		                      
	            // ============================= PICTURES =========================================
				           
					$sql="SELECT * FROM bolesti_pics WHERE bolestID='".$this->bolestRow[$k]['bolestID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->bolestRow[$k]['numPics']  	= $this->conn->numberrows;
					$resultBolestiPics[$k] 			= $this->conn->result;	
					
					for($i = 0; $i < $this->bolestRow[$k]['numPics']; $i++) {
						$this->bolestRow[$k]['resultPics']['url_big'][$i] 	= $resultBolestiPics[$k][$i]["url_big"];
						$this->bolestRow[$k]['resultPics']['url_thumb'][$i] 	= $resultBolestiPics[$k][$i]["url_thumb"];
					}
			
					
	
				// =============================== Cnt ========================================	
		
		
					$sql="SELECT bolest_id, SUM(cnt) as 'cnt' FROM log_bolest WHERE bolest_id='".$this->bolestRow[$k]['bolestID']."' GROUP BY bolest_id LIMIT 1";
					$this->conn->setsql($sql);
					$this->conn->getTableRow();
					$this->bolestRow[$k]['cnt'] 	= $this->conn->result['cnt'];					
					
				// =============================== COMMENTS ========================================	
				
					
					$sql="SELECT commentID, sender_name , sender_email , autor_type, autor, comment_body , parentID , created_on  FROM bolest_comment WHERE bolestID='".$this->bolestRow[$k]['bolestID']."' ORDER BY created_on DESC";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->bolestRow[$k]['numComments'] 	= $this->conn->numberrows;
					$resultBolestiComment[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->bolestRow[$k]['numComments']; $i++) {
						$this->bolestRow[$k]['Comments'][$i] = $resultBolestiComment[$k][$i];					
					}
					
					
					
					//--------------------------- TAGS ------------------------------------------
		
					$sql="SELECT * FROM bolest_tags WHERE bolestID='".$this->bolestRow[$k]['bolestID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$postTagsCount 		= $this->conn->numberrows;
					$resultBolestiTags[$k]= $this->conn->result;	
						
					if($postTagsCount > 0) {
						$this->bolestRow[$k]['Tags'] = explode(',',$resultBolestiTags[$k][$i]['tags']);					
					}
					$this->bolestRow[$k]['numTags'] = count($this->bolestRow[$k]['Tags']);
					
					
					
					
					
				}   
	              
	                  
	            foreach($this->bolestRow as $bolestRow)
	            {
	            	$finalResults[$bolestRow['bolestID']] = $bolestRow;
	            }
           
            	return $finalResults;
            }
            
            return false;
         } else {
            $this->Error["Application Error ClssOffrPrprLdQry-Invalid Argument"] = "Class post: In prepareLoadQuery post_ID is not present";
            return false;
         }
      }//prepareLoadQuery


      /*== CREATE bolest ==*/
      function create($upPicbolest) 
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
			
			
			$body = "<br /><br />Приета е заявка за регистрация на Болест със следните данни: gozbite.com<br /><br />";
	        $body .= "<br />Наименование: ".$this->title;
			$body .= "<br />Източник на статията: ".$this->source;
			$body .= "<br />Автор: ".$this->autor;
			$body .= "<br />Открита през: ".$this->discovered_on;
			$body .= "<br />Със снимка: ".$this->has_pic;
			$body .= "<br />Описание: ".$this->body;
			$body .= "<br />Категории : ".print_r($this->bolest_category, 1);
			$body .= "<br />Симптоми : ".print_r($this->bolest_simptom, 1);
			$body .= "<br />userID: ".$_SESSION['userID'];
            $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Нова Болест в gozbite.com";
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
      			 					               
		$this->body = removeBadTags($this->body);		// Remove Bad tags from text

			
    	$sql = sprintf("INSERT INTO bolesti SET title='%s',
                                             body='%s',
                                             has_pic='%d',
                                             source='%s',
                                             youtube_video='%s',
                                             autor_type='%s',
                                             autor='%d',
                                             discovered_on='%s',
                                             active = '1',
                                             date=NOW()
                                          
                                          ON DUPLICATE KEY UPDATE
                                           
                                            title='%s',
                                             body='%s',
                                             has_pic='%d',
                                             source='%s',
                                             youtube_video='%s',
                                             autor_type='%s',
                                             autor='%d',
                                             discovered_on='%s',
                                             active = '1',
                                             date=NOW()
                                             ",$this->title,
    										 $this->body,
								             $this->has_pic,
								             $this->source,
								             $this->youtube_video,
								             $this->autor_type,
								             $this->autor,
								             $this->discovered_on,
								             $this->title,
    										 $this->body,
								             $this->has_pic,
								             $this->source,
								             $this->youtube_video,
								             $this->autor_type,
								             $this->autor,
								             $this->discovered_on);
		
                 
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
					
					$body  = "<a href='http://gozbite.com/вход,вход_в_системата_на_кулинарния_портал_oHBoli_Bg.html'><img style='border: 0px;' src='http://gozbite.com/images/logce.png'></a><br /><br />";			  	
		  			$body .= "Здравейте, ".(($_SESSION['user_type']=='user')?get_user_nameByUserID($_SESSION['userID']):get_firm_nameByFirmID($_SESSION['userID']))."<br /><br />";			  	
		  			$body .= "<br /><br />Вие току-що публикувахте в кулинарния портал <a href='http://gozbite.com'>gozbite.com</a> ново Заболяване със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=bolesti&bolestID=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да го редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=bolesti&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на gozbite.com Ви желае крепко здраве и дълъг живот!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Novo Zabolqvane v gozbite.com";
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
			
			
			
			
			
			
			
     // ------------------------------- BOLESTI CATEGORIES -------------------------
         
        if(is_array($this->bolest_category) && (count($this->bolest_category) > 0)) {
         	
         		
         	for ($n=0;$n<count($this->bolest_category);$n++)
	 		 {    
		 		$sql="INSERT INTO bolesti_category_list SET category_id='". $this->bolest_category[$n]."' , bolest_id='".$this->id."'";
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
	
	
	
	
	  // ------------------------------- BOLESTI SIMPTOMS -------------------------
         
        if(is_array($this->bolest_simptom) && (count($this->bolest_simptom) > 0)) {
         	
         		
         	for ($n=0;$n<count($this->bolest_simptom);$n++)
	 		 {    
		 		$sql="INSERT INTO bolesti_simptoms_list SET simptom_id='". $this->bolest_simptom[$n]."' , bolest_id='".$this->id."'";
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
         
         $sql = sprintf("INSERT INTO bolest_tags SET  tags = '%s',
	      											   bolestID = %d
	      											    ON DUPLICATE KEY UPDATE
	      											     tags = '%s',
		      										      bolestID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         	$this->conn->setsql($sql);
         	$this->conn->insertDB();
         
    //***********************************************************************************************
        
	
	
	
	
         if(is_array($upPicbolest) && (count($upPicbolest) > 0)) {
            $files = array();
            foreach ($upPicbolest as $k => $l) {
                if(is_array($l) && (count($l) > 0))
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
                  $upPic->process('pics/bolesti/');

                  if ($upPic->processed) {
                     $upPic->image_convert         = 'jpg';
                     $upPic->file_new_name_body    = $this->id."_".$counter."_thumb";
                     $upPic->image_resize          = true;
                     $upPic->image_ratio_crop      = true;
                     $upPic->image_y               = 60;
                     $upPic->image_x               = 60;
                     $upPic->file_overwrite        = false;
                     $upPic->file_auto_rename      = false;
                     $upPic->process('pics/bolesti/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class bolest: ".$upPic->error;
                        return false;
                     }
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class bolest: ".$upPic->error;
                     return false;
                  }
                  
                  $sql = sprintf("INSERT INTO bolesti_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  bolestID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  bolestID = %d
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

         $this->has_pic = is_file('pics/bolesti/'.$this->id."_1_thumb.jpg") ? 1 : 0;

         $sql = sprintf("UPDATE bolesti SET has_pic = %d WHERE bolestID = %d", $this->has_pic, $this->id);
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
     
				if(file_exists("videos/bolesti/".$video_name.".flv"))
				{
					@unlink("videos/bolesti/".$video_name.".flv");
					@unlink("videos/bolesti/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/bolesti/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/bolesti/".$video_name.".flv";
				$path_to_tmp="videos/bolesti/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE bolesti SET has_video=1 WHERE bolestID = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   		}	      
	//=============================================================================================================
	

         	$sql=sprintf("UPDATE %s SET cnt_bolest = (cnt_bolest+1) WHERE %s = %d",($_SESSION['user_type']=='user')?'users':'firms' ,($_SESSION['user_type']=='user')?'userID':'id' ,  $_SESSION['userID']);
			$this->conn->setsql($sql);
			$this->conn->updateDB();
	
            $_SESSION['cnt_bolest']++;  
         
                      
            
         return true;
      } //End Create

      
      
      
      
      
      /*== UPDATE bolest ==*/
      function update($upPicbolest) 
      {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class bolest: In update bolest_ID is not set";
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
			
			
			$body = "<br /><br />Приета е заявка за РЕДАКТИРАНЕ на Болест със следните данни: gozbite.com<br /><br />";
	        $body .= "<br />Наименование: ".$this->title;
			$body .= "<br />Източник на статията: ".$this->source;
			$body .= "<br />Автор: ".$this->autor;
			$body .= "<br />Открита през: ".$this->discovered_on;
			$body .= "<br />Със снимка: ".$this->has_pic;
			$body .= "<br />Описание: ".$this->body;
			$body .= "<br />Категории : ".print_r($this->bolest_category, 1);
			$body .= "<br />Симптоми : ".print_r($this->bolest_simptom, 1);
			$body .= "<br />userID: ".$_SESSION['userID'];
            $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "РЕДАКЦИЯ на Болест в gozbite.com";
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
      			
     	$this->body = removeBadTags($this->body);							
                                             
         $sql = sprintf("UPDATE bolesti SET title = '%s',
		                                   body = '%s',
		                                   has_pic = '%d',
		                                   source = '%s',
		                                   youtube_video = '%s',
		                                   autor_type = '%s',
		                                   autor = '%d',
		                                   discovered_on = '%s', 
		                                   active = '1',
                                           date = NOW() WHERE bolestID = %d", 
		                                   $this->title,
    									   $this->body,
								           $this->has_pic,
								           $this->source,
								           $this->youtube_video,
								           $this->autor_type,
								           $this->autor,
								           $this->discovered_on, $this->id);
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
					
					$body  = "<a href='http://gozbite.com/вход,вход_в_системата_на_кулинарния_портал_oHBoli_Bg.html'><img style='border: 0px;' src='http://gozbite.com/images/logce.png'></a><br /><br />";			  	
		  			$body .= "Здравейте, ".(($_SESSION['user_type']=='user')?get_user_nameByUserID($_SESSION['userID']):get_firm_nameByFirmID($_SESSION['userID']))."<br /><br />";			  	
		  			$body .= "<br /><br />Вие току-що редактирахте в кулинарния портал <a href='http://gozbite.com'>gozbite.com</a> Заболяване със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=bolesti&bolestID=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да го редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=bolesti&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на gozbite.com Ви желае крепко здраве и дълъг живот!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Redaktitrano Zabolqvane v gozbite.com";
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
			
			
			
			
			
			
			
         
         
         // ------------------------------- BOLESTI CATEGORIES -------------------------
         
        if(is_array($this->bolest_category) && (count($this->bolest_category) > 0)) 
        {
        	 $sql = sprintf("DELETE FROM bolesti_category_list WHERE bolest_id	= %d ", $this->id);
			 $this->conn->setsql($sql);
	         $this->conn->updateDB();
	         if($this->conn->error) {
	            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
	               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
	            }
	            return false;
	         }
         
         		
         	for ($n=0;$n<count($this->bolest_category);$n++)
	 		 {    
		 		$sql="INSERT INTO bolesti_category_list SET category_id='". $this->bolest_category[$n]."' , bolest_id='".$this->id."'";
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
         
	
	
	
	
	
	  // ------------------------------- BOLESTI SIMPTOMS -------------------------
         
        if(is_array($this->bolest_simptom) && (count($this->bolest_simptom) > 0)) 
        {
        	 $sql = sprintf("DELETE FROM bolesti_simptoms_list WHERE bolest_id	= %d ", $this->id);
			 $this->conn->setsql($sql);
	         $this->conn->updateDB();
	         if($this->conn->error) {
	            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
	               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
	            }
	            return false;
	         }
         
         		
         	for ($n=0;$n<count($this->bolest_simptom);$n++)
	 		 {    
		 		$sql="INSERT INTO bolesti_simptoms_list SET simptom_id='". $this->bolest_simptom[$n]."' , bolest_id='".$this->id."'";
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
         
         $sql = sprintf("DELETE FROM bolest_tags WHERE bolestID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
			         	
         $sql = sprintf("INSERT INTO bolest_tags SET  tags = '%s',
	      											   bolestID = %d
	      											    ON DUPLICATE KEY UPDATE
	      											     tags = '%s',
		      										      bolestID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         $this->conn->setsql($sql);
         $this->conn->insertDB();
         
    //***********************************************************************************************
      	

         if(is_array($upPicbolest) && (count($upPicbolest) > 0)) {
            $files = array();
            foreach ($upPicbolest as $k => $l) {
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
               	
             	  $imgBig = imageBolestExists($this->id,$counter,1);               	
                  $upPic->image_convert      = 'jpg';
                  $upPic->file_new_name_body = $imgBig;
                  $upPic->image_resize       = true;
                  $upPic->image_x            = 500;
                  $upPic->image_ratio_y      = true;
                  $upPic->file_overwrite     = true;
                  $upPic->file_auto_rename   = false;
                  $upPic->process('pics/bolesti/');

                  if ($upPic->processed) {
                   	
                  	 $imgThumb = imageBolestExists($this->id,$counter,2);
                     $upPic->file_new_name_body = $imgThumb;
                     $upPic->image_resize       = true;
                     $upPic->image_ratio_crop   = true;
                     $upPic->image_y            = 60;
                     $upPic->image_x            = 60;
                     $upPic->file_overwrite     = true;
                     $upPic->file_auto_rename   = false;
                     $upPic->process('pics/bolesti/');
                     if($upPic->processed) {
                        $upPic->clean();
                     } else {
                        $this->Error["Application Error ClssOffrCrtUpThmbnl-Invalid Argument"] = "Class bolest: ".$upPic->error;
                        return false;
                     }
                     
          			
                     
                  } else {
                     $this->Error["Application Error ClssOffrCrtUpImg-Invalid Argument"] = "Class bolest: ".$upPic->error;
                     return false;
                  }
                  
                       $sql = sprintf("INSERT INTO bolesti_pics 
      												SET url_big = '%s',
      												 url_thumb = '%s',
      												  bolestID = %d
      												   ON DUPLICATE KEY UPDATE
      												    url_big = '%s',
	      											     url_thumb = '%s',
	      												  bolestID = %d
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
     
				if(file_exists("videos/bolesti/".$video_name.".flv"))
				{
					@unlink("videos/bolesti/".$video_name.".flv");
					@unlink("videos/bolesti/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/bolesti/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/bolesti/".$video_name.".flv";
				$path_to_tmp="videos/bolesti/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					//@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE bolesti SET has_video=1 WHERE bolestID = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
   		}	    
	//=============================================================================================================
	
	
		
         return true;
      } //End Update

      
      
      /*== DELETE bolest PIC ==*/
      function deletePic($picIndx) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class bolest: In deletePic bolest_ID is not set";
            return false;
         }

         if(!isset($picIndx) || ($picIndx <= 0)) {
            $this->Error["Application Error ClssOffrDltPcPcIndx-Invalid Argument"] = "Class bolest: In deletePic PIC_INDEX is not set";
            return false;
         }

         $picFile    = $this->id."_".$picIndx.".jpg";
         $thumbnail  = $this->id."_".$picIndx."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('pics/bolesti/'.$picFile))
               if(!@unlink('pics/bolesti/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
            else 
            {   
	            $sql=sprintf("DELETE FROM bolesti_pics WHERE url_big = '%s'", $picFile);
				$this->conn->setsql($sql);
				$this->conn->updateDB();
            }
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('pics/bolesti/'.$thumbnail)) if(!@unlink('pics/bolesti/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('pics/bolesti/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE bolesti SET has_pic = 0 WHERE bolestID = %d",$this->id));
            $this->conn->updateDB();
         }
         
	       
	        
	      
	      
         return true;
      }

    
      
      
      /*== DELETE bolest VIDEO ==*/
      function deleteVideo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class bolest: In deleteVideo bolest_ID is not set";
            return false;
         }

         $videoFile    	= $this->id.".flv";
         $thumbnail  	= $this->id."_thumb.jpg";

         if(strlen($videoFile) > 0) {
            if(is_file('videos/bolesti/'.$videoFile))
               if(!@unlink('videos/bolesti/'.$videoFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
          }

         if(strlen($thumbnail) > 0) {
            if(is_file('videos/bolesti/'.$thumbnail))
             if(!@unlink('videos/bolesti/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('videos/bolesti/'.$this->id."_*");
         if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE bolesti SET has_video = 0 WHERE bolestID = %d",$this->id));
            $this->conn->updateDB();
         }
         
	      
         return true;
      }

    
      
      
      

      /*== DELETE bolest ==*/
      function deletebolest() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class bolest: In deleteOffr bolest_ID is not set";
            return false;
         }

        

         $sql = sprintf("DELETE FROM bolesti WHERE bolestID = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }


                            
 	 //**************************************** Изтриваме Таговете **************************************
         
         $sql = sprintf("DELETE FROM bolest_tags WHERE bolestID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
		    	
     //***********************************************************************************************
    
     
         $offPcs = glob('pics/bolesti/'.$this->id."_*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class bolest: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         
    
     
     
     // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("videos/bolesti/".$video_name.".flv"))
				{
					@unlink("videos/bolesti/".$video_name.".flv");
				}
				if(file_exists("videos/bolesti/".$video_name."._thumb.jpg"))
				{
					@unlink("videos/bolesti/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	
         
      	$sql=sprintf("DELETE FROM bolesti_category_list WHERE bolest_id = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
				
		
		$sql=sprintf("DELETE FROM bolesti_pics WHERE bolestID = %d", $this->id);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
	
		
		$sql=sprintf("UPDATE %s SET cnt_bolest = (cnt_bolest-1) WHERE %s = %d",($this->autor_type=='user')?'users':'firms' ,($this->autor_type=='user')?'userID':'id' ,  $this->autor);
		$this->conn->setsql($sql);
		$this->conn->updateDB();
	
		$_SESSION['cnt_bolest']--;
	
         return true;
      } //End Delete

		

   } //Class bolest
?>
