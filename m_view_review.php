<?php if (!isset($_SESSION)) {session_start();}?>
<?php 
	if ($_SESSION['manager'] != "true"){header('location: index.php');}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>The Shop</title>
		<link rel="stylesheet" type="text/css" href="sheet.css">
	</head>
	<body>
		<div class="topbar">
			<a href="index.php"><h1>The Shop</h1></a>
			<div class="menu">
				<a href="games.php"><h2>Games</h2></a>
				<a href="dvds.php"><h2 style="left: 29%;">Dvd's</h2></a>
				<a href="cds.php"><h2 style="right: 29%;">Cd's</h2></a>
				<a href="books.php"><h2 style="right: 0;">Books</h2></a>
			</div>
		</div>
		<div class="managerbar">
			<p class="p">Managment Bar:</p>
			<a href="m_view_customer.php"><p class="p" style="top:40px">Customer</p></a>
			<a href="m_view_customer_order.php"><p class="p" style="top:60px">Customer_order</p></a>
			<a href="m_view_inventory.php"><p class="p" style="top:80px">Inventory</p></a>
			<a href="m_view_inventory_group.php"><p class="p" style="top:100px">Inventory_group</p></a>
			<a href="m_view_manager.php"><p class="p" style="top:120px">Manager</p></a></td>
			<a href="m_view_order_item.php"><p class="p" style="top:140px">Order_item</p></a>
			<a href="m_view_promotion_code.php"><p class="p" style="top:160px">Promotion_code</p></a>
			<a href="m_view_review.php"><p class="p" style="top:180px">Review</p></a>
		</div>
		<?php
			if (array_key_exists('manager',$_SESSION)){
				echo '<a href="logout.php"><h3>Log out</h3></a>';
			}
			else{echo '<a href="login_selection.php"><h3>Log in</h3></a>';}
		?>
		<p style="left:0px;top:1px;color:white;position:fixed;">
		<?php
			if (array_key_exists('manager',$_SESSION)){
				echo 'Logged in as: ' .$_SESSION['username']. '';
			}
			else{echo 'Not logged in';}
		?>
		</p>
		<?php
			if ($_SESSION['manager'] == 'true')
			{
				echo '<a href="m_view_inventory.php"><p style="left:0px;top:17px;color:white;position:fixed;">View Tables</p></a>';
			}
		?>
		<div class="product_container">
			<?php
				$dbname = 'br17011';
				$dbuser = 'br17011';
				$dbpass = 'obscure';
				$dbhost = 'localhost';
				
				$link = mysqli_connect($dbhost, $dbuser, $dbpass)
				or die("unable to connect to database");
				
				mysqli_select_db($link, $dbname)
				or die("unable to open '$dbname'");
				
				$query = "select * from review";
				$result = mysqli_query($link, $query);

				echo '<table class="sql_table">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Review number</th>';
				echo '<th>Customer number</th>';
				echo '<th>Item code</th>';
				echo '<th>Rating</th>';
				echo '</tr>';
				echo '</thead>';
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
				{
					echo '<tr>';
					foreach ($row as $value)
					{
					echo '<td>'. $value .'</td>';
					}
					echo '</tr>';
				}
				echo '</table>';
				
				
				mysqli_free_result( $result );
				mysqli_close( $link ); 
			?>
		</div>
	</body>
</html>