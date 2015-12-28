<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
 	$pages_main_edit = "";

   	$edit=$_REQUEST['edit'];

	
		
	if (isset($edit))
	{
		$editID=$edit;
		
	   $sql = "select * from pages WHERE abriviature = '".$edit."' ";
	   $conn->setSQL($sql);
	   $conn->getTableRow();
	   $resultEdit = $conn->result;
	   
		/* Ne dopuskame redakciq na drugi osven ADMINi */
		if($_SESSION['user_kind'] != 2) exit;
		
		
	}


$pages_main_edit .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">

<div style="margin-top:16px;  margin-bottom:20px; margin-left:0px; padding-left:5px; color:#0066CC; font-weight:bold; font-size: 14px; font-family:  Arial, Helvetica, sans-serif; background-image:url(Images/grey_dot.png); background-position:bottom; background-repeat:repeat-x;"><h4>Редактиране '.(strlen($resultEdit['title']) > 0 ? 'на <b>'.$resultEdit['title'].'</b>' : '').'</h4></div>
     	
			<div style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">';
					
				   		if (eregi("^[a-zA-Z]+",$edit))
				  		{					  
				  			$pages_main_edit .= '<input type="submit" value="Редактирай" id="edit_Btn_Page" title="Редактирай" name="edit_Btn_Page" >';
				  		}
				  
				  					  	
				
$pages_main_edit .= ' </div>
				  
				  <input type=\'hidden\' name=\'MAX_FILE_SIZE\' value=\'9999999999\'>
				  <input type=\'hidden\' name=\'edit\' value=\''.$edit.'\'>
				
			<table><tr><td>  
					  
						<div style="">					
				<fieldset style="width:600px;overflow:auto;"><legend>Заглавие: </legend>
				<div style="margin:10px;margin-left:0px;overflow:auto;"> ';
				
				 
					 include_once("FCKeditor/fckeditor.php");
			         $oFCKeditor = new FCKeditor('title') ;
			         $oFCKeditor->BasePath   = "FCKeditor/";
			         $oFCKeditor->Width      = '600';
			         $oFCKeditor->Height     = '300' ;
			         $oFCKeditor->Value      = (strlen($resultEdit['title']) > 0) ? $resultEdit['title'] : ""; 
			          $pages_main_edit .= $oFCKeditor->CreateHtml();
					
			         
$pages_main_edit .= '</div></fieldset>
				 					
				<fieldset style="width:600px;overflow:auto;"><legend>Title: </legend>
				<div style="margin:10px;margin-left:0px;overflow:auto;">'; 
				
				
					 include_once("FCKeditor/fckeditor.php");
			         $oFCKeditor = new FCKeditor('body') ;
			         $oFCKeditor->BasePath   = "FCKeditor/";
			         $oFCKeditor->Width      = '600';
			         $oFCKeditor->Height     = '300' ;
			         $oFCKeditor->Value      = (strlen($resultEdit['body']) > 0) ? $resultEdit['body'] : ""; 
			         $pages_main_edit .= $oFCKeditor->CreateHtml();
					
$pages_main_edit .= '</div></fieldset>
			</div>
				 
								 			
			</td></td></tr>
			<tr><td>
				    
			 	             		
           	 
</td></tr></table>   
           		 	
<div style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">';

	if (eregi("^[a-zA-Z]+",$edit))
	{					  
		$pages_main_edit .= '<input type="submit" value="Редактирай" id="edit_Btn_Page" title="Редактирай" name="edit_Btn_Page" >';
	}
				  
				  					  	
				
$pages_main_edit .= ' </div>
						  
 </div> </div>';
	

	        
	    
	return $pages_main_edit;
	  
	?>
