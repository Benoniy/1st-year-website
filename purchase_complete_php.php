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
	
	$sql = "INSERT INTO customer_order (order_date, delivered, shipping_date, customer_number) VALUES (NOW(), FALSE, ADDDATE(NOW(), interval 3 day), ". $_SESSION['username'] .")";
	
	if (mysqli_query($link, $sql)){
		echo 'Success';
	}
	else{
		echo 'insert failure';
	}
	
	$query = "select * from customer_order";
	$result = mysqli_query($link, $query);
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
		{
			$i = 0;
			foreach ($row as $value)
			{
				if ($i == 0){
					$order_number = $value;
				}
				++$i;
			}
		}
	mysqli_free_result( $result );
	
	$i_code = $_GET['item_code'];
	$total = $_GET['total'];
	echo $total;
	$sql = "INSERT INTO order_item (item_code, value, order_number, quantity) VALUES ('". $i_code ."', ". $total .", ". $order_number .", 1)";
	echo $sql;
	if (mysqli_query($link, $sql)){
		echo 'Success';
	}
	else{
		echo 'insert failure';
	}
	
	$sql = "update inventory set item_stock_count = item_stock_count - 1 where item_code = '". $i_code ."'";
	
	if (mysqli_query($link, $sql)){
		echo 'Success';
	}
	else{
		echo 'insert failure';
	}
	mysqli_close( $link ); 
	header('location: purchase_complete.php');
?>