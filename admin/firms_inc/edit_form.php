<?php

include_once("../inc/dblogin.inc.php");


$edit=substr($_SERVER['HTTP_REFERER'],strpos($_SERVER['HTTP_REFERER'],"edit=")+5);



if (isset($edit))
{
	$editID=$edit;
	
	$sql="SELECT DISTINCT(h.id) as 'id', h.name as 'firm_name', h.username as 'username', h.password as 'password', h.phone as 'phone', h.address as 'address', h.email as 'email', h.web as 'web', h.manager as 'manager', l.name as 'location', l.id as 'location_id', h.registered_on as 'registered_on', h.description as 'description', h.has_pic as 'has_pic' FROM hospitals h, hospital_category hc , hospitals_category_list hcl ,locations l WHERE h.location_id = l.id  AND h.id = '".$edit."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultEdit=$conn->result;
	
	$sql="SELECT hc.id as 'hospital_category_id', hc.name as 'hospital_category_name' FROM hospitals h, hospital_category hc, hospitals_category_list hcl WHERE hcl.hospital_id = h.id AND hcl.category_id = hc.id AND hcl.hospital_id = '".$edit."' ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$numEditCats  	= $conn->numberrows;
	$resultEditCats = $conn->result;
	for($i=0;$i<$numEditCats;$i++)
	{
		$resultEdtCat[] = $resultEditCats[$i]['hospital_category_id'];
	}
	
	
	
    if ($resultEdit['has_pic']=='1')
	{
		$sql="SELECT * FROM hospital_pics WHERE hospitalID='".$edit."'";
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
				  
				  
				  <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>
				  <input type='hidden' name='edit' value='<?=$edit?>'>
				  
				  
				  
				  <br /><br />
				  
				 <div style = "margin: 10px 10px 10px 10px;">
		            <label for = "hospital_category">категории*</label><br>
		            <?php
		               print "     <select name = \"hospital_category[]\" id = \"hospital_category\" multiple size = \"15\" align = \"left\" style = \"margin-right: 10px;\">\n";
		               print "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
		               require_once("../classes/HospitalCategoriesList.class.php");
		               $CCList = new HospitalCategoriesList($conn);
		               if($CCList->load())
		                  $CCList->showSelectMultipleList(0, "", $resultEdtCat?$resultEdtCat:0);
		               print "     </select>\n";
		               print "<span class = \"txt10\">За избор на повече от една категория,<br />натиснете и задръжте клавиша <b>Ctrl</b><br />и изберете с левия бутон на мишката.</span>\n";
		            ?>
				    </div>
         
				   <br style="clear:left;" />     
				  
				  
				<table  border="0" align="center">
				 	<tr>
                        <td align="right">Потребителско име:</td>                        
                        <td><input type="text" style="width:100px;" name="username" id="username" value = "<?php print (strlen($resultEdit['username']) > 0) ? $resultEdit['username'] : ""; ?>">
						</td>
                          <td align="right">Парола:</td>
                          <td><input type="password" style="width:100px;" name="password" id="password" value = "<?php print (strlen($resultEdit['password']) > 0) ? $resultEdit['password'] : ""; ?>">
						</td>						
                     </tr>
                       <br />
                       <tr>
                        <td align="right">Наименование:</td>                        
                        <td><input type="text" style="width:100px;" name="firm_name" id="firm_name" value = "<?php print (strlen($resultEdit['firm_name']) > 0) ? $resultEdit['firm_name'] : ""; ?>">
						</td>
                          <td align="right">Управител:</td>
                          <td><input type="text" style="width:100px;" name="manager" id="manager" value = "<?php print (strlen($resultEdit['manager']) > 0) ? $resultEdit['manager'] : ""; ?>">
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
                         	 <td><textarea rows="3" cols="15" name="address" id="address" ><?php print (strlen($resultEdit['address']) > 0) ? $resultEdit['address'] : ""; ?></textarea>
                         </td>                            
                              				   					
    					</tr>
    					<br />                  
                                      
                      
    </table>

						
				 <div style="float:left;margin:10px;margin-left:0px;"> 
				&nbsp;&nbsp;Описание: 
				  <?php 
				 include_once("../FCKeditor/fckeditor.php");
		         $oFCKeditor = new FCKeditor('description') ;
		         $oFCKeditor->BasePath   = "FCKeditor/";
		         $oFCKeditor->Width      = '400';
		         $oFCKeditor->Height     = '300' ;
		         $oFCKeditor->Value      = $resultEdit['description'];
		         $oFCKeditor->Create();
			?> 
				   </div>
				   
					<div style="float:left;margin:10px;margin-left:0px;"> 
					 <fieldset style="width:200px">
				        <legend>&nbsp;Лого&nbsp;</legend>   
							<input type = "file" name = "pic_logo">	                  		
                  		</fieldset>
                  	</div>
                  	
           	 	<div style="float:left;margin-top:18px;margin-left:10px;">
       	      			
	       			<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; width:150px; overflow:hidden; cursor:pointer;" ><img width="150" src="<?=(is_file("../pics/firms/".$_REQUEST['edit']."_logo.jpg"))?"../pics/firms/".$_REQUEST['edit']."_logo.jpg":"../pics/firms/no_photo_big.png"?>" />
	       			</div>
	       			<div style="float:left;cursor:pointer;" >
	       			<a  onclick="if(!confirm('Сигурни ли сте?')){return false;}" href="?deleteLogo=<?=$_REQUEST['edit']."_logo.jpg"?>"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
	       			</div>
	    
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
			  {  print "<div style='float:left; margin:0px; height:276px; width:200px;' >";
				  for ($p=0;$p<$numPics;$p++)
				  { 
		?>        			
	       			<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60" onclick = "get_pic('big_pic', '<?=$resultPics[$p]['url_big']?>' ); "  src="../pics/firms/<?php if($resultEdit['has_pic']=='1') print $resultPics[$p]['url_thumb']; else print "no_photo_thumb.png";?>" />
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