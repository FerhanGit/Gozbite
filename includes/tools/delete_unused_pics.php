<?php
	header('Content-type: text/html;charset=utf-8');
	ini_set('max_execution_time', '8750');
   include_once("inc/dblogin.inc.php");

 $dir="pics/".$_REQUEST['delete_what']."/";
 
 $cntAll = 0;
 $cntDeleted = 0; 
 
 $idsArray['posts'] = 'postID';
 $idsArray['recipes'] = 'id';
 $idsArray['drinks'] = 'id';
 $idsArray['guides'] = 'id';
 $idsArray['users'] = 'userID';
 $idsArray['firms'] = 'id';
 
 
 
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
 			
 			$sql=sprintf("SELECT ".$idsArray[$_REQUEST['delete_what']]." FROM ".$_REQUEST['delete_what']." WHERE ".$idsArray[$_REQUEST['delete_what']]." = %d",$ID);
			$conn->setsql($sql);
			$conn->getTableRow();
			$numItems=$conn->numberrows;
		

			if ($numItems == 0) // Ако не е открит запис се изтрива снимката
			{ 
    /*
   				if(unlink($dir.$file))
   				{
   					echo "<font color='green'>Успешно изтрито:".$file."</font><br />";
   				}
   				else 
   				{
   					echo "<font color='red'>Изтриването неуспешно:".$file."</font><br />";
   				}
				$cntDeleted ++;
	*/
			}
			$cntAll ++;
 			
 		}
 
 	}
 	
 	closedir($d); 
 }  
 
  print "<br /><br /><br /><br />Изтрити Снимки:".$cntDeleted." От общо:".$cntAll;

   $conn->closedbconnection();
  
?>