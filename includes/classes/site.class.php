<?php
class Site {
	
	var $settings;
	var $body;
 	
	function Site(&$settings)
	{
		$this->settings = &$settings;
	}
	
	
	function start()
	{
		
		echo'
				
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="bg-BG" lang="bg-BG">
		
		<head>
		<title>.: оХБоли - Здраве желаем :.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		
		<meta name="revisit-after" content="1 days" />
		<meta name="robots" content="follow,index" />
		<meta http-equiv="Description" content="oHBoli.Bg е здравен портал, в който може да откриете пълна информация, свързана с медицината от целия свят и България, авторски статии, интервюта и множество развлекателни секции - богат снимков материал, новини, описания на лекарства и медикаменти, болести и др." />
		<meta http-equiv="Keywords" content="здраве,здравен,болка,болки,здравни новини,България,медицина,медицински,медицинска,общество,лекари,болници,светът,инциденти,здравни заведения,доктор,доктори,интервю,здраве,наука,технологии,диети,спорт,любопитно,болест,болен,рана,кръв,заболяванияите,zdrave,medicina,lekar,lekarstvo,bolest,bolka" />
		<meta http-equiv="Refresh" content="900" />
		<meta name="abstract" content="Здравен сайт – актуални дефиници за болести, лекарства, както и много статии и новини от областа и голям каталог от здравни заведения и служители." />
		<meta name="Subject" content="здраве,болка,болест,лекар,болница,лекарство,медицина" />
		<meta name="classification" content="здраве,болка,болест,лекар,болница,лекарство,медицина" />
		<meta name="language" content="bulgarian" />
		<meta name="author" content="ohboli.bg" />
		<meta name="owner" content="ohboli.bg - здраве,болка,болест,лекар,болница,лекарство,медицина" />
		<meta name="copyright" content="Copyright (c) by ohboli.bg" />
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
		<meta name="generator" content="здраве" />
		<meta name="ProgId" content="здраве" />
		<meta name="rating" content="general" />
		<meta name="description" content="oHBoli.Bg е здравен портал с пълна информация, свързана с медицината от целия свят и България, богат снимков материал, статии описания на лекарства, болести и др." />
		<meta name="keywords" content="здраве,здравен,болка,болки,здравни новини,България,медицина,медицински,медицинска,общество,лекари,болници,светът,инциденти,здравни заведения,доктор,доктори,интервю,здраве,наука,технологии,диети,спорт,любопитно,болест,болен,рана,кръв,заболяванияите,zdrave,medicina,lekar,lekarstvo,bolest,bolka" />
		
		<meta name="google-site-verification" content="Jd-UcEvIQR2wosHkjLpilvtRIX4Nk8yOz8pnj1ioYqU" />
		
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
				
		<script type = "text/javascript" src = "js/load_pic_ajax_js.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
		
		<script src="js/scriptaculous/lib/prototype.js" type="text/javascript"></script>
		<script src="js/scriptaculous/src/scriptaculous.js" type="text/javascript"></script>
		
		<script type="text/javascript" src="js/phototype.js"></script>
		
		<link rel="stylesheet" type="text/css" href="index_inc/ajax_calendar/calendar_style.css"></link>	
		<script type="text/javascript" src="index_inc/ajax_calendar/calendar.js"></script>
		
		   
		<script type="text/javascript" src="js/boxover.js"></script>
		
		<link rel="stylesheet" type="text/css" href="css/NiftyLayout.css" media="screen">
		<script type="text/javascript" src="js/niftycube.js"></script>
		
		   
		
		<script type="text/javascript" src="js/javascripts/window.js"> </script>
		<script type="text/javascript" src="js/javascripts/window_effects.js"> </script>
		<script type="text/javascript" src="js/javascripts/tooltip.js"> </script>
		<link href="themes/default.css" rel="stylesheet" type="text/css" ></link>	
		<link href="themes/spread.css" rel="stylesheet" type="text/css" ></link>
		<link href="themes/alphacube.css" rel="stylesheet" type="text/css" ></link>
		
		
		
		<link rel="stylesheet" type="text/css" href="css/menuStyles.css" media="screen">
		
		<script src="js/AC_RunActiveContent.js" language="javascript"></script>


		
		</head>
		<body>
		<form name="searchform" action="" method="post" enctype="multipart/form-data" >
		';
		
	}
	
	
	function finish()
	{
		
		echo '				
			</form>
			</body>
			</html>
		';
		
	}
	
		
	function showLogo()
	{
		
		$this->body .= ''; // Adding the site logo
		
	}

}
?>
