<?php
   class  HotelLocationsList {
      var $nodes = array();
      var $Error;

      function HotelLocationsList($conn) {
         $this->conn             = $conn;
      }

      function load() {  
         $sql = "SELECT id, name, parent_id , loc_type_id FROM locations WHERE name NOT IN ('Обиколен маршрут')  ORDER BY id";
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
                  $this->nodes[$this->conn->result[$i]["parent_id"]][$this->conn->result[$i]["id"]]["loc_type_id"]  = $this->conn->result[$i]["loc_type_id"];
               }
            }
            return true;
         }
         
      }

      function showlist($parent) {
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])){
               print "<tr>\n";
               printf(" <td%s><a href = \"edit_hotel_category.php?hcID=%d\"><img src = \"images/page_white_edit.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Редактиране наименованието на категория\" align = \"absmiddle\"></a>\n<a href = \"javascript: document.searchform.submit();\" onclick = \"if(confirm('Сигурни ли сте?')) { document.searchform.hcID.value=%d; document.searchform.ActionHotelCtgr.value=1; return true; } else { return false; }\"><img src = \"images/page_white_delete.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изтриване на категория\" align = \"absmiddle\"></a>\n<b>%s</b></td>\n", (($this->nodes[$parent][$id]["parent_id"] > 0) ? " style = \"padding-left: 30px;\"" : ""), $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["name"]);
               print "</tr>\n";
               $this->showlist($id);
            }
            
         }
      } //showlist

      function showselectlist($parent, $indenter, $nid) {
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])){
              if($this->nodes[$parent][$id]["id"] == 14880) continue;
			  	$return .= sprintf(" <option value = \"%d\"%s %s>%s&nbsp; %s %s</option>", $this->nodes[$parent][$id]["id"], (($this->nodes[$parent][$id]["id"] == $nid) ? " selected" : ""), (in_array($this->nodes[$parent][$id]["loc_type_id"], array(1, 18, 10, 11)) ? " DISABLED" : ""), $indenter, (($this->nodes[$parent][$id]["loc_type_id"] == 1) ? "област " : (($this->nodes[$parent][$id]["loc_type_id"] == 10) ? "община " : (($this->nodes[$parent][$id]["loc_type_id"] == 11) ? "кметство " : ""))), $this->nodes[$parent][$id]["name"]);
               	$return .= $this->showselectlist($id, $indenter."-----", $nid);
            }
            
         }
          return $return;
      } //showselectlist

      function showSelectMultipleList($parent, $indenter, $arr) {
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])){
               	$return .= sprintf(" <option value = \"%d\"%s>%s&nbsp;%s</option>", $this->nodes[$parent][$id]["id"], ((in_array($this->nodes[$parent][$id]["id"], $arr)) ? " selected" : ""), $indenter, $this->nodes[$parent][$id]["name"]);
                $return .=$this->showSelectMultipleList($id, $indenter."-----", $arr);
            }
         }
          return $return;
      } //showselectlist
   }
 
?>