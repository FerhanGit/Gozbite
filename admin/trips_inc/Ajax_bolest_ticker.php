<?php
  
   require_once("../inc/dblogin.inc.php");
   

 
   
   $index=$_REQUEST['index'];
   $Itms = explode(',',$_REQUEST['Itms']);
   $itemID = $Itms[$index];
   $response = '';
  
	$sql="SELECT b.bolestID as 'bolestID', b.date as 'date', b.title as 'title', b.body as 'body', b.has_pic as 'has_pic', b.autor_type as 'autor_type', b.autor as 'autor', b.source as 'source' FROM bolesti b WHERE 1=1 AND b.bolestID = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$Itm  = $conn->result;
	
// ============================= CATEGORIES =========================================

	$sql="SELECT bc.id as 'bolest_category_id', bc.name as 'bolest_category_name' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND b.bolestID = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numItmCats  	= $conn->numberrows;
	$resultItmCats  = $conn->result;
	
	
// =============================== SIMPTOMS ========================================	

	$sql="SELECT bs.id as 'bolest_simptom_id', bs.name as 'bolest_simptom_name' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND b.bolestID = '".$itemID."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numItmSimptoms  	= $conn->numberrows;
	$resultItmSimptoms  = $conn->result;
	
	
	
	if ($Itm['has_pic']=='1')
	{
		$sql="SELECT * FROM bolesti_pics WHERE bolestID='".$Itm['bolestID']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPics=$conn->result;
		$numPics=$conn->numberrows;
	}
	
   if($numPics>0 && is_file('../../pics/bolesti/'.$resultPics[0]['url_thumb'])) $picFile= '../pics/bolesti/'.$resultPics[0]['url_thumb'];
   else $picFile = '../pics/bolesti/no_photo_thumb.png';
    

   $response .=	'<div style="float:left;background-color:#FDC8B9; width:320px;">';
   $response .= '<div  style="float:left; margin-left:5px; width:250px; " align="left"><strong style="color:#FF8400">'.$Itm['title'].'</strong></div>';
                
   $response .= '<div style="float:left; margin-left:5px;width:290px; font-size: 14px; color: #333333;" align="justify">';
   $response .= '<table><tr>';
   $response .= '<td style="padding:10px;">';
   $response .= '<div style="float:left;background-image:url(images/fon_header_red.png); margin-left:0px;margin-bottom:5px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#FFFFFF;">';
   $response .= '<div style="float:left; margin-left:5px;"><div style="float:left; color:#000000; "><i>'.$Itm['date'].'</i></div></div><div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:10px;">'.substr($resultItmCats[0]['bolest_category_name'],0,24).'</div>';
   $response .= '</div>';
   $response .= '<div  style="float:left;margin-top:5px; width:290px; overflow:hidden; ">';
   $response .= '<div style="float:left;margin-right:10px; border:double; border-color:#666666; height:100px; width:100px;" ><a href="?bolestID='.$Itm['bolestID'].'"><img width="100" height="100" src="'.$picFile.'" /></a></div>';

   if ($numItmCats>0) 
	{
		$response .= " <b style='color:#FF0000; '>Категория:</b> <span>"; 
	
		for($i=0;$i<$numItmCats;$i++)
		{
			$response .= $resultItmCats[$i]['bolest_category_name']."; "; 
		}
		$response .= "</span><br />";
	} 
	
	if ($numItmSimptoms>0) 
	{
		$response .= " <b style='color:#FF0000; '>Симптоми:</b> <span>"; 
	
		for($i=0;$i<$numItmSimptoms;$i++)
		{
			$response .= $resultItmSimptoms[$i]['bolest_simptom_name']."; "; 
		}
		$response .= "</span><br />";
	} 
			       			
	$response .= "<b style='color:#FF0000; '>Подробности:</b>".substr($Itm['body'],0,300).'...<div align="right"><a href="bolesti.php?&bolestID='.$Itm['bolestID'].'">Още</а></div>'; 
						
	
       			
	$response .= '</tr></table>';
    $response .= '</div>';
            
    $response .= '</div>';  
                
     
   
   print $response;
  ?>
 