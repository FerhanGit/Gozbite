<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left;height:56px; width:500px; padding-left:30px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:25px;margin-bottom:0px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Регистрация</div>
      </div>
	<div id="whiteDIV" style="margin-left:20px;background-color:#F5F5F5;float:left;width:470px; " >	 
<!-- Text na ARTICLE -->
        <div id="tabs" style="float:left; height:auto;  padding:20px 20px 20px 20px; width:430px; background-color:#F5F5F5;" >
    
	
	<?php
	 
	if ((isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['username'])) && (isset($_POST['pass'])) && (isset($_POST['city'])) && (isset($_POST['pass'])) && (isset($_POST['email'])) && (isset($_POST['phone'])) && (isset($_POST['address'])))
	{
		 	    
		$sql="INSERT INTO users SET username='".$_POST['username']."',
							 		first_name='".$_POST['fname']."',
							 		last_name='".$_POST['lname']."',
							 		password=md5('".$_POST['pass']."'),
							 		email='".$_POST['email']."',
							 		phone='".$_POST['phone']."',
							 		city='".$_POST['city']."',
							 		address='".$_POST['address']."',
							 		date_register=NOW()
									 							
	 								";
		 $conn->setsql($sql);
		 $last_ID=$conn->insertDB();
		 
		 	?>
	
				<script type="text/javascript">
			       window.location.href='login.php';
				</script> 
			
			<?php
		
	}
	else 
	{
	?>
	
		<form  id='registrationform' name='registrationform' method='post' action=''>
		  <table width='300' border='0'>
		    <tr>
		      <td ><label>Име </label></td>
		      <td ><input type='text' name='fname' /></td>
		    </tr>
		    <tr>
		      <td>Фамилия</td>
		      <td><input type='text' name='lname' /></td>
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
		      <td>E-mail</td>
		      <td><input type='text' name='email' /></td>
		    </tr>
		    <tr>
		      <td>Телефон</td>
		      <td><input type='text' name='phone' /></td>
		    </tr>
		    <tr>
		      <td>Град</td>
		      <td><input type='text' name='city' /></td>
		    </tr>
		    <tr>
		      <td>Адрес</td>
		      <td><input type='text' name='address' /></td>
		    </tr>
		    <tr>
		      <td><input type='reset' name='reset' value='Изчисти' /></td>
		      <td><input type='submit' name='register' value='Регистрирай' /></td>
		    </tr>
		  </table>
		</form>
		
		<?php } // END else ?>
	  
		
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
        