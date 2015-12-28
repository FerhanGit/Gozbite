<?php

 require_once("../inc/dblogin.inc.php");
  
if($_REQUEST['edit'] <> '')
{
	$edit = $_REQUEST['edit'];
}
else $insert = 1;

	

if (isset($edit))
{
	$editID=$edit;
	
   $sql = "select * from pages WHERE abriviature = '".$edit."' ";
   $conn->setSQL($sql);
   $conn->getTableRow();
   $resultEdit = $conn->result;
}


?>

<div style=" float:left; margin-top:16px;  margin-bottom:20px; margin-left:0px; padding-left:5px; color:#0066CC; font-weight:bold; font-size: 14px; font-family:  Arial, Helvetica, sans-serif; background-image:url(Images/grey_dot.png); background-position:bottom; background-repeat:repeat-x;">Редактиране на <?=$resultEdit['title']?></div>
<br style="margin-top:50px;"/>        	
<div id="search_form" style="margin-top:10px;margin-left:0px; ">


			<div style="margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
				  	<?php if (eregi("^[a-zA-Z]+",$edit))
				  		{	
				  	?>
				  		<input type="submit" value="Редактирай" id="edit_Btn_Page" title="Редактирай" name="edit_Btn_Page" >
				  	
				  	<?php 
				  		}
				  	?>
				  	
				  	<?php if($insert == 1)
				  		{	
				  	?>
				  		<input type="submit" value="Въведи" id="insert_Btn_Page" title="Въведи" name="insert_Btn_Page" >
					
				  	<?php 
				  		}

				  	?>
				
			  </div>
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='9999999999'>
				  <input type='hidden' name='edit' value='<?=$edit?>'>
				  <input type='hidden' name='insert' value='<?=$insert?>'>
				 
				
			<table><tr><td>  
					 
			<?php 
			if (isset($edit))
			{ 
			?>
				<br />	<br /><a onclick="if(!confirm('Сигурни ли сте?')){return false;}" href="?deletePage=<?=$edit?>"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"> Изтрий страницата</a>
	       	<?php } ?>		
			
	       	<br />	<br />	<br />
			 Абревиатура (на латиница - например "zemedelski_proekti") :<br /> <input type="text" name="abriviature" id="abriviature"  value="<?=$resultEdit['abriviature']?>">
				  <br /> <br />
				  
			  Подстраница на:  <select name="parent_id" id="parent_id" style="width:400px;">
	
				<option value ="">не е подстраница</option>
               <?php
                 		$sql="SELECT pageID, title FROM pages WHERE parent_id = 0 ORDER BY title";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCat=$conn->result;
						$numCat=$conn->numberrows;
						for ($i=0;$i<$numCat;$i++)
               {?>      
			 	  <option value = "<?=$resultCat[$i]['pageID']?>" <?=(($resultCat[$i]['pageID'] == $resultEdit['parent_id']) ? 'SELECTED' : '')?> > на <?=$resultCat[$i]['title']?> </option> 
                             
               <?php } ?>
				  </select>
				  <br /> <br />
				  
				   Ранг(по-малко число се появява по-отгоре) :<br /> <input type="text" name="rank" id="rank"  value="<?=$resultEdit['rank']?>">
				  <br /> <br />
				  
				<div style="">					
				<fieldset style="width:400px;overflow:auto;"><legend>Заглавие: </legend>
				<div style="margin:5px;margin-left:0px;overflow:auto;"> 
				
				 	<?php 
					 include_once("../../FCKeditor/fckeditor.php");
			         $oFCKeditor = new FCKeditor('title') ;
			         $oFCKeditor->BasePath   = "FCKeditor/";
			         $oFCKeditor->Width      = '400';
			         $oFCKeditor->Height     = '300' ;
			         $oFCKeditor->Value      = (strlen($resultEdit['title']) > 0) ? $resultEdit['title'] : ""; 
			         $oFCKeditor->Create();
					?> 
					
				 </div></fieldset>
				 					
				<fieldset style="width:400px;overflow:auto;"><legend>Title: </legend>
				<div style="margin:5px;margin-left:0px;overflow:auto;"> 
				
					<?php 
					 include_once("../../FCKeditor/fckeditor.php");
			         $oFCKeditor = new FCKeditor('body') ;
			         $oFCKeditor->BasePath   = "FCKeditor/";
			         $oFCKeditor->Width      = '400';
			         $oFCKeditor->Height     = '300' ;
			         $oFCKeditor->Value      = (strlen($resultEdit['body']) > 0) ? $resultEdit['body'] : ""; 
			         $oFCKeditor->Create();
					?> 
					
				 </div></fieldset>
			</div>
				 
								 			
			</td></td></tr>
			<tr><td>
				    
			 	             		
           	 
</td></tr></table>   
           		 	

						  
 </div>