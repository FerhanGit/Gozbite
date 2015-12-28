<?php
   class  OfferCategoriesList {
      var $nodes = array();
      var $Error;

      function OfferCategoriesList($conn) {
         $this->conn             = $conn;
      }

      function load() {
         $sql = "SELECT id, name, parentID FROM offer_category ORDER BY id";
         $this->conn->setsql($sql);
         $this->conn->getTableRows();
         if($this->error) {
            $this->Error = $this->conn->error;
            return false;
         } else {
            if($this->conn->numberrows > 0) {
               for($i = 0; $i < $this->conn->numberrows; $i++){
                  $this->nodes[$this->conn->result[$i]["parentID"]][$this->conn->result[$i]["id"]]["id"]         = $this->conn->result[$i]["id"];
                  $this->nodes[$this->conn->result[$i]["parentID"]][$this->conn->result[$i]["id"]]["name"]       = $this->conn->result[$i]["name"];
                  $this->nodes[$this->conn->result[$i]["parentID"]][$this->conn->result[$i]["id"]]["parentID"]  = $this->conn->result[$i]["parentID"];
               }
            }
            return true;
         }
         
      }

      function showlist($parent) {
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])){
               print "<tr>\n";
               printf(" <td%s><a href = \"edit_offer_category.php?ocID=%d\"><img src = \"images/page_white_edit.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Редактиране наименованието на категория\" align = \"absmiddle\"></a>\n<a href = \"javascript: document.searchform.submit();\" onclick = \"if(confirm('Сигурни ли сте?')) { document.searchform.ocID.value=%d; document.searchform.ActionOfferCtgr.value=1; return true; } else { return false; }\"><img src = \"images/page_white_delete.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изтриване на категория\" align = \"absmiddle\"></a>\n<b>%s</b></td>\n", (($this->nodes[$parent][$id]["parentID"] > 0) ? " style = \"padding-left: 30px;\"" : ""), $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["name"]);
               print "</tr>\n";
               $this->showlist($id);
            }
            
         }
      } //showlist

      function showselectlist($parent, $indenter, $nid) {
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])){
               printf(" <option value = \"%d\"%s>%s&nbsp;%s</option>", $this->nodes[$parent][$id]["id"], (($this->nodes[$parent][$id]["id"] == $nid) ? " selected" : ""), $indenter, $this->nodes[$parent][$id]["name"]);
               $this->showselectlist($id, $indenter."-----", $nid);
            }
         }
      } //showselectlist

      function showSelectMultipleList($parent, $indenter, $arr) {
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])){
               printf(" <option value = \"%d\"%s>%s&nbsp;%s</option>", $this->nodes[$parent][$id]["id"], ((in_array($this->nodes[$parent][$id]["id"], $arr)) ? " selected" : ""), $indenter, $this->nodes[$parent][$id]["name"]);
               $this->showSelectMultipleList($id, $indenter."-----", $arr);
            }
         }
      } //showselectlist
   }
?>