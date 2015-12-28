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
 class HOME extends Page
{
	var $site = NULL;
	var $page_name = 'home';
	var $post_obj = NULL;
		
	var $events = array(
		'header' 	=> 'displayHeaderLinks',	
		'menu' 	=> 'displayMainMenu',	
		'main'		=> 'displayMainStuff',
		'right'	=> 'displayRightColumn',
		'footer'	=> 'displayFooter',
		'title_key_words' => 'titleKeyWords',
		'footer_overlay_div' => 'footerOverlayDiv',
	);

	function HOME(& $site)
	{		
		global $conn;
		$this->site = & $site;	
		require_once CLASSDIR."Post.class.php";
		$this->post_obj	= new Post($conn);	
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
	
	$main_section .= Pages::loadModule('home_page_lilavo',$prms);
	$main_section .= Pages::loadModule('most_populars',$prms);
	
	$main_section .= Pages::loadModule('specialitet',$prms);
	
	
	$main_section .= '<table><tr><td valign="top">';		
		$main_section .= Pages::loadModule('bolest_simptoms_quick_search',$prms);		
	$main_section .= '</td><td style="width:40px;"></td><td valign="top">';
		$main_section .= Pages::loadModule('relax',$prms);		
	$main_section .= '</td></tr></table>';

	$main_section .= Pages::loadModule('vips_main',$prms);		
	
  
}
	
	
function displayRightColumn($params)
{
	global $conn;
	$right_section = &$params['right_section'];
	$prms = array('page_name' => Pages::getCurrentPageName());
	
	$right_section .= Pages::loadModule('register_button',$prms);	
	$right_section .= Pages::loadModule('survey',$prms);	
	
    $right_section .= Pages::loadModule('bulletin',$prms);	
		
	$right_section .= Pages::loadModule('locations/locations_intro',$prms);	

	$right_section .= Pages::loadModule('fb_fun_box',$prms);	
	$right_section .= Pages::loadModule('fb_tw',$prms);	
	$right_section .= Pages::loadModule('na_focus',$prms);	
	$right_section .= Pages::loadModule('baner_300_250',$prms);	
	$right_section .= Pages::loadModule('aphorisms_button',$prms);	
	
	
	
	$right_section .= Pages::loadModule('pr_stuff',$prms);	
	/*
	$right_section .= '<ul class="TwoHalf">';
		$right_section .= Pages::loadModule('baner_120_240',$prms);	
		$right_section .= Pages::loadModule('archive',$prms);	
	$right_section .='</ul>';    		
	*/
	  	
	$right_section .= Pages::loadModule('fb_activity',$prms);			
    
    $right_section .= '<ul class="TwoHalf">';
		$right_section .= Pages::loadModule('googleAdsenseVertical',$prms);		
		$right_section .= Pages::loadModule('archive_and_baner_120_240',$prms);	
	$right_section .='</ul>';
	
    $right_section .= Pages::loadModule('googleAdsense_300x250px',$prms);		
	
}
	

	
	
	
	function displayFooter($params)
	{
		global $conn;
		$footer_section = &$params['footer_section'];
		$prms = array('page_name' => Pages::getCurrentPageName());
	
		$footer_section .= Pages::loadModule('footer_links',$prms);	
        //$footer_section .= Pages::loadModule('googleAdsenseFooter_728_90',$prms);	
	}
	
	
	
	function getItemsList($params)
	{		
		$this->post_obj->whereClause = $params['where_clause'];
		$this->post_obj->orderClause = $params['order_clause'];
		$this->post_obj->limitClause = $params['limit_clause'];
	   	   
	    return $this->post_obj->load(); // ����� array[$postID] � ����������� ��� FALSE
	   
	}
	


	function titleKeyWords()
	{		
		// KEY WORDS - Slagame gi w HEADER-a na vsqka stranica
		print 'Животът е сладък! Вкусни готварски рецепти, коктейли, алкохолни и безалкохолни, шейкове, сиропи, нектари, авторски статии, интервюта и множество развлекателни секции - богат снимков материал, новини, описания на храни, витамини и минерали, плодове и зеленчуци, каталог от сладкарници, ресторанти, пицарии, магазини, вносители на хранителни продукти и др.';

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