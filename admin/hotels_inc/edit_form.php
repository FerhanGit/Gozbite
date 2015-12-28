<?php

include_once("../inc/dblogin.inc.php");

$edit=substr($_SERVER['HTTP_REFERER'],strpos($_SERVER['HTTP_REFERER'],"edit=")+5);



if (isset($edit))
{
	$editID=$edit;
	
	$sql="SELECT * FROM doctors WHERE id='".$edit."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultEdit=$conn->result;
	
	$sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$edit."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numEditCats  	= $conn->numberrows;
	$resultEditCats = $conn->result;
	for($i=0;$i<$numEditCats;$i++)
	{
		$resultEdtCat[] = $resultEditCats[$i]['doctor_category_id'];
	}
	
	
	
    if ($resultEdit['has_pic']=='1')
	{
		$sql="SELECT * FROM doctor_pics WHERE doctorID='".$edit."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPics=$conn->result;
		$numPics=$conn->numberrows;
	}
	
}


?>

<div id="search_form" style="float:left; margin-top:0px; width:420px;color:#009900;">

				    <div style="float:left; margin-left:0px; margin-top:0px; margin-bottom:0px; width:100px;">
					
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
				  
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='99999999'>
				  <input type='hidden' name='edit' value='<?=$edit?>'>
				  
				  
				  
				  <br /><br />
				   <div style = "margin: 10px 10px 10px 10px;">
		            <label for = "doctor_category">категории*</label><br>
		            <?php
		               print "     <select name = \"doctor_category[]\" id = \"doctor_category\" multiple size = \"15\" align = \"left\" style = \"margin-right: 10px;\">\n";
		               print "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
		               require_once("../classes/DoctorCategoriesList.class.php");
		               $CCList = new DoctorCategoriesList($conn);
		               if($CCList->load())
		                  $CCList->showSelectMultipleList(0, "", $resultEdtCat?$resultEdtCat:0);
		               print "     </select>\n";
		               print "<span class = \"txt10\">За избор на повече от една категория,<br />натиснете и задръжте клавиша <b>Ctrl</b><br />и изберете с левия бутон на мишката.</span>\n";
		            ?>
		         </div>
         
				

                                    
				   <br /> <br />
				   <br style="clear:left;" />     
				  
				<table  border="0" align="center">
				 	<tr>
                        <td align="right">Име:</td>                        
                        <td><input type="text" style="width:100px;" name="first_name" id="first_name" value = "<?php print (strlen($resultEdit['first_name']) > 0) ? $resultEdit['first_name'] : ""; ?>">
						</td>
                          <td align="right">Фамилия:</td>
                          <td><input type="text" style="width:100px;" name="last_name" id="last_name" value = "<?php print (strlen($resultEdit['last_name']) > 0) ? $resultEdit['last_name'] : ""; ?>">
						</td>						
                     </tr>
                       <br />
                        
                      <tr>
                        <td align="right">Телефон:</td>
                          <td><input type="text" style="width:100px;" name="phone" id="phone" value = "<?php print (strlen($resultEdit['phone']) > 0) ? $resultEdit['phone'] : ""; ?>" >
						</td>
                    	<td align="right">E-mail:</td>
                         <td><input type="text" style="width:100px;" name="email" id="email" value = "<?php print (strlen($resultEdit['email']) > 0) ? $resultEdit['email'] : ""; ?>" >
                         </td>
                      </tr>    
                      
		               
                      <br />
                      
                      <tr>
                        <td align="right">Уеб сраница:</td>                        
                        <td><input type="text" style="width:100px;" name="web" id="web" value = "<?php print (strlen($resultEdit['web']) > 0) ? $resultEdit['web'] : ""; ?>">
						</td>
                          <td align="right">Свързано Здравно Заведение:</td>
                          <td><input type="text" style="width:100px;" name="related_hospital" id="related_hospital" value = "<?php print (strlen($resultEdit['related_hospital']) > 0) ? $resultEdit['related_hospital'] : ""; ?>">
						</td>						
                     </tr>
                       <br />
                        
                      
                       <tr>    	
                    				
    					<td colspan="2" align="left">Населено място:
                              <div id = "city" style = "float:left; width:200px; margin-right:10px; overflow-y: auto;overflow-x: none; border: 1px solid #cccccc;">
                              <input type = "hidden" name = "lctnID" id = "lctnID" value = "<?php print (strlen($lctnID) > 0) ? $lctnID : ""; ?>"  />
                           		<select style="width:200px;" name="cityName" id="cityName" >				
                            	<option value ="">избери</option>		
                               <?php
                             
                                 
                                    $sql = sprintf("SELECT id, name FROM locations WHERE loc_type_id IN (2) ORDER BY name");
                                    $conn->setSQL($sql);
                                    $conn->getTableRows();
                                    $resultCity=$conn->result;
                                    $numCity = $conn->numberrows;
                                    if( $numCity> 0) {
                                                                              
                                       	 for($i = 0; $i < $numCity; $i++) 
                                       	 {?>      
										 	  <option value = "<?=$resultCity[$i]['id']?>" <?php if ($resultCity[$i]['id'] == $resultEdit['location_id']) print "selected";?>><?=$resultCity[$i]['name']?></option> 
							                             
							       <?php } 
                                      
                                     }                                 
                                    ?>
                                
                             
                              </select>
                              </div>                              
                              </td>
                              <td align="right">Адрес:</td>
                         	 <td><textarea rows="3" cols="15" name="address" id="address" ><?php print (strlen($resultEdit['addr']) > 0) ? $resultEdit['addr'] : ""; ?></textarea>
                         </td>                            
                              				   					
    					</tr>
    					<br />                  
                                      
                      
    </table>

						
				 <div style="float:left;margin:10px;margin-left:0px;"> 
				&nbsp;&nbsp;Описание: 
				  <?php 
				 include_once("../FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('info') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '400';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = $resultEdit['info'];
		         $oFCKeditor->Create();
			?> 
				   </div>
				   
					 <div style="float:left;margin:10px;margin-left:0px;width:220px;"> 
					 Снимки:
							<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
                  	
                  	</div>
                  	
                  	<div style="float:left;margin-top:18px;margin-left:10px;">
        <?php
			  if ($resultEdit['has_pic']=='1')
			  {  print "<div style='float:left; margin:0px;  width:200px;' >";
				  for ($p=0;$p<$numPics;$p++)
				  { 
		?>        			
	       			<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60" onclick = "get_pic('big_pic', '<?=$resultPics[$p]['url_big']?>' ); "  src="../pics/doctors/<?php if($resultEdit['has_pic']=='1') print $resultPics[$p]['url_thumb']; else print "no_photo_thumb.png";?>" />
	       			</div>
	       			<div style="float:left;cursor:pointer;" >
	       			<a  onclick="if(!confirm('Сигурни ли сте?')) {return false;}" href="?deletePic=<?=$resultPics[$p]['url_big']?>"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
	       			</div>
	     <?php 
				  }
				  print "</div>";
			}
         ?>
           		 	</div>				  
				 
   	 <div style = "float:left;margin: 10px 10px 10px 10px;width:400px;">
            <label><br /><br />.:: Видео Представяне ::.</label><br /><br />
            <?
            	$video_name = $edit;
            	
				if(file_exists("../../videos/doctors/".$video_name.".flv"))
				{
					$video = "../../videos/doctors/".$video_name.".flv";
					?>
					<br>
					
						<br>
					
					<div id="videoDIV"  style="margin-left:0px;">
					<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
						<script type="text/javascript">
							var FO = {movie:"flash_flv_player/flvplayer.swf",width:"300",height:"170",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
							flashvars:"file=<?=$video?>&image=../videos/doctors/<?=$video_name.'_thumb.jpg'?>" };
							UFO.create(FO, "player1");
						</script>
					</div>
					
					<a onclick="if(!confirm('Сигурни ли сте?')){return false;}" href="?deleteVideo=<?=$video_name?>"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
	       			
				<?       
				} ?>
				         				
				<input type="file" name="imagefile">  <label>Прикачи видео</label><br>
				
				<?
				if(is_array($_REQUEST)) {
				      for(reset($_REQUEST); $filedName = key ($_REQUEST); next($_REQUEST)) {
				         $$filedName = $_REQUEST[$filedName];
				      }
				   }
				//$big_resize= "-s 320x240 -r 15  -b 768"; 
				//$normal_resize= "-s 320x240 -r 15  -b 160";
				//$small_resize= "-s 240x180 -r 8  -b 90";  
				
				?>
	   </div>
	   
	   
	   
           		 	
 </div>