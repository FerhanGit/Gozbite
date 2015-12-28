<?php
   class  LocationsList {
      var $nodes = array();
      var $Error;

      function LocationsList($conn) {
         $this->conn             = $conn;
      }

      function load() {
         $sql = "SELECT l.id, l.name, l.parent_id, lt.name AS location_type_name
                 FROM locations l JOIN location_types lt ON l.loc_type_id = lt.id
                 ORDER BY  lt.name ,l.name ";
         $this->conn->setsql($sql);
         $this->conn->getTableRows();
         if($this->error) {
            $this->Error = $this->conn->error;
            return false;
         } else {
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++){
                  $this->nodes[$this->conn->result[$i]["parent_id"]][$this->conn->result[$i]["id"]]["id"]         = $this->conn->result[$i]["id"];
                  $this->nodes[$this->conn->result[$i]["parent_id"]][$this->conn->result[$i]["id"]]["name"]       = $this->conn->result[$i]["name"];
                  $this->nodes[$this->conn->result[$i]["parent_id"]][$this->conn->result[$i]["id"]]["parent_id"]  = $this->conn->result[$i]["parent_id"];
                  $this->nodes[$this->conn->result[$i]["parent_id"]][$this->conn->result[$i]["id"]]["location_type_name"]  = $this->conn->result[$i]["location_type_name"];
               }
            }
            return true;
         }
         
      }

      function drawMainLocations($parent) {
         print "<div id = \"MDME\" style = \"margin-top: 10px;\">\n";
         print "  <ul>\n";
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])) {
               printf("    <li id = \"lID%d\"><a href = \"edit_location.php?LocationID=%d\"><img src = \"images/page_white_edit.png\" width = \"16\" height = \"16\" alt = \"Редактиране на локацията\" /></a><a href = \"edit_location.php?parent_id=%d\"><img src = \"images/add.png\" width = \"16\" height = \"16\" alt = \"Добавяне на подлокация\" /></a><a href = \"loc.php?locationID=%d\">%s %s</a>\n", $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["location_type_name"], $this->nodes[$parent][$id]["name"]);
               $this->drawChildLocations($id);
               print "     </li>\n";
            }
         }
         print "  </ul>\n";
         print "</div>\n";
      }

      function drawChildLocations($parent) {
         if(is_array($this->nodes[$parent])) {
            print "  <ul>\n";
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])) {
               printf("    <li id = \"lID%d\"><a href = \"edit_location.php?LocationID=%d\"><img src = \"images/page_white_edit.png\" width = \"16\" height = \"16\" alt = \"Редактиране на локацията\" /></a><a href = \"javascript: document.itemform.submit();\" onclick = \"if(confirm('Сигурни ли сте, че искате да изтриете локацията?')) { document.itemform.lctnID.value = %d; document.itemform.ActionLctn.value = 1; return true; } else { return false; }\"><img src = \"images/page_white_delete.png\" width = \"16\" height = \"16\" alt = \"Изтриване на локацията\" /></a><a href = \"edit_location.php?parent_id=%d\"><img src = \"images/add.png\" width = \"16\" height = \"16\" alt = \"Добавяне на подлокация\" /></a><a href = \"loc.php?locationID=%d\">%s %s</a>\n", $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["location_type_name"], $this->nodes[$parent][$id]["name"]);
               $this->drawChildLocations($id);
               print "     </li>\n";
            }
            print "  </ul>\n";
         }
      }

      function showMainLocations($parent) {
         print "<div id = \"MDME\" style = \"margin-top: 10px;\">\n";
         print "  <ul>\n";
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])) {
               printf("    <li><a href = \"javascript://\" onclick = \"opener.document.itemform.locationID.value = %d; opener.document.itemform.lctnStrng.value = '%s'; window.self.close();\"><img src = \"images/accept.png\" width = \"16\" height = \"16\" alt = \"Избор на локацията\" /></a><a href = \"loc.php?locationID=%d\">%s %s</a>\n", $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["location_type_name"]." ".$this->nodes[$parent][$id]["name"],  $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["location_type_name"], $this->nodes[$parent][$id]["name"]);
               $this->showChildLocations($id);
               print "     </li>\n";
            }
         }
         print "  </ul>\n";
         print "</div>\n";
      }

      function showChildLocations($parent) {
         if(is_array($this->nodes[$parent])) {
            print "  <ul>\n";
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])) {
               printf("    <li><a href = \"javascript://\" onclick = \"opener.document.itemform.locationID.value = %d; opener.document.itemform.lctnStrng.value = '%s'; window.self.close();\"><img src = \"images/accept.png\" width = \"16\" height = \"16\" alt = \"Избор на локацията\" /></a><a href = \"loc.php?locationID=%d\">%s %s</a>\n", $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["location_type_name"]." ".$this->nodes[$parent][$id]["name"],  $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["location_type_name"], $this->nodes[$parent][$id]["name"]);
               $this->showChildLocations($id);
               print "     </li>\n";
            }
            print "  </ul>\n";
         }
      }
   }
?>