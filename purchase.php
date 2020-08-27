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
			else{
				echo '<a href="login_selection.php"><h3>Log in</h3></a>';
			}
		?>
		<p style="left:0px;top:1px;color:white;position:fixed;">
			<?php
				if (array_key_exists('manager',$_SESSION)){
					echo 'Logged in as: ' .$_SESSION['username']. '';
				}
				else{
					echo 'Not logged in';
				}
			?>
		</p>
		<?php
			if ($_SESSION['manager'] == 'true')
			{
				echo '<a href="m_view_inventory.php"><p style="left:0px;top:17px;color:white;position:fixed;">View Tables</p></a>';
			}
		?>
		<div class="product_container" style="width:100%left:0px;">
			<?php
				$dbname = 'br17011';
				$dbuser = 'br17011';
				$dbpass = 'obscure';
				$dbhost = 'localhost';
				
				$link = mysqli_connect($dbhost, $dbuser, $dbpass)
				or die("unable to connect to database");
				
				mysqli_select_db($link, $dbname)
				or die("unable to open '$dbname'");
				
				if ($_GET['search'] != null){
					$search = ' where item_code like "%'. $_GET['id'] .'%"';
				}
				else{
					$search = '';
				}
				
				$id_v = $_GET['id'];
				echo '<div class="purchase_container">';
				$query = 'select * from inventory where item_code like "%'. $_GET['id'] .'%"';
				$result = mysqli_query($link, $query);
				
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
				{
					$i = 0;
					foreach ($row as $value)
					{
						if ($i == 0){
							$id_v = $value;
						}
						else if ($i == 1){/*name*/
							echo '<p class="prod_name_p">'. $value .'</p>';
						}
						else if ($i == 2){/*desc*/
							echo '<p class="prod_desc_p">'. $value .'</p>';
						}
						else if ($i == 3){/*author*/
							echo '<p class="prod_auth_p">Author: '. $value .'</p>';
						}
						else if ($i == 4){/*image*/
							echo '<img class="prod_img_p" src="images/'. $value .'" height="360" width="360">';
						}
						else if ($i == 6){/*price*/
							echo '<p class="prod_price_p">Price: £'. $value .'</p>';
							$price = $value;
						}
						else if ($i == 8){/*stock count*/
							echo '<p class="prod_stock_p">Stock:'. $value .'</p>';
							$stock_count = $value;
						}
						++$i;
					}
				}
				
				echo '<form style="position:absolute;width:360px;top:200px;right:0px;text-align:center;" action="purchase.php?id='. $id_v .'" method="POST">';
				echo '<p style="margin:0px;padding:0px;">Promotional Code:</p>';
				echo '<input type="search" name="p_code"><br>';
				echo '</form>';
				$promo_c = $_POST['p_code'];
				
				$query = 'select * from promotion_code where code = "'. $promo_c .'"';
				$result = mysqli_query($link, $query);
				if (mysqli_num_rows($result) > 0){
					while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
						$i = 0;
						foreach ($row as $value){
							if ($i == 1){
								$total = $price - ($price / $value);
							}
							++$i;
						}
					}
					echo '<p style="text-align:center;position:absolute;width:360px;right:0px;top:240px;">promo active</p>';
				}
				else{
					$total = $price;
					echo '<p style="text-align:center;position:absolute;width:360px;right:0px;top:240px;">promo inactive</p>';
				}
				$total = round($total, 2);
				$total = number_format($total,"2");
				echo '<p class="prod_price_p" style="top:135px;">Total: £'. $total. '</p>';
				
				echo '<div class="p_box">';
				if (array_key_exists('manager',$_SESSION)){
					if ($stock_count <= 0){
						echo '<p>Out of stock</p>';
					}
					else{
						echo '<a href="purchase_complete_php.php?item_code='. $id_v .'&total='. $total .'"><p>Complete Purchase</p></a>';
					}
				}
				else{
					echo '<p>Please log in to purchase</p>';
				}
				echo '</div>';
				echo '</div>';
				mysqli_free_result( $result );
				mysqli_close( $link ); 
			?>
		</div>
	</body>
</html>