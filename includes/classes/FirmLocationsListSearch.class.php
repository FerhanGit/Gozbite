<?php
   class  FirmLocationsList {
      var $nodes = array();
      var $Error;

      function FirmLocationsList($conn) {
         $this->conn             = $conn;
      }

      
      
	function getSuccessors($locID){
	 
	
	   $a1 = Array($locID);
	
	   $sql = sprintf("select id from locations where parent_id = %d",$locID);
	   $this->conn->setsql($sql);
	
	   if($this->conn->getTableRows()){
	      foreach($this->conn->result as $id_array) $a1 = array_merge($a1, getSuccessors($id_array["id"]));
	      return $a1;
	   }
	   return $a1;
	}


       function checkLocationForCountFirms($locID)
	   {
	   	 	$sql = sprintf("SELECT COUNT(id) as 'cnt' FROM firms WHERE location_id IN (%s)", implode(',',$this->getSuccessors($locID)));
	      	$this->conn->setsql($sql);
	      	$this->conn->getTableRow();
	      	return $this->conn->result['cnt'];
	   }
   
   
      function load() {  
         $sql = "SELECT id, name, parent_id, loc_type_id FROM locations  WHERE name NOT IN ('Обиколен маршрут')  ORDER BY name";
         $this->conn->setsql($sql);
         $this->conn->getTableRows();
         if($this->error) {
            $this->Error = $this->conn->error; 
            return false;
         } else {
            if($this->conn->numberrows > 0) { 
               for($i = 0; $i < $this->conn->numberrows; $i++){
               	
//               	  if($this->checkLocationForCountFirms($this->conn->result[$i]["id"]) < 1) continue;
               	
                  $this->nodes[$this->conn->result[$i]["parent_id"]][$this->conn->result[$i]["id"]]["id"]         = $this->conn->result[$i]["id"];
                  $this->nodes[$this->conn->result[$i]["parent_id"]][$this->conn->result[$i]["id"]]["name"]       = $this->conn->result[$i]["name"];
                  $this->nodes[$this->conn->result[$i]["parent_id"]][$this->conn->result[$i]["id"]]["parent_id"]  = $this->conn->result[$i]["parent_id"];
                  $this->nodes[$this->conn->result[$i]["parent_id"]][$this->conn->result[$i]["id"]]["loc_type_id"]= $this->conn->result[$i]["loc_type_id"];
               }
            }
            return true;
         }
         
      }

      function showlist($parent) {
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])){
               print "<tr>\n";
               printf(" <td%s><a href = \"edit_firm_category.php?fcID=%d\"><img src = \"images/page_white_edit.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Редактиране наименованието на категория\" align = \"absmiddle\"></a>\n<a href = \"javascript: document.searchform.submit();\" onclick = \"if(confirm('Сигурни ли сте?')) { document.searchform.fcID.value=%d; document.searchform.ActionFirmCtgr.value=1; return true; } else { return false; }\"><img src = \"images/page_white_delete.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изтриване на категория\" align = \"absmiddle\"></a>\n<b>%s</b></td>\n", (($this->nodes[$parent][$id]["parent_id"] > 0) ? " style = \"padding-left: 30px;\"" : ""), $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["id"], $this->nodes[$parent][$id]["name"]);
               print "</tr>\n";
               $this->showlist($id);
            }
            
         }
      } //showlist

      function showselectlist($parent, $indenter, $nid) {
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])){
				if(($this->checkLocationForCountFirms($this->nodes[$parent][$id]["id"]) < 1) OR ($this->nodes[$parent][$id]["name"] == 'Обиколен маршрут')) continue;
            	$return .= sprintf(" <option value = \"%d\" %s>%s&nbsp; %s %s</option>", $this->nodes[$parent][$id]["id"], (($this->nodes[$parent][$id]["id"] == $nid) ? " selected" : ""), $indenter, (($this->nodes[$parent][$id]["loc_type_id"] == 1) ? "област " : (($this->nodes[$parent][$id]["loc_type_id"] == 10) ? "община " : (($this->nodes[$parent][$id]["loc_type_id"] == 11) ? "кметство " : ""))), $this->nodes[$parent][$id]["name"]);
                $return .= $this->showselectlist($id, $indenter."-----", $nid);
            }
            
         }
         return $return;
      } //showselectlist

      function showSelectMultipleList($parent, $indenter, $arr) {
         if(is_array($this->nodes[$parent])) {
            for(reset($this->nodes[$parent]); $id = key($this->nodes[$parent]); next($this->nodes[$parent])){
               $return .= sprintf(" <option value = \"%d\"%s>%s&nbsp;%s</option>", $this->nodes[$parent][$id]["id"], ((in_array($this->nodes[$parent][$id]["id"], $arr)) ? " selected" : ""), $indenter, $this->nodes[$parent][$id]["name"]);
               $return .= $this->showSelectMultipleList($id, $indenter."-----", $arr);
            }
         }
         return $return;
      } //showselectlist
   }
 
?>