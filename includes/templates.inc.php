<?
//////////////////////////////////////////////////////////////////////////////////////////////////////
// Copyright (c) 2004-2007 Gameloft.com
//
// xHTML, WML, iHTML and other (OML, PML) Templates File
// Version 3.0.0
// Description: Used to form the way the page is displayed
//
// Generic Site By: Antoni Stavrev <antoni.stavrev@gameloft.com>
// Package: %%package%%
// Author: %%author%%
// Owner: %%owner%%
// Modifications: %%modifs%%
//
//////////////////////////////////////////////////////////////////////////////////////////////////////

// All sections - xhtml, wml, ihtml, etc. needs to have equal keys to work properly
$templates = array();

//////////////////////////////////////////////////////////////////////////////////////////////////////
// xHTML
//////////////////////////////////////////////////////////////////////////////////////////////////////

$templates['xhtml']['center'] = '<div align="center">{data}</div>';
$templates['xhtml']['right'] = '<div align="right" class="or">{data}</div>';
$templates['xhtml']['img'] = '<img src="{src}" alt="{alt}" />';
$templates['xhtml']['icon'] = '<img src="{src}" alt="{alt}" class="icon_img"/>';
$templates['xhtml']['a'] = '<a href="{href}">{title}</a>';
$templates['xhtml']['a_img'] = '<a href="{href}"><img src="{src}" /></a>';
$templates['xhtml']['a_title'] = '<a href="{href}" title="{title}">{data}</a>';
$templates['xhtml']['a_white'] = '<a href="{href}" class="whitelink">{title}</a>';
$templates['xhtml']['a_no_decoration'] = '<a class="no_decoration" href="{href}">{title}</a>';
$templates['xhtml']['a_orange'] = '<a href="{href}" class="orangelink">{title}</a>';
$templates['xhtml']['br'] = '<br />'."\n";
$templates['xhtml']['b'] = '<b>{data}</b>';
$templates['xhtml']['space'] = '&nbsp;';
$templates['xhtml']['center_blue'] = '<div align="center" class="deep_blueish_row_thick">{data}</div>';
$templates['xhtml']['left_blue'] = '<div class="deep_blueish_row_thick">{data}</div>';
$templates['xhtml']['center_orange_bk'] = '<div align="center" class="orange_bk">{data}</div>';
$templates['xhtml']['bullet_description'] = '<div>{data}</div>'; // WAP Key-points bullet format
$templates['xhtml']['orange_link'] = '<b class="orange_link">{data}</b>';
$templates['xhtml']['red_text'] = '<b class="red_text">{data}</b>';

$templates['xhtml']['dark'] = '<div class="dark">{data}</div>';
$templates['xhtml']['title_page_bk'] = '<div align="center" class="title_page_bk">{data}</div>';
// cells
$templates['xhtml']['cell_normal'] = '<div class="cell">{data}</div>'."\n";
$templates['xhtml']['cell_featured'] = '<div class="cell_featured">{data}</div>'."\n";
$templates['xhtml']['cell_featured_bg'] = '<div class="cell_featured_bg">{data}</div>'."\n";
$templates['xhtml']['cell_footer'] = '<div class="cell_footer">{data}</div>'."\n";
$templates['xhtml']['cell_special2'] = '<div class="cell_special2">{data}</div>'."\n";
$templates['xhtml']['img_link'] = '<div class="cell"><img src="{img}" />&nbsp;&nbsp;<a href="{href}">{link_title}</a></div>'."\n";

// Container
$templates['xhtml']['container1'] = '<div class="container1">{data}</div>'."\n";
$templates['xhtml']['container2'] = '<div class="container2">{data}</div>'."\n";
$templates['xhtml']['container3'] = '<div class="container3">{data}</div>'."\n";
$templates['xhtml']['container4'] = '<div class="container4">{data}</div>'."\n";
$templates['xhtml']['container5'] = '<div class="container5">{data}</div>'."\n";
$templates['xhtml']['container6'] = '<div class="container6">{data}</div>'."\n";
$templates['xhtml']['container_orange'] = '<div class="container_orange">{data}</div>'."\n";
$templates['xhtml']['container_blue'] = '<div class="container_blue">{data}</div>'."\n";
// custom
$templates['xhtml']['container11'] = '<div class="container11">{data}</div>'."\n";

// sections
$templates['xhtml']['section'] = '<div class="title"><img src="{img}" alt="- "/> {title}</div>'."\n".'<div class="cell">{contents}</div>';
//$templates['xhtml']['section_home'] = '<div class="title_home"><img src="{img}" alt="- "/>{title}</div>'."\n".'<div class="cell">{contents}</div>'."\n"; 
$templates['xhtml']['section_home'] = '<div class="title_home"><img src="{img}" alt="- "/></div>'."\n".'<div class="cell">{contents}</div>'."\n";
$templates['xhtml']['section_special'] = '<img src="{img}" alt="- "/><br/>'."\n".'<div class="cell_special1">{contents}</div>'."\n";
$templates['xhtml']['section_page'] = '<div class="title_page"><img src="{gameloft_logo}" alt="Gameloft"/><br/><img src="{img}" alt="- "/> {title}</div>'."\n".'<div class="cell_featured">{contents}</div>';
$templates['xhtml']['section_page2'] = '<div class="title_page"><img src="{gameloft_logo}" alt="Gameloft"/><br/><img src="{img}" alt="- "/> {title}</div>'."\n".'<div class="cell">{contents}</div>';
$templates['xhtml']['section_product_page'] = '<div class="title_page"><img src="{gameloft_logo}" alt="Gameloft"/></div><div class="deep_blueish_row_thick"> {title}</div>'."\n".'<div class="cell">{contents}</div>';
$templates['xhtml']['section_related'] = '<div class="deep_blueish_row_thick">{title}</div>'."\n".'<div class="cell">{contents}</div>';

$templates['xhtml']['section_catbk_logo'] = '<div class="title_page_bk"><img src="{gameloft_logo}" alt="Gameloft"/></div>{data_bk}<div class="deep_blueish_row_thick"> {title}</div>'."\n".'<div class="cell_featured">{contents}</div>';
$templates['xhtml']['section_bk_logo'] = '<div class="title_page_bk"><img src="{gameloft_logo}" alt="Gameloft"/></div>{data_bk}<div class="deep_blueish_row_thick"> {title}</div>'."\n".'<div class="cell">{contents}</div>';
// forms
$templates['xhtml']['form_newsletter'] = '<form action="{action}" method="get"><input type="text" name="contactinfo" value="{contactinfo}"/><br/>'."\n".'{hidden_fields}{input_fields}'."\n".'<input type="submit" name="submit" value="{submit_text}" class="submit"/></form>';
$templates['xhtml']['form_raiting'] = '<form name="rate" action="{action}" method="get">'."\n".'{hidden_fields}'."\n".'<table class="deep_blueish_row_2"><tr><td>{username}</td><td class="rating">{input_text}</td></tr></table>'."\n".'<table class="deep_blueish_row_3"><tr><td>{rating_text}</td><td><select name="rating">{raiting_options}</select>'."\n".'{select_text}</td></tr></table>'."\n".'<table class="deep_blueish_row_4"><tr><td>{comment}</td><td class="rating">{input_comment}</td></tr></table>'."\n".'<table><tr><td collspan="2"><input type="submit" name="submit" value="{submit_text}" class="submit"/></td></tr></table></form>';
$templates['xhtml']['raiting_options'] = '<option value="{data}">{data}</option>'."\n";
$templates['xhtml']['input_text'] = '<input type="text" name="{name}" value="{value}" />'."\n";
$templates['xhtml']['input_hidden'] = '<input type="hidden" name="{name}" value="{value}"/>'."\n";
$templates['xhtml']['input_checkbox'] = '<input type="checkbox" name="{name}" value="{value}" {checked}/>'."\n";

$templates['xhtml']['input_hidden_link'] = '';
$templates['xhtml']['textarea'] = '<textarea name="{name}"  cols="17" rows="2" class="comment_block">{value}</textarea>';
$templates['xhtml']['form_feedback'] = '<form action="{action}" method="get">{hidden_fields}{checkbox_fields}{input_fields}<input type="submit" name="submit" value="{submit_text}" class="submit"/></form>';

// other
$templates['xhtml']['subscribe_section'] = '<img src="{src}" alt="{alt}" class="icon_img"/><a href="{product_link}">{product_title}</a><br /><img src="{arrow}" class="icon_img"/><a href="{buy_link}">{buy_title}</a><br />';
$templates['xhtml']['featured_game_my'] = '<table><tr><td valign="top">{links}</td></tr></table>'."\n";
$templates['xhtml']['bk_logo'] = '<div class="title_page_bk" align="left"><img src="{src}" alt="{alt}" /></div>';
$templates['xhtml']['game_row_table'] = '<table class="minimal"><tr><td valign="middle" class="smallcol"><img src="{img_src}" /></td><td valign="middle">{data}</td></tr></table>'."\n";

$templates['xhtml']['logo'] = '<div class="title_page" align="left"><img src="{src}" alt="{alt}" /></div>';
$templates['xhtml']['selectionoftheweek'] = '<div class="title_page" align="left"><img src="{src}" alt="{alt}" /></div>';
$templates['xhtml']['games_phone'] = '<div class="games_phone" align="left">{data}</div>'."\n";
$templates['xhtml']['categories_list'] = '<div class="categories_list">{data}</div>'."\n";
$templates['xhtml']['thumbs_item'] = '<td class="thumbs" valign="top"><br />{data}</td>';
$templates['xhtml']['thumbs_row'] = '<tr>{data}</tr>';
$templates['xhtml']['table'] = '<table>{data}</table>'."\n";
$templates['xhtml']['featured_game_table'] = '<table class="table_type_1">{data}</table>'."\n";
$templates['xhtml']['subscription_table'] = '<table class="table_type_1">{data}</table>'."\n";
$templates['xhtml']['featured_game_contents_0'] = '<tr class="white_row"><td class="cell_image_holder"><img src="{img}" alt="img"/></td><td>{title}<br/>{links}</td></tr>'."\n";
$templates['xhtml']['featured_game_contents_1'] = '<tr class="blueish_row"><td class="cell_image_holder"><img src="{img}" alt="img"/></td><td>{title}<br/>{links}</td></tr>'."\n";
$templates['xhtml']['subscription_game'] = '<tr class="white_row"><td><img src="{img}" alt="img"/></td><td>{links}</td></tr>'."\n";
$templates['xhtml']['rating_username_bg'] = '<div class="deep_blueish_row_2">{data}</div>'."\n";
$templates['xhtml']['rating_bg'] = '<div class="deep_blueish_row_3">{data}</div>'."\n";
$templates['xhtml']['rating_comments_bg'] = '<div class="deep_blueish_row_4">{data}</div>'."\n";

$templates['xhtml']['sap_0'] = '<tr class="white_row"><td><img src="{img}" alt="img"/></td><td>{title}</td></tr><tr class="white_row"><td><img src="{arrow}" alt="img"/></td><td>{links}</td></tr>'."\n";
$templates['xhtml']['sap_1'] = '<tr class="blueish_row"><td><img src="{img}" alt="img"/></td><td>{title}</td></tr><tr class="blueish_row"><td><img src="{arrow}" alt="img"/></td><td>{links}</td></tr>'."\n";

$templates['xhtml']['sap_table'] = '<table class="table_type_1">{data}</table>'."\n";
$templates['xhtml']['separator'] = '<img src="{data}" alt="------------------" class="separator"/>';
$templates['xhtml']['navigation_selected'] = '<b>{data}</b>';
$templates['xhtml']['navigation'] = '{data}';
$templates['xhtml']['product_buy'] = '<div class="product_buy">{data}</div>';
$templates['xhtml']['category_list_row_1'] = '<div class="white_row">{data}</div>';
$templates['xhtml']['category_list_row_0'] = '<div class="blueish_row">{data}</div>';
$templates['xhtml']['bluerow'] = '<div class="deep_blueish_row"><img src="{src}" alt="{alt}" class="icon_img"/> <a href="{href}" class="whitelink">{title}</a></div>';

$templates['xhtml']['bogofanimation'] = '<div class="bogofgamesshortlist">{text}</div><img src="{img}" alt="img" class="icon_img"/><a href="{href}">{title}</a>';
$templates['xhtml']['specialgameanimation'] = '<div class="blueish_row"><img src="{img}" alt="img" class="icon_img"/><a href="{href}">{title}</a></div>';

// General deep blue row - should be used generically
$templates['xhtml']['deepbluerow'] = '<div class="deep_blueish_row">{data}</div>';

// General orange row - should be used generically
$templates['xhtml']['orangerow'] = '<div class="orange_row">{data}</div>';

// No DB message
$templates['xhtml']['no_db'] = '<?xml version="1.0"?>
			<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
			<html>
			<head>
			<title>Gameloft</title>
			<link rel="stylesheet" href="style.css" type="text/css" />
			</head>
			<body {body_options}>
			<!-- SITE BODY START -->
			<div class="title_page" align="center">
				<img src="{img_src}" alt="Gameloft"/><br/>
			</div>
			<div class="cell_featured" align="center">
				<b>{no_db_message}</b>
			</div>
			<!-- SITE BODY END -->
			</body>
			</html>';

$templates['xhtml']['meta_refresh'] = '<?xml version="1.0" encoding="{encoding}" ?>
			<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
			<html>
            <head>
                <meta http-equiv="Content-type" content="text/html; charset={encoding}" />
                <meta http-equiv="Refresh" content="{seconds};url={url}" />
            </head>
            <body> {message}
            </body>
			</html>';
//////////////////////////////////////////////////////////////////////////////////////////////////////
// WML
//////////////////////////////////////////////////////////////////////////////////////////////////////

$templates['wml']['meta_refresh'] = '<?xml version="1.0" encoding="{encoding}" ?>
            <!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
            <wml>
            <head>
                <meta http-equiv="Content-type" content="text/vnd.wap.wml; charset={encoding}" />
                <meta http-equiv="Refresh" content="{seconds};url={url}" />
            </head>
            <card id="gl" title="Gameloft">
                {message}
            </card>
            </wml>
            ';
$templates['wml']['center'] = '<p align="center">{data}</p>';
$templates['wml']['center'] = '<p align="right">{data}</p>';
$templates['wml']['img'] = '<img src="{src}" alt="{alt}" />';
$templates['wml']['icon'] = '<img src="{src}" alt="{alt}" />';
$templates['wml']['a'] = '<a href="{href}">{title}</a>';
$templates['wml']['a_no_decoration'] = '<a class="no_decoration" href="{href}">{title}</a>';
$templates['wml']['a_img'] = '<a href="{href}"><img src="{src}" /></a>';
$templates['wml']['a_white'] = '<a href="{href}">{title}</a>';
$templates['wml']['a_orange'] = '<a href="{href}">{title}</a>';
$templates['wml']['br'] = '<br />'."\n";
$templates['wml']['b'] = '<b>{data}</b>';
$templates['wml']['space'] = '&nbsp;';
$templates['wml']['center_blue'] = '<p align="center">{data}</p>';
$templates['wml']['left_blue'] = '<p align="center">{data}</p>';
$templates['wml']['title_page_bk'] = '<p align="center">{data}</p>';
$templates['wml']['center_orange_bk'] = '<p align="center">{data}</p>';
$templates['wml']['bullet_description'] = '<p>{data}</p>'; // WAP Key-points bullet format
$templates['wml']['orange_link'] = '<b class="orange_link">{data}</b>';
$templates['wml']['red_text'] = '<b class="red_text">{data}</b>';

// cells
$templates['wml']['cell_normal'] = '<p>{data}</p>';
$templates['wml']['cell_featured'] = '<p align="left">{data}</p>'."\n";
$templates['wml']['cell_featured_bg'] = '<div class="cell_featured_bg">{data}</div>'."\n";
$templates['wml']['cell_footer'] = '<p>{data}</p>'."\n";
$templates['wml']['cell_special2'] = '<p>{data}</p>'."\n";
$templates['wml']['img_link'] = '<p><img src="{img}" /><a href="{href}">{link_title}</a></p>'."\n";

// Container
$templates['wml']['container1'] = '<p class="container1">{data}</p>'."\n";
$templates['wml']['container2'] = '<p class="container2">{data}</p>'."\n";
$templates['wml']['container3'] = '<p class="container3">{data}</p>'."\n";
$templates['wml']['container4'] = '<p class="container4">{data}</p>'."\n";
$templates['wml']['container5'] = '<p class="container5">{data}</p>'."\n";
$templates['wml']['container6'] = '<p class="container6">{data}</p>'."\n";


// sections
$templates['wml']['section'] = '<p><img src="{img}" alt="- "/><b>{title}</b></p>'."\n".'<p>{contents}</p>';
$templates['wml']['section_home'] = '<p><img src="{img}" alt="- "/></p>'."\n".'<p>{contents}</p>'."\n";
//$templates['xhtml']['section_special'] = '<img src="{img}" alt="- "/><br/>'."\n".'<div class="cell_special1">{contents}</div>'."\n";
$templates['wml']['section_special'] = '<p><img src="{img}" alt="- "/></p>'."\n".'<p>{contents}</p>'."\n";
$templates['wml']['section_page'] = '<p><img src="{gameloft_logo}" alt="Gameloft"/><br/><img src="{img}" alt="- "/><b>{title}</b></p>'."\n".'<p>{contents}</p>';
$templates['wml']['section_page2'] = '<p><img src="{gameloft_logo}" alt="Gameloft"/><br/><img src="{img}" alt="- "/><b>{title}</b></p>'."\n".'<p>{contents}</p>';
$templates['wml']['section_product_page'] = '<p><img src="{gameloft_logo}" alt="Gameloft"/><br/><b>{title}</b></p>'."\n".'<p>{contents}</p>';
$templates['wml']['section_related'] = '<p><b>{title}</b></p>'."\n".'<p>{contents}</p>';

$templates['wml']['section_catbk_logo'] = '<p><img src="{gameloft_logo}" alt="Gameloft"/><br/><img src="{img}" alt="- "/><br/>{data_bk}<b>{title}</b></p>'."\n".'<p>{contents}</p>';
$templates['wml']['section_bk_logo'] = '<p><img src="{gameloft_logo}" alt="Gameloft"/><br/>{data_bk}<br/><b>{title}</b></p>'."\n".'<p>{contents}</p>';
// forms
$templates['wml']['form_newsletter'] = '<input type="text" name="contactinfo" value="{contactinfo}"/><br/>'."\n".'{input_fields}'."\n".'<anchor><go href="{action}" method="get"><postfield name="contactinfo" value="$contactinfo"/><postfield name="submit" value="submit"/>{hidden_fields}</go>{submit_text}</anchor>';
$templates['wml']['form_raiting'] = '{username}{input_text}<br/>{rating_text}<select name="rating">{raiting_options}</select>{select_text}<br/>{comment}{input_comment}<br/><anchor><go href="{action}" method="get"><postfield name="nickname" value="$nickname"/><postfield name="rating" value="$rating"/><postfield name="comments" value="$comments"/><postfield name="submit" value="submit"/>{hidden_fields}</go>{submit_text}</anchor>';
$templates['wml']['raiting_options'] = '<option value="{data}">{data}</option>'."\n";
$templates['wml']['input_text'] = '<input type="text" name="{name}" value="{value}" />'."\n";
$templates['wml']['input_hidden'] = '<postfield name="{name}" value="{value}"/>'."\n";
$templates['wml']['input_checkbox'] = '<input type="checkbox" name="{name}" value="{value}" {checked}/>'."\n";

$templates['wml']['input_hidden_link'] = '<postfield name="{name}" value="$({name})"/>'."\n";
$templates['wml']['textarea'] =  '<input type="text" name="{name}" value="{value}"/>'."\n";
$templates['wml']['form_feedback'] = '{checkbox_fields}'."\n".'{input_fields}'."\n".'<anchor><go href="{action}" method="get"><postfield name="sites" value="$(sites)"/><postfield name="submit" value="{submit_text}"/>{hidden_fields}</go>{submit_text}</anchor>';


// other
$templates['wml']['subscribe_section'] = '<a href="{product_link}">{product_title}</a><br /> <a href="{buy_link}">{buy_title}</a><br />';
$templates['wml']['bk_logo'] = '<p align="left"><img src="{src}" alt="{alt}" /></p>';

$templates['wml']['logo'] = '<p align="left"><img src="{src}" alt="{alt}" /></p>';
$templates['wml']['selectionoftheweek'] = '<p align="left"><img src="{src}" alt="{alt}" /></p>';
$templates['wml']['games_phone'] = '<p align="left">{data}</p>';
$templates['wml']['categories_list'] = '<p>{data}</p>'."\n";
$templates['wml']['thumbs_item'] = '<td>{data}</td>';
$templates['wml']['thumbs_row'] = '<tr>{data}</tr>';
$templates['wml']['table'] = '<table columns="2" width="100%">{data}</table>'."\n";
$templates['wml']['featured_game_table'] = '{data}'."\n";
$templates['wml']['subscription_table']  = '{data}'."\n";
$templates['wml']['featured_game_contents_0'] = '<p><img src="{img}" alt="img"/><br/>{title}<br/>{links}</p>'."\n";
$templates['wml']['featured_game_contents_1'] = '<p><img src="{img}" alt="img"/><br/>{title}<br/>{links}</p>'."\n";
$templates['wml']['subscription_game'] 			= '<p><img src="{img}" alt="img"/><br/>{title}<br/>{links}</p>'."\n";
$templates['wml']['sap_0'] = '<p><img src="{img}" alt="img"/><br/>{title}<br/>{links}</p>'."\n";
$templates['wml']['sap_1'] = '<p><img src="{img}" alt="img"/><br/>{title}<br/>{links}</p>'."\n";
$templates['wml']['sap_table'] = '{data}'."\n";
$templates['wml']['separator'] = '<img src="{data}" alt="------------------"/>';
$templates['wml']['product_buy'] = '<p>{data}</p>';
$templates['wml']['rating_username_bg'] = ''."\n";
$templates['wml']['rating_bg'] = ''."\n";
$templates['wml']['rating_comments_bg'] = ''."\n";

$templates['wml']['category_list_row_1'] = '{data}<br/>';
$templates['wml']['category_list_row_0'] = '{data}<br/>';
$templates['wml']['bluerow'] = '<p><img src="{src}" alt="{alt}"/> <a href="{href}">{title}</a></p>';

$templates['wml']['bogofanimation'] = '{text}<br/><img src="{img}" alt="img"/><a href="{href}">{title}</a>';
$templates['wml']['specialgameanimation'] = '<br/><img src="{img}" alt="img"/><a href="{href}">{title}</a>';

// General deep blue row - should be used generically
$templates['wml']['deepbluerow'] = '<p>{data}</p>';

// General orange row - should be used generically
$templates['wml']['orangerow'] = '<p>{data}</p>';


// No DB message 
$templates['wml']['no_db'] = '<?xml version="1.0" encoding="{encoding}"?>
			<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
			<wml>
			<head>
			<meta http-equiv="Cache-Control" content="no-cache"/><meta http-equiv="Cache-Control" content="max-age=1"/><meta http-equiv="Cache-Control" content="must-revalidate" forua="true"/>
			</head>
			<card id="gl" title="Gameloft"><p align="left">
			<!-- SITE BODY START -->
			</p><p align="center">
				<img src="{img_src}" alt="Gameloft"/><br/>
				<b>{no_db_message}</b>
			</p><p align="left">
			<!-- SITE BODY END -->
			</p></card>
			</wml>';

//////////////////////////////////////////////////////////////////////////////////////////////////////
// iHTML
//////////////////////////////////////////////////////////////////////////////////////////////////////
// temporrary
$templates['ihtml'] = $templates['xhtml'];
$templates['ihtml']['no_db'] = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD Compact HTML 1.0 Draft//EN">
			<html>
			<head>
			<title>Gameloft</title>
			<META HTTP-EQUIV="content-type" CONTENT="text/html" CHARSET="UTF-8">
			<link rel="stylesheet" href="style.css" type="text/css" />
			</head>
			<body {body_options}>
			<!-- SITE BODY START -->
			<div class="title_page" align="center">
				<img src="{img_src}" alt="Gameloft"/><br/>
			</div>
			<div class="cell_featured" align="center">
				<b>{no_db_message}</b>
			</div>
			<!-- SITE BODY END -->
			</body>
			</html>';

//////////////////////////////////////////////////////////////////////////////////////////////////////
// OML
//////////////////////////////////////////////////////////////////////////////////////////////////////
// temporrary
$templates['oml'] = $templates['xhtml'];

//////////////////////////////////////////////////////////////////////////////////////////////////////
// PML
//////////////////////////////////////////////////////////////////////////////////////////////////////
// temporrary
$templates['pml'] = $templates['xhtml'];

?>
