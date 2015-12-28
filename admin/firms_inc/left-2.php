<div id="left-2DIV" style="float:left;background-color:#E0E0E0;">
 <div   align="center" style="float:left; width:140px; padding:20px 5px 5px 5px; background-color:#FFB12B; color: #FFFFFF; font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">  
  	<?php include("inc/user_info.inc.php")?> 
 </div>
</div>
 
 <div style="float:left; height:50px; background-color:#003300;"><img width="150" height="50" src="images/s4.png"></div>
 
 <div align="left" style="width:150px; background-color:#F5F5F5; color: #467B99; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold;">
 	<?php include("inc/menu.inc.php")?>
 </div>
 
<div style="float:left;width:150px; height:41px;"><img src="images/vulna_dolna.png"></img></div>
 
 
 
 <div id="BANER-LEFT" align="center" style="float:left; width:150px; padding-bottom:10px;padding-top:0px; background-color:#E7E7E7;">
  	<?php 
          include_once("inc/vremeto.inc.php"); 
          include_once("inc/valuta.inc.php");  
          if((isset($_POST['search_btn'])) or (isset($_POST['insert_btn'])) or (isset($_POST['edit_btn'])) or ($_REQUEST['category'] != '' ))
          {
          include_once("target_links.inc.php"); 
          } 
      ?>
  	<div id="Baner_1" style=" float:left; margin-left:10px; width:120px; height:300px; border:double; border-color:#666666;">
	  <?php  
        include_once("inc/baner-left.inc.php");
      ?> 
 	</div>
 </div>
 
 <div style="float:left; "><img src="images/h4_<?=$theme_color?>.gif" width="150" height="41"></div>
 
 
<div style="float:left; width:150px; height:30px; background-image:url(images/bg10_<?=$theme_color?>.gif)">
<input align="left" style="width:120px; float:left; margin-left:5px;" type="text" name="search">
<input type="image" style="float:left;" src="images/but2_<?=$theme_color?>.png" alt="" border="0" usemap="#Map" />
</div>
 
 <div style="float:left; "><img style="float:left;" width="150" src="images/s5_<?=$theme_color?>.gif" /></div>
 
