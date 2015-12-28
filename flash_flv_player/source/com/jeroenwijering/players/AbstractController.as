/**
* Abstract controller class of the MCV pattern, extended by all controlllers.
*
* @author	Jeroen Wijering
* @version	1.5
**/


import com.jeroenwijering.players.*;
import com.jeroenwijering.utils.Randomizer;


class com.jeroenwijering.players.AbstractController {


	/** Randomizer instance **/
	private var  randomizer:Randomizer;
	/** array with all registered models **/
	private var registeredModels:Array;
	/** reference to the config array **/
	private var configArray:Object;
	/** reference to the file array **/
	private var fileArray:Array;
	/** Current item **/
	private var currentItem:Number;
	/** Current item **/
	private var isPlaying:Boolean;
	/** Number of items played; used to track play-once repeat**/
	private var itemsPlayed:Number = 0;
	/** LoadVars object for event logging **/
	private var logObject:LoadVars;


	/**
	* Constructor, save arrays and set currentItem.
	*
	* @param car	reference to the config array
	* @param far	reference to the file array
	**/
	function AbstractController(car:Object,far:Array) {
		configArray = car;
		fileArray = far;
		if(configArray["shuffle"] == "true") {
			randomizer = new Randomizer(fileArray);
			currentItem = randomizer.pick();
		} else {
			currentItem = 0;
		}
		if(configArray["logevents"] != "undefined") { 
			logObject = new LoadVars();
		}
	};


	/**
	* Complete the build of the MCV cycle and start flow of events.
	*
	* @param mar	All models the controller should send events to.
	**/
	public function startMCV(mar:Array) {};


	/**
	* Receive events from the views.
	* 
	* @param typ	Event type.
	* @param prm	Parameter value.
	**/
	public function getEvent(typ:String,prm:Number):Void { 
		if( fileArray[currentItem]["category"] == "commercial" && 
			typ != "volume" && typ != "getlink" && typ != "complete") {
			return;
		}
		trace("controller: "+typ+": "+prm);
		if(configArray["logevents"] != "undefined") { logControls(typ,prm); }
		switch(typ) {
			case "playpause": 
				setPlaypause();
				break;
			case "prev":
				setPrev();
				break;
			case "next":
				setNext();
				break;
			case "stop":
				setStop();
				break;
			case "scrub":
				setScrub(prm);
				break;
			case "volume":
				setVolume(prm);
				break;
			case "playitem":
				setPlayitem(prm);
				break;
			case "getlink":
				setGetlink(prm);
				break;
			case "fullscreen":
				setFullscreen();
				break;
			case "complete":
				setComplete();
				break;
			case "captions":
				setCaptions();
				break;
			default:
				trace("controller: incompatible event received");
				break;
		}
	};


	/** playPause switch **/
	private  function setPlaypause() {
		if(isPlaying == true) {
			isPlaying = false;
			sendChange("pause");
		} else { 
			isPlaying = true;
			sendChange("start");
		}
	};


	/** Play previous item. **/
	private  function setPrev() {
		if(currentItem == 0) {
			var i:Number = fileArray.length - 1;
		} else { 
			var i:Number = currentItem-1;
		}
		setPlayitem(i);
	};


	/** Play next item. **/
	private function setNext() {
		if(currentItem == fileArray.length - 1) {
			var i:Number = 0;
		} else { 
			var i:Number = currentItem+1;
		}
		setPlayitem(i);
	};


	/** Stop and clear item. **/
	private function setStop() { 
		sendChange("pause",0);
		sendChange("stop"); 
		sendChange("item",currentItem);
		isPlaying = false;
	};


	/** Check scrub percentage and forward to model. **/
	private function setScrub(prm) { 
		isPlaying == true ? sendChange("start",prm): sendChange("pause",prm);
	};


	/** Volume event handler **/
	private function setVolume(prm:Number) {};


	/** Play a new item. **/
	private function setPlayitem(itm:Number) {
		if(itm != currentItem) {
			sendChange("stop");
			itm > fileArray.length-1 ? itm = fileArray.length-1: null;
			currentItem = itm;
			sendChange("item",itm);
		}
		if(fileArray[itm]["start"] == undefined) {
			sendChange("start",0);
		} else {
			sendChange("start",fileArray[itm]["start"]);
		}
		isPlaying = true;
	};


	/** Get url from an item if link exists, else playpause. **/
	private function setGetlink(idx:Number) {
		if(fileArray[idx]["link"] == undefined) { 
			setPlaypause();
		} else {
			getURL(fileArray[idx]["link"],configArray["linktarget"]);
		}
	};


	/** Switch fullscreen mode **/
	private function setFullscreen() {};


	/** Determine what to do if an item is completed. **/
	private function setComplete() { 
		itemsPlayed++;
		if(configArray["repeat"]=="false" || (configArray["repeat"]=="list"
			&& itemsPlayed==fileArray.length)) {
			sendChange("pause",0);
			isPlaying = false;
			itemsPlayed = 0;
		} else {
			if(configArray["shuffle"] == "true") {
				var i:Number = randomizer.pick();
			} else if(currentItem == fileArray.length - 1) {
				var i:Number = 0;
			} else { 
				var i:Number = currentItem+1;
			}
			setPlayitem(i);
		}
	};


	/** Switch captions on and off **/
	private function setCaptions() {};

	/** Sending changes to all registered models. **/
	private function sendChange(typ:String,prm:Number):Void {
		for(var i=0; i<registeredModels.length; i++) {
			registeredModels[i].getChange(typ,prm);
		}
	};


	/** logging all button presses to a certain callback **/
	private function logControls(typ:String,prm:Number) {
		logObject.file = fileArray[currentItem]["file"];
		logObject.id = fileArray[currentItem]["id"];
		logObject.type = typ;
		logObject.parameter = prm;
		logObject.sendAndLoad(configArray["logevents"],logObject,"POST");
	};
	

}