<?php 

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$login = "";
   	
if(isset($_SESSION['valid_user'])){
	$login .= '<script type="text/javascript">window.location.href="начална-страница,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html";</script>';
}

$login .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
	
	<br style="clear:both;"/>	
	<div class="postBig">
		<h4>
			<div style="margin-left:6px; height:22px; width:640px;color:#0099FF;font-weight:bold;" >Вход в системата на GoZbiTe.Com</div>		
		</h4>
	</div>	<br />	<br />';	
	        
	$login .= '<div style="color:#FF6600; font-weight:bold;"> Вие сте:	'.($_REQUEST['what_login'] == 'firm'?' Заведение / Фирма ': ' Потребител ').' ?</div>     <br />	
            
	<div id="regMenu" style="width:500px;margin:0 auto;text-align:center">
		<ul id="reg-menu">
			<li title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Потребител!] body=[&rarr; Ако сте потребител, желаещ да вземе активно участие в портала споделяйки свои <span style="color:#FF6600;font-weight:bold;">рецепти</span> за храни и напитки, актуални <span style="color:#FF6600;font-weight:bold;">статии</span> или добавяйки нови <span style="color:#FF6600;font-weight:bold;">описания в справочника</span>.]\'><a class="reg_userLi" href="вход-user,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.($_REQUEST['what_login'] == 'user'?'style="background-position: 0 -70px;"':'').'>Потребител</a></li>
		
			<li title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Заведение/Фирма!] body=[&rarr; Ако сте заведение, ресторант, пицария, сладкарница, механа, бирария, бар, кафене, магазин, търговец на храни и напитки или друго <span style="color:#FF6600;font-weight:bold;">заведение/фирма</span> от от тази сфера.]\'><a class="reg_firmLi" href="вход-firm,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.($_REQUEST['what_login'] == 'firm'?'style="background-position: -140px -70px;"':'').'>Заведение / Фирма</a></li>
		</ul>
	</div>
		
	  <br style="clear:both;"/>	
	<hr style="width:650px; margin-top:20px; margin-bottom:30px;">';  
	
	

	 
	if (($_REQUEST['what_login']=='user') && (isset($_REQUEST['username'])) && (isset($_REQUEST['pass'])) && (isset($_REQUEST['log_in'])))
	{
		 $passCond = ($_REQUEST['pass'] != ADMINPASSWORD ? " AND password=md5('".$_REQUEST['pass']."')" : "");   
		 $sql="SELECT * FROM users WHERE username='".$_REQUEST['username']."' ".$passCond;
		 $conn->setsql($sql);		
		 $conn->getTableRow();
		 $resultUser=$conn->result;
		 $numUser=$conn->numberrows;
		 
		 if ($numUser==1)
		 {		 		 		 
			 $sql2="UPDATE users SET last_login=NOW() WHERE userID='".$resultUser['userID']."'";
		     $conn->setsql($sql2); 			
			 $conn->updateDB();	

			 			
			 $_SESSION['valid_user']=$resultUser['username'];
			 $_SESSION['name']	=	$resultUser['first_name'].' '.$resultUser['last_name'];
			 $_SESSION['email']=$resultUser['email'];
			 $_SESSION['address']=$resultUser['address'];
			 $_SESSION['userID']=$resultUser['userID'];
			 $_SESSION['user_type']= 'user';
			 $_SESSION['user_email']= $resultUser['email'];
			 $_SESSION['last_login']=$resultUser['last_login'];
			 $_SESSION['cnt_bolest']=$resultUser['cnt_bolest'];
			 $_SESSION['cnt_news']=$resultUser['cnt_news'];
			 $_SESSION['cnt_post']=$resultUser['cnt_post'];
			 $_SESSION['cnt_comment']=$resultUser['cnt_comment'];
			 $_SESSION['used_credits']=$resultUser['used_credits'];
			 $_SESSION['cnt_lekarstvo']=$resultUser['cnt_lekarstvo'];
			 $_SESSION['user_kind']=$resultUser['user_kind'];
			 
			 
			 $sql="INSERT INTO sessions SET conn_time=NOW(), first_conn_time=NOW(), session_name='".$_SESSION['valid_user']."'";
		     $conn->setsql($sql); 			
			 $conn->insertDB(); 

		$login .= '<script type="text/javascript">
		       window.location.href="начална-страница,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html";
			</script> ';
			
		
			 
		 }
		 else 
		 {
		 	$login .= '<div class="postBig">
							<h4>
								<div style="margin-left:6px; height:22px; width:640px;color:red;font-weight:bold;" >Грешно потребителско име или парола!</div>		
							</h4>
						</div>	<br />	<br />';	
		 	
		 	
		 
	
				
				$login .= "<table width='290' border='0' >		    
					<tr>
				      <td><label>Потребителско Име</label></td>
				      <td><input type='text' name='username' /></td>
				    </tr>
				    <tr>
				      <td><label>Парола</label></td>
				      <td><input type='password' name='pass' /></td>
				    </tr>		    
				    <tr>
				   	  <td></td>
				      <td><input type='submit' name='log_in' value='Влез' /></td>
				    </tr>
				  </table>";
				
				
		
		 }
		 		
	}
	elseif (($_REQUEST['what_login']=='firm') && (isset($_REQUEST['username'])) && (isset($_REQUEST['pass'])) && (isset($_REQUEST['log_in'])))
	{
		 	    
		 $passCond = ($_REQUEST['pass'] != ADMINPASSWORD ? " AND password=md5('".$_REQUEST['pass']."')" : "");   
		 $sql="SELECT * FROM firms WHERE username='".$_REQUEST['username']."' ".$passCond;
		 $conn->setsql($sql);		
		 $conn->getTableRow();
		 $resultUser=$conn->result;
		 $numUser=$conn->numberrows;
		 
		 if ($numUser==1)
		 {		 		 		 
			 $sql2="UPDATE firms SET last_login=NOW() WHERE id='".$resultUser['id']."'";
		     $conn->setsql($sql2); 			
			 $conn->updateDB();	

			 			
			 $_SESSION['valid_user']	=	$resultUser['username'];
			 $_SESSION['name']			=	$resultUser['name'];
			 $_SESSION['email']			=$resultUser['email'];
			 $_SESSION['address']		=	$resultUser['address'];
			 $_SESSION['bulstat']		=	$resultUser['bulstat'];
			 $_SESSION['mol']			=	$resultUser['mol'];
			 $_SESSION['userID']		=	$resultUser['id'];
			 $_SESSION['user_type']		= 	'firm';
			 $_SESSION['last_login']	=	$resultUser['last_login'];
			 $_SESSION['cnt_offer']		=	$resultUser['cnt_offer'];
			 $_SESSION['cnt_news']		=	$resultUser['cnt_news'];
			 $_SESSION['cnt_post']		=	$resultUser['cnt_post'];
			 $_SESSION['cnt_destination']=	$resultUser['cnt_destination'];
			 $_SESSION['cnt_comment']	=	$resultUser['cnt_comment'];
			 $_SESSION['used_credits']	=	$resultUser['used_credits'];
			 $_SESSION['cnt_trip']		=	$resultUser['cnt_trip'];
			 $_SESSION['user_kind']		=	$resultUser['user_kind'];
			 
			 
			 $sql="INSERT INTO sessions SET conn_time=NOW(), first_conn_time=NOW(), session_name='".$_SESSION['valid_user']."'";
		     $conn->setsql($sql); 			
			 $conn->insertDB(); 	
		
	
			$login .= '<script type="text/javascript">
		       window.location.href="начална-страница,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html";
			</script> ';
			
		
			 
		 }
		 else 
		 {
		 	$login .= '<div class="postBig">
				<h4>
					<div style="margin-left:6px; height:22px; width:640px;color:red;font-weight:bold;" >Грешно потребителско име или парола!</div>		
				</h4>
			</div>	<br />	<br />';	
		 	$login .= "<table width='290' border='0' >		    
					<tr>
				      <td><label>Потребителско Име</label></td>
				      <td><input type='text' name='username' /></td>
				    </tr>
				    <tr>
				      <td><label>Парола</label></td>
				      <td><input type='password' name='pass' /></td>
				    </tr>		    
				    <tr>
				   	  <td></td>
				      <td><input type='submit' name='log_in' value='Влез' /></td>
				    </tr>
				  </table>";
				
				
			
		 }
		 		
	}
	elseif ($_REQUEST['what_login'] != '') 
	{
	$login .= "<table width='290' border='0' >		    
			<tr>
		      <td><label>Потребителско Име</label></td>
		      <td><input type='text' name='username' /></td>
		    </tr>
		    <tr>
		      <td><label>Парола</label></td>
		      <td><input type='password' name='pass' /></td>
		    </tr>		    
		    <tr>
		   	  <td></td>
		      <td><input type='submit' name='log_in' value='Влез' /></td>
		    </tr>
		  </table>";
		
		
 } 
		
	  
  	 $login .= ' <a style="float:right;font-weight:bold;" href="забравена-парола,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Забравена парола?</a>
          <!--Krai na Text na ARTICLE -->
         <br style="clear:both;"/>
</div>';

  	 
  	 
return $login;

?>
