<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left; margin-top:20px; margin-bottom:20px; height:12px; width:23px; padding-left:0px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	   </div> <div style=" float:left; margin-top:18px;  margin-bottom:20px; margin-left:0px; padding-left:5px; font-size: 11px; font-family:  Arial, Helvetica, sans-serif; background-image:url(images/grey_dot.png); background-position:bottom; background-repeat:repeat-x;">Начало</div>
     
      
      <div id="whiteDIV" style="background-color:#F5F5F5;float:left;margin-left:10px;width:490px;" >	</div> 
    <!-- Text na ARTICLE -->
        <div id="tabs" style="float:left; height:auto; margin:0px 0px 0px 10px; padding-left:10px; width:480px; background-color:#F5F5F5; font-size: 12px; color: #467B99;" >
                          
            
			 
			<?php 
			include("index_inc/Most_populars.php");
			?>	 
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na tabs -->
     
      <div id="Main_Top_Bottom" style="background-color:#F5F5F5;float:left;margin-left:10px; padding-top:10px;width:490px;" >	 </div>
     
</div>	<!-- KRAI na Main_Top -->

    
   
    
<div id="Main_Bottom" style="float:left; margin-top:40px; width:500px;">	  
<?if($numDoctorsVIP>0 && $_REQUEST['search']<>1){?>     <div id="ARTICLE" style="float:left; margin-top:20px; margin-bottom:20px; height:12px; width:23px; padding-left:0px; background-image:url(images/h5.gif); background-position:left; background-repeat:no-repeat;"></div>
														<div style=" float:left; margin-top:21px;  margin-bottom:20px; margin-left:0px; padding-left:5px; font-size: 10px; font-family:  Arial, Helvetica, sans-serif; background-image:url(images/grey_dot.png); background-position:bottom; background-repeat:repeat-x;">VIP Лекари</div>
     				
<?php
	if($numDoctorsVIP)
	  for ($i=0;$i<$numDoctorsVIP;$i++)
		{
			if ($resultDoctorsVIP[$i]['has_pic']=='1')
			{
				$sql="SELECT * FROM doctor_pics WHERE doctorID='".$resultDoctorsVIP[$i]['id']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultPicsMain2[$i] = $conn->result;
				$numPicsMain2[$i] = $conn->numberrows;
			}
			
				$sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$resultDoctorsVIP[$i]['id']."' ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numDoctorsCats[$i]  	= $conn->numberrows;
				$resultDoctorsCats[$i]  = $conn->result;
?>		
	 
	
	<div id="OFFER<?=$i?>" class="offer" onMouseover="this.style.backgroundColor='#B9F4A8';" onMouseout="this.style.backgroundColor='#FFFFFF';"
         onMouseout="this.style.backgroundColor='#FFFFFF';" style="float:left;background-color:#FFFFFF; width:500px;">
                <div  style="float:left; margin-left:20px; width:460px; " align="left"><strong style="color:#FF8400"><?=$resultDoctorsVIP[$i]['first_name'].' '.$resultDoctorsVIP[$i]['last_name'] ?></strong></div>
                 <div style="float:left; margin-left:5px; padding:0px; width:460px; " align="justify">
                  <table><tr>
					<td width="15px" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
						<td style="padding:10px;">
						 <div style="float:left;background-image:url(images/fon_header_green.png); margin-left:0px;margin-bottom:5px; height:20px; width:280px; background-repeat:no-repeat; font-size:11px; color:#000000;">
							<div style=" float:left; margin-left:6px; width:150px;color:#FFFFFF;font-weight:bold;" ><?=$resultDoctorsVIP[$i]['locType']." ".$resultDoctorsVIP[$i]['location'] ?></div>
						 	<div style=" float:right; margin-right:5px; font-weight:bold; color:#FFFFFF;" ><?=$resultDoctorsCats[$i][rand( 0 , ($numDoctorsCats[$i]-1) )]['doctor_category_name'] ?></div>
						 </div>
							<div  style="float:left;margin-top:5px; width:460px; overflow:hidden; ">
			       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; height:80px; width:80px; overflow:hidden; " ><a href="doctors.php?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&doctor_category=<?=$_REQUEST['doctor_category']?$_REQUEST['doctor_category']:$_REQUEST['category']?>&first_name=<?=$_REQUEST['first_name']?>&address=<?=$_REQUEST['address']?>&related_hospital=<?=$_REQUEST['related_hospital']?>&cityName=<?=$_REQUEST['cityName']?>&phone=<?=$_REQUEST['phone']?>&email=<?=$_REQUEST['email']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&doctorID=<?=$resultDoctorsVIP[$i]['id']?>"><img width="80" height="80" src="<?php if(is_file('pics/doctors/'.$resultPicsMain2[$i][0]['url_thumb'])) print 'pics/doctors/'.$resultPicsMain2[$i][0]['url_thumb']; else print "pics/doctors/no_photo_thumb.png";?>"/></a></div>
			
			       			<?php 			   
			       			
								if ($numDoctorsCats[$i]>0) 
								{
									print " <b style='color:#666666;'>Специалности:</b> <span>"; 
								
									for($z=0;$z<$numDoctorsCats[$i];$z++)
									{
										print $resultDoctorsCats[$i][$z]['doctor_category_name']."; "; 
									}
									print "</span><br />";
								}
								print "<b style='color:#666666;'>Адрес:</b> ".$resultDoctorsVIP[$i]['address']."<br />"; 
								print "<b style='color:#666666;'>Телефон:</b> ".$resultDoctorsVIP[$i]['phone']."<br />"; 
								print "<b style='color:#666666;'>Е-мейл:</b> ".$resultDoctorsVIP[$i]['email']."<br />"; 
								print "<b style='color:#666666;'>Регистрирано на:</b> ".convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($resultDoctorsVIP[$i]['registered_on']))) ." ч.<br />"; 
								print "<b style='color:#666666;'>Описание:</b> ".stripslashes(str_replace($_REQUEST['info'],"<font color='red'><b><u>".$_REQUEST['info']."</b></u></font>",$resultDoctorsVIP[$i]['info']))."<br />"; 
							
							?>
       						</td></tr></table>
            	  </div>
            
       </div>    
   
    <?php } ?>

		<!-- KRAI na ARTICLE LIST-->	   
		

<?php 
} ?>
	</div>	
	<!-- KRAI na Main_Bottom -->
	

	
	
    
<div id="Main_Bottom" style="float:left; margin-top:40px; width:500px;">	  
<?if($numHospitalsVIP>0 && $_REQUEST['search']<>1){?>	    <div id="ARTICLE" style="float:left; margin-top:20px; margin-bottom:20px; height:12px; width:23px; padding-left:0px; background-image:url(images/h5.gif); background-position:left; background-repeat:no-repeat;"></div>
															<div style=" float:left; margin-top:21px;  margin-bottom:20px; margin-left:0px; padding-left:5px; font-size: 10px; font-family:  Arial, Helvetica, sans-serif; background-image:url(images/grey_dot.png); background-position:bottom; background-repeat:repeat-x;">VIP Организации</div>
	 
 <!-- ARTICLES LIST -->	  
	<?php
	if($numHospitalsVIP)
	  for ($i=0;$i<$numHospitalsVIP;$i++)
		{
			if ($resultHospitalsVIP[$i]['has_pic']=='1')
			{
				$sql="SELECT * FROM hospital_pics WHERE hospitalID='".$resultHospitalsVIP[$i]['id']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultPicsMain[$i]=$conn->result;
				$numPicsMain[$i]=$conn->numberrows;
			}
			
				$sql="SELECT hc.id as 'hospital_category_id', hc.name as 'hospital_category_name' FROM hospitals h, hospital_category hc, hospitals_category_list hcl WHERE hcl.hospital_id = h.id AND hcl.category_id = hc.id AND h.id = '".$resultHospitalsVIP[$i]['id']."' ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numHospitalCats[$i]  	= $conn->numberrows;
				$resultHospitalCats[$i] = $conn->result;
			
	?>		
	 
	
	<div id="OFFER<?=$i?>" class="offer" onMouseover="this.style.backgroundColor='#B9F4A8';" onmouseout="this.style.backgroundColor='#FFFFFF';"
         onMouseout="this.style.backgroundColor='#FFFFFF';" style="float:left;background-color:#FFFFFF; width:500px;">
                <div  style="float:left; margin-left:20px;margin-top:20px; width:460px; " align="left"><strong style="color:#FF8400"><?=$resultHospitalsVIP[$i]['firm_name'] ?></strong></div>
                
                 <div style="float:left; margin-left:5px; padding:0px; width:460px;" align="justify">
                  <table style="width:460px;"><tr>
					<td width="15px" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp; </td>
						<td style="padding:10px;">
						 <div style="float:left;background-image:url(images/fon_header_green.png); margin-left:0px;margin-bottom:5px; height:20px; width:280px; background-repeat:no-repeat; font-size:11px; color:#000000;">
							<div style=" float:left; margin-left:6px; width:140px;font-weight:bold; color:#FFFFFF;" ><?=$resultHospitalsVIP[$i]['locType']." ".$resultHospitalsVIP[$i]['location'] ?></div>
						 	<div style=" float:right; margin-right:5px; font-weight:bold; color:#FFFFFF;" ><?=$resultHospitalCats[$i][rand( 0 , ($numHospitalCats[$i]-1) )]['hospital_category_name'] ?></div>
						 </div>
							<div  style="float:left;margin-top:5px; width:460px; overflow:hidden; ">
			       			<div style="float:left; margin-left:0px;margin-right:10px; width:150px; overflow:hidden; " ><a href="hospitals.php?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&hospital_category=<?=$_REQUEST['hospital_category']?$_REQUEST['hospital_category']:$_REQUEST['category']?>&firm_name=<?=$_REQUEST['firm_name']?>&address=<?=$_REQUEST['address']?>&manager=<?=$_REQUEST['manager']?>&cityName=<?=$_REQUEST['cityName']?>&phone=<?=$_REQUEST['phone']?>&email=<?=$_REQUEST['email']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&firmID=<?=$resultHospitalsVIP[$i]['id']?>"><img width="150"  src="<?=(is_file("pics/firms/".$resultHospitalsVIP[$i]['id']."_logo.jpg"))?"pics/firms/".$resultHospitalsVIP[$i]['id']."_logo.jpg":"pics/firms/no_logo.png"?>"/></a></div>
			
			       			<?php 			   
			       		 	// ----------- DETAILS LIST -------------------------------

			               		if ($numHospitalCats[$i]>0) 
								{
									print " <b style='color: #666666;'>Категория:</b> <span>"; 
								
									for($z=0;$z<$numHospitalCats[$i];$z++)
									{
										print $resultHospitalCats[$i][$z]['hospital_category_name']."; "; 
									}
									print "</span><br />";
								}
							// ---------------------------------------------------------
								
								print "<b style='color: #666666;'>Адрес:</b> ".$resultHospitalsVIP[$i]['address']."<br />"; 
								print "<b style='color: #666666;'>Телефон:</b> ".$resultHospitalsVIP[$i]['phone']."<br />"; 
								print "<b style='color: #666666;'>Е-мейл:</b> ".$resultHospitalsVIP[$i]['email']."<br />"; 
								print "<b style='color: #666666;'>Управител:</b> ".$resultHospitalsVIP[$i]['manager']."<br />"; 
								print "<b style='color: #666666;'>Регистрирано на:</b> ".convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($resultHospitalsVIP[$i]['registered_on']))) ."<br />"; 
								                                    	
			              
			            
							if(isset($_REQUEST['search_btn']))	print "<b style='color: #666666;'>Описание:</b> ".stripslashes(str_replace($_REQUEST['description'],"<font color='red'><b><u>".$_REQUEST['description']."</b></u></font>",$resultHospitalsVIP[$i]['description']))."<br />"; 
							else	print "<b style='color: #666666;'>Описание:</b> ".$resultHospitalsVIP[$i]['description']."<br />"; 
	
							?>
       			
		  			</td></tr></table>
            	  </div>
            
       </div>    
    
	<?php } ?>

		<!-- KRAI na ARTICLE LIST-->	   
		
<?php 
} ?>
	</div>	
	
	
<script type="text/javascript">

function effectF()
{
	//new Effect.Shake('ajaxcontentarea');
}

Event.observe(window, 'load', function() { 	   
Rounded("div.ofr_top","tl","#FFF","lightblue");
Rounded("div.ofr_down","bl br","#FFF","lightblue");
Rounded("div.paging","all","#FFF","lightblue");
//Rounded("div.newsDIVContainer","all","#FFF","lightblue");
//Rounded("div.newsButton","tr bl","#FFF","#E2E2E2","big");
Rounded("div.last_posts","tr bl","#F5F5F5","#E7E7E7","big");

<?php
 	if ($_REQUEST['newsID']>0) print 'expandtab("maintab", 2);$("maintab").scrollTo();';
	elseif (isset($_REQUEST['search_btn'])) print 'expandtab("maintab", 1);';
	else  print 'expandtab("maintab", 0);'; 
?>
 window.setInterval("effectF()", 20000);
}
);

	
</script>
        