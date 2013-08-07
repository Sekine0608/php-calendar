<html>

<?php
function firstWeekCode($year, $month){

	return weekCode($year, $month, 1);
}

function weekCode($year, $month, $date){
	$y = intval( $year );
	$m = intval( $month );
	$d = intval( $date );
	if( $m == 1 or $m == 2 ){
		$y -= 1;
		$m += 12;
	}
	$result = ( $y + intval( $y / 4 ) - intval( $y / 100 ) + intval( $y / 400 ) + intval( ( 13 * $m + 8 ) / 5 ) + $d ) % 7;
	return $result;
	/* 日:0 月:1 火:2 水:3 木:4 金:5 土:6 */
}

function isUru($year){
		return ($year % 4 == 0) && ($year % 100 != 0) || ($year % 400 == 0) ; 
}

function maxDate($year, $month){
	$result = -1 ;
	switch($month){
		case 1:
			$result = 31 ;
			break ;
		case 2:
			if(isUru($year)){
				$result = 29 ;
			}else{
				$result = 28 ;
			}
			break ;
		case 3:
			$result = 31 ;
			break ;
		case 4:
			$result = 30 ;
			break ;
		case 5:
			$result = 31 ;
			break ;
		case 6:
			$result = 30 ;
			break ;
		case 7:
			$result = 31 ;
			break ;
		case 8:
			$result = 31 ;
			break ;
		case 9:
			$result = 30 ;
			break ;
		case 10:
			$result = 31 ;
			break ;
		case 11:
			$result = 30 ;
			break ;
		case 12:
			$result = 31 ;
			break ;
			
	}
	return $result ;
}

function weekStringForWeekCode($code){
	$result = '不明' ;
	switch($code){
		case 0:
			$result = '日' ;	
			break; 
		case 1:
			$result = '月' ;	
			break; 
		case 2:
			$result = '火' ;	
			break; 
		case 3:
			$result = '水' ;	
			break; 
		case 4:
			$result = '木' ;	
			break; 
		case 5:
			$result = '金' ;	
			break; 
		case 6:
			$result = '土' ;	
			break; 
	}
	return $result ;
}
function monthOflastMonth($month){
	$month-- ;
	if($month == 0){
		$month = 12 ;
	}
	return $month ;
}
function monthOfnextMonth($month){
	$month++ ;
	if($month == 13){
		$month = 1 ;
	}
	return $month ;
}
function yearOflastMonth($year,$month){
	if($month == 1){
		$year-- ;
	}
	return $year ;
}
function yearOfnextMonth($year,$month){
	if($month == 12){
		$year++ ;
	}
	return $year ;
}
function getUrlParams($year, $month, $date){
	$result = '?year='.$year.'&month='.$month.'&date='.$date ;
	return $result ; 
}

function makeCalendar($year, $month){
	$firstWeekCode = firstWeekCode($year, $month) ;
	$weekIndex = 0;
	$maxDate = maxDate($year, $month) ;

	/*先月の年*/	
	$yearOfLastMonth =  yearOfLastMonth($year, $month) ; 
	/*先月の月*/
	$monthOfLastMonth = monthOfLastMonth($month) ;
	/*来月の年*/
	$yearOfNextMonth = yearOfNextMonth($year, $month) ; 
	/*先月の月*/
	$monthOfNextMonth = monthOfNextMonth($month) ;
	/*先月の最終日*/
	$maxDateOfLastMonth = maxDate($yearOfLastMonth, $monthOfLastMonth) ; 


	echo $year . '/' . $month ;

	echo '<table border="1"><tr>' ;
	for($i = 0 ; $i <= 6 ; $i++){
		echo '<td>'. weekStringForWeekCode($i). '</td>' ;
	}	
	echo '</tr>' ;
	for($i = 1-$firstWeekCode; $i<=6*7-$firstWeekCode; $i++){
		$dispDay = '-1' ;
		$nextMonth = false ;
		$lastMonth = false ;
		$urlParams = '' ;

		if($i <= 0){
			$dispDay = $i + $maxDateOfLastMonth ; 	
			$lastMonth = true ;
		}else if($i > $maxDate){
			$dispDay = $i - $maxDate;
			$nextMonth = true ; 
		}else{
			$dispDay = $i ;	
		}
		
		if($nextMonth){
			$urlParams = getUrlParams($yearOfNextMonth, $monthOfNextMonth, $dispDay) ;
		}else if($lastMonth){
			$urlParams = getUrlParams($yearOfLastMonth, $monthOfLastMonth, $dispDay) ;
		}else{
			$urlParams = getUrlParams($year, $month, $i) ;
		}

		if($weekIndex == 0){
			$color = 'red' ;
			if($nextMonth || $lastMonth){
				$color = '#ffc0c0' ;	
			}
				echo '<td><a href="schedule.php'.$urlParams.'"><font color="'. $color . '">' . $dispDay . '</font></a></td>' ;
			}else if($weekIndex == 6){
			$color = 'blue' ;
			if($nextMonth || $lastMonth){
				$color = '#00e0e0' ;	
			}
				echo '<td><a href="schedule.php'.$urlParams.'"><font color="'. $color . '">' . $dispDay . '</font></a></td>' ;
		}else{	
			$color = 'black' ;
			if($nextMonth || $lastMonth){
				$color = '#a0a0a0' ;	
			}
				echo '<td><a href="schedule.php'.$urlParams.'"><font color="'. $color . '">' . $dispDay . '</font></a></td>' ;
		}	

		$weekIndex++ ;
		
		if($weekIndex > 6){
			echo '</tr><tr>' ;
			$weekIndex = 0 ;
		}
	}
	echo '</tr></table>' ;
}


function allCalendar($year, $month){
	echo '<table><tr>';
	for($i=1 ; $i<=12 ; $i++){
		if($i == $month){
			echo '<td bgcolor="#ffffc0">' ;
		}else{	
			echo '<td>' ;
		}	
		makeCalendar($year, $i) ;	
		echo '</td>' ;
		if($i % 4 == 0){
			echo '</tr><tr>' ;
		}
	}
	echo '</tr></table>' ;
}

?>
<body>
<?php
	$year = (int)$_GET['year']; 
	$month = (int)$_GET['month']; 
	$all = $_GET['all'] ;
?>
	<form action="calendar.php" method="get">
	 年：<input type="text" name="year" <?php if($year!='')echo 'value='.$year?> >
	 月：<input type="text" name="month" <?php if($month!='')echo 'value='.$month?> >
	 年間表示：<input type="checkbox" <?php if($all=='y')echo 'checked="true"' ?> name="all" value="y">
	 <input type="submit" />
	</form>

<?php 
	

	if($year == '') {
		try{
			ini_set('display_errors', 'Off');
			$year = (int)date("Y") ;
			$month = (int)date("n") ;
			
		}catch(Exception $e){
		}
	}
	
	$allParam = '&all=n' ;
	
	if($all == 'y'){
		$allParam ='&all=y' ;
	}	
	echo '<a href="calendar.php'.getUrlParams(yearOfLastMonth($year,$month), monthOfLastMonth($month),1).$allParam.'">前へ</a>　' ;
	echo '<a href="calendar.php'.getUrlParams(yearOfNextMonth($year,$month), monthOfNextMonth($month),1).$allParam.'">次へ</a>' ;
	echo '<br />';

	if($all == 'y'){
		allCalendar($year,$month) ;
	}else{
		makeCalendar($year,$month) ;
	}
?> 

	<br />

</body>
</html>
