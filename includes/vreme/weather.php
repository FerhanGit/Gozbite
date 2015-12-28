<?php 
$db_host = "localhost";
$db_user = "izletbgu_travel";
$db_pwd = "fsdboing";
$db_name = "izletbgu_travel";
$partner_id = "1057213998";
$key = '35b7fecb34d743dc';
$unit = "m"; 
$input = urlencode($_REQUEST['q']);
$length = 5;
$remember = 1; 
$input_type = ((strlen($input) == 5 And preg_match("/[0-9][0-9][0-9][0-9][0-9]/",$input)) Or (strlen($input) == 8 And preg_match("/[A-Z][A-Z][A-Z][A-Z][0-9][0-9][0-9][0-9]/",$input))) ? "code":"city"; 
$url_search = "http://xoap.weather.com/search/search?where=$input";
$url_forecast = "http://xoap.weather.com/weather/local/$input?cc=*&dayf=3&link=xoap&prod=xoap&par=$partner_id&key=$key&unit=m";
$url = ($input_type==city) ? $url_search:$url_forecast;
$timestamp = time();
$xml_url = md5($url);
$interval = 1;	
$expires = $interval*60*60;
$expired_timestamp = $timestamp - $expires;
$connection = mysql_connect($db_host, $db_user, $db_pwd) or die("Could not connect");
mysql_select_db($db_name) or die("Could not select database");
$query = "DELETE FROM weather_xml WHERE last_updated <= '$expired_timestamp'";
$result = mysql_query($query) or die('Invalid query: ' . mysql_error());
$query = "SELECT * FROM weather_xml WHERE xml_url = '$xml_url'"; 
$result = mysql_query($query) or die('Invalid query: ' . mysql_error());
$row = mysql_fetch_array($result);
if (mysql_num_rows($result) < 1) {
	$fp = @fopen($url,"r");
	if(is_resource($fp)) {
		while (!feof ($fp)) $xml .= fgets($fp, 4096);
		fclose ($fp);
	}
	else {
		exit("Unable to connect to weather.com");
	}
	$query  = "INSERT INTO weather_xml VALUES ('$xml_url', '$xml', '$timestamp')";
	$result = mysql_query($query) or die('Invalid query: ' . mysql_error());
}
else {
	$xml = $row['xml_data'];
}
$parser = xml_parser_create(); 
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
xml_parse_into_struct($parser,$xml,$values,$index); 
xml_parser_free($parser);
function getWeatherData($index,$values) {
	global $length;
	switch ($values[0]['tag']) {
		case "weather":		
			$return_array['type'] = "weather";
			$return_array[unit]['temp'] = $values[$index['ut'][0]]['value'];
			$return_array[unit]['dist'] = $values[$index['ud'][0]]['value'];
			$return_array[unit]['speed'] = $values[$index['us'][0]]['value'];
			$return_array[unit]['precip'] = $values[$index['up'][0]]['value'];
			$return_array[unit]['pressure'] = $values[$index['ur'][0]]['value'];
			$return_array[loc_info]['name'] = $values[$index['dnam'][0]]['value'];
			$return_array[loc_info]['time'] = $values[$index['tm'][0]]['value'];
			$return_array[loc_info]['lat'] = $values[$index['lat'][0]]['value'];
			$return_array[loc_info]['long'] = $values[$index['lon'][0]]['value'];
			$return_array[loc_info]['time_zone'] = $values[$index['zone'][0]]['value'];
			$return_array[cc]['feels_like'] = $values[$index['flik'][0]]['value'];
			$return_array[cc]['last_update'] = $values[$index['lsup'][0]]['value'];
			$return_array[cc]['temp'] = $values[$index['tmp'][0]]['value'];
			$return_array[cc]['text'] = $values[$index['t'][0]]['value'];
			$return_array[cc]['observation_station'] = $values[$index['obst'][0]]['value'];
			$return_array[cc]['icon'] = $values[$index['icon'][0]]['value'];
			$return_array[cc]['humidity'] = $values[$index['hmid'][0]]['value'];
			$return_array[cc]['visibility'] = $values[$index['vis'][0]]['value'];
			$return_array[cc]['dew_point'] = $values[$index['dewp'][0]]['value'];
			$return_array[cc]['uv_index'] = $values[$index['i'][0]]['value'];
			$return_array[cc]['uv_text'] = $values[$index['t'][2]]['value'];
			$return_array[cc]['moon_icon'] = $values[$index['icon'][1]]['value'];
			$return_array[cc]['moon_text'] = $values[$index['t'][3]]['value'];
			$return_array[cc]['uv_index'] = $values[$index['i'][0]]['value'];
			$return_array[cc]['wind_speed'] = $values[$index['s'][0]]['value'];
			$return_array[cc]['wind_gust'] = $values[$index['gust'][0]]['value'];
			$return_array[cc]['wind_direction'] = $values[$index['d'][1]]['value'];
			$return_array[cc]['wind_text'] = $values[$index['t'][1]]['value'];
			$return_array[cc]['barometer'] = $values[$index['r'][0]]['value'];
			$return_array[cc]['barometer_dir'] = $values[$index['d'][0]]['value'];
			$counter = 0;
			if (array_key_exists("day",$index)){
				foreach ($index['day'] as $day){
					if ($values[$day]['attributes']['t'] != ""){
						$day_text = (($counter + 1) * 3) + $counter + 1;
						$day_wind = ((($counter + 1) * 3) + $counter) + 2;
						$day_windspeed = (($counter + 1) * 2) - 1;
						$day_windgust = (($counter + 1) * 2) - 1;
						$day_winddir = ($counter + 1) * 2;
						$day_humidity = (($counter + 1) * 2) - 1;
						$day_precip = $counter * 2;
						$day_icon = ($counter + 1) * 2; 
						$night_text = ((($counter + 1) * 3) + $counter) + 3;
						$night_wind = ((($counter + 1) * 3) + $counter) + 4;
						$night_windspeed = ($counter + 1) * 2;
						$night_windgust = ($counter + 1) * 2;
						$night_winddir = (($counter + 1) * 2) + 1;
						$night_humidity = ($counter + 1) * 2;
						$night_precip = ($counter * 2) + 1;
						$night_icon = (($counter + 1) * 2) + 1;
						$return_array['day'][$counter]['date'] = $values[$day]['attributes']['dt'];
						$return_array['day'][$counter]['day'] = $values[$day]['attributes']['t'];
						$return_array['day'][$counter]['hi'] = $values[$index['hi'][$counter]]['value'];
						$return_array['day'][$counter]['low'] = $values[$index['low'][$counter]]['value'];
						$return_array['day'][$counter]['sunrise'] = $values[$index['sunr'][$counter+1]]['value'];
						$return_array['day'][$counter]['sunset'] = $values[$index['suns'][$counter+1]]['value'];
						$return_array['day'][$counter]['day_text'] = $values[$index[t][$day_text]][value];
						$return_array['day'][$counter]['day_wind'] = $values[$index[t][$day_wind]][value];
						$return_array['day'][$counter]['day_windspeed'] = $values[$index[s][$day_windspeed]][value];
						$return_array['day'][$counter]['day_windgust'] = $values[$index[gust][$day_windgust]][value];
						$return_array['day'][$counter]['day_winddir'] = $values[$index[d][$day_winddir]][value];
						$return_array['day'][$counter]['day_humid'] = $values[$index[hmid][$day_humidity]][value];
						$return_array['day'][$counter]['day_pct_precip'] = $values[$index[ppcp][$day_precip]][value];
						$return_array['day'][$counter]['day_icon'] = $values[$index[icon][$day_icon]][value];
						$return_array['day'][$counter]['night_text'] = $values[$index[t][$night_text]][value];
						$return_array['day'][$counter]['night_wind'] = $values[$index[t][$night_wind]][value];
						$return_array['day'][$counter]['night_windspeed'] = $values[$index[s][$night_windspeed]][value];
						$return_array['day'][$counter]['night_windgust'] = $values[$index[gust][$night_windgust]][value];
						$return_array['day'][$counter]['night_winddir'] = $values[$index[d][$night_winddir]][value];
						$return_array['day'][$counter]['night_humid'] = $values[$index[hmid][$night_humidity]][value];
						$return_array['day'][$counter]['night_pct_precip'] = $values[$index[ppcp][$night_precip]][value];
						$return_array['day'][$counter]['night_icon'] = $values[$index[icon][$night_icon]][value];
						$counter++;
					}
				}
			}
			break;
		case "search":
			if(array_key_exists('loc',$index)) {
		if (count($index[loc]) == 1) header("Location:".$_SERVER[PHP_SELF]."?q=".$values[$index['loc'][0]]['attributes']['id']."&d=".$length); 
				$return_array['type'] = "search";
				$search_count = 0;
				foreach($index['loc'] as $valkey){
					$return_array[$search_count]['city'] = $values[$valkey]['value'];
					$return_array[$search_count]['locid'] = $values[$valkey]['attributes']['id'];
					$search_count++;
				}
			}
			else {
				$return_array['type'] = "error";
				$return_array[]['error'] = "no locations found";
			}
			break;
		case "error":
			$return_array['type'] = "error";
			$return_array[]['error'] = $values[1]['value'];;
			break;
	}
	return $return_array;
}
if ($values[0]['tag'] == "weather" And $_REQUEST['remember']) setcookie("wdc", $input, strtotime("+1 week"));
header("Content-Type:text/xml"); 
$weather_array = getWeatherData($index,$values);
if($weather_array[type] == "error"){
	echo $weather_array[0]['error'];
}
if($weather_array[type] == "search"){
	echo "<select name=\"cities\" onchange=\"getModule(this.options[this.selectedIndex].value,0);theForm.elements['zip'].value=this.options[this.selectedIndex].value\">\n";
	echo "<option value=\"00000\">Select a city</option>\n";
	for($i=0;$i<=count($weather_array)-2;$i++){
		echo "<option value=\"" . $weather_array[$i][locid] . "\">" . $weather_array[$i][city] . "</option>\n";
	}
	echo "</select>\n";
}
if($weather_array[type] == "weather"){
	$system = $weather_array['unit']['temp'];
	$barometer = $weather_array['unit']['pressure'];
	$response = '';
	if(array_key_exists("day",$weather_array)){
		$day_counter = 1;
		$response .= '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:0px\" align=\"center\"><tr style=\"border:0px\">';
		foreach($weather_array['day'] as $forecast_day){
			if($day_counter == 1){
				//$forecast_date = ($forecast_day[hi] == "N/A") ? "Няма данни":"Днес";
				$forecast_date = ($forecast_day[hi] == "N/A") ? "Сега":"Днес";
				$forecast_icon = ($forecast_day[hi] == "N/A") ? $forecast_day['night_icon']:$forecast_day['day_icon'];				
			if($forecast_day[hi] != "N/A") $forecast_data .= "<font color='#CC3300'><strong>$forecast_day[hi]&#176;</strong>$system</font> / ";
			$forecast_data .= "<font color='#006699'><strong>$forecast_day[low]&#176;</strong>$system</font><br />";
			}
			else {			
				$forecast_date = applyforecaststyle($forecast_day[day]);
				$forecast_icon = $forecast_day['day_icon'];
				$forecast_data = "<font color='#CC3300'><strong>".$forecast_day['hi']."&#176;</strong>$system</font> / <font color='#006699'><strong>".$forecast_day['low']."&#176;</strong>$system</font><br />";
			}
			//$forecast_data .= "изгрев ".date("H:i",strtotime($forecast_day[sunrise]))."<br />залез ".date("H:i",strtotime($forecast_day[sunset]));
			if($day_counter == 1 And $forecast_day[hi] == "N/A") $forecast_data .= "&nbsp;";
$response .= "<td style=\"border:0px\" valign=\"top\" width=\"33%\"><div style='padding:2px;margin:2px'>
<div class='rsTopNewsModule' style=\"border:0px\">
  <div class='rsWireBox'>
   
    <div class='rsBoxContent' >
      <div style='color:#006e00;font-weight:bold;' align='center'>$forecast_date</div>
      <div style='padding:2px' align='center'>
          <img src='inc/vreme/icons/61x61/".((strlen($forecast_icon) == 1) ? $forecast_icon = "0".$forecast_icon : $forecast_icon).".png' width='61' height='61' vspace='3' border='0' alt='' title=''>
        <div align='left'>$forecast_data</div>
     </div>
    </div>
   
  </div>
</div></div></td>";
	$day_counter++;
		}
		$response .= '</tr></table>';
	}
echo "<weather>$response</weather>";
}
function applyforecaststyle($temp){
	if ($temp == "Monday") $class ="Понеделник";
	if ($temp == "Tuesday") $class ="Вторник";
	if ($temp == "Wednesday") $class ="Сряда";
	if ($temp == "Thursday") $class ="Четвъртък";
	if ($temp == "Friday") $class ="Петък";
	if ($temp == "Saturday") $class ="Събота";
	if ($temp == "Sunday") $class ="Неделя";
	return $class;
}
?>