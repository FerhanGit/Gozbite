<?php 

$map = "";

$map .='<script type = "text/javascript">
   var map, pin;

   function loadMap(myX, myY) {
      if (GBrowserIsCompatible()) {
         var map = new GMap2(document.getElementById("mymap"));
         map.setCenter(new GLatLng(42.693516, 23.33246), 7);
         map.addControl(new GSmallMapControl());
         map.addControl(new GMapTypeControl());
		 map.enableScrollWheelZoom();

		
         GEvent.addListener(map, "click", function(overlay, latlng) {
           
               if(latlng) {
                  try {
                     map.clearOverlays();
                  } catch(exc) {
                  }';
                 

				  $map .= sprintf("pin = createTabbedMarker(latlng, '%s','%s','%s','%s');\n", nl2br(mysql_real_escape_string($baloonHTML1)), nl2br(mysql_real_escape_string($baloonHTML2)),'Информация','Още');
                  $map .= "map.addOverlay(pin);\n";
$map .='
				  map.setCenter(latlng, 10);
                  document.getElementById(\'latitude\').value    = latlng.lat();
                  document.getElementById(\'longitude\').value   = latlng.lng();
               }
           
         });


         var baseIcon = new GIcon();
         baseIcon.image = "images/icon_hotels.png";
         baseIcon.shadow = "images/icon_hotels_shadow.png";
         baseIcon.iconSize = new GSize(32, 30);
         baseIcon.shadowSize = new GSize(40, 35);
         baseIcon.iconAnchor = new GPoint(9, 34);
         baseIcon.infoWindowAnchor = new GPoint(19, 5);

         function createMarker(point, baloon) {
            markerOptions = { icon:baseIcon };
            var marker = new GMarker(point, markerOptions);

            GEvent.addListener(marker, "mouseover", function() {
               marker.openInfoWindowHtml(baloon, { maxWidth: 250 });
            });
            return marker;
         }
		 function createTabbedMarker(point,html1,html2,label1,label2) {
	        markerOptions = { icon:baseIcon };
	        var marker = new GMarker(point, markerOptions);
	        GEvent.addListener(marker, "mouseover", function() {
	          marker.openInfoWindowTabsHtml([new GInfoWindowTab(label1,html1), new GInfoWindowTab(label2,html2)],{ maxWidth: 250 });
	        });
	        return marker;
	      }';
		  


            if($resultEdit['latitude']>0 && $resultEdit['longitude']>0 ) {
               $map .= sprintf("loc = new GLatLng(%0.20f, %0.20f);\n", $resultEdit['latitude'], $resultEdit['longitude']);
              // printf("pin = createMarker(loc, '%s');\n", addslashes($baloonHTML));
              // print "map.addOverlay(pin);\n";
			   $map .= sprintf("pin = createTabbedMarker(loc, '%s','%s','%s','%s');\n", nl2br(mysql_real_escape_string($baloonHTML1)), nl2br(mysql_real_escape_string($baloonHTML2)),'Информация','Още');
               $map .= "map.addOverlay(pin);\n";
			  
               $map .= "map.setCenter(loc, 10);\n";
            }
         $map .='


      }
   }
</script>';
         
         
return $map;

?>