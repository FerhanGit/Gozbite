<?php
include_once("../inc/dblogin.inc.php");

?>
<div style="float:left; margin-top:10px; width:520px;">

				    <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
							<input type="image" onclick="document.searchform.action='posts_inc/import_posts.php';"  value="Импортирай" src="images/btn_gren_insert.png" id="import_btn" title="Импортирай Оферти" name="import_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
					  </div>
				  <br /><br /><br />				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>				
		
				XML<br />
				<div  id = "import_source" style = "float:left; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                                <select style="width:400px;" name="import_source" id="import_source" >
					  				<option value="http://news.ibox.bg/rss_1">----NEWS.BG----</option>
					  				<option value="http://dnes.dir.bg/rss20.xml">----DIR.BG----</option>					  						
				  				</select>
                </div>       
						  
	
</div>