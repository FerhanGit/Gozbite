<div id="left-2DIV" style="float:left;background-color:#E0E0E0;">
 <div   align="center" style="float:left; width:140px; padding:20px 5px 5px 5px; background-color:#FFB12B; color: #FFFFFF; font-size: 11px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">  
  	<?php include("inc/user_info.inc.php")?> 
 </div>
</div>
 
 <div style="float:left; height:50px; background-color:#003300;"><img width="150" height="50" src="images/s4.png"></div>
 
 <div align="left" style="width:150px; background-color:#F5F5F5; color: #467B99;  ">
 	<?php include("inc/menu.inc.php")?>
 </div>
 
<div style="float:left;width:150px; height:41px;"><img src="images/vulna_dolna.png"></img></div>
 
 <div id="COLLAPSE_BTN" style="float:right;width:150px;background-color:#E7E7E7;">
     
 </div>
 
 <div id="BANER-LEFT" align="center" style="float:left; width:150px; padding-bottom:10px;padding-top:0px; background-color:#E7E7E7;">
  	<?php 
          if((isset($_POST['search_btn'])) or (isset($_POST['insert_btn'])) or (isset($_POST['edit_btn'])))
          {
          include_once("inc/target_links.inc.php"); 
          } 

          include_once("inc/vremeto.inc.php"); 
          
          include_once("inc/valuta.inc.php");  
         
      ?>
  	<div id="Baner_1" style=" float:left; margin-left:10px; width:120px; height:300px; border:double; border-color:#666666;">
	  <?php  
        include_once("inc/baner-left.inc.php");
      ?> 
 	</div>
 </div>
 
 <div style="float:left; "><img src="images/h4_<?=$theme_color?>.gif" width="150" height="41"></div>
 
 
<div style="float:left; width:150px; height:30px; background-image:url(images/bg10_<?=$theme_color?>.gif)">
<input align="left" style="width:120px; float:left; margin-left:5px;" type="text" id="searchAll" name="searchAll" value="търси..." onfocus="if(this.value!='търси...'){this.value=this.value;}else this.value=''" onblur="if(this.value==''){this.value='търси...';}else this.value=this.value"/>
<input type="image" onclick="document.searchform.action='search.php';document.searchform.submit();" style="float:left;" src="images/but2_<?=$theme_color?>.png" alt="" border="0" usemap="#Map" />
</div>
 
 <div style="float:left; "><img style="float:left;" width="150" src="images/s5_<?=$theme_color?>.gif" /></div>
 
