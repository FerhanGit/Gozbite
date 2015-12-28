<?php
ini_set('max_execution_time', '5750');
ini_set('memory_limit','512M');

	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
	
	require_once("../config_prolive.inc.php");
	require_once("../classes/mysqldb.class.php");
   
   	$conn = new mysqldb();
  
   

	$sql = sprintf("SELECT nid,title,created FROM node WHERE nid > 4");
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	
	

	foreach($result as $lastID)
	{
		$sql = sprintf("INSERT INTO node_comment_statistics SET nid = '%d',
										last_comment_timestamp  = '%s',
											last_comment_uid = '1'
                                            ",    	
    										$lastID['nid'],
												$lastID['created']
								            );
								                                 
                                   
        $conn->setsql($sql);
        $conn->insertDB();

		
		
		$sql = sprintf("INSERT INTO tracker_node SET nid = '%d',
										changed  = '%s',
											published = '1'
                                            ",    	
    										$lastID['nid'],
												$lastID['created']
								            );
								                                 
                                   
        $conn->setsql($sql);
        $conn->insertDB();

		
		
		$sql = sprintf("INSERT INTO history SET nid = '%d',
										timestamp  = '%s',
											uid = '1'
                                            ",    	
    										$lastID['nid'],
												$lastID['created']
								            );
								                                 
                                   
        $conn->setsql($sql);
        $conn->insertDB();

		
		 
		
		$sql = sprintf("INSERT INTO node_revision SET nid = '%d',
												 vid = '%d',
													title = '%s',
														uid = '1',
															status = '1',
														timestamp  = '%s
													comment = '2',
											promote = '1'
                                            ",    	
    										$lastID['nid'],
												$lastID['nid'],
													$lastID['title'],
														$lastID['created']					             			
								            );
								                                 
                                   
        $conn->setsql($sql);
        $lastID = $conn->insertDB();
  
	}	
	

?>