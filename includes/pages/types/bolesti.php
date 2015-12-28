<?php

class BOLESTI extends Page
{
	var $site = NULL;
	var $page_name = 'bolesti';
	var $bolest_obj = NULL;

	var $events = array(
		'header' 	=> 'displayHeaderLinks',	
		'menu' 	=> 'displayMainMenu',	
		'main'		=> 'displayMainStuff',
		'right'	=> 'displayRightColumn',
		'footer'	=> 'displayFooter',
		'title_key_words' => 'titleKeyWords',
		'meta_tags' => 'metaTags',
		'next_previous_stuff' => 'nextPrevious',
		'footer_overlay_div' => 'footerOverlayDiv',
	);

	function BOLESTI(& $site)
	{	
		global $conn;
		$this->site = & $site;	
		require_once CLASSDIR."Bolest.class.php";
		$this->bolest_obj	= new Bolest($conn);
	
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
			$header_section .= Pages::loadModule(Pages::getCurrentPageName().'/proceed_bolest_coments',$prms);	
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
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/bolesti_main_edit',$prms);	
	}
	else 
	{
		if(!isset($_REQUEST['category']) && !isset($_REQUEST['bolest_category']) && (!isset($_REQUEST['search']) && !isset($_REQUEST['search_btn'])) && isset($_REQUEST['bolestID']) && $_REQUEST['bolestID'] > 0)
		{	
			$prms = array('page_name' => Pages::getCurrentPageName());		
			$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/bolest_big',$prms);	
		}		
		elseif(!isset($_REQUEST['category']) && !isset($_REQUEST['bolest_category']) && !isset($_REQUEST['bolest_simptom']) && !isset($_REQUEST['bolest_body']) && !isset($_REQUEST['bolest_autor']) && !isset($_REQUEST['autor']) && !isset($_REQUEST['page']) && (!isset($_REQUEST['search']) && !isset($_REQUEST['search_btn'])))
		{	
			$prms = array('page_name' => Pages::getCurrentPageName());		
			$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/bolesti_main',$prms);	
		}
	       
		$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/bolesti_search',$prms);
	}
	
	
	if(!isset($_REQUEST['edit_btn']) && !isset($_REQUEST['insert_btn']))
	{
		$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/bolesti_listing',$prms);	
	}
	
}
	

function displayRightColumn($params)
{
	global $conn;
	$right_section = &$params['right_section'];
	$prms = array('page_name' => Pages::getCurrentPageName());
	
	if(basename($GLOBALS['_SERVER']['SCRIPT_NAME']) == 'edit.php')
	{
		$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/insert_edit_bolest',$prms);	
	}
	
	$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/insert_bolest_button',$prms);	
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
	$this->bolest_obj->whereClause = $params['where_clause'];
	$this->bolest_obj->orderClause = $params['order_clause'];
	$this->bolest_obj->limitClause = $params['limit_clause'];
   	   
    return $this->bolest_obj->load(); // ����� array[$bolestID] � ����������� ��� FALSE
   
}
	


	function titleKeyWords()
	{		
		// KEY WORDS - Slagame gi w HEADER-a na vsqka stranica
		if(isset($_REQUEST['bolestID']))
		{
			print get_bolest_nameByBolestID($_REQUEST['bolestID']).' - Заболявания, състояния на духа и тялото, симптоми и начини за лечение, друга полезна информация';
		}
		elseif(isset($_REQUEST['bolest_category']) OR isset($_REQUEST['category']))
		{
			print get_bolest_category(($_REQUEST['bolest_category'] > 0 ? $_REQUEST['bolest_category'] : $_REQUEST['category'])).' - Заболявания, състояния на духа и тялото, симптоми и начини за лечение, друга полезна информация';
		}		
		else 
		{
			print 'Заболявания, състояния на духа и тялото, симптоми и начини за лечение, друга полезна информация';
		}
	
	}
	
	
	
	
	function metaTags()
	{		
		// KEY WORDS - Slagame gi w HEADER-a na vsqka stranica
		if(isset($_REQUEST['bolestID']))
		{
			print get_bolest_tagsByBolestID($_REQUEST['bolestID']);
		}
		
	}
	

	
	
	
	function nextPrevious()
	{
		if(isset($_REQUEST['bolestID']))
		{
			print 'next_previous(\'bolesti\','.$_REQUEST['bolestID'].');';
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