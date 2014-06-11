<?php

	session_start();
	require("connect/connectDB.php");

	if (isset($_SESSION['sess_username']))
	{

		if ($_SESSION['sess_user_id'] == 0) 
		{
			$teams = trim($_POST['teams2']);
			$filename="$teams".date('G_a_m_d_y').'.sql';
			$result=exec("mysqldump -u 'root' -p ' ' ".$teams." < ./database/$db_name.sql");  .$filename,$output);
		}

	}


?>