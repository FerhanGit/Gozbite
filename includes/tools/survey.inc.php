<?php // ANKETA

	$sql="SELECT s.ID as 'surveyID', s.body as 'survey_body', s.start_date as 'start_date', s.end_date as 'end_date', s.active as 'active' FROM surveys s WHERE active = 1 AND (NOW() BETWEEN start_date AND end_date) ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultSurveysActiv = $conn->result;	
	$numSurveysActiv = $conn->numberrows;
	
	
	$sql="SELECT DISTINCT(ID) as 'anserID', survey_ID as 'survey_ID', cnt as 'cnt', anser as 'anser' FROM surveys_ansers WHERE survey_ID='".$resultSurveysActiv['surveyID']."' ORDER BY ID";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultAnsers = $conn->result;	
	$numAnsers = $conn->numberrows;	
	
if($numSurveysActiv>0)
{
  ?>
 <div class="boxRight   main_same_height">
	<div class="title">Анкета</div>
      <div class="contentBox maincontentBox">

<div id="SurveyDiv" align="left" style="font-size:12px; font-family:'Trebuchet MS', Arial,sans-serif; padding-left:10px; padding:10px 0px 10px 0px; ">
  <div style=" margin:5px;">

  
  <div class="detailsDiv" style="font-size:14px; font-family:'Trebuchet MS', Arial,sans-serif; float:left;  margin-bottom:20px; margin-right:5px; border-top:3px solid #6DCA31; padding:5px; background-color:#F1F1F1;">
	<?=$resultSurveysActiv['survey_body']?>
</div>
<br style="clear:left;"/>
  <?php 
	for($sa=0;$sa<$numAnsers;$sa++)
	{ ?>
		       				
		<div style=" "><input type="radio" name="ansers" id="ansers<?=$resultAnsers[$sa]['anserID']?>" value="<?=$resultAnsers[$sa]['anserID']?>" onclick="if(this.checked==1){$('radio').setValue(this.value);}"> <?=$resultAnsers[$sa]['anser']?>	 </div>
	   	
		<?php }
		?>
			<div style=" margin-top:20px; " align="center">
			<input type="image" onclick="if($('radio').getValue()==''){alert('Моля изберете една от предоставените Ви опции!');return false;} else{new Ajax.Updater('SurveyDiv', 'index_inc/Ajax_survey.php', {
						  method: 'get',
						  parameters: { anser_ID: $F('radio') },
						onSuccess: function() {
					                       new Effect.Opacity('SurveyDiv', {duration: 0.5, from:0.5, to:1.0});
										   new Effect.Opacity('newsDIVContainer', {duration: 0.5, from:0.5, to:1.0});
					              }
						});return false;} " value="Напред" src="images/btn_blue_vote.png" id="vote" title="Напред" name="vote" style="border: 0pt none ; display: inline;" height="15" type="image" width="80" />
	  		</div>
	  
	  	</div>
	</div>

</div>

<input type="hidden" name="radio" id="radio" value="">	

</div>


<?php } 
