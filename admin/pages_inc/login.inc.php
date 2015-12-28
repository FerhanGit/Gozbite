<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left;height:56px; width:500px; padding-left:30px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:25px;margin-bottom:0px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Вход</div>
      </div>
	<div id="whiteDIV" style="margin-left:20px;background-color:#F5F5F5;float:left;width:470px; " >	 
<!-- Text na ARTICLE -->
        <div id="tabs" style="float:left; height:auto;  padding:20px 20px 20px 20px; width:430px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" >
                          
	<?php
	 
	if ((isset($_REQUEST['username'])) && (isset($_REQUEST['pass'])) && (isset($_REQUEST['log_in'])))
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
			 $_SESSION['userID']=$resultUser['userID'];
			 $_SESSION['last_login']=$resultUser['last_login'];
			 $_SESSION['cnt_offr']=$resultUser['cnt_offr'];
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
				  <table width='300' border='0' style="float:left; ">
				    <tr>
				      <td><input type="radio" name="what_login" value="user" >ssff</td>
				      <td><input type="radio" name="what_login" value="hospital" >ssff</td>
				    </tr>
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
		  <table width='300' border='0' style="float:left; ">
		     <tr>
			  <td><input type="radio" name="what_login" value="user" >ssff</td>
			  <td><input type="radio" name="what_login" value="hospital" >ssff</td>
			 </tr>
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
	 
	
		
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na ARTICLE -->
     
      <div id="Main_Top_Bottom" style="background-color:#F5F5F5;float:left;margin-left:20px;width:470px;" ></div>
</div>	<!-- KRAI na Main_Top -->

    
<script type="text/javascript">
Event.observe(window, 'load', function() { 	   
Rounded("div.ofr_top","tl","#FFF","lightblue");
Rounded("div.ofr_down","bl br","#FFF","lightblue");
}
);
</script>
        