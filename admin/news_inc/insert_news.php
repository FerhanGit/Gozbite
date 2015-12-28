<?php

include_once("../inc/dblogin.inc.php");

?>
<div id="search_form" style="float:left; margin-top:10px; width:600px;">


	<div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
				  		<input type="image"  value="Добави" src="images/btn_gren_insert.png" id="insert_btn" title="Добави Новина" name="insert_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
					
				
				   </div>
				  <br /><br /><br />
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
			
				  Раздел:  <select name="news_category" id="news_category" onchange="getSubCats(this.value);">
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT * FROM news_category WHERE parentID = 0 ORDER BY name";
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
				  
				 
				 Заглавие на Новината:<br /> <textarea rows = "2" cols = "40"  name="news_title" id="news_title" ></textarea>
				  <br /> <br />
				  
				 Текст на Новината:<br /> 
			<?php 
				 include_once("../FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('news_body') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '400';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = "";
		         $oFCKeditor->Create();
			?> 
				 <br /> <br />
							 
				 Източник на статията:<br /> <input type="text" size="20"  name="news_source" id="nws_source" />
				  <br /> <br />
			
				 Снимка <input type="checkbox" name="news_pic" id="news_pic" onclick=" if(this.checked) {document.getElementById('picsDv').style.display='inline';} else {document.getElementById('picsDv').style.display='none';}">
					
				 <div id="picsDv" style="display:none;">
					<?php  
				  		
                  			print "<div style = \"margin: 0px 0px 5px 0px;\">\n";
                  			print " <input type = \"file\" name = \"news_pic\">";
                  			print "</div>\n";
               	  		
               
           		 	?>
				  	
           		 	</div>			
           		 	
           		 	
				  </div>