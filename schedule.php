<html>


<body>
<?php
	$year = (int)$_GET['year']; 
	$month = (int)$_GET['month']; 
	$date= $_GET['date'] ;
	echo $year . '/' . $month .'/' . $date .'のスケジュール' ;
	echo '<br />MySQLと連結する予定'
?>

</body>
</html>


