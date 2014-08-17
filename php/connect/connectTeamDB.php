<?php
	$hostname = "localhost";
	$username = "root";
	$password = "";

	$team = $_SESSION['sess_team'];
	$dbConnect = mysql_connect( $hostname , $username , $password );
	$dbSelect  = mysql_select_db( $team , $dbConnect );


?>