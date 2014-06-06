
 <!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript" ></script>
		<script type="text/javascript" src="jscripts/formvalidation.js"></script>
		<title>
			Register
		</title>
	</head>
	<body>

		<div id="registration">
			<ul id="input">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<li>Username:</li><input type="text" name="username" /> 
					<li>Password:</li> <input type="text" name="password" />
					<li>User Level:</li>
					<select name="user">
						<option value="0">Super Admin</option><!--edit all tables-->
						<option value="1">1</option><!--edit Disney princesstable -->
					</select>
				 	<li id="fSubmit"><input type="submit" value="Create Acccount" />
				</form>
			</ul>
		</div>


<?php

session_start();

   if ($_SESSION['sess_username'])
   {

		 if ($_SESSION['sess_user_id'] == 0) 
		 {

			require("../connect/connectDB.php");
			
			if(isset($_POST[ 'username' ]))
			{
				$name = $_POST[ 'username' ];

			}
			if(isset($_POST[ 'password' ]))
			{
				$salt = dechex( mt_rand (0, 2147483647) ) . dechex( mt_rand (0, 2147483647) ); 
				$password = hash('sha256', $_POST['password'] . $salt); 

			}
			if(isset($_POST[ 'user' ]))
			{
				$level = $_POST[ 'user' ];
			}


			if(isset($_POST[ 'username' ]) && isset($_POST[ 'password' ]) && isset($_POST[ 'password' ]))
			{
				$insert = "INSERT INTO users( users_name , users_password, users_passsalt , users_level)
				 			VALUES( '$name' , '$password' , '$salt' , '$level')";


				$result = mysql_query( $insert );  


				if( $result )
				{
			  		echo("Account succesfully created.<br />");
				} 
				else
				{
			    	echo("MySQL error. Entry not added.");
				}

			}
			
		}
		else
		{
			header("Refresh: 3; url=table.php");
	 		echo '<h3>Access deined - you do not have access to this page</h3>';
	 		echo '<p>You will be redirected in 3 seconds</p>';
			exit(); // Quit the script.
		} 
		
   }
   else if (!isset($_SESSION['users_name']))
   {
		header("Refresh: 3; url=../table.php");
	 	echo '<h3>Access deined - you do not have access to this page</h3>';
	 	echo '<p>You will be redirected in 3 seconds</p>';
		exit(); // Quit the script.
		
   }  


?>


</body>
</html>
