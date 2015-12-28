<?php
	ini_set('max_execution_time', '1750');
	
	include("includes/header.inc.php");
   
   
   
  	$xml = "";
   
  	$xml .= '<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
	$xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

	
	$conn =  new mysqldb();	
						    
	$xml .= '
   <sitemap>
      <loc>http://www.gozbite.com/sitemap_XML.php</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
   </sitemap>
   <sitemap>
      <loc>http://www.gozbite.com/sitemap_XML_frazi_1.php</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
   </sitemap>
<sitemap>
      <loc>http://www.gozbite.com/sitemap_XML_frazi_2.php</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
   </sitemap>';
  
	

	$xml .= '</sitemapindex >';
	
	header('Content-Type: application/xml');
	
	print $xml;
	?>