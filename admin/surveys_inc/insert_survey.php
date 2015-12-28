<?php


$edit = $_REQUEST['edit'];

if (isset($edit))
{
	$sql="SELECT s.ID as 'surveyID', s.active as 'active', s.start_date as 'start_date', s.end_date as 'end_date', s.body as 'survey_body' FROM surveys s WHERE s.ID='".$edit."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultEdit=$conn->result;
	
	
	$sql="SELECT sa.ID as 'anserID', sa.survey_ID as 'survey_ID', sa.anser as 'anser', sa.cnt as 'cnt' FROM surveys_ansers sa WHERE sa.anser<> '' AND sa.survey_ID='".$edit."' ORDER BY sa.ID";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultEditAnsers=$conn->result;
	$numEditAnsers=$conn->numberrows;
	
}

?>
<div id="search_form" style="float:left; margin-top:10px; width:460px;">
 <fieldset style="float:left;width:450px;margin-bottom:20px;">
 <legend>&nbsp;Предложи Анкета:</legend> <br />        
                       

 <div style="float:left;margin:10px;margin-left:0px;width:430px;"> 
                        <fieldset style="float:left;width:420px;margin-bottom:10px;">
				       <legend>&nbsp;Период на активност</legend> <br />        
                      <?php     
							printf("    от <input type = \"text\" id = \"fromDate2\" name = \"fromDate2\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate2')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $resultEdit['start_date'] ? date('d.m.Y', strtotime($resultEdit['start_date'])) : '' );
							printf("    до <input type = \"text\" id = \"toDate2\" name = \"toDate2\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate2')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $resultEdit['end_date'] ? date('d.m.Y', strtotime($resultEdit['end_date'])) : '' );
					   ?>   
					    </fieldset>   
				  	
					 
 </div> 
 
		<?php if(count($resultEdit)>0)
	    {
	    	  
	    	?>	    	
                 <div style="float:left; margin-left:0px; width:460px;">
		 			<div style="float:left; margin-left:5px; padding:0px; width:410px; font-size: 14px; color: #467B99;" align="justify">
            		  <table>
            		  	<tr>
            				<td width="15px" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
            				<td style="padding:10px;">
            			 		<div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
            						<div style="float:left; margin-left:2px;width:150px;font-size:11px;"><div style="float:left; color:#FFFFFF; "><i>От <?=convert_Month_to_Cyr(date("j F Y",strtotime($resultEdit['start_date']))) ?></i></div></div>
            						<div style="float:right; color:#000000; margin-right:2px;font-size:11px;"><i>До <?=convert_Month_to_Cyr(date("j F Y",strtotime($resultEdit['end_date'])))  ?></i></div>						
					            </div>
            			  		<div id="commentDiv" style="margin-top:5px; width:360px; overflow:hidden; ">
                   		       		<?php print stripslashes($resultEdit['survey_body']); ?>
            					</div>
            				<div  style="margin-top:5px; width:410px; overflow:hidden; ">
				       		<?php 
				       			for($sa=0;$sa<$numEditAnsers;$sa++)
				       			{ ?>
				       				
				       				<input type="radio" name="ansers" value="<?=$sa?>" > <?=$resultEditAnsers[$sa]['anser']?> <br />	
				       			
				       		<?php }
				       		?>
		       		  </div>
            		  </tr>
            		</table>
		 		 </div>		   
	    	  </div>
	    	
	    	<?php   
                
	    	}    	   	
	    	
	    	?>
	    	
				
				  <br /><br /><br style="clear:both;" />
				  

				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
				   <input type='hidden' name='edit' value='<?=$_REQUEST['edit']?>'>
				
	
				  
				  <br /> <br />
				  
			
				  
				 <br style="clear:both;"/> 
				      				    		
    				 Текст на Въпроса:<br /> 
    				
    				 <textarea rows = "4" cols = "40"  name="survey_body" id="survey_body" ><?=$resultEdit['survey_body']?></textarea>
    				<br /> <br /> 
    				
<?php for($i=0;$i<10;$i++){?>

    				 Отговор <?=($i+1)?>: <br /> 
    				 <textarea rows = "4" cols = "40"  name="surveys_ansers[]" id="surveys_anser<?=($i+1)?>" ><?=$resultEditAnsers[$i]['anser']?></textarea>
    				 <div style="float:right; margin-right:2px;" ><a onclick="if(!confirm('Сигурни ли сте?')){return false;}" href="?page=<?=$_REQUEST['page']."&orderby=".$_REQUEST['orderby']."&survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&deleteAnser=".$resultEditAnsers[$i]['anserID']?>"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>		  				
					<br />
<?php } ?>
					 <br /> 
    				<?php if (!isset($edit)) {?>  <input type="image"  value="Добави" src="images/btn_gren_insert.png" id="insert_survey_btn" title="Добави Анкета" name="insert_survey_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
						<?PHP } else {?> <input type="image" value="Редактирай" src="images/btn_gren.png" id="edit_btn" title="Редактирай" name="edit_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96" />
					<?php } ?>
    			
     </fieldset>  
     			
</div>