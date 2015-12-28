<?php 
		require_once '../header.inc.php';
		header('Content-type: text/html;charset=utf-8');
		
		if(isset($_GET['queryString']) && !empty($_GET['queryString'])) 
		{
?>
			<div align="right">&rarr; <a href="javascript:void(0);" onclick="$('#suggestions').hide();" style="color:#FF6600; font-weight:bold;">Затвори</a></div><br /><br />
			
<?php

			if(detect_i_explorer()) $queryString = trim(iconv('windows-1251','UTF-8',$_GET['queryString']));
			else $queryString = trim($_GET['queryString']);
		
			 $sql = sprintf("SELECT id as 'id' , name as 'name'
                      FROM bolest_simptoms 
                      WHERE LOWER(name) LIKE LOWER('%%%s%%') ORDER BY name ASC ", $queryString);  
			
			  $conn->setsql($sql);
		      $conn->getTableRows();
			  $numHints  	= $conn->numberrows;
			  $resultHints  = $conn->result;
		      if($numHints > 0) {
		         for($i = 0; $i < $numHints; $i++) {
		           	?>
		             <li onClick = "updateSimptomSelect('<?=($_REQUEST['pg_curr'] == 'home_page'?'home_page':'bolesti')?>','<?=myTruncateToCyrilic($resultHints[$i]['name'],100,"_","")?>','<?=$resultHints[$i]['id']?>');fill('<?=$resultHints[$i]['name']?>');"><?=str_replace(ucfirst($queryString),'<font color="#FF6600;">'.ucfirst($queryString).'</font>', str_ireplace(ucfirst($queryString),"<font color='red'><b>".ucfirst($queryString)."</b></font>", $resultHints[$i]['name']) )?></li>
					<?php 
		         }
		      }
		      else 
		      {
		      	?>
	             	<li>Няма симптом, съдържащ тези символи!</li>
				<?php
		      }
      
			
		} 

?>