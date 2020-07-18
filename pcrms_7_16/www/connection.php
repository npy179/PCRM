<?php
		$hostname_connection = "127.0.0.1";
		$database_connection = "PCRMSV4";
		$username_connection = "drsulab";
		$password_connection = "drsulab";
		$connection = mysqli_connect($hostname_connection, $username_connection, $password_connection, $database_connection) or trigger_error(mysql_error(), E_USER_ERROR);
?>
