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
class LOCATIONS extends Page
{
	var $site = NULL;
	var $page_name = 'locations';
	var $location_obj = NULL;
	
	var $events = array(
		'header' 	=> 'displayHeaderLinks',	
		'menu' 	=> 'displayMainMenu',	
		'main'		=> 'displayMainStuff',
		'right'	=> 'displayRightColumn',
		'footer'	=> 'displayFooter',
		'title_key_words' => 'titleKeyWords',
		'next_previous_stuff' => 'nextPrevious',
		'footer_overlay_div' => 'footerOverlayDiv',
		'load.map' => 'loadGoogleMap',
	);

	
	function LOCATIONS(& $site)
	{	
		global $conn;
		$this->site = & $site;	
		require_once CLASSDIR."Location.class.php";
		$this->location_obj	= new Location($conn);		
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

		if(isset($_REQUEST['insert_comment_btn']))
		{	
			$prms = array('page_name' => Pages::getCurrentPageName());		
			$header_section .= Pages::loadModule(Pages::getCurrentPageName().'/proceed_locations_coments',$prms);	
		}
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

	
	if(basename($GLOBALS['_SERVER']['SCRIPT_NAME']) == 'edit.php')
	{
		$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/locations_main_edit',$prms);	
	}
	else 
	{
		
		if((!isset($_REQUEST['search']) && !isset($_REQUEST['search_btn'])) && isset($_REQUEST['locationID']) && $_REQUEST['locationID'] > 0)
		{	
			$prms = array('page_name' => Pages::getCurrentPageName());		
			$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/locations_big',$prms);	
		}
		else
		{
			$prms = array('page_name' => Pages::getCurrentPageName());		
			$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/locations_main',$prms);	
		}	
		
	}
	
	
}
	

function displayRightColumn($params)
{
	global $conn;
	$right_section = &$params['right_section'];
	$prms = array('page_name' => Pages::getCurrentPageName());
	
	if(basename($GLOBALS['_SERVER']['SCRIPT_NAME']) == 'edit.php')
	{
		$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/insert_edit_locations',$prms);	
	}
	
	$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/insert_locations_button',$prms);	
	
	$right_section .= Pages::loadModule('register_button',$prms);	
	/*
	$right_section .= '<ul class="TwoHalf">';
		$right_section .= Pages::loadModule('googleAdsenseVertical',$prms);		
		$right_section .= Pages::loadModule('archive',$prms);	
	$right_section .='</ul>';
	*/	
	$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/locations_letters',$prms);	
	$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/locations_intro',$prms);	

	
	$right_section .= Pages::loadModule('fb_fun_box',$prms);	
	$right_section .= Pages::loadModule('fb_tw',$prms);	
	$right_section .= Pages::loadModule('na_focus',$prms);	
	$right_section .= Pages::loadModule('baner_300_250',$prms);	
	$right_section .= Pages::loadModule('aphorisms_button',$prms);	
	$right_section .= Pages::loadModule('relax',$prms);					 
		
		
	$right_section .= Pages::loadModule('bulletin',$prms);
   	
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

	


	

function getItemsList($params)
{		
	$this->location_obj->whereClause = $params['where_clause'];
	$this->location_obj->orderClause = $params['order_clause'];
	$this->location_obj->limitClause = $params['limit_clause'];
   	   
    return $this->location_obj->load(); // ����� array[$drinkID] � ����������� ��� FALSE
   
}
	
	


	function titleKeyWords()
	{		
		// KEY WORDS - Slagame gi w HEADER-a na vsqka stranica
		if(isset($_REQUEST['themeID']))
		{
			print 'Описания на дестинации, населени места, градове, села, курорти и други забележителни райони. '.get_location_type_and_nameBylocationID($_REQUEST['locationID']);
		}			
		else 
		{
			print 'Описания на дестинации, населени места, градове, села, курорти и други забележителни райони';
		}
	
	}
	
	
	
	function nextPrevious()
	{		
		if(isset($_REQUEST['locationID']))
		{
			print 'next_previous(\'locations\','.$_REQUEST['locationID'].');';
		}
	}
	
	
	
	
	
	function loadGoogleMap()
	{
		print 'loadMap(42.693516, 23.33246);';		
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