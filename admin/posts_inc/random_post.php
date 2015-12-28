<?php

include_once("../inc/dblogin.inc.php");



$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id ORDER BY rand() LIMIT 1";
$conn->setsql($sql);
$conn->getTableRow();
$resultPosts=$conn->result;
$numPosts=$conn->numberrows;
?>

<div style="float:left; margin-top:10px; margin-bottom:10px; width:500px;">
		<div style="float:right; margin-right:120px; width:400px; " align="right"><span style="color:#467B99"><i><u><?=$resultPosts['source'] ?></i></u></span></div>
	    <div style="float:left; margin-left:20px; width:420px; " align="left"><strong style="color:#FF8400"><?=$resultPosts['title'] ?></strong></div>
	    <div style="float:left; margin-left:0px; width:420px;">
		 <div style="float:left; margin-left:5px; padding:0px; width:520px; font-size: 14px; color: #467B99;" align="justify">
		  <table><tr>
			<td width="15px" bgcolor="#E7E7E7"></td>
			<td style="padding:10px;">
			 <div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
				<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultPosts['date'] ?></i></div></div>
				<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:10px;"><?=$resultPosts['category']?></div>
			</div>
			  <div  style="margin-top:5px; width:360px; overflow:hidden; ">
       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:250px; overflow:hidden; " ><img src="../pics/posts/<?=$resultPosts['picURL']?>" /></div>
	<?php print stripslashes($resultPosts['body']); ?>

		</tr></table>
   		  </div>
		   
	    </div>
	  </div>