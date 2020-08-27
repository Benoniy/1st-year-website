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
		<div class="login_screen">
			<form style="text-align:center" method = "GET">
				Username:<br>
				<input type = "text" name = "username"><br>
				Password:<br>
				<input type = "text" name = "passwd"><br>
				<input type = "submit" value = "login">
			</form>
			<script type="text/javascript">
				var ussr = document.getElementsByName("username");
				var passwrd = document.getElementsByName("passwd");
					if(isNaN(ussr) || passwrd == null){
						document.write('<p>Login failed, Try again!</p>');
					}
					else{
						<?php
							session_start();
							$_SESSION = array();
							
							if ( isset( $_GET['username'] ) && isset( $_GET['passwd'] ) )
							{
								$username = $_GET['username'];
								$passwd = $_GET['passwd'];
								$_SESSION['manager'] = 'true';

								$dbname = 'br17011'; 
								$dbuser = 'br17011';
								$dbpass = 'obscure';
								$dbhost = 'localhost';

								$link = mysqli_connect( $dbhost, $dbuser, $dbpass )
								or die( "Unable to Connect to: '$dbhost'" );

								mysqli_select_db( $link, $dbname )
								or die("Could not open the database: '$dbname'");
								
								$passwd_check = "Select * From manager Where manager_number = '".$username."' And passwd = MD5( '".$passwd."' )";
								$dbOutput = mysqli_query($link,$passwd_check);
								
								if (mysqli_num_rows($dbOutput) == 1)
								{
									$_SESSION['username'] = $username;
									header('location: index.php');
									exit();
								}
								else
								{
									echo "document.write('<p>Login failed, Try again!</p>');";
								}
							}
						?> 
					}
			</script>
		</div>
	</body>
</html>