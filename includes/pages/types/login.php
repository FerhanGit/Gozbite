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

class LOGIN extends Page
{
	var $site = NULL;
	var $page_name = 'login';

	var $events = array(
		'header' 	=> 'displayHeaderLinks',	
		'menu' 	=> 'displayMainMenu',	
		'main'		=> 'displayMainStuff',
		'right'	=> 'displayRightColumn',
		'footer'	=> 'displayFooter',
		'title_key_words' => 'titleKeyWords',
		'footer_overlay_div' => 'footerOverlayDiv',
	);

	function LOGIN(& $site)
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
		
		if(isset($_REQUEST['insert_comment_btn']))
		{	
			$prms = array('page_name' => Pages::getCurrentPageName());		
			$header_section .= Pages::loadModule('proceed_post_cooments',$prms);	
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


	if(!empty($_REQUEST['forgotten_pass'])) 
	{
	 	$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule('forgotten_pass',$prms);	
	}
	elseif(!empty($_REQUEST['logout']))
	{
		session_start();	
		
		$sql = "DELETE FROM sessions WHERE  session_name='".$_SESSION['valid_user']."'";
		$conn->setSQL($sql);
		$conn->updateDB();
					 

		unset($_SESSION['valid_user']);
		session_destroy();
		$main_section .= "<script>document.location.href='index.php'</script>";

	}
	else
	{
		$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule('login',$prms);	
	}
  

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
		print 'Потребителски Вход в системата';

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