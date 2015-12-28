<?php
	
	ini_set('max_execution_time', '8750');
    require_once("../inc/config.inc.php");
    require_once("../classes/mysqldb.class.php");
    
    $conn = new mysqldb();
  

 $dir="../../photo/offers/";
   
 if(is_dir($dir))
 {
 	$d=opendir($dir);
 	
 	while ($file=readdir($d))
    { 
 		if (($file!=".") && ($file!=".."))
 		{
 			$findme   = '_';
			$pos = strpos($file, $findme);
			$ID=substr($file,0,$pos);
 			
 		$sql=sprintf("SELECT id FROM offers WHERE id=%d",$ID);
			$conn->setsql($sql);
			$conn->getTableRow();
			$broi_comp_ids=$conn->numberrows;
		

			if ($broi_comp_ids==0)
			{ 
    
   				unlink($dir.$file);
   				echo $file."\n";

			}
 			
 		}
 
 	}
 	
 	closedir($d); 
 }  
 
  

   $conn->closedbconnection();
  
?>