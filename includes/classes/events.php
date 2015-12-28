<?php
class Events {
	
	// the array which will contain all the registered/added events
	var $events = Array();
	
	function & instance(){
		static $instance = NULL;

		if ($instance === NULL){
			$instance = new Events;
		}
		return $instance;
	}
	
	function add($event, $handler, & $object){
		$obj = & Events::instance();

        $page_class = '';
		if (is_object($object)){
			$handler = array(& $object, $handler);
            $page_class = strtolower(get_class($object));
		}

		$obj->events[$event][$page_class] = $handler;
	}

	function remove($event, $handler, & $object){
		$obj = & Events::instance();

		if ( ! isset($obj->events[$event]))
			return;

		if (is_object($object)){
			$handler = array(& $object, $handler);
		}

		foreach ($obj->events[$event] as $key => $function)
		{
			if ($function == $handler)
			{
				unset($obj->events[$event][$key]);
			}
		}

		$log = array_keys($this->events);
	}
	
	/**
	 * @param string event name to be ran
	 * @param array optional assoc array with parameters to be passed to registered functions,
	 *        which they must handle themselves.
	 *        Example: function handler($params)
	 *				   {
	 *						$arg = & $params['arg'];
	 *						$body = & $params['body'];
	 *					}
	 */
	function run($event, & $params){
		$obj = & Events::instance();

		if ( ! isset($obj->events[$event]))
			return FALSE;

		Log::msg("[Event]\t".$event.' has been ran.');
		Log::msg("[Event]\t".'methods to be ran.' .print_r($obj->events[$event], 1));
		Log::msg("[Params]\t".print_r($params, TRUE));

        $pages = Pages::getAllPages();
        foreach($pages as $page) {
            if( isset($obj->events[$event][strtolower($page)]) ) {
                $handler = $obj->events[$event][strtolower($page)];
                $func = is_array($handler) ? get_class($handler[0]).'::'.$handler[1] : $handler;
                Log::msg("[Method]\t".$func.' called.');

                call_user_func($handler, $params);
            }
        }
        

//		foreach ($obj->events[$event] as $key => $handler)
//		{
//			$func = is_array($handler) ? get_class($handler[0]).'::'.$handler[1] : $handler;
//			Log::msg("[Method]\t".$func.' called.');
//
//			call_user_func($handler, $params);
//		}
	}
}
?>
