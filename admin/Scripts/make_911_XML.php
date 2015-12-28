<?php 
	
   
   class mysqldb {
      //properties
      var $dbhost;
      var $db;
      var $dbuser;
      var $dbpassword;
      var $sql;
      var $stmt;
      var $numberrows;
      var $dbopenstatus;
      var $dbconnection;
      var $error;
         
      //---------------------------------------
      function setsql($req_sql) {
         $this->stmt = 0;
         $this->sql = $req_sql;
      }

      //---------------------------------------
      function getnumberrows() {
         return $this->numberrows;
      }

      //---------------------------------------
      //object constructor
      function mysqldb($host="localhost", $db="largo", $webuser="largo", $webpassword="l@rg0") {
         $this->dbhost=$host;
         $this->db=$db;
         $this->dbuser=$webuser;
         $this->dbpassword=$webpassword;
         $this->opendbconnection();
      }

      //---------------------------------------
      function opendbconnection() {
         if ($this->dbconnection = @mysql_connect ("$this->dbhost","$this->dbuser","$this->dbpassword")) {
            mysql_query("SET NAMES utf8");
            mysql_select_db($this->db);
            return true;
         } else {
            $this->error['connect'] = "Няма достъп до базата!";
          //  reportSqlErr("No connection to database");
            return false;
         }
      }

      //-----------------------------------
      function getAffectedRows() {
         return mysql_affected_rows();
      }

      //---------------------------------------
      function insertDB() {
         if (!$this->dbconnection) {
            $this->opendbconnection();
         }
        
         if(!strlen(trim($this->sql))) {
            $this->error['EmptyQuery-insertDB'] = "Не е подадена заявка към функцията insertDB";
           // reportSqlErr("SQL Error [insertDB] -> Empty Query in function insertDB()");
            return false;
         }
         
         mysql_query($this->sql, $this->dbconnection);
         
         if(mysql_errno()) {
            $this->error[mysql_errno()] = "Грешна заявка: ".$this->sql."<br>".mysql_error();
            if(mysql_errno() != 1062)
             //  reportSqlErr("SQL Error [insertDB] -> ".mysql_error()."<br> while execute \"".$this->sql."\"");
            return false;
         }

         return mysql_insert_id($this->dbconnection);
      }

      //---------------------------------------      
      function closedbconnection() {
         if ($this->dbconnection) {
            mysql_close($this->dbconnection);
         }
      }

      //---------------------------------------      
      function getTableRow() {

         if (!$this->dbconnection) {
            $this->opendbconnection();
         }

         if(!strlen(trim($this->sql))) {
            $this->error['emptyQuery - getTableRow'] = "Не е подадена заявка към функцията getTableRow";
          //  reportSqlErr("SQL Error [getTableRow] -> Empty Query in function getTableRow()");
            return false;
         }

         unset($this->result);
         unset($this->numberrows);
      
         $qry = mysql_query($this->sql);
         if (!$qry) {
            $this->error[mysql_errno()] = "Грешна заявка: ".$this->sql."<br>".mysql_error();
           // reportSqlErr("SQL Error [getTableRow] -> ".mysql_error()."<br> while execute \"".$this->sql."\"");
            return false;
         } else {
            $this->numberrows = mysql_num_rows($qry);
            if ($this->numberrows > 0) {
               $this->result = mysql_fetch_array($qry); 
               return true;
            } else {
               return false;
            }
            return true;
         }
      }
      //---------------------------------------      

	  function getStmt() {

         if (!$this->dbconnection) {
            $this->opendbconnection();
         }

         if(!strlen(trim($this->sql))) {
            $this->error['emptyQuery - getTableRow'] = "Не е подадена заявка към функцията getTableRow";
           // reportSqlErr("SQL Error [getTableRow] -> Empty Query in function getTableRow()");
            return false;
         }
      
         $qry = mysql_query($this->sql, $this->dbconnection);

         if (!$qry) {
            $this->error[mysql_errno()] = "Грешна заявка: ".$this->sql."<br>".mysql_error();
           // reportSqlErr("SQL Error [getStmt] -> ".mysql_error()."<br> while trying \"".$this->sql."\"");
            return false;
         }
         $this->stmt = $qry;
         $this->numberrows = mysql_num_rows($this->stmt);

         return true;
      }

      //---------------------------------------     
      function getTableRows() {

         if (!$this->dbconnection) {
            $this->opendbconnection();
         }

         if(!strlen(trim($this->sql))) {
            $this->error['emptyQuery - getTableRows'] = "Не е подадена заявка към функцията getTableRows";
           // reportSqlErr("SQL Error [getTableRows] -> Empty Query in function getTableRows()");
            return false;
         }
      
         unset($this->result);
         unset($this->numberrows);
      
         $qry = mysql_query($this->sql);
         if (!$qry) {
            $this->error[mysql_errno()] = "Грешна заявка: ".$this->sql."<br>".mysql_error();
          //  reportSqlErr("SQL Error [getTableRows] ->".mysql_error()."<br> while execute \"".$this->sql."\"");
            return false;
         } else {
            $this->numberrows = mysql_num_rows($qry);
            if ($this->numberrows >0) {
               for ($i = 0; $i < $this->numberrows; $i++) {
                  $this->result[$i] = mysql_fetch_array($qry);
               }
               return true;
            } else {
               return false;
            }
            return true;
         }
      }

      //---------------------------------------     

      function fetch() {

			if(!$this->stmt) $this->getStmt();

			if(!$this->stmt) { 
				$this->error[mysql_errno()] = "Invalid SQL Stmt: ".$this->sql."<br>".mysql_error();
			//	reportSqlErr("SQL Error [fetch] ->".mysql_error()."<br> while execute \"".$this->sql."\"");
				return false;
			}

			 return ($this->result = mysql_fetch_array($this->stmt)); 
      }

	  //---------------------------------------     

      function getValueFromDB($sql) {

//validity check necessary here			
			$this->sql = $sql;
			$this->fetch();

			 return $this->result[0];
      }

      //---------------------------------------   

      function UpdateDB () {
         if (!$this->dbconnection) {
            $this->opendbconnection();
         }
      
         if(!strlen(trim($this->sql))) {
            $this->error['emptyQuery - UpdateDB'] = "Не е подадена заявка към функцията UpdateDB";
          //  reportSqlErr("SQL Error [UpdateDB] -> Empty Query in function UpdateDB()");
            return false;
         }
      
         if(!mysql_query($this->sql)){ 
            $this->error[mysql_errno()] = "Грешна заявка: ".$this->sql."<br>".mysql_errno();
            if(mysql_errno()!=1062)
            //   reportSqlErr("SQL Error [UpdateDB] -> ".mysql_error()."<br> while execute \"".$this->sql."\"");
            return false;
         } else
            return true;
      }

      //---------------------------------------

      function LastInsID() {
         if (!$this->dbconnection) {
            $this->opendbconnection();
         }
         $lastInsID = mysql_insert_id($this->dbconnection);
         
         return $lastInsID;
      }
      
      //---------------------------------------
      function getErrors() {
         if(is_array($this->error)) {
            for(reset ($this->error); $key = key($this->error); next($this->error))
               $errorStr .= "<div style = \"font-family: Verdana, Helvetica, sans-serif; font-size: 11px; color: #ca0000;\">".$this->error[$key]."</div>\n";
         }
         return $errorStr;
      }

   } //END of Class MYSQLDB
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
	$conn =  new mysqldb();							    
	
	
	$xml='<?xml version="1.0" encoding="UTF-8"?>
<offers>';
// -------------------------------- SELECT na vsi4ki Oferti ---------------------------------------	
	$sql="SELECT * from offers ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$result=$conn->result;
	$nums=$conn->numberrows;	
	
	
	
	
// ------------------------------------------------------------------------------------------------		

	for ($i=0;$i<$nums;$i++)
	{
		
// --------------------------------- Offer-TAG ---------------------------------------------------
		$xml.='<offer>';
// ------------------------------------------------------------------------------------------------			
		
// ------------------------------------- ID-Tag ---------------------------------------------------			
		$xml.='<id>'.$result[$i]["id"].'</id>';
		
// ------------------------------------------------------------------------------------------------			
		
// -------------------------------------- Estate_Type-TAG -----------------------------------------			
		
		$sql="SELECT type_bul FROM types where id='".$result[$i]['type_id']."'";
		$conn->setsql($sql);
		$conn->getTableRow();
		$result1=$conn->result;
		$xml.='<estate_type>'.$result1["type_bul"].'</estate_type>';	


		
// ------------------------------------------------------------------------------------------------			
		
// --------------------------------------- Region-TAG ---------------------------------------------			
	
		$sql="SELECT region_bul FROM  regions where id='".$result[$i]['region_id']."'";
		$conn->setsql($sql);
		$conn->getTableRow();
		$result2=$conn->result;
		$xml.='<region>'.$result2["region_bul"].'</region>';	
// ------------------------------------------------------------------------------------------------			
		
// ----------------------------------------- Price-TAG --------------------------------------------				
		$xml.='<price currency="EUR">'.$result[$i]['price'].'</price>';	
		
// ------------------------------------------------------------------------------------------------			
		
// ------------------------------------------ Sqm-TAG ---------------------------------------------
		$xml.='<sqm>'.$result[$i]['area'].'</sqm>';	
		
// ------------------------------------------------------------------------------------------------				
		
// ------------------------------------------- Publish_Date-TAG -----------------------------------			
		$xml.='<publish_date>'.$result[$i]['created_on'].'</publish_date>';	
		
// ------------------------------------------------------------------------------------------------			
		
// --------------------------------------------- Images-TAG ----------------------------------------			
		$xml.='<images>';	
		$sql="SELECT file_name FROM prop_pictures where property_id='".$result[$i]['id']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$result_pics=$conn->result;
		$num2=$conn->numberrows;
// ------------------------------------------------------------------------------------------------	

		for ($k=0;$k<$num2;$k++)
		{

// ---------------------------------------------- Image-TAG ----------------------------------------	
			$xml.='<image>'.$result_pics[$k]['file_name'].'</image>';	
			
		}
// ------------------------------------------------------------------------------------------------			
		
		$xml.='</images>';	
	
// ----------------------------------------------- Description-TAG --------------------------------				
			$xml.='<description>'.$result[$i]['descr_bul'].'</description>';	
		
// ------------------------------------------------------------------------------------------------	
			
			$xml.='</offer>';
	}
	$xml.='</offers>';
	
	
	header('Content-Type: application/xml');
	
	print $xml;
	
	?>