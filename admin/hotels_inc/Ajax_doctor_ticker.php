<?php
  
   require_once("../inc/dblogin.inc.php");
   

 
   
   $index=$_REQUEST['index'];
   $Itms = explode(',',$_REQUEST['Itms']);
   $itemID = $Itms[$index];
   $response = '';
  
	$sql="SELECT DISTINCT(d.id) as 'id', d.first_name as 'first_name', d.last_name as 'last_name', d.phone as 'phone', d.addr as 'address', d.email as 'email', d.web as 'web', d.related_hospital as 'related_hospital', l.name as 'location', lt.name as 'locType', d.registered_on as 'registered_on', d.info as 'info', d.has_pic as 'has_pic' FROM doctors d, locations l, location_types lt WHERE d.location_id = l.id  AND l.loc_type_id = lt.id AND d.id = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$Itm  = $conn->result;
	
	$sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numItmCats  	= $conn->numberrows;
	$resultItmCats  = $conn->result;
	
	if ($Itm['has_pic']=='1')
	{
		$sql="SELECT * FROM doctor_pics WHERE doctorID='".$Itm['id']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPics=$conn->result;
		$numPics=$conn->numberrows;
	}
	
   if($numPics>0 && is_file('../../pics/doctors/'.$resultPics[0]['url_thumb'])) $picFile= '../pics/doctors/'.$resultPics[0]['url_thumb'];
   else $picFile = '../pics/doctors/no_photo_thumb.png';
   	
  
   $response .=	'<div style="float:left;background-color:#B9F4A8; width:320px;">';
   $response .= '<div  style="float:left; margin-left:5px; width:250px; " align="left"><strong style="color:#FF8400">'.$resultItmCats[0]['doctor_category_name'].'</strong></div>';
                
   $response .= '<div style="float:left; margin-left:5px;width:290px; font-size: 14px; color: #333333;" align="justify">';
   $response .= '<table><tr>';
   $response .= '<td style="padding:10px;">';
   $response .= '<div style="float:left;background-image:url(images/fon_header_green.png); margin-left:0px;margin-bottom:0px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#FFFFFF;">';
   $response .= '<div style=" float:left; margin-left:5px; width:150px; font-weight:bold; color:#FFFFFF; " >'.$Itm['first_name'].' '.$Itm['last_name'].'</div>';
   $response .= '<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;">'.$Itm['locType'].' '.$Itm['location'].'</div>';
   $response .= '</div>';
   $response .= '<div  style="float:left;margin-top:5px; width:290px; overflow:hidden; ">';
   $response .= '<div style="float:left;margin-right:10px; border:double; border-color:#666666; height:80px; width:80px;" ><a href="?doctorID='.$Itm['id'].'"><img width="80" height="80" src="'.$picFile.'" /></a></div>';
					   
			       			
	//$response .= "Регистрирано от: ".$Itm['registered_on']."<br />"; 
	//$response .= "Свързани Здравни Заведения: ".$Itm['related_hospital']."<br />"; 
	//$response .= "Адрес: ".$Itm['address']."<br />"; 
	if ($numItmCats>0) 
	{
		$response .= " <b style='color:#009900;'>Специалности:</b> <span  style='color:#FF6600; '>"; 
	
		for($i=0;$i<$numItmCats;$i++)
		{
			$response .= $resultItmCats[$i]['doctor_category_name']."; "; 
		}
		$response .= "</span><br />";
	}
	
	$response .= "<b style='color:#009900;'>Адрес:</b> ".$Itm['address']."<br />"; 
	$response .= "<b style='color:#009900;'>Телефон:</b> ".$Itm['phone']."<br />"; 
	$response .= "<b style='color:#009900;'>Е-мейл:</b> ".$Itm['email']."<br />"; 
	$response .= "<b style='color:#009900;'>Уеб страница:</b> ".$Itm['web']."<br />"; 
	$response .= "<b style='color:#009900;'>Допълнително:</b> ".$Itm['info']."<br />"; 
						
	
       			
	$response .= '</tr></table>';
    $response .= '</div>';
            
    $response .= '</div>';
  
  
   
   print $response;
  ?>
 