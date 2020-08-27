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
		<div class="sidebar">
			<form style="position:relative;top:15%;width:100%;" action="index.php" method="GET">
				Search (Submit with Enter):<br>
				<input style="width:95%;" type="search" name="search">
			</form>
			<a href="reset.php"><p style="bottom:0px;position:absolute;width:100%;text-align:center;color:white;">Reset Database</p></a>
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
				
				if ($_GET['search'] != null){
					$search = ' and item_description like "%'. $_GET['search'] .'%"';
				}
				else{
					$search = '';
				}
				
				$query = "select * from inventory where item_group = 1002". $search ."";
				$result = mysqli_query($link, $query);
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
				{
					echo '<div class="product">';
					$i = 0;
					foreach ($row as $value)
					{
						if ($i == 0){/*item code for identification*/
							echo '<div class="prod_button"><a href="purchase.php?id='. $value .'">Buy now!</a></div>';
							if ($_SESSION['manager'] == 'true'){
								echo '<a href="review.php?id='. $value .'"><p class="review_button">Review this product!</p></a>';
							}
							else{
								echo '<p class="review_button">Log in to review this product!</p>';
							}
						}
						if ($i == 1){/*name*/
							echo '<p class="prod_name">'. $value .'</p>';
						}
						else if ($i == 2){/*desc*/
							echo '<p class="prod_desc">'. $value .'</p>';
						}
						else if ($i == 3){/*author*/
							echo '<p class="prod_auth">'. $value .'</p>';
						}
						else if ($i == 4){/*image*/
							echo '<img class="prod_img" src="images/'. $value .'" height="240" width="240">';
						}
						else if ($i == 6){/*price*/
							echo '<p class="prod_price">£'. $value .'</p>';
						}
						else if ($i == 8){/*stock count*/
							echo '<p class="prod_stock">Stock:'. $value .'</p>';
						}
						++$i;
					}
					echo '</div>';
				}
				mysqli_free_result( $result );
				mysqli_close( $link ); 
			?>
		</div>
	</body>
</html>