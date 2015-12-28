/**
* Rotator user interface View of the MCV cycle.
*
* @author	Jeroen Wijering
* @version	1.4
**/


import com.jeroenwijering.players.*;


class com.jeroenwijering.players.RotatorView extends AbstractView { 


	/** full width of the scrubbars **/
	private var currentItem:Number;
	/** clip that's currently active **/
	private var upClip:MovieClip;
	/** clip that's currently inactive **/
	private var downClip:MovieClip;
	/** boolean for whether to use the title display **/ 
	private var useTitle:Boolean;
	/** boolean to see if the transition is done **/
	private var transitionDone:Boolean = false;
	/** boolean to detect first run **/ 
	private var firstRun:Boolean = true;
	/** array with all transitions **/ 
	private var allTransitions:Array = new Array(
		"fade",
		"bgfade",
		"blocks",
		"circles",
		"fluids",
		"lines"
	);


	/** Constructor **/
	function RotatorView(ctr:AbstractController,car:Object,far:Array) { 
		super(ctr,car,far);
		setColorsClicks();
	};


	/**
	* Sets up visibility, sizes and colors of all display and navigation items
	* (just an extremely long iteration of all controlbar items)
	**/
	private function setColorsClicks() {
		var ref = this;
		var tgt:MovieClip = configArray["playerclip"];
		tgt.button._width = tgt.img1.bg._width =
			tgt.img2.bg._width = configArray["width"];
		tgt.button._height = tgt.img1.bg._height =
			tgt.img2.bg._height = configArray["height"];
		tgt.img1.col = new Color(tgt.img1.bg);
		tgt.img1.col.setRGB(configArray["backcolor"]);
		tgt.img2.col = new Color(tgt.img2.bg);
		tgt.img2.col.setRGB(configArray["backcolor"]);
		if(configArray["linkfromdisplay"] == "true") {
			tgt.button.onPress = function() { 
				ref.sendEvent("getlink",ref.currentItem); 
			};
			tgt.playicon._visible = false;
		} else {
			tgt.button.onPress = function() { ref.sendEvent("next"); };
		}
		tgt.img1.swapDepths(1);
		tgt.img2.swapDepths(2);
		tgt.playicon.swapDepths(4);
		tgt.activity.swapDepths(5);
		tgt.navigation.swapDepths(6);
		tgt.playicon._x=tgt.activity._x = Math.round(configArray["width"]/2);
		tgt.playicon._y=tgt.activity._y = Math.round(configArray["height"]/2);
		var tgt:MovieClip = configArray["playerclip"].navigation;
		if (configArray["shownavigation"] == "true") {
			tgt._y = configArray["height"] - 40;
			tgt._x = configArray["width"]/2 - 50;
			tgt.prevBtn.col1 = new Color(tgt.prevBtn.bck);
			tgt.prevBtn.col1.setRGB(configArray["backcolor"]);
			tgt.prevBtn.col2 = new Color(tgt.prevBtn.icn);
			tgt.prevBtn.col2.setRGB(configArray["frontcolor"]);
			tgt.itmBtn.col1 = new Color(tgt.itmBtn.bck);
			tgt.itmBtn.col1.setRGB(configArray["backcolor"]);
			tgt.itmBtn.txt.textColor = configArray["frontcolor"];
			tgt.nextBtn.col1 = new Color(tgt.nextBtn.bck);
			tgt.nextBtn.col1.setRGB(configArray["backcolor"]);
			tgt.nextBtn.col2 = new Color(tgt.nextBtn.icn);
			tgt.nextBtn.col2.setRGB(configArray["frontcolor"]);
			tgt.prevBtn.onRollOver = tgt.nextBtn.onRollOver = function() { 
				this.col2.setRGB(ref.configArray["lightcolor"]);
			};
			tgt.prevBtn.onRollOut = tgt.nextBtn.onRollOut = function() { 
				this.col2.setRGB(ref.configArray["frontcolor"]);
			};
			tgt.itmBtn.onRollOver = function() {
				this.txt.textColor = ref.configArray["lightcolor"];
			};
			tgt.itmBtn.onRollOut = function() {
				this.txt.textColor = ref.configArray["frontcolor"];
			};
			tgt.prevBtn.onPress = function() { 
				ref.sendEvent("prev");
				this.col2.setRGB(ref.configArray["frontcolor"]);
			};
			tgt.itmBtn.onPress = function() { ref.sendEvent("playpause"); };
			tgt.nextBtn.onPress = function() { 
				ref.sendEvent("next");
				this.col2.setRGB(ref.configArray["frontcolor"]);
			};
			// set sizes, colors and buttons for image title
			if(fileArray[0]["title"] == undefined) {
				useTitle = false; 
				tgt.titleBtn._visible = false;
			} else {
				useTitle = true;
				tgt.titleBtn._x = 74;
				tgt.titleBtn.col1 = new Color(tgt.titleBtn.left);
				tgt.titleBtn.col1.setRGB(configArray["backcolor"]);
				tgt.titleBtn.col2 = new Color(tgt.titleBtn.mid);
				tgt.titleBtn.col2.setRGB(configArray["backcolor"]);
				tgt.titleBtn.col3 = new Color(tgt.titleBtn.right);
				tgt.titleBtn.col3.setRGB(configArray["backcolor"]);
				tgt.titleBtn.txt.autoSize = true;
				tgt.titleBtn.txt.textColor = configArray["frontcolor"];
				if(fileArray[0]["link"] != undefined) {
					tgt.titleBtn.onRollOver = function() {
						this.txt.textColor = ref.configArray["lightcolor"];
					};
					tgt.titleBtn.onRollOut = function() {
						this.txt.textColor = ref.configArray["frontcolor"];
					};
					tgt.titleBtn.onPress = function() {
						ref.sendEvent("getlink",ref.currentItem);
					};
				};
			}
		} else {
			tgt._visible = false;
		}
	};


	/** New item: switch clips and ready transition **/
	private function setItem(pr1) {
		currentItem = pr1;
		transitionDone = false;
		var tgt = configArray["playerclip"];
		tgt.navigation.itmBtn.txt.text=(currentItem+1)+" / "+fileArray.length;
		useTitle == true ? setTitle(): null;
		tgt.img1.swapDepths(tgt.img2);
		downClip = upClip;
		if (upClip == tgt.img1) {
			upClip = tgt.img2;
		} else {
			upClip = tgt.img1;
		}
	};


	/** Set new title in navigation bar. **/
	private function setTitle() {
		var tgt = configArray["playerclip"].navigation;
		tgt.titleBtn.txt.text = fileArray[currentItem]["title"];
		var len:Number = Math.ceil(tgt.titleBtn.txt._width);
		tgt.titleBtn.mid._width = len + 16;
		tgt.titleBtn.right._x = len + 20;
		tgt.nextBtn._x = len + 95;
		tgt._x = Math.round(configArray["width"]/2 - tgt._width/2);
	};


	/** State switch; start the transition **/
	private function setState(stt:Number) {
		switch(stt) {
			case 0:
				if(configArray["showicons"] == "true") {
					configArray["playerclip"].playicon._visible = true;
				}
				configArray["playerclip"].activity._visible = false;
				break;
			case 1:
				configArray["playerclip"].playicon._visible = false;
				if(configArray["showicons"] == "true") {
					configArray["playerclip"].activity._visible = true;
				}
				break;
			case 2:
				configArray["playerclip"].playicon._visible = false;
				configArray["playerclip"].activity._visible = false;
				transitionDone == false ? doTransition(): null;
				break;
		}
	};


	/** Start a transition **/
	private function doTransition() {
		transitionDone = true;
		if(firstRun == true) {
			configArray["playerclip"].img1._alpha = 100;
			configArray["playerclip"].img2._alpha = 0;
			firstRun = false;
		} else {
			var trs = configArray["transition"];
			if(trs == "random") {
				trs = allTransitions[random(allTransitions.length)];
			}
			switch (trs) {
				case "fade":
					doFade();
					break;
				case "bgfade":
					doBGFade();
					break;
				case "blocks":
					doBlocks();
					break;
				case "circles":
					doCircles();
					break;
				case "fluids":
					doFluids();
					break;
				case "lines":
					doLines();
					break;
				default:
					doFade();
					break;
			}
		}
	};


	/** Function for the fade transition **/
	private function doFade() {
		upClip.ref = this;
		upClip._alpha = 0;
		upClip.onEnterFrame = function() {
			this._alpha +=5;
			if(this._alpha >= 100) {
				delete this.onEnterFrame;
				this.ref.downClip._alpha = 0;
			}
		};
	};


	/** Function for the bgfade transition **/
	private function doBGFade() {
		downClip.ref = upClip.ref = this;
		downClip.onEnterFrame = function() {
			this._alpha -=5;
			if(this._alpha <= 0) {
				delete this.onEnterFrame;
				this.ref.upClip.onEnterFrame = function() {
					if(this._alpha >= 100) {
						delete this.onEnterFrame;
					} else {
						this._alpha +=5;
					}
				};
			}
		};
	};


	/** Function for the circles transition **/
	private function doCircles() {
		upClip._alpha = 100;
		configArray["playerclip"].attachMovie("circlesMask","mask",3);
		var msk:MovieClip = configArray["playerclip"].mask;
		upClip.setMask(msk);
		if (configArray["width"] > configArray["height"]) {
			msk._width = msk._height = configArray["width"];
		} else {
			msk._width = msk._height = configArray["height"];
		}
		msk._x = configArray["width"]/2;
		msk._y = configArray["height"]/2;
		playClip(msk,10);
	};


	/** Function for the blocks transition **/
	private function doBlocks() {
		upClip._alpha = 100;
		configArray["playerclip"].attachMovie("blocksMask","mask",3);
		var msk:MovieClip = configArray["playerclip"].mask;
		if (configArray["width"] > configArray["height"]) {
			msk._width = msk._height = configArray["width"];
		} else {
			msk._width = msk._height = configArray["height"];
		}
		msk._rotation = random(4)*90;
		msk._rotation == 90 ? msk._x = configArray["width"]: null;
		msk._rotation == 180 ? msk._x = configArray["width"]: null;
		msk._rotation == 180 ? msk._y = configArray["height"]: null;
		msk._rotation == -90 ? msk._y = configArray["height"]: null;
		upClip.setMask(msk);
		playClip(msk);
	}; 


	/** Function for the fluids transition **/
	private function doFluids() {
		upClip._alpha = 100;
		configArray["playerclip"].attachMovie("fluidsMask","mask",3);
		var msk:MovieClip = configArray["playerclip"].mask;
		upClip.setMask(msk);
		msk._width = configArray["width"];
		msk._height = configArray["height"];
		playClip(msk);
	};


	/** Function for the lines transition **/
	private function doLines() {
		upClip._alpha = 100;
		configArray["playerclip"].attachMovie("linesMask","mask",3);
		var msk:MovieClip = configArray["playerclip"].mask;
		upClip.setMask(msk);
		msk._width = configArray["width"];
		msk._height = configArray["height"];
		playClip(msk);
	};


	/** Play a specific Movieclip and remove it once it's finished **/
	private function playClip(tgt:MovieClip,rot:Number) {
		tgt.ref = this;
		tgt.onEnterFrame = function() {
			nextFrame();
			rot == undefined ? null: this._rotation +=rot;
			if(this._currentframe  == this._totalframes) {
				this.ref.downClip._alpha = 0;
				this.clear();
				this.unloadMovie();
				this.removeMovieClip();
			}
		};
	};


}