<?php


RewriteBase /

#RewriteRule ^(.*)$ http://gozbite.com/$1 [R=301,L]  

#Начална Страница
RewriteRule ^начална-страница,([^-]*)\.html$ /index.php [L] 


#СТАТИИ
RewriteRule ^статии-етикет-категория-([^-]*),([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=posts&post_body=$1&page=$2&category=$3&limit=$4 [L] 
RewriteRule ^статии-етикет-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=posts&post_body=$1&page=$2&category=$3 [L] 
RewriteRule ^статии-етикет-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=posts&post_body=$1&page=$2&limit=$3 [L] 
RewriteRule ^статии-етикет-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=posts&post_body=$1&page=$2 [L] 
RewriteRule ^статии-етикет-([^-]*),([^-]*)\.html$ /index.php?pg=posts&post_body=$1 [L] 
RewriteRule ^статии-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=posts&category=$1&page=$2&limit=$3 [L] 
RewriteRule ^статии-категория-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=posts&category=$1&page=$2 [L] 
RewriteRule ^статии-категория-([^-]*),([^-]*)\.html$ /index.php?pg=posts&category=$1 [L] 
RewriteRule ^редактирай-статия-([^-]*),([^-]*)\.html$ /edit.php?pg=posts&edit=$1 [L] 
RewriteRule ^публикувай-статия,([^-]*)\.html$ /edit.php?pg=posts [L] 
RewriteRule ^изтрий-статия-([^-]*),([^-]*)\.html$ /edit.php?pg=posts&delete=$1 [L] 
RewriteRule ^изтрий-снимка-на-статия-([^-]*),([^-]*)\.html$ /edit.php?pg=posts&deletePic=$1 [L] 
RewriteRule ^изтрий-друга-снимка-на-статия-([^-]*),([^-]*)\.html$ /edit.php?pg=posts&deletePicMore=$1 [L] 
RewriteRule ^изтрий-видео-на-статия-([^-]*),([^-]*)\.html$ /edit.php?pg=posts&deleteVideo=$1 [L] 
RewriteRule ^търси-статия,([^-]*)\.html$ /index.php?pg=posts&search=1 [L] 
RewriteRule ^прочети-статии,([^-]*),([^-]*)\.html$ /index.php?pg=posts&page=$1 [L] 
RewriteRule ^procheti-statiq-([^-]*),([^-]*)\.html$ /index.php?pg=posts&postID=$1 [L] 
RewriteRule ^прочети-статия-([^-,]*),([^-]*)\.html$ /index.php?postID=$1&pg=posts [L] 
RewriteRule ^прочети-статии,([^-]*)\.html$ /index.php?pg=posts [L] 
RewriteRule ^статии-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?$1&page=$2&limit=$3&pg=posts [L] 
RewriteRule ^статии-([^-]*),([^-]*),([^-]*)\.html$ /index.php?$1&page=$2&pg=posts [L] 
RewriteRule ^статии-([^-]*),([^-]*)\.html$ /index.php?pg=posts&$1 [L] #index.php?pg=posts&post_autor_type=user&post_autor=1,текст.html


#Афоризми

RewriteRule ^афоризми-архив-етикет-([^-]*),([^-]*),([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&aphorism_body=$1&fromDate=$2&toDate=$3&page=$4&limit=$5 [L] 
RewriteRule ^афоризми-архив-етикет-([^-]*),([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&aphorism_body=$1&fromDate=$2&toDate=$3&page=$4 [L] 
RewriteRule ^афоризми-архив-етикет-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&aphorism_body=$1&fromDate=$2&toDate=$3 [L] 
RewriteRule ^афоризми-етикет-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&aphorism_body=$1&page=$2&limit=$3 [L] 
RewriteRule ^афоризми-етикет-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&aphorism_body=$1&page=$2 [L] 
RewriteRule ^афоризми-етикет-([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&aphorism_body=$1 [L] 
RewriteRule ^редактирай-афоризъм-([^-]*),([^-]*)\.html$ /edit.php?pg=aphorisms&edit=$1 [L] 
RewriteRule ^публикувай-афоризъм,([^-]*)\.html$ /edit.php?pg=aphorisms& [L] 
RewriteRule ^изтрий-афоризъм-([^-]*),([^-]*)\.html$ /edit.php?pg=aphorisms&delete=$1 [L] 
RewriteRule ^изтрий-снимка-на-афоризъм-([^-]*),([^-]*)\.html$ /edit.php?pg=aphorisms&deletePic=$1 [L] 
RewriteRule ^търси-афоризъм,([^-]*)\.html$ /index.php?pg=aphorisms&search=1 [L] 
RewriteRule ^прочети-афоризми,([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&page=$1 [L] 
RewriteRule ^procheti-aphorism-([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&aphorismID=$1 [L] 
RewriteRule ^прочети-афоризъм-([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&aphorismID=$1 [L] 
RewriteRule ^прочети-афоризми,([^-]*)\.html$ /index.php?pg=aphorisms [L] 
RewriteRule ^афоризми-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&$1&page=$2&limit=$3 [L] 
RewriteRule ^афоризми-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&$1&page=$2 [L] 
RewriteRule ^афоризми-([^-]*),([^-]*)\.html$ /index.php?pg=aphorisms&$1 [L] #aphorisms.php?aphorism_autor_type=user&aphorism_autor=1,текст.html





#Дестинации
RewriteRule ^изтрий-снимка-на-дестинация-([^-]*),([^-]*)\.html$ /edit.php?pg=locations&deletePic=$1 [L] 
RewriteRule ^редактирай-дестинация-([^-]*),([^-]*)\.html$ /edit.php?pg=locations&edit=$1 [L] 
RewriteRule ^опиши-дестинация,([^-]*)\.html$ /edit.php?pg=locations [L] 
RewriteRule ^изтрий-видео-на-статия-([^-]*),([^-]*)\.html$ /edit.php?pg=locations&deleteVideo=$1 [L] 
RewriteRule ^разгледай-дестинация-([^-]*),([^-]*)\.html$ /index.php?pg=locations&locationID=$1 [L] 
RewriteRule ^разгледай-дестинации,([^-]*)\.html$ /index.php?pg=locations [L] 
RewriteRule ^дестинации-([^-]*),([^-]*)\.html$ /index.php?pg=locations&$1 [L] #posts.php?post_autor_type=user&post_autor=1,текст.html



#Справочник
RewriteRule ^справочник-етикет-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=guides&tag=$1&page=$2&limit=$3 [L] 
RewriteRule ^справочник-етикет-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=guides&tag=$1&page=$2 [L] 
RewriteRule ^справочник-етикет-([^-]*),([^-]*)\.html$ /index.php?pg=guides&tag=$1 [L] 
RewriteRule ^справочник-буква-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=guides&letter=$1&page=$2&limit=$3 [L] 
RewriteRule ^справочник-буква-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=guides&letter=$1&page=$2 [L] 
RewriteRule ^справочник-буква-([^-]*),([^-]*)\.html$ /index.php?pg=guides&letter=$1 [L] 
RewriteRule ^редактирай-справочник-([^-]*),([^-]*)\.html$ /edit.php?pg=guides&edit=$1 [L] 
RewriteRule ^публикувай-справочник,([^-]*)\.html$ /edit.php?pg=guides [L] 
RewriteRule ^изтрий-справочник-([^-]*),([^-]*)\.html$ /edit.php?pg=guides&delete=$1 [L] 
RewriteRule ^изтрий-снимка-на-справочник-([^-]*),([^-]*)\.html$ /edit.php?pg=guides&deletePic=$1 [L] 
RewriteRule ^изтрий-друга-снимка-на-справочник-([^-]*),([^-]*)\.html$ /edit.php?pg=guides&deletePicMore=$1 [L] 
RewriteRule ^изтрий-видео-на-справочник-([^-]*),([^-]*)\.html$ /edit.php?pg=guides&deleteVideo=$1 [L] 
RewriteRule ^търси-справочник,([^-]*)\.html$ /index.php?pg=guides&search=1 [L] 
RewriteRule ^разгледай-справочник,([^-]*),([^-]*)\.html$ /index.php?pg=guides&page=$1 [L] 
RewriteRule ^разгледай-справочник-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=guides&guideID=$1&page=$2 [L] 
RewriteRule ^razgledai-spravochnik-([^-]*),([^-]*)\.html$ /index.php?pg=guides&guideID=$1 [L] 
RewriteRule ^разгледай-справочник-([^-]*),([^-]*)\.html$ /index.php?pg=guides&guideID=$1 [L] 
RewriteRule ^разгледай-справочник,([^-]*)\.html$ /index.php?pg=guides [L] 
RewriteRule ^справочник-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=guides&$1&page=$2&limit=$3 [L] 
RewriteRule ^справочник-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=guides&$1&page=$2 [L] 
RewriteRule ^справочник-([^-]*),([^-]*)\.html$ /index.php?pg=guides&$1 [L] #index.php?post_autor_type=user&post_autor=1,текст.html


#РЕЦЕПТИ
RewriteRule ^рецепти-етикет-категория-([^-]*),([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&tag=$1&page=$2&category=$3&limit=$4 [L] 
RewriteRule ^рецепти-етикет-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&tag=$1&page=$2&category=$3 [L] 
RewriteRule ^рецепти-етикет-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&tag=$1&page=$2&limit=$3 [L] 
RewriteRule ^рецепти-етикет-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&tag=$1&page=$2 [L] 
RewriteRule ^рецепти-етикет-([^-]*),([^-]*)\.html$ /index.php?pg=recipes&tag=$1 [L] 
RewriteRule ^рецепти-кухня-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&kuhnq=$1&page=$2&limit=$3 [L] 
RewriteRule ^рецепти-кухня-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&kuhnq=$1&page=$2 [L] 
RewriteRule ^рецепти-кухня-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&kuhnq=$1 [L] 
RewriteRule ^рецепти-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&category=$1&page=$2&limit=$3 [L] 
RewriteRule ^рецепти-категория-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&category=$1&page=$2 [L] 
RewriteRule ^рецепти-категория-([^-]*),([^-]*)\.html$ /index.php?pg=recipes&category=$1 [L] 
RewriteRule ^редактирай-рецепта-([^-]*),([^-]*)\.html$ /edit.php?pg=recipes&edit=$1 [L] 
RewriteRule ^добави-нова-рецепта,([^-]*)\.html$ /edit.php?pg=recipes [L] 
RewriteRule ^изтрий-рецепта-([^-]*),([^-]*)\.html$ /edit.php?pg=recipes&delete=$1 [L] 
RewriteRule ^изтрий-снимка-на-рецепта-([^-]*),([^-]*)\.html$ /edit.php?pg=recipes&deletePic=$1 [L] 
RewriteRule ^изтрий-друга-снимка-на-рецепта-([^-]*),([^-]*)\.html$ /edit.php?pg=recipes&deletePicMore=$1 [L] 
RewriteRule ^изтрий-видео-на-рецепта-([^-]*),([^-]*)\.html$ /edit.php?pg=recipes&deleteVideo=$1 [L] 
RewriteRule ^търси-рецепта,([^-]*)\.html$ /index.php?pg=recipes&search=1 [L] 
RewriteRule ^разгледай-рецепти,([^-]*),([^-]*)\.html$ /index.php?pg=recipes&page=$1 [L] 
RewriteRule ^разгледай-рецепта-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&recipeID=$1&page=$2 [L] 
RewriteRule ^razgledai-recepta-([^-]*),([^-]*)\.html$ /index.php?pg=recipes&recipeID=$1 [L] 
RewriteRule ^разгледай-рецепта-([^-]*),([^-]*)\.html$ /index.php?pg=recipes&recipeID=$1 [L] 
RewriteRule ^разгледай-рецепти,([^-]*)\.html$ /index.php?pg=recipes [L] 
RewriteRule ^рецепти-специалитети,([^-]*)\.html$ /index.php?pg=recipes&specialiteti=1 [L] #posts.php?post_autor_type=user&post_autor=1,текст.html
RewriteRule ^рецепти-специалитети,([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&specialiteti=1&page=$1&limit=$2 [L] 
RewriteRule ^рецепти-специалитети,([^-]*),([^-]*)\.html$ /index.php?pg=recipes&specialiteti=1&page=$1 [L] 
RewriteRule ^рецепти-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&$1&page=$2&limit=$3 [L] 
RewriteRule ^рецепти-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=recipes&$1&page=$2 [L] 
RewriteRule ^рецепти-([^-]*),([^-]*)\.html$ /index.php?pg=recipes&$1 [L] #posts.php?post_autor_type=user&post_autor=1,текст.html

#Кухня
RewriteRule ^разгледай-кухня-([^-]*),([^-]*)\.html$ /index.php?pg=kuhni&kuhnq=$1 [L] 
RewriteRule ^редактирай-кухня-([^-]*),([^-]*)\.html$ /edit.php?pg=kuhni&edit=$1 [L] 
RewriteRule ^добави-кухня,([^-]*)\.html$ /edit.php?pg=kuhni&edit [L] 



#Напитки
RewriteRule ^напитки-етикет-категория-([^-]*),([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&tag=$1&page=$2&category=$3&limit=$4 [L] 
RewriteRule ^напитки-етикет-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&tag=$1&page=$2&category=$3 [L] 
RewriteRule ^напитки-етикет-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&tag=$1&page=$2&limit=$3 [L] 
RewriteRule ^напитки-етикет-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&tag=$1&page=$2 [L] 
RewriteRule ^напитки-етикет-([^-]*),([^-]*)\.html$ /index.php?pg=drinks&tag=$1 [L] 
RewriteRule ^напитки-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&category=$1&page=$2&limit=$3 [L] 
RewriteRule ^напитки-категория-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&category=$1&page=$2 [L] 
RewriteRule ^напитки-категория-([^-]*),([^-]*)\.html$ /index.php?pg=drinks&category=$1 [L] 
RewriteRule ^редактирай-напитка-([^-]*),([^-]*)\.html$ /edit.php?pg=drinks&edit=$1 [L] 
RewriteRule ^добави-нова-напитка,([^-]*)\.html$ /edit.php?pg=drinks [L] 
RewriteRule ^изтрий-напитка-([^-]*),([^-]*)\.html$ /edit.php?pg=drinks&delete=$1 [L] 
RewriteRule ^изтрий-снимка-на-напитка-([^-]*),([^-]*)\.html$ /edit.php?pg=drinks&deletePic=$1 [L] 
RewriteRule ^изтрий-друга-снимка-на-напитка-([^-]*),([^-]*)\.html$ /edit.php?pg=drinks&deletePicMore=$1 [L] 
RewriteRule ^изтрий-видео-на-напитка-([^-]*),([^-]*)\.html$ /edit.php?pg=drinks&deleteVideo=$1 [L] 
RewriteRule ^търси-напитка,([^-]*)\.html$ /index.php?pg=drinks&search=1 [L] 
RewriteRule ^разгледай-напитки,([^-]*),([^-]*)\.html$ /index.php?pg=drinks&page=$1 [L] 
RewriteRule ^разгледай-напитка-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&drinkID=$1&page=$2 [L] 
RewriteRule ^razgledai-napitki-([^-]*),([^-]*)\.html$ /index.php?pg=drinks&drinkID=$1 [L] 
RewriteRule ^разгледай-напитка-([^-]*),([^-]*)\.html$ /index.php?pg=drinks&drinkID=$1 [L] 
RewriteRule ^разгледай-напитки,([^-]*)\.html$ /index.php?pg=drinks [L] 
RewriteRule ^напитки-специалитети,([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&specialiteti=1&page=$1&limit=$2 [L] 
RewriteRule ^напитки-специалитети,([^-]*),([^-]*)\.html$ /index.php?pg=drinks&specialiteti=1&page=$1 [L] 
RewriteRule ^напитки-специалитети,([^-]*)\.html$ /index.php?pg=drinks&specialiteti=1 [L] #posts.php?post_autor_type=user&post_autor=1,текст.html
RewriteRule ^напитки-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&$1&page=$2&limit=$3 [L] 
RewriteRule ^напитки-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=drinks&$1&page=$2 [L] 
RewriteRule ^напитки-([^-]*),([^-]*)\.html$ /index.php?pg=drinks&$1 [L] #posts.php?post_autor_type=user&post_autor=1,текст.html




#Фирми/Заведения
RewriteRule ^фирми-етикет-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=firms&tag=$1&page=$2&limit=$3 [L] 
RewriteRule ^фирми-етикет-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=firms&tag=$1&page=$2 [L] 
RewriteRule ^фирми-етикет-([^-]*),([^-]*)\.html$ /index.php?pg=firms&tag=$1 [L] 
RewriteRule ^фирми-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=firms&category=$1&page=$2&limit=$3 [L] 
RewriteRule ^фирми-категория-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=firms&category=$1&page=$2 [L] 
RewriteRule ^фирми-категория-([^-]*),([^-]*)\.html$ /index.php?pg=firms&category=$1 [L] 
RewriteRule ^редактирай-фирма-([^-]*),([^-]*)\.html$ /edit.php?pg=firms&edit=$1 [L] 
RewriteRule ^добави-фирма,([^-]*)\.html$ /edit.php?pg=firms&new_registration=yes [L] 
RewriteRule ^изтрий-фирма-([^-]*),([^-]*)\.html$ /edit.php?pg=firms&delete=$1 [L] 
RewriteRule ^изтрий-лого-на-фирма-([^-]*),([^-]*)\.html$ /edit.php?pg=firms&deleteLogo=$1 [L] 
RewriteRule ^изтрий-снимка-на-фирма-([^-]*),([^-]*)\.html$ /edit.php?pg=firms&deletePic=$1 [L] 
RewriteRule ^изтрий-друга-снимка-на-фирма-([^-]*),([^-]*)\.html$ /edit.php?pg=firms&deletePicMore=$1 [L] 
RewriteRule ^изтрий-видео-на-фирма-([^-]*),([^-]*)\.html$ /edit.php?pg=firms&deleteVideo=$1 [L] 
RewriteRule ^търси-фирма,([^-]*)\.html$ /index.php?pg=firms&search=1 [L] 
RewriteRule ^разгледай-фирми,([^-]*),([^-]*)\.html$ /index.php?pg=firms&page=$1 [L] 
RewriteRule ^разгледай-фирма-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=firms&firmID=$1&page=$2 [L] 
RewriteRule ^razgledai-firmi-([^-]*),([^-]*)\.html$ /index.php?pg=firms&firmID=$1 [L] 
RewriteRule ^разгледай-фирма-([^-]*),([^-]*)\.html$ /index.php?pg=firms&firmID=$1 [L] 
RewriteRule ^разгледай-фирми,([^-]*)\.html$ /index.php?pg=firms [L] 
RewriteRule ^фирми-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=firms&$1&page=$2&limit=$3 [L] 
RewriteRule ^фирми-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=firms&$1&page=$2 [L] 
RewriteRule ^фирми-([^-]*),([^-]*)\.html$ /index.php?pg=firms&$1 [L] #index.php?post_autor_type=user&post_autor=1,текст.html



#Болести

RewriteRule ^болести-етикет-категория-([^-]*),([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolest_body=$1&page=$2&category=$3&limit=$4 [L] 
RewriteRule ^болести-етикет-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolest_body=$1&page=$2&category=$3 [L] 
RewriteRule ^болести-етикет-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolest_body=$1&page=$2&limit=$3 [L] 
RewriteRule ^болести-етикет-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolest_body=$1&page=$2 [L] 
RewriteRule ^болести-етикет-([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolest_body=$1 [L] 
RewriteRule ^болести-симптом-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolest_simptom=$1&page=$2&limit=$3 [L] 
RewriteRule ^болести-симптом-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolest_simptom=$1&page=$2 [L] 
RewriteRule ^болести-симптом-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolest_simptom=$1 [L] 
RewriteRule ^болести-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&category=$1&page=$2&limit=$3 [L] 
RewriteRule ^болести-категория-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&category=$1&page=$2 [L] 
RewriteRule ^болести-категория-([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&category=$1 [L] 
RewriteRule ^редактирай-описание-болест-([^-]*),([^-]*)\.html$ /edit.php?pg=bolesti&edit=$1 [L] 
RewriteRule ^добави-нова-болест,([^-]*)\.html$ /edit.php?pg=bolesti [L] 
RewriteRule ^изтрий-болест-([^-]*),([^-]*)\.html$ /edit.php?pg=bolesti&delete=$1 [L] 
RewriteRule ^изтрий-друга-снимка-на-болест-([^-]*),([^-]*)\.html$ /edit.php?pg=bolesti&deletePicMore=$1 [L] 
RewriteRule ^изтрий-снимка-на-болест-([^-]*),([^-]*)\.html$ /edit.php?pg=bolesti&deletePic=$1 [L] 
RewriteRule ^изтрий-видео-на-болест-([^-]*),([^-]*)\.html$ /edit.php?pg=bolesti&deleteVideo=$1 [L] 
RewriteRule ^търси-болест,([^-]*)\.html$ /index.php?pg=bolesti&search=1 [L] 
RewriteRule ^разгледай-болести,([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&page=$1 [L] 
RewriteRule ^разгледай-болест-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolestID=$1&page=$2 [L] 
RewriteRule ^razgledai-bolest-([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolestID=$1 [L] 
RewriteRule ^разгледай-болест-([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&bolestID=$1 [L] 
RewriteRule ^разгледай-болести,([^-]*)\.html$ /index.php?pg=bolesti [L] 
RewriteRule ^болести-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&$1&page=$2&limit=$3 [L] 
RewriteRule ^болести-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&$1&page=$2 [L] 
RewriteRule ^болести-([^-]*),([^-]*)\.html$ /index.php?pg=bolesti&$1 [L] #index.php?post_autor_type=user&post_autor=1,текст.html



#Форум

RewriteRule ^форум-етикет-категория-([^-]*),([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=forums&question_body=$1&page=$2&category=$3&limit=$4 [L] 
RewriteRule ^форум-етикет-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=forums&question_body=$1&page=$2&category=$3 [L] 
RewriteRule ^форум-етикет-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=forums&question_body=$1&page=$2&limit=$3 [L] 
RewriteRule ^форум-етикет-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=forums&question_body=$1&page=$2 [L] 
RewriteRule ^форум-етикет-([^-]*),([^-]*)\.html$ /index.php?pg=forums&post_body=$1 [L] 

RewriteRule ^форум-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=forums&category=$1&page=$2&limit=$3 [L] 
RewriteRule ^форум-категория-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=forums&category=$1&page=$2 [L] 
RewriteRule ^форум-категория-([^-]*),([^-]*)\.html$ /index.php?pg=forums&category=$1 [L] 
RewriteRule ^търси-форум-тема,([^-]*)\.html$ /index.php?pg=forums&search=1 [L] 
RewriteRule ^отговори-форум-тема-цитирай-([^-]*),([^-]*),([^-]*)\.html$ /edit.php?pg=forums&edit=$1&citate=$2 [L] 
RewriteRule ^отговори-форум-тема-([^-]*),([^-]*),([^-]*)\.html$ /edit.php?pg=forums&edit=$1&page=$2 [L] 
RewriteRule ^отговори-форум-тема-([^-]*),([^-]*)\.html$ /edit.php?pg=forums&edit=$1 [L] 
RewriteRule ^редактирай-форум-мнение-([^-]*),([^-]*),([^-]*)\.html$ /edit.php?pg=forums&edit=$1&edit_forum=$2 [L] 
RewriteRule ^изтрий-форум-тема-([^-]*),([^-]*)\.html$ /edit.php?pg=forums&deleteQuestion=$1 [L] 
RewriteRule ^изтрий-форум-мнение-([^-]*),([^-]*)\.html$ /edit.php?pg=forums&deleteAnser=$1 [L] 
RewriteRule ^създай-форум-тема,([^-]*)\.html$ /edit.php?pg=forums&create_topic=1 [L] 
RewriteRule ^разгледай-форум-тема-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=forums&questionID=$1&page=$2&limit=$3 [L] 
RewriteRule ^разгледай-форум-тема-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=forums&questionID=$1&page=$2 [L] 
RewriteRule ^разгледай-форум-тема-([^-]*),([^-]*)\.html$ /index.php?pg=forums&questionID=$1 [L] 
RewriteRule ^разгледай-форум,([^-]*),([^-]*)\.html$ /index.php?pg=forums&page=$1 [L] 
RewriteRule ^разгледай-форум,([^-]*)\.html$ /index.php?pg=forums [L] 
RewriteRule ^форум-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=forums&$1&page=$2&limit=$3 [L] 
RewriteRule ^форум-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=forums&$1&page=$2 [L] 
RewriteRule ^форум-([^-]*),([^-]*)\.html$ /index.php?pg=forums&$1 [L] #index.php?post_autor_type=user&post_autor=1,текст.html

#RewriteRule ^форум-категория-([^-]*),([^-]*),([^-]*)\.html$ /forum [L] 
#RewriteRule ^форум-категория-([^-]*),([^-]*)\.html$ /forum [L] 
#RewriteRule ^търси-форум-тема,([^-]*)\.html$ /forum [L] 
#RewriteRule ^отговори-форум-тема-([^-]*),([^-]*)\.html$ /forum [L] 
#RewriteRule ^изтрий-форум-тема-([^-]*),([^-]*)\.html$ /forum [L] 
#RewriteRule ^създай-форум-тема,([^-]*)\.html$ /forum [L] 
#RewriteRule ^разгледай-форум,([^-]*),([^-]*)\.html$ /forum [L] 
#RewriteRule ^разгледай-форум-тема-([^-]*),([^-]*),([^-]*)\.html$ /forum [L] 
#RewriteRule ^разгледай-форум-тема-([^-]*),([^-]*)\.html$ /forum [L] 
#RewriteRule ^разгледай-форум,([^-]*)\.html$ /forum [L] 
#RewriteRule ^форум-([^-]*),([^-]*)\.html$ /forum [L] #index.php?post_autor_type=user&post_autor=1,текст.html



#КАРТИЧКИ
RewriteRule ^картички-категория-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=cards&category=$1&page=$2&limit=$3 [L] 
RewriteRule ^картички-категория-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=cards&category=$1&page=$2 [L] 
RewriteRule ^картички-категория-([^-]*),([^-]*)\.html$ /index.php?pg=cards&category=$1 [L] 
RewriteRule ^редактирай-картичка-([^-]*),([^-]*)\.html$ /edit.php?pg=cards&edit=$1 [L] 
RewriteRule ^добави-нова-картичка,([^-]*)\.html$ /edit.php?pg=cards [L] 
RewriteRule ^изтрий-картичка-([^-]*),([^-]*)\.html$ /edit.php?pg=cards&delete=$1 [L] 
RewriteRule ^изтрий-снимка-на-картичка-([^-]*),([^-]*)\.html$ /edit.php?pg=cards&deletePic=$1 [L] 
RewriteRule ^изтрий-друга-снимка-на-картичка-([^-]*),([^-]*)\.html$ /edit.php?pg=cards&deletePicMore=$1 [L] 
RewriteRule ^търси-картичка,([^-]*)\.html$ /index.php?pg=cards&search=1 [L] 
RewriteRule ^разгледай-картички,([^-]*),([^-]*)\.html$ /index.php?pg=cards&page=$1 [L] 
RewriteRule ^разгледай-картичка-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=cards&cardID=$1&page=$2 [L] 
RewriteRule ^razgledai-cartichka-([^-]*),([^-]*)\.html$ /index.php?pg=cards&cardID=$1 [L] 
RewriteRule ^разгледай-картичка-([^-]*),([^-]*)\.html$ /index.php?pg=cards&cardID=$1 [L] 
RewriteRule ^разгледай-картички,([^-]*)\.html$ /index.php?pg=cards [L] 
RewriteRule ^картички-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=cards&$1&page=$2&limit=$3 [L] 
RewriteRule ^картички-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=cards&$1&page=$2 [L] 
RewriteRule ^картички-([^-]*),([^-]*)\.html$ /index.php?pg=cards&$1 [L] #posts.php?post_autor_type=user&post_autor=1,текст.html



#Анкети
RewriteRule ^търси-анкета,([^-]*)\.html$ /index.php?pg=surveys&search=1 [L] 
RewriteRule ^разгледай-анкети,([^-]*),([^-]*)\.html$ /index.php?pg=surveys&page=$1 [L] 
RewriteRule ^разгледай-анкета-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=surveys&surveyID=$1&page=$2 [L] 
RewriteRule ^разгледай-анкета-([^-]*),([^-]*)\.html$ /index.php?pg=surveys&surveyID=$1 [L] 
RewriteRule ^разгледай-анкети,([^-]*)\.html$ /index.php?pg=surveys [L] 
RewriteRule ^анкети-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=surveys&$1&page=$2&limit=$3 [L] 
RewriteRule ^анкети-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=surveys&$1&page=$2 [L] 
RewriteRule ^анкети-([^-]*),([^-]*)\.html$ /index.php?pg=surveys&$1 [L] #aphorisms.php?aphorism_autor_type=user&aphorism_autor=1,текст.html
RewriteRule ^публикувай-анкета,([^-]*)\.html$ /edit.php?pg=surveys [L] 



#Страници
RewriteRule ^разгледай-страница-([^-]*),([^-]*)\.html$ /index.php?pg=stuff&get=$1 [L] 
RewriteRule ^редактирай-страница-([^-]*),([^-]*)\.html$ /edit.php?pg=stuff&edit=$1 [L] 
RewriteRule ^разгледай-страница-([^-]*)-([^-]*),([^-]*)\.html$ /index.php?pg=stuff&get=$1&getmore=$2 [L] 


#Реклама
RewriteRule ^разгледай-рекламни-оферти-([^-]*),([^-]*)\.html$ /index.php?pg=adv&get=$1 [L] 
RewriteRule ^разгледай-рекламни-оферти,([^-]*)\.html$ /index.php?pg=adv [L] 


#Статистика
RewriteRule ^разгледай-статистика-([^-]*),([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=statistics&get=$1&page=$2&orderby=$3 [L] 
RewriteRule ^разгледай-статистика-([^-]*),([^-]*),([^-]*)\.html$ /index.php?pg=statistics&get=$1&page=$2 [L] 
RewriteRule ^разгледай-статистика-([^-]*),([^-]*)\.html$ /index.php?pg=statistics&get=$1 [L] 
RewriteRule ^разгледай-статистика,([^-]*)\.html$ /index.php?pg=statistics [L] 



#Login && Regisraciq
RewriteRule ^забравена-парола-([^-]*),([^-]*)\.html$ /index.php?pg=login&forgotten_pass=1&what_login=$1 [L] 
RewriteRule ^забравена-парола,([^-]*)\.html$ /index.php?pg=login&forgotten_pass=1 [L] 
RewriteRule ^вход-([^-]*),([^-]*)\.html$ /index.php?pg=login&what_login=$1 [L] 
RewriteRule ^вход,([^-]*)\.html$ /index.php?pg=login [L] 
RewriteRule ^изход,([^-]*)\.html$ /index.php?pg=login&logout=1 [L] 
RewriteRule ^регистрация-([^-]*),([^-]*)\.html$ /index.php?pg=register&reg=$1 [L] 
RewriteRule ^регистрация,([^-]*)\.html$ /index.php?pg=register [L] 


#Потребители
RewriteRule ^редактирай-профил,([^-]*)\.html$ /edit.php?pg=profile [L] 
RewriteRule ^добави-нов-потребител,([^-]*)\.html$ /edit.php?pg=profile&new_registration=yes [L] 
RewriteRule ^изтрий-аватар-на-потребител-([^-]*),([^-]*)\.html$ /edit.php?pg=profile&deleteAvatar=$1 [L] 
RewriteRule ^изтрий-друга-снимка-на-потребител-([^-]*),([^-]*)\.html$ /edit.php?pg=profile&deletePicMore=$1 [L] 
RewriteRule ^изтрий-видео-на-потребител-([^-]*),([^-]*)\.html$ /edit.php?pg=profile&deleteVideo=$1 [L] 
RewriteRule ^разгледай-потребител-([^-]*),([^-]*)\.html$ /index.php?pg=users&userID=$1 [L] 
RewriteRule ^приятел-потребител-([^-]*),([^-]*)\.html$ /edit.php?pg=users&$1  [L] 

        
        

?>