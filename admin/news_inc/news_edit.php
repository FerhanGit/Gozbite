<?php
include_once("../inc/dblogin.inc.php");


$edit=substr($_SERVER['HTTP_REFERER'],strpos($_SERVER['HTTP_REFERER'],"edit=")+5);

if (isset($edit))
{
	$editID=$edit;
	$sql="SELECT n.newsID as 'newsID', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', n.news_category as 'news_category', nc.name as 'category' FROM news n, news_category nc WHERE n.news_category=nc.id AND newsID='".$edit."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultEdit=$conn->result;

	
}

?>

<div style="float:left; margin-top:10px; width:600px;" >

				    <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
				  		<input type="image" value="Редактирай" src="images/btn_gren.png" id="edit_btn" title="Редактирай" name="edit_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96" />
					
					</div>
				  <br /><br /><br />
				  

			 Раздел:  <select name="news_category" id="news_category" ">
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT * FROM news_category ORDER BY name,parentID";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCat=$conn->result;
						$numCat=$conn->numberrows;
						for ($i=0;$i<$numCat;$i++)
		               	{?>      
					 		<option value = "<?=$resultCat[$i]['id']?>" <?=($resultCat[$i]['id']==get_ParentNewsCat($resultEdit['news_category']))?'selected':''?>><?=($resultCat[$i]['parentID']<>0)?'---':''?><?=$resultCat[$i]['name']?></option> 
		                 
		                <?php } ?>
				  </select>
				  <br /> <br />
				 
				  <div id="SubCatsDiv"> </div>
				   <br /> <br />  
				     
			 	              
              
				  
				 Заглавие на Новината:<br /> <textarea rows = "2" cols = "40"  name="news_title" id="news_title" ><?=$resultEdit['title']?></textarea>
				  <br /> <br />
				  
				 Текст на Новината:<br /> 
			<?php 
				 include_once("../FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('news_body') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '400';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = $resultEdit['body'];
		         $oFCKeditor->Create();
			?> 
				 <br /> <br />
							 
				 Източник на статията:<br /> <input value = "<?=$resultEdit['source']?>" type="text" size="20"  name="news_source" id="nws_source" />
				  <br /> <br />
				  
				  Снимка <input type="checkbox" name="news_pic" id="news_pic" onclick=" if(this.checked) {document.getElementById('picsDv').style.display='inline';} else {document.getElementById('picsDv').style.display='none';}">
					
				 <div id="picsDv" style="display:none;">
					<?php  
				  		
                  			print "<div style = \"margin: 0px 0px 5px 0px;\">\n";
                  			print " <input type = \"file\" name = \"news_pic\">";
                  			print "</div>\n";
               	  		
               
           		 	?>
				  	
           		 		
						  
           		 	
		                  	<div style="float:left;margin-top:18px;margin-left:10px;overflow:auto;">
		        <?php
					  if ($resultEdit['picURL']<>'')
					  {  print "<div style='float:left; margin:0px; height:276px; width:400px;' >";
						 
				?>        			
			       			<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60"  src="../pics/news/<?php if($resultEdit['picURL']<>'') print $resultEdit['newsID']."_thumb.jpg"; else print "no_photo_thumb.png";?>" />
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