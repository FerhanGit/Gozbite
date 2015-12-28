<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
   		
	$pr_stuff = "";

  	$sql="SELECT pr.prID as 'prID', pr.firm_id as 'firmID', pr.user_id as 'userID', pr.body as 'pr_body', pr.active as 'active' FROM pr_stuff pr WHERE active=1 ORDER BY RAND()";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultPrActiv 	= $conn->result;	
	$numPrActiv 	= $conn->numberrows;
	
	
	
if($numPrActiv>0)
{
  $pr_stuff .= '<div class="boxRight">
	<div class="title">Обърнете внимание</div>
      

<div id="SurveyDiv" align="justify" style="padding-left:10px;  padding:10px 0px 10px 0px;">
  <div style=" margin:5px;">';
 
	for($pr = 0; $pr < $numPrActiv; $pr++)
	{ 
		if($resultPrActiv[$pr]['firmID'] > 0) 
		{
			$sql="SELECT DISTINCT(f.id) as 'id', f.name as 'firm_name', l.name as 'location', lt.name as 'locType', f.registered_on as 'registered_on', f.has_pic as 'has_pic' FROM firms f, locations l, location_types lt WHERE f.location_id = l.id  AND l.loc_type_id = lt.id  AND f.id='".$resultPrActiv[$pr]['firmID']."' ";
			$conn->setsql($sql);
			$conn->getTableRow();
			$resultFirms  = $conn->result;
			$numFirms  	= $conn->numberrows;
			
			$sql="SELECT fc.id as 'firm_category_id', fc.name as 'firm_category_name' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id AND f.id = '".$resultPrActiv[$pr]['firmID']."' ";
			$conn->setsql($sql);
			$conn->getTableRows();
			$numItmCats[$pr]  	= $conn->numberrows;
			$resultItmCats[$pr]  = $conn->result;
			
			
            if(is_file("pics/firms/".$resultFirms['id']."_logo.jpg")) $picFile1= "pics/firms/".$resultFirms['id']."_logo.jpg";
            else $picFile1 = 'pics/firms/no_logo.png';
		   	
	
			$pr_stuff .= '<a href="разгледай-фирма-'.$resultFirms['id'].','.myTruncateToCyrilic($resultFirms['firm_name'],200,'_','') .'.html">'.$resultFirms['firm_name'].'</a> | 
                <a href="разгледай-дестинация-'.$resultFirms['location_id'] .','.$resultFirms['locType']."_".$resultFirms['location'] .'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html">'.$resultFirms['locType'].' '.$resultFirms['location'].'</a> | 
                <a href="фирми-категория-'.$resultItmCats[$pr][0]['firm_category_id'].',Закусвалня.html">'.$resultItmCats[$pr][0]['firm_category_name'].'</a>
            <hr /><br /><br />
			<a href="firms.php?firmID='.$resultFirms['id'].'"><img width="80" src="'.$picFile1.'" /></a>
            <hr /><br /><br />
			<div>'.$resultPrActiv[$pr]['pr_body'].'</div>
	   	
			<br /><hr><br />';
        }
		
        // Tuk trqbva da dobavim i sekciqta za potrebiteli 
	
	}
	
  $pr_stuff .= '</div>
</div>

</div>';


 } 

	return $pr_stuff;
	  
?>
