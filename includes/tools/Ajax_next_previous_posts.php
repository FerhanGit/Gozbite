<?php
  
   	require_once("../../includes/functions.php");
	require_once("../../includes/config.inc.php");
	require_once("../../includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();


 	$postID_previous = $_REQUEST['postID'];  
 	$postID_next = $_REQUEST['postID'];  
 	
    $response = '';
  
    $sql="SELECT MAX(p.postID) as 'maxID', MIN(p.postID) as 'minID' FROM posts p ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$ItmMaxMin  = isset($conn->result) ? $conn->result : null;	
		
    function fetchPostInfo($currentPostID,$direction)
    {
    	$postID = $currentPostID + ($direction);			
    	global $conn, $ItmMaxMin;
    	
    	
		
    	$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category = pc.id  AND p.active = '1' AND p.postID='".$postID."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$Itm  = isset($conn->result) ? $conn->result : null;	
		$numItms = isset($conn->numberrows) ? $conn->numberrows : null;
	   
    	if(($direction === 1) && ($postID > $ItmMaxMin['maxID']))
		{
			return false;		
		}
    	elseif(($direction === -1) && ($postID < $ItmMaxMin['minID']))
		{
			return false;		 
		}
		
		if(!$conn->getTableRows())
		{
	     	return fetchPostInfo($postID,$direction);	      	
	   	}
		
	   	return $Itm;
		
    }
	
    
    
    $Itm_Previous = fetchPostInfo($postID_previous,-1);
    $Itm_Next = fetchPostInfo($postID_next,1);
   
  
    
   		$response .=	' <div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">';
		if($Itm_Previous[0]['postID'] > 0) $response .=	'<div style=" float:left; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;">&larr; <a style="color:#FFF;font-weight:bold; text-decoration:none;" href="прочети-статия-'.$Itm_Previous[0]['postID'].','.myTruncateToCyrilic($Itm_Previous[0]['title'],50,"_","").'.html">Предишна Статия</a></div>';
		else $response .=	'<div style=" float:left; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"></div>';
		if($Itm_Next[0]['postID'] > 0) $response .=	'<div style=" float:right; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"><a style="color:#FFF;font-weight:bold; text-decoration:none;" href="прочети-статия-'.$Itm_Next[0]['postID'].','.myTruncateToCyrilic($Itm_Next[0]['title'],50,"_","").'.html">Следваща Статия</a> &rarr;</div>';				
		else $response .=	'<div style=" float:right; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"></div>';				
		$response .=	'<br style="clear:both;"/>';							
		$response .=	'</div>';


        $response .=	'<table><tr><td width="320">';    
  
	
	if($Itm_Previous)
	{
		for($i=0;$i<count($Itm_Previous);$i++)
		{
			if(is_file('../../pics/posts/'.$Itm_Previous[$i]['picURL'])) 
			{
				$picFile= 'pics/posts/'.$Itm_Previous[$i]['picURL'];
			}
			else 
			{
				$picFile = 'pics/posts/no_photo_thumb.png';
			}
		   		 
		
			$response .=	'<div style="float:left;width:320px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'прочети-статия-'.$Itm_Previous[$i]['postID'].','.myTruncateToCyrilic($Itm_Previous[$i]['title'],50,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
			$response .= '<table align="left"><tr>';
			$response .= '<td>';
			$response .= '<div style="float:left; border:double; border-color:#333333;  margin-left:5px; height:35px; width:35px;" ><a href="прочети-статия-'.$Itm_Previous[$i]['postID'].','.myTruncateToCyrilic($Itm_Previous[$i]['title'],50,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
			$response .= '</td><td><div style=" float:left; margin-left:5px; width:260px;" >'.myTruncate($Itm_Previous[$i]['title'], 90, " ").'</div>';
			$response .= '<div style="float:left; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;" ><b>'.$Itm_Previous[$i]['category'].'</b></div>';
						
			$response .= '</td></tr></table>';	            
			$response .= '</div>';
		}
     
	}
   
	
	$response .=	'</td><td width="320">';
    
	
	if($Itm_Next)
	{
		for($i=0;$i<count($Itm_Next);$i++)
		{
			if(is_file('../../pics/posts/'.$Itm_Next[$i]['picURL'])) 
			{
				$picFile= 'pics/posts/'.$Itm_Next[$i]['picURL'];
			}
			else 
			{
				$picFile = 'pics/posts/no_photo_thumb.png';
			}
		   		
		
			$response .=	'<div style="float:right;width:320px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'прочети-статия-'.$Itm_Next[$i]['postID'].','.myTruncateToCyrilic($Itm_Next[$i]['title'],50,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
			$response .= '<table align="right"><tr>';
			$response .= '<td>';
			$response .= '<div style=" float:right; margin-left:5px; width:260px;" >'.myTruncate($Itm_Next[$i]['title'], 90, " ").'</div>';
			$response .= '<div style="float:right; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;" ><b>'.$Itm_Next[$i]['category'].'</b></div>';
			$response .= '</td><td><div style="float:right; border:double; border-color:#333333;  margin-left:5px; height:35px; width:35px;" ><a href="прочети-статия-'.$Itm_Next[$i]['postID'].','.myTruncateToCyrilic($Itm_Next[$i]['title'],50,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
						
			$response .= '</td></tr></table>';	            
			$response .= '</div>';
	
		}
	}
	
	$response .=	'</td></tr></table>';
	
   print $response;
  ?>
 