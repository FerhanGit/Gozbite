<?php
include_once("../inc/dblogin.inc.php");

?>

<div style="float:left; margin-top:10px; width:600px;">

				    <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
				  		<input type="image" value="Редактирай" src="images/btn_gren.png" id="edit_comment_btn" title="Редактирай" name="edit_comment_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
					
					</div>
				  <br /><br /><br />
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
				Избери Здравно заведение:  <select name="all_hospitals" id="all_hospitals" style="width:220px;" onchange="new Ajax.Updater('comment_edit_div' , 'hospitals_inc/ajax_comment_edit.php', {parameters: { all_firmID: $F('all_hospitals') }});">
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT id,name FROM hospitals ORDER BY name";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultAllHospitals=$conn->result;
						$numAllHospitals=$conn->numberrows;
						for ($i=0;$i<$numAllHospitals;$i++)
               {?>      
			 	  <option value = "<?=$resultAllHospitals[$i]['id']?>" ><?=$resultAllHospitals[$i]['name']?></option> 
                             
               <?php } ?>
				  </select>
				  <br /> <br />
				  
							
				 <div id="comment_edit_div"></div>			
    					
			</div>