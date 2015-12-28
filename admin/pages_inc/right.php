  <?php 
  
  	$sql="SELECT s.ID as 'surveyID', s.body as 'survey_body', s.start_date as 'start_date', s.end_date as 'end_date', s.active as 'active' FROM surveys s WHERE active=1";
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
  <div id="orange_dqsno" style="float:left;">
    <div id="orange_dqsno_otpred" align="center" style="float:left; width:140px; height:18px; padding:0px 5px 2px 5px; color: #FFFFFF; font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; background-image:url(images/right_gorno_<?=$theme_color?>.png);">Анкета 
            <?php //include("inc/user_info.inc.php")?>		  
    </div>
</div>

<div style="float:left; background-color:#F7F7F7; margin-bottom:10px;">

<div id="SurveyDiv" align="justify" style="padding-left:10px;float:left; width:148px;  font-weight:normal; font-size:11px; color:#666666; padding:10px 0px 10px 0px;  border-left: 1px solid #999999;border-right: 1px solid #999999;">
  <div style="float:left;margin:5px;">

  
  <div><?=$resultSurveysActiv['survey_body']?></div>
  <?php 
	for($sa=0;$sa<$numAnsers;$sa++)
	{ ?>
		       				
		<div style="width:140px;float:left;"><input type="radio" name="ansers" id="ansers<?=$resultAnsers[$sa]['anserID']?>" value="<?=$resultAnsers[$sa]['anserID']?>" onclick="if(this.checked==1){$('radio').setValue(this.value);}"> <?=$resultAnsers[$sa]['anser']?>	 </div>
	   	
	<?php }
	?>
	<div style="float:left;margin-top:20px;width:140px;" align="center">
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
<div style="float:left;"><img width="150" src="images/<?=$theme_color?>_bottom.png"></div>

<input type="hidden" name="radio" id="radio" value="">	

</div>


<?php } ?>





<div id="orange_dqsno" style="float:left;">
    <div id="orange_dqsno_otpred" align="center" style="float:left; width:140px; height:18px; padding:0px 5px 2px 5px; color: #FFFFFF; font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; background-image:url(images/right_gorno_<?=$theme_color?>.png);">Реклама 
            <?php //include("inc/user_info.inc.php")?>		  
    </div>
</div>

<div style="float:left; background-color:#F7F7F7; margin-bottom:10px;">

	<div id="BANER-LEFT" align="justify" style="float:left; width:148px;  font-weight:normal; font-size:11px; color:#666666; padding:10px 0px 10px 0px;  border-left: 1px solid #999999;border-right: 1px solid #999999;">
	  <div style="float:left;margin:4px;">
<!--/* OpenX Javascript Tag v2.4.4 */-->

<!--/*
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://localhost/WS/openx/www/delivery/...'
  * to
  *   'https://localhost/WS/openx/www/delivery/...'
  *
  * This noscript section of this tag only shows image banners. There
  * is no width or height in these banners, so if you want these tags to
  * allocate space for the ad before it shows, you will need to add this
  * information to the <img> tag.
  *
  * If you do not want to deal with the intricities of the noscript
  * section, delete the tag (from <noscript>... to </noscript>). On
  * average, the noscript tag is called from less than 1% of internet
  * users.
  */-->

<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://localhost/WS/openx/www/delivery/ajs.php':'http://localhost/WS/openx/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=5&amp;source=HOME_140x300");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://localhost/WS/openx/www/delivery/ck.php?n=a53bdd45&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://localhost/WS/openx/www/delivery/avw.php?zoneid=5&amp;source=HOME_140x300&amp;n=a53bdd45' border='0' alt='' /></a></noscript>



	  </div>
	</div>
	
	<div style="float:left;"><img width="150" src="images/<?=$theme_color?>_bottom.png"></div>


</div>









<div id="orange_dqsno" style="float:left;">
    <div id="orange_dqsno_otpred" align="center" style="float:left; width:140px; height:18px; padding:0px 5px 2px 5px; color: #FFFFFF; font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; background-image:url(images/right_gorno_<?=$theme_color?>.png);"><img style="margin-top:2px;" src="images/google-title.png"> 
            <?php //include("inc/user_info.inc.php")?>		  
    </div>
</div>

<div style="float:left; background-color:#F7F7F7; margin-bottom:10px;">

	<div id="BANER-LEFT" align="justify" style="float:left; width:148px;  font-weight:normal; font-size:12px; color:#666666; padding:10px 0px 10px 0px;  border-left: 1px solid #999999;border-right: 1px solid #999999;">
	  <div style="float:left;margin:5px;">Google AddSense
	  </div>
	</div>
	
	
	<div style="float:left;"><img width="150" src="images/<?=$theme_color?>_bottom.png"></div>


</div>
