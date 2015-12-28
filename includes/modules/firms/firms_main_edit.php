<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   	
 	$firms_main_edit = "";

   	$edit=$_REQUEST['edit'];

   	/* Ne dopuskame redakciq na chujdi statii */
		
	if($edit > 0 && $edit != $_SESSION['userID'] && $_SESSION['userID'] != 1) exit;
	


	if (isset($edit))
	{
		$editID=$edit;
		
		$clauses = array();
	   	$clauses['where_clause'] = " AND f.id = '".$editID."'";
		$clauses['order_clause'] = '';
		$clauses['limit_clause'] = ' LIMIT 1';
		$firm_edit_info = $this->getItemsList($clauses);
	
		if(!$firm_edit_info)
		{
			return false;
		}
		$resultEdit = $firm_edit_info[$editID];	
		
					
		if($resultEdit['Cats'] > 0) 
		{				 	
			for($i=0; $i<$resultEdit['numCats']; $i++) 
			{						
				$firm_edit_cats_ids[$i] = $resultEdit['Cats'][$i]['firm_category_id'];			
				$firm_edit_cats_names[$i] = $resultEdit['Cats'][$i]['firm_category_name'];						
			} 
		}	
	}
	//$firms_main_edit .=print_r($resultEdit,1);
	
$firms_main_edit .= '<div class="detailsDivMap" style="width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
							<div id="mymap" style="width: 660px; height: 290px;"></div>
								<div id="mapHelpDiv" style="margin-top:5px;margin-left:0px;  padding:5px; width: 520px; background-color:#F7F7F7;">Позиционирайте местоположенитео си върху картата като кликнете с левия бутон на мишката върху желаното място.</div>
						</div>';

$firms_main_edit .= '<div id="search_form" style=" margin-top:0px; width:650px;">

<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
			
<div class="postBig">';
					
		        if (eregi("^[0-9]+",$edit))
		  		{		  
		  			$firms_main_edit .= '<input type="submit" value="Редактирай" id="edit_btn" name="edit_btn" onclick="return checkForCorrectDataFirm(document.searchform,\''.$resultEdit['username'].'\');">';
		  		}
		  
		  	
		  	    if (!eregi("^[0-9]+",$edit))
		  		{
		  			$firms_main_edit .= '<input type="submit" value="Въведи" id="insert_btn"  name="insert_btn" onclick="return checkForCorrectDataFirm(document.searchform,\'n/a\');">';
		  		}

$firms_main_edit .= '</div>';
				  
				  

	     
		//	$pushpinIcon = "http://largo.bg/img/icon_firmi.gif";
			$picFileMap = is_file("pics/firms/".$_REQUEST['edit']."_logo.jpg")?("pics/firms/".$_REQUEST['edit']."_logo.jpg"):("pics/firms/no_logo.png");
			$baloonHTML1 .= "<span style='float:left;margin-right:10px;'><a href ='разгледай-фирма-".$resultEdit['id'].",".myTruncateToCyrilic($resultEdit['name'],50,'_','').".html'><img src='".$picFileMap."' width='100' /></a></span>";               
			$baloonHTML1 .= "<span>".$resultEdit["name"]."<br />Категории: ".(is_array($firm_edit_cats_names)?implode(', ',$firm_edit_cats_names):'')."<br />Населено място: ".$resultEdit["location"]."<br />Адрес: ".$resultEdit["address"]."<br />Телефон: ".$resultEdit["phone"]."</span>";
			$baloonHTML2 .= "<span>".myTruncate($resultEdit["description"], 300, " ")."<a href = 'разгледай-фирма-".$resultEdit['id'].",".myTruncateToCyrilic($resultEdit['name'],50,'_','').".html'> виж още</a></span>";
			$firms_main_edit .= require("map_edit_firms.php");		

 		
			$firms_main_edit .= sprintf("<input type = \"hidden\" name = \"latitude\" id = \"latitude\" value = \"%0.20f\">\n", $resultEdit['latitude']);
			$firms_main_edit .= sprintf("<input type = \"hidden\" name = \"longitude\" id = \"longitude\" value = \"%0.20f\">\n", $resultEdit['longitude']);
		
		
           	
		
		
			$firms_main_edit .= '<input type=\'hidden\' name=\'MAX_FILE_SIZE\' value=\'99999999\'>';
			$firms_main_edit .= '<input type=\'hidden\' name=\'edit\' value=\''.$edit.'\'>';
			  
				  
			  
		$firms_main_edit .= '

		  <table  border="0" align="center">
				 	 <tr>
				 	    <td align="left"  valign="top"> 
					 	<label for = "firm_category">Категория*</label><br>';
				          
						$firms_main_edit .= "     <select name = \"firm_category[]\" id = \"firm_category\" multiple size = \"15\" align = \"left\" style = \"float:left;width:250px;margin-right: 10px;\">";
						$firms_main_edit .= "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
						require_once("includes/classes/FirmCategoriesList.class.php");
						$CCList = new FirmCategoriesList($conn);
						if($CCList->load())
				                {
							$firms_main_edit .= $CCList->showSelectMultipleList(0, "", $firm_edit_cats_ids?$firm_edit_cats_ids:0);
						}
						$firms_main_edit .= "     </select>\n";
$firms_main_edit .= '			          
			             </td>                        
	                    <td valign="top">
	                    	 Наименование* <br /><input type="text" style="width:300px;" name="firm_name" id="firm_name" value = "'.((strlen($resultEdit['name']) > 0) ? htmlspecialchars($resultEdit['name']) : "").'" > <br />
	                    	 Потребителско име* <br /><input type="text" style="width:300px;" name="username" id="username" value="'.$resultEdit['username'].'" > <br />
	                    	 Парола* <br /><input type="password" style="width:300px;" name="password" id="password" value="'.($resultEdit['password']?$resultEdit['password']:'').'" > <br />
	                    	 Повтори паролата* <br /><input type="password" style="width:300px;" name="password2" id="password2" value="'.($resultEdit['password']?$resultEdit['password']:'').'" > <br />
	                    	 Лице за контакти* <br /><input type="text" style="width:300px;" name="manager" id="manager" value = "'.((strlen($resultEdit['manager']) > 0) ? $resultEdit['manager'] : "").'" > <br />
	                    	 Телефон <br /><input type="text" style="width:300px;" name="phone" id="phone" value = "'.((strlen($resultEdit['phone']) > 0) ? $resultEdit['phone'] : "").'" > <br />
	                    	 E-mail*  <br /><input type="text" style="width:300px;" name="email" id="email" value = "'.((strlen($resultEdit['email']) > 0) ? $resultEdit['email'] : "").'" > <br />
	                    	 Уеб сраница <br /><input type="text" style="width:300px;" name="web" id="web" value = "'.((strlen($resultEdit['web']) > 0) ? $resultEdit['web'] : "").'">
	                    </td>                        					
                     </tr>
                         
                     
                      <tr>    	
                    				
    					<td align="left">
                              
    					 <fieldset>
    					 <legend>&nbsp;Населено място*   <a href=\'#\' id=\'destinaciq\' style=\'z-index:1000;\'><img src=images/help.png\' /></a></legend>
                            
                           		<!--  TARSACHKATA -->
								<div>
									<input type="text" size="30" id="inputString" name="inputString" AUTOCOMPLETE=OFF onkeyup="if(this.value.length > 2 ) { lookupLocation(this.value);}" value="Търси..." onfocus="if(this.value!=\'Търси...\'){this.value=this.value;} else {this.value=\'\';}" onblur="if(this.value==\'\'){this.value = \'Търси...\';} else {this.value = this.value;}" >
								</div>
								
								<div class="suggestionsBox" id="suggestions" style="display: none; z-index: 1000; -moz-border-radius:7px; -webkit-border-radius:7px;" onclick=" hidemsgArea();">
									<img src="images/top_arrow.gif" style="position: relative; top: -10px; left: 50px;" alt="upArrow" />
									<div class="suggestionList" id="autoSuggestionsList" style="color:#FFFFFF;"  onclick="hidemsgArea();" onmouseout="hidemsgArea();"></div>
								</div>				
								<!-- KRAI NA TARSACHKATA -->
								<label class = "txt12"><a href="javascript:void(0);" title = "Въведете първите няколко символа и изберете от предложения списък.">Подсказка за населеното място:</label>&nbsp;<br /><br />';
                            		
                         
							$firms_main_edit .= "     <select name = \"cityName\" id = \"cityName\" size = \"15\" align = \"left\" style = \"float:left;width:280px;margin-right: 5px;\">";
							$firms_main_edit .= "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
							//printf(" <option value = \"14880\" %s>&nbsp; Обиколен маршрут </option>",((14880 == $resultEdit['location_id']) ? " selected" : ""));
							require_once("includes/classes/FirmLocationsListEdit.class.php");
							$CCList = new FirmLocationsList($conn);
							if($CCList->load())
					                {
								$firms_main_edit .= $CCList->showselectlist(0, "", $resultEdit['location_id']?$resultEdit['location_id']:0);
							}
							$firms_main_edit .= "     </select>\n";
	$firms_main_edit .= '   		
                              	
                      	</fieldset>                         
                      </td>
                      <td align="left" valign="top">
                      	Адрес: <br /><textarea style="width:300px;" rows="3" cols="20" name="address" id="address" >'.$resultEdit['address'].'</textarea>
                      </td>                            
                      				   					
				</tr>
				<br />                
                      
    </table>
    
    <table style = " width:650px; border="0" align="center">
  		<tr><td>				
				 <div style="margin:10px;margin-left:10px;"> 
					 <fieldset>
				        <legend>&nbsp;Описание&nbsp;</legend>'; 
						
					include_once("FCKeditor/fckeditor.php");
				        $oFCKeditor = new FCKeditor('description') ;
				        $oFCKeditor->BasePath   = "FCKeditor/";
				        $oFCKeditor->Width      = '630';
				        $oFCKeditor->Height     = '300' ;
				        $oFCKeditor->Value      = $resultEdit['description'];
				       	$firms_main_edit .= $oFCKeditor->CreateHtml();
				      
$firms_main_edit .= '
					</fieldset>
				   </div>
		</td></tr>		 
		<tr><td>  
		 <fieldset style="width:650px">
				        <legend>&nbsp;Лого&nbsp;</legend>  
					<table><tr><td>
						<div style="float:left;margin:10px;margin-left:0px;"> 
							<input type = "file" name = "pic_logo">	   
	                  	</div>
                  	</td><td>';
                  	 	 
				       	if(is_file("pics/firms/".$_REQUEST['edit']."_logo.jpg"))
					{
		 				$firms_main_edit .= '<div style="float:left;margin-top:18px;margin-left:10px;">       	      			
			       			<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; width:150px; overflow:hidden; cursor:pointer;" ><img width="150" src="pics/firms/'.$_REQUEST['edit'].'_logo.jpg" />
			       			</div>
			       			<div style="float:left;cursor:pointer;" >
			       			<a href="изтрий-лого-на-фирма-'.$_REQUEST['edit']."_logo.jpg".','.(!empty($resultEdit['name'])?myTruncateToCyrilic($resultEdit['name'],200,'_',''):',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кафене_механа_дискотека_клуб_кръчма').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
			       			</div>';
					} 
                  	
$firms_main_edit .= '		       			
	       			</td></tr></table>
	       </fieldset>
	    </td></tr>
		<tr><td>		
			          		 	
                  <fieldset style="width:650px;">		
            	 <legend><br />.:: Снимки ::.</legend><br />        		 	
                  	
                  	<table><tr><td>
                  	 <div> 
                  	 		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:220px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:220px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:220px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:220px;">
	                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:220px;">
                  	
                  	</div>
                  	</td>';
      
			if ($resultEdit['numPics'] > 0)
			{  
			  	$firms_main_edit .= "<td><div style='width:250px;' ><ul id='thumbs'>";
			  	$p=0;
				foreach ($resultEdit['resultPics']['url_thumb'] as $pics_thumb)
				{ 	
					if(is_file('pics/firms/'.$pics_thumb))
					{ 
						$firms_main_edit .= '<li class="thumbDiv"><a href="pics/firms/';
						$firms_main_edit .= $resultEdit['resultPics']['url_big'][$p];    			
						$firms_main_edit .= '" class=\'lightview\' rel=\'gallery[myset]\'><img width="60" height="60" onclick = "$(\'big_pic\').src=\'pics/firms/';
						$firms_main_edit .= $resultEdit['resultPics']['url_big'][$p];    		
						$firms_main_edit .= '\'; "  src="';
						$firms_main_edit .= 'pics/firms/'.$pics_thumb; 
						$firms_main_edit .= '" /></a>';
						$firms_main_edit .= '<div style="cursor:pointer;" >
									<a href="изтрий-снимка-на-фирма-'.$resultEdit['resultPics']['url_big'][$p].','.(!empty($resultEdit['name'])?myTruncateToCyrilic($resultEdit['name'],200,'_',''):',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кафене_механа_дискотека_клуб_кръчма').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14" onclick="if(!confirm(\'Сигурни ли сте?\')) {return false;}"></a>
								     </div>';
						$firms_main_edit .= '</li>';
						
						$p++;
					}
				}
				
				
				  $firms_main_edit .= "</ul></div></td>";
			}
 $firms_main_edit .= '
           		</tr></table> 	 
           		
         </fieldset>
         
         
           	
		</td></tr>	 
        <tr><td>			 	
      <div style = "width:650px;">
            <fieldset>
             <label><br />.:: Видео Представяне ::.</label><br /><br />';
         
            	$video_name = $_REQUEST['edit'];
            	
		if(file_exists("videos/firms/".$video_name.".flv"))
		{
			$video = "videos/firms/".$video_name.".flv";
			
			$firms_main_edit .= '<br>
			
			<div id="videoDIV"  style="margin-left:0px;">
			<p id="player1"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>
				<script type="text/javascript">
					var FO = {movie:"flash_flv_player/flvplayer.swf",width:"300",height:"170",majorversion:"7",build:"0",bgcolor:"#FFFFFF",allowfullscreen:"true",
					flashvars:"file=../videos/firms/'.$video_name.'.flv&image=../videos/firms/'.$video_name.'_thumb.jpg" };
					UFO.create(FO, "player1");
				</script>
			</div>
			
			<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-видео-на-фирма-'.$video_name.','.(!empty($resultEdit['name'])?myTruncateToCyrilic($resultEdit['name'],200,'_',''):'здравни_организации_болници_аптеки_търговци_на_медицинска_техника').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>';
		
		     
		} 
				         				
		$firms_main_edit .= '<input type="file" name="imagefile">  <label>Прикачи видео (файла трябва да е с разширение ".fla")</label><br>';
				
			
				if(is_array($_REQUEST)) {
				      for(reset($_REQUEST); $filedName = key ($_REQUEST); next($_REQUEST)) {
				         $$filedName = $_REQUEST[$filedName];
				      }
				   }
				//$big_resize= "-s 320x240 -r 15  -b 768"; 
				//$normal_resize= "-s 320x240 -r 15  -b 160";
				//$small_resize= "-s 240x180 -r 8  -b 90";  
				
			
				
				
	$firms_main_edit .= '				
				<br />
				Видео от YOUTUBE.COM:
					<input type="text" style="width:380px;" name="youtube_video" id="youtube_video" value = "'.((strlen($resultEdit['youtube_video']) > 0) ? $resultEdit['youtube_video'] : "").'">
				<br /><br />
						
				
			</fieldset>		
						
	   </div>
	   </td></tr>
	 </table> ';
		
$firms_main_edit .= '		
	 <table>  
	     <tr>
		 <td width="200" align="right"><fieldset style="width:100px;"><img src="verificationimage/picture.php" /></fieldset></td>
		 <td>	 
			<br /><input type="text" name="verificationcode" value="" /><br />
			В полето въведете кода показан на картинката*		
		 </td>
	   </tr>	   
	 </table>';
	        	
	
	  
if ($_REQUEST['edit'] > 0 && $_SESSION['user_kind'] == 2)
{
	$firms_main_edit .= '<input type=\'checkbox\' id=\'active'.$_REQUEST['edit'].'\' name=\'active'.$_REQUEST['edit'].'\' '.((($resultEdit["active"] == 1) ? 'checked' : '')).' onclick=\'if(this.checked) {set_active(1,"firm",'.$_REQUEST['edit'].','.$_SESSION['userID'].');} else{set_active(0,"firm",'.$_REQUEST['edit'].','.$_SESSION['userID'].');} \'/> Заведението/Фирмата е активно.<a href=\'#\' id=\'aktivirane_firm\' style=\'z-index:1000;\'><img src=\'images/help.png\' /></a>';
}	 

$firms_main_edit .= '<br /> <br />';

 
if(isset($_REQUEST['edit']) && $_REQUEST['edit'] > 0) // Показваме информацията за СПЕЦИАЛИТЕТ само ако редактираме напитката, не когато я въвеждаме!
{
	$firms_main_edit .= " <br /><hr><br />
		<h3 style=\"color:#FF6600; font-weight:bold;\">Бъди VIP за 1 седмица!</h3><hr style=\"border:1px dashed #000000;\"><p style=\"color:#000000;\"> &rarr; Изпрати SMS на кратък номер 1094 и въведи получения код в полето, което ще видиш след като кликнеш на бутона 'Въведи КОД-а и стани VIP'.<br /> &rarr; Една седмица ще си в секция VIP на главната ни страница!<br />  &rarr; За да използваш услугата изпрати SMS с текст <span style=\"color:#FF6600;font-weight:bold;\">forvip</span> на номер <span style=\"color:#FF6600;font-weight:bold;\">1094</span> (цена с ДДС - 4.80лв.).  </p>
		<a href = \"javascript://\" onclick = \"window.open('includes/tools/checkSMScode.php', 'sndWin', 'top=0, left=0, width=400px, height=250px, resizable=no, toolbars=no, scrollbars=yes');\" class = \"smallOrange\"><img style=\"margin-left:5px;\" src=\"images/get_VIP_btn.png\" alt=\"Стани VIP\" width=\"180\" height=\"20\"></a>";
	
    $firms_main_edit .= "<br /><br />";
            
    
    $firms_main_edit .= "
        <table width='100%' style='padding-left:5px;'><tr><td style='background-color:#F1F1F1; width:100px;'>Период</td><td style='background-color:#F1F1F1; width:100px;'>Цена</td><td  style='background-color:#F1F1F1; '></td></tr>
        <tr style='background-color:#C7C7C7;'><td>1 седмица</td><td>4.80 лв.</td>
        <td  style='background-color:#C7C7C7;' >
        <style>
			INPUT.epay-button         { border: solid  1px #FFF; background-color: #168; padding: 4px; color: #FFF; background-image: none; padding-left: 5px; padding-right: 5px; }
			INPUT.epay-button:hover   { border: solid  1px #ABC; background-color: #179; padding: 4px; color: #FFF; background-image: none; padding-left: 5px; padding-right: 5px; }
		</style>
		
		<form action='https://www.epay.bg/' method=post>
		<input type=hidden name=PAGE value='paylogin'>
		<input type=hidden name=MIN value='6042735676'>
		<input type=hidden name=INVOICE value=''>
		<input type=hidden name=TOTAL value='4.80'>
		<input type=hidden name=DESCR value='Badi VIP za 1 sedmica'>
		<input type=hidden name=URL_OK value='http://www.gozbite.com'>
		<input type=hidden name=URL_CANCEL value='http://www.gozbite.com'>
		<input class=epay-button type=submit name=BUTTON:EPAYNOW value='Плащане on-line през ePay.bg' onclick='sendMailWhenEpayBg(\'4.80\');'>
		</form>
   </td></tr></table>";
           
                    
	         
                    
	$firms_main_edit .= " <br /><hr><br />
			<h3 style=\"color:#FF6600; font-weight:bold;\">Бъди \"НА ФОКУС\" за 1 седмица!</h3><hr style=\"border:1px dashed #000000;\"><p style=\"color:#000000;\"> &rarr; Изпрати SMS на кратък номер 1093 и въведи получения код в полето, което ще видиш след като кликнеш на бутона 'стани НА ФОКУС'.<br /> &rarr; Една седмица ще си в секция \"НА ФОКУС\" която е видима във всички страници на портала!<br />  &rarr; За да използваш услугата изпрати SMS с текст <span style=\"color:#FF6600;font-weight:bold;\">izbran</span> на номер <span style=\"color:#FF6600;font-weight:bold;\">1093</span> (цена с ДДС - 1.20лв.).  </p>
			<a href = \"javascript://\" onclick = \"window.open('includes/tools/checkSMScodeFeatured.php', 'sndWin', 'top=0, left=0, width=400px, height=250px, resizable=no, toolbars=no, scrollbars=yes');\" class = \"smallOrange\"><img style=\"margin-left:5px;\" src=\"images/get_Featured_btn.png\" alt=\"Стани VIP\" width=\"180\" height=\"20\"></a>";
    
    $firms_main_edit .= "<br /><br />";
            
    $firms_main_edit .= "
        <table width='100%' style='padding-left:5px;'><tr><td style='background-color:#F1F1F1; width:100px;'>Период</td><td style='background-color:#F1F1F1; width:100px;'>Цена</td><td  style='background-color:#F1F1F1; '></td></tr>
        <tr style='background-color:#C7C7C7;'><td>1 седмица</td><td>1.20 лв.</td>
        <td  style='background-color:#C7C7C7;' >
        <style>
			INPUT.epay-button         { border: solid  1px #FFF; background-color: #168; padding: 4px; color: #FFF; background-image: none; padding-left: 5px; padding-right: 5px; }
			INPUT.epay-button:hover   { border: solid  1px #ABC; background-color: #179; padding: 4px; color: #FFF; background-image: none; padding-left: 5px; padding-right: 5px; }
		</style>
		
		<form action='https://www.epay.bg/' method=post>
		<input type=hidden name=PAGE value='paylogin'>
		<input type=hidden name=MIN value='6042735676'>
		<input type=hidden name=INVOICE value=''>
		<input type=hidden name=TOTAL value='1.20'>
		<input type=hidden name=DESCR value='Badi NA FOKUS za 1 sedmica'>
		<input type=hidden name=URL_OK value='http://www.gozbite.com'>
		<input type=hidden name=URL_CANCEL value='http://www.gozbite.com'>
		<input class=epay-button type=submit name=BUTTON:EPAYNOW value='Плащане on-line през ePay.bg' onclick='sendMailWhenEpayBg(\'1.20\');'>
		</form>
   </td></tr></table>";
     
    $firms_main_edit .= "<br /><hr><br />";
   
}
	
	 	 
$firms_main_edit .= '<div style="margin:0px; width:100px;">';
					
					if (eregi("^[0-9]+",$edit))
					{	
						$firms_main_edit .= '<input type="submit" value="Редактирай" id="edit_btn" name="edit_btn" onclick="return checkForCorrectDataFirm(document.searchform,\''.$resultEdit['username'].'\');">';								
					}
				  	
				  	
				  	if (!eregi("^[0-9]+",$edit))
					{			  
						$firms_main_edit .= '<input type="submit" value="Въведи" id="insert_btn"  name="insert_btn" onclick="return checkForCorrectDataFirm(document.searchform,\'n/a\');">';					  
					}
				  	
$firms_main_edit .= '</div>
		 </div>     		 	
 </div>
 <br style="clear:both;"/>';
	    
	return $firms_main_edit;
	  
	?>
