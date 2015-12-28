/**
* User input management of the players MCV pattern.
*
* @author	Jeroen Wijering
* @version	1.4
**/


import com.jeroenwijering.players.*;
import com.jeroenwijering.utils.Randomizer;


class com.jeroenwijering.players.PlayerController extends AbstractController {


	/** use SharedObject to save current file, item and volume **/
	private var playerSO:SharedObject;
	/** reference to the current volume **/
	private var currentVolume:Number;
	/** Array with all file values **/
	private var fileElements:Object = {
		file:"",
		title:"",
		link:"",
		id:"",
		image:"",
		author:"",
		captions:"",
		category:"",
		start:"",
		type:""
	}
	/** showing the captions (they're off by default) **/
	private var captionsOn:Boolean = false;


	/** Constructor, save arrays and set currentItem. **/
	function PlayerController(car:Object,far:Array) {
		super(car,far);
		configArray["playerclip"].captions._visible = false;
		playerSO = SharedObject.getLocal("com.jeroenwijering.players", "/");
		if(playerSO.data.capon == true) { setCaptions(); }
		if(configArray["fullscreenmode"] == "true" &&
			playerSO.data.item != undefined) {
			currentItem = playerSO.data.item;
		}
	};


	/** Complete the build of the MCV cycle and start flow of events. **/
	public function startMCV(mar:Array) {
		registeredModels = mar;
		sendChange("item",currentItem);
		if(configArray["autostart"] == "false" && 
			fileArray[currentItem]["category"] != "commercial") {
			sendChange("pause",0);
			isPlaying = false;
		} else { 
			sendChange("start",0);
			isPlaying = true;
		}
		if(playerSO.data.volume != undefined && _root.volume == undefined) {
			sendChange("volume",playerSO.data.volume);
			currentVolume = playerSO.data.volume;
		} else {
			sendChange("volume",Number(configArray["volume"]));
			currentVolume = Number(configArray["volume"]);
		}
	};


	/** Check volume percentage and forward to models. **/
	private function setVolume(prm) {
		if (prm < 0 ) { prm = 0; } else if (prm > 100) { prm = 100; }
		if(currentVolume == 0 && prm == 0) { prm = 80; }
		currentVolume = prm;
		playerSO.data.volume = prm;
		playerSO.flush();
		sendChange("volume",prm);
	};


	
	/** Fullscreen switch function. **/
	private function setFullscreen() {
		if(configArray["fullscreenmode"] == "true") {
			configArray["fullscreenmode"] = "false";
		} else {
			configArray["fullscreenmode"] = "true";
		}
		if(Stage["displayState"] == "normal") { 
			Stage["displayState"] = "fullScreen";
		} else if (Stage["displayState"] == "fullScreen") {
			Stage["displayState"] = "normal";
		} else {
			if(configArray["fullscreenmode"] == "false") { 
				getURL(unescape(configArray["fsreturnpage"]));
			} else {
				sendChange("stop");
				playerSO.data.item = currentItem;
				playerSO.data.fsreturnpage = configArray["fsreturnpage"];
				playerSO.data.largecontrols = configArray["largecontrols"];
				for(var elm in fileElements) {
					playerSO.data[elm] = fileArray[currentItem][elm];
				}
				playerSO.data.file = configArray["file"];
				playerSO.flush();
				getURL(unescape(configArray["fullscreenpage"]),
					configArray["linktarget"]);
			}
		}
	};


	/** Captions toggle **/
	private function setCaptions() {
		if(captionsOn == true) {
			captionsOn = false;
			configArray["playerclip"].captions._visible = false;
			trace("captions off");
		} else {
			captionsOn = true;
			configArray["playerclip"].captions._visible = true;
			trace("captions on");
		}
		playerSO.data.capon = captionsOn;
		playerSO.flush();
	};



}