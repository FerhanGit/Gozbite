<?php

include_once("../inc/dblogin.inc.php");


$bolestID=substr($_SERVER['HTTP_REFERER'],strpos($_SERVER['HTTP_REFERER'],"bolestID=")+9);

if (isset($bolestID))
{
	
	$sql="SELECT b.bolestID as 'bolestID', b.date as 'date', b.title as 'title', b.body as 'body', b.has_pic as 'has_pic', b.autor_type as 'autor_type', b.autor as 'autor', b.source as 'source' FROM bolesti b WHERE 1=1 AND b.bolestID='".$bolestID."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultBolestiBig=$conn->result;	
	
	
	// ============================= CATEGORIES =========================================

		$sql="SELECT bc.id as 'bolest_category_id', bc.name as 'bolest_category_name' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND b.bolestID = '".$bolestID."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numBolestBigCats  		= $conn->numberrows;
		$resultBolestBigCats 	= $conn->result;
		
		
	// =============================== SIMPTOMS ========================================	
	
		$sql="SELECT bs.id as 'bolest_simptom_id', bs.name as 'bolest_simptom_name' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND b.bolestID = '".$bolestID."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numBolestBigSimptoms  	   = $conn->numberrows;
		$resultBolestBigSimptoms   = $conn->result;
		
		
	// =============================== Cnt ========================================	
	
	
		$sql="SELECT bolest_id, SUM(cnt) as 'cnt' FROM log_bolest WHERE bolest_id='".$bolestID."' GROUP BY bolest_id";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultBolestiCnt=$conn->result;	
		
	// =============================== COMMENTS ========================================	
	
		
		$sql="SELECT commentID, sender_name , sender_email , comment_body , parentID , created_on  FROM bolest_comment WHERE bolestID='".$bolestID."' ORDER BY created_on DESC";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultBolestiComment=$conn->result;	
	    $numBolestiComment=$conn->numberrows;
	

	//------------- Pics ----------------------------------------------------
	
		$sql="SELECT * FROM bolesti_pics WHERE bolestID='".$resultBolestiBig['bolestID']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPicsBig=$conn->result;
		$numPicsBig=$conn->numberrows;
}


?>
<div id="bolestiDiv" style="float:left; margin-top:10px; margin-bottom:10px; width:420px;">
  <a href="javascript:void(0);" onclick="bolestiFsize(2)" title="увеличи размера на текста" style="font-size:16px;">A+|</a> <a href="javascript:void(0);" onclick="bolestiFsize_d()" title="нормален размер" style="font-size:14px;">A|</a> <a href="javascript:void(0);" onclick="bolestiFsize(-2)" title="намали размера на текста" style="font-size:12px;">A-</a>
		<div style="float:right; margin-right:0px;margin-bottom:5px; width:400px; " align="right"><span style="color:#333333"><i><u><?=$resultBolestiBig['source'] ?></i></u></span>
 		</div>
	    <div style="float:left; margin-left:20px;margin-bottom:10px; width:400px; " align="left"><strong style="color:#FF8400"><?=$resultBolestiBig['title'] ?></strong>
	    </div>
	    <div style="float:left; margin-left:0px; width:420px;">
		 <div style="float:left; margin-left:5px; padding:0px; width:400px; font-size: 14px; color: #333333;">
		  <table><tr>
			<td style="width:15px;" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
			<td style="padding:10px;">
			 <div style="background-image:url(images/fon_header_red.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
				<div style="float:left; margin-left:10px;">
					<div style="float:left; color:#000000; "><i><?=$resultBolestiBig['date'] ?></i></div>
				</div>
				<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:10px;"><?=$resultBolestBigCats[0]['bolest_category_name']?></div>
			 </div>
			 <div id="bolestiBodyDiv" style="margin-top:5px; width:400px; overflow:hidden; ">
       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:250px; overflow:hidden; " ><a href="bolesti.php?bolestID=<?=$bolestID?>"><img id="big_pic" width="250" src="../pics/bolesti/<?php if($numPicsBig > 0) print $resultPicsBig[0]['url_big']; else print "no_photo_big.png";?>" /></a>
       			</div>
				<?php 
								if ($numBolestBigCats>0) 
								{
									print " <b style='color: #FF0000;'>Категория:</b> <span>"; 
								
									for($z=0;$z<$numBolestBigCats;$z++)
									{
										print $resultBolestBigCats[$z]['bolest_category_name']."; "; 
									}
									print "</span><br />";
								}
								
								if ($numBolestBigSimptoms>0) 
								{
									print " <b style='color: #FF0000;'>Симптоми:</b> <span>"; 
								
									for($z=0;$z<$numBolestBigSimptoms;$z++)
									{
										print $resultBolestBigSimptoms[$z]['bolest_simptom_name']."; "; 
									}
									print "</span><br />";
								}
				?>
				
				<b style='color: #FF0000;'>Подробности:</b> <span >
       			<?php print stripslashes($resultBolestiBig['body']); ?>
				</span>
				</tr>
			</table>
			
		</div>	
				 
				 	
<div id="starDiv" style=" float:left;width:200; margin-top:20px;"> </div>
<?php 
	$sql="SELECT rating, times_rated FROM bolesti WHERE bolestID = '".$_REQUEST['bolestID']."' ";
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
			
	  new Ajax.Request('bolesti_inc/savestar.php?bolestID=<?=$_REQUEST['bolestID']?>', {
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


			<div style="float:right; margin-right:0px; width:400px; "><span style="color:#FF8400;float:right; margin-right:0px;"><u>Прочетена <?=$resultBolestiCnt['cnt'] ?> пъти</u></span></div>
			
		
		   
	    </div>
	    
	    	 <br style="clear:both;"/> 
	
		<hr style="float:left; margin:20px 20px 0px 20px; width:400px;" /> 	   
	    
	    	<a style="float:right;margin-right:0px;margin-top:10px;" href="javascript://" onclick=" new Effect.toggle($('readComment'),'Blind'); ">Коментари (<?=$numBolestiComment?>)</a> 
	    	   		    	
					<br /> 
				<div id="readComment" style="float:left;display:none;margin-left:20px;color:#333333">
				
				
			<?php if($numBolestiComment>0)
	    	{
	    	    for($i=0;$i<$numBolestiComment;$i++)
	    	    {
	    	?>	    	
                 <div  style="float:left; margin-left:0px; width:400px;">
		 			<div style="float:left; margin-left:5px; padding:0px; width:410px; font-size: 14px; color: #FF0000;" align="justify">
            		  <table>
            		  	<tr>
            				<td width="15px" bgcolor="#E7E7E7"></td>
            				<td style="padding:10px;">
            			 		<div style="background-image:url(images/fon_header_red.png); margin-left:0px;margin-bottom:10px; height:20px; width:245px; background-repeat:no-repeat; font-size:12px; color:#000000;">
            					<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultBolestiComment[$i]['created_on'] ?></i></div></div>
            					<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultBolestiComment[$i]['sender_name']?></div>
            					</div>
            			  		<div  style="margin-top:5px; width:360px; overflow:hidden; ">
                   		<span id="commentDiv">
            	        	<?php print stripslashes($resultBolestiComment[$i]['comment_body']); ?>
            			</span>
            		  </tr>
            		</table>
		 		 </div>		   
	    	  </div>
	    	
	    	<?php   
                } 
	    	}    	   	
	    	
	    	?>
	    	
	    	  <br style="clear:both;"/> 
	    	 
	    	  <hr style="float:left; margin:20px 20px 0px 0px; width:400px;"/> 	   
	    
	    	<a style="float:right;margin-right:40px;margin-top:10px;" href="javascript://" onclick=" new Effect.toggle($('writeComment'),'Blind'); ">Коментирай</a> 
	    	
				 <br /> 
				 
				 <div id="writeComment" style="float:left;display:none;margin-left:20px;color:#333333;">
				  
				  <br /> 
				  
    				 	<input type="hidden" name="bolestID" value="<?=$bolestID?>"/>
    				  Името Ви:<br /> <input type="text" name="sender_name" id="sender_name" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  Е-мейлът Ви:<br /> <input type="text" name="sender_email" id="sender_email" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  				
    				 Текст на Коментара:<br /> 
    				 <textarea rows = "4" cols = "40"  name="comment_body" id="comment_body" ></textarea>
    								  
    				  <br />  <br /> 
    				  <input type="image"  value="Добави" src="images/btn_gren_insert.png" id="insert_comment_btn" title="Добави Коментар" name="insert_comment_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
						
    			</div>
		  		
			</div>		   
				
  </div>
