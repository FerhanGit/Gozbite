<?php
  
   require_once("../inc/dblogin.inc.php");
   

 
   
    $response = '';
  
	$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id ORDER BY p.date DESC LIMIT 5 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$Itm  = $conn->result;	
	$numItms = $conn->numberrows;

	for($i=0;$i<$numItms;$i++)
	{
	   if(is_file('../../pics/posts/'.$Itm[$i]['picURL'])) $picFile= '../pics/posts/'.$Itm[$i]['picURL'];
	   else $picFile = '../pics/posts/no_photo_thumb.png';
	   		 
	
	   $response .=	'<div style="float:left;width:320px;font-size:11px;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'posts.php?postID='.$Itm[$i]['postID'].'\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
	   $response .= '<table><tr>';
	   $response .= '<td >';
	   $response .= '<div style="float:left; border:double; border-color:#333333; height:35px; width:35px;" ><a href="posts.php?postID='.$Itm[$i]['postID'].'"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
	   $response .= '<div style=" float:left; margin-left:10px; width:260px; color:#467B99; " >'.substr($Itm[$i]['title'],0,90).'...</div>';
	   $response .= '<div  style="float:left; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;color:#467B99; " ><i>'.$Itm[$i]['category'].'</i></div>';
	         			
	   $response .= '</tr></table>';	            
	   $response .= '</div>';

     
	}
   
   print $response;
  ?>
 