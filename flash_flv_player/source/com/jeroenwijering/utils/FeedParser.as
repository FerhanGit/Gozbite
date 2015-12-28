/**
* Parses RSS, ATOM and XSPF lists and returns them as a numerical array:
* [title,author,file,link,image,category,id,start,description,date,latitude,longitude]
* An onParseComplete event is broadcasted upon succesful completion.
*
* @example
* var prs = new com.jeroenwijering.utils.FeedParser();
* prs.onParseComplete = function() { trace(this.parseArray.length); };
* prs.parse("http://www.jeroenwijering.com/rss/");
*
* @author	Jeroen Wijering
* @version	1.21
**/


import com.jeroenwijering.utils.StringMagic;


class com.jeroenwijering.utils.FeedParser {


	/** URL of the xml file to parse. **/
	private var parseURL:String;
	/** The array the XML is parsed into **/
	public var parseArray:Array; 
	/** Flash XML object the file is loaded into. **/
	private var parseXML:XML;
	/** Tags allowed for RSS Format **/
	private var RSS_TAGS:Object = {
		title:"title",
		author:"author",
		link:"link",
		guid:"id",
		category:"category"
	};
	/** Tags allowed for ATOM Format **/
	private var ATOM_TAGS:Object = {
		title:"title",
		id:"id"
	};
	/** Tags allowed for XSPF Format **/
	private var XSPF_TAGS:Object = {
		title:"title",
		creator:"author",
		info:"link",
		image:"image",
		identifier:"id",
		album:"category"
	};
	/** Accapted MIMETYPES for enclosures **/
	private var MIMETYPES:Object = {
		mp3:"mp3",
		flv:"flv",
		rtmp:"rtmp",
		jpg:"jpg",
		gif:"gif",
		png:"png",
		swf:"swf"
	};


	/** Constructor. Only a hack to support tags with ': or /' included **/
	function FeedParser() {
		RSS_TAGS["itunes:author"] = "author";
		RSS_TAGS["geo:lat"] = "latitude";
		RSS_TAGS["geo:long"] = "longitude"; 
		ATOM_TAGS["geo:lat"] = "latitude";
		ATOM_TAGS["geo:long"] = "longitude";
		MIMETYPES["audio/mpeg"] = "mp3";
		MIMETYPES["video/x-flv"] = "flv";
		MIMETYPES["image/jpeg"] = "jpg";
		MIMETYPES["image/png"] = "png";
		MIMETYPES["image/gif"] = "gif";
		MIMETYPES["application/x-shockwave-flash"] = "swf";
		MIMETYPES["application/x-fcs"] = "rtmp";
	};


	/** 
	* Parse an XML list.
	*
	* @param url	URL of the playlist that should be parsed.
	**/
	public function parse(url:String):Void {
		var ref = this;
		parseURL = url;
		parseArray = new Array();
		parseXML = new XML();
		parseXML.ignoreWhite = true;
		parseXML.onLoad = function(success:Boolean) {
			if(success) {
				var fmt = this.firstChild.nodeName.toLowerCase();
				if( fmt == 'rss') {	ref.parseRSS();} 
				else if (fmt == 'feed') { ref.parseASF(); } 
				else if (fmt == 'playlist') { ref.parseXSPF(); } 
				else { parseArray.push({title:"Feed not understood: "+ref.parseURL}); }
			} else {
				parseArray.push({title:"Feed not found: "+ref.parseURL});
			}
			if(parseArray.length == 0) {
				parseArray.push({title:"Empty feed: "+ref.parseURL});
			}
			delete ref.parseXML;
			ref.onParseComplete();
		};
		if(_root._url.indexOf("file://") > -1) { parseXML.load(parseURL); } 
		else if(parseURL.indexOf('?') > -1) { parseXML.load(parseURL+'&'+random(999)); } 
		else { parseXML.load(parseURL+'?'+random(999)); }
	};


	/** Convert RSS structure to array. **/
	private function parseRSS():Void {
		var tpl = parseXML.firstChild.firstChild.firstChild;
		while(tpl != null) { 
			if (tpl.nodeName.toLowerCase() == "item") {
					var obj = new Object();
					for(var j=0; j<tpl.childNodes.length; j++) {
						var nod:XMLNode = tpl.childNodes[j];
						if(RSS_TAGS[nod.nodeName.toLowerCase()] != undefined) {
							obj[RSS_TAGS[nod.nodeName.toLowerCase()]] = nod.firstChild.nodeValue;
						} else if(nod.nodeName.toLowerCase() == "description") {
							obj["description"] = StringMagic.stripTagsBreaks(nod.firstChild.nodeValue);
						} else if(nod.nodeName.toLowerCase() == "pubdate") {
							obj["date"] = StringMagic.rfc2Date(nod.firstChild.nodeValue);
						} else if(nod.nodeName.toLowerCase() == "dc:date") {
							obj["date"] = StringMagic.iso2Date(nod.firstChild.nodeValue);
						} else if(nod.nodeName.toLowerCase() == "media:thumbnail") {
							obj["image"] = nod.attributes.url;
						} else if(nod.nodeName.toLowerCase() == "itunes:image") {
							obj["image"] = nod.attributes.href;
						} else if(nod.nodeName.toLowerCase() == "geo") {
							obj["latitude"] = nod.attributes.latitude;
							obj["longitude"] = nod.attributes.longitude;
						} else if(nod.nodeName.toLowerCase() == "enclosure" || 
							nod.nodeName.toLowerCase() == "media:content") {
							if(MIMETYPES[nod.attributes.type] != undefined) {
								obj["file"] = nod.attributes.url;
								obj["type"] = MIMETYPES[nod.attributes.type];
							}
							if(nod.attributes.type == "captions") {
								obj["captions"] = nod.attributes.url;
							}
						} else if(nod.nodeName.toLowerCase() == "media:group") { 
							for(var k=0; k< nod.childNodes.length; k++) {
								if(nod.childNodes[k].nodeName == "media:content") {
									if(MIMETYPES[nod.childNodes[k].attributes.type] != undefined) {
										obj["file"] = nod.childNodes[k].attributes.url;
										obj["type"] = MIMETYPES[nod.childNodes[k].attributes.type];
									}
								} else if(nod.childNodes[k].nodeName == "media:thumbnail") {
									obj["image"] = nod.childNodes[k].attributes.url;
								}
							}
						}
					}
					if(obj["latitude"] == undefined && lat != undefined) {
						obj["latitude"] = lat;
						obj["longitude"] = lng;
					} 
					if(obj["image"] == undefined && obj["file"].indexOf(".jpg") > 0) {
						obj["image"] = obj["file"];
					}
					obj["author"] == undefined ? obj["author"] = ttl: null;
					parseArray.push(obj);
			} else if (tpl.nodeName == "title") { var ttl = tpl.firstChild.nodeValue; }
			else if (tpl.nodeName == "geo:lat") { var lat = tpl.firstChild.nodeValue; }
			else if (tpl.nodeName == "geo:long") { var lng = tpl.firstChild.nodeValue; }
			tpl = tpl.nextSibling;
		}
	};


	/** Convert ATOM structure to array **/
	private function parseASF():Void {
		var tpl = parseXML.firstChild.firstChild;
		while(tpl != null) {
			if (tpl.nodeName.toLowerCase() == "entry") {
					var obj = new Object();
					for(var j=0; j<tpl.childNodes.length; j++) {
						var nod:XMLNode = tpl.childNodes[j];
						if(ATOM_TAGS[nod.nodeName] != undefined) {
							obj[ATOM_TAGS[nod.nodeName]] = nod.firstChild.nodeValue;
						} else if(nod.nodeName == "link" && 
							nod.attributes.rel == "alternate") {
							obj["link"] =  nod.attributes.href;
						} else if(nod.nodeName == "summary") {
							obj["description"] = StringMagic.stripTagsBreaks(nod.firstChild.nodeValue);
						} else if(nod.nodeName == "published") {
							obj["date"] = StringMagic.iso2Date(nod.firstChild.nodeValue);
						} else if(nod.nodeName == "updated") {
							obj["date"] = StringMagic.iso2Date(nod.firstChild.nodeValue);
						} else if(nod.nodeName == "modified") {
							obj["date"] = StringMagic.iso2Date(nod.firstChild.nodeValue);
						} else if(nod.nodeName == "category") {
							obj["category"] = nod.attributes.term;
						} else if(nod.nodeName == "author") { 
							for(var k=0; k< nod.childNodes.length; k++) {
								if(nod.childNodes[k].nodeName == "name") {
									obj["author"] = nod.childNodes[k].firstChild.nodeValue;
								}
							}
						} else if(nod.nodeName == "link" && 
							nod.attributes.rel == "enclosure") {
							if(MIMETYPES[nod.attributes.type] != undefined) {
								obj["file"] = nod.attributes.href;
								obj["type"] = MIMETYPES[nod.attributes.type];
							}
						} else if(nod.nodeName == "link" && 
							nod.attributes.rel == "captions") {
							obj["captions"] = nod.attributes.href;
						} else if(nod.nodeName == "link" && 
							nod.attributes.rel == "image") {
							obj["image"] = nod.attributes.href;
						}
					}
					obj["author"] == undefined ? obj["author"] = ttl: null;
					parseArray.push(obj);
			} else if (tpl.nodeName == "title") { var ttl = tpl.firstChild.nodeValue; }
			tpl = tpl.nextSibling;
		}
	};


	/** Convert XSPF structure to array. **/
	private function parseXSPF():Void {
		var tpl = parseXML.firstChild.firstChild;
		while(tpl != null) { 
			if (tpl.nodeName == 'trackList') {
				for(var i=0; i<tpl.childNodes.length; i++) {
					var obj = new Object();
					for(var j=0; j<tpl.childNodes[i].childNodes.length; j++) {
						var nod:XMLNode = tpl.childNodes[i].childNodes[j];
						if(XSPF_TAGS[nod.nodeName.toLowerCase()] != undefined) {
							obj[XSPF_TAGS[nod.nodeName.toLowerCase()]] = nod.firstChild.nodeValue;
						} else if(nod.nodeName.toLowerCase() == "location") {
							obj["file"] = nod.firstChild.nodeValue;
							if(nod.firstChild.nodeValue.substr(0,4) == "rtmp") {
								obj["type"] == "rtmp";
							} else {
								obj["type"] = nod.firstChild.nodeValue.substr(-3);
							}
						} else if(nod.nodeName.toLowerCase() == "annotation") {
							obj["description"] = StringMagic.stripTagsBreaks(nod.firstChild.nodeValue);
						} else if(nod.nodeName.toLowerCase() == "link" &&
							nod.attributes.rel == "captions") {
							obj["captions"] = nod.firstChild.nodeValue;
						} else if(nod.nodeName.toLowerCase() == "meta" &&
							nod.attributes.rel == "start") {
							obj["start"] = nod.firstChild.nodeValue;
						} else if(nod.nodeName.toLowerCase() == "meta" &&
							nod.attributes.rel == "type") {
							obj["type"] = nod.firstChild.nodeValue;
						}
					}
					parseArray.push(obj);
				} 
			}
			tpl = tpl.nextSibling;
		}
	};


	/** Invoked when parsing is completed. **/
	public function onParseComplete() { };


}