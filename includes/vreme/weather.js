var div = document.getElementById('forecast');
var theForm = document.getElementById('form1');
function successHandler(o) {
	var wdata = o.responseText;
	div.innerHTML = wdata;
}
function failureHandler(o) {
	div.innerHTML = o.status + " " + o.statusText;
}
function getModule(wdccode,remem) {
	div.innerHTML = "Loading...";
	var location = (wdccode) ? wdccode:theForm.elements['zip'].selectedIndex;
	var days = $('numdays').getValue();
	var queryString = encodeURI('?q=' + location);
	var sUrl = ('inc/vreme/weather.php' + queryString);
	if(remem) sUrl += "&remember=1";
	//var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, { success:successHandler, failure:failureHandler });
	new Ajax.Updater("forecast",sUrl);
}
var allcookies = (document.cookie);
var position = allcookies.indexOf("wdc=");
if(position != -1) {
	var start = position + 4;
	var end = allcookies.indexOf(";",start);
	if (end == -1) end = allcookies.length;
	var value = allcookies.substring(start,end);
	value = decodeURIComponent(value); 
	if(value != "") getModule(value,0);
}