<? 
	
	 include_once("../../includes/header.inc.php");
   
  
  $conn = new mysqldb();
  
$output = '';
$month = $_GET['month'];
$year = $_GET['year'];
	
if($month == '' && $year == '') { 
	$time = time();
	$month = date('n',$time);
    $year = date('Y',$time);
}

$date = getdate(mktime(0,0,0,$month,1,$year));
$today = getdate();
$hours = $today['hours'];
$mins = $today['minutes'];
$secs = $today['seconds'];

if(strlen($hours)<2) $hours="0".$hours;
if(strlen($mins)<2) $mins="0".$mins;
if(strlen($secs)<2) $secs="0".$secs;

$days=date("t",mktime(0,0,0,$month,1,$year));
$start = $date['wday']+1;
$name = $date['month'];
$year2 = $date['year'];
$offset = $days + $start - 1;
 
if($month==12) { 
	$next=1; 
	$nexty=$year + 1; 
} else { 
	$next=$month + 1; 
	$nexty=$year; 
}

if($month==1) { 
	$prev=12; 
	$prevy=$year - 1; 
} else { 
	$prev=$month - 1; 
	$prevy=$year; 
}

if($offset <= 28) $weeks=28; 
elseif($offset > 35) $weeks = 42; 
else $weeks = 35; 

$output .= "
<table class='cal' cellspacing='1'>
<tr>
	<td colspan='7'>
		<table class='calhead'>
		<tr>
			<td align='center'>
				<a href='javascript:navigate($prev,$prevy)'><img src='index_inc/ajax_calendar/calLeft.gif'></a> <a href='javascript:navigate(\"\",\"\")'><img src='index_inc/ajax_calendar/calCenter.gif'></a> <a href='javascript:navigate($next,$nexty)'><img src='index_inc/ajax_calendar/calRight.gif'></a>
			</td>
		</tr>
		<tr>
			<td align='center'>
				<div>".getMonthCyrName($name)." $year2</div>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr class='dayhead'>
	<td>Н</td>
	<td>П</td>
	<td>В</td>
	<td>С</td>
	<td>Ч</td>
	<td>П</td>
	<td>С</td>	
</tr>";

$col=1;
$cur=1;
$next=0;

for($i=1;$i<=$weeks;$i++) { 
	if($next==3) $next=0;
	if($col==1) $output.="<tr class='dayrow'>"; 
  	
	
   $sql = "select * from posts WHERE date LIKE '%".$year2."-".getMonthNum($name)."-".(($cur<10)?"0".$cur:$cur)."%'   order by date DESC ";
   $conn->setSQL($sql);
   $conn->getTableRows();
   $resultPostsCal = $conn->result; 
   $numPostsCal = $conn->numberrows;

   if($numPostsCal>0) $link=" <a style='color:#FFF;' href='статии-page=".$_REQUEST['page']."&fromDate=".((($cur<10)?"0".$cur:$cur).'.'.getMonthNum($name).'.'.$year2)."&toDate=".(((($cur+1)<10)?"0".($cur+1):($cur+1)).'.'.getMonthNum($name).'.'.$year2).",интересни_туристически_статии_пътеписи_полезни_съвети.html'>$cur</a>";
   else $link=$cur;
	
   if($numPostsCal>0) $style=" style='background-color:#FF6600; cursor: pointer; text-decoration:underline;'";
   else $style='';
   
   if($numPostsCal>0) $click = " onclick=\"document.location.href='статии-page=".$_REQUEST['page']."&fromDate=".((($cur<10)?"0".$cur:$cur).'.'.getMonthNum($name).'.'.$year2)."&toDate=".(((($cur+1)<10)?"0".($cur+1):($cur+1)).'.'.getMonthNum($name).'.'.$year2).",интересни_туристически_статии_пътеписи_полезни_съвети.html'\"";
   else $click = '';
	
	
   
	$output.="<td valign='top' ".$click."  onMouseOver=\"this.className='dayover'\" onMouseOut=\"this.className='dayout'\" ".$style.">";

	if($i <= ($days+($start-1)) && $i >= $start) {
		$output.="<div class='day'><b";

		if(($cur==$today[mday]) && ($name==$today[month])) $output.=" style='color:#FF6600;'";

		$output.=">$link</b></div></td>";

		$cur++; 
		$col++; 
		
	} else { 
		$output.="&nbsp;</td>"; 
		$col++; 
	}  
	    
    if($col==8) { 
	    $output.="</tr>"; 
	    $col=1; 
    }
}

$output.="</table>";
  
echo $output;

?>
