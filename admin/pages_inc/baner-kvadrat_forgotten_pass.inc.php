<div id="BANER_KVADRAT_AND_NEWS_DIV" style="float:left;padding:10px 0px 10px 0px;">
	
   <div id="Main_Top" style="float:left;margin-top:35px; width:330px; ">
	 
	<div id="whiteDIV" style="margin-left:5px;margin-right:5px;float:left;width:320px; " >	 
<!-- Text na ARTICLE -->
        <div id="tabs" style="float:left; height:auto;  padding:0px 0px 0px 5px; width:310px;  " >
                          
	<?php
	 
	if ((!empty($_REQUEST['email'])) && (!empty($_REQUEST['username'])) && (isset($_REQUEST['send_pass'])))
	{
		 	    
		 $sql="SELECT * FROM ".(($_REQUEST['what_login']=='user')?'users':(($_REQUEST['what_login']=='doctor')?'doctors':'hospitals'))." WHERE email='".$_REQUEST['email']."' AND username='".$_REQUEST['username']."'";
		 $conn->setsql($sql);		
		 $conn->getTableRow();
		 $resultUser=$conn->result;
		 $numUser=$conn->numberrows;
		 
		 if ($numUser==1)
		 {		 		 		 
			 // ПРАЩАМЕ Е–МЕЙЛ С ПАРОЛАТА!
			require("classes/phpmailer/class.phpmailer.php");

			$mail = new PHPMailer();

			$mail->Host = "localohost";  // specify main and backup server
			$mail->SMTPAuth = false;     // turn on SMTP authentication
//			$mail->Username = "";  // SMTP username
//			$mail->Password = ""; // SMTP password
//			$mail->SetLanguage("ru");
			$mail->IsSMTP();                                      // set mailer to use SMTP

			$mail->From = "MailServer@oHBoli.bg";
			$mail->FromName = "oHBoli.BG";
	//		$mail->AddAddress($adminEmail, "Creditcenter staff");
	//		$mail->AddAddress("floorer@gbg.bg"); 
	//		$mail->AddReplyTo("info@example.com", "Information");

			$mail->WordWrap = 100;                                 // set word wrap to 50 characters
	//		$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
	//		$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
			$mail->IsHTML(true);                                  // set email format to HTML
			$mail->CharSet="utf-8";

			if ($_REQUEST['what_login']=='hospital') $usrName = $resultUser['name'];
			else $usrName = $resultUser['first_name'].' '.$resultUser['last_name'];
			
			$mail->Subject = "Вашата парола за достъп до услугите на oHBoli.BG!";
   			$dataField 		= "<img src='http://ohboli.bg/images/logce.png'><br /><br />";			  	
	  		$dataField 		= "Здравейте, ".$usrName."<br /><br />";			  	
	  		$dataField 		= "Вашето потребителско име е ".$resultUser['username']."!<br />";			  	
	  		$dataField 		= "Паролата Ви за достъп е ".md5($resultUser['password'])."!<br /><br />";			  	
	  		$dataField 		= "Екипът на oHBoli.BG Ви желае успех!<br />";			  	
	  		$mail->Body     = stripslashes($dataField); // "This is the HTML message body <b>in bold!</b>";					
	  		$mailSent 		= $mail->Send();	
	

			?>
			<script type="text/javascript">
		       alert('Паролата Ви беше изпратена на посочения Е-мейл адрес!')
		        window.location.href='login.php';
			</script> 
			<?php
			 
		 }
		 else 
		 {
		 	print "Не съществува потребител с този Е-мейл адрес!";
		 	
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
				      <td><label>Моля, въведете Вашия Е-мейл адрес.</label></td>
				      <td><input type='text' name='email' /></td>
				    </tr>
				    <tr>
				   	  <td></td>
				      <td><input type='submit' name='send_pass' value='Изпрати' /></td>
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
				      <td><label>Моля, въведете Вашия Е-мейл адрес.</label></td>
				      <td><input type='text' name='email' /></td>
				    </tr>
				    <tr>
				   	  <td></td>
				      <td><input type='submit' name='send_pass' value='Изпрати' /></td>
				    </tr>
				  </table>
				</form>
				
<?php 				
	}	
?>
		
</div>
	 
	
  	      <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na ARTICLE -->
     
      <div id="Main_Top_Bottom" style="background-color:#F5F5F5;float:left;margin-left:5px;width:320px;" ></div>
</div>	<!-- KRAI na Main_Top -->
   	





   	<div id="BANER_KVADRAT" style="float:left; width:310px;padding-right:0px;overflow:hidden;">

   

 <div style="float:right;background-image:url(images/reklama_<?=$theme_color?>.png);margin-bottom:5px; height:28px; width:144px; background-repeat:no-repeat; font-size:11px; color:#FFFFFF;"></div>
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