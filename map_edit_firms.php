<?php 

$map = "";

$map .='<script type = "text/javascript">
   var map, pin;

   function loadMap(myX, myY) {
      if (GBrowserIsCompatible()) {
         var map = new GMap2(document.getElementById("mymap"));
         map.setCenter(new GLatLng(42.693516, 23.33246), 12);
         map.addControl(new GSmallMapControl());
		 map.addControl(new GMapTypeControl());
         map.enableScrollWheelZoom();

		
         GEvent.addListener(map, "click", function(overlay, latlng) {
           
               if(latlng) {
                  try {
                     map.clearOverlays();
                  } catch(exc) {
                  }';
                  

				  $map .= sprintf("pin = createTabbedMarker(latlng, '%s','%s','%s','%s');\n", nl2br(mysql_real_escape_string($baloonHTML1)), nl2br(mysql_real_escape_string($baloonHTML2)), 'Информация', 'Още');
                  $map .= "map.addOverlay(pin);\n";
$map .='			
				  map.setCenter(latlng, 16);
                  document.getElementById(\'latitude\').value    = latlng.lat();
                  document.getElementById(\'longitude\').value   = latlng.lng();
               }
           
         });


         var baseIcon = new GIcon();
         baseIcon.image = "images/icon_firms.png";
         baseIcon.shadow = "images/icon_firms_shadow.png";
         baseIcon.iconSize = new GSize(30, 30);
         baseIcon.shadowSize = new GSize(30, 30);
         baseIcon.iconAnchor = new GPoint(9, 34);
         baseIcon.infoWindowAnchor = new GPoint(19, 5);

         function createMarker(point, baloon) {
            markerOptions = { icon:baseIcon };
            var marker = new GMarker(point, markerOptions);

            GEvent.addListener(marker, "mouseover", function() {
               marker.openInfoWindowHtml(baloon, { maxWidth: 300 });
            });
            return marker;
         }
		 function createTabbedMarker(point,html1,html2,label1,label2) {
	        markerOptions = { icon:baseIcon };
	        var marker = new GMarker(point, markerOptions);
	        GEvent.addListener(marker, "mouseover", function() {
	          marker.openInfoWindowTabsHtml([new GInfoWindowTab(label1,html1), new GInfoWindowTab(label2,html2)],{ maxWidth: 300 });
	        });
	        return marker;
	      }';
        
            if($resultEdit['latitude']>0 && $resultEdit['longitude']>0 ) {
               $map .= sprintf("loc = new GLatLng(%0.20f, %0.20f);\n", $resultEdit['latitude'], $resultEdit['longitude']);
              // printf("pin = createMarker(loc, '%s');\n", addslashes($baloonHTML));
              // print "map.addOverlay(pin);\n";
			   $map .= sprintf("pin = createTabbedMarker(loc, '%s','%s','%s','%s');\n", nl2br(mysql_real_escape_string($baloonHTML1)), nl2br(mysql_real_escape_string($baloonHTML2)),'Информация','Още');
               $map .= "map.addOverlay(pin);\n";
			  
			   $map .= "map.setCenter(loc, 16);\n";
            }
        $map .='

      }
   }
</script>';
        
return $map;

?>
