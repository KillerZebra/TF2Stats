<html>
<head>
<title> Stat </title>
</head>
<body>

<?php

require("connect/connectDB.php");
include_once ('simplydom/simple_html_dom.php');
include ('getClass.php');
include ('handler.php');

$url = $_POST['url'];
$team = $_POST['team'];

$data = file_get_html($url);

$tables = $data->find('table tr');
$players= array();

for($i=1; $i<=18; $i++)
{
	$tables[$i]->plaintext . "<br />";

	$players[$i] = preg_split( '/(<td>|<ul)/', $tables[$i],-1,PREG_SPLIT_NO_EMPTY); 	


}




$name  = "";
$steamid = "";
$color = "";
$kills = 0;
$assists = 0;
$deaths = 0;
$damage = 0;
$damage_m = 0;
$ka_d = 0;
$kd = 0;
$hp = 0;
$backstabs = 0;
$headshot = 0;
$sentries = 0;
$captures = 0;
$damage_t = 0;
$airshots = 0;

for($ii = 1; $ii <= 18; $ii++ )
	{
		$arraySize = count($players[$ii]);

		//makes all arrays the size of 100 for easy input. Every table converted into a random array size, making it impossible to get data from. 
		while($arraySize <= 100)
		{
			$inserted = array( 'x' );
			array_splice( $players[$ii], 5, 0, $inserted );
			$arraySize++;

		}
		$get87 = ($players[$ii][87]);
		if(strlen($get87) > 15)
		{
			//set values
			$color = substr($players[$ii][0],23);
			$colorString = str_replace('</td>', '', $color);// removes table data characters after team color

			//this loop checks the team. If the team color isn't = to what you inputted, the stats are not recorded. 
			if(trim($colorString) == trim($team))//trim removes whitespaces before and after the character. 
			{

				// gets player name
				$name = substr($players[$ii][1], 94);
				$nameString = str_replace('</a>', '', $name); // removes anchor tag characters after name

				// gets player steam id
				$fullID = substr($players[$ii][2], 374, 18);

				$class = getClass($fullID); // directs to getClass.php	

				// gets player kills
				$kills = ($players[$ii][88]);
				$killsString = str_replace('</td>', '', $kills);

				// gets player assists
				$assists = $players[$ii][89];
				$assistsString = str_replace('</td>', '', $assists);	

				// gets player deaths
				$deaths = $players[$ii][90];
				$deathsString = str_replace('</td>', '', $deaths);

				// gets player total damage output
				$damage = $players[$ii][91];
				$damageString = str_replace('</td>', '', $damage);

				// gets player damage per minute
				$damagem = $players[$ii][92];
				$damagemString = str_replace('</td>', '', $damagem);

				// gets player kill/assists per death
				$kad = $players[$ii][93];
				$kadString = str_replace('</td>', '', $kad);

				// gets player kill death
				$kd = $players[$ii][94];
				$kdString = str_replace('</td>', '', $kd);

				// gets players total damage taken
				$damaget = $players[$ii][95];
				$damagetString = str_replace('</td>', '', $damaget);

				// gets player health packs used
				$hp = $players[$ii][96];	
				$hpString = str_replace('</td>', '', $hp);

				// gets player backstabs
				$backstabs = $players[$ii][97];	
				$backstabsString = str_replace('</td>', '', $backstabs);

				// gets player headshots
				$headshot = $players[$ii][98];	
				$headshotString = str_replace('</td>', '', $headshot);

				// gets player sentries built
				$sentries = $players[$ii][99];	
				$sentriesString = str_replace('</td>', '', $sentries);

				// gets player capture points
				$captures = $players[$ii][100];
				$capturesString = str_replace('</td>', '', $captures);		

				$airshotString = 0;

				//this block prints out the values the stats are attached too. It is used for debugging (making sure all the values got assigned) and is not needed in the code. 
				/*
				echo "<br/ >Name: $nameString " . "<br /> ";
				echo "STEAM ID: $fullID <br / >";
				echo "Kills: $killsString" . "<br /> ";
				echo "Assists: $assistsString" . "<br /> ";
				echo "Deaths: $deathsString" . "<br /> ";
				echo "Damage: $damageString" . "<br /> ";
				echo "Damage Per Min: $damagemString" . "<br /> ";
				echo "Kill/Assist per Death: $kadString" . "<br /> ";
				echo "Kill/Death: $kdString" . "<br /> ";
				echo "Health picked up: $hpString" . "<br />";
				echo "Backstabs: $backstabsString" . "<br /> ";
				echo "Headshots: $headshotString" . "<br /> ";
				echo "Aitshots: $airshotString". "<br /> ";
				echo "Sentries: $sentriesString" . "<br /> ";
				echo "Captures: $capturesString" . "<br /> ";
				*/
				mySQLentry($nameString , $fullID , $class , $killsString , $assistsString , $deathsString , $damageString , $damagemString , $kadString , $kdString , $damagetString, $hpString , $backstabsString , $headshotString , $airshotString , $sentriesString , $capturesString);


				
			}	

		}	
		//the purpose of this if/else statement is because if a match has 0 airshots, that stat doesn't appear. If there is more than 1 airshot, it appears, and throws the stat placement off by one. 
		else
		{
			//set values
			$color = substr($players[$ii][0],23);
			$colorString = str_replace('</td>', '', $color);// removes table data characters after team color

			//this loop checks the team. If the team color isn't = to what you inputted, the stats are not recorded. 
			if(trim($colorString) == trim($team))//trim removes whitespaces before and after the character. 
			{
				// gets player name
				$name = substr($players[$ii][1], 94);
				$nameString = str_replace('</a>', '', $name); // removes anchor tag characters after name

				// gets player steam id
				$fullID = substr($players[$ii][2], 374, 18);

				$class = getClass($fullID); // directs to getClass.php	

				// gets player kills
				$kills = ($players[$ii][87]);
				$killsString = str_replace('</td>', '', $kills);

				// gets player assists
				$assists = $players[$ii][88];
				$assistsString = str_replace('</td>', '', $assists);	

				// gets player deaths
				$deaths = $players[$ii][89];
				$deathsString = str_replace('</td>', '', $deaths);

				// gets player total damage output
				$damage = $players[$ii][90];
				$damageString = str_replace('</td>', '', $damage);

				// gets player damage per minute
				$damagem = $players[$ii][91];
				$damagemString = str_replace('</td>', '', $damagem);

				// gets player kill/assists per death
				$kad = $players[$ii][92];
				$kadString = str_replace('</td>', '', $kad);

				// gets player kill death
				$kd = $players[$ii][93];
				$kdString = str_replace('</td>', '', $kd);

				// gets players total damage taken
				$damaget = $players[$ii][94];
				$damagetString = str_replace('</td>', '', $damaget);

				// gets player health packs used
				$hp = $players[$ii][95];	
				$hpString = str_replace('</td>', '', $hp);

				// gets player backstabs
				$backstabs = $players[$ii][96];	
				$backstabsString = str_replace('</td>', '', $backstabs);

				// gets player headshots
				$headshot = $players[$ii][97];	
				$headshotString = str_replace('</td>', '', $headshot);

				//gets player airshots
				$airshots = $players[$ii][98];	
				$airshotString = str_replace('</td>', '', $airshots);

				// gets player sentries built
				$sentries = $players[$ii][99];	
				$sentriesString = str_replace('</td>', '', $sentries);

				// gets player capture points
				$captures = $players[$ii][100];
				$capturesString = str_replace('</td>', '', $captures);		

				//this block prints out the values the stats are attached too. It is used for debugging (making sure all the values got assigned) and is not needed in the code. Look at the Array difference. 
				/*
				echo "<br/ >Name: $nameString " . "<br /> ";
				echo "STEAM ID: $fullID <br / >";
				echo "Kills: $killsString" . "<br /> ";
				echo "Assists: $assistsString" . "<br /> ";
				echo "Deaths: $deathsString" . "<br /> ";
				echo "Damage: $damageString" . "<br /> ";
				echo "Damage Per Min: $damagemString" . "<br /> ";
				echo "Kill/Assist per Death: $kadString" . "<br /> ";
				echo "Kill/Death: $kdString" . "<br /> ";
				echo "Damage Taken: $damagetString" . "<br /> ";
				echo "Health picked up: $hpString" . "<br />";
				echo "Backstabs: $backstabsString" . "<br /> ";
				echo "Headshots: $headshotString" . "<br /> ";
				echo "Aitshots: $airshotString ". "<br /> ";
				echo "Sentries: $sentriesString" . "<br /> ";
				echo "Captures: $capturesString" . "<br /> ";
				*/

				//calls on handler.php
				mySQLentry($nameString , $fullID , $class , $killsString , $assistsString , $deathsString , $damageString , $damagemString , $kadString , $kdString , $damagetString, $hpString , $backstabsString , $headshotString , $airshotString , $sentriesString , $capturesString);

			}

		}
	}

//var_dump($players);

?>










</body>
</html>