/**
* Manages startup and overall control of the Flash Image Rotator
*
* @author	Jeroen Wijering
* @version	1.3
**/


import com.jeroenwijering.players.*;


class com.jeroenwijering.players.ImageRotator extends AbstractPlayer { 


	/** Array with all config values **/
	private var configArray:Object = {
		autostart:"true",
		backcolor:"0x000000",
		callback:"undefined",
		enablejs:"false",
		file:"playlist.xml",
		frontcolor:"0xffffff",
		height:"undefined",
		lightcolor:"0x990000",
		linkfromdisplay:"true",
		linktarget:"_self",
		logo:"undefined",
		overstretch:"false",
		playerclip:"undefined",
		repeat:"true",
		rotatetime:"5",
		showicons:"false",
		shownavigation:"false",
		shuffle:"true",
		transition:"fade",
		width:"undefined"
	}
	/** Accepted types of mediafiles **/
	private var fileTypes:Array = new Array("jpg","png","gif");


	/** Constructor **/
	function ImageRotator(tgt:MovieClip,fil:String) { super(tgt,fil); };


	/** Setup all necessary MCV blocks. **/
	private function setupMCV():Void {
		// set controller
		controller = new RotatorController(configArray,fileArray);
		// set views
		var rov = new RotatorView(controller,configArray,fileArray);
		var ipv = new InputView(controller,configArray,fileArray);
		var vws:Array = new Array(rov,ipv);
		if(configArray["enablejs"] == "true") {
			var jsv = new JavascriptView(controller,configArray,fileArray);
			vws.push(jsv);
		}
		if(configArray["callback"] != "undefined") {
			var cbv = new CallbackView(controller,configArray,fileArray);
			vws.push(cbv);
		}
		// set models
		configArray["displayheight"] = configArray["height"];
		var im1 = new ImageModel(vws,controller,configArray,
			fileArray,configArray["playerclip"].img1,true);
		var im2 = new ImageModel(vws,controller,configArray,
			fileArray,configArray["playerclip"].img2,true);
		var mds:Array = new Array(im1,im2);
		// start mcv cycle
		controller.startMCV(mds);
	};


}