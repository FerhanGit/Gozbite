<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$statistics_big = "";
   	
			
$statistics_big .= '<div class="postBig">
<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
	<div id="Main_Top" style="float:left; width:660px; ">
	

	<div id="track1" class="track" style="margin-right:5px; width: 130px; margin-bottom:3px;" >
	   <div id="handle1" class="handle" style="width: 30px;" ><p id="changed" style="color:#FFFFFF; text-align:center;  font-size:10px; font-weight:bold; line-height:1.2;">12px</p></div>
	</div>
	
	<script type="text/javascript">
		new Control.Slider(\'handle1\' , \'track1\',
		{
			range: $R(10,28),
			values: [10,12,14,18,24,28],
			sliderValue: 12,
			onChange: function(v){
				var objTextBody = document.getElementById("bodyDiv");		
			   	objTextBody.style.fontSize = v+"px";
			   	$(\'changed\').innerHTML = v+\'px\';
			},
			onSlide: function(v) {
			  	var objTextBody = document.getElementById("bodyDiv");
			  	objTextBody.style.fontSize = v+"px";
			  	$(\'changed\').innerHTML = v+\'px\';			  
			}
		} );
	</script>	
	
	
	  	<h4 style=\'margin: 10px 0px 0px 0px; padding-left:20px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;\'>'.getPageTitle($_REQUEST['get']).'</h4>
    </div><br style="clear:left;"/>';

    
 $statistics_big .= '<div class="postBig" id="bodyDiv">
	<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
	<h4 style=\'margin: 10px 0px 20px 0px; padding-left:5px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;\'>
		Статистически Данни за най-четени материали от базата данни на GoZbiTe.Com
	</h4>
		
	                
	                 <table align="center" border="0" >
	                 <tr>
	                 	<td><a href="разгледай-статистика-firms,сладкарници_барове_заведения_пицарии_механи_закусвални_таверни_дискотеки_рецепти_напитки_статии.html">Заведения/Фирми</a> | </td> <td><a href="разгледай-статистика-recipes,сладкарници_барове_заведения_пицарии_механи_закусвални_таверни_дискотеки_рецепти_напитки_статии.html">Рецепти</a> | </td> <td><a href="разгледай-статистика-drinks,сладкарници_барове_заведения_пицарии_механи_закусвални_таверни_дискотеки_рецепти_напитки_статии.html">Напитки</a> | </td> 
						<td><a href="разгледай-статистика-guides,сладкарници_барове_заведения_пицарии_механи_закусвални_таверни_дискотеки_рецепти_напитки_статии.html">Справочни Описания</a> | </td><td><a href="разгледай-статистика-posts,сладкарници_барове_заведения_пицарии_механи_закусвални_таверни_дискотеки_рецепти_напитки_статии.html">Статии</a></td>
                 	 </tr></table> ';    
        
	        $statistics_big .= include("pages_include.php");
	            	
	        
	$statistics_big .= '     
	
</div>';    	
       
$statistics_big .= '
	</div><br style="clear:left;"/></div>
</div><br style="clear:left;"/>	';


return $statistics_big;

?>