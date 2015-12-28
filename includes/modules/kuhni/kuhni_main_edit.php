<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
 	$kuhni_main_edit = "";

   	$edit=$_REQUEST['edit'];

	
		
	if (isset($edit))
	{
		$editID=$edit;
		
	   $sql = "select * from kuhni WHERE id = '".$edit."' ";
	   $conn->setSQL($sql);
	   $conn->getTableRow();
	   $resultEdit = $conn->result;
	   
		/* Ne dopuskame redakciq na drugi osven ADMINi */
		if($_SESSION['user_kind'] != 2) exit;
		
		
	}


$kuhni_main_edit .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">

<div style="margin-top:16px;  margin-bottom:20px; margin-left:0px; padding-left:5px; color:#0066CC; font-weight:bold; font-size: 14px; font-family:  Arial, Helvetica, sans-serif; background-image:url(Images/grey_dot.png); background-position:bottom; background-repeat:repeat-x;"><h4>Редактиране '.(strlen($resultEdit['name']) > 0 ? 'на <b>'.$resultEdit['name'].' кухня</b>' : '').'</h4></div>
     	
			<div style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">';
					
				  		
				if (eregi("^[0-9]+",$edit))
		  		{	
		  			$kuhni_main_edit .= '<input type="submit" value="Редактирай Описанието" id="edit_btn" title="Редактирай Описанието" name="edit_btn" onclick="return checkForCorrectDataKuhni();">';	
		  		}		  
		  		elseif (!eregi("^[0-9]+",$edit))
		  		{			  	
		  			$kuhni_main_edit .= '<input type="submit" value="Добави Описанието" id="insert_btn" title="Добави Описанието" name="insert_btn"  onclick="return checkForCorrectDataKuhni();">';	
		  		}
		  					  	
				
$kuhni_main_edit .= ' </div>
				  
				  <input type=\'hidden\' name=\'MAX_FILE_SIZE\' value=\'9999999999\'>
				  <input type=\'hidden\' name=\'edit\' value=\''.$edit.'\'>
				
			<table><tr><td>  
					  
			<div style="">					
				 <fieldset style="width:600px;overflow:auto;"><legend>Наименование на Кухнята: </legend>
				 <div style="margin:10px;margin-left:0px;overflow:auto;">			
				 <textarea rows = "2" cols = "53"  name="name" id="name" >'.$resultEdit['name'].'</textarea>';		         
$kuhni_main_edit .= '</div></fieldset>
				 					
				<fieldset style="width:600px;overflow:auto;"><legend>Описание: </legend>
				<div style="margin:10px;margin-left:0px;overflow:auto;">'; 
				
				
					 include_once("FCKeditor/fckeditor.php");
			         $oFCKeditor = new FCKeditor('info') ;
			         $oFCKeditor->BasePath   = "FCKeditor/";
			         $oFCKeditor->Width      = '600';
			         $oFCKeditor->Height     = '300' ;
			         $oFCKeditor->Value      = (strlen($resultEdit['info']) > 0) ? stripslashes($resultEdit['info']) : ""; 
			         $kuhni_main_edit .= $oFCKeditor->CreateHtml();
					
$kuhni_main_edit .= '</div></fieldset>
			</div>
				 
								 			
			</td></td></tr>
			<tr><td>
				    
			 	             		
           	 
</td></tr></table>   
           		 	
<div style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">';

	if (eregi("^[0-9]+",$edit))
	{	
		$kuhni_main_edit .= '<input type="submit" value="Редактирай Описанието" id="edit_btn" title="Редактирай Описанието" name="edit_btn" onclick="return checkForCorrectDataKuhni();">';	
	}		  
	elseif (!eregi("^[0-9]+",$edit))
	{			  	
		$kuhni_main_edit .= '<input type="submit" value="Добави Описанието" id="insert_btn" title="Добави Описанието" name="insert_btn"  onclick="return checkForCorrectDataKuhni();">';	
	}
		  					  
				  	
				
$kuhni_main_edit .= ' </div>
						  
 </div> </div>';
	

	        
	    
	return $kuhni_main_edit;
	  
	?>
