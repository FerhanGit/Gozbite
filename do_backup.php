<?php

$domain = "izlet.bg";
$scpuser = "izletbgu";
$scppass = "aV3t7M398";
$scphost = "ftp.izlet.bg";
$scpport = "21";
$scprdir = "/home/izletbgu/";

// Notification information
$notifyemail = "office@izlet.bg";

$url = $domain;
$port = 2082;

$users = parse_ini_file("/home/izletbgu/public_html/accounts_pass.ini");
foreach($users as $cpuser => $cppass) 
{
       if(!is_dir('/home/izletbgu/backups_izletbg/'.$cpuser))
       {
               mkdir('/home/izletbgu/backups_izletbg/'.$cpuser);
               echo '[+] Creating backup folder for user: '. $cpuser .' - /home/izletbgu/backups_izletbg/'.$cpuser;
       }
       $socket = fsockopen($url,$port);
       if (!$socket) { echo "Failed to open socket connection!\n"; exit; }
       echo "\nProcessing $cpuser\n";
       // Encode authentication string
       $authstr = $cpuser.":".$cppass;
       $pass = base64_encode($authstr);


		$params = "dest=ftp&email=$notifyemail&server=$scphost&user=$scpuser&pass=$scppass&port=$scpport&rdir=$scprdir&submit=Generate Backup";

       print "POST /frontend/x3/backup/dofullbackup.html?".$params." HTTP/1.0\r\n";
	
       // Make POST to cPanel
       fputs($socket,"POST /frontend/x3/backup/dofullbackup.html?".$params." HTTP/1.0\r\n");
       fputs($socket,"Host: $domain\r\n");
       fputs($socket,"Authorization: Basic $pass\r\n");
       fputs($socket,"Connection: Close\r\n");
       fputs($socket,"\r\n");

       // Grab response even if we don't do anything with it.
       while (!feof($socket)) {
               $response = fgets($socket,4096);
               //echo $response;
       }
       fclose($socket);
       sleep(60);
}



/*
// PHP script to allow periodic cPanel backups automatically, optionally to a remote FTP server.
// This script contains passwords. KEEP ACCESS TO THIS FILE SECURE! (place it in your home dir, not /www/)

// ********* THE FOLLOWING ITEMS NEED TO BE CONFIGURED *********

// Info required for cPanel access
$cpuser = "izletbgu"; // Username used to login to CPanel
$cppass = "aV3t7M398"; // Password used to login to CPanel
$domain = "izlet.bg"; // Domain name where CPanel is run
$skin = "x3"; // Set to cPanel skin you use (script won't work if it doesn't match). Most people run the default x theme

// Info required for FTP host
$ftpuser = "izletbgu"; // Username for FTP account
$ftppass = "aV3t7M398"; // Password for FTP account
$ftphost = "ftp.izlet.bg"; // Full hostname or IP address for FTP host
$ftpmode = "ftp"; // FTP mode ("ftp" for active, "passiveftp" for passive)
$ftpport = "21"; // Port (default = 21)
$rdir = "/"; // Remote dir (defaut = / )

// Notification information
$notifyemail = "office@izlet.bg"; // Email address to send results

// Secure or non-secure mode
$secure = 0; // Set to 1 for SSL (requires SSL support), otherwise will use standard HTTP

// Set to 1 to have web page result appear in your cron log
$debug = 0;

// *********** NO CONFIGURATION ITEMS BELOW THIS LINE *********

if ($secure) {
$url = "ssl://".$domain;
$port = 2083;
} else {
$url = $domain;
$port = 2082;
}

$socket = fsockopen($url,$port);
if (!$socket) { echo "Failed to open socket connection… Bailing out!\n"; exit; }

// Encode authentication string
$authstr = $cpuser.":".$cppass;
$pass = base64_encode($authstr);

$params = "dest=$ftpmode&email=$notifyemail&server=$ftphost&user=$ftpuser&pass=$ftppass&port=$ftpport&rdir=$rdir&submit=Generate Backup";

// Make POST to cPanel
fputs($socket,"POST /frontend/".$skin."/backup/dofullbackup.html?".$params." HTTP/1.0\r\n");
fputs($socket,"Host: $domain\r\n");
fputs($socket,"Authorization: Basic $pass\r\n");
fputs($socket,"Connection: Close\r\n");
fputs($socket,"\r\n");

// Grab response even if we don't do anything with it.
while (!feof($socket)) {
$response = fgets($socket,4096);
if ($debug) echo $response;
}

fclose($socket);

*/
?>