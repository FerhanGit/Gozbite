<?php
include_once("../inc/dblogin.inc.php");


$edit=substr($_SERVER['HTTP_REFERER'],strpos($_SERVER['HTTP_REFERER'],"edit=")+5);

if (isset($edit))
{
	$editID=$edit;
	$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', p.post_category as 'post_category', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id AND postID='".$edit."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultEdit=$conn->result;

	
}

?>

<div style="float:left; margin-top:10px; width:600px;">

				    <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
				  		<input type="image" value="Редактирай" src="images/btn_gren.png" id="edit_btn" title="Редактирай" name="edit_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96" />
					
					</div>
				  <br /><br /><br />
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
				Раздел:  <select name="post_category" id="post_category">
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT * FROM post_category";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCat=$conn->result;
						$numCat=$conn->numberrows;
						for ($i=0;$i<$numCat;$i++)
               {?>      
			 	  <option value = "<?=$resultCat[$i]['id']?>" <?php if ($resultCat[$i]['id'] == $resultEdit['post_category']) print "selected";?>><?=$resultCat[$i]['name']?></option> 
                             
               <?php } ?>
				  </select>
				  <br /> <br />
				  
				 Заглавие на Статията:<br /> <textarea rows = "2" cols = "40"  name="post_title" id="post_title" ><?=$resultEdit['title']?></textarea>
				  <br /> <br />
				  
				 Текст на Статията:<br /> 
			<?php 
				 include_once("../FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('post_body') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '400';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = $resultEdit['body'];
		         $oFCKeditor->Create();
			?> 
				 <br /> <br />
							 
				 Източник на Статията:<br /> <input value = "<?=$resultEdit['source']?>" type="text" size="20"  name="post_source" id="post_source" />
				  <br /> <br />
				  
				  Снимка <input type="checkbox" name="post_pic" id="post_pic" onclick=" if(this.checked) {document.getElementById('picsDv').style.display='inline';} else {document.getElementById('picsDv').style.display='none';}">
					
				 <div id="picsDv" style="display:none;">
					<?php  
				  		
                  			print "<div style = \"margin: 0px 0px 5px 0px;\">\n";
                  			print " <input type = \"file\" name = \"post_pic\">";
                  			print "</div>\n";
               	  		
               
           		 	?>
				  	
           		 	 	
		                  	<div style="float:left;margin-top:18px;margin-left:10px;overflow:auto;">
		        <?php
					  if ($resultEdit['picURL']<>'')
					  {  print "<div style='float:left; margin:0px; height:276px; width:400px;' >";
						 
				?>        			
			       			<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60"  src="../pics/posts/<?php if($resultEdit['picURL']<>'') print $resultEdit['postID']."_thumb.jpg"; else print "no_photo_thumb.png";?>" />
			       			</div>
			       			<div style="float:left;cursor:pointer;" >
			       			<a onclick="if(!confirm('Сигурни ли сте?')) {return false;}" href="?edit=<?=$edit?>&deletePic=<?=$resultEdit['picURL']?>"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
			       			</div>
			     <?php 
						 
						  print "</div>";
					}
		         ?>
		           		 	</div>			
           		 	
           		 	
           		 	</div>			
						  

				  </div>