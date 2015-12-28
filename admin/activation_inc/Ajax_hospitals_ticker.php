<?php
  
   require_once("../inc/dblogin.inc.php");
   
   
   $response = '';
  
	$sql="SELECT DISTINCT(h.id) as 'id', h.name as 'firm_name', h.manager as 'manager', h.phone as 'phone', h.address as 'address', h.email as 'email', h.web as 'web', l.name as 'location', lt.name as 'locType', h.registered_on as 'registered_on', h.description as 'description', h.has_pic as 'has_pic' FROM hospitals h, locations l, location_types lt WHERE h.location_id = l.id  AND l.loc_type_id = lt.id ORDER BY h.registered_on DESC LIMIT 5 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$Itm  = $conn->result;
	$numItms  = $conn->numberrows;
	
	for($i=0;$i<$numItms;$i++)
	{
				
		
	   if(is_file("../pics/firms/".$Itm[$i]['id']."_logo.jpg")) $picFile= "pics/firms/".$Itm[$i]['id']."_logo.jpg";
	   else $picFile = 'pics/firms/no_logo.png';
	   		 
	
	   $response .=	'<div style="float:left; width:320px;color:#009900; font-size:11px;"cursor:pointer;cursor:hand;background-color:#F9FBFF;" onClick="javascript:document.location.href=\'hospitals.php?firmID='.$Itm[$i]['id'].'\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'#F9FBFF\';">';                
	   $response .= '<table><tr>';
	   $response .= '<td style="padding:5px;">';
	   $response .= '<div style="float:left;margin-right:0px;width:100px;" ><a href="hospitals.php?firmID='.$Itm[$i]['id'].'"><img width="100" height="35" src="'.$picFile.'" /></a></div>';
	   $response .= '<div  style="float:left; margin-left:5px; width:200px; " align="left">'.$Itm[$i]['firm_name'].'</div>';
	   $response .= '<div style="float:left; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:5px; width:200px; color:#009900;">'.$Itm[$i]['locType'].' '.$Itm[$i]['location'].' | '.$Itm[$i]['address'].'</div>';
	   $response .= '</tr></table>';
	            
	   $response .= '</div>';
  
	}
  
   
   print $response;
  ?>
 