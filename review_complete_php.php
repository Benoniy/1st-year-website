<?php
	if (!isset($_SESSION)) {session_start();}
	$dbname = 'br17011';
	$dbuser = 'br17011';
	$dbpass = 'obscure';
	$dbhost = 'localhost';
	
	$link = mysqli_connect($dbhost, $dbuser, $dbpass)
	or die("unable to connect to database");
	
	mysqli_select_db($link, $dbname)
	or die("unable to open '$dbname'");
	
	$item_code = $_GET['id'];
	$customer_number = $_SESSION['username'];
	$rating = $_GET['score'];
	
	$sql = "INSERT INTO review (customer_number, item_code, rating) VALUES (". $customer_number .", '". $item_code ."', ". $rating .")";
	
	echo $sql;
	
	if (mysqli_query($link, $sql)){
		echo 'Success';
	}
	else{
		echo 'insert failure';
	}
	
	mysqli_close( $link ); 
	header('location: review_complete.php');
?>