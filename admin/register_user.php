<?php
include_once("inc/dblogin.inc.php");




?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.:Фери:.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 1px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<body>
<div id="MAIN" style="margin:0px;">

  <div id="LEFT" style="float:left; width:160px;">
    <div style="float:left;  background-color:#F5F5F5; "><img src="images/logo.gif" width="159" height="83"></div>
	
    <table style="float:left" width="159"  border="0" cellspacing="0" cellpadding="0"> 
              <tr> 
                <td rowspan="2" valign="top"><img src="images/floorer_08.gif" width="49" height="113" alt="" /></td> 
                <td valign="top"><a href="index.php"><img src="images/r2.gif" width="31" height="20" border="0" alt="" /></a></td> 
             	<td><img src="images/floorer_10.gif" width="79" height="20" alt="" /></td> 
              </tr> 
              <tr> 
                <td><img src="images/floorer_11.gif" width="31" height="93" alt="" /></td> 
               <td><img src="images/floorer_12.jpg" width="79" height="93" alt="" /></td> 
              </tr> 
    </table>


    <!-- ============== RSS INCLUDE ================= -->
        
     <div id="SCROLL_NEWS_CONTAINER" style="float:left; width:160px;">
      <div id="SCROLL_NEWS" style=" margin:0px 0px 0px 5px; overflow:inherit;">
       <table width="160" border="0">
  <tr>
    <td rowspan="4" width="3" bgcolor="#0D959F"></td>
    <td colspan="2"><img src="images/up.jpg"></td>
    </tr>
  <tr>
    <td>
    <div  style="width:135px;" align="left" class="news_scroll">
    
    <?php include("inc/rss_include.php")?>
	
    </div>
    </td>    
  </tr>
  <tr>
    <td colspan="2"><img src="images/down.gif"></td>
    </tr>
</table>
      </div>
    </div>
    
   <!-- ============== END RSS INCLUDE ================= -->
    
   
   
   
    <!-- ============== EXTRA RESULT INCLUDE ================= -->
    <?php
    
    if (($_POST['marka']!="") or ($_REQUEST['carID']!="")) 
	{
	?>
	
    
      
    <div id="SCROLL_NEWS_CONTAINER" style="float:left; width:160px; overflow:hidden;">
      <div id="SCROLL_NEWS" style=" margin:0px 0px 0px 5px; ">
       <table width="160" border="0">
  <tr>
    <td rowspan="4" width="3" bgcolor="#0D959F"></td>
    <td colspan="2"><img src="images/up.jpg"></td>
    </tr>
  <tr>
    <td><div  style="width:135px;" align="left" class="news_scroll">
    
    <marquee direction="up" onMouseOver="this.stop();" onMouseOut="this.start();"  SCROLLDELAY=100 SCROLLAMOUNT=2>   

    <?php
    
    if (($_POST['marka']!="") && ($_POST['marka']!="-1")) 
	{
			
	 //------------------------- EXTRA RESULTS -------------------------------
					
	 	$sql="SELECT DISTINCT(c.id) as 'id', mk.name as 'marka', md.name as 'model', c.price as 'price', l.name as 'location', cr.name as 'currency', at.name as 'avto_type' , cl.name as 'color', f.name as 'fuel', c.updated_on as 'updated_on', c.year_made as 'year_made', c.description as 'description', c.probeg as 'probeg', c.has_pic as 'has_pic'  FROM cars c,marka mk, model md, currency cr, avto_type at, color cl, fuel f, locations l, cars_details cd  WHERE c.marka=mk.id AND c.model=md.id AND c.avto_type=at.id AND c.color=cl.id AND c.fuel = f.id AND c.currency = cr.id AND c.location_id = l.id AND c.marka='".$_POST['marka']."' ORDER BY marka";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultExtra=$conn->result;
		$numExtra=$conn->numberrows;
		
		for ($i=0;$i<$numExtra;$i++)
	    {
	    ?>
		<div style="border:double; border-color:#666666;height:60px; width:60px;" ><a href="search.php?carID=<?=$resultExtra[$i]['id']?>"><img width="60" height="60" src="../pics/cars/<?php if($resultExtra[$i]['has_pic']=='1') print $resultExtra[$i]['id']."_0_thumb.jpg"; else print "no_photo_thumb.png";?>" /></a></div>		
	    <div style="margin-top:0px;margin-bottom:20px;"><a href="search.php?carID=<?=$resultExtra[$i]['id']?>"><?php print $resultExtra[$i]['marka']."|".$resultExtra[$i]['model']."<br /> Цена:".$resultExtra[$i]['price']." ".$resultExtra[$i]['currency'];?></a></div>
			
		<?php 
	    } 
	 
	//------------------------- END EXTRA RESULTS ---------------------------	
	 			
	 			
	}
	else 
	{
			
	 //------------------------- ELSE EXTRA RESULTS -------------------------------
					
	 	$sql="SELECT DISTINCT(c.id) as 'id', mk.name as 'marka', md.name as 'model', c.price as 'price', l.name as 'location', cr.name as 'currency', at.name as 'avto_type' , cl.name as 'color', f.name as 'fuel', c.updated_on as 'updated_on', c.year_made as 'year_made', c.description as 'description', c.probeg as 'probeg', c.has_pic as 'has_pic'  FROM cars c,marka mk, model md, currency cr, avto_type at, color cl, fuel f, locations l, cars_details cd  WHERE c.marka=mk.id AND c.model=md.id AND c.avto_type=at.id AND c.color=cl.id AND c.fuel = f.id AND c.currency = cr.id AND c.location_id = l.id AND c.marka=(SELECT marka FROM cars WHERE id ='".$_GET['carID']."') ORDER BY marka";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultExtra=$conn->result;
		$numExtra=$conn->numberrows;
		
		for ($i=0;$i<$numExtra;$i++)
	    {
	    ?>
		<div style="border:double; border-color:#666666;height:60px; width:60px;" ><a href="search.php?carID=<?=$resultExtra[$i]['id']?>"><img width="60" height="60" src="../pics/cars/<?php if($resultExtra[$i]['has_pic']=='1') print $resultExtra[$i]['id']."_0_thumb.jpg"; else print "no_photo_thumb.png";?>" /></a></div>		
	    <div style="margin-top:0px;margin-bottom:20px;"><a href="search.php?carID=<?=$resultExtra[$i]['id']?>"><?php print $resultExtra[$i]['marka']."|".$resultExtra[$i]['model']."<br /> Цена:".$resultExtra[$i]['price']." ".$resultExtra[$i]['currency'];?></a></div>
			
		<?php 
	    } 
	 
	//------------------------- END ELSE EXTRA RESULTS ---------------------------	
	 			
	 			
	}
	  
   ?>
   
    </marquee>
	
    </div>
    </td>    
  </tr>
  <tr>
    <td colspan="2"><img src="images/down.gif"></td>
    </tr>
</table>
      </div>
    </div>

<?php } ?>
    <!-- ============== END EXTRA RESULT INCLUDE ================= -->
    

    
    	<div style="float:left;width:160px; margin-top:0px;"><img src="images/but1.gif" width="159" height="42"></div>
  </div>
  <div id="CENTER" style="float:left; width:167px;">
    <div style="float:left; width:167px; height:25px;"><img src="images/h2.gif" width="167" height="25"></div>
	<div align="center" style="float:left; width:157px; padding:5px; background-color:#FFB12B; color: #FFFFFF; font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">
	
	 
		  <?php include("inc/user_info.inc.php")?>
		  
	
	</div>
	<div style="float:left; width:167px; height:52px; background-color:#003300;"><img src="images/s4.gif"></div>
<div align="left" style="float:left; width:167px; background-color:#F1F1F1; color: #467B99; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold;">

		<?php include("inc/menu.inc.php")?>

	</div>
	<div style="float:left; width:167px;"><img src="images/h3.gif" width="167" height="65"></div>
	<div id="BANER-LEFT" align="center" style="float:left; width:167px; padding-bottom:10px;padding-top:0px; background-color:#E7E7E7;">

	<?php if((isset($_POST['search_btn'])) or (isset($_POST['insert_btn'])) or (isset($_POST['edit_btn'])))
		{
	 		include_once("inc/target_links.inc.php"); 
		} 
	?>
	
	<div id="Baner_1" style=" width:120px; height:300px; border:double; border-color:#666666;">
       <?php		
	 		include_once("inc/baner-left.inc.php"); 		
		?>
     </div>
	
	</div>
	<div style="float:left; width:167px;"><img src="images/h4.gif" width="167" height="41"></div>
	<div style="float:left; width:167px; height:30px; background-image:url(images/bg10.gif)">
	  <input align="left" style="width:100px; float:left; margin-left:10px;" type="text" name="search"><input type="image" src="images/but2.gif" alt="" width="44" height="32" border="0" usemap="#Map" /></div>
	<div style="float:left; width:167px;"><img src="images/s5.gif"></div>
  </div>
  
  
   <div id="RIGHT" style="width:auto;">
    <div id="FLASH" align="center" style=" width:auto; height:175px; padding-top:22px; background-image:url(images/header_bgr.gif); background-position:top; background-repeat:repeat-x;">
          
    <div id="BANER_Goren" align="center" style="width:600px; height:90px; border:double; border-color:#999999;">
    
    <?php
		
	 		include_once("inc/baner-goren.inc.php"); 
		
	?>
   	  </div>
    
    </div>
    
    <div id="center_center" style="float:left; width:600px;">
   

<div id="CENTRALNO_DOLNO" style="float:left; margin-top:0px; margin-bottom:20px; width:600px; ">
	<div style="float:left; margin-left:0px; width:560px; height:56px;">
	  <div id="TEMA_2" style="float:left; margin-left:0px; height:56px; width:560px; padding-left:30px; padding-bottom:0px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:25px;margin-bottom:0px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Вход </div>
	     </div>
	  </div>
	  <!-- Text na TEMA-2 -->
	  <div style="float:left; margin-left:30px; width:580px; ">
	    <div style="float:left; margin-left:0px; width:580px;">
		  <div style="float:left; margin:0px; padding:0px 20px 0px 20px; width:520px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" align="justify">
		  		  
		  		  
<div align="center" >

	<div style="width:300px; border:double; border-color:#999999;">
	
	
	<?php
	 
	if ((isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['username'])) && (isset($_POST['pass'])) && (isset($_POST['city'])) && (isset($_POST['pass'])) && (isset($_POST['email'])) && (isset($_POST['phone'])) && (isset($_POST['address'])))
	{
		 	    
		print  $sql="INSERT INTO users SET username='".$_POST['username']."',
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

</div>
		  
		  
		  </div>			  
  		 </div>
  	  </div>
	  <!--Krai na Text na TEMA-2 -->
	 
   <div style="float:left; margin-left:30px;"><img src="images/s6.gif" height="16"></div>
	</div>	
	<!-- KRAI na TEMA_2 -->	
	
	</div>
				
  
	        
	<div id="RIGHT_NEW" style="float:left; width:167px;">
		<div align="center" style="float:left; width:157px; padding:5px; background-color:#FFB12B; color: #FFFFFF; font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">
		
			  <?php include("inc/user_info.inc.php")?>
			  
		</div>
		<div style="float:left; width:167px; height:52px; background-color:#003300;"><img src="images/s4.gif"></div>
		<div align="left" style="float:left; width:167px; background-color:#F1F1F1; color: #467B99; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold;">
	
			<?php include("inc/menu.inc.php")?>
	
		</div>
		<div style="float:left; width:167px;"><img src="images/h3.gif" width="167" height="65"></div>
		
		<div id="BANER-LEFT" align="center" style="float:left; width:167px; padding-bottom:10px;padding-top:0px; background-color:#E7E7E7;">
		dsdfgdfg
		dfgdfg
		dfg
				
		</div>
		<div style="float:left; width:167px;"><img src="images/h4.gif" width="167" height="41"></div>
		<div style="float:left; width:167px; height:30px; background-image:url(images/bg10.gif)">
		  <input align="left" style="width:100px; float:left; margin-left:10px;" type="text" name="search"><input type="image" src="images/but2.gif" alt="" width="44" height="32" border="0" usemap="#Map" /></div>
		<div style="float:left; width:167px;"><img src="images/s5.gif"></div><div style="float:left; width:167px;"><img src="images/h4.gif" width="167" height="41"></div>
		<div style="float:left; width:167px; height:30px; background-image:url(images/bg10.gif)">
		  <input align="left" style="width:100px; float:left; margin-left:10px;" type="text" name="search"><input type="image" src="images/but2.gif" alt="" width="44" height="32" border="0" usemap="#Map" /></div>
		<div style="float:left; width:167px;"><img src="images/s5.gif"></div><div style="float:left; width:167px;"><img src="images/h4.gif" width="167" height="41"></div>
		<div style="float:left; width:167px; height:30px; background-image:url(images/bg10.gif)">
		  <input align="left" style="width:100px; float:left; margin-left:10px;" type="text" name="search"><input type="image" src="images/but2.gif" alt="" width="44" height="32" border="0" usemap="#Map" /></div>
		<div style="float:left; width:167px;"><img src="images/s5.gif"></div>
	</div>

</div>
</div>
   


<div id="FOOTER" style=" float:left;width:auto; margin-top:20px;">
<div style=" float:left; margin-left:0px;"><img src="images/floorer_48.gif" width="159" height="48" alt="" /> </div>  
<div style=" float:left; margin-left:0px;"><img style="margin:0px;" src="images/s7.gif" width="167" height="48"></div>  
<div style=" float:left; margin-left:0px;"><img style="margin:0px;" src="images/bg16.gif" width="600" height="48" alt="" /></div>  
<div style=" float:left; margin-left:0px;"><img  src="images/s7.gif" width="167" height="48"></div>  
<div style=" float:left; margin-left:0px;"><img src="images/floorer_48.gif" width="159" height="48" alt="" /> </div>  
</div>

</body>
</html>


<?php
// -------------------- funkcii -----------------------------------------



?>