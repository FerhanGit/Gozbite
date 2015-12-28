<?php
   include_once("../inc/dblogin.inc.php");
   
  


   $response = "";
   
	$sql="SELECT * FROM post_category WHERE parentID = '".$_REQUEST['mainCat']."' ORDER BY name";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultCat=$conn->result;
	$numCat=$conn->numberrows;
	if($numCat>0)
	{
		$response .= 'Подкатегории:  <select name="post_sub_category" id="post_sub_category" onchange="">';
		$response .= '<option value ="">избери</option>';
	           
		for ($i=0;$i<$numCat;$i++)          
		{  	
			      		
	                    
				 $response .= '<option value = '.$resultCat[$i]['id'].'>'.$resultCat[$i]['name'].'</option> ';
	                             
	              
		}			
			
 $response .= '</select>';	   
} 
   print $response;
?>