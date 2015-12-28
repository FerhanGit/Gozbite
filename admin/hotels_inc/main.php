<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left;height:56px; width:500px; padding-left:30px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:25px;margin-bottom:0px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Начало АДМИН</div>
      </div>
	<div id="whiteDIV" style="background-color:#F5F5F5;float:left;margin-left:20px;" >	 
<!-- Text na ARTICLE -->
        <div id="tabs" style="float:left; height:auto; padding:0px 20px 0px 20px; width:440px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" >
                 
          	<ul id="maintab" class="shadetabs">
					<li class="selected"><a href="doctors_inc/random_doctor.php" rel="ajaxcontentarea">ТОП</a></li>
					<li ><a href="doctors_inc/edit_form.php" rel="ajaxcontentarea">Добави</a></li>
					<?php  if ((isset($_REQUEST['edit'])) && ($_REQUEST['edit']!="")) print	'<li class="selected"><a href="doctors_inc/edit_form.php" rel="ajaxcontentarea">Редактирай</a></li>'; ?>
	                <li ><a href="doctors_inc/search_doctor.php" rel="ajaxcontentarea">Търси</a></li>
	                <li ><a href="doctors_inc/comment_edit.php" rel="ajaxcontentarea">Коментари</a></li>
	                <?php  if ((!empty($_REQUEST['doctorID'])) && (!isset($_REQUEST['search_btn']))){ print '<li class="selected"><a href="doctors_inc/doctorBig.php" rel="ajaxcontentarea">Лекар</a></li>'; }?>
	        </ul>       
	         
           <div id="ajaxcontentarea" class="contentstyle" ></div>    
            
    <script type="text/javascript">
            //Start Ajax tabs script for UL with id="maintab" Separate multiple ids each with a comma.
            startajaxtabs("maintab")
    </script>		 
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na ARTICLE -->
      </div>
      <div id="Main_Top_Bottom" style="background-color:#F5F5F5;float:left;margin-left:20px;width:480px;" >	 
      </div>
</div>	<!-- KRAI na Main_Top -->

    
<div id="Main_Bottom" style="float:left; margin-top:40px; width:500px;">	  
<?if($numDoctors){?>	     <div id="ARTICLE_LIST" style="float:left; margin-left:0px;margin-top:5px; height:31px; padding-left:30px; padding-bottom:0px; background-image:url(images/h5.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:12px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Лекари</div>
	     </div>
	 
<?}?>	       
	<?php
if ((isset($_REQUEST['search_btn'])) or (isset($page))  or $pageName == 'edit_doctors')
{
	if ($numDoctors==0) 
	{
	?>
		<div style="float:left; margin-top:10px; margin-bottom:10px; width:400px;">
		    <div style="float:left; margin-left:20px; width:350px; height:20px;" align="left"><strong style="float:left;color:#FF8400">Няма Лекари</strong></div>		    
	  </div>
	<?php  } 
	// ---- Paging START ------
else {
echo "<div class=\"paging\" style=\"background-color:#B9F4A8;width:300px;margin: 10px 50px 10px 140px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&doctor_category=".$_REQUEST['doctor_category']."&first_name=".$_REQUEST['first_name']."&address=".$_REQUEST['address']."&related_hospital=".$_REQUEST['related_hospital']."&cityName=".$_REQUEST['sityName']."&phone=".$_REQUEST['phone']."&email=".$_REQUEST['email']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&doctorID=".$_REQUEST['doctorID'], "2");
?>

	  
  
	  
<?php if($numChildCats>0) 
{
?>		
	<div  style="background-color:#B9F4A8;" align='center'>
		<br />
		<select style="width:200px;" name="category" id="category" onchange="jumpBlank(this);">
			<option value="">Подкатегория..</option>
<?php			
   for($cc=0;$cc<$numChildCats;$cc++)
   {?>
		<option value="<?=$resultChildCats[$cc]['id']?>"><?=$resultChildCats[$cc]['name']?></option>
<? } ?>						
		</select>                			
	
	</div>
<? } ?>

</div> 
<!-- Paging END -->

	  
	  <!-- ARTICLES LIST -->	  
	<?php
	if($numDoctors)
	  for ($i=0;$i<$numDoctors;$i++)
		{
			if ($resultDoctors[$i]['has_pic']=='1')
			{
				$sql="SELECT * FROM doctor_pics WHERE doctorID='".$resultDoctors[$i]['id']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultPicsMain[$i]=$conn->result;
				$numPicsMain[$i]=$conn->numberrows;
			}
	?>		
	 
	
	<div id="OFFER<?=$i?>" class="offer" onMouseover="this.style.backgroundColor='#B9F4A8';" onMouseout="this.style.backgroundColor='#FFFFFF';"
         onMouseout="this.style.backgroundColor='#FFFFFF';" style="float:left;background-color:#FFFFFF; width:500px;">
                <div  style="float:left; margin-left:20px; width:460px; " align="left"><strong style="color:#FF8400"><?=$resultDoctors[$i]['first_name'].' '.$resultDoctors[$i]['last_name'] ?></strong></div>
                
                 <div style="float:left; margin-left:5px; padding:0px; width:460px; font-size: 14px; color: #333333;" align="justify">
                  <table><tr>
					<td width="15px" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
						<td style="padding:10px;">
						 <div style="float:left;background-image:url(images/fon_header_green.png); margin-left:0px;margin-bottom:5px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
							<div style=" float:left; margin-left:6px; width:150px;color:#FFFFFF;font-weight:bold;" ><?=$resultDoctors[$i]['locType']." ".$resultDoctors[$i]['location'] ?></div>
					<?php if(($resultDoctors[$i]['id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'doctor') or $_SESSION['userID']==1) {?>	
							<div style="float:right; margin-right:5px;" ><a href="edit_doctors.php?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&doctor_category=<?=$_REQUEST['doctor_category']?$_REQUEST['doctor_category']:$_REQUEST['category']?>&first_name=<?=$_REQUEST['first_name']?>&address=<?=$_REQUEST['address']?>&related_hospital=<?=$_REQUEST['related_hospital']?>&cityName=<?=$_REQUEST['cityName']?>&phone=<?=$_REQUEST['phone']?>&email=<?=$_REQUEST['email']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&edit=<?=$resultDoctors[$i]['id']?>"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>
							<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm('Сигурни ли сте?')){return false;}" href="edit_doctors.php?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&doctor_category=<?=$_REQUEST['doctor_category']?$_REQUEST['doctor_category']:$_REQUEST['category']?>&first_name=<?=$_REQUEST['first_name']?>&address=<?=$_REQUEST['address']?>&related_hospital=<?=$_REQUEST['related_hospital']?>&cityName=<?=$_REQUEST['cityName']?>&phone=<?=$_REQUEST['phone']?>&email=<?=$_REQUEST['email']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&delete=<?=$resultDoctors[$i]['id']?>"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>
					<?php }else { ?>
							<div style="float:right; margin-right:5px;" ><a href="edit_doctors.php?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&doctor_category=<?=$_REQUEST['doctor_category']?$_REQUEST['doctor_category']:$_REQUEST['category']?>&first_name=<?=$_REQUEST['first_name']?>&address=<?=$_REQUEST['address']?>&related_hospital=<?=$_REQUEST['related_hospital']?>&cityName=<?=$_REQUEST['cityName']?>&phone=<?=$_REQUEST['phone']?>&email=<?=$_REQUEST['email']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&doctorID=<?=$resultDoctors[$i]['id']?>"><img style="margin-left:5px;" src="images/big.png" width="14" height="14"></a></div>
							<div style="float:right; margin-right:2px;" ><?php printf("<a href = \"javascript://\" onclick = \"window.open('doctors_inc/sendtofriend.php?doctorID=%d', 'sndWin', 'top=0, left=0, width=440px, height=500px, resizable=yes, toolbars=no, scrollbars=yes');\" class = \"smallOrange\">", $resultDoctors[$i]['id']);?><img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a></div>
					<?php } ?>						    
							</div>
							<div  style="float:left;margin-top:5px; width:510px; overflow:hidden; ">
			       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; height:80px; width:80px; overflow:hidden; " ><a href="?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&doctor_category=<?=$_REQUEST['doctor_category']?$_REQUEST['doctor_category']:$_REQUEST['category']?>&first_name=<?=$_REQUEST['first_name']?>&address=<?=$_REQUEST['address']?>&related_hospital=<?=$_REQUEST['related_hospital']?>&cityName=<?=$_REQUEST['cityName']?>&phone=<?=$_REQUEST['phone']?>&email=<?=$_REQUEST['email']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&doctorID=<?=$resultDoctors[$i]['id']?>"><img width="80" height="80" src="../pics/doctors/<?php if($numPicsMain[$i] > 0) print $resultPicsMain[$i][0]['url_thumb']; else print "no_photo_thumb.png";?>"/></a></div>
			
			       			<?php 			   
			       			
								print "<b style='color:#009900;'>Населено Място:</b> ".$resultDoctors[$i]['locType']." ".$resultDoctors[$i]['location']."<br />"; 
								if ($numDoctorsCats[$i]>0) 
								{
									print " <b style='color:#009900;'>Специалности:</b> <span  style='color:#FF6600; '>"; 
								
									for($z=0;$z<$numDoctorsCats[$i];$z++)
									{
										print $resultDoctorsCats[$i][$z]['doctor_category_name']."; "; 
									}
									print "</span><br />";
								}
								print "<b style='color:#009900;'>Адрес:</b> ".$resultDoctors[$i]['address']."<br />"; 
								print "<b style='color:#009900;'>Телефон:</b> ".$resultDoctors[$i]['phone']."<br />"; 
								print "<b style='color:#009900;'>Е-мейл:</b> ".$resultDoctors[$i]['email']."<br />"; 
								print "<b style='color:#009900;'>Регистрирано на:</b> ".$resultDoctors[$i]['registered_on']."<br />"; 
								print "<b style='color:#009900;'>Описание:</b> ".stripslashes(str_replace($_REQUEST['info'],"<font color='red'><b><u>".$_REQUEST['info']."</b></u></font>",$resultDoctors[$i]['info']))."<br />"; 
							
							?>
       			
		  			</tr></table>
            	  </div>
            
       </div>    
   
    <?php } ?>

		<!-- KRAI na ARTICLE LIST-->	   
		

<?php	

// ---- Paging START ------

echo "<div class=\"paging\" style=\"float:left;background-color:#B9F4A8;width:340px;margin:10px 30px 20px 30px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&doctor_category=".$_REQUEST['doctor_category']."&first_name=".$_REQUEST['first_name']."&address=".$_REQUEST['address']."&related_hospital=".$_REQUEST['related_hospital']."&cityName=".$_REQUEST['cityName']."&phone=".$_REQUEST['phone']."&email=".$_REQUEST['email']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&doctorID=".$_REQUEST['doctorID'], "2");

?>
</div>
<?php }
} ?>
	</div>	
	<!-- KRAI na Main_Bottom -->
<script type="text/javascript">

function effectF()
{
	//new Effect.Shake('ajaxcontentarea');
}

Event.observe(window, 'load', function() { 	   
	
Rounded("div.paging","all","#FFF","#B9F4A8");
Rounded("div.newsDIVContainer","all","#FFF","#B9F4A8");
Rounded("div.newsButton","tr bl","#FFF","#E2E2E2","big");
Rounded("div.last_posts","tr bl","#F5F5F5","#E7E7E7","big");

<?php
 	if ($_REQUEST['doctorID']>0) print 'expandtab("maintab", 2);$("maintab").scrollTo();';
	elseif (isset($_REQUEST['search_btn'])) print 'expandtab("maintab", 1);';
	elseif ($pageName=='edit_doctors') print 'expandtab("maintab", 2);';
	else  print 'expandtab("maintab", 0);'; 
?>
 window.setInterval("effectF()", 20000);
}
);

	
</script>
        