<?php

	$hostname = "localhost";
	$username = "root";
	$password = "";

	$dbName = "aguaruim_tf2logs";

	$dbConnect = mysql_connect( $hostname , $username , $password );
	$dbSelect  = mysql_select_db( $dbName , $dbConnect );



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