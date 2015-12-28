<?php

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
		
 
/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/  
$locatons_intro = "";

$locatons_intro .= '
<div class="boxRight">
	<div class="title">Опознай света си за да го обикнеш!</div>
      

<div id="PrStuffDiv" align="center" style="padding-left:10px;  padding:10px 0px 10px 0px;">
  <div style=" margin:5px;">';
		  	        
		        
	



	
	$sql="SELECT l.id as 'id', l.name as 'location_name', lt.name as 'locType', l.info as 'info', l.youtube_video as 'youtube_video' FROM locations l, location_types lt WHERE l.loc_type_id = lt.id AND ( LENGTH(l.info)>10 OR l.id IN (SELECT locationID FROM location_pics)) AND lt.id = l.loc_type_id ORDER BY RAND() LIMIT 1";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numlocationBig = $conn->numberrows;
	$resultlocationBig = $conn->result;
	
	
	
	
	
if($numlocationBig > 0)
{
  
	for($l = 0; $l < $numlocationBig; $l++)
	{ 
		//--------------------------- PICS ------------------------------------------
		
		$sql="SELECT * FROM location_pics WHERE locationID='".$resultlocationBig[$l]['id']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPicsLoc[$l] = $conn->result;
		$numPicsLoc[$l]	= $conn->numberrows;
	
$locatons_intro .= '
			<div class="detailsDiv" style="float:left; width:280px; margin-bottom:20px; margin-right:5px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">		  		
		  		<h4><a style="font-size:14px; color:#0099FF; font-weight:bold;" href="разгледай-дестинация-'.$resultlocationBig[$l]['id'].','.myTruncateToCyrilic($resultlocationBig[$l]['locType']." ".$resultlocationBig[$l]['location_name'],200,' ','').'.html">'.$resultlocationBig[$l]['locType'].' '.$resultlocationBig[$l]['location_name'].'</a></h4>	
			</div>	
			<br style="clear:both;">	
				<ul id="thumbs">';
		
			  	 $cntPics = 0;
				  foreach ($resultPicsLoc[$l] as $picFileLoc )
				  { 
				  	if($cntPics ==6) continue;
				      			
		   				$locatons_intro .= '<li class="thumbDiv"><a href="разгледай-дестинация-'.$resultlocationBig[$l]['id'].','.myTruncateToCyrilic($resultlocationBig[$l]['locType']." ".$resultlocationBig[$l]['location_name'],200,' ','').'.html"><img width="60" height="60"  src="';
		   				$locatons_intro .= 'pics/locations/'.$picFileLoc['url_thumb'].'" /></a></li>';
			
				 	$cntPics++;
				  }
			$locatons_intro .= '	
				</ul>
					<br style="clear:both;">	';
			

			
	}
	
}

$locatons_intro .= ' </div>
</div>

</div>';

return $locatons_intro;
	  
?>
