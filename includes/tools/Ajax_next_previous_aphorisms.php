<?php
  
   	require_once("../../includes/functions.php");
	require_once("../../includes/config.inc.php");
	require_once("../../includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

 	$aphorismID_previous = $_REQUEST['aphorismID'];  
 	$aphorismID_next = $_REQUEST['aphorismID'];  
 	
    $response = '';
  
    $sql="SELECT MAX(a.aphorismID) as 'maxID', MIN(a.aphorismID) as 'minID' FROM aphorisms a ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$ItmMaxMin  = $conn->result;	
		
    function fetchPostInfo($currentAphorismID,$direction)
    {
    	$aphorismID = $currentAphorismID + ($direction);			
    	global $conn, $ItmMaxMin;
    	
    	$sql = sprintf("SELECT DISTINCT(a.aphorismID) as 'aphorismID',
								             a.title as 'title',								             
								              a.body as 'body',
									           a.picURL as 'picURL',
										        a.autor_type as 'autor_type',
								                 a.autor as 'autor',
									              a.date as 'date'
										           FROM aphorisms a
											        WHERE a.active = '1'
										        	   AND a.aphorismID = %d", $aphorismID);

										   

    	      
            $conn->setsql($sql);
            $conn->getTableRow();
            $Itm = $conn->result;
			$aphorismRowsCount = $conn->numberrows;
    	
			
							
    	
    	if(($direction === 1) && ($aphorismID > $ItmMaxMin['maxID']))
		{
			return false;		
		}
    	elseif(($direction === -1) && ($aphorismID < $ItmMaxMin['minID']))
		{
			return false;		 
		}
		
		if($aphorismRowsCount == 0)
		{
	     	return fetchPostInfo($aphorismID,$direction);	      	
	   	}
		
	   	return $Itm;
		
    }
	
    
    
    $Itm_Previous = fetchPostInfo($aphorismID_previous,-1);
    $Itm_Next = fetchPostInfo($aphorismID_next,1);
   
  
    
   		$response .=	' <div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">';
		if($Itm_Previous['aphorismID'] > 0) $response .=	'<div style=" float:left; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;">&larr; <a style="color:#FFF;font-weight:bold; text-decoration:none;" href="прочети-афоризъм-'.$Itm_Previous['aphorismID'].','.myTruncateToCyrilic($Itm_Previous['body'],100,"_","").'.html">Предишна Фраза</a></div>';
		else $response .=	'<div style=" float:left; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"></div>';
		if($Itm_Next['aphorismID'] > 0) $response .=	'<div style=" float:right; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"><a style="color:#FFF;font-weight:bold; text-decoration:none;" href="прочети-афоризъм-'.$Itm_Next['aphorismID'].','.myTruncateToCyrilic($Itm_Next['body'],100,"_","").'.html">Следваща Фраза</a> &rarr;</div>';				
		else $response .=	'<div style=" float:right; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"></div>';				
		$response .=	'<br style="clear:both;"/>';							
		$response .=	'</div>';


        $response .=	'<table><tr><td width="320">';    
  
	
	if($Itm_Previous)
	{
   		
		   if(is_file("../../pics/aphorisms/".$Itm_Previous['picURL'])) $picFile= "pics/aphorisms/".$Itm_Previous['picURL'];
		   else $picFile = 'pics/aphorisms/no_photo_thumb.png';
		   	 
		
		   $response .=	'<div style="float:left;width:320px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'прочети-афоризъм-'.$Itm_Previous['aphorismID'].','.myTruncateToCyrilic($Itm_Previous['body'],100,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
		   $response .= '<table align="left"><tr>';
		   $response .= '<td>';
		   $response .= '<div style="float:left; border:double; border-color:#333333;  margin-left:5px; height:35px; width:35px;" ><a href="прочети-афоризъм-'.$Itm_Previous['aphorismID'].','.myTruncateToCyrilic($Itm_Previous['body'],100,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
		   $response .= '</td><td><div style=" float:left; margin-left:5px; width:260px;" >'.myTruncate($Itm_Previous['body'], 200, " ").'</div>';
		         			
		   $response .= '</td></tr></table>';	            
		   $response .= '</div>';
		
	}
   
	
	 $response .=	'</td><td width="320">';
    
	
	if($Itm_Next)
	{
		
		   if(is_file("../../pics/aphorisms/".$Itm_Next['picURL'])) $picFile= "pics/aphorisms/".$Itm_Next['picURL'];
		   else $picFile = 'pics/aphorisms/no_photo_thumb.png';
		  		  		
		
		   $response .=	'<div style="float:right;width:320px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'прочети-афоризъм-'.$Itm_Next['aphorismID'].','.myTruncateToCyrilic($Itm_Next['body'],100,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
		   $response .= '<table align="right"><tr>';
		   $response .= '<td>';
		   $response .= '<div style=" float:right; margin-left:5px; width:260px;" >'.myTruncate($Itm_Next['body'], 200, " ").'</div>';
		    $response .= '</td><td><div style="float:right; border:double; border-color:#333333;  margin-left:5px; height:35px; width:35px;" ><a href="прочети-афоризъм-'.$Itm_Next['aphorismID'].','.myTruncateToCyrilic($Itm_Next['body'],100,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
		         			
		   $response .= '</td></tr></table>';	            
		   $response .= '</div>';
	
		
	}
	
	 $response .=	'</td></tr></table>';
	
   print $response;
  ?>
 