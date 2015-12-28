<?php
   include_once("../inc/dblogin.inc.php");
   
  


   $response = "";
   
   if($_REQUEST['mainCat']!='' or $_REQUEST['mainCat']!='-1')
   { 
		$sql="SELECT * FROM news_category WHERE parentID = '".$_REQUEST['mainCat']."' ORDER BY name";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultCat=$conn->result;
		$numCat=$conn->numberrows;
		if($numCat>0)
		{
			$response .= 'Подкатегории:  <select name="news_sub_category" id="news_sub_category" >';
			$response .= '<option value ="">избери</option>';
		           
			for ($i=0;$i<$numCat;$i++)          
			{  	
				      		
		                    
					 $response .= '<option value = '.$resultCat[$i]['id'].'>'.$resultCat[$i]['name'].'</option> ';
		                             
		              
			}			
				
	 		$response .= '</select>';	   
		} 
   }
   print $response;
?>