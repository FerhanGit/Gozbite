<?php
include_once("../inc/dblogin.inc.php");


$edit=substr($_SERVER['HTTP_REFERER'],strpos($_SERVER['HTTP_REFERER'],"edit=")+5);

if (isset($edit))
{
	$editID=$edit;
	
	$sql = sprintf("SELECT b.bolestID as 'id', b.title as 'title', b.body as 'body', b.autor as 'autor', b.source as 'source', b.has_pic as 'has_pic', b.date as 'date', b.discovered_on as 'discovered_on' FROM bolesti b WHERE b.bolestID = %d", $editID);
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultEdit=$conn->result;
	
	$sql="SELECT bc.id as 'bolest_category_id', bc.name as 'bolest_category_name' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND bcl.bolest_id = '".$resultEdit['id']."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numEditCats  	= $conn->numberrows;
	$resultEditCats = $conn->result;
	for($i=0;$i<$numEditCats;$i++)
	{
		$resultEditCat[] = $resultEditCats[$i]['bolest_category_id'];
	}
	
	$sql="SELECT bs.id as 'bolest_simptom_id', bs.name as 'bolest_simptom_name' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND bsl.bolest_id = '".$resultEdit['id']."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numEditSimptoms  	= $conn->numberrows;
	$resultEditSimptoms = $conn->result;
	for($i=0;$i<$numEditSimptoms;$i++)
	{
		$resultEditSimptom[] = $resultEditSimptoms[$i]['bolest_simptom_id'];
	}
	
	
	
    if ($resultEdit['has_pic']=='1')
	{
		$sql="SELECT * FROM bolesti_pics WHERE bolestID='".$resultEdit['id']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPics=$conn->result;
		$numPics=$conn->numberrows;
	}
	
}


?>

<div id="search_form" style="float:left; margin-top:10px; width:600px;">


	<div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
				  	<?php if (eregi("^[0-9]+",$edit))
				  		{	
				  	?>
				  		<input type="image" value="Редактирай" src="images/btn_gren.png" id="edit_btn" title="Редактирай" name="edit_btn" style="float:left;border: 0pt none ; " height="20" type="image" width="96">
				  	
				  	<?php 
				  		}
				  	?>
				  	
				  	<?php if (!eregi("^[0-9]+",$edit))
				  		{	
				  	?>
				  		<input type="image" value="Въведи" src="images/btn_gren.png" id="insert_btn" title="Въведи" name="insert_btn" style="float:left;border: 0pt none ; " height="20" type="image" width="96">
					
				  	<?php 
				  		}
				  	?>
				
				   </div>
				  <br /><br /><br />
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
				  <input type='hidden' name='edit' value='<?=$edit?>'>
				<div  id = "bolest_cats" style = "float:left;margin-bottom:20px; overflow-y: auto;overflow-x: none; height: 200px;width: 400px; border: 1px solid #cccccc;">

				<div style = "margin: 10px 10px 10px 10px;">
		            <label for = "bolest_category">категории*</label><br>
		            <?php
		               print "     <select name = \"bolest_category[]\" id = \"bolest_category\" multiple size = \"15\" align = \"left\" style = \"margin-right: 10px;\">\n";
		               print "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
		               require_once("../classes/BolestCategoriesList.class.php");
		               $CCList = new BolestCategoriesList($conn);
		               if($CCList->load())
		                  $CCList->showSelectMultipleList(0, "", $resultEditCat?$resultEditCat:0);
		               print "     </select>\n";
		               print "<span class = \"txt10\">За избор на повече от една категория,<br />натиснете и задръжте клавиша <b>Ctrl</b><br />и изберете с левия бутон на мишката.</span>\n";
		            ?>
				    </div>
         
                   
                 </div>                              
                   <br /> <br style="clear:left;" />   
				  
				  
				 <div  id = "bolest_simptoms" style = "float:left;margin-bottom:20px; overflow-y: auto;overflow-x: none; height: 200px;width: 400px; border: 1px solid #cccccc;">
                 	Симптоми:  
				  <?php
                     $sql = sprintf("SELECT * FROM bolest_simptoms ORDER BY name");
                     $conn->setsql($sql);
                     $conn->getTableRows();
                     $resultSimptoms=$conn->result;
                     $numSimptoms = $conn->numberrows;
                     if( $numSimptoms> 0) {
                      	print "	<ul style = \"margin: 0; padding: 0;\">\n";
                   	 for($i = 0; $i < $numSimptoms; $i++) 
                   	 { ?>
                    	 	<li><input  type = "checkbox" id = "bolest_simptom<?=$i?>" name = "bolest_simptom[]" value = "<?=$resultSimptoms[$i]['id']?>" style = "border: 0; vertical-align: middle;" <?php if (is_array($resultEditSimptom) && in_array($resultSimptoms[$i]['id'], $resultEditSimptom)) print "checked";?>/>&nbsp;<label for = "bolest_simptom<?=$i?>" style = "color: #444; vertical-align: middle;"><?=$resultSimptoms[$i]['name']?></label></li>
                   	 <?php }
                      print "</ul>\n";
                     }                                 
                     ?>
                 </div>                              
                   <br /> <br style="clear:left;" />         
				 
				 Име на Болеста:<br /> <textarea rows = "2" cols = "40"  name="bolest_title" id="bolest_title" ><?=(strlen($resultEdit['title']) > 0) ? $resultEdit['title'] : ""; ?></textarea>
				  <br /> <br />
				  
				 Описание на Болеста:<br /> 
			<?php 
				 include_once("../FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('bolest_body') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '400';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = (strlen($resultEdit['body']) > 0) ? $resultEdit['body'] : ""; 
		         $oFCKeditor->Create();
			?> 
				 <br /> <br style="clear:left;" />
							 
				 Източник на статията:<br /> <input type="text" size="20"  name="bolest_source" id="bolest_source" value="<?php print (strlen($resultEdit['source']) > 0) ? $resultEdit['source'] : ""; ?>"/>
				  <br /> <br style="clear:left;" />
				  
				 <div style="float:left;margin:10px;margin-left:0px;width:220px;"> 
					 Снимки:
							<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
                  	
                  	</div>
                  	
                  	<div style="float:left;margin-top:18px;margin-left:10px;width:200px;">
        <?php
			  if ($resultEdit['has_pic']=='1')
			  {  print "<div style='float:left; margin:0px; height:276px; width:200px;' >";
				  for ($p=0;$p<$numPics;$p++)
				  { 
		?>        			
	       			<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60" onclick = "get_pic('big_pic', '<?=$resultPics[$p]['url_big']?>' ); "  src="../pics/bolesti/<?php if($resultEdit['has_pic']=='1') print $resultPics[$p]['url_thumb']; else print "no_photo_thumb.png";?>" />
	       			</div>
	       			<div style="float:left;cursor:pointer;" >
	       			<a onclick="if(!confirm('Сигурни ли сте?')){return false;}" href="?deletePic=<?=$resultPics[$p]['url_big']?>"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
	       			</div>
	     <?php 
				  }
				  print "</div>";
			}
         ?>
           		 	</div>				  
				 
           		 	
 </div>