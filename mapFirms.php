<?php

$map = "";

   $cond = "";
   $firmID = $_REQUEST['firmID'];
   if($firmID > 0) $cond .= sprintf(" AND f.id = %d", $firmID);
   elseif(isset($_REQUEST['cityName'])) 
   {
     if(is_array($_REQUEST['cityName'])) { $locations = implode(',',$_REQUEST['cityName']);}
	 else { $locations = $_REQUEST['cityName'];}
	 if (($_REQUEST['cityName']!="") && ($_REQUEST['cityName']!="-1"))
	 {
	 	 $cond .= sprintf(" AND f.location_id in (%s)", $locations);
	 }
   }
	elseif(isset($_REQUEST['firm_category']) or isset($_REQUEST['category']))
    {
	   	if(empty($_REQUEST['firm_category'])) $_REQUEST['firm_category'] = $_REQUEST['category'];
		$_REQUEST['firm_category'] = $_REQUEST['firm_sub_category']?$_REQUEST['firm_sub_category']:$_REQUEST['firm_category'];
		if ($_REQUEST['firm_category']!="")  
		{
			$sql="SELECT f.id as 'firm_id' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id AND (fcl.category_id = '".$_REQUEST['firm_category']."' OR fcl.category_id IN (SELECT id FROM firm_category WHERE parentID='".$_REQUEST['firm_category']."') )";
			$conn->setsql($sql);
			$conn->getTableRows();
			$numfirmByCatsMap    = $conn->numberrows;
			$resultfirmByCatsMap = $conn->result;
			for($n=0;$n<$numfirmByCatsMap;$n++)
			{
				if(!empty($numfirmByCatsMap[$n]['firm_id']))
				$firmsByCatsMapArr[]=$resultfirmByCatsMap[$n]['firm_id'];
					
			}
			if(is_array($firmsByCatsMapArr))
			$firmsByCatsMap = implode(',',$firmsByCatsMapArr);
			else $firmsByCatsMap = '-1';
		}
		if ($firmsByCatsMap!="" && $firmsByCatsMap!="-1")  $cond .= " AND f.id IN (".$firmsByCatsMap.")";
		else $cond .= "";
	}		

	$sql="SELECT f.id as 'id', f.name as 'firm_name', f.phone as 'phone', f.address as 'address', f.email as 'email', f.manager as 'manager', l.name as 'location', lt.name as 'locType', f.registered_on as 'registered_on', f.description as 'description', f.has_pic as 'has_pic', f.is_Silver as 'silver', f.is_Gold as 'gold', f.latitude as 'latitude', f.longitude as 'longitude' FROM firms f, locations l, location_types lt WHERE f.location_id = l.id  AND l.loc_type_id = lt.id AND f.active = '1' $cond ";
	$conn->setsql($sql);
	$conn->getTableRows();
	
   $firms_onMap = Array();
   if($conn->numberrows > 0) {
      $firms_onMap = $conn->result;
      require_once("includes/classes/Firm.class.php");
      $hosp = new firm($conn);
            	
   }

$map .='
<script type = "text/javascript">

  function firms_MapOnload() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("myMap"));';
       
			if(isset($firmID)) { $map .= sprintf("map.setCenter(new GLatLng(%0.20f, %0.20f),11);", $firms_onMap[0]["latitude"], $firms_onMap[0]["longitude"]); }
			else { $map .= 'map.setCenter(new GLatLng(42.693516, 23.33246), 6);'; }
$map .='
		map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
		//map.enableScrollWheelZoom();
		
        var baseIcon = new GIcon();
        baseIcon.image = "images/icon_firms.png";
        baseIcon.shadow = "images/icon_firm_shadow.png";
        baseIcon.iconSize = new GSize(30, 30);
        baseIcon.shadowSize = new GSize(30, 30);
        baseIcon.iconAnchor = new GPoint(9, 34);
        baseIcon.infoWindowAnchor = new GPoint(19, 5);

        function createMarker(point, baloon) {
          markerOptions = { icon:baseIcon };
          var marker = new GMarker(point, markerOptions);
          GEvent.addListener(marker, "click", function() {
            marker.openInfoWindowHtml(baloon, { maxWidth: 300 });
          });
          return marker;
        }

		function createTabbedMarker(point,html1,html2,label1,label2) {
	        markerOptions = { icon:baseIcon };
	        var marker = new GMarker(point, markerOptions);
	        GEvent.addListener(marker, "click", function() {
	          marker.openInfoWindowTabsHtml([new GInfoWindowTab(label1,html1), new GInfoWindowTab(label2,html2)],{ maxWidth: 300 });
	        });
	        return marker;
	      }
		  
        var firmLocsArr = new Array();
        var bounds = new GLatLngBounds();';

           foreach($firms_onMap as $row) 
           {
           		$baloonHTML1 = "";
           		$baloonHTML2 = "";
           	
               $hosp->id = $row['id'];
			   $hosp->load();	
			   $baloonHTML = "";		  

	// ---------------------------------------- Категории -------------------------------------------------
				$sql="SELECT fc.id as 'firm_category_id', fc.name as 'firm_category_name' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id AND f.id = '".$row['id']."' ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numfirmCatsMap    = $conn->numberrows;
				$resultfirmCatsMap = $conn->result;
				$resultfirmCatsMapText = "";
				for($i=0;$i<3;$i++)
				{
					if(!empty($resultfirmCatsMap[$i]['firm_category_name']))
					$resultfirmCatsMapText[] = "<a class='homePageVIPLink' href = 'фирми-категория-".$resultfirmCatsMap[$i]['firm_category_id'].",".myTruncateToCyrilic($resultfirmCatsMap[$i]['firm_category_name'],200,'_','') .".html'>".$resultfirmCatsMap[$i]['firm_category_name']."</a>";
					//$resultfirmCatsMapText[] = $resultfirmCatsMap[$i]['firm_category_name'];
				}
				$resultfirmCatsMapText = implode("; ",$resultfirmCatsMapText);
				
					
               $picFileMap = is_file("pics/firms/".$row['id']."_logo.jpg")?("pics/firms/".$row['id']."_logo.jpg"):("pics/firms/no_logo.png");
			   $baloonHTML1 .= "<span style='float:left;margin-right:10px;'><a href = 'разгледай-фирма-".$row['id'].",".myTruncateToCyrilic($row['firm_name'],200,'_','').".html'><img src='".$picFileMap."' width='100' /></a></span>";               
		       $baloonHTML1 .= "<span style='font-size:12px;'><a class='homePageVIPLink'  href='разгледай-фирма-".$row['id'].",".myTruncateToCyrilic($row['firm_name'],200,'_','').".html'>".$row["firm_name"]."</a><br />Категории:<b> ".$resultfirmCatsMapText."</b><br /> Населено място:<b> ".$row["location"]."</b><br />Адрес:<b> ".$row["address"]."</b><br /> Телефон:<b> ".$row["phone"]."</b></span>";
               $baloonHTML2 .= "<span style='font-size:12px;'>".myTruncate($row["description"], 300, " ")."<a href = 'разгледай-фирма-".$row['id'].",".myTruncateToCyrilic($row['firm_name'],200,'_','').".html'> виж още</a></span>";
               $map .= sprintf("loc = new GLatLng(%0.20f, %0.20f);\n", $row["latitude"], $row["longitude"]);
               $map .= "bounds.extend(loc);\n";
               $map .= sprintf("firmLocsArr.push(loc);\n");
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

      firms_MapOnload();
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
 