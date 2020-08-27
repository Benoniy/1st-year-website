<?php if (!isset($_SESSION)) {session_start();}?>

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
		<div class="product_container" style="width:100%left:0px;text-align:center;">
			<p>Please enter a rating for the product</p>
			<form action="review_complete_php.php" method="GET">
				<input type="radio" name="score" value="1">1<br>
				<input type="radio" name="score" value="2">2<br>
				<input type="radio" name="score" value="3">3<br>
				<input type="radio" name="score" value="4">4<br>
				<input type="radio" name="score" value="5">5<br>
				<button type="submit" name="id" value="<?php echo $_GET['id'];?>">Submit</button>
			</form>
		</div>
	</body>
</html>