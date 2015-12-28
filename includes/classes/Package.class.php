<?php
   class Package {
      var $conn;
      var $id;
      var $package_id;
      var $supplement_id;
      var $in_package;
      var $with_package;
      var $value;
      var $description;
      var $package;
      var $price_per_month;
      var $price_per_year;
      var $package_name;
      var $is_agency_or_builder;
      var $supplement_name;
      var $supplement_price;
      var $supplement;
	  var $PackageSupplementsRow;	 
	  var $AdditionalSupplementsRow; 
      var $Error;

      /*== CONSTRUCTOR ==*/
      function Package($conn) {
         $this->conn = $conn;
         
         
      } //Company

      /*== PREPARE AND LOAD QUERY ==*/
      function getSupplements($package_id) {  // ------------ Tova zarejda sastavkite na daden paket --------------
         if(isset($package_id) && ($package_id > 0)) {
            $sql = sprintf("SELECT psn.id as 'id', psn.package_id as 'package_id', psn.suplement_id as 'suplement_id', psn.value as 'value', sn.name as 'supplement', pn.name as 'package', pn.price_per_month as 'price_per_month' , pn.price_per_year as 'price_per_year', sn.description as 'description' FROM packages_supliments_new psn, packages_new pn, supplements_new sn WHERE psn.package_id=pn.id AND psn.suplement_id=sn.id AND psn.package_id = %d", $package_id);
            $this->conn->setsql($sql);
            $this->conn->getTableRows();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            
            $this->PackageSupplementsRow = $this->conn->result;
           
            
            return true;
         } else {
            $this->Error["Application Error ClssCmpnPrprLdQry-Invalid Argument"] = "Class CompanyOffice: In prepareLoadQuery Office_id is not present";
            return false;
         }
      }//prepareLoadQuery
      
      
      
       function getPackageName($package_id) {
         if(isset($package_id) && ($package_id > 0)) {
            $sql = sprintf("SELECT id, name FROM packages_new WHERE id = %d ", $package_id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

           return   $this->conn->result['name'];
            
          
            
         } else {
            $this->Error["Application Error ClssCmpnPrprLdQry-Invalid Argument"] = "Class CompanyOffice: In prepareLoadQuery Office_id is not present";
            return false;
         }
      }//prepareLoadQuery
      
      
      
      function getPackagePrice($package_id,$per_what) {
         if(isset($package_id) && ($package_id > 0)) {
         	
         	$price=($per_what=='per_month')?"price_per_month":"price_per_year";
         	
            $sql = sprintf("SELECT %s as 'price' FROM packages_new WHERE id = %d", $price , $package_id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            
           return   $this->conn->result['price'];
            
          
            
         } else {
            $this->Error["Application Error ClssCmpnPrprLdQry-Invalid Argument"] = "Class CompanyOffice: In prepareLoadQuery Office_id is not present";
            return false;
         }
      }//prepareLoadQuery
      
      
      function getSupplemetPrice($package_id,$suplement_id) {
         if(isset($package_id) && ($package_id > 0)) {
         	
         	
         	
            $sql = sprintf("SELECT price FROM supplements_new WHERE with_package = %d AND id = %d", $package_id, $suplement_id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

           return   $this->conn->result['price'];
            
          
            
         } else {
            $this->Error["Application Error ClssCmpnPrprLdQry-Invalid Argument"] = "Class CompanyOffice: In prepareLoadQuery Office_id is not present";
            return false;
         }
      }//prepareLoadQuery
      
      
      
      function getSupplementValue($package_id,$suplement_id) {
         if(isset($package_id) && ($package_id > 0)) {
            $sql = sprintf("SELECT value FROM packages_supliments_new WHERE package_id = %d AND suplement_id = %d ", $package_id, $suplement_id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

                      
            return  $this->conn->result['value'];
            
         } else {
            $this->Error["Application Error ClssCmpnPrprLdQry-Invalid Argument"] = "Class CompanyOffice: In prepareLoadQuery Office_id is not present";
            return false;
         }
      }//prepareLoadQuery
      
      
      
       function getAdditionalSupplements($package_id) {
         if(isset($package_id) && ($package_id > 0)) {
            $sql = sprintf("SELECT id, name, description, price FROM supplements_new WHERE in_package=0 AND with_package = %d ", $package_id);
            $this->conn->setsql($sql);
            $this->conn->getTableRows();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

            $this->AdditionalSupplementsRow =  $this->conn->result;
            
            
            return true;  
            
         } else {
            $this->Error["Application Error ClssCmpnPrprLdQry-Invalid Argument"] = "Class CompanyOffice: In prepareLoadQuery Office_id is not present";
            return false;
         }
      }//prepareLoadQuery
      
      
     
      
      
      function getSupplementDescription($package_id,$supp_ID) {
         if(isset($package_id) && ($package_id > 0) && ($supp_ID>0)) {
         	
         	
	        $sql = sprintf("SELECT description FROM supplements_new WHERE id = %d AND with_package= %d ", $supp_ID, $package_id);
	        $this->conn->setsql($sql);
	        $this->conn->getTableRow();
	        if ($this->conn->error) {
	           $this->Error = $this->conn->error;
	           return false;
	        }
	
	        return $this->conn->result['description'];
	                	
         	
         } else {
            $this->Error["Application Error ClssCmpnPrprLdQry-Invalid Argument"] = "Class CompanyOffice: In prepareLoadQuery Office_id is not present";
            return false;
         }
      }//prepareLoadQuery
      
      
           

      /*== LOAD PACKAGE DATA ==*/
      function loadPackage() { 

      if(isset($this->package_id) && ($this->package_id > 0)) {
            $sql = sprintf("SELECT id, name, price_per_month, price_per_year, is_agency_or_builder FROM packages_new WHERE id = %d ", $this->package_id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

           $this->package_id 			=   $this->conn->result['id'];
           $this->package_name 			=   $this->conn->result['name'];
           $this->price_per_month 		=   $this->conn->result['price_per_month'];
           $this->price_per_year 		=   $this->conn->result['price_per_year'];
           $this->is_agency_or_builder  =   $this->conn->result['is_agency_or_builder'];
            
          
            
         } else {
            $this->Error["Application Error ClssCmpnPrprLdQry-Invalid Argument"] = "Class CompanyOffice: In prepareLoadQuery Office_id is not present";
            return false;
         }
		 
      } //End Load

      /*== CREATE PACKAGE ==*/
      function createPackage() {

         $sql = sprintf("INSERT INTO packages_new (name,
         										price_per_month,
         										price_per_year,
         										is_agency_or_builder	
         									) VALUES ('%s',
         									'%s',
         									'%s',
         									%d 
                                            )",
         										$this->package_name,
         										$this->price_per_month,
         										$this->price_per_year,
         										$this->is_agency_or_builder         										
         									);
         $this->conn->setsql($sql);
         $this->package_id = $this->conn->insertDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
          $sql = sprintf("SELECT id FROM supplements_new WHERE in_package = 1 AND is_agency_or_builder = %d ", $this->is_agency_or_builder);
          $this->conn->setsql($sql);
          $this->conn->getTableRows();
          if($this->conn->numberrows > 0 && $this->package_id > 0)
          {
          	for ($n=0;$n<$this->conn->numberrows;$n++)
          	{
		          $sql = sprintf("INSERT INTO packages_supliments_new (package_id,
		          									 	suplement_id,
		          									 	value         										
		         									) VALUES (%d,
		         									%d,
		         									'%s'
		                                            )",
		         										$this->package_id,
		         										$this->conn->result[$n]['id'],
		         										'0'       										
		         									);
		         $this->conn->setsql($sql);
		         $this->conn->insertDB();
		
		         if($this->conn->error) {
		            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
		               $this->Error["SQL ERROR ClssCmpnCrt-".$key] = $this->conn->error[$key];
		            }
		            return false;
		         }
	         
          	}
          	
          }

          
          
          
         return true;
      } //End Create
      
      
      /*== UPDATE PACKAGE ==*/
      function updatePackage() {

         $sql = sprintf("UPDATE packages_new SET name = '%s',
         										price_per_month = '%s',
         										price_per_year = '%s',
         										is_agency_or_builder = %d
         										WHERE id = %d	
         									",
         										$this->package_name,
         										$this->price_per_month,
         										$this->price_per_year,
         										$this->is_agency_or_builder,
         										$this->package_id         										
         									);
         $this->conn->setsql($sql);
         $this->conn->updateDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
         

         return true;
      } //End Create
      
      
      
      
      
      
      /*== UPDATE PACKAGE ==*/
      function updateSupplement() {

           $sql = sprintf("UPDATE supplements_new SET name = '%s' ,
         										description = '%s',
         										is_agency_or_builder = %d,
         										in_package = %d,
         										with_package = %d,
         										price ='%s'
         										WHERE id = %d		
         										",
         										$this->supplement_name,
         										$this->description,
         										$this->is_agency_or_builder,
         										$this->in_package,
         										$this->with_package,
         										$this->supplement_price ,
         										$this->supplement_id        										
         									);
         $this->conn->setsql($sql);
         $this->conn->updateDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
         

         return true;
      } //End Create
      
      
      
      
      
      
      
        /*== LOAD PACKAGE DATA ==*/
      function loadSupplement() { 

      if(isset($this->supplement_id) && ($this->supplement_id > 0)) {
            $sql = sprintf("SELECT id, name, description, is_agency_or_builder, in_package,	with_package, price FROM supplements_new WHERE id = %d ", $this->supplement_id);
            $this->conn->setsql($sql);
            $this->conn->getTableRow();
            if ($this->conn->error) {
               $this->Error = $this->conn->error;
               return false;
            }

           $this->supplement_id 		=   $this->conn->result['id'];
           $this->supplement_name 		=   $this->conn->result['name'];
           $this->description 			=   $this->conn->result['description'];
           $this->in_package 			=   $this->conn->result['in_package'];           
           $this->with_package 			=   $this->conn->result['with_package'];
           $this->supplement_price 		=   $this->conn->result['price'];           
           $this->is_agency_or_builder  =   $this->conn->result['is_agency_or_builder'];
            
          
            
         } else {
            $this->Error["Application Error ClssCmpnPrprLdQry-Invalid Argument"] = "Class CompanyOffice: In prepareLoadQuery Office_id is not present";
            return false;
         }
		 
      } //End Load

      
      
      
      
      
      
      
      /*== CREATE SUPPLEMENT ==*/
      function createSupplement() {

    	 	 	 	
         $sql = sprintf("INSERT INTO supplements_new (name,
         										description,
         										is_agency_or_builder,
         										in_package,
         										with_package,
         										price	
         									) VALUES ('%s',
         									'%s',
         									%d,
         									%d,
         									%d,
         									'%s' 
                                            )",
         										$this->supplement_name,
         										$this->description,
         										$this->is_agency_or_builder,
         										$this->in_package,
         										$this->with_package,
         										$this->supplement_price         										
         									);
         $this->conn->setsql($sql);
         $this->supplement_id = $this->conn->insertDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
         
         
          $sql = sprintf("SELECT id FROM packages_new WHERE is_agency_or_builder = %d ", $this->is_agency_or_builder);
          $this->conn->setsql($sql);
          $this->conn->getTableRows();
          if($this->conn->numberrows > 0 && $this->supplement_id > 0)
          {
          	for ($n=0;$n<$this->conn->numberrows;$n++)
          	{
		          $sql = sprintf("INSERT INTO packages_supliments_new (package_id,
		          									 	suplement_id,
		          									 	value         										
		         									) VALUES (%d,
		         									%d,
		         									'%s'
		                                            )",		         										
		         										$this->conn->result[$n]['id'],
		         										$this->supplement_id,
		         										'0'       										
		         									);
		         $this->conn->setsql($sql);
		         $this->conn->insertDB();
		
		         if($this->conn->error) {
		            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
		               $this->Error["SQL ERROR ClssCmpnCrt-".$key] = $this->conn->error[$key];
		            }
		            return false;
		         }
	         
          	}
          	
          }

         
         
         

         return true;
      }  //End Create
      
      
       
      
      /*== CREATE SUPPLEMENT ==*/
      function updateOrderedPackage() {

    	 	 	 	
         $sql = sprintf("UPDATE packages_supliments_new SET 
         									package_id = %d,
         									suplement_id = %d,
         									value  = '%s' 
         									WHERE   
         									package_id = %d AND
         									suplement_id = %d    										
         									",         										
         									$this->package_id,
         									$this->supplement_id,
         									$this->value   ,
         									$this->package_id,
         									$this->supplement_id      										
         									);
         $this->conn->setsql($sql);
         $this->id = $this->conn->updateDB();

         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnCrt-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         
         

         return true;
      }  //End Create
      

     

/*== DELETE ORDERED PACKAGE ==*/
      function deleteOrderedPackage($package_id) {
         if(!isset($package_id) or ($package_id == 0)) {
            $this->Error["Application Error ClssCmpnDltCID-Invalid Argument"] = "Class Package: In deletePackage package_id is not set";
            return false;
         }
         
         $sql = sprintf("DELETE FROM purchased_packages_new WHERE id = %d", $package_id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         return true;
      } //End Delete
	  
      
      
/*== DELETE ORDERED SUPPLEMENT ==*/
      function deleteOrderedSupplement($supplement_id) {
         if(!isset($supplement_id) or ($supplement_id == 0)) {
            $this->Error["Application Error ClssCmpnDltCID-Invalid Argument"] = "Class Package: In deleteSupplement supplement_id is not set";
            return false;
         }
         
         $sql = sprintf("DELETE FROM purchased_supplements_new WHERE id = %d", $supplement_id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
            }
            return false;
         }

         return true;
      } //End Delete
	  
      
      
      
      
      
     

/*== DELETE PACKAGE ==*/
      function deletePackage($package_id) {
         if(!isset($package_id) && ($package_id == 0)) {
            $this->Error["Application Error ClssCmpnDltCID-Invalid Argument"] = "Class Package: In deletePackage package_id is not set";
            return false;
         }
         
         $sql = sprintf("DELETE FROM packages_new WHERE id = %d", $package_id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
         $sql = sprintf("DELETE FROM packages_supliments_new WHERE package_id = %d", $package_id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         

         return true;
      } //End Delete
	  
      
      
/*== DELETE SUPPLEMENT ==*/
      function deleteSupplement($supplement_id) {
         if(!isset($supplement_id) && ($supplement_id == 0)) {
            $this->Error["Application Error ClssCmpnDltCID-Invalid Argument"] = "Class Package: In deleteSupplement supplement_id is not set";
            return false;
         }
         
         $sql = sprintf("DELETE FROM supplements_new WHERE id = %d", $supplement_id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
         $sql = sprintf("DELETE FROM packages_supliments_new WHERE suplement_id = %d", $supplement_id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         

         return true;
      } //End Delete
	  
      
      
      
/*== DELETE SUPPLEMENT ==*/
      function deleteOthersSupplement($supplement_id) {
         if(!isset($supplement_id) && ($supplement_id == 0)) {
            $this->Error["Application Error ClssCmpnDltCID-Invalid Argument"] = "Class Package: In deleteSupplement supplement_id is not set";
            return false;
         }
         
         $sql = sprintf("DELETE FROM supplements_new WHERE id = %d", $supplement_id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         
         
         $sql = sprintf("DELETE FROM packages_supliments_new WHERE suplement_id = %d", $supplement_id);
         $this->conn->setsql($sql);
         $this->conn->UpdateDB();
         if($this->conn->error) {
            for(reset($this->conn->error); $key = key($this->conn->error); next($this->conn->error)) {
               $this->Error["SQL ERROR ClssCmpnDltCmpn-".$key] = $this->conn->error[$key];
            }
            return false;
         }
         

         return true;
      } //End Delete
	  

   } //Class Package
?>