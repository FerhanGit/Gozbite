<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left;height:56px; width:460px; padding-left:30px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:25px;margin-bottom:0px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Начало АДМИН</div>
      </div>
      
      <div id="whiteDIV" style="background-color:#F5F5F5;float:left;margin-left:10px;width:490px;" >	</div> 
    <!-- Text na ARTICLE -->
        <div id="tabs2" style="float:left; height:auto; margin:0px 0px 0px 10px; padding-left:10px; width:480px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" >

        <div id="ActiveSurveyDiv" align='center'>
		<br />
		В момента е активна Анкетата
		<select style="width:300px;" name="ActiveSurvey" id="ActiveSurvey" onchange="setActive(this);">
			<option value="">Анкети...</option>
			<?php	
			   $sql="SELECT s.ID as 'surveyID', s.active as 'active', s.start_date as 'start_date', s.end_date as 'end_date', s.body as 'survey_body' FROM surveys s WHERE 1=1 $and ORDER BY s.start_date DESC";
			   $conn->setsql($sql);
			   $conn->getTableRows();
	 		   $resultActive=$conn->result;
	           $numActive=$conn->numberrows;		
			   for($cc=0;$cc<$numActive;$cc++)
			   {?>
					<option value="<?=$resultActive[$cc]['surveyID']?>" <?=($resultActive[$cc]['active']==1)?'selected':''?>><?=$resultActive[$cc]['survey_body']?></option>
			<? } ?>						
					</select>                			
	
		</div>
	          
           <?php
				include("surveys_inc/search_survey.php");
			?>
		      <hr style="float:left; margin-left:0px; width:470px;">
        </div>	<!-- KRAI na tabs -->
        
        
         <div id="tabs" style="float:left; height:auto; margin:0px 0px 0px 10px; padding-left:10px; width:480px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" >
                          
              <?php
									
					if ((isset($_REQUEST['surveyID'])) && ($_REQUEST['surveyID']>0) && (!isset($_REQUEST['search_btn']))) 
					{
						include("surveys_inc/surveyBig.php");
						//log_question($_REQUEST['surveyID']);
						?>
							<script>
								//$('tabs').scrollTo();							 
							</script>
						<?
					}
					
					
					
					else 
					{
						
						include("surveys_inc/insert_survey.php");
						?>
							<script>
								//$('tabs').scrollTo();							 
							</script>
						<?
						
					}
					
					
					?>
			 
			
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na tabs -->
     
      <div id="Main_Top_Bottom" style="background-color:#F5F5F5;float:left;margin-left:10px; padding-top:10px;width:490px;" >	 </div>
     
</div>	<!-- KRAI na Main_Top -->

    
    
<div id="Main_Bottom" style="float:left; margin-top:40px; width:500px;">	  
<?if($numSurveysMain){?>	 	     <div id="ARTICLE_LIST" style="float:left; margin-left:0px;margin-top:5px; height:31px; padding-left:30px; padding-bottom:0px; background-image:url(images/h5.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:12px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Новини</div>
	     </div>
<?}?>	 
	       
	<?php
if ((isset($_REQUEST['search_btn'])) or (isset($page))  or $pageName == 'surveys')
{	
	if ($numSurveysMain==0) 
	{
	?>
		<div style="float:left; margin-top:10px; margin-bottom:10px; width:500px;">
	    <div style="float:left; margin-left:20px; width:200px; height:20px;" align="left"><strong style="color:#FF8400">Няма Анкети</strong></div>
	    <div style="float:left; margin-left:0px; width:500px;">
				   
	    </div>
	  </div>
	<?php  } 
	// ---- Paging START ------
else {
echo "<div class=\"paging\" style=\"background-color:lightblue;width:300px;margin: 10px 50px 10px 100px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&surveyID=".$resultSurveysMain[$i]['surveyID'], "2");
?>

</div> 
<!-- Paging END -->

	  
	  <!-- ARTICLES LIST -->	  
	<?php
	  for ($i=0;$i<$numSurveysMain;$i++)
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
						<div style="float:left; margin-left:2px;width:150px;font-size:11px;"><div style="float:left; color:#FFFFFF; "><i>От <?=convert_Month_to_Cyr(date("j F Y",strtotime($resultSurveysMain[$i]['start_date']))) ?></i></div></div>
            			<div style="float:right; color:#000000; margin-right:2px;font-size:11px;"><i>До <?=convert_Month_to_Cyr(date("j F Y",strtotime($resultSurveysMain[$i]['end_date'])))  ?></i></div>						
					<?php if($pageName=='surveys') {?>		
							<div style="float:right; margin-right:2px;width:20px;" ><a href="?page=<?=$_REQUEST['page']."&orderby=".$_REQUEST['orderby']."&survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&edit=".$resultSurveysMain[$i]['surveyID']?>"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>
							<div style="float:right; margin-right:2px;width:20px;" ><a onclick="if(!confirm('Сигурни ли сте?')){return false;}" href="?page=<?=$_REQUEST['page']."&orderby=".$_REQUEST['orderby']."&survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&delete=".$resultSurveysMain[$i]['surveyID']?>"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>
						<?php } ?>
					</div>
					  <div  style="margin-top:5px; width:410px; overflow:hidden; ">
		       			      			<?php print stripslashes(str_replace($_REQUEST['survey_body'],"<font color='red'><b>".$_REQUEST['survey_body']."</b></font>",substr($resultSurveysMain[$i]['survey_body'],0,200)))."..."; ?>
		       		  </div>
		       		 
			<div align="right"><a href="?<?php print "page=".$page."&orderby=".$_REQUEST['orderby']."&survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&surveyID=".$resultSurveysMain[$i]['surveyID'] ?>">Виж целия текст</а></div>
		 			
				</tr></table>
            	  </div>
            
       </div>    
   
	<?php } ?>

		<!-- KRAI na ARTICLE LIST-->	   
		

<?php	

// ---- Paging START ------

echo "<div class=\"paging\" style=\"float:left;background-color:lightblue;width:340px;margin:10px 30px 20px 30px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&surveyID=".$resultSurveysMain[$i]['surveyID'], "2");
?>
</div> 
<?php }
}?>
	</div>	
	<!-- KRAI na Main_Bottom -->
<script type="text/javascript">

function effectF()
{
	//new Effect.Shake('ajaxcontentarea');
}

Event.observe(window, 'load', function() { 	   
Rounded("div.ofr_top","tl","#FFF","lightblue");
Rounded("div.ofr_down","bl br","#FFF","lightblue");
Rounded("div.paging","all","#FFF","lightblue");
Rounded("div.surveyDIVContainer","all","#FFF","lightblue");
Rounded("div.surveyButton","tr bl","#FFF","#E2E2E2","big");
Rounded("div.last_posts","tr bl","#F5F5F5","#E7E7E7","big");


 window.setInterval("effectF()", 20000);
}
);

	
</script>
        