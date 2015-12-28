<?php

   require_once("inc/dblogin.inc.php");
	
  
  
   $is_payed=$_REQUEST['is_payed'];
   $is_active=$_REQUEST['is_active'];
   $PackorSupps=$_REQUEST['PackorSupps'];
   $id=$_REQUEST['id'];
   
   $companyOrDoctor_id		= $_REQUEST['companyID']?$_REQUEST['companyID']:0;
   $companyOrDoctor_field 	= $_REQUEST['companyOrDoctor_field']?$_REQUEST['companyOrDoctor_field']:'company_id';
   											 
   if($companyOrDoctor_id <> 0)
   {	  
   	if ($is_payed >= 0)
   	{
   		
   		if($PackorSupps == 'package')
   		{
	   		$sql = "UPDATE purchased_packages SET is_payed=$is_payed WHERE $companyOrDoctor_field = $companyOrDoctor_id AND id= $id";
	        $conn->setSQL($sql);
	   		$conn->updateDB();
   		}
   	}
   	
   	if ($is_active >= 0)
   	{
   		if($PackorSupps == 'package')
   		{
	   		
			$sql = "UPDATE purchased_packages SET active=$is_active WHERE $companyOrDoctor_field = $companyOrDoctor_id AND id= $id";
	        $conn->setSQL($sql);
	   		$conn->updateDB();
	   		
			$sql = "SELECT pp.company_id as 'company_id', pp.doctor_id as 'doctor_id', p.is_Silver as 'is_Silver', p.is_Gold as 'is_Gold' FROM packages p, purchased_packages pp WHERE pp.package_id=p.id AND pp.id='".$id."'";
            $conn->setSQL($sql);
			$conn->getTableRow();
			$resultSilverGold = $conn->result;
			
			if($resultSilverGold['company_id'] > 0)
			{
				if($is_active == 1)
				{
					$sql = "UPDATE hospitals SET is_Silver = '".$resultSilverGold['is_Silver']."', is_Gold = '".$resultSilverGold['is_Gold']."' WHERE id='".$resultSilverGold['company_id']."'";
					$conn->setsql($sql);
					$conn->updateDB();
				}
				else
				{
					$sql = "UPDATE hospitals SET is_Silver = '0', is_Gold = '0' WHERE id='".$resultSilverGold['company_id']."'";
					$conn->setsql($sql);
					$conn->updateDB();
				}
			}
			if($resultSilverGold['doctor_id'] > 0)
			{
				if($is_active == 1)
				{
					$sql = "UPDATE doctors SET is_Silver = '".$resultSilverGold['is_Silver']."', is_Gold = '".$resultSilverGold['is_Gold']."' WHERE id='".$resultSilverGold['doctor_id']."'";
					$conn->setsql($sql);
					$conn->updateDB();
				}
				else
				{
					$sql = "UPDATE doctors SET is_Silver = '0', is_Gold = '0' WHERE id='".$resultSilverGold['doctor_id']."'";
					$conn->setsql($sql);
					$conn->updateDB();
				}
			}
	   		
   		}
   		
   	}
   	
   
  }
   
?>