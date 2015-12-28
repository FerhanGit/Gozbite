<?php
   class QuestionCategory {
      var $conn;
      var $id, $parentID, $name;
      var $Error;

      /*------------------ CONSTRUCTOR---------------------*/
      function QuestionCategory($conn) {
         $this->conn = $conn;
      } //CompanyCategory

      /*------------------ PREPARE AND LOAD QUERY ---------------------*/
      function prepareLoadQuery() {
         if(isset($this->id) && ($this->id > 0)) {
            $sql = sprintf("SELECT id, parentID, name FROM question_category WHERE id = %d", $this->id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }
            return true;
         } else {
            $this->Error["Application Error ClssCmpnCtgrPrprLdQry-Invalid Argument"] = "Class PostCategory: In prepareLoadQuery FIRM_CAT_ID is not present";
            return false;
         }
      }//prepareLoadQuery

      /*== LOAD COMPANY CATEGORY DATA ==*/
      function load() {
         if($this->prepareLoadQuery()) {
            $this->id         = $this->conn->result["id"];
            $this->parentID   = $this->conn->result["parentID"];
            $this->name       = $this->conn->result["name"];
         }
      } //End Load

      /*== CREATE COMPANY CATEGORY ==*/
      function create() {
         if (!isset($this->name) || strlen($this->name) == 0) {
            $this->Error["Application Error ClssCmpnCtgrCrtName-Invalid Argument"] = "Class CompanyCategory: In create NAME is not set";
            return false;
         }

         $sql = sprintf("INSERT INTO question_category (parentID, name) VALUES (%d, '%s')", $this->parentID, $this->name);
         $this->conn->setsql($sql);
         $this->id = $this->conn->insertDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssPostCtgrCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         return true;
      } //End Create

      /*== UPDATE COMPANY CATEGORY ==*/
      function update() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssCmpnCtgrUpdID-Invalid Argument"] = "Class CompanyCategory: In update FIRM_CAT_ID is not set";
            return false;
         }

         if (!isset($this->name) || (strlen($this->name) == 0)) {
            $this->Error["Application Error ClssCmpnCtgrUpdtName-Invalid Argument"] = "Class CompanyCategory: In update NAME is not set";
            return false;
         }

         $sql = sprintf("UPDATE question_category SET parentID = %d, name = '%s' WHERE id = %d", $this->parentID, $this->name, $this->id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnCtgrUpd-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         return true;
      } //End Update

      /*== DELETE COMPANY CATEGORY ==*/
      function deleteQuestionCtgr() {
         if(!isset($this->id) || ($this->id <= 0)) {
            $this->Error["Application Error ClssCmpnCtgrDltCmpnCtgrID-Invalid Argument"] = "Class CompanyCategory: In deleteCmpnCtgr FIRM_CAT_ID is not set";
            return false;
         }

         $sql = sprintf("SELECT questionID FROM questions WHERE question_category = %d", $this->id);
         $this->conn->setsql($sql);
         if($this->conn->getTableRow()) {
            $this->Error["SQL ERROR ClssCmpnCtgrDltCmpnCtgr"] = "категория не може да бъде изтрита! Има свързани с нея фирми!";
            return false;
         }

         $sql = sprintf("DELETE FROM question_category WHERE id = %d", $this->id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnCtgrDltCmpnCtgr-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         return true;
      } //End Delete
   } //Class CompanyCategory
?>