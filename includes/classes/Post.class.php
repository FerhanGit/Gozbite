<?php
   require_once("includes/classes/Upload.class.php");
   class Post {
      var $conn;
      var $postID;
      var $id;
      var $post_category;
      var $post_category_name;
      var $title;
      var $body;
      var $youtube_video;
      var $autor_type;
      var $autor;
      var $source;
      var $tags;
      var $updated_by;
      var $updated_on;      
      var $registered_on;   
      var $postRow;
      var $whereClause;
      var $orderClause;
      var $limitClause;
      var $postRowsCount;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Post($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //post

      /*== PREPARE AND LOAD DATA ==*/
      function load() {
         if(isset($this->whereclause) or isset($this->orderClause) or isset($this->limitClause)) 
         {
         
          		 $sql=sprintf("SELECT p.postID as 'postID',
							   p.post_category as 'post_category',
								pc.id as 'category_id',
								 pc.name as 'category_name',
								  p.title as 'title',
								   p.body as 'body',
								    p.picURL as 'picURL',
								     p.autor as 'autor',
								      p.autor_type as 'autor_type',
									   p.source as 'source',
									    p.rating as 'rating',
									     p.times_rated as 'times_rated',
									      p.has_video as 'has_video',
									       p.youtube_video as 'youtube_video',
									        p.date as 'date',
							    			 p.active as 'active'
									  		  FROM posts p, post_category pc
										       WHERE p.post_category = pc.id AND 1=1
										        %s  %s  %s ", $this->whereClause, $this->orderClause, $this->limitClause);

		       	 
            $this->conn->setsql($sql);
            $this->conn->getTableRows();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->postRow = $this->conn->result;
			$this->postRowsCount = $this->conn->numberrows;
            
            
            if($this->postRowsCount > 0)
            { 
		        // Get Type Categories
				for($k = 0; $k < $this->postRowsCount; $k++)
				{
				            
		            
	            // ============================= PICTURES =========================================
			
	           
					$sql="SELECT * FROM post_pics WHERE postID='".$this->postRow[$k]['postID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->postRow[$k]['numPics']  	= $this->conn->numberrows;
					$resultPostsPics[$k] 			= $this->conn->result;	
					
					for($i = 0; $i < $this->postRow[$k]['numPics']; $i++) {
						$this->postRow[$k]['resultPics']['url_big'][$i] 	= $resultPostsPics[$k][$i]["url_big"];
						$this->postRow[$k]['resultPics']['url_thumb'][$i] 	= $resultPostsPics[$k][$i]["url_thumb"];
					}
			
					
	
				// =============================== Cnt ========================================	
		
		
					$sql="SELECT post_id, SUM(cnt) as 'cnt' FROM log_post WHERE post_id='".$this->postRow[$k]['postID']."' GROUP BY post_id LIMIT 1";
					$this->conn->setsql($sql);
					$this->conn->getTableRow();
					$this->postRow[$k]['cnt'] 	= $this->conn->result['cnt'];					
					
				// =============================== COMMENTS ========================================	
				
					
					$sql="SELECT commentID, sender_name , sender_email , autor_type, autor, comment_body , parentID , created_on  FROM post_comment WHERE post_id='".$this->postRow[$k]['postID']."' ORDER BY created_on DESC";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$this->postRow[$k]['numComments'] 	= $this->conn->numberrows;
					$resultPostsComment[$k] 			= $this->conn->result;	
						
					for($i = 0; $i < $this->postRow[$k]['numComments']; $i++) {
						$this->postRow[$k]['Comments'][$i] = $resultPostsComment[$k][$i];					
					}
					
					
					
					//--------------------------- TAGS ------------------------------------------
		
					$sql="SELECT * FROM post_tags WHERE postID='".$this->postRow[$k]['postID']."'";
					$this->conn->setsql($sql);
					$this->conn->getTableRows();
					$postTagsCount 		= $this->conn->numberrows;
					$resultPostsTags[$k]= $this->conn->result;	
						
					if($postTagsCount > 0) {
						$this->postRow[$k]['Tags'] = explode(',',$resultPostsTags[$k][$i]['tags']);					
					}
					$this->postRow[$k]['numTags'] = count($this->postRow[$k]['Tags']);
					
				}   
	              
	                  
	            foreach($this->postRow as $postRow)
	            {
	            	if($_SESSION['user_type'] == $postRow['autor_type'] && $_SESSION['userID'] == $postRow['autor'] or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)
	            	{
	            		$finalResults[$postRow['postID']] = $postRow; //  Vzemame samo aktivnite statii, no za avtorite i admina davame vsi4ki
	            	}
	            	elseif($postRow['active'] == 1 ) 
	            	{
	            		$finalResults[$postRow['postID']] = $postRow;
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



      /*== CREATE post ==*/
      function create($upPicPost) 
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
			
			
			$body = "<br /><br />Приета е заявка за Публикуване на Статия със следните данни: GoZbiTe.Com<br /><br />";
	        $body .= "<br />Заглавие: ".$this->title;
			$body .= "<br />Източник на статията: ".$this->source;
			$body .= "<br />Автор: ".$this->autor;
			$body .= "<br />Тип на Автора: ".$this->autor_type;
			$body .= "<br />Описание: ".$this->body;
			$body .= "<br />Категории : ".print_r($this->post_category, 1);
			$body .= "<br />userID: ".$_SESSION['userID'];
            $body .= "<br />Тагове: ".$this->tags;
			$body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Нова Статия в GoZbiTe.Com";
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
											                
    		
    	$sql = sprintf("INSERT INTO posts SET title = '%s',
                                             	 body = '%s',
                                             	  post_category = '%d',
                                             	   source = '%s',
                                             		autor_type = '%s',
                                             		 autor = '%d',
                                             		  active = '1',
                                                 	   youtube_video = '%s',
                                             		    date = NOW()
                                             	
                                             ON DUPLICATE KEY UPDATE
                                             
                                             	      title = '%s',
                                             		 body = '%s',
                                             		post_category = '%d',
                                             	   source = '%s',
                                                  autor_type = '%s',
                                                 autor = '%d',
                                                active = '1',
                                               youtube_video = '%s',
                                              date = NOW()
                                             ",    	
    										  $this->title,
								               $this->body,
								                $this->post_category,
								             	 $this->source,
								             	  $this->autor_type,
								             	   $this->autor,								             			
								             		$this->youtube_video,								             			
								             		$this->title,
								             	   $this->body,
								             	  $this->post_category,
								             	 $this->source,
								                 $this->autor_type,
								               $this->autor,
								               $this->youtube_video								             			
								             );
								                                 
                                   
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
		  			$body .= "<br /><br />Вие току-що публикувахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> нова Статия със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=posts&postID=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да я редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=posts&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Nova Statiq v GoZbiTe.Com";
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
         
         $sql = sprintf("INSERT INTO post_tags SET  tags = '%s',
	      											 postID = %d
	      											  ON DUPLICATE KEY UPDATE
	      											   tags = '%s',
		      										    postID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         	$this->conn->setsql($sql);
         	$this->conn->insertDB();
         
    //***********************************************************************************************
         
// ----------------- za ka4vane na snimkite ---------------------------------------
				
         	if(isset($upPicPost)) {
						
				if ((!empty($upPicPost['name'])))
				{
					$uploaddir = "pics/posts/";
					$uploadfile = $uploaddir . basename($upPicPost['name']);
				
					if (move_uploaded_file($upPicPost['tmp_name'], $uploadfile))
				 	{
				  			// --------------------Vkarva snimkite --------------------------------
							
							$pic_file=$this->get_pic_name($uploadfile,$uploaddir,$this->id.".jpg","500");           		
							$tumbnail=$this->get_pic_name($uploaddir.$pic_file,$uploaddir,$this->id."_thumb.jpg","60");  
					
					
							 $sql = sprintf("UPDATE posts SET picURL = '%s' WHERE postID = %d", $this->id.".jpg",   $this->id);
					         $this->conn->setsql($sql);
					         $this->conn->updateDB();
					         if($this->conn->error) {
					            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
					               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
					            }
					            return false;
					         }		
				 		
					}
					@unlink($uploadfile);
				}
						
				
				// --------------------------------------------------------------------------------
			
         }

         
     // ======================================== KA4va VIDEO =====================================================   	
     		if($_FILES['imagefile']['name']<>'')
     		{
     			$video_name = $this->id;    			
     
				if(file_exists("videos/posts/".$video_name.".flv"))
				{
					@unlink("videos/posts/".$video_name.".flv");
					@unlink("videos/posts/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/posts/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/posts/".$video_name.".flv";
				$path_to_tmp="videos/posts/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE posts SET has_video=1 WHERE postID = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
     		}      
	//=============================================================================================================
	
	
	// ======================================== KA4va VIDEO =====================================================   	
     		if($_FILES['imagefile']['name']<>'')
     		{
     			$video_name = $this->id;    			
     
				if(file_exists("videos/posts/".$video_name.".flv"))
				{
					@unlink("videos/posts/".$video_name.".flv");
					@unlink("videos/posts/".$video_name."_thumb.jpg");
				}
				preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
				$path_to_sorce=	"videos/posts/".$video_name.".".strtolower($matches[2]);
				@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
				
				$ffpath="/usr/bin/";
				$res= $big_resize;
				$path_to_big="videos/posts/".$video_name.".flv";
				$path_to_tmp="videos/posts/".$video_name."_thumb.jpg";		
				
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
				passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
				if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
				{
					@unlink($path_to_sorce);
					
				}	

					$sql = sprintf("UPDATE posts SET has_video=1 WHERE postID = %d ", $this->id);
			        $this->conn->setsql($sql);
					$this->conn->updateDB();			
									
     		}      
	//=============================================================================================================
	
	
	
	   
         	$sql="UPDATE ".(($_SESSION['user_type']=='user')?'users':'firm')." SET cnt_post = (cnt_post+1) WHERE username='".$_SESSION['valid_user']."'";
			$this->conn->setsql($sql);
			$this->conn->updateDB();
	
    		$_SESSION['cnt_post']++;	     

    		   
         
         return true;
      } //End Create

      /*== UPDATE post ==*/
      function update($upPicPost) {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class post: In update post_ID is not set";
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
			
			
			$body = "<br /><br />Приета е заявка за РЕДАКЦИЯ на Статия със следните данни: GoZbiTe.Com<br /><br />";
	        $body .= "<br />Заглавие: ".$this->title;
			$body .= "<br />Източник на статията: ".$this->source;
			$body .= "<br />Автор: ".$this->autor;
			$body .= "<br />Тип на Автора: ".$this->autor_type;
			$body .= "<br />Описание: ".$this->body;
			$body .= "<br />Категории : ".print_r($this->post_category, 1);
			$body .= "<br />userID: ".$_SESSION['userID'];
            $body .= "<br />Тагове: ".$this->tags;
			$body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "РЕДАКЦИЯ на Статия в GoZbiTe.Com";
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
											                
    		
    	$sql = sprintf("UPDATE posts SET title = '%s',
                                           body = '%s',
                                            post_category = '%d',
                                             source = '%s',
                                              autor_type = '%s',
                                               autor = '%d',
                                                active = '1',
                                                 youtube_video = '%s',
                                               	  date = NOW()
                                   				 	WHERE postID = %d",
         										 $this->title,
								             	$this->body,
								               $this->post_category,
								              $this->source,
								             $this->autor_type,
								            $this->autor,
			                               $this->youtube_video,
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
		  			$body .= "<br /><br />Вие току-що редактирахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Статия със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=posts&postID=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да я редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=posts&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Redaktirana Statiq v GoZbiTe.Com";
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
         
         $sql = sprintf("DELETE FROM post_tags WHERE postID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
			         	
         $sql = sprintf("INSERT INTO post_tags SET  tags = '%s',
	      											 postID = %d
	      											  ON DUPLICATE KEY UPDATE
	      											   tags = '%s',
		      										    postID = %d
      											   		 ",
      											        $this->tags,
      											       $this->id,
      											      $this->tags,
      											     $this->id);
         $this->conn->setsql($sql);
         $this->conn->insertDB();
         
    //***********************************************************************************************
      	
         	if(isset($upPicPost)) {
						
				if ((!empty($upPicPost['name'])))
				{
					$uploaddir = "pics/posts/";
					$uploadfile = $uploaddir . basename($upPicPost['name']);
				
					if (move_uploaded_file($upPicPost['tmp_name'], $uploadfile))
				 	{
				  			// --------------------Vkarva snimkite --------------------------------
							
							$pic_file=$this->get_pic_name($uploadfile,$uploaddir,$this->id.".jpg","500");           		
							$tumbnail=$this->get_pic_name($uploaddir.$pic_file,$uploaddir,$this->id."_thumb.jpg","60");  
					
					
							 $sql = sprintf("UPDATE posts SET picURL = '%s' WHERE postID = %d", $this->id.".jpg",   $this->id);
					         $this->conn->setsql($sql);
					         $this->conn->updateDB();
					         if($this->conn->error) {
					            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
					               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
					            }
					            return false;
					         }		
				 		
					}
					@unlink($uploadfile);
				}
						
				
				// --------------------------------------------------------------------------------
					
         }
         
        
     // ======================================== KA4va VIDEO =====================================================   	
   if($_FILES['imagefile']['name']<>'') 
   {
   		$video_name = $this->id;    			
   
    
		if(file_exists("videos/posts/".$video_name.".flv"))
		{
			@unlink("videos/posts/".$video_name.".flv");
			@unlink("videos/posts/".$video_name."_thumb.jpg");
		}
		preg_match("/(.+)\.(.*?)\Z/", $_FILES['imagefile']['name'], $matches);
		$path_to_sorce=	"videos/posts/".$video_name.".".strtolower($matches[2]);
		@copy ($_FILES['imagefile']['tmp_name'], $path_to_sorce);				
									
			
		$ffpath="/usr/bin/";
		$res= $big_resize;
		$path_to_big="videos/posts/".$video_name.".flv";
		$path_to_tmp="videos/posts/".$video_name."_thumb.jpg";		
		
		passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' '.$res.' -f flv '.$path_to_big);
		passthru($ffpath.'ffmpeg -i '.$path_to_sorce.' -f mjpeg -ss 00:00:062 -t 00:00:01 -s 240x180 '.$path_to_tmp);
		if(file_exists($path_to_sorce) && !eregi('.flv',$path_to_sorce))
		{
			@unlink($path_to_sorce);
			
		}	

		$offPcs = glob('videos/posts/'.$this->id."_*");
    	if($offPcs == 1) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
       		$this->conn->setsql(sprintf("UPDATE posts SET has_video = 1 WHERE postID = %d",$this->id));
    	 	$this->conn->updateDB();
         }			
   }							
				      
	//=============================================================================================================
	

        		
		
         return true;
      } //End Update

      
      
      /*== DELETE post PIC ==*/
      function deletePic() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class post: In deletePic post_ID is not set";
            return false;
         }

         
         $picFile    = $this->id.".jpg";
         $thumbnail  = $this->id."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('pics/posts/'.$picFile))
               if(!unlink('pics/posts/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class post: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
           
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('pics/posts/'.$thumbnail)) if(!unlink('pics/posts/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class post: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }		
          
	     
         if(!file_exists('pics/posts/'.$this->id.".jpg")) 
         {
            $sql = sprintf("UPDATE posts SET picURL = '' WHERE postID = %d", $this->id);
			$this->conn->setsql($sql);
			$this->conn->updateDB();
        
         }
         
	      
	      
         return true;
      }

    
       /*== DELETE post VIDEO ==*/
      function deleteVideo() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class bolest: In deleteVideo bolest_ID is not set";
            return false;
         }

         $videoFile    	= $this->id.".flv";
         $thumbnail  	= $this->id."_thumb.jpg";

         if(strlen($videoFile) > 0) {
            if(is_file('videos/posts/'.$videoFile))
               if(!@unlink('videos/posts/'.$videoFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$videoFile." cannot be deleted!";
                  return false;
               }
          }

         if(strlen($thumbnail) > 0) {
            if(is_file('videos/posts/'.$thumbnail))
             if(!@unlink('videos/posts/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class bolest: In deleteVideo -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }
		
         $offPcs = glob('videos/posts/'.$this->id."_*");
         if($offPcs == 0) {// da oprawim has_pics - ako iztrie 1wa snimka, znachi niama snimki.
            $this->conn->setsql(sprintf("UPDATE posts SET has_video = 0 WHERE postID = %d",$this->id));
            $this->conn->updateDB();
         }
         
	      
         return true;
      }

    
      

      /*== DELETE post ==*/
      function deletePost() {
         if((!isset($this->id) || ($this->id <= 0)) && $_SESSION['user_kind'] == 2) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class post: In deleteOffr post_ID is not set";
            return false;
         }

        

         $offPcs = glob('pics/posts/'.$this->id."*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class post: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         
    // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("videos/posts/".$video_name.".flv"))
				{
					@unlink("videos/posts/".$video_name.".flv");
				}
				if(file_exists("videos/posts/".$video_name."_thumb.jpg"))
				{
					@unlink("videos/posts/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	

         $sql = sprintf("DELETE FROM posts WHERE postID = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
         
         $sql = sprintf("DELETE FROM post_pics WHERE postID = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
         
         
 	//**************************************** Изтриваме Таговете **************************************
         
         $sql = sprintf("DELETE FROM post_tags WHERE postID = %d ",$this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
		    	
     //***********************************************************************************************
     
     
      		$sql=sprintf("UPDATE %s SET cnt_post = (cnt_post-1) WHERE %s = %d",($this->autor_type=='user')?'users':'firms' ,($this->autor_type=='user')?'userID':'id' ,  $this->autor);
			$this->conn->setsql($sql);
			$this->conn->updateDB();
			
			$_SESSION['cnt_post']--;
	
         return true;
      } //End Delete

		
		   
	function getFileExtension($str)  // Vra6ta extension-a na snimkata ,kato mu se podade URL-a !
	{	
	   $i = strrpos($str,".");
	   if (!$i) { return ""; }
	
	   $l = strlen($str) - $i;
	   $ext = substr($str,$i+1,$l);
	
	   return $ext;	
	}
		
		
			
	function get_pic_name($val, $dest_dir, $offert_pic_name, $pic_width=300)				// Vra6ta ime na snimkata,koeto se vkarva v DB sled tova
	{	
		$ime_pic		=	basename($val);								//originalno ime na snimkata
		$novo_ime		=	$offert_pic_name;								//novo ime(nomer na ofertata) + raz6irenieto na snimkata
		$new_name		=	$dest_dir.$novo_ime;												//promenq staroto ime na novoto
		@copy($val,$new_name);
		//unlink($new_place);
		//@rename($ime_pic,$novo_ime);		
		
		
		if (($this->getFileExtension($val)	==	"jpeg") or ($this->getFileExtension($val)	==	"jpg") or ($this->getFileExtension($val)	==	"JPEG") or ($this->getFileExtension($val)=="JPG"))
		{
			@$src 		= imagecreatefromjpeg($val);
			@list($width,$height)	=	getimagesize($val);
		
			$newwidth	=	$pic_width;
			if (($height) && ($width))	
			{
				$newheight = ($height/$width)*$pic_width;	
			}
		
			@$tmp 		= imagecreatetruecolor($newwidth,$newheight);
			@imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		
			$filename 	=	$new_name; 
			@imagejpeg($tmp,$filename,100);
	
			@imagedestroy($src);
			@imagedestroy($tmp);
			//@rename($ime_pic,$new_ime_pic);
			
			return $novo_ime;
		}
		
		elseif (($this->getFileExtension($val) == "GIF") or ($this->getFileExtension($val) == "gif"))
		{
			@$src 		= imagecreatefromgif($val);
			@list($width,$height)	=	getimagesize($val);
		
			$newwidth 	= $pic_width;
			if (($height) && ($width))	
			{	
				$newheight = ($height/$width)*$pic_width;	
			}
			
			@$tmp 		= imagecreatetruecolor($newwidth,$newheight);
			@imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		
			$filename 	= $new_name; 
			@imagegif($tmp,$filename,100);
	
			@imagedestroy($src);
			@imagedestroy($tmp);
			
			return $novo_ime;
		}	
		else return false;
	
		
		
	}
	


   } //Class post
?>
