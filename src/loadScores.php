<?php
	error_reporting(0);
	
	set_include_path($_SERVER['DOCUMENT_ROOT']  . "/" . "modules");
	
	// Require modules
	require_once( 'Constants.class.php');

	$range = $_POST['range'];
	
	if($range == "day") {
		$whereClause = "WHERE DATE(score_date) = CURDATE()";
	}
	else if($range == "week") {
		$whereClause = "WHERE DATE(score_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";		
	}
	else if($range == "month") {
		$whereClause = "WHERE DATE(score_date) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";	
	}
	else if($range == "year") {
		$whereClause = "WHERE DATE(score_date) BETWEEN CURDATE() - INTERVAL 365 DAY AND CURDATE()";	
	}
	else if($range == "all") {
		$whereClause = "";
	}
		
	$connect = mysqli_connect(Constants::DB_HOST, Constants::DB_USER, Constants::DB_PASSWORD);
	mysqli_select_db($connect,"hallaby_bunny");
	
	$str = "SELECT * FROM high_scores " . $whereClause . " ORDER BY score DESC, score_date DESC LIMIT 10";
	$query = mysqli_query($connect,$str);
	
	$str = "&hhnothing=1";
	
	$i = 1;
	while($rows = mysqli_fetch_array($query)):
		
		$username = $rows['username'];
		$score = $rows['score'];
		$str .= "&hsuser" . $i . "=" . $username;
		$str .= "&hs" . $i . "=" . $score;
		
		$i++;
		
	endwhile;

	while($i < 11) {
		
		$str .= "&hsuser" . $i . "=Bunny";
		$str .= "&hs" . $i . "=0";
		
		$i++;
	}
	
	echo $str;
	
	mysqli_close($connect);
?>