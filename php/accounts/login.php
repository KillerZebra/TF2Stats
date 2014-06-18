<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>
			Login
		</title>
	</head>
	<body>

		<div id="Login">
			<ul id="input">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<li>Username:</li><input type="text" name="username" /> 
					<li>Password:</li> <input type="text" name="password" />
				 	<li id="fSubmit"><input type="submit" value="Login" />
				</form>
			</ul>
		</div>



<?php

ob_start();
session_start();
require("../connect/connectDB.php");



// username and password sent from form
if(isset($_POST['username']))
{
	$username = $_POST['username'];
}
if(isset($_POST['password']))
{
	$password = $_POST['password'];
}


if(isset($_POST['username']) && isset($_POST['password']))
{
	//$salt = dechex( mt_rand (0, 2147483647) ) . dechex( mt_rand (0, 2147483647) ); 
	//$password = hash('sha256', $_POST['password'] . $salt); 

	$username = mysql_real_escape_string($username);
	$query = "SELECT users_name, users_password, users_passsalt , users_level
	FROM users
	WHERE users_name = '$username';";
	 
	$result = mysql_query($query);
	 
	if(mysql_num_rows($result) == 0) // User not found. So, redirect to login_form again.
	{
		echo "User not found <br />";
		//header('Location: login.html');
	}
	 
	$userData = mysql_fetch_array($result, MYSQL_ASSOC);

	$hash = hash('sha256', $_POST['password'] . $userData['users_passsalt']);
	
	if($hash != $userData['users_password']) // Incorrect password. So, redirect to login_form again.
	{
		echo "Bad password <br />";
	}
	else
	{ // Redirect to home page after successful login.
		session_regenerate_id();
		$_SESSION['sess_user_id'] = $userData['users_level'];
		$_SESSION['sess_username'] = $userData['users_name'];
		session_write_close();
		header('Location: ../../index.php');
	}
// To protect MySQL injection (more detail about MySQL injection)

}
            
    

?>	
</body>
</html>
