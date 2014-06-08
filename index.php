<html>
<head>
<title> Stat </title>
	<link rel="stylesheet" type="text/css" href="css/table.css">
	<link media="print, projection, screen" type="text/css" href="js/tablesorter/themes/blue/style.css" rel="stylesheet">
	<script type="text/javascript" src="js/tablesorter/jquery-latest.js"></script> 
	<script type="text/javascript" src="js/tablesorter/jquery.tablesorter.js"></script> 
	<script>
	$(document).ready(function() 
		{ 
        $("#statsTable").tablesorter(); 
		} 
	); 
	</script>

</head>
<body>


<div id = "accounts">
<?php
session_start();
if (!isset($_SESSION['sess_username']))
{
	echo '<a href = "php/accounts/login.php">Login | </a>';
}
else if (isset($_SESSION['sess_username']))
{
	echo '<a href = "php/accounts/logout.php">Logout | </a>';
	if ($_SESSION['sess_user_id'] == 0) //super admin, can see all databases
	{
		echo	'<a href = "php/accounts/register.php">Make New Accounts</a>';
		echo	'</div>';
	}
}

?>

<div id="donate-button">
		<a href="https://www.nfoservers.com/donate.pl?force_recipient=1&recipient=chuckwagon96@gmail.com"><Span>Dontate!</Span><br> Click here to donate to help with server costs. Thanks!</a>
</div>

<div id="selectTable">

	<form name="input" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Select Database <select name="teams">	

<?php
/**
 *
 *
 * @author			Jeff AKA KillerZebra
 * @version			$Rev: 1
 */
require("php/connect/connectDB.php");

$file = "databases/database.txt";
$linesInFile = count(file($file));
//$openFile = fopen($file , 'r');

for($i=0; $i <= $linesInFile; $i++)
{
	$lines = file($file);
	echo	"<option value='" . $lines[$i]  . "'>$lines[$i]</option>";
}
echo	'</select><br />';
echo	'<input type="submit" value="Show Stats"> ';
echo	'</form>' ;
echo "</div>";


	if(isset($_POST['teams']))
	{



		$database = trim($_POST['teams']);
		$result = mysql_query("SELECT * FROM `$database`"); 


		echo "<table id='statsTable' class='tablesorter' cellspacing='1' cellpadding='0' border='1'>
		<thead>
		<tr>
		<th class='header'>Name</th>
		<th class='header'>SteamID</th>
		<th class='header'>Class</th>		
		<th class='header'>Kills </th>
		<th class='header'>Assists </th>
		<th class='header'>Deaths </th>
		<th class='header'>Damage </th>
		<th class='header'>DA/M </th>
		<th class='header'>KA/D </th>
		<th class='header'>K/D </th>
		<th class='header'>Dmg Taken</th>
		<th class='header'>Health P/U</th>
		<th class='header'>Backstabs</th>	
		<th class='header'>Headshots</th>
		<th class='header'>Airshots</th>		
		<th class='header'>Sentries</th>
		<th class='header'>Captures</th>
		</tr>
		</thead>";
		
		echo "<tbody>";		
		
		while($row = mysql_fetch_array($result))
		{

			echo "<tr>";
			echo "<td>" . $row['stats_name'] . "</td>";
			echo "<td>" . $row['stats_steamid'] . "</td>";
			echo "<td>"  . $row['stats_class'] . "</td>";
			echo "<td>" . $row['stats_kills'] . "</td>";
			echo "<td>" . $row['stats_assist'] . "</td>";
			echo "<td>" . $row['stats_deaths'] . "</td>";
			echo "<td>" . $row['stats_damage'] . "</td>";
			echo "<td>" . $row['stats_dam'] . "</td>";
			echo "<td>" . $row['stats_kad'] . "</td>";
			echo "<td>" . $row['stats_killdeaths'] . "</td>";
			echo "<td>" . $row['stats_damagetaken'] . "</td>";
			echo "<td>"  . $row['stats_hpt'] . "</td>";
			echo "<td>" . $row['stats_backstab'] . "</td>";
			echo "<td>"  . $row['stats_hs'] . "</td>";
			echo "<td>" . $row['stats_as'] . "</td>";
			echo "<td>"  . $row['stats_sb'] . "</td>";
			echo "<td>" . $row['stats_cap'] . "</td>";
			echo "</tr>";
		}
		echo "</tbody>";

		echo "<td>" . " " .  "</td>";
		echo "<td>" . " " . "</td>";
		echo "<td>" . "Total" . "</td>";

		$total = mysql_query("SELECT SUM(stats_kills) AS total_kills FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum1 = $row['total_kills'];
		echo "<td>" . $sum1 . "</td>";

		$total = mysql_query("SELECT SUM(stats_assist) AS total_assist FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum2 = $row['total_assist'];
		echo "<td>" . $sum2 . "</td>";

		$total = mysql_query("SELECT SUM(stats_deaths) AS total_deaths FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum3 = $row['total_deaths'];
		echo "<td>" . $sum3 . "</td>";

		$total = mysql_query("SELECT SUM(stats_damage) AS total_damage FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum = $row['total_damage'];
		echo "<td>" . $sum . "</td>";

		$total = mysql_query("SELECT SUM(stats_dam) AS total_dam FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum = $row['total_dam'];
		echo "<td>" . $sum . "</td>";


		$sum4 = ($sum1 + $sum2) / $sum3;
		echo "<td>" . number_format($sum4,2) . "</td>";

	
		$sum5 = $sum1 / $sum3;
		echo "<td>" . number_format($sum5,2) . "</td>";

		$total = mysql_query("SELECT SUM(stats_damagetaken) AS total_dt FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum = $row['total_dt'];
		echo "<td>" . $sum . "</td>";

		$total = mysql_query("SELECT SUM(stats_hpt) AS total_hpt FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum = $row['total_hpt'];
		echo "<td>" . $sum . "</td>";

		$total = mysql_query("SELECT SUM(stats_backstab) AS total_backstab FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum = $row['total_backstab'];
		echo "<td>" . $sum . "</td>";

		$total = mysql_query("SELECT SUM(stats_hs) AS total_hs FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum = $row['total_hs'];
		echo "<td>" . $sum . "</td>";

		$total = mysql_query("SELECT SUM(stats_as) AS total_as FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum = $row['total_as'];
		echo "<td>" . $sum . "</td>";

		$total = mysql_query("SELECT SUM(stats_sb) AS total_sb FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum = $row['total_sb'];
		echo "<td>" . $sum . "</td>";

		$total = mysql_query("SELECT SUM(stats_cap) AS total_cap FROM `$database`"); 
		$row = mysql_fetch_assoc($total); 			
		$sum = $row['total_cap'];
		echo "<td>" . $sum . "</td>";
		

		echo "</table>";


	}
	

?>

<?php



require("php/connect/connectDB.php");

$DBnames = array();

$file = "databases/database.txt";
$linesInFile = count(file($file));
//$openFile = fopen($file , 'r');
for($i=1; $i <= $linesInFile; $i++)
{
	$lines = file($file);
}




if (isset($_SESSION['sess_username']))
{
	echo '<div id="stats">';
	echo '<form name="input" action="php/stats.php" method="post">';
	echo 'URL: <input type="text" name="url"><br />';

	//
	echo '<input type="radio" name="team" value="Red">Red';
	echo '<input type="radio" name="team" value="Blu">Blu<br />';
	//
	echo '<input type="radio" name="league" value="hl">9v9';
	echo '<input type="radio" name="league" value="sixes">6v6<br />';

	echo 'Select Database <select name="database">';
	if ($_SESSION['sess_user_id'] == 0) //super admin, can see all databases
	{
		for($i=0; $i < $linesInFile; $i++)
		{
			echo "<option value='" . $lines[$i]  . "'>$lines[$i]</option>";
		}
		

	}
	else if ($_SESSION['sess_user_id'] == 1) //pretty princess database
	{

			echo "<option value='" . $lines[2]  . "'>$lines[2]</option>";


	}
	echo	'</select><br />';
	echo	'<input type="submit" value="Submit Stats"> ';

}




?>



</body>
</html>