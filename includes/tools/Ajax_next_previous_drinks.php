<?php
  
   	require_once("../../includes/functions.php");
	require_once("../../includes/config.inc.php");
	require_once("../../includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

 	$drinkID_previous = $_REQUEST['drinkID'];  
 	$drinkID_next = $_REQUEST['drinkID'];  
 	
    $response = '';
  
    $sql="SELECT MAX(d.id) as 'maxID', MIN(d.id) as 'minID' FROM drinks d ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$ItmMaxMin  = $conn->result;	
		
    function fetchPostInfo($currentDrinkID,$direction)
    {
    	$drinkID = $currentDrinkID + ($direction);			
    	global $conn, $ItmMaxMin;
    	
    	$sql=sprintf("SELECT d.id as 'drinkID',
									   d.title as 'title',
										d.info as 'info',
										 d.firm_id as 'firm_id',
										  d.user_id as 'user_id',
										   d.has_pic as 'has_pic',
										    d.registered_on as 'registered_on',
										     d.updated_by as 'updated_by',
									    	  d.updated_on as 'updated_on',
									    	   d.activated_deactivated_by as 'activated_deactivated_by',
									    		d.active as 'active'
											  	 FROM drinks d
												  WHERE d.active = '1'
												   AND d.id = %d", $drinkID);

    	      
            $conn->setsql($sql);
            $conn->getTableRow();
            $Itm = $conn->result;
			$drinkRowsCount = $conn->numberrows;
    	
			
			if($drinkRowsCount > 0)
			{
				$sql="SELECT * FROM drink_pics WHERE drinkID='".$Itm['drinkID']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$Itm['numPics']  	= $conn->numberrows;
				$resultDrinksPics	= $conn->result;	
				
				for($i = 0; $i < $Itm['numPics']; $i++) {
					$Itm['resultPics']['url_big'][$i] 	= $resultDrinksPics[$i]["url_big"];
					$Itm['resultPics']['url_thumb'][$i] = $resultDrinksPics[$i]["url_thumb"];
				}
				
				
				
				$sql="SELECT dc.id as 'drink_category_id', dc.name as 'drink_category_name' FROM drinks d, drink_category dc, drinks_category_list dcl WHERE dcl.drink_id = d.id AND dcl.category_id = dc.id AND d.id = '".$Itm['drinkID']."' ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$Itm['numCats'] 	= $conn->numberrows;
				$resultDrinksCat	= $conn->result;	
					
				for($i = 0; $i < $Itm['numCats']; $i++) {
					$Itm['Cats'][$i] = $resultDrinksCat[$i];					
				}
			
		
		
			}
			
			
				
				
    	
    	if(($direction === 1) && ($drinkID > $ItmMaxMin['maxID']))
		{
			return false;		
		}
    	elseif(($direction === -1) && ($drinkID < $ItmMaxMin['minID']))
		{
			return false;		 
		}
		
		if($drinkRowsCount == 0)
		{
	     	return fetchPostInfo($drinkID,$direction);	      	
	   	}
		
	   	return $Itm;
		
    }
	
    
    
    $Itm_Previous = fetchPostInfo($drinkID_previous,-1);
    $Itm_Next = fetchPostInfo($drinkID_next,1);
   
  
    
   		$response .=	' <div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">';
		if($Itm_Previous['drinkID'] > 0) $response .=	'<div style=" float:left; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;">&larr; <a style="color:#FFF;font-weight:bold; text-decoration:none;" href="разгледай-напитка-'.$Itm_Previous['drinkID'].','.myTruncateToCyrilic($Itm_Previous['title'],100,"_","").'.html">Предишна Напитка</a></div>';
		else $response .=	'<div style=" float:left; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"></div>';
		if($Itm_Next['drinkID'] > 0) $response .=	'<div style=" float:right; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"><a style="color:#FFF;font-weight:bold; text-decoration:none;" href="разгледай-напитка-'.$Itm_Next['drinkID'].','.myTruncateToCyrilic($Itm_Next['title'],100,"_","").'.html">Следваща Напитка</a> &rarr;</div>';				
		else $response .=	'<div style=" float:right; margin-left:6px; width:310px;color:#FFF;font-weight:bold; text-align:center;"></div>';				
		$response .=	'<br style="clear:both;"/>';							
		$response .=	'</div>';


        $response .=	'<table><tr><td width="320">';    
  
	
	if($Itm_Previous)
	{
						
		if(is_file("../../pics/drinks/".$Itm_Previous['resultPics']['url_thumb'][0])) 
		{
			$picFile= "pics/drinks/".$Itm_Previous['resultPics']['url_thumb'][0];
		}
		else 
		{
			$picFile = 'pics/drinks/no_photo_thumb.png';
		}   	 
		
		$response .=	'<div style="float:left;width:320px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-напитка-'.$Itm_Previous['drinkID'].','.myTruncateToCyrilic($Itm_Previous['title'],100,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
		$response .= '<table align="left"><tr>';
		$response .= '<td>';
		$response .= '<div style="float:left; border:double; border-color:#333333;  margin-left:5px; height:35px; width:35px;" ><a href="разгледай-напитка-'.$Itm_Previous['drinkID'].','.myTruncateToCyrilic($Itm_Previous['title'],100,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
		$response .= '</td><td><div style=" float:left; margin-left:5px; width:260px;" >'.myTruncate($Itm_Previous['title'], 90, " ").'</div>';
		$response .= '<div style="float:left; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;" ><b>'.$Itm_Previous['Cats'][0]['drink_category_name'].'</b></div>';
					
		$response .= '</td></tr></table>';	            
		$response .= '</div>';
		
	}
   
	
		$response .=	'</td><td width="320">';
    
	
	if($Itm_Next)
	{
		
		if(is_file("../../pics/drinks/".$Itm_Next['resultPics']['url_thumb'][0])) 
		{
			$picFile= "pics/drinks/".$Itm_Next['resultPics']['url_thumb'][0];
		}
		else 
		{
			$picFile = 'pics/drinks/no_photo_thumb.png';
		}		  		
		
		$response .=	'<div style="float:right;width:320px;font-size:12px;font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'разгледай-напитка-'.$Itm_Next['drinkID'].','.myTruncateToCyrilic($Itm_Next['title'],100,"_","").'.html\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
		$response .= '<table align="right"><tr>';
		$response .= '<td>';
		$response .= '<div style=" float:right; margin-left:5px; width:260px;" >'.myTruncate($Itm_Next['title'], 90, " ").'</div>';
		$response .= '<div style="float:right; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;" ><b>'.$Itm_Next['Cats'][0]['drink_category_name'].'</b></div>';
		$response .= '</td><td><div style="float:right; border:double; border-color:#333333;  margin-left:5px; height:35px; width:35px;" ><a href="разгледай-напитка-'.$Itm_Next['drinkID'].','.myTruncateToCyrilic($Itm_Next['title'],100,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
					
		$response .= '</td></tr></table>';	            
		$response .= '</div>';
	
		
	}
	
		$response .=	'</td></tr></table>';
	
   print $response;
  ?>
 