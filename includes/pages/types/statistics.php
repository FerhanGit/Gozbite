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
class STATISTICS extends Page
{
	var $site = NULL;
	var $page_name = 'statistics';
	
	var $events = array(
		'header' 	=> 'displayHeaderLinks',	
		'menu' 	=> 'displayMainMenu',	
		'main'		=> 'displayMainStuff',
		'right'	=> 'displayRightColumn',
		'footer'	=> 'displayFooter',
		'title_key_words' => 'titleKeyWords',
		'footer_overlay_div' => 'footerOverlayDiv',
	);

	function STATISTICS(& $site)
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
	$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/statistics_big',$prms);	
		
}
	



function displayRightColumn($params)
{
	global $conn;
	$right_section = &$params['right_section'];
	$prms = array('page_name' => Pages::getCurrentPageName());

	
	$right_section .= Pages::loadModule('register_button',$prms);	
	$right_section .= Pages::loadModule('fb_fun_box',$prms);	
	$right_section .= Pages::loadModule('fb_tw',$prms);	
	$right_section .= Pages::loadModule('na_focus',$prms);	
	$right_section .= Pages::loadModule('baner_300_250',$prms);	
	$right_section .= Pages::loadModule('aphorisms_button',$prms);	
	$right_section .= Pages::loadModule('relax',$prms);						
		
	$right_section .= Pages::loadModule('bulletin',$prms);
	
	$right_section .= Pages::loadModule('locations/locations_intro',$prms);	
   	
	$right_section .= Pages::loadModule('pr_stuff',$prms);	
	
	$right_section .= '<ul class="TwoHalf">';
		$right_section .= Pages::loadModule('baner_120_240',$prms);	
		$right_section .= Pages::loadModule('archive',$prms);	
	$right_section .='</ul>';    		
	
	$right_section .= Pages::loadModule('googleAdsense_300x250px',$prms);	
	$right_section .= Pages::loadModule('survey',$prms);	
	 	
	$right_section .= Pages::loadModule('fb_activity',$prms);					 
	 	
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
		if(isset($_REQUEST['get']) && $_REQUEST['get'] == 'firms')
		{
			print 'Статистикчески данни за Заведения, Ресторанти, Пицарии, Механи, Сладкарници, Кръчми, Клубове, Дискотеки и др.';
		}
		elseif(isset($_REQUEST['get']) && $_REQUEST['get'] == 'drinks')
		{
			print 'Статистикчески данни за Напитки , коктейли, алкохолни и безалкохолни шейкове, мусове, кафета, чайове, енергийни напитки и др.';
		}
		elseif(isset($_REQUEST['get']) && $_REQUEST['get'] == 'recipes')
		{
			print 'Статистикчески данни за Готварски рецепти, екзотични ястия, месни ястия, вегетариоански, торти, сладкиши, тестени изделия, салати, супи и др.';
		}
		elseif(isset($_REQUEST['get']) && $_REQUEST['get'] == 'guides')
		{
			print 'Статистикчески данни за Справочни Описания на хранителни продукти и съставки, екзотични растения и подправки';
		}
		elseif(isset($_REQUEST['get']) && $_REQUEST['get'] == 'posts')
		{
			print 'Статистикчески данни за Статии, Полезни кулинарни Съвети, Споделен опит, Зов за помощ и още ';
		}
		else 
		{
			print 'Статистикчески данни ';
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