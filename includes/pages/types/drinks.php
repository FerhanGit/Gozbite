<?php

class DRINKS extends Page
{
	var $site = NULL;
	var $page_name = 'drinks';
	var $drink_obj = NULL;

	var $events = array(
		'header' 	=> 'displayHeaderLinks',	
		'menu' 	=> 'displayMainMenu',	
		'sub_menu' 	=> 'displaySubMenus',	
		'main'		=> 'displayMainStuff',
		'right'	=> 'displayRightColumn',
		'footer'	=> 'displayFooter',
		'title_key_words' => 'titleKeyWords',
		'meta_tags' => 'metaTags',
		'next_previous_stuff' => 'nextPrevious',
		'footer_overlay_div' => 'footerOverlayDiv',
	);

	function DRINKS(& $site)
	{	
		global $conn;
		$this->site = & $site;	
		require_once CLASSDIR."Drink.class.php";
		$this->drink_obj	= new Drink($conn);
	
		
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
	

	function displaySubMenus($params)
	{
		global $conn;
		$header_section = &$params['header_section'];
		$prms = array('page_name' => Pages::getCurrentPageName());
		$header_section .= Pages::loadModule('sub_menus',$prms);			
	}
	

function displayMainStuff($params)
{
	global $conn;
	$main_section = &$params['main_section'];

	if(basename($GLOBALS['_SERVER']['SCRIPT_NAME']) == 'edit.php')
	{
		$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/drinks_main_edit',$prms);	
	}
	else 
	{
		if(!isset($_REQUEST['category']) && !isset($_REQUEST['drink_category']) && !isset($_REQUEST['info']) && (!isset($_REQUEST['search']) && !isset($_REQUEST['search_btn'])) && isset($_REQUEST['drinkID']) && $_REQUEST['drinkID'] > 0)
		{	
			$prms = array('page_name' => Pages::getCurrentPageName());		
			$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/drink_big',$prms);	
		}	
		elseif(!isset($_REQUEST['specialiteti']) && !isset($_REQUEST['tag']) && !isset($_REQUEST['title']) && !isset($_REQUEST['category']) && !isset($_REQUEST['drink_category']) && !isset($_REQUEST['info']) && !isset($_REQUEST['page']) && (!isset($_REQUEST['search']) && !isset($_REQUEST['search_btn'])))
		{	
			$prms = array('page_name' => Pages::getCurrentPageName());		
			$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/drinks_main',$prms);	
		}
	 
		$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/drinks_search',$prms);
	

	}
	
	if(!isset($_REQUEST['edit_btn']) && !isset($_REQUEST['insert_btn']))
	{
		$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/drinks_listing',$prms);	
	}	
	
}
	

function displayRightColumn($params)
{
	global $conn;
	$right_section = &$params['right_section'];
	$prms = array('page_name' => Pages::getCurrentPageName());
	
	if(basename($GLOBALS['_SERVER']['SCRIPT_NAME']) == 'edit.php')
	{
		$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/insert_edit_drink',$prms);	
	}
	
	$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/insert_drink_button',$prms);	
	$right_section .= Pages::loadModule('register_button',$prms);	
	
	$right_section .= '<ul class="TwoHalf">';
		$right_section .= Pages::loadModule('googleAdsenseVertical',$prms);		
		$right_section .= Pages::loadModule('archive_and_baner_120_240',$prms);	
	$right_section .='</ul>';
		
	$right_section .= Pages::loadModule('right_menu',$prms);	
	$right_section .= Pages::loadModule('fb_fun_box',$prms);	
	$right_section .= Pages::loadModule('fb_tw',$prms);	
	$right_section .= Pages::loadModule('na_focus',$prms);	
	$right_section .= Pages::loadModule('baner_300_250',$prms);	
	$right_section .= Pages::loadModule('aphorisms_button',$prms);	
	$right_section .= Pages::loadModule('relax',$prms);					 
				
	$right_section .= Pages::loadModule('bulletin',$prms);
	
	$right_section .= Pages::loadModule('locations/locations_intro',$prms);	
   	
	$right_section .= Pages::loadModule('pr_stuff',$prms);	
	/*
	$right_section .= '<ul class="TwoHalf">';
		$right_section .= Pages::loadModule('baner_120_240',$prms);	
		$right_section .= Pages::loadModule('archive',$prms);	
	$right_section .='</ul>';    		
	*/
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
	$this->drink_obj->whereClause = $params['where_clause'];
	$this->drink_obj->orderClause = $params['order_clause'];
	$this->drink_obj->limitClause = $params['limit_clause'];
   	   
    return $this->drink_obj->load(); // ����� array[$drinkID] � ����������� ��� FALSE
   
}
	



	function titleKeyWords()
	{		
		// KEY WORDS - Slagame gi w HEADER-a na vsqka stranica
		if(isset($_REQUEST['drinkID']))
		{
			print get_drink_nameByDrinkID($_REQUEST['drinkID']).' - Екзотични коктейли, алкохолни и безалкохолни напитки, шейкове, сиропи, нектари, концентрати и още';
		}
		elseif(isset($_REQUEST['drink_category']) OR isset($_REQUEST['category']))
		{
			print get_drink_category(($_REQUEST['drink_category'] > 0 ? $_REQUEST['drink_category'] : $_REQUEST['category'])).' - Екзотични коктейли, алкохолни и безалкохолни напитки, шейкове, сиропи, нектари, концентрати и още';
		}		
		else 
		{
			print 'Екзотични коктейли, алкохолни и безалкохолни напитки, шейкове, сиропи, нектари, концентрати и още';
		}
	
	}
	
	
	
	
	
	function metaTags()
	{		
		// KEY WORDS - Slagame gi w HEADER-a na vsqka stranica
		if(isset($_REQUEST['drinkID']))
		{
			print get_drink_tagsByDrinkID($_REQUEST['drinkID']);
		}
		
	}

	
	
	function nextPrevious()
	{
		if(isset($_REQUEST['drinkID']))
		{
			print 'next_previous(\'drinks\','.$_REQUEST['drinkID'].');';
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