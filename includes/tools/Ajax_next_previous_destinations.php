<?php
  
    require_once("../../includes/functions.php");
	require_once("../../includes/config.inc.php");
	require_once("../../includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();


 	$locationID_previous = $_REQUEST['locationID'];  
 	$locationID_next = $_REQUEST['locationID'];  
 	
    $response = '';
    $response_Previous = '';
    $response_Next = '';
    
    $sql="SELECT MAX(l.id) as 'maxID', MIN(l.id) as 'minID' FROM locations l";
	$conn->setsql($sql);
	$conn->getTableRow();
	$ItmMaxMin  = $conn->result;	
		
    function fetchLocationInfo($currentLocationID,$direction)
    {
    	$locationID = $currentLocationID + ($direction);			
    	global $conn, $ItmMaxMin;
    	    	
		
    	$sql="SELECT l.id as 'id', l.name as 'location_name', lt.name as 'locType', l.info as 'info', l.youtube_video as 'youtube_video' FROM locations l, location_types lt WHERE l.loc_type_id = lt.id AND l.id= '".$locationID."'";
		$conn->setsql($sql);
		$conn->getTableRow();
		$Itm  = $conn->result;	
		
    	if(($direction === 1) && ($locationID > $ItmMaxMin['maxID']))
		{
			return false;		
		}
    	elseif(($direction === -1) && ($locationID < $ItmMaxMin['minID']))
		{
			return false;		 
		}
		
		if(!$conn->getTableRows())
		{
	     	return fetchLocationInfo($locationID,$direction);	      	
	   	}
		
	   	return $Itm;
		
    }
	
    
    
    	$Itm_Previous = fetchLocationInfo($locationID_previous,-1);
    	$Itm_Next = fetchLocationInfo($locationID_next,1);
       
   		
	
	if(is_array($Itm_Previous))
	{
		
	   	$sql="SELECT * FROM location_pics WHERE locationID='".$Itm_Previous['id']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPics=@$conn->result;
		$numPics=@$conn->numberrows;
	
		
		if(is_file("../../pics/locations/".$resultPics[0]['url_thumb'])) 
		{
			$picFile_Previous= "pics/locations/".$resultPics[0]['url_thumb'];
		}
		else 
		{
			$picFile_Previous = 'pics/locations/no_photo_thumb.png';
		}
	   	
		list($width, $height, $type, $attr) = getimagesize("../../".$picFile_Previous);
		$pic_width_or_height = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($height) && ($width))	
		{
			if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
			else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
		}

		
		
		$Previous_Pic = '<a href="разгледай-дестинация-'.$Itm_Previous['id'].','.myTruncateToCyrilic($Itm_Previous['locType'].' '.$Itm_Previous['location_name'],200,"_","").'.html" ><div style="border:1px solid #CCCCCC; width:90px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:80).'"  src="'.$picFile_Previous.'" /></div></a>';
								
		$response_Previous .= '<h3><a href="разгледай-дестинация-'.$Itm_Previous['id'].','.myTruncateToCyrilic($Itm_Previous['locType'].' '.$Itm_Previous['location_name'],200,"_","").'.html" style="font-size:12px; font-weight:bold; color:#0099FF;" >'.$Itm_Previous['locType'].' '.$Itm_Previous['location_name'].'</a></h3>';
		$response_Previous .= '<a href="разгледай-дестинация-'.$Itm_Previous['id'].','.myTruncateToCyrilic($Itm_Previous['locType'].' '.$Itm_Previous['location_name'],200,"_","").'.html" style="font-size:14px; color:#FF6600; font-weight:normal; text-decoration:none;" >';				    		
		// $response_Previous .= '&rarr; '.$Itm_Previous['locType'].' '.$Itm_Previous['location'].' <br />'; 
		$response_Previous .= 'Предишна<br />'; 
		$response_Previous .= '</a>'; 
			
				   			
		
     
	}
   
	
	if(is_array($Itm_Next))
	{
		
		$sql="SELECT * FROM location_pics WHERE locationID='".$Itm_Next['id']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPics=@$conn->result;
		$numPics=@$conn->numberrows;
	
		
		if(is_file("../../pics/locations/".$resultPics[0]['url_thumb'])) 
		{
			$picFile_Next= "pics/locations/".$resultPics[0]['url_thumb'];
		}
		else 
		{
			$picFile_Next = 'pics/locations/no_photo_thumb.png';
		}
		
		list($width, $height, $type, $attr) = getimagesize("../../".$picFile_Next);
		$pic_width_or_height = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($height) && ($width))	
		{
			if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
			else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
		}

		$Next_Pic = '<a href="разгледай-дестинация-'.$Itm_Next['id'].','.myTruncateToCyrilic($Itm_Next['locType'].' '.$Itm_Next['location_name'],200,"_","").'.html" ><div style="border:1px solid #CCCCCC; width:90px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:80).'"  src="'.$picFile_Next.'" /></div></a>';
		
		$response_Next .= '<h3><a href="разгледай-дестинация-'.$Itm_Next['id'].','.myTruncateToCyrilic($Itm_Next['locType'].' '.$Itm_Next['location_name'],200,"_","").'.html" style="font-size:12px; font-weight:bold; color:#0099FF;" >'.$Itm_Next['locType'].' '.$Itm_Next['location_name'].'</a></h3>';
		$response_Next .= '<a href="разгледай-дестинация-'.$Itm_Next['id'].','.myTruncateToCyrilic($Itm_Next['locType'].' '.$Itm_Next['location_name'],200,"_","").'.html" style="font-size:14px; color:#FF6600; font-weight:normal; text-decoration:none;" >';				    		
		// $response_Next .= '&rarr; '.$Itm_Next['locType'].' '.$Itm_Next['location'].' <br />'; 
		$response_Next .= 'Следваща<br />'; 
		$response_Next .= '</a>'; 		
			
	
	}
	
		$response .='<table style="height:122px; background-image:url(images/next_previous_strelki.png); background-position:top; background-repeat:no-repeat;"><tr><td align="center" style="width:100px;">'.$Previous_Pic.'</td> <td style="width:110px;">&nbsp;</td> <td style="width:260px;"> <table style="width:260px;"><tr><td align="left"  style="width:130px;">'.$response_Previous.'</td><td align="right"  style="width:130px;">'.$response_Next.'</td></tr></table> </td> <td style="width:110px;">&nbsp;</td> <td align="center" style="width:100px;">'.$Next_Pic.'</td></tr></table>';
   	
	
   print $response;
  ?>
 
  
  
  
  
  
  