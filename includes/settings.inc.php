<?
//////////////////////////////////////////////////////////////////////////////////////////////////////
// Copyright (c) 2004-2007 Gameloft.com
//
// Settings File for a single operation
// Version 3.0.0
// Description: Used to configure a single site with one operation (used in CGenericSite class)
//
// Generic Site By: Antoni Stavrev <antoni.stavrev@gameloft.com>
// Package: %%package%%
// Author: %%author%%
// Owner: %%owner%%
// Modifications: %%modifs%%
//
//////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////
// DEBUG DEFINES
////////////////////////////////////////////////////////////////////////////////////////////////

define('ST_DEBUG', false);
define('ST_EMAIL', 'krasimir.gruichev@gameloft.com');
//define('ST_EMAIL', 'yavor.vasev@gameloft.com');

// reset the array - the array is not global it is included in CGenericSite and it is used per package
$settings = array();

////////////////////////////////////////////////////////////////////////////////////////////////
// GENERAL SITE SETTINGS
////////////////////////////////////////////////////////////////////////////////////////////////
$settings['operation'] 	= 4498; 				// Generic Site
$settings['package'] 	= 'generig_site_3.0'; 	// Package Title

$settings['operator']	= 21; // Get Operator ID
#$settings['operator']	= findOperatorByIP($_SERVER["REMOTE_ADDR"]); // Get Operator ID
#$settings['operator']	= findOperatorByIP('62.87.37.71'); // Set Statis IP for test purpose (Vodafone)

/* Operators IDs

21 = Telefonica
20 = Vodafone

*/


// Local settings
$settings['country'] 	= 195; 	// Spain
$settings['money'] 		= 2; 	// Euro

$settings['hd_plus_auto_redirect'] = true;
 
// Language
$settings['default_lang'] 	= 'es'; 					// Which language it will use in case it cannot decide which from the available ones to assign
$settings['textpath'] 		= 'includes/texts.ini.php'; // the language strings file location
// possibile languages - !! comment the ones thet are not used !!
$settings['langs'] = array(
#	'1' => 'fr', // French
#	'2' => 'en', // English
#	'3' => 'de', // German
	'4' => 'es', // Spanish
#	'5' => 'it', // Italian
#	'7' => 'nl', // Duch
);
//path to the root folder of the site
//$settings['site_root'] = 'http://wap-php5.gameloft.org/wapshop-es/';
$settings['site_root'] = 'http://wapshop.gameloft.com/wapshop-es/';

////////////////////////////////////////////////////////////////////////////////////////////////
// Set Static dl link on\off
////////////////////////////////////////////////////////////////////////////////////////////////
$settings['static_dl_link'] = false; // true to use rewrite rule and false to use the dynamic dl link

////////////////////////////////////////////////////////////////////////////////////////////////
// Access Restriction
////////////////////////////////////////////////////////////////////////////////////////////////
$settings['restriction_ip'] = false; // restriction IP Array (false if none)

$settings['exclude_category']	= 'exclude';		// Category name for exluding games for PPD

////////////////////////////////////////////////////////////////////////////////////////////////
// DEBUG and OWNER
////////////////////////////////////////////////////////////////////////////////////////////////
$settings['owner'] 			= 'antoni.stavrev@gameloft.com'; // The Owner Developer Email
$settings['parser_debug'] 	= false; // parser debug mode
$settings['debug_mode'] 	= false; // some things are displayed for debugging purpoces

/////////////////////////////////////////////////////////////////////////////////////////////////
// PROMOTIONS
/////////////////////////////////////////////////////////////////////////////////////////////////

// propmotions merge
$settings['merge_promotions'] = true; // determines whenever a game participates in several promotions should it use only one of them or all

// BOGOF - TODO - remove test data
$settings['bogof_enable'] 			= true; 	// enable/disable the functionality
$settings['bogof_promo'] 			= 'bogof'; 	// the promotion name and the 'promo' get parameter in case to be used when various promotions are conflicting
$settings['bogof_buy_categories'] 	= array('bogof_buy'); 	// the categories that are going to be used for BOGOF purchase
$settings['bogof_free_categories'] 	= array('bogof_free'); 		// the categories that are going to be used for free download from BOGOF
$settings['bogof_free_count'] 		= 5; 		// free games to show on buy listing page and to show more free games
$settings['bogof_buy_show'] 		= 3; 		// now many free games to be shown on the buy page
$settings['bogof_expire'] 			= 86400;	// in seconds, usually it is 24h (86400 sec)

$settings['categoriesToDisplayOnIndex'] = Array('newgames');
/////////////////////////////////////////////////////////////////////////////////////////////////
// BURGUER KING
/////////////////////////////////////////////////////////////////////////////////////////////////

$settings['burguerking_free_adids'] 				= array('128337');
$settings['burguerking_buy_adids'] 				    = array('128341');
$settings['burguerking_cat'] 				        = array('newgames');
$settings['burgerking_category_free'] 				= array('burgerking_free');
$settings['burgerking_wap_category_free'] 			= array('wap_burgerking_free');
$settings['burguerking_price'] 				        = '3';
$settings['burguerking_link']['menuhome']	        = 'http://m.burgerking.es/index.php';
$settings['burguerking_img']['menuhome']	        = 'menuhome.gif';
$settings['burguerking_link']['menurestaurantes']   = 'http://m.burgerking.es/restaurantes.php';
$settings['burguerking_img']['menurestaurantes']    = 'menurestaurantes.gif';
$settings['burguerking_link']['menuregistro']       = 'http://m.burgerking.es/loginregister.php';
$settings['burguerking_img']['menuregistro']        = 'menuregistro.gif';
$settings['burguerking_link']['menu2d']             = 'http://m.burgerking.es/2dcodes.php';
$settings['burguerking_img']['menu2d']              = 'menu2d.gif';


// GIFT
$settings['gift_enable'] 				= true; 		// enable disable gift feature
$settings['gift_all_games'] 			= true; 		// using gift for all games
$settings['gift_promo_enable'] 			= true; 		// using gift with promotions
$settings['gift_promo'] 				= 'gift'; 		// the promotion name and the 'promo' get parameter in case to be used when various promotions are conflicting
$settings['gift_promo_categories'] 		= 'action'; 	// promotion category - which games participate in the promotion
$settings['gift_promo_free_category'] 	= 'kids'; 		// in case of the promotion the category of free games
$settings['gift_promo_type'] 			= 'wallpaper'; 	// can be 'games'

/////////////////////////////////////////////////////////////////////////////////////////////////
// FUNCTIONALITIES
/////////////////////////////////////////////////////////////////////////////////////////////////

// if we should display downlaod page or the game is going to start downloading immediately
$settings['show_download_page'] = true; // in case we do need to show the page (or just download to start immediately)

// featured game
$settings['featured_game'] 			= true;	 	// should it show the featured game
$settings['featured_count'] 		= 3; 		// 1 or more, 0 is same as 1
$settings['featured_game_cat'] 		= 'gow_bestsellers'; // display category of the featured game
$settings['featured_game_cat_type'] = 'home'; 	// type of the display category of the featured game
$settings['featured_filename'] 		= '1.gif'; 	// the featured game preview ima filename


// shown display categories on the home page
$settings['home_categories_type'] = 'home'; // the type of the display categories on the home page

// game ratings
$settings['use_raiting'] 			= true;
$settings['raiting_limit_user'] 	= true;
$settings['raiting_max_rate'] 		= 10; 	// the maximum raiting value

// on the product page
$settings['product_show_copyrights']	= true;
$settings['product_show_terms'] 		= true;
$settings['product_show_support'] 		= false;
$settings['product_free_video'] 		= false;

// newsletter
// !! IMPORTANT !! This system need a Service to be created and correctly set.
$settings['newsletter'] 			= false; 	// General use newsletter
$settings['newsletter_service'] 	= 'test'; 	// Newsletter Global Service - !! WARNING !! This system need a Service to be created and correctly set.
$settings['newsletter_by_email'] 	= true; 	// True - sent by email; false - sent by SMS

// Classic Hits
$settings['classic_hits'] 		= true; 			// is the classic hits enabled to show
$settings['all_category_games'] = 'wap_all_games'; 	// all games with categories

// Game categories on index
$settings['index_categories'] 		= true;
$settings['index_categories_list'] 	= 600; 	// max categories to display on the index

// Related Games
$settings['related_games'] 			= true; // enable/disable
$settings['related_icon_rows'] 		= 1; 	// how many related games are going to be shown with images on other pages
$settings['related_page_icon_rows'] = 2; 	// how many related games are going to be shown with images on realted games page
$settings['related_page_max_games'] = 20; 	// how many games are going to be displayed on the related page totally
$settings['related_show'] 			= 6; 	// how many related games (totally) are going to be shown on product or other pages
$settings['related_buy_show'] 		= 3; 	// now many related games to be shown on the buy page

// Redownload
$settings['redownload'] 		= true; 	// enable/disable redownload option
$settings['redownload_expire'] 	= 604800; 	// expire time to redownload in seconds (604800 sec = 7 Days)
$settings['bk_start_time'] 	= '604800'; 	// 1 week (test)

////////////////////////////////////////////////////////////////////////////////////////////////
// VISUAL and APPEARANCE
////////////////////////////////////////////////////////////////////////////////////////////////

// general
$settings['utf8'] 						= false; // use UTF8 to unicode conversion
$settings['i-mode'] 					= false; // if the site is i-mode
$settings['versioninfo_description'] 	= 'WAP'; // check for group (from versioninfo.php)

// visual preferences
$settings['category_games_per_page'] 	= 10;	// the number of games shown in each category page
$settings['home_gameslist'] 			= 5; 	// the number of games to display on the home page from a category
$settings['alpha_per_page'] 			= 30;	// how many games are going to be listed per page sorted alphabetically
$settings['categories_per_page'] 		= 50; 	// how many categories should be shown per page in category listing
$settings['category_thumb_rows'] 		= 2; 	// how many rows of thumbnails we have to show on the category page
$settings['thumbs_max_per_row'] 		= 2; 	// the maximum number of thumbs that are going to be shown per a row if the platform supports it
$settings['price_format'] 				= '0.00'; // it can be '0', '0.0' or '0.00'; Default is '0' - it means that the value is unchanged from the DB

// default small screenshots (thumbnail previews)
$settings['small_screenshots_size'] 	= 50; 	// (int) in pixels - used also to find the directory name
$settings['game_icons_size'] 			= 16; 	// used to find the game icon images dir
$settings['small_screenshots_imgFilename'] = '1'; // the default filename (without the extension

// Site parsing options
$settings['template']['title'] 			= 'Gameloft';
$settings['template']['body_options'] 	= ' bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF" link="#8F0002" alink="#FE0000" vlink="#FE0000" ';
$settings['template']['css_file'] 		= 'style.css'; // the CSS file location

// prices
$settings['show_price'] = true; // if it has to show prices for a game

// images absolute path prefix
$settings['site_img_path'] 			= 'http://wapshop.gameloft.com/waptemplate/images/common_3_1/es/'; // !to be sync with the below! the path to the images accessed from the internet
$settings['internal_img_path'] 		= '/var/www/shops/wapshopgameloftcom/waptemplate/images/common_3_1/es/'; // the internal path accesed from the file system - !WARNING! - to be ALWAYS sync with the above!
$settings['img_sections_dirname'] 	= 'section/'; // the directory that holds section images
$settings['gameimg_subscribe_web_path'] = 'http://media01.gameloft.com/products/{product}/default/{img_type}/screenshots/16/1.gif';

// bullets
$settings['bullets']['default'] 	= 'bullet_1';
$settings['bullets']['bullet_1'] 	= '- ';
$settings['bullets']['bullet_2'] 	= '-- ';
$settings['bullets']['lt'] 			= '< ';
$settings['bullets']['gt'] 			= '> ';
$settings['bullets']['previous'] 	= '<<';
$settings['bullets']['next'] 		= '>>';
$settings['bullets']['empty'] 		= '';

/////////////////////////////////////////////////////////////////////////////////////////////////
// SERVICE PARAMS
/////////////////////////////////////////////////////////////////////////////////////////////////

// DB failure - these settings are in case of DB down, to show properly the user firendly message
$settings['db_down']['encoding'] = 'ISO-8859-1'; // encoding in case it cannot use the DB to show the message
$settings['db_down']['template'] = false; // you can force which template to output from templates.inc.php (or leave it false - automatic)

// the site uses filters
$settings['use_filters'] = false;

// get params
$settings['get_lan'] 		= 'lan'; 	// Language Get Variable Name
$settings['get_return'] 	= 'r'; 		// the GET variable name of the return param
$settings['get_page'] 		= 'page'; 	// the page GET variable used in navigation listing (A-Z)
$settings['get_promo'] 		= 'promo'; 	// last visited promotion parameter
$settings['get_result'] 	= 'result'; // the variable which the result is passed from the form submission protection function redirectForm()

// Return Link ommit GET parameters
$settings['return_omit'] = array('sv', 'adid', 'igagame', 'igpop'); // get parameters which are going to be ommited while generating return link

// in case of old functions that work with constants and $GLOBALS
$settings['define_constants'] = true;

// tracking functionality
$settings['tracking'] = true; // enable/disable tracking functionality

// display categories
$settings['only_local_display_categories'] = false; // whenever we are using only local or local with global display categories

// available scales
$settings['service_scales'] = array(96, 120, 128, 176, 240);

// parser force to use specific template - template name or false
$settings['force_parser'] = false;

// user XID
$settings['XIDType'] = 'header'; // Where to get the XID
$settings['XIDName'] = 'TM_user-id'; // Name of the variable that contains the XID

// Gameloft Catalog Product ID
$settings['gameloft_catalog_id'] = 191;

// Some files defined
$settings['pages']['home'] 		= 'index.php';
$settings['pages']['buy'] 		= 'buy.php';
$settings['pages']['product'] 	= 'product.php';

// game images paths and settings
$settings['gameimg_web_path'] 	= 'http://www.gameloft.com/common/products/{product}/{path_medias}/{img_type}/screenshots/{size}/{img_name}.gif'; // web location of game images
$settings['gameimg_file_path'] 	= '/var/www/shops/www.gameloft.com/common/products/{product}/{path_medias}/{img_type}/screenshots/{size}/{img_name}.gif'; // the location on the file system of the server
$settings['gameimg_featured_web_path'] 	= 'http://media01.gameloft.com/products/{product}/default/wap/screenshots/40/splash.gif';
$settings['gameimg_small_web_path'] 	= 'http://media01.gameloft.com/products/{product}/default/{img_type}/screenshots/15/1.gif';
$settings['gameimg_type_wap'] 			= 'wap'; // images for WML and xHTML
$settings['gameimg_type_imode'] 		= 'imode'; // images for i-mode
$settings['gameimg_placeholder'] 		= 'placeholders/default';
$settings['image_default_screenshot'] 	= 1; // the default image to be shown in product page
$settings['image_max_number'] 			= 5; // the max number of image preview in product media page
$settings['images_common'] 				= $settings['site_root'] . 'images/common/';


// content preview images
$settings['content_img_prefix'] 		= 'http://www.gameloft.com/common/contents/';
$settings['content_img_middle_path'] 	= '/wap/preview/';
$settings['content_img_filename'] 		= 'preview.gif';

// notifycharge relative path filename - RELATIVE FROM "d.php"
$settings['notifycharge_filename'] = 'notifycharge.php'; // currently in the same dir as d.php

// 3D categories
$settings['3D_regexp_recognition'] = '3d'; // the regexp to recognize 3D subcategory key

// Contents types - defined ID type values
$settings['contents_types']['wallpaper'] 	= 1;
$settings['contents_types']['monophonic'] 	= 2;
$settings['contents_types']['polyphonic'] 	= 3;
$settings['contents_types']['truetone'] 	= 4;
$settings['contents_types']['screensaver'] 	= 5;
$settings['contents_types']['videotone'] 	= 6;
$settings['contents_types']['video'] 		= 7;
$settings['contents_types']['pc_game'] 		= 8;
$settings['contents_types']['pc_demo'] 		= 9;

// contents which have image preview
$settings['contents-img_preview'] = array(1, 5); // the values from the contents types that have image preview



$settings['bm_key'] 			= 'mode';
$settings['bm_value'] 			= 'bm';
$settings['bm_allowed_hosts'] 	= Array('sofwks0127', 'sofwks0055', 'barlap0011', 'GRELAP0013');

$settings['bypassed_ips'] = array(
	'200.80.56.187',	// Jesica's IP
	'84.233.214.11',  // requested
	'10.123.200.159', // requested
	'82.103.112.60',  // External Gameloft IP addres for life test
	'10.59.8.178',     // Internal Gameloft IP addres for test on MDC server
	'10.59.8.215',     // Internal Gameloft IP addres for test on MDC server - Ognian Marinov
	'10.49.8.39',     // Internal Gameloft IP addres for test on MDC server - In�s Torres
	'80.25.162.121',     // External Gameloft IP addres for live test - In�s Torres
	'10.59.8.178',     // Internal Gameloft IP addres for test on MDC server - Yamile
	);

$settings['xid_number'] = false;

$settings['as_newspaper_adids'] 					= array('127057');
$settings['as_newspaper_operation'] 				= '5927';
$settings['as_newspaper_featured_game_cat_type'] 	= 'category_listing';
$settings['as_newspaper_featured_game_cat'] 		= 'sports';
$settings['as_newspaper_link']						= 'http://movil.as.com/index.php';

$settings['comment_length'] = 10;//Support tool minimum comment length
?>
