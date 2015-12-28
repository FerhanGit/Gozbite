<?php
  
   require_once("../inc/dblogin.inc.php");
   

 
   
   $index=$_REQUEST['index'];
   $Itms = explode(',',$_REQUEST['Itms']);
   $itemID = $Itms[$index];
   $response = '';
  
	$sql="SELECT DISTINCT(h.id) as 'id', h.name as 'firm_name', h.manager as 'manager', h.phone as 'phone', h.address as 'address', h.email as 'email', h.web as 'web', l.name as 'location', lt.name as 'locType', h.registered_on as 'registered_on', h.description as 'description', h.has_pic as 'has_pic' FROM hospitals h, locations l, location_types lt WHERE h.location_id = l.id  AND l.loc_type_id = lt.id AND h.id = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$Itm  = $conn->result;
	
	$sql="SELECT hc.id as 'hospital_category_id', hc.name as 'hospital_category_name' FROM hospitals h, hospital_category hc, hospitals_category_list hcl WHERE hcl.hospital_id = h.id AND hcl.category_id = hc.id AND h.id = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numItmCats  	= $conn->numberrows;
	$resultItmCats  = $conn->result;
	
	if ($Itm['has_pic']=='1')
	{
		$sql="SELECT * FROM hospital_pics WHERE hospitalID='".$Itm['id']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPics=$conn->result;
		$numPics=$conn->numberrows;
	}
	
	
	
   if(is_file("../../pics/firms/".$resultHospitalBig['id']."_logo.jpg")) $picFile= "../pics/firms/".$resultHospitalBig['id']."_logo.jpg";
   else $picFile = '../pics/firms/no_logo.png';
   		 

   $response .=	'<div style="float:left;background-color:#B9F4A8; width:320px;">';
   $response .= '<div  style="float:left; margin-left:5px; width:250px; " align="left"><strong style="color:#FF8400">'.$Itm['firm_name'].'</strong></div>';
                
   $response .= '<div style="float:left; margin-left:5px;width:290px; font-size: 14px; color: #333333;" align="justify">';
   $response .= '<table><tr>';
   $response .= '<td style="padding:10px;">';
   $response .= '<div style="float:left;background-image:url(images/fon_header_green.png); margin-left:0px;margin-bottom:0px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#FFFFFF;">';
   $response .= '<div style=" float:left; margin-left:5px; width:150px; font-weight:bold; color:#FFFFFF; " >'.$Itm['manager'].'</div>';
   $response .= '<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;">'.$Itm['locType'].' '.$Itm['location'].'</div>';
   $response .= '</div>';
   $response .= '<div  style="float:left;margin-top:5px; width:290px; overflow:hidden; ">';
   $response .= '<div style="float:left;margin-right:10px; border:double; border-color:#666666; width:150px;" ><a href="?firmID='.$Itm['id'].'"><img width="150"  src="'.$picFile.'" /></a></div>';
					   
			       			
	$response .= "<b style='color: #009900;'>Адрес:</b> ".$Itm['address']."<br />"; 
	if ($numItmCats>0) 
	{
		$response .= " <b style='color: #009900;'>Категория:</b> <span  style='color:#FF6600; '>"; 
	
		for($i=0;$i<$numItmCats;$i++)
		{
			$response .= $resultItmCats[$i]['hospital_category_name']."; "; 
		}
		$response .= "</span><br />";
	}
	$response .= "<b style='color: #009900;'>Телефон:</b> ".$Itm['phone']."<br />"; 
	$response .= "<b style='color: #009900;'>Е-мейл:</b> ".$Itm['email']."<br />"; 
	$response .= "<b style='color: #009900;'>Уеб Страница:</b> ".$Itm['web']."<br />"; 
	$response .= "<b style='color: #009900;'>Описание:</b> ".$Itm['description']."<br />"; 
						
	
       			
	$response .= '</tr></table>';
    $response .= '</div>';
            
    $response .= '</div>';
  
  
   
   print $response;
  ?>
 