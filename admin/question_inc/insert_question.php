<?php


$edit = $_REQUEST['edit'];

if (isset($edit))
{
	$sql="SELECT q.questionID as 'questionID', q.parentID as 'parentID', q.created_on as 'created_on', q.question_body as 'question_body', q.sender_name as 'sender_name', q.sender_email as 'sender_email', qc.name as 'category' FROM questions q, question_category qc WHERE q.category=qc.id AND questionID='".$edit."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultEdit=$conn->result;
	
}

?>
<div id="search_form" style="float:left; margin-top:10px; width:500px;">


 <hr style="float:left; margin-left:0px; width:470px;">
 
 Напиши:
		<?php if(count($resultEdit)>0)
	    {
	    	  
	    	?>	    	
                 <div style="float:left; margin-left:0px; width:460px;">
		 			<div style="float:left; margin-left:5px; padding:0px; width:410px; font-size: 14px; color: #467B99;" align="justify">
            		  <table>
            		  	<tr>
            				<td width="15px" bgcolor="#E7E7E7"></td>
            				<td style="padding:10px;">
            			 		<div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
            						<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultEdit['created_on'] ?></i></div></div>
            						<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultEdit['sender_name']?></div>
            					</div>
            			  		<div id="commentDiv" style="margin-top:5px; width:360px; overflow:hidden; ">
                   		
            	        <?php print stripslashes($resultEdit['question_body']); ?>
            
            		  </tr>
            		</table>
		 		 </div>		   
	    	  </div>
	    	
	    	<?php   
                
	    	}    	   	
	    	
	    	?>
	    	
				
				  <br /><br /><br style="clear:both;" />
				  

				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
				
		<?php if(count($resultEdit)<1)
		 {	    	  
	    ?>  
			 <div id="writeComment" style="float:left;margin-left:20px;">  

			 	Раздел: <br />  <select name="question_category" id="question_category">
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT * FROM question_category";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCat=$conn->result;
						$numCat=$conn->numberrows;
						for ($i=0;$i<$numCat;$i++)
               {?>      
			 	  <option value = "<?=$resultCat[$i]['id']?>"><?=$resultCat[$i]['name']?></option> 
                             
               <?php } ?>
				  </select>

		<?php } ?>
				  
				  
				  <br /> <br />
				  
			
				  
				 <br style="clear:both;"/> 
				  
    				 	<input type="hidden" name="parentID" value="<?=$_REQUEST['edit']?$_REQUEST['edit']:0?>"/>
    				  Името Ви:<br /> <input type="text" name="sender_name" id="sender_name" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  Е-мейлът Ви:<br /> <input type="text" name="sender_email" id="sender_email" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  				
    				 Текст на Въпроса/Отговора:<br /> 
    				 <textarea rows = "4" cols = "40"  name="question_body" id="question_body" ></textarea>
    								  
    				  <br />  <br /> 
    				  <input type="image"  value="Добави" src="images/btn_gren_insert.png" id="insert_question_btn" title="Добави Въпрос" name="insert_question_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
						
    			</div>
    
     			
</div>