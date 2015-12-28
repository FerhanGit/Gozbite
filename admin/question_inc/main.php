<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left;height:56px; width:460px; padding-left:30px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:25px;margin-bottom:0px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Начало АДМИН</div>
      </div>
      
      <div id="whiteDIV" style="background-color:#F5F5F5;float:left;margin-left:10px;width:490px;" >	</div> 
    <!-- Text na ARTICLE -->
        <div id="tabs2" style="float:left; height:auto; margin:0px 0px 0px 10px; padding-left:10px; width:480px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" >
                          
           <?php
				include("question_inc/search_question.php");
			?>
		      <hr style="float:left; margin-left:0px; width:470px;">
        </div>	<!-- KRAI na tabs -->
        
        
         <div id="tabs" style="float:left; height:auto; margin:0px 0px 0px 10px; padding-left:10px; width:480px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" >
                          
              <?php
									
					if ((isset($_REQUEST['questionID'])) && ($_REQUEST['questionID']>0) && (!isset($_REQUEST['search_btn']))) 
					{
						include("question_inc/questionBig.php");
						log_question($_REQUEST['questionID']);
						?>
							<script>
								$('tabs').scrollTo();							 
							</script>
						<?
					}
					
					
					
					else 
					{
						
						include("question_inc/insert_question.php");
						?>
							<script>
								$('tabs').scrollTo();							 
							</script>
						<?
						
					}
					
					
					?>
			 
			
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na tabs -->
     
      <div id="Main_Top_Bottom" style="background-color:#F5F5F5;float:left;margin-left:10px; padding-top:10px;width:490px;" >	 </div>
     
</div>	<!-- KRAI na Main_Top -->

    
    
<div id="Main_Bottom" style="float:left; margin-top:40px; width:500px;">	  
<?if($numQuestionMain){?>	 	     <div id="ARTICLE_LIST" style="float:left; margin-left:0px;margin-top:5px; height:31px; padding-left:30px; padding-bottom:0px; background-image:url(images/h5.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:12px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Новини</div>
	     </div>
<?}?>	 
	       
	<?php
if ((isset($_REQUEST['search_btn'])) or (isset($page))  or $pageName == 'forum')
{	
	if ($numQuestionMain==0) 
	{
	?>
		<div style="float:left; margin-top:10px; margin-bottom:10px; width:500px;">
	    <div style="float:left; margin-left:20px; width:200px; height:20px;" align="left"><strong style="color:#FF8400">Няма Въпроси <?php if(isset($_REQUEST['bolest_category']) or isset($_REQUEST['category'])) {print ' от категория '.get_question_category($_REQUEST['question_category']?$_REQUEST['question_category']:$_REQUEST['category']);}?></strong></div>
	    <div style="float:left; margin-left:0px; width:500px;">
				   
	    </div>
	  </div>
	<?php  } 
	// ---- Paging START ------
else {
echo "<div class=\"paging\" style=\"background-color:lightblue;width:300px;margin: 10px 50px 10px 100px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&category=".$_REQUEST['category']."&question_body=".$_REQUEST['question_body']."&question_body=".$_REQUEST['question_body']."&sender_name=".$_REQUEST['sender_name']."&sender_email=".$_REQUEST['sender_email']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&questionID=".$resultQuestionMain[$i]['questionID'], "2");
?>

</div> 
<!-- Paging END -->

	  
	  <!-- ARTICLES LIST -->	  
	<?php
	  for ($i=0;$i<$numQuestionMain;$i++)
		{
	?>		
	 
	
	<div id="OFFER<?=$i?>" class="offer" onMouseover="this.style.backgroundColor='lightblue';" onmouseout="this.style.backgroundColor='#FFFFFF';"
         onMouseout="this.style.backgroundColor='#FFFFFF';" style="float:left;background-color:#FFFFFF; width:500px;">
                <div  style="float:left; margin-left:20px; width:460px; " align="left"><strong style="color:#FF8400"><?=$resultQuestionMain[$i]['sender_name'] ?></strong></div>
                
                 <div style="float:left; margin-left:5px; padding:0px; width:460px; font-size: 14px; color: #333333;" align="justify">
                  <table><tr>
					<td width="15px" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
					<td style="padding:10px;">
					 <div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
						
					 	<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultQuestionMain[$i]['created_on'] ?></i></div></div>
						<?php if($pageName=='forum') {?>		
							<div style="float:right; margin-right:2px;" ><a href="?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&category=<?=$_REQUEST['category']?>&question_body=<?=$_REQUEST['question_body']?>&sender_name=<?=$_REQUEST['sender_name']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&edit=<?=$resultQuestionMain[$i]['questionID']?>"><img style="margin-left:5px;" src="images/replay.png" alt="Напиши твоето мнение по този въпрос" title="Напиши твоето мнение по този въпрос" width="20" height="20"></a></div>
						<?php } ?>
					<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultQuestionMain[$i]['category']?></div>
					</div>
					  <div  style="margin-top:5px; width:410px; overflow:hidden; ">
		       			
		       			<?php print stripslashes(str_replace($_REQUEST['question_body'],"<font color='red'><b>".$_REQUEST['question_body']."</b></font>",substr($resultQuestionMain[$i]['question_body'],0,2000)))."..."; ?>
			<div align="right"><a href="?<?php print "page=".$page."&orderby=".$_REQUEST['orderby']."&category=".$_REQUEST['category']."&question_body=".$_REQUEST['question_body']."&sender_name=".$_REQUEST['sender_name']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&questionID=".$resultQuestionMain[$i]['questionID'] ?>">Виж целия текст</а></div>
		
				</tr></table>
            	  </div>
            
       </div>    
   
	<?php } ?>

		<!-- KRAI na ARTICLE LIST-->	   
		

<?php	

// ---- Paging START ------

echo "<div class=\"paging\" style=\"float:left;background-color:lightblue;width:340px;margin:10px 30px 20px 30px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&category=".$_REQUEST['category']."&question_body=".$_REQUEST['question_body']."&question_body=".$_REQUEST['question_body']."&sender_name=".$_REQUEST['sender_name']."&sender_email=".$_REQUEST['sender_email']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&questionID=".$resultQuestionMain[$i]['questionID'], "2");
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
Rounded("div.questionDIVContainer","all","#FFF","lightblue");
Rounded("div.questionButton","tr bl","#FFF","#E2E2E2","big");
Rounded("div.last_posts","tr bl","#F5F5F5","#E7E7E7","big");

<?php
 	if ($_REQUEST['questionID']>0) print 'expandtab("maintab", 2);$("maintab").scrollTo();';
	elseif (isset($_REQUEST['search_btn'])) print 'expandtab("maintab", 1);';
	else  print 'expandtab("maintab", 0);'; 
?>
 window.setInterval("effectF()", 20000);
}
);

	
</script>
        