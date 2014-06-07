<html>
<head>
<title> Stat </title>
<link rel="stylesheet" type="text/css" href="../css/table.css">
</head>
<body>
<div id = "accounts">
	<a href = "accounts/login.php">Login</a>
	<a href = "accounts/register.php">Register</a>
</div>

<div id="selectTable">

	<form name="input" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Select Database <select name="database">
					


<?php
session_start();
$DBnames = array();

$file = "../databases/database.txt";
$linesInFile = count(file($file));
$openFile = fopen($file , 'r');

for($i=1; $i <= $linesInFile; $i++)
{
$lines = fgets($openFile);

echo	"<option value=$i>$lines</option>";
}
echo	'</select><br />';
echo	'<input type="submit" value="Show Stats"> ';
echo	'</form>' ;
echo "</div>";

/**
 * The Schools of McKeel Academy Website ( $Id: index.php 9 2011-12-09 19:16:43Z brandon $ )
 *
 * cron script gateway file
 *
 * @author			Jeff AKA KillerZebra
 * @version			$Rev: 1
 */

	require("connect/connectDB.php");

	$result = mysql_query("SELECT * FROM stats");

	echo "<table border='1'>
	<tr>
	<th>Name</th>
	<th>SteamID</th>
	<th>Class</th>		
	<th>Kills</th>
	<th>Assists</th>
	<th>Deaths</th>
	<th>Damage</th>
	<th>DA/M</th>
	<th>KA/D</th>
	<th>K/D</th>
	<th>Damage Taken</th>
	<th>Health P/U</th>
	<th>Backstabs</th>	
	<th>Headshots</th>
	<th>Airshots</th>		
	<th>Sentries</th>
	<th>Captures</th>
	</tr>";

	while($row = mysql_fetch_array($result))
	{
	echo "<tr>";
	echo "<td>" . $row['stats_name'] . "</td>";
	echo "<td>" . $row['stats_steamid'] . "</td>";
	echo "<td>" . $row['stats_class'] . "</td>";
	echo "<td>" . $row['stats_kills'] . "</td>";
	echo "<td>" . $row['stats_assist'] . "</td>";
	echo "<td>" . $row['stats_deaths'] . "</td>";
	echo "<td>" . $row['stats_damage'] . "</td>";
	echo "<td>" . $row['stats_dam'] . "</td>";
	echo "<td>" . $row['stats_kad'] . "</td>";
	echo "<td>" . $row['stats_killdeaths'] . "</td>";
	echo "<td>" . $row['stats_damagetaken'] . "</td>";
	echo "<td>" . $row['stats_hpt'] . "</td>";
	echo "<td>" . $row['stats_backstab'] . "</td>";
	echo "<td>" . $row['stats_hs'] . "</td>";
	echo "<td>" . $row['stats_as'] . "</td>";
	echo "<td>" . $row['stats_sb'] . "</td>";
	echo "<td>" . $row['stats_cap'] . "</td>";
	echo "</tr>";
	}
	echo "</table>";

	mysql_close($dbConnect);
?>

<div id="stats">
<form name="input" action="php/stats.php" method="post">
URL: <input type="text" name="url"><br />
<input type="radio" name="team" value="Red">Red
<input type="radio" name="team" value="Blu">Blu<br />
Select Database <select name="database">
<?php
require("connect/connectDB.php");

$DBnames = array();

$file = "../databases/database.txt";
$linesInFile = count(file($file));
$openFile = fopen($file , 'r');


if (isset($_SESSION['sess_username']))
{
	for($i=1; $i <= $linesInFile; $i++)
	{
	$lines = fgets($openFile);
			if ($_SESSION['sess_user_id'] == 0) 
			{
				$i == 1;
			}
			else if ($_SESSION['sess_user_id'] == 1) 
			{
				$i == 2;
			}
	echo "<option value=$i>$lines</option>";
	}
	echo	'</select><br />';
	echo	'<input type="submit" value="Submit Stats"> ';

}




?>



</body>
</html>