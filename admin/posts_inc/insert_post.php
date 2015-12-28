<?php

include_once("../inc/dblogin.inc.php");

?>

<div id="search_form" style="float:left; margin-top:10px; width:600px;">


	<div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
				  		<input type="image"  value="Добави" src="images/btn_gren_insert.png" id="insert_btn" title="Добави Новина" name="insert_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
					
				
				   </div>
				  <br /><br /><br />
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
				Раздел:  <select name="post_category" id="post_category" onchange="getSubCats(this.value);">
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT * FROM post_category WHERE parentID = 0 ORDER BY name";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCat=$conn->result;
						$numCat=$conn->numberrows;
						for ($i=0;$i<$numCat;$i++)
               {?>      
			 	  <option value = "<?=$resultCat[$i]['id']?>"><?=$resultCat[$i]['name']?></option> 
                             
               <?php } ?>
				  </select>
				  <br /> <br />
				 
				  <div id="SubCatsDiv"> </div>
				   <br /> <br />
				 
				 Заглавие на Статията:<br /> <textarea rows = "2" cols = "40"  name="post_title" id="post_title" ></textarea>
				  <br /> <br />
				  
				 Текст на Статията:<br /> 
			<?php 
				 include_once("../FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('post_body') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '400';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = "";
		         $oFCKeditor->Create();
			?> 
				 <br /> <br />
							 
				 Източник на статията:<br /> <input type="text" size="20"  name="post_source" id="post_source" />
				  <br /> <br />
			
				 Снимка <input type="checkbox" name="post_pic" id="post_pic" onclick=" if(this.checked) {document.getElementById('picsDv').style.display='inline';} else {document.getElementById('picsDv').style.display='none';}">
					
				 <div id="picsDv" style="display:none;">
					<?php  
				  		
                  			print "<div style = \"margin: 0px 0px 5px 0px;\">\n";
                  			print " <input type = \"file\" name = \"post_pic\">";
                  			print "</div>\n";
               	  		
               
           		 	?>
				  	
           		 	</div>			
           		 	
           		 	
				  </div>