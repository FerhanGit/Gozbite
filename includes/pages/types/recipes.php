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
class RECIPES extends Page
{
	var $site = NULL;
	var $page_name = 'recipes';
	var $recipe_obj = NULL;

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

	function RECIPES(& $site)
	{	
		global $conn;
		$this->site = & $site;	
		require_once CLASSDIR."Recipe.class.php";
		$this->recipe_obj	= new Recipe($conn);
	
		
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
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/recipes_main_edit',$prms);	
	}
	else 
	{
		if(!isset($_REQUEST['category']) && !isset($_REQUEST['recipe_category']) && !isset($_REQUEST['info']) && (!isset($_REQUEST['search']) && !isset($_REQUEST['search_btn'])) && isset($_REQUEST['recipeID']) && $_REQUEST['recipeID'] > 0)
		{	
			$prms = array('page_name' => Pages::getCurrentPageName());		
			$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/recipe_big',$prms);	
		}	
		elseif(!isset($_REQUEST['specialiteti']) && !isset($_REQUEST['tag']) && !isset($_REQUEST['title']) && !isset($_REQUEST['category']) && !isset($_REQUEST['recipe_category']) && !isset($_REQUEST['info']) && !isset($_REQUEST['page']) && (!isset($_REQUEST['search']) && !isset($_REQUEST['search_btn'])))
		{	
			$prms = array('page_name' => Pages::getCurrentPageName());		
			$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/recipes_main',$prms);	
		}
	 
		$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/recipes_search',$prms);
	

	}
	
	if(!isset($_REQUEST['edit_btn']) && !isset($_REQUEST['insert_btn']))
	{
		$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/recipes_listing',$prms);	
	}	
	
}
	

function displayRightColumn($params)
{
	global $conn;
	$right_section = &$params['right_section'];
	$prms = array('page_name' => Pages::getCurrentPageName());
	
	if(basename($GLOBALS['_SERVER']['SCRIPT_NAME']) == 'edit.php')
	{
		$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/insert_edit_recipe',$prms);	
	}
	
	$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/insert_recipe_button',$prms);	
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
	$this->recipe_obj->whereClause = $params['where_clause'];
	$this->recipe_obj->orderClause = $params['order_clause'];
	$this->recipe_obj->limitClause = $params['limit_clause'];
   	   
    return $this->recipe_obj->load(); // ����� array[$recipeID] � ����������� ��� FALSE
   
}
	



	function titleKeyWords()
	{		
		// KEY WORDS - Slagame gi w HEADER-a na vsqka stranica
		if(isset($_REQUEST['recipeID']))
		{
			print 'Готварски рецепти - '.get_recipe_nameByRecipeID($_REQUEST['recipeID']).' - специалитет, десерт, торта ,сладки, месо, пица, плодове и зеленчуци и още';
		}
		elseif(isset($_REQUEST['recipe_category']) OR isset($_REQUEST['category']))
		{
			print 'Готварски рецепти - '.get_recipe_category(($_REQUEST['recipe_category'] > 0 ? $_REQUEST['recipe_category'] : $_REQUEST['category'])).' - специалитет, десерт, торта ,сладки, месо, пица, плодове и зеленчуци и още';
		}		
		else 
		{
			print 'Готварски рецепти, специалитет, десерт, торта ,сладки, месо, пица, плодове и зеленчуци и още';
		}
	
	}
	
	
	
	
	
	function metaTags()
	{		
		// KEY WORDS - Slagame gi w HEADER-a na vsqka stranica
		if(isset($_REQUEST['recipeID']))
		{
			print get_recipe_tagsByRecipeID($_REQUEST['recipeID']);
		}
		
	}

	
	function nextPrevious()
	{		
		if(isset($_REQUEST['recipeID']))
		{
			print 'next_previous(\'recipes\','.$_REQUEST['recipeID'].');';
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