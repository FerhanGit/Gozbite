<?php
include_once("../inc/dblogin.inc.php");

 $doctorID=substr($_SERVER['HTTP_REFERER'],strpos($_SERVER['HTTP_REFERER'],"doctorID=")+9);

if (isset($doctorID))
{
	
	$sql="SELECT d.id as 'id', d.first_name as 'first_name', d.last_name as 'last_name', d.phone as 'phone', d.addr as 'address', d.email as 'email', d.web as 'web', d.related_hospital as 'related_hospital', l.name as 'location', lt.name as 'locType', d.registered_on as 'registered_on', d.info as 'info', d.has_pic as 'has_pic' FROM doctors d, locations l, location_types lt WHERE  d.location_id = l.id  AND l.loc_type_id = lt.id AND d.id = '".$doctorID."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultDoctorBig=$conn->result;
	
	//------------- Categories ----------------------------------------------------
	
	$sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$doctorID."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numDoctorBigCats  	  = $conn->numberrows;
	$resultDoctorBigCats  = $conn->result;
	
	//------------- Pics ----------------------------------------------------
	
	$sql="SELECT * FROM doctor_pics WHERE doctorID='".$resultDoctorBig['id']."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultPics=$conn->result;
	$numPics=$conn->numberrows;
	
	//------------- COUNT VEWS ----------------------------------------------------
	
	$sql="SELECT doctor_id, SUM(cnt) as 'cnt' FROM log_doctors WHERE doctor_id='".$resultDoctorBig['id']."' GROUP BY doctor_id";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultDoctorCnt=$conn->result;

	
	//------------- Comments ----------------------------------------------------
	 	
	   
	$sql="SELECT doctorID, sender_name , sender_email , comment_body , parentID , created_on  FROM doctor_comment WHERE doctorID='".$doctorID."' ORDER BY created_on DESC";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultDoctorComment=$conn->result;	
    $numDoctorComment=$conn->numberrows;
	  			
	// --------------------------------------------------------------------------
		
	
}

?>
<div id="doctorDiv" style="float:left; margin-top:20px; margin-bottom:10px; width:420px;">
 <a href="javascript:void(0);" onclick="doctorsFsize(2)" title="увеличи размера на текста" style="font-size:16px;">A+|</a> <a href="javascript:void(0);" onclick="doctorsFsize_d()" title="нормален размер" style="font-size:14px;">A|</a> <a href="javascript:void(0);" onclick="doctorsFsize(-2)" title="намали размера на текста" style="font-size:12px;">A-</a>
	<div style="float:right; margin-right:20px; width:400px; " align="right"><span style="color:#009900;">Регистрирано на: <font color="Black"><u><?=$resultDoctorBig['registered_on'] ?> </u></font>ч.</span></div>
	    <div style="float:left; margin-left:5px; width:410px; " align="left"><strong style="color:#FF8400;"><?=$resultDoctorBig['first_name'].' '.$resultDoctorBig['last_name']?></strong></div>
	    <div style="float:left; margin-left:0px; width:420px;">
		 <div style="float:left; margin-left:0px; padding:0px; width:420px; font-size: 14px; color: #333333;" align="justify">
		   <table><tr>
			<td width="15px" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
			<td style="padding:10px;">
			 <div style="background-image:url(images/fon_header_green.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
				<div style="float:left; margin-left:15px;"><div style="float:left; font-weight:bold; color:#FFFFFF; "><?=$resultDoctorBigCats[0]['doctor_category_name'] ?></div></div>
				<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultDoctorBig['locType'].' '.$resultDoctorBig['location']?></div>
			  </div>
			  <div  style="margin-top:5px; width:410px; overflow:hidden; ">
			 <div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:250px; overflow:hidden; " ><div><img id="big_pic" width="250" src="../pics/doctors/<?php if($numPics > 0) print $resultPics[0]['url_big']; else print "no_photo_big.png";?>" /></div></div>
				
			 <?php 
			 
			  if ($resultDoctorBig['has_pic']=='1')
			  {  print "<div style='float:left; margin:0px; width:140px;' >";
				  for ($p=0;$p<$numPics;$p++)
				  { 
				 ?>        			
	       			<div style="float:left; border:double; border-color:#666666; margin-bottom:2px;margin-right:2px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><a href="../pics/doctors/<?php if($numPics>0) print $resultPics[$p]['url_big']; else print "no_photo_big.png";?>" class='lightview' rel='gallery[myset]'><img width="60" height="60" onclick = "$('big_pic').src='../pics/doctors/<?php if($numPics>0) print $resultPics[$p]['url_big']; else print 'no_photo_big.png';?>'; "  src="../pics/doctors/<?php if($numPics > 0) print $resultPics[$p]['url_thumb']; else print "no_photo_thumb.png";?>" /></a></div>
	       			
	       		<?php 
				  }
				  print "</div>";
			}
       		?>
       		</div>
       		 <div id="doctorBodyDiv" style="float:left;margin-top:20px; width:400px; overflow:hidden; ">
               <div style="float:left;margin-top:0px; width:400px;"><img width="400" src="images/orange_gorno.png"></img></div>
			   <div id="orangeDiv" style="float:left; margin:0px; padding:0px 10px 0px 10px ; width:380px; background-color:#FFB12B;"> 
             
			
                       		================ <u><b style="color: #009900;">Характеристики</b></u> ===============	 <br />
                          
						<b style="color: #009900;">Адрес:</b> <font color="#FFFFFF"><?=$resultDoctorBig['address']?></font><br />    
                 		<b style="color: #009900;">Телефон:</b> <font color="#FFFFFF"><?=$resultDoctorBig['phone']?></font><br />
                 		<b style="color: #009900;">Е-мейл:</b> <font color="#FFFFFF"><?=$resultDoctorBig['email']?></font><br />
                 		<b style="color: #009900;">Уеб страница:</b> <font color="#FFFFFF"><?=$resultDoctorBig['web']?></font><br />
                 		<?php                                    	
			              // ----------- DETAILS LIST -------------------------------
					
							if ($numDoctorBigCats>0)  
							{
								print "<br />================ <u><b style='color: #009900;'>Специалности</b></u> ================	<br />";
								for ($z=0;$z<$numDoctorBigCats;$z++)
								{
							 		print "<u><b><font color='#FFFFFF'> - ".$resultDoctorBigCats[$z]['doctor_category_name']."</font></b></u> <br />"; 
						    	}
							}
			
						// ---------------------------------------------------------		
			            ?>
							================ <u><b style="color: #009900;">Допълнително</b></u> ================	<br />		            
                 		 <div style="margin:0px; width:380px; background-color:#FFB12B;"> 
                 		  <font color="#FFFFFF"><?=$resultDoctorBig['info']?></font><br />
                 		  </div>
                     	
               		</div>
               		  <div style="float:left;margin-top:0px; width:400px;height:16px;"><img width="400" src="images/orange_dolno.png"></img></div>
			
           </div>

		</tr></table>
		</div>

		
		
<div id="starDiv" style=" float:left;width:200; margin-top:20px;"> </div>
<?php 
	$sql="SELECT rating, times_rated FROM doctors WHERE id = '".$_REQUEST['doctorID']."' ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$RatingResult = $conn->result;
?>
<script language='javascript' type='text/javascript'>
   new Starbox('starDiv', <?=$RatingResult['rating']?>, { rerate: false, max: 6, stars: 6, buttons: 12, color:'#FF6600',hoverColor:'#B9F4A8', total: <?=$RatingResult['times_rated']?>, indicator: ' Рейтинг #{average} от #{total} гласа', ghosting: true ,onRate: function(element, info) {
   	var indicator = element.down('.indicator');
  	var restore = indicator.innerHTML;
    indicator.update('Вие дадохте оценка ' + info.rated.toFixed(2));
    window.setTimeout(function() { indicator.update('Благодарности!') }, 2000);
    //window.setTimeout(function() { indicator.update(restore) }, 4000);
    new Effect.Highlight(indicator);
    
     
	}});
	
function saveStar(event) {
			
	  new Ajax.Request('doctors_inc/savestar.php?doctorID=<?=$_REQUEST['doctorID']?>', {
	    parameters: event.memo,  
	    onSuccess: function(transport) {
		   	var indicator = $('starDiv').down('.indicator');
		    if (transport.responseText){   
		    	window.setTimeout(function() { indicator.update(transport.responseText) }, 4000);  	    	  		    	    	
		    }     
		    else indicator.update('Вие ще сте пръв с Вашата оценка');	  
			}
		}
	  );
}
         
document.observe('starbox:rated', saveStar);


</script>


<div style="float:right; margin-right:0px; width:420px; " align="right"><span style="color:#FF8400"><u>Разгледана <?=$resultdoctorCnt['cnt']?$resultdoctorCnt['cnt']:1 ?> пъти</u></span></div>
   		 <br style="clear:both;"/> 
	
		<hr style="float:left; margin:20px 20px 0px 20px; width:420px;" /> 	   
	    
	    	 	<a style="float:right;margin-right:0px;margin-top:10px;" href="javascript://" onclick=" new Effect.toggle($('readComment'),'Blind'); ">Коментари (<?=$numDoctorComment?>)</a> 
	      		    	
					<br /> 
				<div id="readComment" style="float:left;display:none;margin-left:0px;">
				
				
			<?php if($numDoctorComment>0)
	    	{
	    	    for($i=0;$i<$numDoctorComment;$i++)
	    	    {
	    	?>	    	
                 <div style="float:left; margin-left:0px; width:460px;">
		 			<div style="float:left; margin-left:5px; padding:0px; width:420px; font-size: 14px; color: #009900;" align="justify">
            		  <table>
            		  	<tr>
            				<td width="15px" bgcolor="#E7E7E7"></td>
            				<td style="padding:10px;">
            			 		<div style="background-image:url(images/fon_header_green.png); margin-left:0px;margin-bottom:10px; height:20px; width:245px; background-repeat:no-repeat; font-size:12px; color:#000000;">
            					<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultDoctorComment[$i]['created_on'] ?></i></div></div>
            					<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultDoctorComment[$i]['sender_name']?></div>
            					</div>
            			  		<div  style="margin-top:5px; width:360px; overflow:hidden; ">
                   		
            	        <?php print stripslashes($resultDoctorComment[$i]['comment_body']); ?>
            
            		  </tr>
            		</table>
		 		 </div>		   
	    	  </div>
	    	
	    	<?php   
                } 
	    	}    	   	
	    	
	    	?>
	    	
	    	 <br />
	    	 
	    	  <hr style="float:left; margin:20px 20px 0px 20px; width:420px;"/> 	   
	    
	    	  <a style="float:right;margin-right:40px;margin-top:10px;" href="javascript:void(0);" onclick="if(<?=$_SESSION['userID']?'true':'false'?>) { new Effect.toggle($('writeComment'),'Blind');} else{alert('Съжалявам, необходимо е да влезете в системата за да направите своя коментар.');return false;} ">Коментирай</a> 
	    
				 <br /> 
				 
				 <div id="writeComment" style="float:left;display:none;margin-left:20px;">
				  
				  <br /> 
				  
    				 	<input type="hidden" name="doctorID" value="<?=$doctorID?>"/>
    				  Името Ви:<br /> <input type="text" name="sender_name" id="sender_name" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  Е-мейлът Ви:<br /> <input type="text" name="sender_email" id="sender_email" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  				
    				 Текст на Коментара:<br /> 
    				 <textarea rows = "4" cols = "40"  name="comment_body" id="comment_body" ></textarea>
    								  
    				  <br /> <br /> 
    				   <input type="hidden" name="insert_comment_btn" value="" />
					
    				  <input type="image"  value="Добави" src="images/btn_gren_insert.png" onclick="$('insert_comment_btn').setValue('Добави');$('search_form').action='doctors.php?doctorID=<?=$doctorID?>'" id="insert_comment_btn" title="Добави Коментар" name="insert_comment_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
							
    			</div>
		  		
			</div>		   
				
			</div>		   
				
  </div>
