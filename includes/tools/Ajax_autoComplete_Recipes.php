<?php 
		require_once '../header.inc.php';
   
		header('Content-type: text/html;charset=utf-8');
		
  
		if(isset($_GET['queryString'])) 
		{

			if(detect_i_explorer()) $queryString = trim(iconv('windows-1251','UTF-8',$_GET['queryString']));
			else $queryString = trim($_GET['queryString']);
		
			 $sql = sprintf("SELECT id as 'id' , title as 'title'
                      FROM recipes 
                      WHERE LOWER(title) LIKE LOWER('%%%s%%') AND from_vkusnotiiki_net <> 1 ORDER BY title ASC ", $queryString);  //order by neshto, taka che naj-tyrsenite da sa otpred
			  $conn->setsql($sql);
		      $conn->getTableRows();
			  $numHints  	= $conn->numberrows;
			  $resultHints  = $conn->result;
		      if($numHints > 0) {
		         for($i = 0; $i < $numHints; $i++) {
		         	
		         	?>
		             <li onClick = "updateRecipeSelect('<?=$resultHints[$i]['title']?>',<?=$resultHints[$i]['id']?>);fill('<?=$resultHints[$i]['title']?>');"><?=str_replace(ucfirst($queryString),'<font color="#FF6600;">'.ucfirst($queryString).'</font>',htmlspecialchars($resultHints[$i]['title']))?></li>
					<?php
		         }
		      }
		      else 
		      {
		      	?>
	             	<li>Няма резултат, започващ с тези символи!</li>
				<?php
		      }
      
			
		} 

?>