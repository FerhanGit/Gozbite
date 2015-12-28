<?
	//
	// The image script for the verification image script
	//
	// author: Jaap van der Meer(jaap_at_web-radiation_dot_nl)
	//

	session_start();
	
	include("verification_image.class.php");
	
	$image = new verification_image(114,35,"arial.ttf");
	
	$image->_output();
	
?>
