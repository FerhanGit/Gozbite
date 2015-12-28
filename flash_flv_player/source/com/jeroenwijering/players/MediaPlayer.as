/**
* Player that reads all media formats Flash can read.
*
* @author	Jeroen Wijering
* @version	1.7
**/


import com.jeroenwijering.players.*;


class com.jeroenwijering.players.MediaPlayer extends AbstractPlayer { 


	/** Array with all config values **/
	private var configArray:Object = {
		autoscroll:"false",
		autostart:"false",
		backcolor:"0xffffff",
		bufferlength:"5",
		callback:"undefined",
		displayheight:"undefined",
		displaywidth:"undefined",
		enablejs:"false",
		file:"playlist.xml",
		frontcolor:"0x000000",
		fsreturnpage:"undefined",
		fullscreenmode:"false",
		fullscreenpage:"fullscreen.html",
		height:"undefined",
		largecontrols:"false",
		lightcolor:"0x000000",
		linkfromdisplay:"false",
		linktarget:"_self",
		logevents:"undefined",
		logo:"undefined",
		overstretch:"fit",
		playerclip:"undefined",
		repeat:"false",
		rotatetime:"10",
		showdigits:"true",
		showeq:"false",
		showfsbutton:"true",
		showicons:"true",
		shuffle:"true",
		streamscript:"undefined",
		thumbsinplaylist:"false",
		volume:"80",
		width:"undefined"
	}
	/** Accepted types of mediafiles **/
	private var fileTypes:Array = new Array(
		"mp3",
		"flv",
		"rtmp",
		"jpg",
		"png",
		"gif",
		"swf",
		"rbs"
	);


	/** Constructor **/
	public function MediaPlayer(tgt:MovieClip,fil:String) { super(tgt,fil); };


	/** Setup all necessary MCV blocks. **/
	private function setupMCV():Void {
		// set controller
		controller = new PlayerController(configArray,fileArray);
		// set default views
		var dpv = new DisplayView(controller,configArray,fileArray);
		var ipv = new InputView(controller,configArray,fileArray);
		var vws:Array = new Array(dpv,ipv);
		// set optional views
		if(configArray["displayheight"] < configArray["height"]) {
			var cbv = new ControlbarView(controller,configArray,fileArray);
			vws.push(cbv);
		} else {
			configArray["playerclip"].controlbar._visible = false;
		}
		if(configArray["displayheight"] < configArray["height"] - 40 || 
			configArray["displaywidth"] < configArray["width"] - 20) {
			var plv = new PlaylistView(controller,configArray,fileArray);
			vws.push(plv);
		} else {
			configArray["playerclip"].playlist._visible = false; 
		}
		if(configArray["showeq"] == "true") {
			var eqv = new EqualizerView(controller,configArray,fileArray);
			vws.push(eqv);
		} else {
			configArray["playerclip"].equalizer._visible = false;
		}
		if(fileArray[0]["captions"] != undefined) {
			var cpv = new CaptionsView(controller,configArray,fileArray);
			vws.push(cpv);
		} else {
			configArray["playerclip"].captions._visible = false;
		}
		if(configArray["enablejs"] == "true") {
			var jsv = new JavascriptView(controller,configArray,fileArray);
			vws.push(jsv);
		}
		if(configArray["callback"] != "undefined") {
			var cav = new CallbackView(controller,configArray,fileArray);
			vws.push(cav);
		}
		// set models
		var mp3 = new MP3Model(vws,controller,configArray,fileArray);
		var flv = new FLVModel(vws,controller,configArray,fileArray,
			configArray["playerclip"].display.video);
		var img = new ImageModel(vws,controller,configArray,fileArray,
			configArray["playerclip"].display.image);
		var mds:Array = new Array(mp3,flv,img);
		// start mcv cycle
		controller.startMCV(mds);
	};


}