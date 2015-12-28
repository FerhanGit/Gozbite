<?php
  
    require_once("../../includes/functions.php");
	require_once("../../includes/config.inc.php");
	require_once("../../includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();


 	$firmID_previous = $_REQUEST['firmID'];  
 	$firmID_next = $_REQUEST['firmID'];  
 	
    $response = '';
  
    $sql="SELECT MAX(f.id) as 'maxID', MIN(f.id) as 'minID' FROM firms f";
	$conn->setsql($sql);
	$conn->getTableRow();
	$ItmMaxMin  = $conn->result;	
		
    function fetchFirmInfo($currentFirmID,$direction)
    {
    	$firmID = $currentFirmID + ($direction);			
    	global $conn, $ItmMaxMin;
    	    	
		
    	$sql="SELECT DISTINCT(f.id) as 'id', f.name as 'firm_name', f.manager as 'manager', f.phone as 'phone', f.address as 'address', f.email as 'email', f.web as 'web', l.name as 'location', lt.name as 'locType', f.registered_on as 'registered_on', f.description as 'description', f.has_pic as 'has_pic' FROM firms f, locations l, location_types lt WHERE f.active = '1' AND f.location_id = l.id  AND l.loc_type_id = lt.id  AND f.id='".$firmID."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$Itm  = $conn->result;	
		$numItms = $conn->numberrows;
	 
    	if(($direction === 1) && ($firmID > $ItmMaxMin['maxID']))
		{
			return false;		
		}
    	elseif(($direction === -1) && ($firmID < $ItmMaxMin['minID']))
		{
			return false;		 
		}
		
		if(!$conn->getTableRows())
		{
	     	return fetchFirmInfo($firmID,$direction);	      	
	   	}
		
	   	return $Itm;
		
    }
	
    
    
    	$Itm_Previous = fetchFirmInfo($firmID_previous,-1);
    	$Itm_Next = fetchFirmInfo($firmID_next,1);
   
  
	
	if($Itm_Previous)
	{
		for($i=0;$i<count($Itm_Previous);$i++)
		{
		   	$sql="SELECT fc.id as 'firm_category_id', fc.name as 'firm_category_name' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id AND f.id = '".$Itm_Previous[$i]['id']."' LIMIT 1 ";
			$conn->setsql($sql);
			$conn->getTableRow();
			$firmFeaturedCats  = $conn->result;
		
			
			if(is_file("../../pics/firms/".$Itm_Previous[$i]['id']."_logo.jpg")) 
			{
				$picFile_Previous= "pics/firms/".$Itm_Previous[$i]['id']."_logo.jpg";
			}
			else 
			{
				$picFile_Previous = 'pics/firms/no_logo.png';
			}
				
			list($width, $height, $type, $attr) = getimagesize("../../".$picFile_Previous);
			$pic_width_or_height = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
			if (($height) && ($width))	
			{
				if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
				else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
			}

				$Previous_Pic = '<a href="разгледай-фирма-'.$Itm_Previous[0]['id'].','.myTruncateToCyrilic($Itm_Previous[0]['firm_name'],50,"_","").'.html" ><div style="border:1px solid #CCCCCC; width:90px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:80).'"  src="'.$picFile_Previous.'" /></div></a>';
									
			    $response_Previous .= '<h3><a href="разгледай-фирма-'.$Itm_Previous[$i]['id'].','.myTruncateToCyrilic($Itm_Previous[$i]['firm_name'],50,"_","").'.html" style="font-size:12px; font-weight:bold; color:#0099FF;" >'.$Itm_Previous[$i]['firm_name'].'</a></h3>';
			    $response_Previous .= '<a href="разгледай-фирма-'.$Itm_Previous[$i]['id'].','.myTruncateToCyrilic($Itm_Previous[$i]['firm_name'],50,"_","").'.html" style="font-size:14px; color:#FF6600; font-weight:normal; text-decoration:none;" >';				    		
			   // $response_Previous .= '&rarr; '.$Itm_Previous[$i]['locType'].' '.$Itm_Previous[$i]['location'].' <br />'; 
				$response_Previous .= 'Предишна<br />'; 
				$response_Previous .= '</a>'; 
		    	
							
    			
		}
     
	}
   
	

    
	
	if($Itm_Next)
	{
		for($i=0;$i<count($Itm_Next);$i++)
		{
		  	$sql="SELECT fc.id as 'firm_category_id', fc.name as 'firm_category_name' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id AND f.id = '".$Itm_Next[$i]['id']."' LIMIT 1 ";
			$conn->setsql($sql);
			$conn->getTableRow();
			$firmFeaturedCats  = $conn->result;
		
			
			if(is_file("../../pics/firms/".$Itm_Next[$i]['id']."_logo.jpg")) 
			{
				$picFile_Next= "pics/firms/".$Itm_Next[$i]['id']."_logo.jpg";
			}
			else 
			{
				$picFile_Next = 'pics/firms/no_logo.png';
			}
				
			list($width, $height, $type, $attr) = getimagesize("../../".$picFile_Next);
			$pic_width_or_height = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
			if (($height) && ($width))	
			{
				if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
				else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
			}

			$Next_Pic = '<a href="разгледай-фирма-'.$Itm_Next[0]['id'].','.myTruncateToCyrilic($Itm_Next[0]['firm_name'],50,"_","").'.html" ><div style="border:1px solid #CCCCCC; width:90px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:80).'"  src="'.$picFile_Next.'" /></div></a>';
			
				$response_Next .= '<h3><a href="разгледай-фирма-'.$Itm_Next[$i]['id'].','.myTruncateToCyrilic($Itm_Next[$i]['firm_name'],50,"_","").'.html" style="font-size:12px; font-weight:bold; color:#0099FF;" >'.$Itm_Next[$i]['firm_name'].'</a></h3>';
			    $response_Next .= '<a href="разгледай-фирма-'.$Itm_Next[$i]['id'].','.myTruncateToCyrilic($Itm_Next[$i]['firm_name'],50,"_","").'.html" style="font-size:14px; color:#FF6600; font-weight:normal; text-decoration:none;" >';				    		
			   // $response_Next .= '&rarr; '.$Itm_Next[$i]['locType'].' '.$Itm_Next[$i]['location'].' <br />'; 
				$response_Next .= 'Следваща<br />'; 
				$response_Next .= '</a>'; 		    	
		    	
		}
	}
	
	 	
	 	
	 	$response .='<table style="height:122px; background-image:url(images/next_previous_strelki.png); background-position:top; background-repeat:no-repeat;"><tr><td align="center" style="width:100px;">'.$Previous_Pic.'</td> <td style="width:110px;">&nbsp;</td> <td style="width:260px;"> <table style="width:260px;"><tr><td align="left"  style="width:130px;">'.$response_Previous.'</td><td align="right"  style="width:130px;">'.$response_Next.'</td></tr></table> </td> <td style="width:110px;">&nbsp;</td> <td align="center" style="width:100px;">'.$Next_Pic.'</td></tr></table>';
   	
	 	
		
	 
   print $response;
  ?>
 