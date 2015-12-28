<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");   	
	
   	$conn = new mysqldb();
   
   		
	$insert_edit_survey = "";
	
	
	
// ------------------СТАРТ на Вкарване на Survey -----------------------
   
//=========================================================
 if (isset($_REQUEST['insert_survey_btn']))
 {
     
     if (!empty($_REQUEST['survey_body']))
     {
     		 
       	    
        $sql="INSERT INTO surveys SET 	body='".addslashes($_REQUEST['survey_body'])."',
        							 	start_date=NOW(),
        								end_date = (NOW() + INTERVAL 3 DAY) 
        								ON DUPLICATE KEY UPDATE
        								active = '1'								 							
        	 							";
    	$conn->setsql($sql);
    	$last_ID=$conn->insertDB();
    	
		for($n=0;$n<sizeof($_REQUEST['surveys_ansers']);$n++)    	
		{
	    	$sql="INSERT INTO surveys_ansers SET survey_ID='".$last_ID."',
	        							 	anser='".addslashes($_REQUEST['surveys_ansers'][$n])."',
	        							 	cnt = '0' 
	        								ON DUPLICATE KEY UPDATE
	        								survey_ID = '".$last_ID."'							 							
	        	 							";
	    	$conn->setsql($sql);
	    	$conn->insertDB();
	    	
		}	 
    		 
    
    	$insert_edit_survey .='<script type="text/javascript">
	       	alert(\'Анкетата беше успешно добавена!\'); 
	     	window.location.href=\'разгледай-анкета-'.$last_ID.',анкети_и_допитвания_за_актуални_теми_от_ежедневието_и_още.html\';
		</script>';
    	
    }
    else 
    {
       $insert_edit_survey .='<script type="text/javascript">
	       	alert(\'Не сте попълнили задължителните полета!\'); 
	     	window.location.href=\'разгледай-анкети,анкети_и_допитвания_за_актуални_теми_от_ежедневието_и_още.html\';
		</script>';
    }
}

// --------------------Край на Survey --------------------------------	
//=========================================================
 if (isset($_REQUEST['edit_btn']) && isset($_REQUEST['edit']))
 {
     
     if (!empty($_REQUEST['survey_body']))
     {
     		 
       	    
        $sql="UPDATE surveys SET body='".addslashes($_REQUEST['survey_body'])."',
        						 start_date='".$_REQUEST['fromDate']."',
        						 end_date = ('".$_REQUEST['fromDate']."' + INTERVAL 3 DAY) 
        						 WHERE ID ='".$_REQUEST['edit']."' 									 							
        	 					 ";
    	$conn->setsql($sql);
    	$last_ID=$conn->updateDB();
    		 

    	$sql="DELETE FROM surveys_ansers WHERE survey_ID='".$_REQUEST['edit']."'";
	    $conn->setsql($sql);
	    $conn->updateDB();
	    	
	    	
    	for($n=0;$n<sizeof($_REQUEST['surveys_ansers']);$n++)    	
		{
			
	    	$sql="INSERT INTO surveys_ansers SET survey_ID='".$_REQUEST['edit']."',
	        							 	anser='".addslashes($_REQUEST['surveys_ansers'][$n])."',
	        							 	cnt = '0' 
	        								ON DUPLICATE KEY UPDATE
	        								survey_ID = '".$last_ID."'							 							
	        	 							";
	    	$conn->setsql($sql);
	    	$conn->insertDB();
	    	
		}	 
    		 	 
    
    	 $insert_edit_survey .='<script type="text/javascript">
	       	alert(\'Не сте попълнили задължителните полета!\'); 
	     	window.location.href=\'редактирай-анкета-'.$_REQUEST['edit'].',анкети_и_допитвания_за_актуални_теми_от_ежедневието_и_още.html\';
		</script>';
    	
    }
    else 
    {
        $insert_edit_survey .='<script type="text/javascript">
	       	alert(\'Не сте попълнили задължителните полета!\'); 
	     	window.location.href=\'редактирай-анкета-'.$_REQUEST['edit'].',анкети_и_допитвания_за_актуални_теми_от_ежедневието_и_още.html\';
		</script>';
    }
}



if (isset($_REQUEST['delete']))
{
	  if (!empty($_REQUEST['delete']))
     {
     		 
       	    
        $sql="DELETE FROM surveys WHERE ID='".$_REQUEST['delete']."'";
    	$conn->setsql($sql);
    	$conn->updateDB();

    	$sql="DELETE FROM surveys_ansers WHERE survey_ID='".$_REQUEST['delete']."'";
    	$conn->setsql($sql);
    	$conn->updateDB();
    		 
    	$insert_edit_survey .='<script type="text/javascript">
	       	alert(\'Анкетата е изтрита успешно!\'); 
	     	window.location.href=\'разгледай-анкети,анкети_и_допитвания_за_актуални_теми_от_ежедневието_и_още.html\'; 
		</script>';
    }
    else 
    {
       
		$insert_edit_survey .='<script type="text/javascript">
	       	alert(\'Не сте избрали анкета за изтриване!\'); 
	     	window.location.href=\'разгледай-анкета-'.$_REQUEST['surveyID'].',анкети_и_допитвания_за_актуални_теми_от_ежедневието_и_още.html\';
		</script>';
        	
    }
		 
}

		

 	
	
	return $insert_edit_survey;
	  
	?>
