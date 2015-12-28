<?php
   require_once("includes/classes/Upload.class.php");
   class Forum {
      var $conn;
      var $questionID;
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
      var $forumRow;
      var $userID;
      
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Forum($conn) {
         $this->conn = $conn;
         $this->userID= $_SESSION['userID'];
      } //forum

      
        function load() 
        {

        	if(isset($this->whereclause) or isset($this->orderClause) or isset($this->limitClause)) 
         	{
                   
		   		$sql = sprintf("SELECT DISTINCT(q.questionID) as 'questionID',
												q.parentID as 'parentID',
												 q.question_title as 'question_title',								             
												  q.question_body as 'question_body',
												   q.autor_type as 'autor_type',
													 q.autor as 'autor',
													   q.rating as 'rating',
									              q.times_rated as 'times_rated',
										          q.created_on as 'created_on',
													   q.active as 'active',
										                qc.id as 'category_id',
													     qc.name as 'category'
														  FROM questions q, question_category qc
														 WHERE q.category=qc.id 
														%s  %s  %s ", $this->whereClause, $this->orderClause, $this->limitClause);

 
	            $this->conn->setsql($sql);
	            $this->conn->getTableRows();
	            if ($this->conn->error) {
	               $this->Error = $this->conn->error;
	               return false;
	            }
	
	            $this->forumRow 		= $this->conn->result;
				$this->forumRowsCount 	= $this->conn->numberrows;
            
	            if($this->forumRowsCount > 0)
	            { 
			      	   
					for($k = 0; $k < $this->forumRowsCount; $k++)
					{ 
						$sql="SELECT question_id, SUM(cnt) as 'cnt' FROM log_question WHERE question_id='".$this->forumRow[$k]['questionID']."' GROUP BY question_id";
						$this->conn->setsql($sql);
						$this->conn->getTableRow();
						$this->forumRow[$k]['cnt'] 	= $this->conn->result['cnt'];	
						
						 
						$sql="SELECT DISTINCT(questionID) as 'questionID', parentID as 'parentID', created_on as 'created_on', autor as 'autor', autor_type as 'autor_type', question_title as 'question_title', question_body as 'question_body' FROM questions WHERE parentID='".$this->forumRow[$k]['questionID']."' AND active = '1' ORDER BY created_on DESC";
						$this->conn->setsql($sql);
						$this->conn->getTableRows();						
						$this->forumRow[$k]['numQuestionAnsers'] 	= $this->conn->numberrows;						
						$resultQuestionAnsers[$k] 					= $this->conn->result;	
							
						for($i = 0; $i < $this->forumRow[$k]['numQuestionAnsers']; $i++) {
							$this->forumRow[$k]['QuestionAnsers'][$i] = $resultQuestionAnsers[$k][$i];					
						}
					
						
							//------------- FIRM AND USER ----------------------------------------------------
				
						if($this->forumRow[$k]['autor_type'] == 'firm')
						{
							$sql="SELECT  f.name as 'firm', f.email as 'email', f.phone as 'phone', fc.id as 'firm_cat_id', fc.name as 'firm_cat_name', f.location_id as 'location_id', f.cnt_drink as 'cnt_drink' FROM drinks d, firms f, firms_category_list fcl, firm_category fc  WHERE f.id = d.firm_id AND fcl.firm_id = f.id AND fc.id = fcl.category_id AND f.id = '".$this->forumRow[$k]['user']."' ";
							$this->conn->setsql($sql);
							$this->conn->getTableRow();
							$this->forumRow[$k]['Firm'] = $this->conn->result;
							
						}
						
						elseif($this->forumRow[$k]['autor_type'] == 'user')
						{						
							$sql="SELECT userID as 'userID', CONCAT(first_name, ' ', last_name) as 'user', email as 'email', location_id as 'location_id', cnt_drink as 'cnt_drink' FROM users WHERE userID = '".$this->forumRow[$k]['user']."' ";
							$this->conn->setsql($sql);
							$this->conn->getTableRow();
							$this->forumRow[$k]['User'] = $this->conn->result;
							
						}
					}
					
		            foreach($this->forumRow as $forumRow)
		            {	            				
		            		
		            	if($_SESSION['user_type'] == $forumRow['autor_type'] && $_SESSION['userID'] == $forumRow['autor'] or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)
		            	{
		            		$finalResults[$forumRow['questionID']] = $forumRow; //  Vzemame samo aktivnite aforizmi, no za avtorite i admina davame vsi4ki
		            	}
		            	elseif($forumRow['active'] == 1 ) 
		            	{
		            		$finalResults[$forumRow['questionID']] = $forumRow; 
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


      
      /*== CREATE forum ==*/
      function create() 
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
			
			
			$body = "<br /><br />Приета е заявка за ПУБЛИКУВАНЕ на Форум Тема/Мнение в GoZbiTe.Com със следните данни: <br /><br />";
	        $body .= "<br />Заглавие: ".$this->question_title;
			$body .= "<br />Автор: ".$this->autor;
			$body .= "<br />Тип на Автора: ".$this->autor_type;
			$body .= "<br />Описание: ".$this->question_body;
			$body .= "<br />userID: ".$_SESSION['userID'];
            $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Нова Форум Тема/Мнение в GoZbiTe.Com";
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
      			
     	
      
    	$this->question_body = removeBadTags($this->question_body);		// Remove Bad tags from text
											                
    		
    	$sql = sprintf("INSERT INTO questions SET parentID = %d,
                                             	   autor_type = '%s',
                                             		autor = '%d',
                                             		 question_title = '%s',
													  question_body = '%s',
													   category = %d,
														active = '1',
                                             		     created_on = NOW(),
														  updated_on = NOW()
                                             			 ON DUPLICATE KEY UPDATE                                             
                                             	        parentID = %d,
                                             		   autor_type = '%s',
                                                      autor = '%d',
                                                     question_title = '%s',
												    question_body = '%s',
												   category = %d,
												  active = '1',
                                                 created_on = NOW(),
                                                updated_on = NOW()
                                                ",    	
    										    $this->parent_id,
								                $this->autor_type,
								             	   $this->autor,								             			
								             		$this->question_title,								             			
								             		 $this->question_body,								             			
								             		  $this->question_category,
													 $this->parent_id,
								             	   $this->autor_type,
								                  $this->autor,
												 $this->question_title,								             			
								             	$this->question_body,
											   $this->question_category
								               );
								                                 
            
         $this->conn->setsql($sql);
         $this->id = $this->conn->insertDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

       
		$sql="UPDATE ".(($_SESSION['user_type']=='user')?'users':'firms')." SET cnt_comment = (cnt_comment+1) WHERE username='".$_SESSION['valid_user']."'";
		$this->conn->setsql($sql);
		$this->conn->updateDB();
		
		$_SESSION['cnt_comment']++;
	    	
         
         
         
	  // ==================================== MAIL SEND ============================================
	    	
	   if(isset($this->parent_id) AND $this->parent_id > 0) // Само мненията имат parent_id, темите нямат - по това ги различаваме и пращаме майл до всички собственици на мнения от конкретната тема	
	   {
	   		$sql="SELECT questionID, parentID, autor, autor_type FROM questions  WHERE questionID = '".$this->parent_id."' OR parentID = '".$this->parent_id."' GROUP BY autor_type, autor";
			$this->conn->setsql($sql);
			$this->conn->getTableRows();
			$resultQuestionNew = $this->conn->result;
			$numQuestionNew = $this->conn->numberrows;
	   }	
	   
	if($numQuestionNew > 0)
	{
		for($n=0; $n<$numQuestionNew; $n++)
		{
		
		//************ Автора за всяка тема ****************
			$sql="SELECT ".(($resultQuestionNew[$n]['autor_type']=='user')?" CONCAT(first_name, ' ', last_name)":'name')." as 'autor_name' FROM ".(($resultQuestionNew[$n]['autor_type']=='user')?'users':'firms')." WHERE ".(($resultQuestionNew[$n]['autor_type']=='user')?'userID':'id')." = '".$resultQuestionNew[$n]['autor']."' LIMIT 1";
			$this->conn->setsql($sql);
			$this->conn->getTableRow();
			$resultMneniqAvtor = $this->conn->result['autor_name'];	
			
			$sql="SELECT email as 'email' FROM ".(($resultQuestionNew[$n]['autor_type']=='user')?'users':'firms')." WHERE ".(($resultQuestionNew[$n]['autor_type']=='user')?'userID':'id')." = '".$resultQuestionNew[$n]['autor']."' LIMIT 1";
			$this->conn->setsql($sql);
			$this->conn->getTableRow();
			$resultMneniqEmail = $this->conn->result['email'];	
		//***********************************************************************
		
			//error_reporting(E_ALL);
			error_reporting(E_STRICT);
			
			date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('phpmailer/class.phpmailer.php');
					
			$mail             = new PHPMailer();
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			$body ="<div style=\"width:600px; \">";
			$body .= "Уважаеми, <b><font color='#FF6600'>".$resultMneniqAvtor."</font></b>, Има ново мнение в тема от форума на GoZbiTe.Com, в която и Вие сте участвали!<br /><br />";
	   		
	   		 $body .= "<div style=\"width:600px; float:left; margin: 0px 0px 50px 0px;\">	
	   		 			За да го прочетете последвайте този линк <a href='http://GoZbiTe.Com/разгледай-форум-тема-".$this->parent_id.",инересни_кулинарни_теми_потърси_съвет_или_помогни.html#question_".$this->id."'>Ново Мнение</a>.
	   					</div>";
	   		 
			 $body .= "</div>";
			 
		 
			$body  = eregi_replace("[\]",'',$body);
			
						
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Forum.GoZbiTe.Com" ;
			
			//$mail->AddReplyTo("office@gozbite.com"); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Nova tema/mnenie ot Foruma na GoZbiTe.Com";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress($resultMneniqEmail);
			$mail->AddAddress("office@gozbite.com");
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!$mail->Send()) {
			  //$MessageText .= "Грешка при изпращане на заявката: " . $mail->ErrorInfo; 
			} else {
			  //$MessageText .= "<br /><span>Благодарим Ви!<br />Вашето заявка е приета успешно. За повече информация проверете пощата за кореспондеция, с която сте се регистрирали в GoZbiTe.Com.</span><br />";
			}
		
		}
		
	}
	// ================================= KRAI na MAIL-a =========================================
	
         
		 
		 
         return true;
      } //End Create

      /*== UPDATE forum ==*/
      function update() 
      {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrUpdtID-Invalid Argument"] = "Class forum: In update forum_ID is not set";
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
			
			
			$body = "<br /><br />Приета е заявка за РЕДАКЦИЯ на Форум Тема/Мнение в GoZbiTe.Com със следните данни: <br /><br />";
	        $body .= "<br />Заглавие: ".$this->question_title;
			$body .= "<br />Автор: ".$this->autor;
			$body .= "<br />Тип на Автора: ".$this->autor_type;
			$body .= "<br />Описание: ".$this->question_body;
			$body .= "<br />userID: ".$_SESSION['userID'];
           $body  = eregi_replace("[\]",'',$body);
			
			
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Служебен Мейл";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "РЕДАКЦИЯ на Форум Тема/Мнение в GoZbiTe.Com";
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
      	

		$this->question_body = removeBadTags($this->question_body);		// Remove Bad tags from text
											                
    		
    	$sql = sprintf("UPDATE questions SET parentID = %d,
											  autor_type = '%s',
											   autor = '%d',
												question_title = '%s',
												 question_body = '%s',
												  category = %d,
												   active = '1',
												   	updated_on = NOW()
													WHERE questionID = %d",
													$this->parent_id,
												   $this->autor_type,
												  $this->autor,								             			
												 $this->question_title,								             			
												$this->question_body,								             			
											   $this->question_category,
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
		  			$body .= "<br /><br />Вие току-що редактирахте в кулинарния портал <a href='http://gozbite.com'>GoZbiTe.Com</a> Форум Тема/Мнение със следните данни:<br /><br />";
			        $body .= "Ако желаете да видите как изглежда последвайте <a href='http://gozbite.com/index.php?pg=forums&questionID=".$this->parent_id."#question_".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Ако желаете да я редактирате или изтриете може да го направите през <a href='http://gozbite.com/edit.php?pg=forums&edit=".$this->id."'>този адрес</a>!<br /><br />";			  	
			  		$body .= "Екипът на GoZbiTe.Com Ви желае винаги добър апетит!<br />";			  	
		  		
		  			$body  = eregi_replace("[\]",'',$body);
					
					
					$mail->From       = "office@gozbite.com";
					$mail->FromName   = "Служебен Мейл";
					
					//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
					
					$mail->WordWrap = 100; 
					$mail->Subject    = "Redaktirano Mnenie/Komentar / Forum na GoZbiTe.Com";
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
			
			
			
         return true;
      } //End Update

      
      
      
      function deleteAnser() 
	  {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class forum: In deletePic forum_ID is not set";
            return false;
         }

       												 
		$sql="SELECT q.question_title as 'question_title', q.autor_type as 'autor_type', q.autor as 'autor' FROM questions q WHERE q.questionID = '".$this->id."'";
		$this->conn->setsql($sql);
		$this->conn->getTableRow();
		$resultQuestionToDelete=$this->conn->result;
		
         $sql = sprintf("DELETE FROM questions WHERE questionID = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }
		
	        if($resultQuestionToDelete['autor_type'] == 'firm')
	        {
	        	$sql=sprintf("UPDATE firms SET cnt_comment = cnt_comment-1 WHERE id = %d ",$resultQuestionToDelete['autor']);
	        	$this->conn->setsql($sql);
				$this->conn->updateDB();		
				$_SESSION['cnt_comment']--;
			}  
			elseif($resultQuestionToDelete['autor_type'] == 'user')
	        {
	        	$sql=sprintf("UPDATE users SET cnt_comment = cnt_comment-1 WHERE userID = %d ",$resultQuestionToDelete['autor']);
	        	$this->conn->setsql($sql);
				$this->conn->updateDB();
				$_SESSION['cnt_comment']--;
			}  
			
     	// --------------Iztrivame i ot LOG tablicata --------------
		$sql = sprintf("DELETE FROM  log_question WHERE question_id = %d", $this->id);
     	$this->conn->setsql($sql);
     	$this->conn->updateDB();
     	if($this->conn->error) {
        	for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
           	$this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
        	}
        	return false;
     	}
		
         return true;
      }

     
      function deleteQuestion() 
	  {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssOffrDltPcID-Invalid Argument"] = "Class forum: In deletePic forum_ID is not set";
            return false;
         }

													 
		$sql="SELECT q.question_title as 'question_title', q.autor_type as 'autor_type', q.autor as 'autor' FROM questions q WHERE q.questionID = '".$this->id."'";
		$this->conn->setsql($sql);
		$this->conn->getTableRow();
		$resultQuestionToDelete=$this->conn->result;
		
       
         $sql = sprintf("DELETE FROM questions WHERE questionID = %d OR parentID = %d ", $this->id, $this->id);
         $this->conn->setsql($sql);
         $this->conn->updateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssOffrDltOffr-".$key] = $this->conn->error[$key];
            }
            return false;
         }
		 
		   if($resultQuestionToDelete['autor_type'] == 'firm')
	        {
	        	$sql=sprintf("UPDATE firms SET cnt_comment = cnt_comment-1 WHERE id = %d ",$resultQuestionToDelete['autor']);
	        	$this->conn->setsql($sql);
				$this->conn->updateDB();		
				$_SESSION['cnt_comment']--;
			}  
			elseif($resultQuestionToDelete['autor_type'] == 'user')
	        {
	        	$sql=sprintf("UPDATE users SET cnt_comment = cnt_comment-1 WHERE userID = %d ",$resultQuestionToDelete['autor']);
	        	$this->conn->setsql($sql);
				$this->conn->updateDB();
				$_SESSION['cnt_comment']--;
			}  
			
     	// --------------Iztrivame i ot LOG tablicata --------------
		$sql = sprintf("DELETE FROM  log_question WHERE question_id = %d", $this->id);
     	$this->conn->setsql($sql);
     	$this->conn->updateDB();
     	if($this->conn->error) {
        	for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
           	$this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
        	}
        	return false;
     	}
		
		 
         return true;
      }

      
     

   } //Class forum
?>
