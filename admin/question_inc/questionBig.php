<?php

 $questionID = $_REQUEST['questionID'];

if (isset($questionID))
{
	
	$sql="SELECT q.questionID as 'questionID', q.parentID as 'parentID', q.created_on as 'created_on', q.question_body as 'question_body', q.sender_name as 'sender_name', q.sender_email as 'sender_email', qc.name as 'category' FROM questions q, question_category qc WHERE q.category=qc.id AND questionID='".$questionID."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultQuestionBig=$conn->result;	
	
	$sql="SELECT question_id, SUM(cnt) as 'cnt' FROM log_question WHERE question_id='".$questionID."' GROUP BY question_id";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultQuestionCnt=$conn->result;	
	
	$sql="SELECT DISTINCT(questionID) as 'questionID', parentID as 'parentID', created_on as 'created_on', question_body as 'question_body', sender_name as 'sender_name', sender_email as 'sender_email' FROM questions WHERE parentID='".$questionID."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultQuestionAnsers=$conn->result;	
	$numQuestionAnsers=$conn->numberrows;	
	
}


?>
<div id="newsDiv" style="float:left; margin-top:10px; margin-bottom:10px; width:420px;">
		<div style="float:left;width:420px;">
			<div style="float:left;"><a href="javascript:void(0);" onclick="newsFsize(2)" title="увеличи размера на текста" style="font-size:16px;">A+|</a> <a href="javascript:void(0);" onclick="newsFsize_d()" title="нормален размер" style="font-size:14px;">A|</a> <a href="javascript:void(0);" onclick="newsFsize(-2)" title="намали размера на текста" style="font-size:12px;">A-</a></div>
		<div style="float:right; margin-right:2px;" ><a href="?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&category=<?=$_REQUEST['category']?>&question_body=<?=$_REQUEST['question_body']?>&sender_name=<?=$_REQUEST['sender_name']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&edit=<?=$resultQuestionMain[$i]['questionID']?>"><img style="margin-left:5px;" src="images/replay.png" alt="Напиши твоето мнение по този въпрос" title="Напиши твоето мнение по този въпрос" width="20" height="20"></a></div>
		</div>
		<div style="float:left; margin-left:0px; width:420px;">
		
	    <?php if(count($resultQuestionBig)>0)
	    {
	    	  
	    	?>	    	
                 <div style="float:left; margin-left:0px; width:460px;">
		 			<div style="float:left; margin-left:5px; padding:0px; width:410px; font-size: 14px; color: #467B99;" align="justify">
            		  <table>
            		  	<tr>
            				<td width="15px" bgcolor="#E7E7E7"></td>
            				<td style="padding:10px;">
            			 		<div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
            						<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultQuestionBig['created_on'] ?></i></div></div>
            						<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultQuestionBig['sender_name']?></div>
            					</div>
            			  		<div id="commentDiv" style="margin-top:5px; width:360px; overflow:hidden; ">
                   		
            	        <?php print stripslashes($resultQuestionBig['question_body']); ?>
            
            		  </tr>
            		</table>
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
