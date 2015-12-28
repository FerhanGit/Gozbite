<?php

$map = "";

   $cond = "";
   $locationID = $_REQUEST['locationID'];
   if($locationID > 0) 
   {
   		$cond .= sprintf(" AND l.id = %d", $locationID);
   }
   else 
   {
   		$cond .= " AND l.info <> ''"; 
   }
  
    		


	$sql="SELECT l.id as 'id', l.name as 'location_name', lt.name as 'locType', l.info as 'info', l.autor as 'autor', l.autor_type as 'autor_type', l.latitude as 'latitude', l.longitude as 'longitude', l.youtube_video as 'youtube_video' FROM locations l, location_types lt WHERE l.loc_type_id = lt.id $cond";
	$conn->setsql($sql);
	$conn->getTableRows();
	
   $locations_onMap = Array();
   if($conn->numberrows > 0) {
      $locations_onMap = $conn->result;                 	
   }

   
$map .='
<script type = "text/javascript">

  function locations_MapOnload() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("myMap"));';
     
			if(isset($locationID)) { $map .= sprintf("map.setCenter(new GLatLng(%0.20f, %0.20f),11);", $locations_onMap[0]["latitude"], $locations_onMap[0]["longitude"]); }
			else { $map .= 'map.setCenter(new GLatLng(42.693516, 23.33246), 6);'; }
$map .='
		map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
		map.enableScrollWheelZoom();
		
        var baseIcon = new GIcon();
        baseIcon.image = "images/icon_hotels.png";
        baseIcon.shadow = "images/icon_hotels_shadow.png";
        baseIcon.iconSize = new GSize(40, 25);
        baseIcon.shadowSize = new GSize(37, 34);
        baseIcon.iconAnchor = new GPoint(9, 34);
        baseIcon.infoWindowAnchor = new GPoint(9, 2);

        function createMarker(point, baloon) {
          markerOptions = { icon:baseIcon };
          var marker = new GMarker(point, markerOptions);
          //GEvent.addListener(marker, "mouseover", function() {
          GEvent.addListener(marker, "click", function() {
                 marker.openInfoWindowHtml(baloon, { maxWidth: 300 });
          });
          return marker;
        }

		function createTabbedMarker(point,html1,html2,label1,label2) {
	        markerOptions = { icon:baseIcon };
	        var marker = new GMarker(point, markerOptions);
	        //GEvent.addListener(marker, "mouseover", function() {
        	 GEvent.addListener(marker, "click", function() {
	     	          marker.openInfoWindowTabsHtml([new GInfoWindowTab(label1,html1), new GInfoWindowTab(label2,html2)],{ maxWidth: 300 });
	        });
	        return marker;
	      }
		  
        var locationLocsArr = new Array();
        var bounds = new GLatLngBounds();';
    
           foreach($locations_onMap as $row) 
           {   
           
           		$baloonHTML1 = "";
           		$baloonHTML2 = "";
           	
               $baloonHTML = "";		  
          
            
			//--------------------------- PICS ------------------------------------------
			
				$sql="SELECT * FROM location_pics WHERE locationID='".$row['id']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultPicsMap=$conn->result;
				$numPicsMap=$conn->numberrows;
	
			 
				
			   if($numPicsMap > 0)  $picFileMap = $resultPicsMap[0]['url_thumb'];
			   else $picFileMap = "no_photo_thumb.png";
	  		   $baloonHTML1 .= "<span style='float:left;margin-right:10px;'><a href = 'разгледай-дестинация-".$row['id'].",".myTruncateToCyrilic($row['locType'].' '.$row['location_name'],200,'_','').".html'><img src='pics/locations/".$picFileMap."' /></a></span>";               
               $baloonHTML1 .= "<span style='font-size:12px;'><a class='homePageVIPLink'  href='разгледай-дестинация-".$row['id'].",".myTruncateToCyrilic($row['locType'].' '.$row['location_name'],200,'_','').".html'>".$row['locType'].' '.$row['location_name']."</a></span>";
               $baloonHTML2 .= "<span style='font-size:12px;'>".myTruncate($row["info"], 300, " ")."<a href = 'разгледай-дестинация-".$row['id'].",".myTruncateToCyrilic($row['locType'].' '.$row['location_name'],200,'_','').".html'> виж още</a></span>";
               $map .= sprintf("loc = new GLatLng(%0.20f, %0.20f);\n", $row["latitude"], $row["longitude"]);
               $map .= "bounds.extend(loc);\n";
               $map .= sprintf("locationLocsArr.push(loc);\n");
              // printf("pin = createMarker(loc, '%s');\n", nl2br(mysql_real_escape_string($baloonHTML)));
              // print "map.addOverlay(pin);\n";
			   
			   $map .= sprintf("pin = createTabbedMarker(loc, '%s','%s','%s','%s');\n", nl2br(mysql_real_escape_string($baloonHTML1)), nl2br(mysql_real_escape_string($baloonHTML2)),'Информация','Още');
               $map .= "map.addOverlay(pin);\n";
			  
      
	  
           }
           
$map .='
     
        //map.setZoom(map.getBoundsZoomLevel(bounds));
      }
   }
</script>
<script type = "text/javascript">
   
   function init() {    // quit if this function has already been called
      if (arguments.callee.done) return;
      // flag this function so we don\'t do the same thing twice
      arguments.callee.done = true;
      // kill the timer
      if (_timer) clearInterval(_timer);

      locations_MapOnload();
   };

   /* for Mozilla/Opera9 */
   if (document.addEventListener) {
      document.addEventListener("DOMContentLoaded", init, false);
   }

   // for Internet Explorer (using conditional comments)
   /*@cc_on @*/
   /*@if (@_win32)
   document.write("<script id=__ie_onload defer src=javascript:void(0)><\/script>");
   var script = document.getElementById("__ie_onload");
   script.onreadystatechange = function() {
       if (this.readyState == "complete") {
           init(); // call the onload handler
       }
   };
   /*@end @*/

   /* for Safari */
   if (/WebKit/i.test(navigator.userAgent)) { // sniff
      var _timer = setInterval(function() {
         if (/loaded|complete/.test(document.readyState)) {
            init(); // call the onload handler
         }
      }, 10);
   }
</script>';

return $map;

?>
 