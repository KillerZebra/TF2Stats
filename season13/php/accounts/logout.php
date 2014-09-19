 <?php
 	session_start();
    // First we execute our common code to connection to the database and start the session
	require("../connect/connectDB.php");
    
    // We remove the user's data from the session
    unset($_SESSION["sess_user_id"]);
    unset($_SESSION["sess_username"]);

    // We redirect them to the login page
    header("Location: ../../index.php");
    die("Redirecting to: ../../index.php"); 

 ?>