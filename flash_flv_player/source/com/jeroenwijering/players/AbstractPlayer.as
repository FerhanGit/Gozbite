/**
* Abstract player class, extended by all other players.
* Class loads config and file XML's and sets up MCV triangle.
*
* @author	Jeroen Wijering
* @version	1.7
**/


import com.jeroenwijering.players.*;
import com.jeroenwijering.utils.FeedParser;


class com.jeroenwijering.players.AbstractPlayer { 


	/** Array with all config values **/
	private var configArray:Object = {
		autoscroll:"",
		autostart:"",
		backcolor:"",
		bufferlength:"",
		callback:"",
		displayheight:"",
		displaywidth:"",
		enablejs:"",
		file:"",
		frontcolor:"",
		fsreturnpage:"",
		fullscreenmode:"",
		fullscreenpage:"",
		height:"",
		largecontrols:"",
		lightcolor:"",
		linkfromdisplay:"",
		linktarget:"",
		logevents:"",
		logo:"",
		overstretch:"",
		playerclip:"",
		repeat:"",
		rotatetime:"",
		showdigits:"",
		showeq:"",
		showfsbutton:"",
		showicons:"",
		shownavigation:"",
		shuffle:"",
		streamscript:"",
		thumbsinplaylist:"",
		transition:"",
		volume:"",
		width:""
	}
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
	/** Accepted types of mediafiles **/
	private var fileTypes:Array;
	/** reference to the XML parser **/
	private var fileParser:FeedParser;
	/** Array with all playlist items **/
	private var fileArray:Array;
	/** reference to the controller **/
	private var controller:AbstractController;


	/**
	* Player application startup
	*
	* @param tgt	movieclip that contains all player graphics
	* @param fil	file that should be played
	**/
	public function AbstractPlayer(tgt:MovieClip,fil:String) {
		configArray["playerclip"] = tgt;
		configArray["playerclip"]._visible = false;
		fil == undefined ? null: configArray["file"] = fil;
		loadConfig();
	};


	/** Set configArray variables or load them from flashvars. **/
	private function loadConfig() {
		configArray["width"] = Stage.width;
		configArray["height"] = Stage.height;
		if(configArray["fullscreenmode"] == "true") {
			var pso = SharedObject.getLocal("com.jeroenwijering.players","/");
			configArray["fsreturnpage"] = pso.data.fsreturnpage;
			configArray["largecontrols"] = pso.data.largecontrols;
			configArray["file"] = pso.data.file;
		}
		for(var cfv in configArray) {
			if(_root[cfv] != undefined) {
				configArray[cfv] = unescape(_root[cfv]);
			}
		}
		if (configArray["displayheight"] == "undefined") {
			configArray["displayheight"] = configArray["height"]-20;
			if(configArray["largecontrols"] == "true") { 
				configArray["displayheight"] -= 20; 
			}
		}
		if (configArray["displaywidth"] == "undefined") {
			configArray["displaywidth"] = configArray["width"];
		}
		configArray["enablejs"] == "true" ? enableLoadFile(): null;
		loadFile(configArray["file"]);
	};


	/** 
	* Load an XML playlist or single media file.
	* 
	* @param fil	The file to load. It can be an array or single file string
	* @param tit,lnk,fid,img,aut,cap,cat,stt,typ	Additional file elements.
	**/
	public function loadFile(fil,tit,lnk,fid,img,aut,cap,cat,stt,typ) {
		if(controller != undefined) {
			controller.getEvent("stop");
			delete controller;
		}
		var i = 0;
		for (var itm in fileElements) {
			if(arguments[i] != undefined) { _root[itm] = arguments[i] }
			i++;
		}
		fileArray = new Array();
		var ftp = "list";
		for(var i=0; i<fileTypes.length; i++) {
			if(fil.substr(-3) == fileTypes[i] || _root.type == fileTypes[i] ||
				fil.substr(0,4)  == fileTypes[i]) {
				ftp = fileTypes[i]; 
			}
		}
		if (ftp == "list") {
			var ref = this;
			fileParser = new FeedParser();
			fileParser.onParseComplete = function() { 
				ref.fileArray = this.parseArray;
				ref.configArray["playerclip"]._visible = true;
				_root.activity._visible = false;
				ref.setupMCV();
			};
			fileParser.parse(fil);
		} else {
			fileArray[0] = new Object();
			fileArray[0]['type'] = ftp;
			var pso = SharedObject.getLocal("com.jeroenwijering.players","/");
			for(var cfv in fileElements) {
				if(_root[cfv] != undefined) { 
					fileArray[0][cfv] = unescape(_root[cfv]); 
				} else if(pso.data[itm] != undefined) {
					fileArray[0][cfv] =  pso.data[itm];
				}
			}
			configArray["playerclip"]._visible = true;
			_root.activity._visible = false;
			setupMCV();
		}	
	};


	/** Setup all necessary MCV blocks. **/
	private function setupMCV():Void {
		controller = new AbstractController(configArray,fileArray);
		var asv = new AbstractView(controller,configArray,fileArray);
		var vws:Array = new Array(asv);
		var asm = new AbstractModel(vws,controller,configArray,fileArray);
		var mds:Array = new Array(asm);
		controller.startMCV(mds);
	};


	/** Enable javascript access to loadFile command **/
	private function enableLoadFile() {
		if(flash.external.ExternalInterface.available) {
			var lfc = flash.external.ExternalInterface.addCallback("loadFile",
				this,loadFile);
		}
	};


}