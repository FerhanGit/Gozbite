<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left;height:56px; width:460px; padding-left:30px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:25px;margin-bottom:0px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Начало АДМИН</div>
      </div>
      
      <div id="whiteDIV" style="background-color:#F5F5F5;float:left;margin-left:10px;width:490px;" >	</div> 
    <!-- Text na ARTICLE -->
        <div id="tabs" style="float:left; height:auto; margin:0px 0px 0px 10px; padding-left:10px; width:480px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" >
                          
            <?php

            	$pageName = $_SERVER['SCRIPT_NAME'];
            
            	if(eregi('firms',$pageName)) $q = 'firms';
            	elseif(eregi('offers',$pageName)) $q = 'offers';
            	elseif(eregi('trips',$pageName)) $q = 'trips';
            	elseif(eregi('hotels',$pageName)) $q = 'hotels';
            	elseif(eregi('news',$pageName)) $q = 'news';
            	elseif(eregi('posts',$pageName)) $q = 'posts';
           		else  $q = 'news';
            
            ?>
			 
			 <ul id="maintab" class="shadetabs">
		  		    <li><a href="target_links_inc/insert_target_link_<?=$q?>.php" rel="ajaxcontentarea">Таргет Връзка</a></li>	
					
	              </ul>
            <div id="ajaxcontentarea" class="contentstyle" style="float:left; height:auto; width:460px;"></div>    
            
    <script type="text/javascript">
            //Start Ajax tabs script for UL with id="maintab" Separate multiple ids each with a comma.
            startajaxtabs("maintab")
    </script>		 
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na tabs -->
     
      <div id="Main_Top_Bottom" style="background-color:#F5F5F5;float:left;margin-left:10px; padding-top:10px;width:490px;" >	 </div>
     
</div>	<!-- KRAI na Main_Top -->

    
    
<div id="Main_Bottom" style="float:left; margin-top:40px; width:500px;">	  
<?if($numNews){?>	 	     <div id="ARTICLE_LIST" style="float:left; margin-left:0px;margin-top:5px; height:31px; padding-left:30px; padding-bottom:0px; background-image:url(images/h5.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:12px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Новини</div>
	     </div>
<?}?>	 
	       
	<?php
if ((isset($_REQUEST['search_btn'])) or (isset($page))  or $pageName == 'edit_firms')
{	
	if ($numNews==0) 
	{
	?>
		<div style="float:left; margin-top:10px; margin-bottom:10px; width:500px;">
	    <div style="float:left; margin-left:20px; width:200px; height:20px;" align="left"><strong style="color:#FF8400">Няма Новини</strong></div>
	    <div style="float:left; margin-left:0px; width:500px;">
				   
	    </div>
	  </div>
	<?php  } 
	// ---- Paging START ------
else {
echo "<div class=\"paging\" style=\"background-color:lightblue;width:300px;margin: 10px 50px 10px 100px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&news_title=".$_REQUEST['news_title']."&news_category=".$_REQUEST['news_category']."&news_body=".$_REQUEST['news_body']."&nеws_source=".$_REQUEST['nеws_source']."&news_autor=".$_REQUEST['news_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&newsID=".$resultNews[$i]['newsID'], "2");
?>

	  
<div  style="background-color:lightblue;" align='center'>
<a onclick=" document.getElementById('actDv').style.display='inline';" href="javascript:selectAllQuarters(true)">избери всички</a> | <a onclick="document.getElementById('actDv').style.display='none';" href="javascript:selectAllQuarters(false)">откажи всички</a>
	<div id="actDv" style="display:none;">
		<br />
		<select style="width:100px;" name="ToDo" id="ToDo" onchange="jumpBlank(this);document.itemform.submit();">
			<option value="">Избери</option>
			<option value="del">Изтрий</option>
			<option value="Send_to_friend">Прати на приятел</option>
			<option value="save">Запиши в бележника</option>			
		</select>                			
	</div>	
</div>

</div> 
<!-- Paging END -->

	  
	  <!-- ARTICLES LIST -->	  
	<?php
	  for ($i=0;$i<$numNews;$i++)
		{
	?>		
	 
	
	<div id="OFFER<?=$i?>" class="offer" onMouseover="this.style.backgroundColor='lightblue';" onmouseout="this.style.backgroundColor='#FFFFFF';"
         onMouseout="this.style.backgroundColor='#FFFFFF';" style="float:left;background-color:#FFFFFF; width:500px;">
                <div  style="float:left; margin-left:20px; width:460px; " align="left"><strong style="color:#FF8400"><?=$resultNews[$i]['title'] ?></strong></div>
                
                 <div style="float:left; margin-left:5px; padding:0px; width:460px; font-size: 14px; color: #333333;" align="justify">
                  <table><tr>
					<td width="15px" bgcolor="#E7E7E7">
						<input  type = "checkbox" onclick=" if(this.checked) {document.getElementById('actDv').style.display='inline';} else {document.getElementById('actDv').style.display='none';}" id = "offerChck<?=$i?>" name = "offerChck[]" value = "1" style = "border: 0; vertical-align: middle;"/>
		            </td>
					<td style="padding:10px;">
					 <div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:245px; background-repeat:no-repeat; font-size:12px; color:#000000;">
						
					 	<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultNews[$i]['date'] ?></i></div></div>
						<?php if($pageName!='edit_news') {?>		
							<div style="float:right; margin-right:2px;" ><a href="?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&news_title=<?=$_REQUEST['news_title']?>&news_category=<?=$_REQUEST['news_category']?>&news_body=<?=$_REQUEST['news_body']?>&nеws_source=<?=$_REQUEST['nеws_source']?>&news_autor=<?=$_REQUEST['news_autor']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&sendToFriend=<?=$resultNews[$i]['newsID']?>"><img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a></div>
					<?php }else { ?>
							<div style="float:right; margin-right:2px;" ><a href="?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&news_title=<?=$_REQUEST['news_title']?>&news_category=<?=$_REQUEST['news_category']?>&news_body=<?=$_REQUEST['news_body']?>&nеws_source=<?=$_REQUEST['nеws_source']?>&news_autor=<?=$_REQUEST['news_autor']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&doctorID=<?=$resultNews[$i]['newsID']?>"><img style="margin-left:5px;" src="images/big.png" width="14" height="14"></a></div>
							<div style="float:right; margin-right:2px;" ><a href="?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&news_title=<?=$_REQUEST['news_title']?>&news_category=<?=$_REQUEST['news_category']?>&news_body=<?=$_REQUEST['news_body']?>&nеws_source=<?=$_REQUEST['nеws_source']?>&news_autor=<?=$_REQUEST['news_autor']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&edit=<?=$resultNews[$i]['newsID']?>"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>
					<?php } ?>
					<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultNews[$i]['category']?></div>
					</div>
					  <div  style="margin-top:5px; width:410px; overflow:hidden; ">
		       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; height:80px; width:80px; overflow:hidden; " ><a href="news.php?<?php print "page=".$page."&orderby=".$_REQUEST['orderby']."&news_title=".$_REQUEST['news_title']."&news_category=".$_REQUEST['news_category']."&news_body=".$_REQUEST['news_body']."&nеws_source=".$_REQUEST['nеws_source']."&news_autor=".$_REQUEST['news_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&newsID=".$resultNews[$i]['newsID'] ?>"><img  width="80" height="80" src="pics/news/<?php if($resultNews[$i]['picURL']<>'') print $resultNews[$i]['newsID']."_thumb.jpg"; else print "no_photo_thumb.png";?>" /></a></div>
					
		       			<?php print stripslashes(str_replace($_REQUEST['news_body'],"<font color='red'><b>".$_REQUEST['news_body']."</b></font>",substr($resultNews[$i]['body'],0,500)))."..."; ?>
			<div align="right"><a href="news.php?<?php print "page=".$page."&orderby=".$_REQUEST['orderby']."&news_title=".$_REQUEST['news_title']."&news_category=".$_REQUEST['news_category']."&news_body=".$_REQUEST['news_body']."&nеws_source=".$_REQUEST['nеws_source']."&news_autor=".$_REQUEST['news_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&newsID=".$resultNews[$i]['newsID'] ?>">Още</а></div>
		
				</tr></table>
            	  </div>
            
       </div>    
   
	<?php } ?>

		<!-- KRAI na ARTICLE LIST-->	   
		

<?php	

// ---- Paging START ------

echo "<div class=\"paging\" style=\"float:left;background-color:lightblue;width:340px;margin:10px 30px 20px 30px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&news_title=".$_REQUEST['news_title']."&news_category=".$_REQUEST['news_category']."&news_body=".$_REQUEST['news_body']."&nеws_source=".$_REQUEST['nеws_source']."&news_autor=".$_REQUEST['news_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&newsID=".$resultNews[$i]['newsID'], "2");
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
Rounded("div.newsDIVContainer","all","#FFF","lightblue");
Rounded("div.newsButton","tr bl","#FFF","#E2E2E2","big");
Rounded("div.last_posts","tr bl","#F5F5F5","#E7E7E7","big");

<?php
 	if ($_REQUEST['newsID']>0) print 'expandtab("maintab", 2);$("maintab").scrollTo();';
	elseif (isset($_REQUEST['search_btn'])) print 'expandtab("maintab", 1);';
	else  print 'expandtab("maintab", 0);'; 
?>
 window.setInterval("effectF()", 20000);
}
);

	
</script>
        