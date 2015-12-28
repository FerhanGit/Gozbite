<?php
/**
 * Ensures all required classes are loaded.
 */
define('CLASSDIR', dirname(__FILE__).'/classes/');
define('PAGESDIR', dirname(__FILE__).'/pages/');
define('INCLUDESDIR', dirname(__FILE__));
define('TOOLS', dirname(__FILE__).'/tools/');
define('MODULES', dirname(__FILE__).'/modules/');
define('ROOT', '../'.dirname(__FILE__));


require_once CLASSDIR."mysqldb.class.php";
require_once CLASSDIR."paging.class.php";   
require_once CLASSDIR.'log.php';
require_once CLASSDIR.'events.php';
require_once CLASSDIR.'site.class.php';

require_once PAGESDIR.'pages.php';
// Add log emails and turn on/off logging
Log::setSubject('[GOI] '.date('d-m-Y H:i:s').' '.$_SERVER['PHP_SELF']);
//Log::addRecipient('floorer@gbg.bg');
//Log::addRecipient('ohboli@ohboli.bg');
