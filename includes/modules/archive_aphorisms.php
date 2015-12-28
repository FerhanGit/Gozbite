<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$archive = "";
	$archive .= '<li class="boxRightHalf" style="margin-right:0;padding-right:0px;">
		<div class="title" style="margin-bottom:10px">Архив - Фрази</div>
		 <div class="contentBox">';
			$archive .= '<div id="calback">
							<div id="calendar"></div>
						</div>'; 
	$archive .= '</div>		
			</li>';
		
	return $archive;
	  
	?>
