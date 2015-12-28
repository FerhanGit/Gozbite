/**
* A couple of commonly used string operations.
*
* @author	Jeroen Wijering
* @version	1.0
**/


class com.jeroenwijering.utils.StringMagic {

	
	/** Array with day string representations. **/
	static var DAYS:Array = Array("Sunday","Monday","Tuesday","Wednesday",
		"Thursday","Friday","Saturday");
	/** Array with month string representations. **/
	static var MONTHS:Array = Array("January","February","March","April","May",
		"June","July","August","September","October","November","December");
	/** Supporting array to translate RFC2822 months to number. **/
	static var MONTH_INDEXES:Object = {January:0,February:1,March:2,April:3,
		May:4,June:5,July:6,August:7,September:8,October:9,November:10,
		December:11,Jan:0,Feb:1,Mar:2,Apr:3,May:4,Jun:5,Jul:6,Aug:7,Sep:8,
		Oct:9,Nov:10,Dec:11};
	/** Timezone abbreviation offsets **/
	static var TIMEZONES:Object = { IDLW:-12,NT:-11,AHST:-10,CAT:-10,HST:-10,
		YST:-9,PST:-8,MST:-7,PDT:-7,CST:-6,EST:-5,EDT:-4,ADT:-3,WBT:-4,AST:-4,
		NT:-3.5,EBT:-3,AT:-2,WAT:-1,UTC:0,UT:0,GMT:0,WET:0,CET:1,CEST:1,EET:2,
		EEDT:3,MSK:3,IRT:3.5,SAMT:4,YEKT:5,TMT:5,TJT:5,OMST:6,NOVT:6,LKT:6,
		MMT:6.5,KRAT:7,ICT:7,WIT:7,WAST:7,IRKT:8,ULAT:8,CST:8,CIT:8,BNT:8,
		YAKT:9,JST:9,KST:9,EIT:9,ACST:9.5,VLAT:10,ACDT:10.5,SAKT:10,GST:10,
		MAGT:11,IDLE:12,PETT:12,NZST:12 };
	/** A list of all allowed tags **/
	static var ALLOWED_TAGS = new Array("<p>","</p","<br","<i>","</i","<b>",
										"</b","<a ","</a","<u>","</u");


	/** 
	* Strip tags and breaks from a string
	* 
	* @param str	The string to process.
	* @return		The filered string.
	**/
	static function stripTagsBreaks(str:String):String {
		if(str.length == 0 || str == undefined) { return ""; }
		var tmp:Array = str.split("\n");
		str = tmp.join("");
		var tmp:Array = str.split("\r");
		str = tmp.join("");
		var i:Number = str.indexOf("<");
		while(i != -1) {
			var j = str.indexOf(">",i+1);
			j == -1 ? j = str.length-1: null;
			var fnd = false;
			for(var k=0; k<StringMagic.ALLOWED_TAGS.length; k++) {
				if(StringMagic.ALLOWED_TAGS[k] == str.substr(i,3)) { 
					var fnd = true;
					break;
				}
			}
			if(str.substr(i,3) == "<a ") {
				str = str.substr(0,i)+"<u>"+str.substr(i,str.length);
				j += 3;
			} else if(str.substr(i,3) == "</a") {
				str = str.substr(0,j+1)+"</u>"+str.substr(j+1,str.length);
				j += 4;
			} else if (fnd == false) {
				str = str.substr(0,i) + str.substr(j+1,str.length);
			}
			i = str.indexOf("<",j);
		}
		return str;
	};


	/** 
	* Translate RFC2822 date strings to timestamp. 
	*
	* @param dat	RFC2822 date string
	* @return		Resulting timestamp.
	**/
	static function rfc2Date(dat):Number {
		if(isNaN(dat)) {
			var darr:Array = dat.split(' ');
			darr[1] == "" ? darr.splice(1,1) : null;
			var month:Number = StringMagic.MONTH_INDEXES[darr[2]];
			var date:Number = darr[1].substring(0,2);
			var year:Number = darr[3];
			var zone = darr[5];
			var tarr:Array = darr[4].split(':');
			var myDate:Date = new Date(year,month,date,tarr[0],tarr[1],tarr[2]);
			var stamp = Math.round(myDate.valueOf()/1000) - myDate.getTimezoneOffset()*60;
			if(isNaN(zone)) { stamp -= 3600*StringMagic.TIMEZONES[zone]; }
			else { stamp -= 3600*Number(zone.substring(1,3)); }
			var dat = new Date(stamp*1000);
			return stamp;
		} else {
			return dat;
		}
	};


	/** 
	* Translate ISO8601 date strings to timestamp.
	*
	* @param dat	ISO8601 date string
	* @return		Resulting timestamp.
	**/
	static function iso2Date(dat):Number {
		if(isNaN(dat)) {
			while(dat.indexOf(" ") > -1) {
				var idx = dat.indexOf(" ");
				dat = dat.substr(0,idx) + dat.substr(idx+1);
			}
			var myDate = new Date(dat.substr(0,4),dat.substr(5,2)-1,dat.substr(8,2),
								  dat.substr(11,2),dat.substr(14,2),dat.substr(17,2));
			var stamp = Math.round(myDate.valueOf()/1000) - myDate.getTimezoneOffset()*60;
			if(dat.length > 20) { 
				var hr:Number = Number(dat.substr(20,2));
				var mn:Number = Number(dat.substr(23,2));
				if(dat.charAt(19) == "-") {
					stamp = stamp - hr*3600 - mn*60;
				} else {
					stamp += hr*3600 + mn*60;
					trace(stamp);
				}
				var dat = new Date(stamp*1000);
			}
			return stamp;
		} else {
			return dat;
		}
	};


	/**
	* Chop string into a number of lines five lines max.
	*
	* @param str	The input string.
	* @param cap	The average number of characters a line should have.
	* @param nbr	The max number of lines the return can have.
	* @return		The string with linebreaks included.
	**/
	static function chopString(str:String,cap:Number,nbr:Number):String {
		for(var i=cap; i<str.length; i+=cap) {
			if(i == cap*nbr) {
				if(str.indexOf(" ",nbr*i-3) == -1) {
					return str;
				} else {
					return str.substr(0,str.indexOf(" ",nbr*i-3));
				}
			} else  if(str.indexOf(" ",i) > 0) {
				str = str.substr(0,str.indexOf(" ",i-3))+"\n"+str.substr(str.indexOf(" ",i-3)+1);
			}
		}
		return str;
	};


	/** 
	* Add a leading zero and convert number to string.
	*
	* @param nbr	The number to convert.
	* @return		Te resulting string.
	**/
	static function addLeading(nbr:Number):String { 
		if(nbr < 10) { return "0"+Math.floor(nbr); } else { return Math.floor(nbr).toString(); }
	};


	/** 
	* Build a delaystring for a timestamp. 
	* 
	* @param stp	The stamp the delay should be calculated of.
	* @param sht	Use short notation or not.
	**/
	static function delayString(stp:Number,sht:Boolean):String {
		var dat = new Date();
		var dif = Math.round(dat.valueOf()/1000) - stp;
		dif < 0 || isNaN(dif) ? dif = 0: null;
		if(sht == true) {
			var hr:Number = Math.floor(dif/3600);
			var mi:Number = Math.floor(dif%3600/60);
			return hr+":"+StringMagic.addLeading(mi)+" ago";
		} else { 
			var ret:String = "";
			var dy:Number = Math.floor(dif/86400);
			if(dy > 1 ) {
				ret = dy+" days"; 
			} else if (dy == 1) { 
				ret = dy+" day";
			}
			var hr:Number = Math.floor(dif%86400/3600);
			if(hr > 1) { 
				ret.length>0 ? ret=ret+", "+hr+" hours": ret=hr+" hours";
			} else if (hr == 1) {
				ret.length > 0 ? ret = ret +", "+hr+" hour": ret = hr+" hour";
			}
			var mi:Number = Math.floor(dif%3600/60);
			if(mi == 1) { 
				ret.length>0 ? ret = ret+", "+mi+" minute": ret=mi+" minute";
			} else if(!(mi == 0 && ret.length > 0)) {
				ret.length>0 ? ret = ret +", "+mi+" minutes": ret = mi+" minutes";
			}
			return ret+" ago";
		}
	};


}