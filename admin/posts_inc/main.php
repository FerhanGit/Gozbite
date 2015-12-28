<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left;height:56px; width:500px; padding-left:30px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:25px;margin-bottom:0px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Начало АДМИН</div>
      </div>
	<div id="whiteDIV" style="background-color:#F5F5F5;float:left;margin-left:20px;" >	 
<!-- Text na ARTICLE -->
        <div id="tabs" style="float:left; height:auto; padding:0px 20px 0px 20px; width:440px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" >
                 
          	<ul id="maintab" class="shadetabs">
					<li class="selected"><a href="posts_inc/random_post.php" rel="ajaxcontentarea">ТОП</a></li>
					<li ><a href="posts_inc/insert_post.php" rel="ajaxcontentarea">Добави</a></li>
					<li ><a href="posts_inc/import_form.php" rel="ajaxcontentarea">Импортирай</a></li>
					<?php  if ((isset($_REQUEST['edit'])) && ($_REQUEST['edit']!="")) print	'<li class="selected"><a href="posts_inc/post_edit.php" rel="ajaxcontentarea">Редактирай</a></li>'; ?>
	                <li ><a href="posts_inc/search_posts.php" rel="ajaxcontentarea">Търси</a></li>
	                <li ><a href="posts_inc/comment_edit.php" rel="ajaxcontentarea">Коментари</a></li>
	                <?php  if ((!empty($_REQUEST['postID'])) && (!isset($_REQUEST['search_btn']))){ print '<li class="selected"><a href="posts_inc/postBig.php" rel="ajaxcontentarea">Новина</a></li>'; log_post($_REQUEST['postID']);}?>
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

    
    
<div id="Main_Bottom" style="float:left; margin-top:0px; width:500px;">	  
	     <div id="ARTICLE_LIST" style="float:left; margin-left:0px;margin-top:5px; height:31px; padding-left:30px; padding-bottom:0px; background-image:url(images/h5.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:12px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Статии</div>
	     </div>
	 
	       
	<?php
	
	if ($numPosts==0) 
	{
	?>
		<div style="float:left; margin-top:10px; margin-bottom:10px; width:600px;">
	    <div style="float:left; margin-left:20px; width:200px; height:20px;" align="left"><strong style="color:#FF8400">Няма Резултат</strong></div>
	    <div style="float:left; margin-left:0px; width:600px;">
				   
	    </div>
	  </div>
	<?php  } 
	// ---- Paging START ------
else {
echo "<div class=\"paging\" style=\"background-color:lightblue;width:400px;margin: 10px 50px 10px 100px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&post_title=".$_REQUEST['post_title']."&post_category=".$_REQUEST['post_category']."&post_body=".$_REQUEST['post_body']."&post_source=".$_REQUEST['post_source']."&post_autor=".$_REQUEST['post_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&postID=".$resultPosts[$i]['postID'], "2");
?>

	  
	  
<?php if($numChildCats>0) 
{
?>		
	<div  style="background-color:lightblue;" align='center'>
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
	  for ($i=0;$i<$numPosts;$i++)
		{
	?>		
	 
	<div class="ofr_top" id="ofr_top<?=$i?>" style="width:500px; float:left; display:none;"> </div>
	
	<div id="OFFER<?=$i?>" class="offer" onMouseover="this.style.backgroundColor='lightblue';" onMouseout="this.style.backgroundColor='#FFFFFF';" style="float:left;background-color:#FFFFFF; width:500px;">
           <div  style="float:left; margin-left:20px; width:500px; " align="left"><strong style="color:#FF8400"><?=$resultPosts[$i]['title'] ?></strong></div>
                
                 <div style="float:left; margin-left:5px; padding:0px; width:460px; font-size: 14px; color: #467B99;" align="justify">
                  <table><tr>
					<td width="15px" bgcolor="#E7E7E7">
						<input  type = "checkbox" onclick=" if(this.checked) {document.getElementById('actDv').style.display='inline';} else {document.getElementById('actDv').style.display='none';}" id = "offerChck<?=$i?>" name = "offerChck[]" value = "1" style = "border: 0; vertical-align: middle;"/>
		            </td>
					<td style="padding:10px;">
					  <div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
						
					 	<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultPosts[$i]['date'] ?></i></div></div>
						
							<div style="float:right; margin-right:2px;" ><a href="?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&post_title=<?=$_REQUEST['post_title']?>&post_category=<?=$_REQUEST['post_category']?>&post_body=<?=$_REQUEST['post_body']?>&post_source=<?=$_REQUEST['post_source']?>&post_autor=<?=$_REQUEST['post_autor']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&postID=<?=$resultPosts[$i]['postID']?>"><img style="margin-left:5px;" src="images/big.png" width="14" height="14"></a></div>
							<div style="float:right; margin-right:2px;" ><a href="?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&post_title=<?=$_REQUEST['post_title']?>&post_category=<?=$_REQUEST['post_category']?>&post_body=<?=$_REQUEST['post_body']?>&post_source=<?=$_REQUEST['post_source']?>&post_autor=<?=$_REQUEST['post_autor']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&edit=<?=$resultPosts[$i]['postID']?>"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>
						
							<div style="float:right; margin-right:2px;" ><a onclick="if(!confirm('Сигурни ли сте?')) {return false;}" href="?page=<?=$_REQUEST['page']?>&orderby=<?=$_REQUEST['orderby']?>&post_title=<?=$_REQUEST['post_title']?>&post_category=<?=$_REQUEST['post_category']?>&post_body=<?=$_REQUEST['post_body']?>&post_source=<?=$_REQUEST['npost_source']?>&post_autor=<?=$_REQUEST['post_autor']?>&description=<?=$_REQUEST['description']?>&fromDate=<?=$_REQUEST['fromDate']?>&toDate=<?=$_REQUEST['toDate']?>&limit=<?=$_REQUEST['limit']?>&delete=<?=$resultPosts[$i]['postID']?>"><img style="margin-left:5px;" src="images/page_white_delete.png" alt="Изтрий" width="14" height="14"></a></div>
						
					<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultPosts[$i]['category']?></div>
					</div>
					  <div  style="margin-top:5px; width:410px; overflow:hidden; ">
		       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; height:80px; width:80px; overflow:hidden; " ><a href="edit_posts.php?<?php print "page=".$page."&orderby=".$_REQUEST['orderby']."&post_title=".$_REQUEST['post_title']."&post_category=".$_REQUEST['post_category']."&post_body=".$_REQUEST['post_body']."&post_source=".$_REQUEST['post_source']."&post_autor=".$_REQUEST['post_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&postID=".$resultPosts[$i]['postID'] ?>"><img  width="80" height="80" src="../pics/posts/<?php if($resultPosts[$i]['picURL']<>'') print $resultPosts[$i]['postID']."_thumb.jpg"; else print "no_photo_thumb.png";?>" /></a></div>
					
		       			<?php print stripslashes(str_replace($_REQUEST['post_body'],"<font color='red'><b>".$_REQUEST['post_body']."</b></font>",substr($resultPosts[$i]['body'],0,500)))."..."; ?>
			<div align="right"><a href="edit_posts.php?<?php print "page=".$page."&orderby=".$_REQUEST['orderby']."&post_title=".$_REQUEST['post_title']."&post_category=".$_REQUEST['post_category']."&post_body=".$_REQUEST['post_body']."&post_source=".$_REQUEST['post_source']."&post_autor=".$_REQUEST['post_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&postID=".$resultPosts[$i]['postID'] ?>">Още</а></div>
		
				</tr></table>
            	  </div>
            
       </div>    
   
	<div class="ofr_down" id="ofr_down<?=$i?>" style="width:500px; float:left; display:none;"></div>  
	<?php } ?>

		<!-- KRAI na ARTICLE LIST-->	   
		

<?php	

// ---- Paging START ------

echo "<div class=\"paging\" style=\"float:left;background-color:lightblue;width:470px;margin:10px 30px 20px 30px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
per_page("?page=%page&orderby=".$_REQUEST['orderby']."&post_title=".$_REQUEST['post_title']."&post_category=".$_REQUEST['post_category']."&post_body=".$_REQUEST['post_body']."&post_source=".$_REQUEST['post_source']."&post_autor=".$_REQUEST['post_autor']."&description=".$_REQUEST['description']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate']."&limit=".$_REQUEST['limit']."&postID=".$resultPosts[$i]['postID'], "2");
?>
</div> 
<?php }
?>
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
 	if ($_REQUEST['postID']>0) print 'expandtab("maintab", 2);';
	elseif (isset($_REQUEST['search_btn'])) print 'expandtab("maintab", 1);';
	else  print 'expandtab("maintab", 0);'; 
?>
 window.setInterval("effectF()", 20000);
}
);

	
</script>
        