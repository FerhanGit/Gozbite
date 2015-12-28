<?php 

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$forgotten_pass = "";
   	
 	$forgotten_pass .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
            
	<br style="clear:both;"/>	
	<div class="postBig">
		<h4>
			<div style="margin-left:6px; height:20px; width:550px;color:#0099FF;font-weight:bold;" >Забравена парола - моля въведете необходимите данни за да Ви изпратим нова.</div>		
		</h4>
	</div>	<br />	<br />	

	
	<div style="color:#FF6600; font-weight:bold;">Вие сте: 	'.(($_REQUEST['what_login'] == 'firm'?' Заведение / Фирма':' Потребител ')).' ?</div>     <br />	
  
	
	<div id="regMenu" style="width:500px;margin:0 auto;text-align:center">
		<ul id="reg-menu">
			<li><a class="reg_userLi" href="забравена-парола-user,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.($_REQUEST['what_login'] == 'user'?'style="background-position: 0 -70px;"':'').'>Потребител</a></li>
		
			<li><a class="reg_firmLi" href="забравена-парола-firm,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.($_REQUEST['what_login'] == 'firm'?'style="background-position: -140px -70px;"':'').'>Заведение / Фирма</a></li>
		</ul>
	</div>
	  <br style="clear:both;"/>	
	<hr style="600px; margin-top:20px; margin-bottom:30px;">       
     <!-- Text na ARTICLE -->';
      
    

	
	if ((!empty($_REQUEST['email'])) && (!empty($_REQUEST['username'])) && (isset($_REQUEST['send_pass'])))
	{
		 	    
		 $sql="SELECT * FROM ".(($_REQUEST['what_login']=='user')?'users':'firms')." WHERE email='".$_REQUEST['email']."' AND username='".$_REQUEST['username']."'";
		 $conn->setsql($sql);		
		 $conn->getTableRow();
		 $resultUser=$conn->result;
		 $numUser=$conn->numberrows;
		 
		 if ($numUser==1)
		 {		 		 		 

            $usrName = (($_REQUEST['what_login']=='user') ? $resultUser['first_name '].' '.$resultUser['last_name '] : $resultUser['name']); 
            $randomPassowrd = rand(0, pow(10, 5));
		 	
		 	$sql="UPDATE ".(($_REQUEST['what_login']=='user')?'users':($_REQUEST['what_login']=='firm'))." SET password = '".md5($randomPassowrd)."' WHERE email='".$_REQUEST['email']."' AND username='".$_REQUEST['username']."'";
		 	$conn->setsql($sql);		
		 	$conn->getTableRow();
		 	$resultUser=$conn->result;
		 
		 	date_default_timezone_set('Europe/Sofia');
			//date_default_timezone_set(date_default_timezone_get());
			
			include_once('includes/classes/phpmailer/class.phpmailer.php');
			
			$mail             = new PHPMailer();
			//$body             = $mail->getFile('contents.html');
			$mail->CharSet       = "UTF-8";
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			$body 		= "<img src='http://GoZbiTe_Com/images/logce.png'><br /><br />";			  	
	  		$body 		.= "Здравейте, ".$usrName."<br /><br />";			  	
	  		$body 		.= "Вашето потребителско име е ".$resultUser['username']."!<br />";			  	
	  		$body 		.= "Паролата Ви за достъп е ".$randomPassowrd." !<br />След като влезете успешно в системата с нея можете да я промените от Вашия профил.<br />";			  	
	  		$body 		.= "Екипът на GoZbiTe_Com Ви желае успех!<br />";			  	
	  		
	  		
	  	    $body  = eregi_replace("[\]",'',$body);
						
			$mail->From       = "office@gozbite.com";
			$mail->FromName   = "Екип GoZbiTe_Com";
			
			//$mail->AddReplyTo($emailTo); // tova moje da go zadadem razli4no ot $mail->From
			
			$mail->WordWrap = 100; 
			$mail->Subject    = "Vashata parola za dostap do uslugite na GoZbiTe_Com!";
			$mail->AltBody    = "За да видите това писмо, моля използвайте и-мейл клиент, който да поддържа визуализацията на HTML съдържание.!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			$mail->Priority = 1;
			$mail->ClearAddresses();
			$mail->AddAddress($_REQUEST['email']);
			$mail->AddAddress("office@gozbite.com");
			
			//$mail->ClearAttachments();
			//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
			if(!$mail->Send()) {
			  //echo "По технически причини вашето съобщение не беше изпратено: " . $mail->ErrorInfo; 
			} else {
			  //echo "<br /><span>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
			}
			

		 	$forgotten_pass .= '<div class="postBig">
				<h4>
					<div style="margin-left:6px; height:22px; width:640px;color:green;font-weight:bold;" >Паролата Ви беше изпратена на посочения Е-мейл адрес!</div>		
				</h4>
			</div>	<br />	<br />';	
		 		
			
			$forgotten_pass .= '<script type="text/javascript">
		       alert(\'Паролата Ви беше изпратена на посочения Е-мейл адрес!\')
		        window.location.href="вход-'.$_REQUEST['what_login'].',вход_в_системата_на_gozbite_com.html";
			</script> ';
			
			 
		 }
		 else 
		 {
		 	$forgotten_pass .= '<div class="postBig">
				<h4>
					<div style="margin-left:6px; height:22px; width:640px;color:red;font-weight:bold;" >Не съществува потребител с този Е-мейл адрес!</div>		
				</h4>
			</div>	<br />	<br />';	
		 	
		 	$forgotten_pass .= '	
				<form  id=\'loginform\' name=\'loginform\' method=\'post\' action=\'\'>
				 <table width=\'550\' border=\'0\' >		    
					<tr>
				      <td><label>Вашето потребителско пме</label></td>
				      <td><input type=\'text\' name=\'username\' /></td>
				    </tr>
				    <tr>
				      <td><label>Е-мейл адреса, с който сте се регистрирали в GoZbiTe_Com за да Ви изпратим новата парола.</label></td>
				      <td><input type=\'text\' name=\'email\' /></td>
				    </tr>
				    <tr>
				   	  <td></td>
				      <td><input type=\'submit\' name=\'send_pass\' value=\'Изпрати новата парола\' /></td>
				    </tr>
				  </table>
				</form>';
				
		 }
	}
	elseif($_REQUEST['what_login'] != '') 
	{
		 
			$forgotten_pass .= '
				<form  id=\'loginform\' name=\'loginform\' method=\'post\' action=\'\'>
				<table width=\'550\' border=\'0\' >		    
					<tr>
				      <td><label>Вашето Потребителско Име</label></td>
				      <td><input type=\'text\' name=\'username\' /></td>
				    </tr>
				    <tr>
				      <td><label>Е-мейл адреса, с който сте се регистрирали в GoZbiTe_Com за да Ви изпратим новата парола.</label></td>
				      <td><input type=\'text\' name=\'email\' /></td>
				    </tr>
				    <tr>
				   	  <td></td>
				      <td><input type=\'submit\' name=\'send_pass\' value=\'Изпрати новата парола\' /></td>
				    </tr>
				  </table>
				</form>';
				
		
	}


$forgotten_pass .= '</div>';
	 
	

return $forgotten_pass;

?>
