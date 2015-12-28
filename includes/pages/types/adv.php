<?php

/**
 * Implements Bogof (Buy one get one free) promotion.
 * There are two categories:
 *	   One with games that are valid bogof games, which means only games from that category
 *	   trigger the bogof promotion.
 *	   The second list is with the free games available.
 *
 * Specifications:
 *		If you buy a game from the "buy" bogof category, you are eligible
 *		for free game from "free" bogof category.
 *		If you are buying a free game check is made to ensure the game is free and you
 *		are eligible for the free download.
 */
class ADV extends Page
{
	var $site = NULL;
	var $page_name = 'adv';
	
	var $events = array(
		'header' 	=> 'displayHeaderLinks',	
		'menu' 	=> 'displayMainMenu',	
		'main'		=> 'displayMainStuff',
		'footer'	=> 'displayFooter',
		'title_key_words' => 'titleKeyWords',
		'footer_overlay_div' => 'footerOverlayDiv',
	);

	function ADV(& $site)
	{	
		global $conn;
		$this->site = & $site;	
		
	
	}

	

	function isActive()
	{
		return true;
	}




	function displayHeaderLinks($params)
	{
		global $conn;
		$header_section = &$params['header_section'];
		$prms = array('page_name' => Pages::getCurrentPageName());
		$header_section .= Pages::loadModule('header_links',$prms);	
	}
	

	function displayMainMenu($params)
	{
		global $conn;
		$header_section = &$params['header_section'];
		$prms = array('page_name' => Pages::getCurrentPageName());
		$header_section .= Pages::loadModule('main_menu',$prms);			
	}
	


	

function displayMainStuff($params)
{
	global $conn;
	$main_section = &$params['main_section'];
				
	$prms = array('page_name' => Pages::getCurrentPageName());	
	$prms['sub_page'] = ($_REQUEST['get']?$_REQUEST['get']:'auditory');	
	$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/adv_big',$prms);	
		
		
}
	


	

function displayFooter($params)
{
	global $conn;
	$footer_section = &$params['footer_section'];
	$prms = array('page_name' => Pages::getCurrentPageName());

	$footer_section .= Pages::loadModule('footer_links',$prms);		  
}

	



	function titleKeyWords()
	{		
		// KEY WORDS - Slagame gi w HEADER-a na vsqka stranica
		if(isset($_REQUEST['get']) && $_REQUEST['get'] == "base")
		{
			print 'Рекламни предложения, атрактивни услуги и оферти за участие в сайта - Безплатни рекламни предложения';
		}
		elseif(isset($_REQUEST['get']) && $_REQUEST['get'] == "alternative")
		{
			print 'Рекламни предложения, атрактивни услуги и оферти за участие в сайта - Алтернативни рекламни предложения';
		}
		elseif(isset($_REQUEST['get']) && $_REQUEST['get'] == "auditory")
		{
			print 'Рекламни предложения, атрактивни услуги и оферти за участие в сайта - Аудитория на портала';
		}
		elseif(isset($_REQUEST['get']) && $_REQUEST['get'] == "banner")
		{
			print 'Рекламни предложения, атрактивни услуги и оферти за участие в сайта - Банерна реклама';
		}
		else 
		{
			print 'Рекламни предложения, атрактивни услуги и оферти за участие в сайта';
		}
	
	}
	
	
	
	
	
	function footerOverlayDiv($params)
	{
		global $conn;
		$footer_overlay = &$params['footer_overlay'];
		$prms = array('page_name' => Pages::getCurrentPageName());	
		$footer_overlay .= Pages::loadModule('footer_overlay_div_banner',$prms);	
	}
	
	
	
	
}





?>