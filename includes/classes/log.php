<?php
/**
 * Simple logging class.
 * Used to send debugging data.
 */
class Log {
	var $data = array();
	var $mails = array();
	var $subject = '[LOG INFO]';

	var $log = TRUE;

	function Log()
	{
		register_shutdown_function(array(& $this, 'send'));
	}

    public static function &instance()
	{
		static $instance = NULL;

		if ($instance === NULL)
		{
			$instance = new Log;
		}

		return $instance;
	}

	/**
	 * @param string message to be logged
	 * @param bool force message logging, this way you can filter messages even you have logging disabled.
	 */
	public static function msg($message, $force = FALSE)
	{
		$obj = & Log::instance();

		if ( ! $obj->log AND ! $force)
			return;

		if (is_array($message))
		{
			$obj->data = array_merge($obj->data, $message);
		}
		else
		{
			$obj->data[] = $message;
		}
	}

    public static function addRecipient($mail)
	{
		$obj = & Log::instance();

		if (is_array($mail))
		{
			$obj->mails = array_merge($obj->mails, $mail);
		}
		else
		{
			$obj->mails[] = $mail;
		}
	}

    public static function enable()
	{
		$obj = & Log::instance();

		$obj->log = TRUE;
	}

    public static function disable()
	{
		$obj = & Log::instance();

		$obj->log = FALSE;
	}

    public static function setSubject($subject)
	{
		$obj = & Log::instance();

		$obj->subject = $subject;
	}

    public static function send()
	{
		$obj = & Log::instance();

		// Don't send empty data. When logging is disable, no data is collected.
		if (empty($obj->data))
			return;
		
		$obj->data[] = "SERVER: ".print_r($_SERVER, 1);
		$obj->data[] = "REQUEST: ".print_r($_REQUEST, 1);
		
		$recipients = implode(', ', $obj->mails);
		$subject = $obj->subject;
		$body = implode("\n", $obj->data);
		
		if(!empty($recipients))
		{
			if (function_exists('gmail'))
			{
				gmail($recipients, $subject, $body);
			}
			else
			{
				mail($recipients, $subject, $body);
			}
		}
	}
}
