<?php
////////////////////////////////////////////////////////////////////// 
//
// Class Pages
// Description: Used to retrieve the right page/s
// according to the active ones, the priority and the parametters.
//
// Package: оХБоли.Бг
// Author: Ферхан Исмаилов
// Date : 26.01.2011
//
//////////////////////////////////////////////////////////////////////

require_once 'page.interface.php';
require_once 'page.php';
require_once 'pages.settings.php';

class Pages {
	// holds loaded pages
	var $types = array();
	
	// $_GET param to indetify page

	var $param = 'pg';

	var $site = NULL;
	
	function Pages()
	{
		global $site, $page_names;

		$this->site = & $site;
		
		$this->page_names = $page_names;
		$this->page_key_words = $page_key_words;
		
	}

	function & instance()
	{
		static $instance = NULL;

		if ($instance === NULL)
		{
			$instance = new Pages;
		}

		return $instance;
	}
	
	
	
	/**
	 * Load given page if not loaded.
	 *
	 * @param string page name
	 *
	 * @return class reference to the page object
	 */
	function & loadPage($name)
	{
		$obj = & Pages::instance();
		$not_found = FALSE;
		
		$name = strtolower($name);

		$obj->current_page_name = $name;
		
		if (isset($obj->types[$name]))
		{
			return $obj->types[$name];
		}
		
				
		$path = dirname(__FILE__).'/types/'.$name.'.php';
		if ( ! file_exists($path)) {
			Log::msg('Page '.$name.' file does not exists!');
			return $not_found;
		}

		require_once $path;

		if (checkInterface($name, 'PageInterface', TRUE))
		{
			$class = new $name($obj->site);
			$class->registerEvents();
			$obj->types[$name] = & $class;

			Log::msg('Page '.$name.' loaded.');
			
			return $obj->types[$name];
		} else {
			Log::msg('Interface for page '.$name.' is not valid!');
			
		}
		
	}

	function & loadModule($name,  $prms = array())
	{
		$params = &$prms;
		$obj = & Pages::instance();
		$not_found = FALSE;
		
		$name = strtolower($name);

		$obj->current_module_name = $name;
				
		$path = INCLUDESDIR.'/modules/'.$name.'.php';
		if ( ! file_exists($path)) {
			Log::msg('Module '.$name.' file does not exists!');
			return $not_found;
		}

			return require $path;
			 
			Log::msg('Module '.$name.' loaded.');			
		
		
	}

	
	
	function getAllPages()
	{
		$obj = & Pages::instance();

		return $obj->page_names;
	}
	
	
	function getCurrentPageName()
	{
		$obj = & Pages::instance();

		return $obj->current_page_name;
	}
	
	
	function setPageToLoad()
	{
		$page_to_load = ($_REQUEST['pg']?$_REQUEST['pg']:'home') ; // ��� ���� �� ����� 404.php ��� � ���� ���������� ������ �� ���� ��� HOMEW
		return $page_to_load;
	}
	
	
		
	
}

?>
