<?php
	ini_set('max_execution_time', '1750');
	
	include("includes/header.inc.php");
   
   
   
  	$xml = "";
   
  	$xml .= '<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
	$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

	
	$conn =  new mysqldb();							    
	

// ----------------------------------------- Афоризми -----------------------------------------------
	$sql="SELECT a.aphorismID as 'aphorismID', a.date as 'date', a.title as 'title', a.body as 'body', a.picURL as 'picURL', a.autor as 'autor', a.autor_type as 'autor_type' FROM aphorisms a WHERE a.active = '1' ORDER BY RAND(), a.date DESC LIMIT 50000,100000";
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://gozbite.com/прочети-афоризъм-'.$result[$i]["aphorismID"].','.str_replace('#','',strip_tags(htmlspecialchars(myTruncateToCyrilic($result[$i]['body'],200,"_","")))).'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d").'</lastmod>';
		$xml .= '<changefreq>daily</changefreq>';
		$xml .= '<priority>0.9</priority>';		
		$xml .= '</url>';
		
	}	
// ------------------------------------------------------------------------------------------------		


	
	

	$xml .= '</urlset>';
	
	header('Content-Type: application/xml');
	
	print $xml;
	?>