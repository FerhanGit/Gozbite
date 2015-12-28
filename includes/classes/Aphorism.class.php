<?php
   require_once("includes/classes/Upload.class.php");
   class Aphorism {
      var $conn;
      var $aphorismID;
      var $id;
      var $title;
      var $body;
      var $autor_type;
      var $autor;
      var $source;
      var $tags;
      var $updated_by;
      var $updated_on;      
      var $registered_on;   
      var $aphorismRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Aphorism($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //aphorism

      
        function load() 
        {

        	if(isset($this->whereclause) or isset($this->orderClause) or isset($this->limitClause)) 
         	{
                   
		   		$sql = sprintf("SELECT DISTINCT(a.aphorismID) as 'aphorismID',
								             a.title as 'title',								             
								              a.body as 'body',
									           a.picURL as 'picURL',
										        a.autor_type as 'autor_type',
								                 a.autor as 'autor',
									              a.date as 'date',
										           a.rating as 'rating',
									              a.times_rated as 'times_rated',
										           a.active as 'active'
										            FROM aphorisms a
											         WHERE 1=1
										        	  %s  %s  %s ", $this->whereClause, $this->orderClause, $this->limitClause);

			     
	            $this->conn->setsql($sql);
	            $this->conn->getTableRows();
	            if ($this->conn->error) {
	               $this->Error = $this->conn->error;
	               return false;
	            }
	
	            $this->aphorismRow = $this->conn->result;
				$this->aphorismRowsCount = $this->conn->numberrows;
	            
	            
	            if($this->aphorismRowsCount > 0)
	            { 
			      	                  
		            foreach($this->aphorismRow as $aphorismRow)
		            {	            				
		            		
		            	if($_SESSION['user_type'] == $aphorismRow['autor_type'] && $_SESSION['userID'] == $aphorismRow['autor'] or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)
		            	{
		            		$finalResults[$aphorismRow['aphorismID']] = $aphorismRow; //  Vzemame samo aktivnite aforizmi, no za avtorite i admina davame vsi4ki
		            	}
		            	elseif($aphorismRow['active'] == 1 ) 
		            	{
		            		$finalResults[$aphorismRow['aphorismID']] = $aphorismRow; 
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


      
      /*== CREATE aphorism ==*/
      function create($upPicAphorism) 
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
			
			
			$body = "<br /><br />Приета е заявка за РЕГИСТРАЦИЯ на Афоризъм в GoZbiTe.Com със следните данни: <br /><br />";
	        $body .= "<br />Заглавие: ".$this->title;
			$body .= "<br />Автор: ".$this->autor;
			$body .= "<br />Тип на Автора: ".$this->autor_type;
			$body .= "<br />Описание: ".$this->body;
			$body .= "<br />userID: ".$_SESSION['userID'];
            $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Нов Афоризъм в GoZbiTe.Com";
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
											                
    		
    	$sql = sprintf("INSERT INTO aphorisms SET title = '%s',
                                             	   body = '%s',
                                             	    autor_type = '%s',
                                             		 autor = '%d',
                                             		  active = '1',
                                             		   date = NOW()
                                             			ON DUPLICATE KEY UPDATE                                             
                                             	      title = '%s',
                                             		 body = '%s',
                                             		autor_type = '%s',
                                                   autor = '%d',
                                                  active = '1',
                                                 date = NOW()
                                                ",    	
    										    $this->title,
								                 $this->body,
								                  $this->autor_type,
								             	   $this->autor,								             			
								             		$this->title,
								             	   $this->body,
								             	  $this->autor_type,
								                $this->autor								             			
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
		  			$body .= "<br /><br />Вие току-що публикувахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Фраза/Афоризъм със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=aphorisms&aphorismD=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да го редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=aphorisms&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Nova Fraza / Aforizam v GoZbiTe.Com";
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
			
			
			
			
			
    
// ----------------- za ka4vane na snimkite ---------------------------------------
				
         	if(isset($upPicAphorism)) {
						
				if ((!empty($upPicAphorism['name'])))
				{
					$uploaddir = "pics/aphorisms/";
					$uploadfile = $uploaddir . basename($upPicAphorism['name']);
				
					if (move_uploaded_file($upPicAphorism['tmp_name'], $uploadfile))
				 	{
				  			// --------------------Vkarva snimkite --------------------------------
							
							$pic_file=$this->get_pic_name($uploadfile,$uploaddir,$this->id.".jpg","300");           		
							$tumbnail=$this->get_pic_name($uploaddir.$pic_file,$uploaddir,$this->id."_thumb.jpg","60");  
					
					
							 $sql = sprintf("UPDATE aphorisms SET picURL = '%s' WHERE aphorismID = %d", $this->id.".jpg",   $this->id);
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

         
     
	//=============================================================================================================
	
	
	$sql=sprintf("UPDATE %s SET cnt_aphorism = (cnt_aphorism +1) WHERE %s = %d",($_SESSION['user_type']=='user')?'users':'firms' ,($_SESSION['user_type']=='user')?'userID':'id' ,  $_SESSION['userID']);
	$this->conn->setsql($sql);
	$this->conn->updateDB();
	
        $_SESSION['cnt_aphorism ']++;  
            
            
         return true;
      } //End Create

      /*== UPDATE aphorism ==*/
      function update($upPicAphorism) 
      {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class aphorism: In update aphorism_ID is not set";
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
			
			
			$body = "<br /><br />Приета е заявка за РЕДАКЦИЯ на Афоризъм в GoZbiTe.Com със следните данни: <br /><br />";
	        $body .= "<br />Заглавие: ".$this->title;
			$body .= "<br />Автор: ".$this->autor;
			$body .= "<br />Тип на Автора: ".$this->autor_type;
			$body .= "<br />Описание: ".$this->body;
			$body .= "<br />userID: ".$_SESSION['userID'];
           $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "РЕДАКЦИЯ на Афоризъм в GoZbiTe.Com";
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
											                
    		
    	$sql = sprintf("UPDATE aphorisms SET title = '%s',
                                           body = '%s',
                                            autor_type = '%s',
                                               autor = '%d',
                                                active = '1',
                                                  date = NOW()
                                   				 	WHERE aphorismID = %d",
         										 $this->title,
								             	$this->body,
								              $this->autor_type,
								            $this->autor,
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
		  			$body .= "<br /><br />Вие току-що редактирахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Фраза/Афоризъм със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=aphorisms&aphorismD=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да го редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=aphorisms&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Redaktirana Fraza / Aforizam v GoZbiTe.Com";
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
			
			
			
			
         
         
         
         	if(isset($upPicAphorism)) 
         	{
						
				if ((!empty($upPicAphorism['name'])))
				{
					$uploaddir = "pics/aphorisms/";
					$uploadfile = $uploaddir . basename($upPicAphorism['name']);
				
					if (move_uploaded_file($upPicAphorism['tmp_name'], $uploadfile))
				 	{
				  			// --------------------Vkarva snimkite --------------------------------
							
							$pic_file=$this->get_pic_name($uploadfile,$uploaddir,$this->id.".jpg","300");           		
							$tumbnail=$this->get_pic_name($uploaddir.$pic_file,$uploaddir,$this->id."_thumb.jpg","60");  
					
					
							 $sql = sprintf("UPDATE aphorisms SET picURL = '%s' WHERE aphorismID = %d", $this->id.".jpg",   $this->id);
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
		
         return true;
      } //End Update

      
      
      /*== DELETE aphorism PIC ==*/
      function deletePic() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class aphorism: In deletePic aphorism_ID is not set";
            return false;
         }

         
         $picFile    = $this->id.".jpg";
         $thumbnail  = $this->id."_thumb.jpg";

         if(strlen($picFile) > 0) {
            if(is_file('pics/aphorisms/'.$picFile))
               if(!unlink('pics/aphorisms/'.$picFile)) {
                  $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class aphorism: In deletePic -> The file ".$picFile." cannot be deleted!";
                  return false;
               }
           
         }

         if(strlen($thumbnail) > 0) {
            if(is_file('pics/aphorisms/'.$thumbnail)) if(!unlink('pics/aphorisms/'.$thumbnail)) {
               $this->Error["Application Error ClssOffrDltPc-Invalid Operation"]   = "Class aphorism: In deletePic -> The file ".$thumbnail." cannot be deleted!";
               return false;
            }
         }		
          
	     
         if(!file_exists('pics/aphorisms/'.$this->id.".jpg")) 
         {
            $sql = sprintf("UPDATE aphorisms SET picURL = '' WHERE aphorismID = %d", $this->id);
			$this->conn->setsql($sql);
			$this->conn->updateDB();
        
         }
         
	      
	      
         return true;
      }

    
      
      

      /*== DELETE aphorism ==*/
      function deleteAphorism() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltOffrID-Invalid Argument"] = "Class aphorism: In deleteOffr aphorism_ID is not set";
            return false;
         }

        

         $offPcs = glob('pics/aphorisms/'.$this->id."*");
         

         if(count($offPcs) > 0) {
            foreach($offPcs as $val) {
               if(strlen($val) > 0) {
                  if(!@unlink($val)) {
                     $this->Error["Application Error ClssOffrDltOffr-Invalid Operation"] = "Class aphorism: In deleteOffr -> The file ".basename($val)." cannot be deleted!";
                     return false;
                  }
               }
            }
         }

         
    // ======================================== DELETE VIDEO =====================================================   	
     			$video_name = $this->id;    			
     
				if(file_exists("videos/aphorisms/".$video_name.".flv"))
				{
					@unlink("videos/aphorisms/".$video_name.".flv");
				}
				if(file_exists("videos/aphorisms/".$video_name."_thumb.jpg"))
				{
					@unlink("videos/aphorisms/".$video_name."_thumb.jpg");
				}	
				
						
	//=============================================================================================================
	

         $sql = sprintf("DELETE FROM aphorisms WHERE aphorismID = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }

        $sql=sprintf("UPDATE %s SET cnt_aphorism= (cnt_aphorism-1) WHERE %s = %d",($this->autor_type=='user')?'users':'firms' ,($this->autor_type=='user')?'userID':'id' ,  $this->autor);
	$this->conn->setsql($sql);
	$this->conn->updateDB();

	$_SESSION['cnt_aphorism']--;
		
  	
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
	


   } //Class aphorism
?>
