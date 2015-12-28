<?php 
		require_once '../header.inc.php';
   
		header('Content-type: text/html;charset=utf-8');
		
  
		if(isset($_GET['queryString'])) 
		{

			if(detect_i_explorer()) $queryString = trim(iconv('windows-1251','UTF-8',$_GET['queryString']));
			else $queryString = trim($_GET['queryString']);
		
			 $sql = sprintf("SELECT id as 'id' , name as 'name'
                      FROM locations 
                      WHERE LOWER(name) LIKE LOWER('%s%%') AND loc_type_id IN (2, 5, 14, 15, 16, 19) ORDER BY searchRate DESC, name ASC ", $queryString);  //order by neshto, taka che naj-tyrsenite da sa otpred

			  $conn->setsql($sql);
		      $conn->getTableRows();
			  $numHints  	= $conn->numberrows;
			  $resultHints  = $conn->result;
		      if($numHints > 0) {
		         for($i = 0; $i < $numHints; $i++) {
		         	
		         	?>
		             <li onClick = "updateLocSelect('<?=$resultHints[$i]['name']?>',<?=$resultHints[$i]['id']?>);fill('<?=$resultHints[$i]['name']?>');"><?=str_replace(ucfirst($queryString),'<font color="#FF6600;">'.ucfirst($queryString).'</font>',htmlspecialchars(locationTracker($resultHints[$i]['id'])))?></li>
					<?php
		         }
		      }
		      else 
		      {
		      	?>
	             	<li>Няма населено място започващо с тези символи!</li>
				<?php
		      }
      
			
		} 

?>