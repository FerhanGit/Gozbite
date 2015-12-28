<?php

include_once("../inc/dblogin.inc.php");



	$sql="SELECT n.newsID as 'newsID', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc WHERE n.news_category=nc.id ORDER BY rand() LIMIT 1";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultNews=$conn->result;
	$numNews=$conn->numberrows;

	$sql="SELECT news_id, SUM(cnt) as 'cnt' FROM log_news WHERE news_id='".$resultNews['newsID']."' GROUP BY news_id";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultNewsCnt=$conn->result;
?>

<div style="float:left; margin-top:10px; margin-bottom:10px; width:420px;">
		<div style="float:right; margin-right:0px;margin-bottom:20px; width:400px; " align="right"><span style="color:#333333;"><i><u><?=$resultNews['source'] ?></i></u></span></div>
	    <div style="float:left; margin-left:20px;margin-bottom:10px; width:400px; " align="left"><strong style="color:#FF8400;"><?=$resultNews['title'] ?></strong></div>
	    <div style="float:left; margin-left:0px; width:420px;">
		 <div style="float:left; margin-left:5px; padding:0px; width:400px; font-size: 14px; color: #333333;" align="justify">
		  <table><tr>
			<td style="width:15px;" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
			<td style="padding:10px;">
			 <div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
				<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultNews['date'] ?></i></div></div>
				<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:10px;"><?=$resultNews['category']?></div>
			</div>
			  <div  style="margin-top:5px; width:420px; overflow:hidden; ">
       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:250px; overflow:hidden; " ><img src="../pics/news/<?=$resultNews['picURL']?>" /></div>
	<?php print stripslashes($resultNews['body']); ?>

		</tr></table>
   		  </div>
		   	
   		  <div style="float:right; margin-right:0px; margin-top:20px; width:420px; " align="right"><span style="color:#FF8400"><u>Прочетено <?=$resultNewsCnt['cnt']?$resultNewsCnt['cnt']:1 ?> пъти</u></span></div>
   		
	    </div>
	  </div>