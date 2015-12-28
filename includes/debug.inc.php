<?
//////////////////////////////////////////////////////////////////////////////////////////////////////
// Copyright (c) 2004-2007 Gameloft.com
//
// Debug functions
// Version 3.0.0
// Description: Used for ease of the debug / Log process. Stores all data in a log and sends it to an address
//
// Generic Site By: Antoni Stavrev <antoni.stavrev@gameloft.com>
// Package: %%package%%
// Author: %%author%%
// Owner: %%owner%%
// Modifications: %%modifs%%
//
//////////////////////////////////////////////////////////////////////////////////////////////////////

$SINGLE_RUN_DEBUG_LOG = array();

//// Stores single line in the debug log for a single run
function debug_log($str = '', $location = '')
{
	global $SINGLE_RUN_DEBUG_LOG;
	if ($location != ''){
		$SINGLE_RUN_DEBUG_LOG[] = $str.' (on line '.$location.')';
	}else{
		$SINGLE_RUN_DEBUG_LOG[] = $str;
	}
}

// Sends mail with the whole log
function debug_mail($mail_address = '')
{
	// send mail to owner mail
	global $SINGLE_RUN_DEBUG_LOG;
	global $settings;
	
	if ($mail_address == ''){
		// set the owner email address
		$mail_address = $settings['owner'];
	}
	
	// send the mail with the log
	if(!empty($mail_address))
	{
		mail($mail_address, $_SERVER['PHP_SELF'], implode("\n", $SINGLE_RUN_DEBUG_LOG));
	}
}

?>