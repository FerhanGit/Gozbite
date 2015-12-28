<?php
  
   require_once("../includes/header.inc.php");
   

 
   
   $index=$_REQUEST['index'];
   $Itms = explode(',',$_REQUEST['Itms']);
   $itemID = $Itms[$index];
   $response = '';
  
	$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id AND p.active = '1'  AND p.postID = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$Itm  = $conn->result;
	
   if(eregi('.jpg','../pics/posts/'.$Itm['picURL'])) $picFile= 'pics/posts/'.$Itm['picURL'];
   else $picFile = 'pics/posts/no_photo_big.png';
   		 
	$response .= '<div style="float:left;background-color:lightblue; width:320px;">';
   	$response .= '<div align="center" style="background-color:lightblue; width:300px; height:180px;background-image:url('.$picFile.');background-repeat:no-repeat;margin:auto;">';
   	$response .= '<div id="ajax_news_title" style="float:left; margin-left:0px;width:auto; padding-right:5px; margin-top:5px; background-color:lightblue;   filter: alpha(opacity=70); -moz-opacity: 0.7; border-right:2px solid #FF6600;" ><strong style="color:#FF8400">'.$Itm['title'].'</strong></div>';
                
   	$response .= '<div style="float:left; margin-left:5px;width:230px;" align="justify">';
   	$response .= '<table><tr>';
   	$response .= '<td style="padding:10px;">';
   	$response .= '<div  style="float:left;margin-top:5px; width:280px; overflow:hidden; ">';
  		       			
	$response .= '</tr></table>';
    $response .= '</div>';
            
    $response .= '</div>';  
    
   $response .= '<div style="float:left;background-color:lightblue;margin-left:10px;color:#467B99;">'.myTruncate($Itm['body'], 250, " ").'<div align="right"><a href="index.php?pg=posts.php&postID='.$Itm['postID'].'">Още</а></div></div>'; 
	
    
   print $response;
  ?>
 