<?php

 $surveyID = $_REQUEST['surveyID'];

if (isset($surveyID))
{
	
	$sql="SELECT s.ID as 'surveyID', s.body as 'survey_body', s.start_date as 'start_date', s.end_date as 'end_date', s.active as 'active' FROM surveys s WHERE ID='".$surveyID."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultSurveysBig=$conn->result;	
	
	
	$sql="SELECT DISTINCT(ID) as 'anserID', survey_ID as 'survey_ID', cnt as 'cnt', anser as 'anser' FROM surveys_ansers WHERE survey_ID='".$surveyID."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultAnsers=$conn->result;	
	$numAnsers=$conn->numberrows;	
	
}


?>
<div id="newsDiv" style="float:left; margin-top:10px; margin-bottom:10px; width:420px;">
		<div style="float:left;width:420px;">
			<div style="float:left;"><a href="javascript:void(0);" onclick="newsFsize(2)" title="увеличи размера на текста" style="font-size:16px;">A+|</a> <a href="javascript:void(0);" onclick="newsFsize_d()" title="нормален размер" style="font-size:14px;">A|</a> <a href="javascript:void(0);" onclick="newsFsize(-2)" title="намали размера на текста" style="font-size:12px;">A-</a></div>
		<div style="float:right; margin-right:2px;" ><a href="?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&category=<?=$_REQUEST['category']?>&question_body=<?=$_REQUEST['question_body']?>&sender_name=<?=$_REQUEST['sender_name']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&edit=<?=$resultQuestionMain[$i]['questionID']?>"><img style="margin-left:5px;" src="images/replay.png" alt="Напиши твоето мнение по този въпрос" title="Напиши твоето мнение по този въпрос" width="20" height="20"></a></div>
		</div>
		<div style="float:left; margin-left:0px; width:420px;">
		
	    <?php if(count($resultSurveysBig)>0)
	    {
	    	  
	    	?>	    	
                  <div id="OFFER<?=$i?>" class="offer" onMouseover="this.style.backgroundColor='lightblue';" onmouseout="this.style.backgroundColor='#FFFFFF';"
         onMouseout="this.style.backgroundColor='#FFFFFF';" style="float:left;background-color:#FFFFFF; width:500px;">
                <div  style="float:left; margin-left:20px; width:460px; " align="left"><strong style="color:#FF8400"></strong></div>
                
                 <div style="float:left; margin-left:5px; padding:0px; width:460px; font-size: 14px; color: #333333;" align="justify">
                  <table><tr>
					<td width="15px" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
					<td style="padding:10px;">
					 <div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
						<div style="float:left; margin-left:2px;"><div style="float:left; color:#FFFFFF; "><i>От <?=convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($resultSurveysBig['start_date']))) ?></i></div></div>
            			<div style="float:right; color:#000000; margin-right:2px;"><i>До <?=convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($resultSurveysBig['end_date'])))  ?></i></div>						
					<?php if($pageName=='surveys') {?>		
							<div style="float:right; margin-right:2px;" ><a href="?page=<?=$_REQUEST['page']."&orderby=".$_REQUEST['orderby']."&survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&edit=".$resultSurveysMain[$i]['surveyID']?>"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>
							<div style="float:right; margin-right:2px;" ><a onclick="if(!confirm('Сигурни ли сте?')){return false;}" href="?page=<?=$_REQUEST['page']."&orderby=".$_REQUEST['orderby']."&survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&delete=".$resultSurveysMain[$i]['surveyID']?>"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>
						<?php } ?>
					<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"></div>
					</div>
					  <div  style="margin-top:5px; width:410px; overflow:hidden; ">
		       			      			<?php print stripslashes(str_replace($_REQUEST['survey_body'],"<font color='red'><b>".$_REQUEST['survey_body']."</b></font>",substr($resultSurveysMain[$i]['survey_body'],0,200)))."..."; ?>
		       		  </div>
		       		 <div  style="margin-top:5px; width:410px; overflow:hidden; ">
		       		<?php 
		       			for($sa=0;$sa<$numAnsers;$sa++)
		       			{ ?>
		       				
		       				<input type="radio" name="ansers" value="<?=$sa?>" > <?=$resultAnsers[$sa]['anser']?>	 <br />
		       			
		       		<?php }
		       		?>
		       		  </div>
			<div align="right"><a href="?<?php print "page=".$page."&orderby=".$_REQUEST['orderby']."&survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&surveyID=".$resultSurveysMain[$i]['surveyID'] ?>">Виж целия текст</а></div>
		 			
				</tr></table>
            	  </div>
            
       </div>
	    	
	    <?php   
               
	    }    	   	
	    	
	    ?>
   		  
   		  
   		  



   		  <div style="float:right; margin-right:0px; margin-top:20px; width:400px; " align="right"><span style="color:#FF8400;float:right; margin-right:0px;"><u>Прочетено <?=$resultQuestionCnt['cnt']?$resultQuestionCnt['cnt']:1 ?> пъти</u></span></div>
   		
	  </div>
	    
	    	 <br style="clear:both;"/> 
	
		<hr style="float:left; margin:20px 20px 0px 20px; width:420px;" /> 	   
	    
	  	<a style="float:right;margin-right:0px;margin-top:10px;" href="javascript://" onclick=" new Effect.toggle($('readComment'),'Blind'); ">Отговори (<?=$numQuestionAnsers?>)</a> 
	    		   		    	
					<br style="clear:both;"/> 
		<div id="readComment" style="float:left;display:none;margin-left:20px;">
				
				
			<?php if($numQuestionAnsers>0)
	    	{
	    	    for($i=0;$i<$numQuestionAnsers;$i++)
	    	    {
	    	?>	    	
                 <div style="float:left; margin-left:0px; width:460px;">
		 			<div style="float:left; margin-left:5px; padding:0px; width:410px; font-size: 14px; color: #467B99;" align="justify">
            		  <table>
            		  	<tr>
            				<td width="15px" bgcolor="#E7E7E7"></td>
            				<td style="padding:10px;">
            			 		<div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
            						<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultQuestionAnsers[$i]['created_on'] ?></i></div></div>
            						<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultQuestionAnsers[$i]['sender_name']?></div>
            					</div>
            			  		<div id="commentDiv" style="margin-top:5px; width:360px; overflow:hidden; ">
                   		
            	        <?php print stripslashes($resultQuestionAnsers[$i]['question_body']); ?>
            
            		  </tr>
            		</table>
		 		 </div>		   
	    	  </div>
	    	
	    	<?php   
                } 
	    	}    	   	
	    	
	    	?>
	    	
	    	
		  		
			</div>	
				   
				
  </div>
