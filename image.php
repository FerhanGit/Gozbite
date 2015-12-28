<?php
/* No source, quit */
if(empty($_GET['i'])) exit;

header("content-type:image/png");

$l_oImg = imagecreatefromjpeg($_GET['i']);

/* Resizing/ flipping */
if($_GET['fh']) {
	$l_oImg = imageflip($l_oImg, 1);
}

if($_GET['fv']) {
	$l_oImg = imageflip($l_oImg, 0);
}

if($_GET['rw'] || $_GET['rh']) {
	if($_GET['rw'] && $_GET['rh']) {
		$l_newWidth = $_GET['rw'];
		$l_newHeight = $_GET['rh'];
	} elseif($_GET['rw']) {
		$l_newWidth 	=  $_GET['rw'];
		$l_newHeight 	=  $l_newWidth/imagesx($l_oImg)*imagesy($l_oImg);
	} elseif($_GET['rh']) {
		$l_newHeight	= $_GET['rh'];
		$l_newWidth 	=  $l_newHeight/imagesy($l_oImg)*imagesx($l_oImg);
	}
	
	$l_newImg = imagecreatetruecolor($l_newWidth, $l_newHeight);
	imagecopyresampled($l_newImg, $l_oImg, 0, 0, 0, 0, $l_newWidth, $l_newHeight, imagesx($l_oImg), imagesy($l_oImg));
	$l_oImg = $l_newImg;
}

if($_GET['cn']) {
	
	$l_oImgChuck = imagecreatefrompng("images/chuck.png");
	
	$l_iWidth = imagesx($l_oImg)/2;
	$l_iHeight = imagesy($l_oImg)/1;
	
	imagecopyresampled($l_oImg, $l_oImgChuck, 0, 0, 0, 0, $l_iWidth, $l_iHeight,imagesx($l_oImgChuck),imagesy($l_oImgChuck) );
		
}


/* Filters */
if($_GET['ed']) {
	imagefilter($l_oImg, IMG_FILTER_EDGEDETECT);
}

if($_GET['gr']) {
	imagefilter($l_oImg, IMG_FILTER_GRAYSCALE);
}

if($_GET['sk']) {
	imagefilter($l_oImg, IMG_FILTER_MEAN_REMOVAL);
}



if($_GET['ct']) {
	$sFontFile = ($_GET['cf'] != "") ? $_GET['cf'] : "1942.ttf" ;
	$sFontFile = dirname(__FILE__). "/".$sFontFile;
	$iFontSize = ($_GET['cs'] != "") ?  $_GET['cs'] : 12 ; 

	$bbox = imagettfbbox($iFontSize, 0, $sFontFile, $_GET['ct']);
	$l_iBoxHeight	= ($bbox[3] - $bbox[5]);
	$l_iBoxWidth = $bbox[2];
	
	$l_newImg = imagecreatetruecolor(imagesx($l_oImg), imagesy($l_oImg)+$l_iBoxHeight+10);
	imagefill($l_newImg, 0, 0, imagecolorallocate($l_newImg, 255, 255, 255));
	
	imagecopyresampled($l_newImg, $l_oImg, 0, 0, 0, 0, imagesx($l_newImg), imagesy($l_oImg), imagesx($l_oImg), imagesy($l_oImg));
	
	$l_oImg = $l_newImg;
	
	imagettftext($l_oImg, $iFontSize, 0, (imagesx($l_oImg)/2)-(($l_iBoxWidth/2)),imagesy($l_oImg)-($l_iBoxHeight/2), imagecolorallocate($l_newImg, 0, 0, 0), $sFontFile, $_GET['ct'] );	
}


/* drop ? */
if($_GET['sh']) {
	$l_oImg = dropShadow($l_oImg);
}

/* Rotation? Always at the end */
if($_GET['r']) {
	$l_oImg = imagerotate($l_oImg, $_GET['r'], imagecolorallocate($l_oImg, 255, 255, 255));
}

imagepng($l_oImg);

/* --- Functions --- */
define("VERTICAL", 1);
define("HORIZONTAL", 2);

function imageflip($image, $mode) {
        $w = imagesx($image);
        $h = imagesy($image);
        $flipped = imagecreatetruecolor($w, $h);
        if ($mode) {
                for ($y = 0; $y < $h; $y++) {
                        imagecopy($flipped, $image, 0, $y, 0, $h - $y - 1, $w, 1);
                }
        } else {
                for ($x = 0; $x < $w; $x++) {
                        imagecopy($flipped, $image, $x, 0, $w - $x - 1, 0, 1, $h);
                }
        }
        return $flipped;
}

function dropShadow($p_oImg) {
	/* -- NOTE: This function and technique is taken from this site http://www.partdigital.com/tutorials/gd-drop-shadow/ */
	$width = imagesx($p_oImg);
	$height =  imagesy($p_oImg);
	 	 
	$tl = imagecreatefromgif("images/shadow_TL.gif");
	$t  = imagecreatefromgif("images/shadow_T.gif"); 
	$tr = imagecreatefromgif("images/shadow_TR.gif"); 
	$r  = imagecreatefromgif("images/shadow_R.gif"); 
	$br = imagecreatefromgif("images/shadow_BR.gif"); 
	$b  = imagecreatefromgif("images/shadow_B.gif"); 
	$bl = imagecreatefromgif("images/shadow_BL.gif");
	$l  = imagecreatefromgif("images/shadow_L.gif");
		
	$w = imagesx($l); 	//Width of the left shadow image
	$h = imagesy($l);	//Height of the left shadow image

	$canvasHeight = $height + (2*$w); 
	$canvasWidth  = $width + (2*$w);

	$canvas = imagecreatetruecolor($canvasWidth, $canvasHeight); 
 
	imagecopyresized($canvas, $t,0,0,0,0,$canvasWidth,$w,$h,$w);			
	imagecopyresized($canvas, $l,0,0,0,0,$w,$canvasHeight,$w,$h);
	imagecopyresized($canvas, $b,0,$canvasHeight-$w,0,0,$canvasWidth,$w,$h, $w); 
	imagecopyresized($canvas, $r,$canvasWidth-$w,0,0,0,$w,$canvasHeight,$w,$h);
	 
	 
	//here I'm doing the same thing again, only this time I'm setting $w and $h to be the width and heights of the corners. 
	$w = imagesx($tl); 
	$h = imagesy($tl); 
	imagecopyresized($canvas, $tl,0,0,0,0,$w,$h,$w,$h);  
	imagecopyresized($canvas, $bl,0,$canvasHeight-$h,0,0,$w,$h,$w,$h); 
	imagecopyresized($canvas, $br,$canvasWidth-$w,$canvasHeight-$h,0,0,$w,$h,$w,$h);
	imagecopyresized($canvas, $tr,$canvasWidth-$w,0,0,0,$w,$h,$w, $h);  
	 
	/*
	At this point the canvas has all the drop shadow images attached, all we need to do now is attach the image and we're done! 
	I changed $w back to the size of the perimeter in order to properly place the image.
	*/	
	$w = imagesx($l); 
	imagecopyresampled($canvas, $p_oImg, $w,$w,0,0,  imagesx($p_oImg), imagesy($p_oImg), imagesx($p_oImg),imagesy($p_oImg));
	 
	return $canvas;
}

?>
