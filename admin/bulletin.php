<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.: оХБоли :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="http://ohboli.bg/css/NiftyLayout.css" media="screen">
</head>
<body style="width:700px;text-align:center;">

<div style="margin-bottom:10px;width:320px;float:left;color:#FFF;font-weight:bold;" align="center"><u>Статии</u></div>
<div style="margin-bottom:10px;width:320px;float:left;color:#FFF;font-weight:bold;" align="center"><u>Новини</u></div>

<div style="width:650px; float:left; background-color:#F1F1F1; text-align:left;">
<table><tr><td style="vertical-align: top;">
<?php

	include_once("inc/dblogin.inc.php");
	ini_set('max_execution_time', '5750');


	
	$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category = pc.id  AND p.active = '1'  ORDER BY p.date DESC LIMIT 10 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$Itm  = $conn->result;	
	$numItms = $conn->numberrows;

	for($i=0;$i<$numItms;$i++)
	{
	   if(is_file('../pics/posts/'.$Itm[$i]['picURL'])) $picFile= '../pics/posts/'.$Itm[$i]['picURL'];
	   else $picFile = '../pics/posts/no_photo_thumb.png';
	   		 
	
	   print '<div style="float:left;width:300px;font-size:12px;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'http://ohboli.bg/posts.php?postID='.$Itm[$i]['postID'].'\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
	   print '<table><tr>';
	   print '<td >';
	   print '<div style="float:left; border:double; border-color:#333333; height:35px; width:35px;" ><a href="posts.php?postID='.$Itm[$i]['postID'].'"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
	   print '<div style=" float:left; margin-left:10px; width:240px; color:#467B99; " >'.myTruncate($Itm[$i]['title'], 1000, " ").'</div>';
	   print '<div  style="float:left; background-image:url(http://ohboli.bg/images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:240px;color:#467B99; " ><i>'.$Itm[$i]['category'].'</i></div>';
	         			
	   print '</tr></table>';	            
	   print '</div>';

     
	}
   
	print "</td><td style='vertical-align: top;'>";
	
	
	$sql="SELECT n.newsID as 'newsID', SUM(ln.cnt) as 'cnt', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc, log_news ln WHERE n.news_category=nc.id AND ln.news_id=n.newsID AND n.active = '1' GROUP BY n.newsID ORDER BY n.date DESC LIMIT 10 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultNewsLast = $conn->result;
	$numNewsLast = $conn->numberrows;
	
	
	for($i=0;$i<$numNewsLast;$i++)
	{
	   if(is_file('../pics/news/'.$resultNewsLast[$i]['picURL'])) $picFile= '../pics/news/'.$resultNewsLast[$i]['picURL'];
	   else $picFile = '../pics/news/no_photo_thumb.png';
	   		 
	
	   print '<div style="float:left;width:300px;font-size:12px;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'http://ohboli.bg/news.php?newsID='.$resultNewsLast[$i]['newsID'].'\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
	   print '<table><tr>';
	   print '<td >';
	   print '<div style="float:left; border:double; border-color:#333333; height:35px; width:35px;" ><a href="http://ohboli.bg/news.php?newsID='.$resultNewsLast[$i]['newsID'].'"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
	   print '<div style=" float:left; margin-left:10px; width:240px; color:#467B99; " >'.myTruncate($resultNewsLast[$i]['title'], 1000, " ").'</div>';
	   print '<div  style="float:left; background-image:url(http://ohboli.bg/images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:240px;color:#467B99; " ><i>'.$resultNewsLast[$i]['category'].'</i></div>';
	         			
	   print '</tr></table>';	            
	   print '</div>';

     
	}
	
		
?>
</td></tr></table>
</div>
</body>