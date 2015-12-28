<?php
/**
 * Abstract class to provide un/register of promotion events.
 * $events array contains key(event name) and value(the function attached to the event) pairs.
 */
abstract class Page {
	var $events = array();

	/**
	 * if the promo has some specific
	 * conditions to be active
	 * @return boolean
	*/
	abstract function isActive();
	
	function registerEvents()
	{
		foreach ($this->events as $event => $handler)
		{
			Events::add($event, $handler, $this);
		}
	}
	
	function unregisterEvents()
	{
		foreach ($this->events as $event => $handler)
		{
			Events::remove($event, $handler, $this);
		}
	}
}
