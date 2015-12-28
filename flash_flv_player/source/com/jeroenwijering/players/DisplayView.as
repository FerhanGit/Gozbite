/**
* Display user interface management of the players MCV pattern.
*
* @author	Jeroen Wijering
* @version	1.6
**/


import com.jeroenwijering.players.*;
import com.jeroenwijering.utils.ImageLoader;
import com.jeroenwijering.utils.StringMagic;


class com.jeroenwijering.players.DisplayView extends AbstractView { 


	/** reference to the  imageloader object **/
	private var  imageLoader:ImageLoader;
	/** Reference to the currently active item **/
	private var currentItem;
	/** Reference to the currently active item **/
	private var itemSize:Array = new Array(0,0);
	/** Reference to the currently active item **/
	private var thumbSize:Array = new Array(0,0);
	/** Starting position of the players **/
	private var startPos:Array;


	/** Constructor **/
	function DisplayView(ctr:AbstractController,car:Object,far:Array) { 
		super(ctr,car,far);
		Stage.addListener(this);
		var ref = this;
		var tgt = configArray["playerclip"];
		imageLoader = new ImageLoader(tgt.display.thumb);
		imageLoader.onLoadFinished = function() {
			ref.thumbSize = new Array(this.targetClip._width,
				this.targetClip._height);
			ref.scaleClip(tgt.display.thumb,this.targetClip._width,
				this.targetClip._height);
		}
		startPos = new Array(tgt._x,tgt._y);
		setColorsClicks();
		setDimensions();
	};


	/** Sets up colors and clicks of all display items. **/
	private function setColorsClicks() {
		var ref = this;
		// background
		var tgt = configArray["playerclip"].back;
		tgt.col = new Color(tgt);
		tgt.col.setRGB(configArray["backcolor"]);
		// display items
		var tgt = configArray["playerclip"].display;
		if(configArray["showicons"] == "false") { 
			tgt.playicon._visible = false;
		}
		tgt.activity._visible = false;
		tgt.back.tabEnabled = false;
		if(configArray["linkfromdisplay"] == "true") {
			tgt.playicon._visible = false;
			tgt.back.onRelease = function() { 
				ref.sendEvent("getlink",ref.currentItem);
			};
		} else {
			tgt.back.onRelease = function() { ref.sendEvent("playpause"); };
		}
		if(configArray["logo"] != "undefined") {
			var lll = new ImageLoader(tgt.logo,"none");
			lll.onLoadFinished = function() {
				tgt.logo._x = ref.configArray["displaywidth"] - 
					tgt.logo._width -10;
				tgt.logo._y = ref.configArray["displayheight"] - 
					tgt.logo._height -10;
			};
			lll.loadImage(configArray["logo"]);
			tgt.logo.onRelease = function() { 
				ref.sendEvent("getlink",ref.currentItem);
			};
		}
	};


	/** Sets up dimensions of all controlbar items. **/
	private function setDimensions() {
		var tgt = configArray["playerclip"].back;
		if(configArray["fullscreenmode"] == "true") {
			configArray["playerclip"]._x = configArray["playerclip"]._y = 0;
			tgt._width = Stage.width;
			tgt._height = Stage.height;
		} else {
			configArray["playerclip"]._x = startPos[0];
			configArray["playerclip"]._y = startPos[1];
			tgt._width = configArray["width"];
			tgt._height = configArray["height"];
			if(configArray["displayheight"] >= configArray["height"] - 20 &&
				configArray["displaywidth"] == configArray["width"]) {
				tgt._height--;
			}
		} 
		var tgt = configArray["playerclip"].display;
		scaleClip(tgt.thumb,thumbSize[0],thumbSize[1]);
		scaleClip(tgt.image,itemSize[0],itemSize[1]);
		scaleClip(tgt.video,itemSize[0],itemSize[1]);
		if(configArray["fullscreenmode"] == "true") {
			configArray["playerclip"].displaymask._width = 
				tgt.back._width = Stage.width;
			configArray["playerclip"].displaymask._height = 
				tgt.back._height = Stage.height;
		 } else {
			configArray["playerclip"].displaymask._width = 
				tgt.back._width = configArray["displaywidth"];
			configArray["playerclip"].displaymask._height = 
				tgt.back._height = configArray["displayheight"];
		}
		tgt.playicon._x = tgt.activity._x = Math.round(tgt.back._width/2);
		tgt.playicon._y = tgt.activity._y = Math.round(tgt.back._height/2);
		if(configArray["fullscreenmode"] == "true") {
			tgt.playicon._xscale = tgt.playicon._yscale = 
				tgt.activity._xscale = tgt.activity._yscale = 
				tgt.logo._xscale = tgt.logo._yscale = 200;
			tgt.logo._x = Stage.width - tgt.logo._width - 20;
			tgt.logo._y = Stage.height - tgt.logo._height - 20;
		} else {
			if(configArray["largecontrols"] == "true") {
				tgt.playicon._xscale = tgt.playicon._yscale = 
					tgt.activity._xscale = tgt.activity._yscale = 200;
			} else {
				tgt.playicon._xscale = tgt.playicon._yscale = 
					tgt.activity._xscale = tgt.activity._yscale =
					tgt.logo._xscale = tgt.logo._yscale = 100;
			}
			if(tgt.logo._height > 1) {
				tgt.logo._x= configArray["displaywidth"]-tgt.logo._width -10;
				tgt.logo._y= configArray["displayheight"]-tgt.logo._height-10;
			}
		}
	};


	/** Show and hide the play/pause button and show activity icon **/
	private function setState(stt:Number) {
		var tgt = configArray["playerclip"].display;
		switch(stt) {
			case 0:
				if (configArray["linkfromdisplay"] == "false" && 
					configArray["showicons"] == "true") {
					tgt.playicon._visible = true;
				}
				tgt.activity._visible = false;
				break;
			case 1:
				tgt.playicon._visible = false;
				if (configArray["showicons"] == "true") {
					tgt.activity._visible = true;
				}
				break;
			case 2:
				tgt.playicon._visible = false;
				tgt.activity._visible = false;
				break;
		}
	};


	/** save size information and rescale accordingly **/
	private function setSize(wid:Number,hei:Number) {
		itemSize = new Array (wid,hei);
		var tgt = configArray["playerclip"].display;
		scaleClip(tgt.image,itemSize[0],itemSize[1]);
		scaleClip(tgt.video,itemSize[0],itemSize[1]);
	};


	/** Scale movie according to overstretch setting **/
	private function scaleClip(tgt:MovieClip,wid:Number,hei:Number):Void {
		var tcf = tgt.mc._currentframe;
		tgt.mc.gotoAndStop(1);
		if(configArray["fullscreenmode"] == "true") { 
			var stw:Number = Stage.width;
			var sth:Number = Stage.height;
		} else {
			var stw = configArray["displaywidth"];
			var sth = configArray["displayheight"];
		}
		var xsr:Number = stw/wid;
		var ysr:Number = sth/hei;
		if (xsr < ysr && configArray["overstretch"] == "false" || 
			ysr < xsr && configArray["overstretch"] == "true") { 
			tgt._width = wid*xsr;
			tgt._height = hei*xsr;
		} else if(configArray["overstretch"] == "none") {
			tgt._width = wid;
			tgt._height = hei;
		} else if (configArray["overstretch"] == "fit") {
			tgt._width = stw;
			tgt._height = sth;
		} else { 
			tgt._width = wid*ysr;
			tgt._height = hei*ysr;
		}
		tgt._x = stw/2 - tgt._width/2;
		tgt._y = sth/2 - tgt._height/2;
		tgt.mc.gotoAndPlay(tcf);
	};


	/** Load Thumbnail image if available. **/
	private function setItem(idx:Number) {
		currentItem = idx;
		if(fileArray[idx]["image"] == "undefined") { 
			configArray["playerclip"].display.thumb.clear();
			configArray["playerclip"].display.thumb._visible = false;
		} else {
			imageLoader.loadImage(fileArray[idx]["image"]);
			configArray["playerclip"].display.thumb._visible = true;
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