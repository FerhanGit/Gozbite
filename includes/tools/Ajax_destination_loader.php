<?php
   require_once '../header.inc.php';
   header('Content-type: text/html;charset=utf-8');
		
  	if(detect_i_explorer()) 
	foreach ($_REQUEST as $key => $value)
	{
		$_REQUEST[$key] = iconv("windows-1251","UTF-8",$value);
		if($_REQUEST[$key] == 'undefined') {$_REQUEST[$key] = '';}
	}


   $response = "";
   
	
// --------------------------- START SEARCH ------------------------------
	
		$response .= '<table><tr><td>'; 
		     $response .= '<div class="postBig">';
							
			
				if ($_REQUEST['letter']!="")  
				{
					$sql="SELECT DISTINCT(l.id) as 'loc_id', l.name as 'loc_name', lt.name as 'locType' FROM locations l, location_types lt WHERE ( LENGTH(l.info)>10 OR l.id IN (SELECT locationID FROM location_pics)) AND lt.id = l.loc_type_id AND LEFT(LOWER(l.name),1) LIKE LOWER('".$_REQUEST['letter']."') ORDER BY l.name";
					$conn->setsql($sql);
					$conn->getTableRows();
					$numDestinationsByLetter    = $conn->numberrows;
					$resultDestinationsByLetter = $conn->result;
					
					if($numDestinationsByLetter > 0) 
					{ 
						$response .= '<table cellpadding="2"><tr>';
							
						for($n = 0, $cn = 1; $n < $numDestinationsByLetter; $n++, $cn++) 
						{							
							$response .= '<td width="93"><h4 style="font-size:12px; margin: 3px 0px 0px 0px; padding-left:3px; color: #0099FF; background: #F1F1F1 url(../images/gradient_tile.png) repeat 0 -5px;"><a  style="font-size:12px;" href="разгледай-дестинация-'.$resultDestinationsByLetter[$n]['loc_id'].','.myTruncateToCyrilic($resultDestinationsByLetter[$n]['locType']." ".$resultDestinationsByLetter[$n]['loc_name'],50," ","").'.html">'.$resultDestinationsByLetter[$n]['locType'].' '.$resultDestinationsByLetter[$n]['loc_name'].'</a></h4></td>';
						 	if($cn % 3 == 0) { $response .= "</tr><tr>"; }
						 	if($cn == $numDestinationsByLetter) { $response .= "</tr>"; }
						}																		 	 
						
						$response .= '</table>';	
					}					
					else
					{	
						$response .= "Няма дестинации започващи с буквата <font color='#FF6600'><b>".$_REQUEST['letter'] ."</b></font>" ;
					}
					
				}
	
			$response .= '</div>';
		$response .= '</td></tr></table>';
		
	
   print $response;
?>