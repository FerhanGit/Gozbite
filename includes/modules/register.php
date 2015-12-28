<?php 

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$register = "";
   	
if(isset($_SESSION['valid_user'])){
	$register .= '<script type="text/javascript">window.location.href="начална-страница,сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html";</script>';
}
$register .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
	
	<br style="clear:both;"/>	
	<div class="postBig">
		<h4>
			<div style="margin-left:6px; height:22px; width:550px;color:#0099FF;font-weight:bold;" >Регистрация в GoZBiTe.Com</div>		
		</h4>
	</div>	<br />	
	
	
	<div style="color:#FF6600; font-weight:bold;">Вие сте: 	'.(($_REQUEST['reg'] <> "") ? ($_REQUEST['reg'] == 'firm'?' Заведение/Фирма ': ' Потребител ') : '').' ?</div>     <br />	
  


	<div id="regMenu" style="width:500px;margin:0 auto;text-align:center">
		<ul id="reg-menu">
			<li title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Потребител!] body=[&rarr; Ако сте потребител, желаещ да вземе активно участие в портала споделяйки свои <span style="color:#FF6600;font-weight:bold;">рецепти</span> за храни и напитки, актуални <span style="color:#FF6600;font-weight:bold;">статии</span> или добавяйки нови <span style="color:#FF6600;font-weight:bold;">описания в справочника</span>.]\'><a class="reg_userLi" href="добави-нов-потребител,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.($_REQUEST['reg'] == 'user'?'style="background-position: 0 -70px;"':'').'>Потребители</a></li>
			
			<li title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Заведение/Фирма!] body=[&rarr; Ако сте заведение, ресторант, пицария, сладкарница, механа, бирария, бар, кафене, магазин, търговец на храни и напитки или друго <span style="color:#FF6600;font-weight:bold;">заведение/фирма</span> от от тази сфера.]\'><a class="reg_firmLi" href="добави-фирма,сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html" '.($_REQUEST['reg'] == 'firm'?'style="background-position: -140px -70px;"':'').'>Заведение / Фирма</a></li>
		</ul>
	</div>
	  <br style="clear:both;"/>	
	<hr style="600px; margin-top:20px; margin-bottom:30px;">       
     <!-- Text na ARTICLE -->
        <div id="tabs" style="height:auto; margin:0px 0px 0px 10px; padding-left:10px; width:620px; background-color:#F5F5F5;" >
                                                    
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na tabs -->
     <br style="clear:both;"/>	
     <hr style="600px; margin-top:20px; margin-bottom:30px;">       
     Ако имате проблеми с регистрацията или искате да получите информация, моля <a href="разгледай-страница-feedback,задайте_въпрос_напишете_коментар_препоръка_или_мнение.html">пишете ни </a> !
     
</div>';

return $register;

?>
