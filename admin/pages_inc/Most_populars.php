<div style="float:left;width:460px;">
<div style="margin-left:10px;margin-bottom:10px;width:220px;float:left;color:#000;" align="center">Най-популярни</div>
<div style="margin-left:10px;margin-bottom:10px;width:220px;float:left;color:#000;" align="center">Най-пресни</div>

<div style="margin-left:0px;width:460px;float:left;">
<?php

	//$sql="SELECT n.newsID as 'newsID', SUM(ln.cnt) as 'cnt', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc, log_news ln WHERE n.news_category=nc.id AND ln.news_id=n.newsID GROUP BY n.newsID ORDER BY cnt DESC LIMIT 3 ";
	$sql="SELECT n.newsID as 'newsID', n.rating/n.times_rated as 'rating_average', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc WHERE n.news_category=nc.id ORDER BY rating_average DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultNewsPopular = $conn->result;
	$numNewsPopular = $conn->numberrows;
	
	print '<div style="margin-left:10px;width:210px;float:left;">';	
	for($n=0;$n<$numNewsPopular;$n++)
	{
		print "<img src='images/blue_six.png' style='width:5px;height:5px;margin-right:2px;'/><a href=news.php?newsID=".$resultNewsPopular[$n]['newsID'].">".$resultNewsPopular[$n]['title']."</a><br />";
	}
	
	print '</div><div style="margin-left:10px;padding-left:10px;width:210px;float:left; background-image:url(images/dash.png); background-position:left;background-repeat:repeat-y;">';		
	$sql="SELECT n.newsID as 'newsID', SUM(ln.cnt) as 'cnt', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc, log_news ln WHERE n.news_category=nc.id AND ln.news_id=n.newsID GROUP BY n.newsID ORDER BY n.date DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultNewsLast = $conn->result;
	$numNewsLast = $conn->numberrows;
	for($n=0;$n<$numNewsLast;$n++)
	{
		print "<img src='images/blue_six.png' style='width:5px;height:5px;margin-right:2px;'/><a href=news.php?newsID=".$resultNewsLast[$n]['newsID'].">".$resultNewsLast[$n]['title']."</a><br />";
	}
	print '</div>';
?><div style="float:left;width:10px;writing-mode: tb-rl;"><img src="images/vertical_news.png" /></div>
</div>
<hr style="float:left; margin-left:5px; width:460px; border:none; border-top:dashed 1px #CCCCCC;" >


<div style="margin-left:0px;width:460px;float:left;">
<?php

	//$sql="SELECT p.postID as 'postID', SUM(lp.cnt) as 'cnt', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc, log_post lp WHERE p.post_category=pc.id AND lp.post_id=p.postID GROUP BY p.postID ORDER BY cnt DESC LIMIT 3 ";
	$sql="SELECT p.postID as 'postID',p.rating/p.times_rated as 'rating_average', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id ORDER BY rating_average DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultPostsPopular = $conn->result;
	$numPostsPopular = $conn->numberrows;
	
	print '<div style="margin-left:10px;width:210px;float:left;">';	
	for($n=0;$n<$numPostsPopular;$n++)
	{
		print "<img src='images/blue_six.png' style='width:5px;height:5px;margin-right:2px;'/><a href=posts.php?postID=".$resultPostsPopular[$n]['postID'].">".$resultPostsPopular[$n]['title']."</a><br />";
	}
	
	
	$sql="SELECT p.postID as 'postID', SUM(lp.cnt) as 'cnt', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc, log_post lp WHERE p.post_category=pc.id AND lp.post_id=p.postID GROUP BY p.postID ORDER BY date DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultPostsLast = $conn->result;
	$numPostsLast = $conn->numberrows;
	
	print '</div><div style="margin-left:10px;padding-left:10px;width:210px;float:left; background-image:url(images/dash.png); background-position:left;background-repeat:repeat-y;">';		
	for($n=0;$n<$numPostsLast;$n++)
	{
		print "<img src='images/blue_six.png' style='width:5px;height:5px;margin-right:2px;'/><a href=posts.php?postID=".$resultPostsLast[$n]['postID'].">".$resultPostsLast[$n]['title']."</a><br />";
	}
	print '</div>';
?><div style="float:left;width:10px;writing-mode: tb-rl;"><img src="images/vertical_posts.png" /></div>
</div>
<hr style="float:left; margin-left:5px; width:460px; border:none; border-top:dashed 1px #CCCCCC;" >


<div style="margin-left:0px;width:460px;float:left;">
<?php

//	$sql="SELECT b.bolestID as 'bolestID', SUM(lb.cnt) as 'cnt', b.title as 'title', b.date as 'date' FROM bolesti b, log_bolest lb WHERE lb.bolest_id=b.bolestID GROUP BY b.bolestID ORDER BY cnt DESC LIMIT 3 ";
	$sql="SELECT b.bolestID as 'bolestID', b.rating/b.times_rated as 'rating_average', b.title as 'title', b.date as 'date' FROM bolesti b ORDER BY rating_average DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultBolestiPopular = $conn->result;
	$numBolestiPopular = $conn->numberrows;
	
	print '<div style="margin-left:10px;width:210px;float:left;">';	
	for($n=0;$n<$numBolestiPopular;$n++)
	{
		print "<img src='images/red_six.png' style='width:5px;height:5px;margin-right:2px;'/><a href=bolesti.php?bolestID=".$resultBolestiPopular[$n]['bolestID'].">".$resultBolestiPopular[$n]['title']."</a><br />";
	}
	
	
	$sql="SELECT b.bolestID as 'bolestID', SUM(lb.cnt) as 'cnt', b.title as 'title', b.date as 'date' FROM bolesti b, log_bolest lb WHERE lb.bolest_id=b.bolestID GROUP BY b.bolestID ORDER BY date DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultBolestiLast = $conn->result;
	$numBolestiLast = $conn->numberrows;
	
	print '</div><div style="margin-left:10px;padding-left:10px;width:210px;float:left; background-image:url(images/dash.png); background-position:left;background-repeat:repeat-y;">';		
	for($n=0;$n<$numBolestiLast;$n++)
	{
		print "<img src='images/red_six.png' style='width:5px;height:5px;margin-right:2px;'/><a href=bolesti.php?bolestID=".$resultBolestiLast[$n]['bolestID'].">".$resultBolestiLast[$n]['title']."</a><br />";
	}
	print '</div>';
?><div style="float:left;width:10px;writing-mode: tb-rl;"><img src="images/vertical_bolesti.png" /></div>
</div>
<hr style="float:left; margin-left:5px; width:460px; border:none; border-top:dashed 1px #CCCCCC;" >




<div style="margin-left:0px;width:460px;float:left;">
<?php

	//$sql="SELECT d.id as 'id', SUM(ld.cnt) as 'cnt', CONCAT(d.first_name,' ',d.last_name) as 'name', d.updated_on as 'updated_on' FROM doctors d, log_doctor ld WHERE ld.doctor_id=d.id GROUP BY d.id ORDER BY cnt DESC LIMIT 3 ";
	$sql="SELECT d.id as 'id', d.rating/d.times_rated as 'rating_average', CONCAT(d.first_name,' ',d.last_name) as 'name', d.updated_on as 'updated_on' FROM doctors d ORDER BY rating_average DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultDoctorsPopular = $conn->result;
	$numDoctorsPopular = $conn->numberrows;
	
	
	print '<div style="margin-left:10px;width:210px;float:left;">';	
	for($n=0;$n<$numDoctorsPopular;$n++)
	{
		$sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$resultDoctorsPopular[$n]['id']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numDoctorsPopularCats     = $conn->numberrows;
		$resultDoctorsPopularCats  = $conn->result;
	
		print "<img src='images/green_six.png' style='width:5px;height:5px;margin-right:2px;'/><a href=doctors.php?doctorID=".$resultDoctorsPopular[$n]['id'].">".$resultDoctorsPopular[$n]['name']." - ".$resultDoctorsPopularCats[0]['doctor_category_name']."</a><br />";
	}
	
	
	$sql="SELECT d.id as 'id', SUM(ld.cnt) as 'cnt', CONCAT(d.first_name,' ',d.last_name) as 'name', d.updated_on as 'updated_on' FROM doctors d, log_doctor ld WHERE ld.doctor_id=d.id GROUP BY d.id ORDER BY updated_on DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultDoctorsLast = $conn->result;
	$numDoctorsLast = $conn->numberrows;
	
	print '</div><div style="margin-left:10px;padding-left:10px;width:210px;float:left; background-image:url(images/dash.png); background-position:left;background-repeat:repeat-y;">';		
	for($n=0;$n<$numDoctorsLast;$n++)
	{
		$sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$resultDoctorsLast[$n]['id']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numDoctorslastCats     = $conn->numberrows;
		$resultDoctorsLastCats  = $conn->result;
		
		print "<img src='images/green_six.png' style='width:5px;height:5px;margin-right:2px;'/><a href=doctors.php?doctorID=".$resultDoctorsLast[$n]['id'].">".$resultDoctorsLast[$n]['name']." - ".$resultDoctorsLastCats[0]['doctor_category_name']."</a><br />";
	}
	print '</div>';
?><div style="float:left;width:10px;writing-mode: tb-rl;"><img src="images/vertical_doctors.png" /></div>
</div>
<hr style="float:left; margin-left:5px; width:460px; border:none; border-top:dashed 1px #CCCCCC;" >



<div style="margin-left:0px;width:460px;float:left;">
<?php

	//$sql="SELECT h.id as 'id', SUM(lh.cnt) as 'cnt', h.name as 'name', h.updated_on as 'updated_on', l.name as 'location', lt.name as 'locType' FROM hospitals h, log_hospitals lh, locations l, location_types lt WHERE  h.location_id = l.id  AND l.loc_type_id = lt.id AND lh.hospital_id=h.id GROUP BY h.id ORDER BY cnt DESC LIMIT 3 ";
	$sql="SELECT h.id as 'id', h.rating/h.times_rated as 'rating_average', h.name as 'name', h.updated_on as 'updated_on', l.name as 'location', lt.name as 'locType' FROM hospitals h, locations l, location_types lt WHERE  h.location_id = l.id  AND l.loc_type_id = lt.id ORDER BY rating_average DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultHospitalsPopular = $conn->result;
	$numHospitalsPopular = $conn->numberrows;
	
	print '<div style="margin-left:10px;width:210px;float:left;">';	
	for($n=0;$n<$numHospitalsPopular;$n++)
	{
		print "<img src='images/green_six.png' style='width:5px;height:5px;margin-right:2px;'/><a href=hospitals.php?firmID=".$resultHospitalsPopular[$n]['id'].">".$resultHospitalsPopular[$n]['name']." - ".$resultHospitalsPopular[$n]['locType']." ".$resultHospitalsPopular[$n]['location']."</a><br />";
	}
	
	
	$sql="SELECT h.id as 'id', SUM(lh.cnt) as 'cnt', h.name as 'name', h.updated_on as 'updated_on' , l.name as 'location', lt.name as 'locType'  FROM hospitals h, log_hospitals lh, locations l, location_types lt WHERE  h.location_id = l.id  AND l.loc_type_id = lt.id AND lh.hospital_id=h.id GROUP BY h.id ORDER BY updated_on DESC LIMIT 3 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultHospitalsLast = $conn->result;
	$numHospitalsLast = $conn->numberrows;
	
	print '</div><div style="margin-left:10px;padding-left:10px;width:210px;float:left; background-image:url(images/dash.png); background-position:left;background-repeat:repeat-y;">';		
	for($n=0;$n<$numHospitalsLast;$n++)
	{
		print "<img src='images/green_six.png' style='width:5px;height:5px;margin-right:2px;'/><a href=hospitals.php?firmID=".$resultHospitalsLast[$n]['id'].">".$resultHospitalsLast[$n]['name']." - ".$resultHospitalsLast[$n]['locType']." ".$resultHospitalsLast[$n]['location']."</a><br />";
	}
	print '</div>';
?><div style="float:left;width:10px;writing-mode: tb-rl;"><img src="images/vertical_hospitals.png" /></div>
</div>
<hr style="float:left; margin-left:5px; width:460px; border:none; border-top:dashed 1px #CCCCCC;" >




</div>