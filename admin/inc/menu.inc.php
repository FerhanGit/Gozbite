<script type="text/javascript">
Event.observe(window, 'load', function() {    
$('firmsA').onclick=function(){ Effect.toggle('dropmenu2','Slide');  if ($('dropmenu1').visible()) {Effect.toggle('dropmenu1','Slide');} if ($('dropmenu3').visible()) {Effect.toggle('dropmenu3','Slide');} if ($('dropmenu4').visible()) {Effect.toggle('dropmenu4','Slide');} if ($('dropmenu5').visible()) {Effect.toggle('dropmenu5','Slide');} if ($('dropmenu6').visible()) {Effect.toggle('dropmenu6','Slide');} if ($('dropmenu7').visible()) {Effect.toggle('dropmenu7','Slide');} if ($('dropmenu8').visible()) {Effect.toggle('dropmenu8','Slide');} if ($('dropmenu9').visible()) {Effect.toggle('dropmenu9','Slide');} if ($('dropmenu10').visible()) {Effect.toggle('dropmenu10','Slide');} if ($('dropmenu11').visible()) {Effect.toggle('dropmenu11','Slide');} return false;}
$('offersA').onclick=function(){ Effect.toggle('dropmenu3','Slide'); if ($('dropmenu1').visible()) {Effect.toggle('dropmenu1','Slide');} if ($('dropmenu2').visible()) {Effect.toggle('dropmenu2','Slide');} if ($('dropmenu4').visible()) {Effect.toggle('dropmenu4','Slide');} if ($('dropmenu5').visible()) {Effect.toggle('dropmenu5','Slide');} if ($('dropmenu6').visible()) {Effect.toggle('dropmenu6','Slide');} if ($('dropmenu7').visible()) {Effect.toggle('dropmenu7','Slide');} if ($('dropmenu8').visible()) {Effect.toggle('dropmenu8','Slide');} if ($('dropmenu9').visible()) {Effect.toggle('dropmenu9','Slide');} if ($('dropmenu10').visible()) {Effect.toggle('dropmenu10','Slide');} if ($('dropmenu11').visible()) {Effect.toggle('dropmenu11','Slide');} return false;}
$('newsA').onclick=function(){ Effect.toggle('dropmenu4','Slide'); if ($('dropmenu1').visible()) {Effect.toggle('dropmenu1','Slide');} if ($('dropmenu2').visible()) {Effect.toggle('dropmenu2','Slide');} if ($('dropmenu3').visible()) {Effect.toggle('dropmenu3','Slide');} if ($('dropmenu5').visible()) {Effect.toggle('dropmenu5','Slide');} if ($('dropmenu6').visible()) {Effect.toggle('dropmenu6','Slide');} if ($('dropmenu7').visible()) {Effect.toggle('dropmenu7','Slide');} if ($('dropmenu8').visible()) {Effect.toggle('dropmenu8','Slide');} if ($('dropmenu9').visible()) {Effect.toggle('dropmenu9','Slide');} if ($('dropmenu10').visible()) {Effect.toggle('dropmenu10','Slide');} if ($('dropmenu11').visible()) {Effect.toggle('dropmenu11','Slide');} return false;}
$('postsA').onclick=function(){ Effect.toggle('dropmenu5','Slide'); if ($('dropmenu1').visible()) {Effect.toggle('dropmenu1','Slide');} if ($('dropmenu2').visible()) {Effect.toggle('dropmenu2','Slide');} if ($('dropmenu3').visible()) {Effect.toggle('dropmenu3','Slide');} if ($('dropmenu4').visible()) {Effect.toggle('dropmenu4','Slide');} if ($('dropmenu6').visible()) {Effect.toggle('dropmenu6','Slide');} if ($('dropmenu7').visible()) {Effect.toggle('dropmenu7','Slide');} if ($('dropmenu8').visible()) {Effect.toggle('dropmenu8','Slide');} if ($('dropmenu9').visible()) {Effect.toggle('dropmenu9','Slide');} if ($('dropmenu10').visible()) {Effect.toggle('dropmenu10','Slide');} if ($('dropmenu11').visible()) {Effect.toggle('dropmenu11','Slide');} return false;}
$('target_linksA').onclick=function(){ Effect.toggle('dropmenu7','Slide'); if ($('dropmenu1').visible()) {Effect.toggle('dropmenu1','Slide');} if ($('dropmenu2').visible()) {Effect.toggle('dropmenu2','Slide');} if ($('dropmenu3').visible()) {Effect.toggle('dropmenu3','Slide');} if ($('dropmenu4').visible()) {Effect.toggle('dropmenu4','Slide');} if ($('dropmenu5').visible()) {Effect.toggle('dropmenu5','Slide');} if ($('dropmenu7').visible()) {Effect.toggle('dropmenu7','Slide');} if ($('dropmenu8').visible()) {Effect.toggle('dropmenu8','Slide');} if ($('dropmenu9').visible()) {Effect.toggle('dropmenu9','Slide');} if ($('dropmenu10').visible()) {Effect.toggle('dropmenu10','Slide');} if ($('dropmenu11').visible()) {Effect.toggle('dropmenu11','Slide');} return false;}
$('forumA').onclick=function(){ Effect.toggle('dropmenu6','Slide'); if ($('dropmenu1').visible()) {Effect.toggle('dropmenu1','Slide');} if ($('dropmenu2').visible()) {Effect.toggle('dropmenu2','Slide');} if ($('dropmenu3').visible()) {Effect.toggle('dropmenu3','Slide');} if ($('dropmenu4').visible()) {Effect.toggle('dropmenu4','Slide');} if ($('dropmenu5').visible()) {Effect.toggle('dropmenu5','Slide');} if ($('dropmenu7').visible()) {Effect.toggle('dropmenu7','Slide');} if ($('dropmenu8').visible()) {Effect.toggle('dropmenu8','Slide');} if ($('dropmenu9').visible()) {Effect.toggle('dropmenu9','Slide');} if ($('dropmenu10').visible()) {Effect.toggle('dropmenu10','Slide');} if ($('dropmenu11').visible()) {Effect.toggle('dropmenu11','Slide');} return false;}
$('tripsA').onclick=function(){ Effect.toggle('dropmenu8','Slide'); if ($('dropmenu1').visible()) {Effect.toggle('dropmenu1','Slide');} if ($('dropmenu2').visible()) {Effect.toggle('dropmenu2','Slide');} if ($('dropmenu3').visible()) {Effect.toggle('dropmenu3','Slide');} if ($('dropmenu4').visible()) {Effect.toggle('dropmenu4','Slide');} if ($('dropmenu5').visible()) {Effect.toggle('dropmenu5','Slide');} if ($('dropmenu6').visible()) {Effect.toggle('dropmenu6','Slide');} if ($('dropmenu7').visible()) {Effect.toggle('dropmenu7','Slide');} if ($('dropmenu9').visible()) {Effect.toggle('dropmenu9','Slide');} if ($('dropmenu10').visible()) {Effect.toggle('dropmenu10','Slide');} if ($('dropmenu11').visible()) {Effect.toggle('dropmenu11','Slide');} return false;}
}
);
</script>
<div id="moonmenu" class="halfmoon" align="left" >
<ul style="margin:0px;padding:0px;line-height:1.8">
<?php
if (isset($_SESSION['valid_user'])) 
{
?>
	
<?php
if ($_SESSION['user_kind']==2) 
{
?>	
 	<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a href="index.php" target="_self" <?=$pageName=='admin_home'?'class="active"':''?>>АДМИН НАЧАЛО</a></div></li>
 	<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a href="../index.php" <?=$pageName=='home'?'class="active"':''?>>НАЧАЛО</a></div></li>

<?php 
}
}
else{
?>
<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a href="admin/index.php" target="_self" <?=$pageName=='admin_home'?'class="active"':''?>>АДМИН</a></div></li>
<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a href="index.php" <?=$pageName=='home'?'class="active"':''?>>НАЧАЛО</a></div></li>
<?php }?>

<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a href="pages.php" target="_self" <?=$pageName=='pages'?'class="active"':''?>>НОВА СТРАНИЦА</a></div></li>

<?php 
$sql = "SELECT pageID, title, abriviature FROM pages WHERE parent_id = 0 ORDER BY  title";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuPages = $conn->result;
$numMenuPages = $conn->numberrows;
for($d=0;$d<$numMenuPages;$d++)
{ ?>
<li>

<img id="img_page<?=$d?>" src="images/menu_strelka_white.png" /><a onmouseover="$('img_page<?=$d?>').src='images/menu_strelka_orange.png';" onmouseout="$('img_page<?=$d?>').src='images/menu_strelka_white.png';"  class="blue" href="pages.php?edit=<?=$resultMenuPages[$d]['abriviature']?>" target="_self"><?=$resultMenuPages[$d]['title']?></a><br />
<?php 
$sql = "SELECT pageID, title, abriviature FROM pages WHERE parent_id = (SELECT pageID FROM pages WHERE abriviature = '".$resultMenuPages[$d]['abriviature']."') ORDER BY  title";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuSubPages = $conn->result;
$numMenuSubPages = $conn->numberrows;
for($s=0;$s<$numMenuSubPages;$s++)
{ ?>
<img id="img_page<?=$s?>" src="images/menu_strelka_white.png" /><a onmouseover="$('img_page<?=$s?>').src='images/menu_strelka_orange.png';" onmouseout="$('img_page<?=$s?>').src='images/menu_strelka_white.png';"  class="blue" href="pages.php?edit=<?=$resultMenuSubPages[$s]['abriviature']?>" target="_self"><?=$resultMenuSubPages[$s]['title']?></a><br />
<?php 
}
?>

</li>
<?php 
}
?>


<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="firmsA" href="javascript:void(0);" <?=$pageName=='edit_firms'?'class="active"':''?>>ФИРМИ</a></div></li>
<li><!--2st drop down menu -->                                                   
<div id="dropmenu2" style="padding-left:10px;display:none;">
<?php
if (isset($_SESSION['valid_user']))
{?>
	<img id="img_redaktirai_bolnica_category" src="images/menu_strelka_white.png" /><a onmouseover="$('img_redaktirai_bolnica_category').src='images/menu_strelka_orange.png';"onmouseout="$('img_redaktirai_bolnica_category').src='images/menu_strelka_white.png';"  class="blue"  href="firm_categories.php" target="_self">Категории</a><br />
<?php 
}

?>

</div>
</li>

<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="offersA" href="javascript:void(0);" <?=$pageName=='edit_offers'?'class="active"':''?>>ПОЧИВКИ</a></div></li>
<li><!--3nd drop down menu -->                                                
<div id="dropmenu3" style="padding-left:10px;display:none;" align="left">
<?php
if (isset($_SESSION['valid_user']))
{?>
	<img id="img_redaktirai_offer_category" src="images/menu_strelka_white.png" /><a onmouseover="$('img_redaktirai_offer_category').src='images/menu_strelka_orange.png';"onmouseout="$('img_redaktirai_offer_category').src='images/menu_strelka_white.png';"  class="blue"  href="offer_categories.php" target="_self">Категории</a><br />
	<img id="img_redaktirai_offer" src="images/menu_strelka_white.png" /><a onmouseover="$('img_redaktirai_offer').src='images/menu_strelka_orange.png';"onmouseout="$('img_redaktirai_offer').src='images/menu_strelka_white.png';"  class="blue"  href="edit_offers.php" target="_self">Добави/Редактирай</a><br />
	<img id="img_redaktirai_simptom" src="images/menu_strelka_white.png" /><a onmouseover="$('img_redaktirai_simptom').src='images/menu_strelka_orange.png';"onmouseout="$('img_redaktirai_simptom').src='images/menu_strelka_white.png';"  class="blue"  href="edit_offer_simptoms.php" target="_self">Симптоми</a><br />
<?php 
}

$sql = "SELECT id,name FROM offer_category WHERE parentID=0 ORDER BY name";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuOffers = $conn->result;
$numMenuOffers = $conn->numberrows;
for($i=0;$i<$numMenuOffers;$i++)
{
?>
<img id="img_offer<?=$i?>" src="images/menu_strelka_white.png" /><a onmouseover="$('img_offer<?=$i?>').src='images/menu_strelka_orange.png';"onmouseout="$('img_offer<?=$i?>').src='images/menu_strelka_white.png';"  class="blue" href="edit_offers.php?category=<?=$resultMenuOffers[$i]['id']?>" target="_self"><?=$resultMenuOffers[$i]['name']?></a><br />
<?php } ?>

<img id="img_search_offer" src="images/menu_strelka_white.png" /><a onmouseover="$('img_search_offer').src='images/menu_strelka_orange.png';"onmouseout="$('img_search_offer').src='images/menu_strelka_white.png';"  class="blue" href="edit_offers.php?search=1" target="_self">Търси</a><br />


</div>
</li>
<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="tripsA" href="javascript:void(0);" <?=$pageName=='edit_trips'?'class="active"':''?>>ЕКСКУРЗИИ</a></div></li>
<li><!--3nd drop down menu -->                                                
<div id="dropmenu8" style="padding-left:10px;display:none;" align="left">
<?php
if (isset($_SESSION['valid_user']))
{?>
	<img id="img_redaktirai_trip_category" src="images/menu_strelka_white.png" /><a onmouseover="$('img_redaktirai_trip_category').src='images/menu_strelka_orange.png';"onmouseout="$('img_redaktirai_trip_category').src='images/menu_strelka_white.png';"  class="blue"  href="trip_categories.php" target="_self">Категории</a><br />
	<img id="img_redaktirai_tript" src="images/menu_strelka_white.png" /><a onmouseover="$('img_redaktirai_trip').src='images/menu_strelka_orange.png';"onmouseout="$('img_redaktirai_trip').src='images/menu_strelka_white.png';"  class="blue"  href="edit_trips.php" target="_self">Добави/Редактирай</a><br />
	<img id="img_redaktirai_simptom" src="images/menu_strelka_white.png" /><a onmouseover="$('img_redaktirai_simptom').src='images/menu_strelka_orange.png';"onmouseout="$('img_redaktirai_simptom').src='images/menu_strelka_white.png';"  class="blue"  href="edit_trip_simptoms.php" target="_self">Симптоми</a><br />
<?php 
}

$sql = "SELECT id,name FROM trips_category WHERE parentID=0 ORDER BY name";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuTrips = $conn->result;
$numMenuTrips = $conn->numberrows;
for($i=0;$i<$numMenuTrips;$i++)
{
?>
<img id="img_trip<?=$i?>" src="images/menu_strelka_white.png" /><a onmouseover="$('img_trip<?=$i?>').src='images/menu_strelka_orange.png';"onmouseout="$('img_trip<?=$i?>').src='images/menu_strelka_white.png';"  class="blue" href="edit_trips.php?category=<?=$resultMenuTrips[$i]['id']?>" target="_self"><?=$resultMenuTrips[$i]['name']?></a><br />
<?php } ?>

<img id="img_search_trip" src="images/menu_strelka_white.png" /><a onmouseover="$('img_search_trip').src='images/menu_strelka_orange.png';"onmouseout="$('img_search_trip').src='images/menu_strelka_white.png';"  class="blue" href="edit_trips.php?search=1" target="_self">Търси</a><br />


</div>
</li>
<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="newsA" href="javascript:void(0);" <?=$pageName=='news'?'class="active"':''?>>НОВИНИ</a></div></li>
<li>
<!--4nd drop down menu -->                                                
<div id="dropmenu4" style="padding-left:10px;display:none;">
<img id="img_pro4etinovina" src="images/menu_strelka_white.png" /><a onmouseover="$('img_pro4etinovina').src='images/menu_strelka_orange.png';"onmouseout="$('img_pro4etinovina').src='images/menu_strelka_white.png';"  class="blue"  href="edit_news.php" target="_self">Прочети</a><br />
<img id="img_search_news" src="images/menu_strelka_white.png" /><a onmouseover="$('img_search_news').src='images/menu_strelka_orange.png';"onmouseout="$('img_search_news').src='images/menu_strelka_white.png';"  class="blue" href="edit_news.php?search=1" target="_self">Търси</a><br />
<?php
if (isset($_SESSION['valid_user']))
{?>
	<img id="img_redaktirai_news_category" src="images/menu_strelka_white.png" /><a onmouseover="$('img_redaktirai_news_category').src='images/menu_strelka_orange.png';"onmouseout="$('img_redaktirai_news_category').src='images/menu_strelka_white.png';"  class="blue"  href="news_categories.php" target="_self">Категории</a><br />
	<img id="img_publikuvainovina" src="images/menu_strelka_white.png" /><a onmouseover="$('img_publikuvainovina').src='images/menu_strelka_orange.png';"onmouseout="$('img_publikuvainovina').src='images/menu_strelka_white.png';"  class="blue"  href="edit_news.php" target="_self">Публикувай</a><br />
<?php 
}?>

</div>
</li>
<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="postsA" href="javascript:void(0);" <?=$pageName=='posts'?'class="active"':''?>>СТАТИИ</a></div></li>
<li>
<!--4nd drop down menu -->                                                
<div id="dropmenu5" style="padding-left:10px;display:none;">
<img id="img_pro4etistatiq" src="images/menu_strelka_white.png" /><a onmouseover="$('img_pro4etistatiq').src='images/menu_strelka_orange.png';"onmouseout="$('img_pro4etistatiq').src='images/menu_strelka_white.png';"  class="blue"  href="edit_posts.php" target="_self">Прочети</a><br />
<img id="img_search_statiq" src="images/menu_strelka_white.png" /><a onmouseover="$('img_search_statiq').src='images/menu_strelka_orange.png';"onmouseout="$('img_search_statiq').src='images/menu_strelka_white.png';"  class="blue" href="edit_posts.php?search=1" target="_self">Търси</a><br />
<?php
if (isset($_SESSION['valid_user']))
{?>
	<img id="img_redaktirai_post_category" src="images/menu_strelka_white.png" /><a onmouseover="$('img_redaktirai_post_category').src='images/menu_strelka_orange.png';"onmouseout="$('img_redaktirai_post_category').src='images/menu_strelka_white.png';"  class="blue"  href="posts_categories.php" target="_self">Категории</a><br />
	<img id="img_publikuvaistatiq" src="images/menu_strelka_white.png" /><a onmouseover="$('img_publikuvaistatiq').src='images/menu_strelka_orange.png';"onmouseout="$('img_publikuvaistatiq').src='images/menu_strelka_white.png';"  class="blue"  href="edit_posts.php" target="_self">Публикувай</a><br />
<?php 
}

$sql = "SELECT id,name FROM post_category WHERE parentID=0 ORDER BY name";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuPosts = $conn->result;
$numMenuPosts = $conn->numberrows;
for($d=0;$d<$numMenuPosts;$d++)
{
?>
<img id="img_post<?=$d?>" src="images/menu_strelka_white.png" /><a onmouseover="$('img_post<?=$d?>').src='images/menu_strelka_orange.png';"onmouseout="$('img_post<?=$d?>').src='images/menu_strelka_white.png';"  class="blue" href="edit_posts.php?category=<?=$resultMenuPosts[$d]['id']?>" target="_self"><?=$resultMenuPosts[$d]['name']?></a><br />
<?php } ?>
</div>
</li>

<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="forumA" href="javascript:void(0);" <?=$pageName=='forum'?'class="active"':''?>>СПОДЕЛИ И ПОМОГНИ</a></div></li>
<li>
<!--6nd drop down menu -->                                                
<div id="dropmenu6" style="padding-left:10px;display:none;">
<img id="img_redaktirai_forum_category" src="images/menu_strelka_white.png" /><a onmouseover="$('img_redaktirai_forum_category').src='images/menu_strelka_orange.png';"onmouseout="$('img_redaktirai_forum_category').src='images/menu_strelka_white.png';"  class="blue"  href="forum_categories.php" target="_self">Категории</a><br />
<img id="img_pro4etiquestion" src="images/menu_strelka_white.png" /><a onmouseover="$('img_pro4etiquestion').src='images/menu_strelka_orange.png';"onmouseout="$('img_pro4etiquestion').src='images/menu_strelka_white.png';"  class="blue"  href="forum.php" target="_self">Прочети</a><br />
<img id="img_search_question" src="images/menu_strelka_white.png" /><a onmouseover="$('img_search_question').src='images/menu_strelka_orange.png';"onmouseout="$('img_search_question').src='images/menu_strelka_white.png';"  class="blue" href="forum.php?search=1" target="_self">Търси</a><br />
<img id="img_publikuvaiquestion" src="images/menu_strelka_white.png" /><a onmouseover="$('img_publikuvaiquestion').src='images/menu_strelka_orange.png';"onmouseout="$('img_publikuvaiquestion').src='images/menu_strelka_white.png';"  class="blue"  href="forum.php" target="_self">Публикувай</a><br />
</div>
</li>

<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="last_loginsA" href="last_logins.php" <?=$pageName=='last_logins'?'class="active"':''?>>ПОСЛЕДНИ ЛОГИНИ</a></div></li>
<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="surveyA" href="surveys.php" <?=$pageName=='surveys'?'class="active"':''?>>АНКЕТИ</a></div></li>
<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="shoppingA" href="shopping.php" <?=$pageName=='shopping'?'class="active"':''?>>ПАКЕТИ</a></div></li>
<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="activationA" href="activation.php" <?=$pageName=='activation'?'class="active"':''?>>АКТИВАЦИИ</a></div></li>
<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="prstuffA" href="pr_stuff.php" <?=$pageName=='pr_stuff'?'class="active"':''?>>PR Материали</a></div></li>
<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="send_bulletinA" href="send_Bulletin.php?test=1" <?=$pageName=='send_bulletin'?'class="active"':''?>>ИЗПРАТИ БЮЛЕТИН (Потребители)</a></div></li>
<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="send_bulletinA" href="send_Bulletin_Firms.php?test=1" <?=$pageName=='send_bulletin'?'class="active"':''?>>ИЗПРАТИ БЮЛЕТИН (Фирми)</a></div></li>
<li><div  style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="prstuffA" href="send_promo_mail.php?test=1" <?=$pageName=='send_promo_mail'?'class="active"':''?>>МАЙЛ ДО ВСИЧКИ (Оферта)</a></div></li>



<?php
if (isset($_SESSION['valid_user'])) 
{
?>
	
<?php
if ($_SESSION['user_kind']==2) 
{
?>	
 	<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="target_linksA" href="javascript:void(0);" <?=$pageName=='target_links'?'class="active"':''?>>ТАРГЕТ ВРЪЗКИ</a></div></li>
<li>
<!--4nd drop down menu -->                                                
<div id="dropmenu7" style="padding-left:10px;display:none;">
<img id="img_target_links_firms" src="images/menu_strelka_white.png" /><a onmouseover="$('img_target_links_firms').src='images/menu_strelka_orange.png';"onmouseout="$('img_target_links_firms').src='images/menu_strelka_white.png';"  class="blue"  href="target_links_firms.php" target="_self">Агенции</a><br />
<img id="img_target_links_hotels" src="images/menu_strelka_white.png" /><a onmouseover="$('img_target_links_hotels').src='images/menu_strelka_orange.png';"onmouseout="$('img_target_links_hotels').src='images/menu_strelka_white.png';"  class="blue" href="target_links_hotels.php" target="_self">Хотели</a><br />
<img id="img_target_links_trips" src="images/menu_strelka_white.png" /><a onmouseover="$('img_target_links_trips').src='images/menu_strelka_orange.png';"onmouseout="$('img_target_links_trips').src='images/menu_strelka_white.png';"  class="blue" href="target_links_trips.php" target="_self">Екскурзии</a><br />
<img id="img_target_links_offers" src="images/menu_strelka_white.png" /><a onmouseover="$('img_target_links_offers').src='images/menu_strelka_orange.png';"onmouseout="$('img_target_links_offers').src='images/menu_strelka_white.png';"  class="blue"  href="target_links_offers.php" target="_self">Почивки</a><br />
<img id="img_target_links_news" src="images/menu_strelka_white.png" /><a onmouseover="$('img_target_links_news').src='images/menu_strelka_orange.png';"onmouseout="$('img_target_links_news').src='images/menu_strelka_white.png';"  class="blue" href="target_links_news.php" target="_self">Новини</a><br />
<img id="img_target_links_posts" src="images/menu_strelka_white.png" /><a onmouseover="$('img_target_links_postrs').src='images/menu_strelka_orange.png';"onmouseout="$('img_target_links_posts').src='images/menu_strelka_white.png';"  class="blue" href="target_links_posts.php" target="_self">Статии</a><br />


</div>
</li>
<?php 
}
}
?>


<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a id="locationsA" href="../locations1.php" <?=$pageName=='locations'?'class="active"':''?>>ЛОКАЦИИ</a></div></li>

	
	
<?php
if (isset($_SESSION['valid_user']))
{
?>
	<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a href="logout.php" target="_self" <?=$pageName=='logout'?'class="active"':''?>>ИЗХОД</a></div></li>
<?php 
}
else 
{
?>
	<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a href="login.php" target="_self" <?=$pageName=='login'?'class="active"':''?>>ВХОД</a></div></li>
	<li><div style="padding-left:10px;padding-top:5px;padding-bottom:1px; background-image:url(images/bg2.gif); background-position:bottom; background-repeat:no-repeat"><a href="register_user.php" target="_self" <?=$pageName=='register_user'?'class="active"':''?>>РЕГИСТРАЦИЯ</a></div></li>
<?php 
}

?>

</ul>
</div>
<br style="clear: left;" />