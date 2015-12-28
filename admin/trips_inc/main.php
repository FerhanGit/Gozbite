<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left;height:56px; width:500px; padding-left:30px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:25px;margin-bottom:0px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Начало АДМИН</div>
      </div>
	<div id="whiteDIV" style="background-color:#F5F5F5;float:left;margin-left:20px;" >	 
<!-- Text na ARTICLE -->
        <div id="tabs" style="float:left; height:auto; padding:0px 20px 0px 20px; width:440px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" >
                 
          	<ul id="maintab" class="shadetabs">
					<li class="selected"><a href="bolesti_inc/random_bolesti.php" rel="ajaxcontentarea">ТОП</a></li>
					<li ><a href="bolesti_inc/bolesti_edit.php" rel="ajaxcontentarea">Добави</a></li>
					<?php  if ((isset($_REQUEST['edit'])) && ($_REQUEST['edit']!="")) print	'<li class="selected"><a href="bolesti_inc/bolesti_edit.php" rel="ajaxcontentarea">Редактирай</a></li>'; ?>
	                <li ><a href="bolesti_inc/search_bolesti.php" rel="ajaxcontentarea">Търси</a></li>
	                <li ><a href="bolesti_inc/comment_edit.php" rel="ajaxcontentarea">Коментари</a></li>
	                <?php  if ((!empty($_REQUEST['bolestID'])) && (!isset($_REQUEST['search_btn']))){ print '<li class="selected"><a href="bolesti_inc/bolestBig.php" rel="ajaxcontentarea">Болест</a></li>'; }?>
	        </ul>       
	         
           <div id="ajaxcontentarea" class="contentstyle" ></div>    
            
    <script type="text/javascript">
            //Start Ajax tabs script for UL with id="maintab" Separate multiple ids each with a comma.
            startajaxtabs("maintab")
    </script>		 
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na ARTICLE -->
      </div>
      <div id="Main_Top_Bottom" style="background-color:#F5F5F5;float:left;margin-left:20px;width:480px;" >	 
      </div>
</div>	<!-- KRAI na Main_Top -->

    
    
<div id="Main_Bottom" style="float:left; margin-top:40px; width:500px;">	  
<?if($numBolesti){?>	 	     <div id="ARTICLE_LIST" style="float:left; margin-left:0px;margin-top:5px; height:31px; padding-left:30px; padding-bottom:0px; background-image:url(images/h5.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:12px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Болести</div>
	     </div>
<?}?>	 
	       
	<?php
if ((isset($_REQUEST['search_btn'])) or (isset($page)) or $pageName == 'edit_bolesti')
{	
	if ($numBolesti==0) 
	{
	?>
		<div style="float:left; margin-top:10px; margin-bottom:10px; width:500px;">
	    <div style="float:left; margin-left:20px; margin-right:20px; width:200px; height:20px;" align="left"><strong style="color:#FF8400">Няма Болести</strong></div>
	    <div style="float:left; margin-left:0px; width:500px;">
				   
	    </div>
	  </div>
	<?php  } 
	// ---- Paging START ------
else {
echo "<div class=\"paging\" style=\"background-color:#FDC8B9;width:300px;margin: 10px 50px 10px 100px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&bolest_title=".$_REQUEST['bolest_title']."&bolest_category=".$_REQUEST['bolest_category']."&bolest_simptom=".(is_array($_REQUEST['bolest_simptom'])?implode(',',$_REQUEST['bolest_simptom']):$_REQUEST['bolest_simptom'])."&bolest_body=".$_REQUEST['bolest_body']."&nеws_source=".$_REQUEST['nеws_source']."&bolest_autor=".$_REQUEST['bolest_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&bolestID=".$resultBolesti[$i]['bolestID'], "2");
?>

	  
  
	  
<?php if($numChildCats>0) 
{
?>		
	<div  style="background-color:#FDC8B9;" align='center'>
		<br />
		<select style="width:200px;" name="category" id="category" onchange="jumpBlank(this);">
			<option value="">Подкатегория..</option>
<?php			
   for($cc=0;$cc<$numChildCats;$cc++)
   {?>
		<option value="<?=$resultChildCats[$cc]['id']?>"><?=$resultChildCats[$cc]['name']?></option>
<? } ?>						
		</select>                			
	
	</div>
<? } ?>

</div> 
<!-- Paging END -->

	  
	  <!-- ARTICLES LIST -->	  
	<?php
	  for ($i=0;$i<$numBolesti;$i++)
		{
			if ($resultBolesti[$i]['has_pic']=='1')
			{
				$sql="SELECT * FROM bolesti_pics WHERE bolestID='".$resultBolesti[$i]['bolestID']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultPicsMain[$i]=$conn->result;
				$numPicsMain[$i]=$conn->numberrows;
			}
	?>		
	 
	
	<div id="OFFER<?=$i?>" class="offer" onMouseover="this.style.backgroundColor='#FDC8B9';" onMouseout="this.style.backgroundColor='#FFFFFF';"
         onMouseout="this.style.backgroundColor='#FFFFFF';" style="float:left;background-color:#FFFFFF; width:500px;">
                <div  style="float:left; margin-left:20px; width:460px; " align="left"><strong style="color:#FF8400"><?=$resultBolesti[$i]['title'] ?></strong></div>
                
                 <div style="float:left; margin-left:5px; padding:0px; width:460px; font-size: 14px; color: #333333;" align="justify">
                  <table><tr>
					<td width="15px" bgcolor="#E7E7E7">
						<input  type = "checkbox" onclick=" if(this.checked) {document.getElementById('actDv').style.display='inline';} else {document.getElementById('actDv').style.display='none';}" id = "offerChck<?=$i?>" name = "offerChck[]" value = "1" style = "border: 0; vertical-align: middle;"/>
		            </td>
					<td style="padding:10px;">

										
					 <div style="float:left;background-image:url(images/fon_header_green.png); margin-left:0px;margin-bottom:5px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
							<div style=" float:left; margin-left:6px; width:150px;color:#FFFFFF;font-weight:bold;" ><?=$resultBolesti[$i]['date']?></div>
					
							<div style="float:right; margin-right:5px;" ><a href="edit_bolesti.php?page=<?=$page."&orderby=".$_REQUEST['orderby']."&bolest_title=".$_REQUEST['bolest_title']."&bolest_category=".$_REQUEST['bolest_category']."&bolest_simptom=".(is_array($_REQUEST['bolest_simptom'])?implode(',',$_REQUEST['bolest_simptom']):$_REQUEST['bolest_simptom'])."&bolest_body=".$_REQUEST['bolest_body']."&bolest_source=".$_REQUEST['bolest_source']."&bolest_autor=".$_REQUEST['bolest_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&edit=".$resultBolesti[$i]['bolestID']?>"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>
					
							<div style="float:right; margin-right:5px;" ><a href="edit_bolesti.php?page=<?=$page."&orderby=".$_REQUEST['orderby']."&bolest_title=".$_REQUEST['bolest_title']."&bolest_category=".$_REQUEST['bolest_category']."&bolest_simptom=".(is_array($_REQUEST['bolest_simptom'])?implode(',',$_REQUEST['bolest_simptom']):$_REQUEST['bolest_simptom'])."&bolest_body=".$_REQUEST['bolest_body']."&bolest_source=".$_REQUEST['bolest_source']."&bolest_autor=".$_REQUEST['bolest_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&bolestID=".$resultBolesti[$i]['bolestID']?>"><img style="margin-left:5px;" src="images/big.png" width="14" height="14"></a></div>
							<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm('Сигурни ли сте?')){return false;}" href="?page=<?=$page."&orderby=".$_REQUEST['orderby']."&bolest_title=".$_REQUEST['bolest_title']."&bolest_category=".$_REQUEST['bolest_category']."&bolest_simptom=".(is_array($_REQUEST['bolest_simptom'])?implode(',',$_REQUEST['bolest_simptom']):$_REQUEST['bolest_simptom'])."&bolest_body=".$_REQUEST['bolest_body']."&bolest_source=".$_REQUEST['bolest_source']."&bolest_autor=".$_REQUEST['bolest_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&delete=".$resultBolesti[$i]['bolestID']?>"><img style="margin-left:5px;" src="images/page_white_delete.png" alt="Изтрий" width="14" height="14"></a></div>
										    
					</div>
														
								
					  <div  style="float:left;margin-top:5px; width:460px; overflow:hidden; ">
		       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; height:80px; width:80px; overflow:hidden; " ><a  href="edit_bolesti.php?<?php print "page=".$page."&orderby=".$_REQUEST['orderby']."&bolest_title=".$_REQUEST['bolest_title']."&bolest_category=".$_REQUEST['bolest_category']."&bolest_simptom=".(is_array($_REQUEST['bolest_simptom'])?implode(',',$_REQUEST['bolest_simptom']):$_REQUEST['bolest_simptom'])."&bolest_body=".$_REQUEST['bolest_body']."&bolest_source=".$_REQUEST['bolest_source']."&bolest_autor=".$_REQUEST['bolest_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&bolestID=".$resultBolesti[$i]['bolestID'] ?>"><img width="80" height="80" src="../pics/bolesti/<?php if($numPicsMain[$i] > 0) print $resultPicsMain[$i][0]['url_thumb']; else print "no_photo_thumb.png";?>"/></a></div>
					
		       			
		       			<?php

		       					if ($numBolestCats[$i]>0) 
								{
									print " <b style='color: #FF0000;'>Категория:</b> <span>"; 
								
									for($z=0;$z<$numBolestCats[$i];$z++)
									{
										print $resultBolestCats[$i][$z]['bolest_category_name']."; "; 
									}
									print "</span><br />";
								}
								
								if ($numBolestSimptoms[$i]>0) 
								{
									print " <b style='color: #FF0000;'>Симптоми:</b> <span>"; 
								
									for($z=0;$z<$numBolestSimptoms[$i];$z++)
									{
										print $resultBolestSimptoms[$i][$z]['bolest_simptom_name']."; "; 
									}
									print "</span><br />";
								}
								
							 print "<b style='color: #FF0000;'>Подробности:</b> ";
		       			print stripslashes(str_replace($_REQUEST['bolest_body'],"<font color='red'><b>".$_REQUEST['bolest_body']."</b></font>",substr($resultBolesti[$i]['body'],0,300)))."..."; ?>
			<div align="right"><a href="edit_bolesti.php?<?php print "page=".$page."&orderby=".$_REQUEST['orderby']."&bolest_title=".$_REQUEST['bolest_title']."&bolest_category=".$_REQUEST['bolest_category']."&bolest_simptom=".(is_array($_REQUEST['bolest_simptom'])?implode(',',$_REQUEST['bolest_simptom']):$_REQUEST['bolest_simptom'])."&bolest_body=".$_REQUEST['bolest_body']."&bolest_source=".$_REQUEST['bolest_source']."&bolest_autor=".$_REQUEST['bolest_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&bolestID=".$resultBolesti[$i]['bolestID'] ?>">Още</а></div>
		
				</td></tr></table>
            	  </div>
            
       </div>    
   
	<?php } ?>

		<!-- KRAI na ARTICLE LIST-->	   
		

<?php	

// ---- Paging START ------

echo "<div class=\"paging\" style=\"float:left;background-color:#FDC8B9;width:340px;margin:10px 30px 20px 30px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&bolest_title=".$_REQUEST['bolest_title']."&bolest_category=".$_REQUEST['bolest_category']."&bolest_simptom=".(is_array($_REQUEST['bolest_simptom'])?implode(',',$_REQUEST['bolest_simptom']):$_REQUEST['bolest_simptom'])."&bolest_body=".$_REQUEST['bolest_body']."&bolest_source=".$_REQUEST['bolest_source']."&bolest_autor=".$_REQUEST['bolest_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&bolestID=".$resultBolesti[$i]['bolestID'], "2");
?>
</div> 
<?php }
} ?>
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
Rounded("div.paging","all","#FFF","#FDC8B9");
Rounded("div.newsDIVContainer","all","#FFF","#FDC8B9");
Rounded("div.newsButton","tr bl","#FFF","#E2E2E2","big");
Rounded("div.last_posts","tr bl","#F5F5F5","#E7E7E7","big");


<?php
 	if ($_REQUEST['bolestID']>0) print 'expandtab("maintab", 2);$("maintab").scrollTo();';
	elseif (isset($_REQUEST['search_btn'])) print 'expandtab("maintab", 1);';
	else  print 'expandtab("maintab", 0);'; 
?>
 window.setInterval("effectF()", 20000);
}
);

	
</script>
        