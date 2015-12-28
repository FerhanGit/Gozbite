<div id="mymap" style="position: relative; width:640px; height:260px;"></div>
<script type = "text/javascript">
   var map, pin;

   function loadMap(myX, myY) {
      if (GBrowserIsCompatible()) {
         var map = new GMap2(document.getElementById("mymap"));
         map.setCenter(new GLatLng(42.693516, 23.33246), 12);
         map.addControl(new GSmallMapControl());
         map.enableScrollWheelZoom();


         GEvent.addListener(map, "click", function(overlay, latlng) {
          //  if(document.getElementById('isOnMap').checked) {
               if(latlng) {
                  try {
                     map.clearOverlays();
                  } catch(exc) {
                  }
                  pin = createMarker(latlng, '<?=mysql_real_escape_string($baloonHTML)?>');
                  map.addOverlay(pin);
                  map.setCenter(latlng, 16);
                  document.getElementById('latitude').value    = latlng.lat();
                  document.getElementById('longitude').value   = latlng.lng();
               }
           // } else return Largo_alert("Моля, маркирайте полето 'на карта'!");
         });


         var baseIcon = new GIcon();
         baseIcon.image = "../img/icon_firmi.gif";
         baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
         baseIcon.iconSize = new GSize(23, 29);
         baseIcon.shadowSize = new GSize(37, 34);
         baseIcon.iconAnchor = new GPoint(9, 34);
         baseIcon.infoWindowAnchor = new GPoint(9, 2);

         function createMarker(point, baloon) {
            markerOptions = { icon:baseIcon };
            var marker = new GMarker(point, markerOptions);

            GEvent.addListener(marker, "mouseover", function() {
               marker.openInfoWindowHtml(baloon, { maxWidth: 250 });
            });
            return marker;
         }

         <?php
            if($Doctor->latitude>0 && $Doctor->longitude>0 && $Doctor->isOnMap) {
               printf("loc = new GLatLng(%0.20f, %0.20f);\n", $Doctor->latitude, $Doctor->longitude);
               printf("pin = createMarker(loc, '%s');\n", addslashes($baloonHTML));
               print "map.addOverlay(pin);\n";
               print "map.setCenter(loc, 16);\n";
            }
         ?>





      }
   }
</script>