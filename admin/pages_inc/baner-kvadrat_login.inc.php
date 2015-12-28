<div id="BANER_KVADRAT_AND_NEWS_DIV" style="float:left;padding:0px 0px 0px 0px;">
	
     
   <div id="Main_Top" style="float:left;margin-top:0px; width:330px; ">
	 
	<div id="whiteDIV" style="margin-left:5px;margin-right:5px;float:left;width:320px; " >	 
<!-- Text na ARTICLE -->
       <div id="tabs" style="float:left; height:auto;  padding:0px 0px 0px 5px; width:310px;" >
            <div id="ARTICLE" style="float:left; margin-top:25px; margin-bottom:20px; height:12px; width:23px; padding-left:0px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;"></div> 
	   		<div style=" float:left; margin-top:19px;  margin-bottom:20px; margin-left:0px; padding-left:5px; font-size: 12px; font-weight:bold; font-family:  'Trebuchet MS', Arial, Helvetica, sans-serif; background-image:url(images/grey_dot.png); background-position:bottom; background-repeat:repeat-x;">ВХОД</div>
           
		     <br style="clear:left;"/>         
	<?php
	 
	if (($_REQUEST['what_login']=='user') && (isset($_REQUEST['username'])) && (isset($_REQUEST['pass'])) && (isset($_REQUEST['log_in'])))
	{
		 	    
		 $sql="SELECT * FROM users WHERE username='".$_REQUEST['username']."' AND password=md5('".$_REQUEST['pass']."')";
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
			 $_SESSION['name']=$resultUser['name'];
			 $_SESSION['address']=$resultUser['address'];
			 $_SESSION['userID']=$resultUser['userID'];
			 $_SESSION['user_type']= 'user';
			 $_SESSION['user_email']= $resultUser['email'];
			 $_SESSION['last_login']=$resultUser['last_login'];
			 $_SESSION['cnt_bolest']=$resultUser['cnt_bolest'];
			 $_SESSION['cnt_news']=$resultUser['cnt_news'];
			 $_SESSION['cnt_post']=$resultUser['cnt_post'];
			 $_SESSION['cnt_comment']=$resultUser['cnt_comment'];
			 $_SESSION['user_kind']=$resultUser['user_kind'];
			 
			 
			 $sql="INSERT INTO sessions SET conn_time=NOW(), session_name='".$_SESSION['valid_user']."'";
		     $conn->setsql($sql); 			
			 $conn->insertDB(); 	
			?>
	
			<script type="text/javascript">
		       window.location.href='index.php';
			</script> 
			
			<?php
			 
		 }
		 else 
		 {
		 	print "Грешно потребителско име или парола!";
		 	
		 	?>
	
				<form  id='loginform' name='loginform' method='post' action=''>
				 <table>
					<tr>
					 <td><input type="radio" name="what_login" value="user" checked><label style="color:#FFF;">Потребител | </label></td>
					 <td><input type="radio" name="what_login" value="hospital" ><label style="color:#FFF;">Здравно Заведение | </label></td>			 
					 <td><input type="radio" name="what_login" value="doctor" ><label style="color:#FFF;">Лекар</label> <br /><br /> </td>			 
					</tr>		
				</table>
				  <table width='290' border='0' style="float:left; ">		    
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
				  </table>
				</form>
				
			<?php 
		 }
		 		
	}
	elseif (($_REQUEST['what_login']=='hospital') && (isset($_REQUEST['username'])) && (isset($_REQUEST['pass'])) && (isset($_REQUEST['log_in'])))
	{
		 	    
		 $sql="SELECT * FROM hospitals WHERE username='".$_REQUEST['username']."' AND password=md5('".$_REQUEST['pass']."')";
		 $conn->setsql($sql);		
		 $conn->getTableRow();
		 $resultUser=$conn->result;
		 $numUser=$conn->numberrows;
		 
		 if ($numUser==1)
		 {		 		 		 
			 $sql2="UPDATE hospitals SET last_login=NOW() WHERE id='".$resultUser['id']."'";
		     $conn->setsql($sql2); 			
			 $conn->updateDB();	

			 			
			 $_SESSION['valid_user']=$resultUser['username'];
			 $_SESSION['name']=$resultUser['name'];
			 $_SESSION['address']=$resultUser['address'];
			 $_SESSION['bulstat']=$resultUser['bulstat'];
			 $_SESSION['mol']=$resultUser['mol'];
			 $_SESSION['userID']=$resultUser['id'];
			 $_SESSION['user_type']= 'hospital';
			 $_SESSION['last_login']=$resultUser['last_login'];
			 $_SESSION['cnt_bolest']=$resultUser['cnt_bolest'];
			 $_SESSION['cnt_news']=$resultUser['cnt_news'];
			 $_SESSION['cnt_post']=$resultUser['cnt_post'];
			 $_SESSION['cnt_comment']=$resultUser['cnt_comment'];
			 $_SESSION['user_kind']=$resultUser['user_kind'];
			 
			 
			 $sql="INSERT INTO sessions SET conn_time=NOW(), session_name='".$_SESSION['valid_user']."'";
		     $conn->setsql($sql); 			
			 $conn->insertDB(); 	
			?>
	
			<script type="text/javascript">
		       window.location.href='index.php';
			</script> 
			
			<?php
			 
		 }
		 else 
		 {
		 	print "Грешно потребителско име или парола!";
		 	
		 	?>
	
				<form  id='loginform' name='loginform' method='post' action=''>
				 <table>
					<tr>
					 <td><input type="radio" name="what_login" value="user" checked><label style="color:#FFF;">Потребител | </label></td>
					 <td><input type="radio" name="what_login" value="hospital" checked><label style="color:#FFF;">Здравно Заведение | </label></td>			 
					 <td><input type="radio" name="what_login" value="doctor" ><label style="color:#FFF;">Лекар</label> <br /><br /> </td>			 
					</tr>		
				</table>
				  <table width='290' border='0' style="float:left; ">		    
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
				  </table>
				</form>
				
			<?php 
		 }
		 		
	}
	elseif (($_REQUEST['what_login']=='doctor') && (isset($_REQUEST['username'])) && (isset($_REQUEST['pass'])) && (isset($_REQUEST['log_in'])))
	{
		 	    
		 $sql="SELECT * FROM doctors WHERE username='".$_REQUEST['username']."' AND password=md5('".$_REQUEST['pass']."')";
		 $conn->setsql($sql);		
		 $conn->getTableRow();
		 $resultUser=$conn->result;
		 $numUser=$conn->numberrows;
		 
		 if ($numUser==1)
		 {		 		 		 
			 $sql2="UPDATE doctors SET last_login=NOW() WHERE id='".$resultUser['id']."'";
		     $conn->setsql($sql2); 			
			 $conn->updateDB();	

			 			
			 $_SESSION['valid_user']=$resultUser['username'];
			 $_SESSION['name']=$resultUser['first_name'].' ' .$resultUser['last_name'];
			 $_SESSION['address']=$resultUser['addr'];
			 $_SESSION['bulstat']=$resultUser['bulstat'];
			 $_SESSION['mol']=$resultUser['mol'];
			 $_SESSION['userID']=$resultUser['id'];
			 $_SESSION['user_type']= 'doctor';
			 $_SESSION['last_login']=$resultUser['last_login'];
			 $_SESSION['cnt_bolest']=$resultUser['cnt_bolest'];
			 $_SESSION['cnt_news']=$resultUser['cnt_news'];
			 $_SESSION['cnt_post']=$resultUser['cnt_post'];
			 $_SESSION['cnt_comment']=$resultUser['cnt_comment'];
			 $_SESSION['user_kind']=$resultUser['user_kind'];
			 
			 
			 $sql="INSERT INTO sessions SET conn_time=NOW(), session_name='".$_SESSION['valid_user']."'";
		     $conn->setsql($sql); 			
			 $conn->insertDB(); 	
			?>
	
			<script type="text/javascript">
		       window.location.href='index.php';
			</script> 
			
			<?php
			 
		 }
		 else 
		 {
		 	print "Грешно потребителско име или парола!";
		 	
		 	?>
	
				<form  id='loginform' name='loginform' method='post' action=''>
				 <table>
					<tr>
					 <td><input type="radio" name="what_login" value="user" ><label style="color:#FFF;">Потребител | </label></td>
					 <td><input type="radio" name="what_login" value="hospital" ><label style="color:#FFF;">Здравно Заведение | </label></td>			 
					 <td><input type="radio" name="what_login" value="doctor" checked><label style="color:#FFF;">Лекар</label> <br /><br /> </td>			 
					</tr>		
				</table>
				  <table width='290' border='0' style="float:left; ">		    
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
				  </table>
				</form>
				
			<?php 
		 }
		 		
	}
	else 
	{
	?>
	
		<form  id='loginform' name='loginform' method='post' action=''>
		<table>
			<tr>
			 <td><input type="radio" name="what_login" value="user" checked><label style="color:#FFF;">Потребител | </label></td>
			 <td><input type="radio" name="what_login" value="hospital" ><label style="color:#FFF;">Здравно Заведение | </label></td>			 
			 <td><input type="radio" name="what_login" value="doctor" ><label style="color:#FFF;">Лекар</label> <br /><br /> </td>			 
			</tr>		
		</table>
		  <table width='290' border='0' style="float:left; ">		    
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
		  </table>
		</form>
		
	<?php } ?>
		
	  
		
  	  </div>
	 
	
  	  <a style="float:right;font-weight:bold;" href="login.php?forgotten_pass=1">Забравена парола?</a>
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na ARTICLE -->
     
      <div id="Main_Top_Bottom" style="float:left;margin-left:5px;width:320px;" ></div>
</div>	<!-- KRAI na Main_Top -->
   	





 	<div id="BANER_KVADRAT" style="float:left; width:310px;padding-right:0px;margin-top:20px;overflow:hidden;">

   

   		<div style="float:right;background-image:url(images/reklama_<?=$theme_color?>.png);margin-bottom:10px; height:28px; width:144px; background-repeat:no-repeat; font-size:11px; color:#FFFFFF;"></div>
   		<div style="float:left;border-style:double;">
	       	<!--/* OpenX Javascript Tag v2.4.4 */-->

<!--/*
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://localhost/WS/openx/www/delivery/...'
  * to
  *   'https://localhost/WS/openx/www/delivery/...'
  *
  * This noscript section of this tag only shows image banners. There
  * is no width or height in these banners, so if you want these tags to
  * allocate space for the ad before it shows, you will need to add this
  * information to the <img> tag.
  *
  * If you do not want to deal with the intricities of the noscript
  * section, delete the tag (from <noscript>... to </noscript>). On
  * average, the noscript tag is called from less than 1% of internet
  * users.
  */-->

<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://www.intermobile-bg.com/openx/www/delivery/ajs.php':'http://www.intermobile-bg.com/openx/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=4");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>-->
</script><noscript><a href='http://www.intermobile-bg.com/openx/www/delivery/ck.php?n=af261e3c&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://www.intermobile-bg.com/openx/www/delivery/avw.php?zoneid=4&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=af261e3c' border='0' alt='' /></a></noscript>

   		</div>
   	</div>
</div>