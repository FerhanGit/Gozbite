<?php
  
   require_once("../inc/dblogin.inc.php");
   

 $response ='';
   
	$sql="SELECT DISTINCT(d.id) as 'id', d.first_name as 'first_name', d.last_name as 'last_name', d.phone as 'phone', d.addr as 'address', d.email as 'email', d.web as 'web', d.related_hospital as 'related_hospital', l.name as 'location', lt.name as 'locType', d.registered_on as 'registered_on', d.info as 'info', d.has_pic as 'has_pic' FROM doctors d, locations l, location_types lt WHERE d.location_id = l.id  AND l.loc_type_id = lt.id  ORDER BY d.registered_on DESC LIMIT 5 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$Itm  = $conn->result;
	$numItms  = $conn->numberrows;
	
	for($i=0;$i<$numItms;$i++)
	{
	
		$sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$Itm[$i]['id']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numItmCats[$i]  	= $conn->numberrows;
		$resultItmCats[$i]  = $conn->result;
		
		if ($Itm[$i]['has_pic']=='1')
		{
			$sql="SELECT * FROM doctor_pics WHERE doctorID='".$Itm[$i]['id']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultPics[$i]=$conn->result;
			$numPics[$i]=$conn->numberrows;
		}
		
	   if($numPics[$i]>0 && is_file('../pics/doctors/'.$resultPics[$i][0]['url_thumb'])) $picFile= 'pics/doctors/'.$resultPics[$i][0]['url_thumb'];
	   else $picFile = 'pics/doctors/no_photo_thumb.png';
	   	

	   $response .=	'<div style="float:left;width:320px;font-size:11px;cursor:pointer;cursor:hand;background-color:F9FBFF;" onClick="javascript:document.location.href=\'doctors.php?doctorID='.$Itm[$i]['id'].'\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'#F9FBFF\';">';
	   $response .= '<table><tr>';
	   $response .= '<td >';
	   $response .= '<div style="float:left; border:double; border-color:#009900; height:35px; width:35px;" ><a href="doctors.php?doctorID='.$Itm[$i]['id'].'"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
	   $response .= '<div style=" float:left; margin-left:10px; width:260px; color:#009900; " >'.$Itm[$i]['first_name'].' '.$Itm[$i]['last_name'].'</div>';
	   $response .= '<div  style="float:left;background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;color:#009900; " >'.$resultItmCats[$i][0]['doctor_category_name'].' | '.$Itm[$i]['locType'].' '.$Itm[$i]['location'].' | '.($Itm[$i]['phone']?$Itm[$i]['phone']:$Itm[$i]['email']).'</div>';
	         			
	   $response .= '</tr></table>';	            
	   $response .= '</div>';
	  
  
	}
	
   print $response;
  ?>
 