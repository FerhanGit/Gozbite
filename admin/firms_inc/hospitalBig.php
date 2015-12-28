<?php

include_once("../inc/dblogin.inc.php");


 $firmID=substr($_SERVER['HTTP_REFERER'],strpos($_SERVER['HTTP_REFERER'],"firmID=")+7);


if (isset($firmID))
{
	
	$sql="SELECT h.id as 'id', h.name as 'firm_name', h.phone as 'phone', h.address as 'address', h.email as 'email', h.web as 'web', h.manager as 'manager', l.name as 'location',lt.name as 'locType', h.registered_on as 'registered_on', h.description as 'description', h.has_pic as 'has_pic' FROM hospitals h, locations l, location_types lt WHERE h.location_id = l.id  AND l.loc_type_id = lt.id AND h.id= '".$firmID."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultHospitalBig=$conn->result;
	
	
	//------------- Categories ----------------------------------------------------
	
	$sql="SELECT hc.id as 'hospital_category_id', hc.name as 'hospital_category_name' FROM hospitals h, hospital_category hc, hospitals_category_list hcl WHERE hcl.hospital_id = h.id AND hcl.category_id = hc.id AND h.id = '".$resultHospitalBig['id']."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numHospitalBigCats  	= $conn->numberrows;
	$resultHospitalBigCats  = $conn->result;
	
	//--------------------------- PICS ------------------------------------------
	
	$sql="SELECT * FROM hospital_pics WHERE hospitalID='".$resultHospitalBig['id']."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultPics=$conn->result;
	$numPics=$conn->numberrows;
	
	
	//---------------------------- CNT --------------------------------------------------
	
	$sql="SELECT hospital_id, SUM(cnt) as 'cnt' FROM log_hospitals WHERE hospital_id='".$resultHospitalBig['id']."' GROUP BY hospital_id";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultHospitalCnt=$conn->result;

	
	//------------- Comments ----------------------------------------------------
	 	
	   
	$sql="SELECT firmID, sender_name , sender_email , comment_body , parentID , created_on  FROM hospital_comment WHERE firmID='".$resultHospitalBig['id']."' ORDER BY created_on DESC";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultHospitalComment=$conn->result;	
    $numHospitalComment=$conn->numberrows;
	  			
	// --------------------------------------------------------------------------
		
	
}

?>

<div id="hospitalDiv" style="float:left; margin-top:20px; margin-bottom:10px; width:420px;">
  <a href="javascript:void(0);" onclick="hospitalsFsize(2)" title="увеличи размера на текста" style="font-size:16px;">A+|</a> <a href="javascript:void(0);" onclick="hospitalsFsize_d()" title="нормален размер" style="font-size:14px;">A|</a> <a href="javascript:void(0);" onclick="hospitalsFsize(-2)" title="намали размера на текста" style="font-size:12px;">A-</a>
		<div style="float:right; margin-right:20px; width:400px; " align="right"><span style="color:#009900">Регистрирано на: <font color="Black"><u><?=$resultHospitalBig['registered_on'] ?> </u></font>ч.</span></div>
	    <div style="float:left; margin-left:5px; width:410px; " align="left"><strong style="color:#FF8400"><?=$resultHospitalBig['firm_name'] ?></strong></div>
	    <div style="float:left; margin-left:0px; width:420px;">
		
 		 <div style="float:left; margin-left:0px; padding:0px; width:420px; font-size: 14px; color: #333333;" align="justify">
		   <table><tr>
			<td width="15px" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
			<td style="padding:10px;">
			 <div style="background-image:url(images/fon_header_green.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
				<div style="float:left; margin-left:15px;"><div style="float:left; font-weight:bold; color:#FFFFFF; "><?=$resultHospitalBig['locType']." ".$resultHospitalBig['location'] ?></div></div>
			 	<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?='' ?></div>
			  </div>
			  <div  style="margin-top:5px; width:410px; overflow:hidden; ">
			 <div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:40px; width:150px; overflow:hidden; " ><div ><img width="150" src="<?=(is_file("../pics/firms/".$resultHospitalBig['id']."_logo.jpg"))?"../pics/firms/".$resultHospitalBig['id']."_logo.jpg":"../pics/firms/no_logo.png"?>" /></div></div>
			
			 <?php
			  if ($resultHospitalBig['has_pic']=='1')
			  {  print "<div style='float:left; margin:0px; width:210px;' >";
				  for ($p=0;$p<$numPics;$p++)
				  { 
				 ?>        			
	       			<div style="float:left; border:double; border-color:#666666; margin-bottom:2px;margin-right:2px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><a href="../pics/firms/<?php if($numPics>0) print $resultPics[$p]['url_big']; else print "no_photo_big.png";?>" class='lightview' rel='gallery[myset]'><img width="60" height="60" src="../pics/firms/<?php if($numPics>0) print $resultPics[$p]['url_thumb']; else print "no_photo_thumb.png";?>" /></a></div>
	       			
	       		<?php 
				  }
				  print "</div>";
			}
       		?>
       		</div>
       		 <div id="hospitalBodyDiv" style="float:left;margin-top:20px; width:400px; overflow:hidden; ">
               <div style="float:left;margin-top:0px; width:400px;"><img width="400" src="images/orange_gorno.png"></img></div>
			
                     <div id="orangeDiv" style="float:left; margin:0px; padding:0px 10px 0px 10px ; width:380px; background-color:#FFB12B;"> 
             
			
                       <br />============== <u><b style='color: #009900;'>Характеристики</b></u> ==============	 <br />
                           
						<b  style='color: #009900;'>Адрес:</b> <font color="#FFFFFF"><?=$resultHospitalBig['address']?></font><br />    
                 		<b  style='color: #009900;'>Телефон:</b> <font color="#FFFFFF"><?=$resultHospitalBig['phone']?></font><br />
                 		<b  style='color: #009900;'>Е-мейл:</b> <font color="#FFFFFF"><?=$resultHospitalBig['email']?></font><br />
                 		<b  style='color: #009900;'>Уеб страница:</b> <font color="#FFFFFF"><?=$resultHospitalBig['web']?></font><br />
                 		<?php                                    	
			               // ----------- DETAILS LIST -------------------------------
					
							if ($numHospitalBig>0)  
							{
								print "<br />================ <u><b style='color: #009900;'>Категория</b></u> ================	<br />";
								for ($z=0;$z<$numHospitalBigCats;$z++)
								{
							 		print "<b><font color='#FFFFFF'> - ".$resultHospitalBigCats[$z]['hospital_category_name']."</font></b> <br />"; 
						    	}
							}
			
						// ---------------------------------------------------------		
			            ?>
					<br />================ <u><b style='color: #009900;'>Описание</b></u> ================	<br />		            
                 		 <div style="margin:0px; width:380px; background-color:#FFB12B;"> 
                 		  <font color="#FFFFFF"><?=$resultHospitalBig['description']?></font><br />
                 		  </div>
                     	
               		</div>
               		  <div style="float:left;margin-top:0px; width:400px;height:16px;"><img width="400" src="images/orange_dolno.png"></img></div>
			
           </div>

		</tr></table>
		</div>


	
<div id="starDiv" style=" float:left;width:200; margin-top:20px;"> </div>
<?php 
	$sql="SELECT rating, times_rated FROM hospitals WHERE id = '".$_REQUEST['firmID']."' ";
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
			
	  new Ajax.Request('hospitals_inc/savestar.php?firmID=<?=$_REQUEST['firmID']?>', {
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


		<div style="float:right; margin-right:20px; width:300px; " align="right"><span style="color:#FF8400"><u>Разгледана <?=$resultHospitalCnt['cnt']?$resultHospitalCnt['cnt']:1 ?> пъти</u></span></div>
   		 <br style="clear:both;"/> 
	
		<hr style="float:left; margin:20px 20px 0px 20px; width:420px;" /> 	   
	    
	    	<a style="float:right;margin-right:0px;margin-top:10px;" href="javascript://" onclick=" new Effect.toggle($('readComment'),'Blind'); ">Коментари (<?=$numHospitalComment?>)</a> 
	    	   		    	
					<br style="clear:both;"/>
				<div id="readComment" style="float:left;display:none;margin-left:0px;">
				
				
			<?php if($numHospitalComment>0)
	    	{
	    	    for($i=0;$i<$numHospitalComment;$i++)
	    	    {
	    	?>	    	
                 <div style="float:left; margin-left:0px; width:460px;">
		 			<div style="float:left; margin-left:5px; padding:0px; width:420px; font-size: 14px; color: #009900;" align="justify">
            		  <table>
            		  	<tr>
            				<td width="15px" bgcolor="#E7E7E7"></td>
            				<td style="padding:10px;">
            			 		<div style="background-image:url(images/fon_header_green.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
            					<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultHospitalComment[$i]['created_on'] ?></i></div></div>
            					<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultHospitalComment[$i]['sender_name']?></div>
            					</div>
            			  		<div  style="margin-top:5px; width:360px; overflow:hidden; ">
                   		<span class="commentDiv">
            	        	<?php print stripslashes($resultHospitalComment[$i]['comment_body']); ?>
            			</span>
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
	    
	    	<a style="float:right;margin-right:40px;margin-top:10px;" href="javascript://" onclick=" new Effect.toggle($('writeComment'),'Blind'); ">Коментирай</a> 
	    	
				 <br style="clear:both;"/> 
				 
				 <div id="writeComment" style="float:left;display:none;margin-left:20px;">
				  
				 
    				 	<input type="hidden" name="firmID" value="<?=$firmID?>"/>
    				  Името Ви:<br /> <input type="text" name="sender_name" id="sender_name" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  Е-мейлът Ви:<br /> <input type="text" name="sender_email" id="sender_email" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  				
    				 Текст на Коментара:<br /> 
    				 <textarea rows = "4" cols = "40"  name="comment_body" id="comment_body" ></textarea>
    								  
    				  <br /> 
    				   <input type="hidden" name="insert_comment_btn" value="" />
					
    				  <input type="image"  value="Добави" src="images/btn_gren_insert.png" onclick="$('insert_comment_btn').setValue('Добави');$('search_form').action='hospitals.php?firmID=<?=$firmID?>';" id="insert_comment_btn" title="Добави Коментар" name="insert_comment_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
							
    			</div>
		  		
			</div>		
			
		 </div>		   
				
  </div>
