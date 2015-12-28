/**
* Captions display management of the players MCV pattern.
*
* @author	Jeroen Wijering
* @version	1.1
**/


import com.jeroenwijering.players.*;
import com.jeroenwijering.utils.CaptionsParser;
import flash.filters.DropShadowFilter;


class com.jeroenwijering.players.CaptionsView extends AbstractView { 


	/** The current volume **/
	private var parser:CaptionsParser;
	/** The captions array **/
	private var captions:Array;
	/** The current elapsed time **/
	private var currentTime:Number;
	/** The captions textfield **/
	private var clip:MovieClip;
	/** Reference to the dropshadowfilter**/
	private var filter:DropShadowFilter;

	/** Constructor, loads caption file. **/
	function CaptionsView(ctr:AbstractController,car:Object,far:Array) {
		super(ctr,car,far);
		var ref = this;
		Stage.addListener(this);
		parser = new CaptionsParser();
		parser.onParseComplete = function() {
			this.parseArray.sortOn("bgn",Array.NUMERIC);
			ref.captions = this.parseArray;
			delete this;
		}
		clip = configArray["playerclip"].captions;
		setDimensions();
	};


	/** onLoad override, sets capture sizes. **/
	private function setDimensions() {
		clip.txt.autoSize = "center";
		clip.bck._height = clip.txt._height + 10;
		if(configArray["fullscreenmode"] == "true") {
			clip._width = Stage.width;
			clip._yscale= clip._xscale;
			clip._y = Stage.height - clip._height;
		} else {
			clip._width = configArray["displaywidth"];
			clip._yscale = clip._xscale;
			clip._y = configArray["displayheight"] - clip._height;
		}
		var blr = 2 + Math.round(clip._yscale/100);
		filter = new DropShadowFilter(0,0,0x000000,1,blr,blr,50,2);
		clip.filters = new Array(filter);
	}


	/** parse a new captions file every time an item is set **/
	private function setItem(idx:Number) {
		parser.parse(fileArray[idx]["captions"]);
	};


	/** Check elapsed time, evaluate captions every second. **/
	private function setTime(elp:Number,rem:Number) {
		if(Math.round(elp) != currentTime) {
			currentTime = Math.round(elp);
			setCaption();
		}
	};


	/** Check if a new caption should be displayed **/
	private function setCaption() {
		var nxt:Number = captions.length;
		for (var i=0; i<captions.length; i++) {
			if(captions[i]["bgn"] > currentTime) {
				nxt = i;
				break;
			}
		}
		if(captions[nxt-1]["bgn"] + captions[nxt-1]["dur"] > currentTime) {
			clip.txt.htmlText = captions[nxt-1]["txt"];
			clip.bck._height = clip.txt._height + 15;
			if(configArray["fullscreenmode"] == "true") {
				clip._y = Stage.height - clip._height;
			} else {
				clip._y = configArray["displayheight"] - clip._height;
			}
		} else {
			clip.txt.htmlText = "";
		}
	};


	/** OnResize Handler: catches stage resizing **/
	public function onResize() { setDimensions(); };


	/** Catches fullscreen escape  **/
	public function onFullScreen(fs:Boolean) { 
		if(fs == false) {
			configArray["fullscreenmode"] = "false"; 
			setDimensions(); }
	};


}