<?php

	$hostname = "localhost";
	$username = "root";
	$password = "";

	$dbName1 = "accounts";

	$dbConnect = mysql_connect( $hostname , $username , $password );
	$dbSelect  = mysql_select_db( $dbName1 , $dbConnect );

	/*

	if (isset($_SESSION['sess_username']))
	{
		$team = $_SESSION['sess_team'];
		$username = $_SESSION['sess_username'];
		$dbConnect = mysql_connect( $hostname , $username , $password );
		$dbSelect  = mysql_select_db( $team , $dbConnect );

	}

	/*if ( $dbConnect)
		{
			echo "MySQL connection: PASS<br /> <br />";

			if ( $dbSelect )
				{
					echo  "Database (dev_ref_tracking) connecton: PASS<br /> <br />";
				}
			else
				{
					echo  "Database (dev_ref_tracking) connecton: FAILED<br /> <br />";
				}
		}
	else
		{
			echo "MySQL connection: FAILED<br /> <br />";
		}
*/

?>