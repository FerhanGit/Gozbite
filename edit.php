<?php

//	ini_set('display_errors', 1);
//	error_reporting(E_ALL ^ E_NOTICE);
   
//=========================================================



require_once 'includes/header.inc.php';

// Puskame na tazi stranica samo otorizirani potrebiteli i neotorizirani, koito iskat da se registrirat!!!
if ((!isset($_REQUEST['new_registration']) OR $_REQUEST['new_registration'] != 'yes') && !isset($_SESSION['valid_user'])) 
{
	$_SESSION['page_refferer'] = $_SERVER['REQUEST_URI']; // zapomnqme tekushtata stranica
?>
	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='вход,вход_в_системата_на_здравния_портал_gozbite_com.html';</script> 
<?php 
exit;
}

$page_obj  =& Pages::loadPage(Pages::setPageToLoad());

$page = $_REQUEST['page'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="bg-BG" lang="bg-BG">

<head>
<title>.: GoZbiTe.Com - <?php Events::run('title_key_words', $params = array()); ?> :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	


<meta name="revisit-after" content="1 days" />
<meta name="robots" content="follow,index" />
<meta http-equiv="Description" content="GoZbiTe.Com е кулинарен портал, в който може да откриете вкусни готварски рецепти, екзотични коктейли, алкохолни и безалкохолни шейкове, сиропи, нектари, концентрати, авторски статии, интервюта и множество развлекателни секции - богат снимков материал, новини, описания на храни, витамини и минерали, плодове и зеленчуци, каталог от сладкарници, ресторанти, пицарии, магазини, вносители на хранителни продукти и др." />
<meta http-equiv="Keywords" content="<?php Events::run('meta_tags', $params = array()); ?>готварска,рецепта,месо,вегетариански,зеленчуци,плодове,десерт,торта,сладки,коктейл,кафе,чай,нектар,сок,шейк,сладкарница,ресторант,механа,таверна,кафене,пицария,магазин,бар,закусвалня,вносител на храни,кръчма" />

<meta name="abstract" content="Кулинарен сайт – готварски рецепти, месо, вегетариански, зеленчуци, плодове, десерти, торти, сладки, коктейли, кафе, чай, нектари, сокове, шейкове, сладкарници, ресторанти, механа, таверна, кафене, пицарии, магазини, барове, закусвални, вносители на храни, кръчми." />
<meta name="Subject" content="<?php Events::run('meta_tags', $params = array()); ?>готварска,рецепта,месо,вегетариански,зеленчуци,плодове,десерт,торта,сладки,коктейл,кафе,чай,нектар,сок,шейк,сладкарница,ресторант,механа,таверна,кафене,пицария,магазин,бар,закусвалня,вносител на храни,кръчма" />
<meta name="classification" content="<?php Events::run('meta_tags', $params = array()); ?>готварска,рецепта,месо,вегетариански,зеленчуци,плодове,десерт,торта,сладки,коктейл,кафе,чай,нектар,сок,шейк,сладкарница,ресторант,механа,таверна,кафене,пицария,магазин,бар,закусвалня,вносител на храни,кръчма" />
<meta name="language" content="bulgarian" />
<meta name="author" content="GoZbiTe.Com" />
<meta name="owner" content="GoZbiTe.Com - готварска,рецепта,месо,вегетариански,зеленчуци,плодове,десерт,торта,сладки,коктейл,кафе,чай,нектар,сок,шейк,сладкарница,ресторант,механа,таверна,кафене,пицария,магазин,бар,закусвалня,вносител на храни,кръчма" />
<meta name="copyright" content="Copyright (c) by GoZbiTe.Com" />
<meta name="city" content="Sofia" />
<meta name="country" content="Bulgaria" />
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta name="robots" content="all" />
<meta name="robots" content="index, follow" />
<meta name="slurp" content="index,follow" />
<meta name="msnbot" content="index, follow" />
<meta name="msnbot" content="robots-terms" />
<meta name="googlebot" content="index,follow" />
<meta name="googlebot" content="robots-terms" />
<meta name="generator" content="кулинария" />
<meta name="ProgId" content="кулинария" />
<meta name="rating" content="general" />
<meta name="description" content="GoZbiTe.Com е кулинарен портал, в който може да откриете вкусни готварски рецепти, екзотични коктейли, алкохолни и безалкохолни шейкове, сиропи, нектари, концентрати, авторски статии, интервюта и множество развлекателни секции - богат снимков материал, новини, описания на храни, витамини и минерали, плодове и зеленчуци, каталог от сладкарници, ресторанти, пицарии, магазини, вносители на хранителни продукти и др." />
<meta name="keywords" content="<?php Events::run('meta_tags', $params = array()); ?>готварска,рецепта,месо,вегетариански,зеленчуци,плодове,десерт,торта,сладки,коктейл,кафе,чай,нектар,сок,шейк,сладкарница,ресторант,механа,таверна,кафене,пицария,магазин,бар,закусвалня,вносител на храни,кръчма" />


<meta name="google-site-verification" content="sD7oTKdtnFc43S5PtLMlC81JMKYTy6lM0S_so_OjH40" />


<!-- FB LIKE BUTTON-->
<meta property="og:title" content="<?php Events::run('title_key_words', $params = array()); ?>" />
<meta property="og:site_name" content="GoZbiTe.Com" />
<meta property="og:type" content="article" />
<meta property="fb:admins" content="1544088151" />
<meta property="og:image" content="http://GoZbiTe.Com/images/logce.png"/>


<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAx_W5ztkhhP0ZnBVvqHy4LhTw_80zUO6lyQ4Y1v56XsZgNtdzbxQn4KMQnXGnAybHP_2R91A5_j-zCg" type="text/javascript"></script>


<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
			
<script type="text/javascript" src="js/functions.js"></script>

<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>

<script type = "text/javascript" src = "flash_flv_player/ufo.js"></script>



<?php
if($_GET['pg'] == 'aphorisms')
{?>
<link rel="stylesheet" type="text/css" href="includes/tools/ajax_aphorisms_calendar/calendar_style.css"></link>	
<script type="text/javascript" src="includes/tools/ajax_aphorisms_calendar/calendar.js"></script>
<?php	
}
else
{?>
<link rel="stylesheet" type="text/css" href="index_inc/ajax_calendar/calendar_style.css"></link>	
<script type="text/javascript" src="index_inc/ajax_calendar/calendar.js"></script>
<?php	
}
?>    
<script type="text/javascript" src="js/boxover.js"></script>

<script type = "text/javascript" src = "js/calendar.js"></script>
<script type = "text/javascript" src = "js/calendar_conf.js"></script>
<script type = "text/javascript">
     addCalendar("CalFDate", "Изберете дата", "fromDate", "searchform");
     addCalendar("CalTDate", "Изберете дата", "toDate", "searchform");
</script>


<link rel="stylesheet" type="text/css" href="css/NiftyLayout.css" media="screen">
<script type="text/javascript" src="js/niftycube.js"></script>		   

<script type="text/javascript" src="js/javascripts/tooltip.js"> </script>
<link href="themes/default.css" rel="stylesheet" type="text/css" ></link>	
<link href="themes/spread.css" rel="stylesheet" type="text/css" ></link>
<link href="themes/alphacube.css" rel="stylesheet" type="text/css" ></link>		

<link rel="stylesheet" type="text/css" href="css/menuStyles.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/RegMenuStyles.css" media="screen">

<link rel="stylesheet" type="text/css" href="css/adv_menuStyles.css" media="screen">

<script src="js/AC_RunActiveContent.js" language="javascript"></script>
	

		
<script type="text/javascript">
 		
function fastLimit(selObj) 
{
	<?php require_once("includes/tools/fastLimit.php"); ?>	 
}

</script>
	
	
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'bg'}
</script>


<?php Events::run('profile.validation', $params = array());		?>

</head>
<body>
<div id="adv_bgr_Div">
<form name='searchform' action='' method='post' enctype='multipart/form-data' >

<input type="hidden" name="txt_x" id="txt_x" />
<input type="hidden" name="txt_y" id="txt_y" />
<input type="hidden" name="map_str" />
<input type="hidden" id="citiesOrRegions" name="citiesOrRegions" />

<script type="text/javascript">


//$.noConflict();
jQuery(document).ready(function($) {
    if(!<?php echo in_array($_REQUEST['pg'], array('locations', 'edit_location', 'bolesti', 'edit_bolesti', 'locations', 'edit_location')) ? 'true' : 'false'; ?>) {

        jQuery('ul#awesome-sub-menu').hide(); 

        jQuery("a.freetimeLi,a.bolestiLi,a.aphorismsLi,a.destinationsLi").mouseover(function() {
            jQuery('ul#awesome-sub-menu').show(); 
        });

        jQuery("a.freetimeLi,a.bolestiLi,a.aphorismsLi,a.destinationsLi").mouseout(function() {
            jQuery('ul#awesome-sub-menu').hide(); 
        });
    }
});


window.onload=function(){
	
<?php Events::run('load.map', $params = array());		?>


Nifty("ul#thumbs_posts li","same-height");
Nifty("div.paging","transparent");
Nifty("div#BANER_KVADRAT_AND_NEWS_DIV","transparent");
Nifty("div#contentUser","same-height");
Nifty("ul#intro li","same-height");
Nifty("ul.listingHotelsVip li","transparent same-height");
Nifty("ul.listingFirmsVip li","transparent same-height");
Nifty("div.listArea","transparent");
Nifty("div.date","transparent");
//Nifty("div#content,div#right","same-height");
Nifty("div.boxLeft","transparent");
Nifty("div.boxLeft135","transparent");
Nifty("div.boxRight","transparent");
Nifty("div.LastComments","transparent");
Nifty("ul.TwoHalf li","transparent");
Nifty("div.post_text","transparent");
Nifty("div.thumbDiv","transparent");
Nifty("div.detailsDivMap","bottom");
Nifty("div.detailsDiv","bottom");
Nifty("ul#thumbs li","same-height");
Nifty("div.pagingVip","transparent");
Nifty("div.rsBoxContent","transparent");
Nifty("div.promo_section_title","transparent");
Nifty("ul.promo li","transparent same-height");
Nifty("div#get_register","transparent");
Nifty("div#send_sms","transparent");


navigate("","");

}
</script>

<?php




$header_section = "";
$header_section .= '<div id="header">
	<div id="menu">';		
Events::run('header', $params = array('header_section' => &$header_section));
Events::run('menu', $params = array('header_section' => &$header_section));	
	$header_section .= '</div>
</div>';
$body .= $header_section;


$body .= '<div id="container">
	<div id="content">';	
		$main_section = "";
		Events::run('main', $params = array('main_section' => &$main_section));	
	$body .= $main_section;	
	$body .= '</div>
	<div id="right">';
		$right_section = "";
		Events::run('right', $params = array('right_section' => &$right_section));
	$body .= $right_section;
	$body .= '</div>
		<br style="clear:both;" />
</div>';
	


$body .= '<div id="footer_real">
	<div class="footer_links">';
$footer_section = "";
Events::run('footer', $params = array('footer_section' => &$footer_section)); 
	$body .= '</div>
</div>';	
$body .= $footer_section;		

/*
$body .= '<script>
  TooltipManager.addURL("get_featured_help", "help/get_featured_help.html", 350, 350);
  TooltipManager.addURL("get_vip_help", "help/get_vip_help.html", 400, 300);
</script>';
*/

print $body;
?>
</div>
</form>
		</body>
		</html>