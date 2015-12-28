<?php
  
   	require_once("../../includes/functions.php");
	require_once("../../includes/config.inc.php");
	require_once("../../includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

 	$bolestID_previous = $_REQUEST['bolestID'];  
 	$bolestID_next = $_REQUEST['bolestID'];  
 	
    $response = '';
  
    $sql="SELECT MAX(b.bolestID) as 'maxID', MIN(b.bolestID) as 'minID' FROM bolesti b ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$ItmMaxMin  = $conn->result;	
		
    function fetchPostInfo($currentBolestID,$direction)
    {
    	$bolestID = $currentBolestID + ($direction);			
    	global $conn, $ItmMaxMin;
    	
    	
    	$sql=sprintf("SELECT b.bolestID as 'bolestID',
							   b.title as 'title',
								b.body as 'body',
								 b.autor as 'autor',
								  b.autor_type as 'autor_type',
								   b.source as 'source',
								    b.rating as 'rating',
								     b.times_rated as 'times_rated',
								      b.has_pic as 'has_pic',
								       b.has_video as 'has_video',
								        b.youtube_video as 'youtube_video',
								         b.discovered_on as 'discovered_on',
								          b.date as 'date',
							    		   b.active as 'active'
									  		FROM bolesti b
										     WHERE b.active = '1'
										     AND b.bolestID = %d", $bolestID);

    	      
            $conn->setsql($sql);
            $conn->getTableRow();
            $Itm = $conn->result;
			$bolestRowsCount = $conn->numberrows;
    	
			
			if($bolestRowsCount > 0)
			{
				$sql="SELECT * FROM bolesti_pics WHERE bolestID='".$Itm['bolestID']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$Itm['numPics']  	= $conn->numberrows;
				$resultBolestiPics	= $conn->result;	
				
				for($i = 0; $i < $Itm['numPics']; $i++) {
					$Itm['resultPics']['url_big'][$i] 	= $resultBolestiPics[$i]["url_big"];
					$Itm['resultPics']['url_thumb'][$i] = $resultBolestiPics[$i]["url_thumb"];
				}
				
				
				
				$sql="SELECT bc.id as 'bolest_category_id', bc.name as 'bolest_category_name' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND b.bolestID = '".$Itm['bolestID']."' ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$Itm['numCats'] 	= $conn->numberrows;
				$resultBolestiCat	= $conn->result;	
					
				for($i = 0; $i < $Itm['numCats']; $i++) {
					$Itm['Cats'][$i] = $resultBolestiCat[$i];					
				}
			
		
		
			}
			
			
				
				
    	
    	if(($direction === 1) && ($bolestID > $ItmMaxMin['maxID']))
		{
			return false;		
		}
    	elseif(($direction === -1) && ($bolestID < $ItmMaxMin['minID']))
		{
			return false;		 
		}
		
		if(!$conn->getTableRows())
		{
	     	return fetchPostInfo($bolestID,$direction);	      	
	   	}
		
	   	return $Itm;
		
    }
	
    
    
    $Itm_Previous = fetchPostInfo($bolestID_previous,-1);
    $Itm_Next = fetchPostInfo($bolestID_next,1);
   
  
    
   		$response .=	' <div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">';
		if($Itm_Previous['bolestID'] > 0) $response .=	'<div style=" float:left; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;">&larr; <a style="color:#FFF;font-weight:bold; text-decoration:none;" href="разгледай-болест-'.$Itm_Previous['bolestID'].','.myTruncateToCyrilic($Itm_Previous['title'],100,"_","").'.html">Предишна Болест</a></div>';
		else $response .=	'<div style=" float:left; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"></div>';
		if($Itm_Next['bolestID'] > 0) $response .=	'<div style=" float:right; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"><a style="color:#FFF;font-weight:bold; text-decoration:none;" href="разгледай-болест-'.$Itm_Next['bolestID'].','.myTruncateToCyrilic($Itm_Next['title'],100,"_","").'.html">Следваща Болест</a> &rarr;</div>';				
		else $response .=	'<div style=" float:right; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"></div>';				
		$response .=	'<br style="clear:both;"/>';							
		$response .=	'</div>';


        $response .=	'<table><tr><td width="320">';    
  
	
	if($Itm_Previous)
	{
						
		   if(is_file("../../pics/bolesti/".$Itm_Previous['resultPics']['url_big'][0])) $picFile= "pics/bolesti/".$Itm_Previous['resultPics']['url_big'][0];
		   else $picFile = 'pics/bolesti/no_photo_big.png';
		   	 
		
		   $response .=	'<div style="float:left;width:320px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-болест-'.$Itm_Previous['bolestID'].','.myTruncateToCyrilic($Itm_Previous['title'],100,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
		   $response .= '<table align="left"><tr>';
		   $response .= '<td>';
		   $response .= '<div style="float:left; border:double; border-color:#333333;  margin-left:5px; height:35px; width:35px;" ><a href="разгледай-болест-'.$Itm_Previous['bolestID'].','.myTruncateToCyrilic($Itm_Previous['title'],100,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
		   $response .= '</td><td><div style=" float:left; margin-left:5px; width:260px;" >'.myTruncate($Itm_Previous['title'], 90, " ").'</div>';
		   $response .= '<div style="float:left; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;" ><b>'.$Itm_Previous['Cats'][0]['bolest_category_name'].'</b></div>';
		         			
		   $response .= '</td></tr></table>';	            
		   $response .= '</div>';
		
	}
   
	
	 $response .=	'</td><td width="320">';
    
	
	if($Itm_Next)
	{
		
		   if(is_file("../../pics/bolesti/".$Itm_Next['resultPics']['url_big'][0])) $picFile= "pics/bolesti/".$Itm_Next['resultPics']['url_big'][0];
		   else $picFile = 'pics/bolesti/no_photo_big.png';
		  		  		
		
		   $response .=	'<div style="float:right;width:320px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-болест-'.$Itm_Next['bolestID'].','.myTruncateToCyrilic($Itm_Next['title'],100,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
		   $response .= '<table align="right"><tr>';
		   $response .= '<td>';
		   $response .= '<div style=" float:right; margin-left:5px; width:260px;" >'.myTruncate($Itm_Next['title'], 90, " ").'</div>';
		   $response .= '<div style="float:right; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;" ><b>'.$Itm_Next['Cats'][0]['bolest_category_name'].'</b></div>';
		   $response .= '</td><td><div style="float:right; border:double; border-color:#333333;  margin-left:5px; height:35px; width:35px;" ><a href="разгледай-болест-'.$Itm_Next['bolestID'].','.myTruncateToCyrilic($Itm_Next['title'],100,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
		         			
		   $response .= '</td></tr></table>';	            
		   $response .= '</div>';
	
		
	}
	
	 $response .=	'</td></tr></table>';
	
   print $response;
  ?>
 