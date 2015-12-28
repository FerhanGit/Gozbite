<?php
  
   require_once("../inc/dblogin.inc.php");
   

 
   
   $index=$_REQUEST['index'];
   $Itms = explode(',',$_REQUEST['Itms']);
   $itemID = $Itms[$index];
   $response = '';
  
	$sql="SELECT n.newsID as 'newsID', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc WHERE n.news_category=nc.id AND n.newsID = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$Itm  = $conn->result;
	
   if(eregi('.jpg','../pics/news/'.$Itm['picURL'])) $picFile= '../pics/news/'.$Itm['picURL'];
   else $picFile = '../pics/news/no_photo_thumb.png';
   		 

   	$response .= '<div style="float:left;background-color:lightblue; width:320px;">';
   	$response .= '<div align="center" style="background-color:lightblue; width:300px; height:180px;background-image:url('.$picFile.');margin:auto;">';
   	$response .= '<div id="ajax_news_title" style="float:left; margin-left:0px; padding-right:5px; margin-top:5px; background-color:lightblue;   filter: alpha(opacity=70); -moz-opacity: 0.7; border-right:2px solid #FF6600;" ><strong style="color:#FF8400">'.$Itm['title'].'</strong></div>';
                
   	$response .= '<div style="float:left; margin-left:5px;width:230px; font-size: 14px; color: #333333;" align="justify">';
   	$response .= '<table><tr>';
   	$response .= '<td style="padding:10px;">';
   	$response .= '<div  style="float:left;margin-top:5px; width:280px; overflow:hidden; ">';
  		       			
	$response .= '</tr></table>';
    $response .= '</div>';
            
    $response .= '</div>';  
    
    $response .= '<div style="float:left;background-color:lightblue;margin-left:10px;">'.substr($Itm['body'],0,140).'...<div align="right"><a href="news.php?&newsID='.$Itm['newsID'].'">Още</а></div></div>'; 
	
     
   
   print $response;
  ?>
 