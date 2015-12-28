<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/



	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
   	$vips_main = "";
	
	
	$sql="SELECT f.id as 'id', f.name as 'firm_name', f.phone as 'phone', f.address as 'address', f.email as 'email', f.manager as 'manager', l.id as 'location_id', l.name as 'location', lt.name as 'locType', f.registered_on as 'registered_on', f.description as 'description', f.has_pic as 'has_pic' FROM firms f, locations l, location_types lt WHERE f.location_id = l.id  AND l.loc_type_id = lt.id AND f.is_VIP = '1' AND f.is_VIP_end > NOW() AND f.active = '1' ORDER BY rand() LIMIT 8";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultFirmsVIP=$conn->result;
	$numFirmsVIP=$conn->numberrows;
   	
	
   		
	$vips_main .= '<table><tr><td>	';	
		
	
	if($numFirmsVIP>0 && $_REQUEST['search']<>1)
	{

		$vips_main .= '<div class="pagingVip"><h3 style="font-weight:bold;" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Бъди VIP за 1 седмица] body=[&rarr; Изпрати SMS с текст <span style="color:#FF6600;font-weight:bold;">forvip</span> на номер <span style="color:#FF6600;font-weight:bold;">1094</span> (цена с ДДС - 4.80лв.) и въведи получения код в твоя профил (*само за Заведения/Фирми).]\'>VIP Заведения / Фирми</h3></div>

				 
		 <!-- ARTICLES LIST -->	 
		 
		 <ul class="listingHotelsVip">';
			
		 
		
        for ($i=0;$i<$numFirmsVIP;$i++)
        { 
            if ($resultFirmsVIP[$i]['has_pic']=='1')
            {
                $sql="SELECT * FROM firm_pics WHERE firmID='".$resultFirmsVIP[$i]['id']."'";
                $conn->setsql($sql);
                $conn->getTableRows();
                $resultPicsMain[$i]=$conn->result;
                $numPicsMain[$i]=$conn->numberrows;
            }

                $sql="SELECT fc.id as 'firm_category_id', fc.name as 'firm_category_name' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id AND f.id = '".$resultFirmsVIP[$i]['id']."' ";
                $conn->setsql($sql);
                $conn->getTableRows();
                $numFirmCats[$i]  	= $conn->numberrows;
                $resultFirmCats[$i] = $conn->result;

                $randFirmCat = rand( 0 , ($numFirmCats[$i]-1) );
$vips_main .= '
				<li class="item" style="float:left;">
				<div class="listLink" align="center" style="margin-bottom:10px;" onmouseover="$(\'firm_link_'.$i .'\').style.color=\'#FFF\'" onmouseout="$(\'firm_link_'.$i .'\').style.color=\'#0099FF\'"><a id="firm_link_'.$i .'" href="разгледай-фирма-'.$resultFirmsVIP[$i]['id'].','.myTruncateToCyrilic($resultFirmsVIP[$i]['firm_name'],200,'_','') .'.html">Виж профила</a></div>
				<div class="listArea" align="center">
				 	<h3 align="left"><a style="font-size:13px; color:#0099FF; font-weight:bold; margin-left:5px;" href="разгледай-фирма-'.$resultFirmsVIP[$i]['id'].','.myTruncateToCyrilic($resultFirmsVIP[$i]['firm_name'],200,'_','') .'.html">'.$resultFirmsVIP[$i]['firm_name'] .'</a></h3>
<!--				 	<a href="разгледай-фирма-'.$resultFirmsVIP[$i]['id'].','.myTruncateToCyrilic($resultFirmsVIP[$i]['firm_name'],200,'_','') .'.html"><img width="80"  src="'.((is_file("pics/firms/".$resultFirmsVIP[$i]['id']."_logo.jpg"))?"image.php?i=pics/firms/".$resultFirmsVIP[$i]['id']."_logo.jpg&fh=&fv=&ed=&gr=&rw=150&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5":"pics/firms/no_logo.png").'"/></a></a> -->
                    <a href="разгледай-фирма-'.$resultFirmsVIP[$i]['id'].','.myTruncateToCyrilic($resultFirmsVIP[$i]['firm_name'],200,'_','') .'.html"><img width="80"  src="'.((is_file("pics/firms/".$resultFirmsVIP[$i]['id']."_logo.jpg")) ? "pics/firms/".$resultFirmsVIP[$i]['id']."_logo.jpg" : "pics/firms/no_logo.png").'"/></a></a>
				 </div>
				 <p>
				 	<h3 style="text-transform:none;"><a style="color:#FFF; font-size:12px; " href="фирми-категория-'.$resultFirmCats[$i][$randFirmCat]['firm_category_id'].','.myTruncateToCyrilic($resultFirmCats[$i][$randFirmCat]['firm_category_name'],200,'_','') .'.html" >&rarr; '.$resultFirmCats[$i][$randFirmCat]['firm_category_name']  .' </a></h3>
				 	<h3 style="text-transform:none;"><a style="color:#FFF; font-size:12px; " href="разгледай-дестинация-'.$resultFirmsVIP[$i]['location_id'] .','.$resultFirmsVIP[$i]['locType']."_".$resultFirmsVIP[$i]['location'] .'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html" >&rarr; '.$resultFirmsVIP[$i]['locType']." ".$resultFirmsVIP[$i]['location'] .' </a></h3>
				 	&rarr; '.$resultFirmsVIP[$i]['address'] .'<br />
				<!-- 	&rarr; '.myTruncate($resultFirmsVIP[$i]['description'], 200, " ").'-->
				 </p>
				 </li>';
				if(($i+1)%4==0) $vips_main .= '<br style="clear:both;"/>'; 
			
			 } 
			
			$vips_main .= '</ul>';
			
			
		 
			  
				
			
			} 
			
	
			
$vips_main .= '</td></tr></table>';
   
   	
		
	return $vips_main;
	  
?>
