<?php

print "Full DATE - ".date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').'00:00:00')))).'<br />';
print "TIME STAMP - ".strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').'00:00:00'))).'<br />';
print 'TIME() - '.time().'<br />';
print 'CURR DATE Curr - '.date('d',time()).'<br />';
print 'CURR DATE Generic - '.date('d').'<br />';
print 'CURR DATE - '.date('Y-m-d',time()).'<br />';
print 'FIRST DAY OF THE MONT - '.date('Y-m-d',strtotime('first month')).'<br />';
print 'LAST DAY OF THE MONT 2 - '.date('t',time()).'<br />';
print 'TOTAL MONTH DAYS - '.date('t',time()).'<br />';
print 'CURR MONTH DAY - '.date('d',time()).'<br />';
print 'CURR MONTH WEEK - '.date('W',time()).'<br />';
print 'LAST MONTH WEEK - '.date('W',strtotime('last week of month')).'<br />';
print 'First Monday - '.date('Y-m-d',strtotime('first monday', time())).'<br />';
print 'SecondMonday - '.date('Y-m-d',strtotime('second monday', time())).'<br /><br /><br />';

print 'WEEK DAY - '.date('j',strtotime('24 August 2011')).'<br />';
print 'WEEK DAY CURR - '.date('j',time()).'<br />';

if(!(date('j',time()) >= 1 && date('j',time()) <= 9))
{
	print 'WEEK DAY CURR - '.date('j',time()).'<br />';
}

?>










<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="bg-BG" lang="bg-BG">

<head>
<title>.: GoZbiTe.Com </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	

		
</head>
<body>
 <iframe id="goglobal" width="900" height="800" frameborder="0" style="overflow:hidden; overflow-y:auto;"
scrolling="auto" src="http://www.gozbite.com/%D1%80%D0%B0%D0%B7%D0%B3%D0%BB%D0%B5%D0%B4%D0%B0%D0%B9-%D1%80%D0%B5%D1%86%D0%B5%D0%BF%D1%82%D0%B8,%D0%B2%D0%BA%D1%83%D1%81%D0%BD%D0%B8_%D0%B3%D0%BE%D1%82%D0%B2%D0%B0%D1%80%D1%81%D0%BA%D0%B8_%D1%80%D0%B5%D1%86%D0%B5%D0%BF%D1%82%D0%B8_%D1%81_%D0%BC%D0%B5%D1%81%D0%BE_%D0%B2%D0%B5%D0%B3%D0%B5%D1%82%D0%B0%D1%80%D0%B8%D0%B0%D0%BD%D1%81%D0%BA%D0%B8_%D0%B7%D0%B5%D0%BB%D0%B5%D0%BD%D1%87%D1%83%D1%86%D0%B8_%D0%BF%D0%BB%D0%BE%D0%B4%D0%BE%D0%B2%D0%B5_%D0%B4%D0%B5%D1%81%D0%B5%D1%80%D1%82%D0%B8_%D1%82%D0%BE%D1%80%D1%82%D0%B8_%D1%81%D0%BB%D0%B0%D0%B4%D0%BA%D0%B8_%D0%BA%D0%BE%D0%BA%D1%82%D0%B5%D0%B9%D0%BB%D0%B8.html" marginwidth="0" marginheight="0"></iframe>
</body>
</html>