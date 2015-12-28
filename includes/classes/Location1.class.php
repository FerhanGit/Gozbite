<?php
   class Location {
      var $conn;
      var $id, $name, $parentID, $loctypeID, $parentName, $centerX, $centerY;
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Location($conn, $parent_id = 0, $id = 0, $locType = 0, $name = '', $centerX = 0, $centerY = 0) {
         $this->conn = $conn;
         $this->id         = $id;
         $this->parentID   = $parent_id;
         $this->name       = $name;
         $this->loctypeID  = $locType;
         $this->centerX    = $centerX;
         $this->centerY    = $centerY;
      } //Location

      /*== PREPARE AND LOAD QUERY ==*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) {
            $sql = sprintf("SELECT q.id, q.name, q.loc_type_id, q.parent_id, lt.name  loctypeName
                            FROM locations q JOIN location_types lt ON q.loc_type_id = lt.id
                            WHERE q.id = %d", $this->id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }
            return true;
         } else {
            $this->Error["Application Error ClssLctnPrprLdQry-Invalid Argument"] = "Class Location: In prepareLoadQuery Location_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD URBAN AREA DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
            $this->id         = $this->conn->result["id"];
            $this->name       = $this->conn->result["name"];
            $this->loctypeID  = $this->conn->result["loc_type_id"];
            $this->parentID   = $this->conn->result["parent_id"];
         }
      } //End Load

      /*== CREATE Location ==*/
      function create() {
         if (!isset($this->parentID) || ($this->parentID < 0)) {
            $this->Error["Application Error ClssLctnCrtCtID-Invalid Argument"] = "Class Location: In create PARENT_ID is not set";
            return false;
         }

         if (!isset($this->name) || (strlen($this->name) == 0)) {
            $this->Error["Application Error ClssLctnCrtName-Invalid Argument"] = "Class Location: In create NAME is not set";
            return false;
         }

         $sql = sprintf("INSERT INTO locations (name, parent_id, loc_type_id) VALUES ('%s', %d, %d)", $this->name, $this->parentID, $this->loctypeID);
         $this->conn->setsql($sql);
         $this->id = $this->conn->insertDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssLctnCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         return true;
      } //End Create

      /*== UPDATE Location ==*/
      function update() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssLctnUpdtID-Invalid Argument"] = "Class Location: In update Location_ID is not set";
            return false;
         }

         if (!isset($this->name) || (strlen($this->name) == 0)) {
            $this->Error["Application Error ClssLctnUpdtName-Invalid Argument"] = "Class Location: In update NAME is not set";
            return false;
         }

         $sql = sprintf("UPDATE locations SET name = '%s', parent_id = %d, loc_type_id = %d WHERE id = %d", $this->name, $this->parentID, $this->loctypeID, $this->id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssLctnUpdt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         return true;
      } //End Update

      /*== DELETE Location ==*/
      function deleteLctn() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssLctnDltLctnID-Invalid Argument"] = "Class Location: In deleteLctn Location_ID is not set";
            return false;
         }

         $sql = sprintf("SELECT id FROM locations WHERE parent_id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->getTableRow();
         if($conn->result["id"] > 0) {
            $this->Error["Application Error ClssLctnDltLctn-Invalid Operation"] = "Class Location: In deleteLctn -> Локацията не може да бъде изтрита, защото има подлокации!";
            return false;
         }

         $sql = sprintf("DELETE FROM locations WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssLctnDltLctn-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         return true;
      } //End deleteLctn
   } //Class Location
?>