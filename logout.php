<?php
	if (!isset($_SESSION)) {session_start();}
	session_destroy();
	header('location: logout_complete.php');
?>