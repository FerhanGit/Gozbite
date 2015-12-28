<?php
include_once("../inc/dblogin.inc.php");

?>

<div style="float:left; margin-top:10px; width:600px;">

				    <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
				  		<input type="image" value="Редактирай" src="images/btn_gren.png" id="edit_comment_btn" title="Редактирай" name="edit_comment_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
					
					</div>
				  <br /><br /><br />
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
				Избери новина:  <select name="all_post" id="all_post" style="width:300px;" onchange="new Ajax.Updater('comment_edit_div' , 'posts_inc/ajax_comment_edit.php', {parameters: { all_postID: $F('all_post') }});">
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT postID,title FROM posts ORDER BY title";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultAllPosts=$conn->result;
						$numAllPosts=$conn->numberrows;
						for ($i=0;$i<$numAllPosts;$i++)
               {?>      
			 	  <option value = "<?=$resultAllPosts[$i]['postID']?>" ><?=$resultAllPosts[$i]['title']?></option> 
                             
               <?php } ?>
				  </select>
				  <br /> <br />
				  
							
				 <div id="comment_edit_div"></div>			
    					
			</div>