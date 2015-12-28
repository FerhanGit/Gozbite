<?php
  
   require_once("../inc/dblogin.inc.php");
   

 $response ='';
   
	$sql="SELECT b.bolestID as 'bolestID', b.date as 'date', b.title as 'title', b.body as 'body', b.has_pic as 'has_pic', b.autor_type as 'autor_type', b.autor as 'autor', b.source as 'source' FROM bolesti b WHERE 1=1 ORDER BY b.date DESC LIMIT 5 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$Itm  = $conn->result;
	$numItms = $conn->numberrows;

	for($i=0;$i<$numItms;$i++)
	{
	
	// ============================= CATEGORIES =========================================

	$sql="SELECT bc.id as 'bolest_category_id', bc.name as 'bolest_category_name' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND b.bolestID = '".$Itm[$i]['bolestID']."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numItmCats[$i]  	= $conn->numberrows;
	$resultItmCats[$i]  = $conn->result;
	
	
// =============================== SIMPTOMS ========================================	

	$sql="SELECT bs.id as 'bolest_simptom_id', bs.name as 'bolest_simptom_name' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND b.bolestID = '".$Itm[$i]['bolestID']."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numItmSimptoms[$i]  	= $conn->numberrows;
	$resultItmSimptoms[$i]  = $conn->result;
	
	
	
	if ($Itm[$i]['has_pic']=='1')
	{
		$sql="SELECT * FROM bolesti_pics WHERE bolestID='".$Itm[$i]['bolestID']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPics[$i] = $conn->result;
		$numPics[$i] = $conn->numberrows;
	}
	
   if($numPics[$i]>0 && is_file('../../pics/bolesti/'.$resultPics[$i][0]['url_thumb'])) $picFile= '../pics/bolesti/'.$resultPics[$i][0]['url_thumb'];
   else $picFile = '../pics/bolesti/no_photo_thumb.png';
	

	   $response .=	'<div style="float:left;width:320px;font-size:11px;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'bolesti.php?bolestID='.$Itm[$i]['id'].'\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\';" onMouseout="this.style.backgroundColor=\'transparent\';">';
	   $response .= '<table><tr>';
	   $response .= '<td >';
	   $response .= '<div style="float:left; border:double; border-color:#333333; height:35px; width:35px;" ><a href="bolesti.php?bolestID='.$Itm[$i]['id'].'"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
	   $response .= '<div style=" float:left; margin-left:10px; width:260px; color:#FF0000; " >'.$Itm[$i]['title'].'</div>';
	   $response .= '<div  style="float:left;background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:260px;color:#FF0000; " >'.$resultItmCats[$i][0]['bolest_category_name'].' | '.$resultItmSimptoms[$i][0]['bolest_simptom_name'].'</div>';
	         			
	   $response .= '</tr></table>';	            
	   $response .= '</div>';
	  
  
	}
	
   print $response;
  ?>
 