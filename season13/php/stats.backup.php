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
$database = trim($_POST['database']);

$editurl = substr($url, 0, 7); 
if($editurl != "http://")
{
	//checks to see if the url contains http://  . If it doesn't it will add it to the begining. 
	$url = "http://" . $url;
}

if (strlen($url) > 21) 
{
		//checks to see if the highlight is in the url, if it is true, it removes it. 
		$url = substr($url,0,21);
}

// This is the file holding the URLs of the Log files that have been uploaded
$logFile = "../databases/urls/" . $database . ".txt";

//Checks to see if a logfile has been exists on the server, if not creates one. 
if (file_exists($logFile) == false)
{
	$content = htmlspecialchars($url);
	$fp = fopen($logFile,"wb");
	fwrite($fp,$content . PHP_EOL);
	fclose($fp);
}
else 
{

	//This makes $lines an array of lines from the $logFile. 
	$lines = file($logFile);
	
	//Iterates over the array. $lines is the array, $line_num is the index, $ line is the string on the line.
	foreach ($lines as $line_num => $line) 
	{
		//The process adds two whitespaces, this chops those off to match the length of $url to ensure proper comparison 
		$line = substr($line, 0, -2);
		//If the log the user is attempting to enter has already been logged, user will be re-directed back to index and stats will exit
		if ($line == $url)
		{
			echo "That log file already exists! <br / > Stats will not be altered. <br /> <br / > ";
			header("Refresh: 10; url=../index.php");
			exit;
		}
		//there is no else, the next bit needs execute outside of the foreach loop
	}
	//if the code did not exit, the log url is appended to the log text file and the rest of the code is allowed to run and update the logs
	file_put_contents($logFile, $url . PHP_EOL, FILE_APPEND | LOCK_EX);
}
 


$team = $_POST['team'];

$league = $_POST['league'];


$data = file_get_html($url);

$tables = $data->find('table tr');
$players= array();

if ($league == "hl")
{
	for($i=0; $i<=18; $i++)
	{
		$tables[$i]->plaintext . "<br />";

		$players[$i] = preg_split( '/(http:\/\/www.ugcleague.com\/|<td class="blu">|<td class="red">|toggle="dropdown" href="#">|<\/a>|-|<\/tr>|<tr>|<\/th>|<td>|<ul|<\/td>|<span class="tip" title="|<\/span>)/', $tables[$i],-1,PREG_SPLIT_NO_EMPTY); 	

	}
}
else if ($league == "sixes")
{
	for($i=0; $i<=18; $i++)
	{
		$tables[$i]->plaintext . "<br />";
		$players[$i] = preg_split( '/(-|<\/tr>|<tr>|<\/th>|<td>|<ul|<\/td>|<span class="tip" title="|<\/span>)/', $tables[$i],-1,PREG_SPLIT_NO_EMPTY); 	
	}
}




$name  = "";
$steamid = "";
$color = "";
$kills = 0;
$assists = 0;
$deaths = 0;
$damage = 0;
$damage_m = 0;
$ka_d = 0.0;
$kd = 0.0;
$hp = 0;
$backstabs = 0;
$headshot = 0;
$sentries = 0;
$captures = 0;
$damage_t = 0;
$airshots = 0;
$edittime = 0.0;
$time = 0.0;
$value = "";
$getHeader = "";
$fullID = "";


if($league == "hl")
{
	for($ii = 1; $ii <= 18; $ii++ )
	{
		$arraySize = count($players[$ii]);


			//makes all arrays the size of 100 for easy input. Every table converted into a random array size, making it impossible to get data from. 
			while($arraySize <= 102)
			{
				$inserted = array( 'x' );
				array_splice( $players[$ii], 5, 0, $inserted );
				$arraySize++;

			}
				$findStats = 75; 
				if($ii == 1)
				{
					$j = 5;
					while($j != 1)
					{
						$key = array_search("</thead><tbody>", $players[1]);

							$edittime = substr($players[1][$key+1], -2, 2);
							$time = substr($players[1][$key+1], 0, 2);
							$edittime = number_format(($edittime / 60),2);
							$time = $time + $edittime; 
							$j = 1;
					}
				}
				//set values
				$color = $players[$ii][1];

				//this loop checks the team. If the team color isn't = to what you inputted, the stats are not recorded. 
				if(trim($color) == trim($team))//trim removes whitespaces before and after the character. 
				{

					// gets player name
					$getName = 5;
					while(strlen($players[$ii][$getName]) == 1)
					{
						if(strlen($players[$ii][$getName]) == 1)
						{
							$getName++;
						}
						if(strlen($players[$ii][$getName]) != 1)
						{
							$name = $players[$ii][$getName];
						}
					}

					
					// gets player steam id
					$steam = 10;
					
					while($steam != 102)
					{
						if(strlen($players[$ii][$steam]) != 102)
						{
							$steam++;
						}
						if(strlen($players[$ii][$steam]) >= 95 && strlen($players[$ii][$steam]) < 105)
						{
							/*
							if(strlen($players[$ii][$steam]) == 99)
							{
								$fullID = substr($players[$ii][$steam], 67, 17);
							}
							else if(strlen($players[$ii][$steam]) == 100)
							{
								$fullID = substr($players[$ii][$steam], 67, 18);
							}
							*/
							$fullID = substr($players[$ii][$steam], 67, 18);
							$steam = 102;
						}
					}
					
					if(!(is_numeric(strpos($fullID, 18))))
					{
						$fullID = substr($fullID, 0, 17);

					}
					$fullID = trim($fullID);

					$class = getClass($players[$ii]);// directs to getClass.php	

					while(strlen($players[$ii][$findStats]) != 2 || strlen($players[$ii][$findStats]) != 1)
					{

						if(strlen($players[$ii][$findStats]) == 2 || strlen($players[$ii][$findStats]) == 1)
						{

							if(is_numeric($players[$ii][$findStats]))
							{
								$kills = $players[$ii][$findStats];
								$findStats = $findStats + 2;
								// gets player assists
								$assists = $players[$ii][$findStats];
								$findStats = $findStats + 2;
								// gets player deaths
								$deaths = $players[$ii][$findStats];
								$findStats = $findStats + 2;
								// gets player total damage output
								$damage = $players[$ii][$findStats];
								$findStats = $findStats + 2;
								// gets player damage per minute
								$damagem = $players[$ii][$findStats];
								$findStats = $findStats + 2;
								// gets player kill/assists per death
								$kad = $players[$ii][$findStats];
								$findStats = $findStats + 2;
								// gets player kill death
								$kd = $players[$ii][$findStats];
								$findStats = $findStats + 2;
								// gets players total damage taken
								if(in_array("Damage taken\">DT", $players[0]))
								{
									$damaget = $players[$ii][$findStats];
									$findStats = $findStats + 2;
								}
								else if (!(in_array("Damage taken\">DT", $players[0])))
								{
									$damaget = 0;
								}


								// gets player health packs used
								$hp = $players[$ii][$findStats];
								$findStats = $findStats + 2;
								// gets player backstabs
								$backstabs = $players[$ii][$findStats];
								$findStats = $findStats + 2;
								// gets player headshots
								$headshot = $players[$ii][$findStats];
								$findStats = $findStats + 2;

								if(in_array("AIRSHOTS\">AS", $players[0]))
										{
											$airshots = $players[$ii][$findStats];
											$findStats = $findStats + 2;
											if(in_array("Sentries built\">SB", $players[0]))
											{
												$sentries = $players[$ii][$findStats];
												$findStats = $findStats + 2;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
											else if(!(in_array("Sentries built\">SB", $players[0])))
											{
												$sentries = 0;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}	
										}
								if(!(in_array("AIRSHOTS\">AS", $players[0])))
										{
											$airshots = 0;
											if(in_array("Sentries built\">SB", $players[0]))
											{
												$sentries = $players[$ii][$findStats];
												$findStats = $findStats + 2;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
											else if(!(in_array("Sentries built\">SB", $players[0])))
											{
												$sentries = 0;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
										}
								// gets player sentries built
								
								echo "<br/ >Name: $name " . "<br /> ";
								echo "Class: $class " . "<br /> ";
								echo "Time: $time  <br /> "  ; 
								echo "Edit Time: $edittime  <br /> "  ; 		
								echo "STEAM ID: $fullID <br / >";
								echo "Kills: $kills" . "<br /> ";
								echo "Assists: $assists" . "<br /> ";
								echo "Deaths: $deaths" . "<br /> ";
								echo "Damage: $damage" . "<br /> ";
								echo "Damage Per Min: $damagem" . "<br /> ";
								echo "Kill/Assist per Death: $kad" . "<br /> ";
								echo "Kill/Death: $kd" . "<br /> ";
								echo "Damage Taken: $damaget" . "<br /> ";
								echo "Health picked up: $hp" . "<br />";
								echo "Backstabs: $backstabs" . "<br /> ";
								echo "Headshots: $headshot" . "<br /> ";
								echo "Aitshots: $airshots". "<br /> ";
								echo "Sentries: $sentries" . "<br /> ";
								echo "Captures: $captures" . "<br /> ";
								
								//mySQLentry( $time , $database , $nameString , $fullID , $class , $kills , $assists , $deaths , $damage , $damagem , $kad , $kd , $damaget, $hp , $backstabs , $headshot , $airshots , $sentries , $captures);
								break;
							}

						}

						$findStats++;

						


					}
					//this block prints out the values the stats are attached too. It is used for debugging (making sure all the values got assigned) and is not needed in the code. 
			
					

					

					
				}	
			

			
		}

}
if($league == "sixes")
{

	for($ii = 1; $ii <= 12; $ii++ )
	{
		$arraySize = count($players[$ii]);

			//makes all arrays the size of 100 for easy input. Every table converted into a random array size, making it impossible to get data from. 
			while($arraySize <= 102)
			{
				$inserted = array( 'x' );
				array_splice( $players[$ii], 5, 0, $inserted );
				$arraySize++;

			}
				if($ii == 1)
				{
						$j = 40;
						while(strlen($players[1][$j]) != 5)
						{
							$j++;
							if(strlen($players[1][$j]) == 5)
							{
								$edittime = substr($players[1][$j], -2, 2);
								$time = substr($players[1][$j], 0, 2);
								$edittime = number_format(($edittime / 60),2);
								$time = $time + $edittime; 

							}
						}
					
				}
				//set values
				$color = substr($players[$ii][0],23);
				$colorString = str_replace('</td>', '', $color);// removes table data characters after team color

				//this loop checks the team. If the team color isn't = to what you inputted, the stats are not recorded. 
				if(trim($colorString) == trim($team))//trim removes whitespaces before and after the character. 
				{
					$findStats = 75; 

					// gets player name
					$name = substr($players[$ii][2], 94);
					$nameString = str_replace('</a>', '', $name); // removes anchor tag characters after name

					// gets player steam id
					$fullID = substr($players[$ii][3], 374, 18);

					$class = getClass($players[$ii]);// directs to getClass.php	


					while(strlen($players[$ii][$findStats]) != 2 || strlen($players[$ii][$findStats]) == 1)
					{
						$findStats++;

						if(strlen($players[$ii][$findStats]) == 2 || strlen($players[$ii][$findStats]) == 1)
						{

							if(is_numeric($players[$ii][$findStats]))
							{
								$kills = $players[$ii][$findStats];//79
								$findStats = $findStats + 2;
								// gets player assists
								$assists = $players[$ii][$findStats];//81
								$findStats = $findStats + 2;
								// gets player deaths
								$deaths = $players[$ii][$findStats];//83
								$findStats = $findStats + 2;
								// gets player total damage output
								$damage = $players[$ii][$findStats];//85
								$findStats = $findStats + 2;
								// gets player damage per minute
								$damagem = $players[$ii][$findStats];//87
								$findStats = $findStats + 2;
								// gets player kill/assists per death
								$kad = $players[$ii][$findStats];//89
								$findStats = $findStats + 2;
								// gets player kill death
								$kd = $players[$ii][$findStats];//91
								$findStats = $findStats + 2;
								// gets players total damage taken
								$damaget = $players[$ii][$findStats];//93
								$findStats = $findStats + 2;
								// gets player health packs used
								$hp = $players[$ii][$findStats];//95
								$findStats = $findStats + 2;
								// gets player backstabs

								if(in_array("Backstabs\">BS", $players[0]))
								{
									$backstabs = $players[$ii][$findStats];
									$findStats = $findStats + 2;
									if(in_array("Headshots\">HS", $players[0]) || in_array("Headshot kills\">HSK", $players[0]))
									{
										$headshot = $players[$ii][$findStats];
										$findStats = $findStats + 2;
										if(in_array("AIRSHOTS\">AS", $players[0]))
										{
											$airshots = $players[$ii][$findStats];
											$findStats = $findStats + 2;
											if(in_array("Sentries built\">SB", $players[0]))
											{
												$sentries = $players[$ii][$findStats];
												$findStats = $findStats + 2;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
											else if(!(in_array("Sentries built\">SB", $players[0])))
											{
												$sentries = 0;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}	
										}
										if(!(in_array("AIRSHOTS\">AS", $players[0])))
										{
											$airshots = 0;
											if(in_array("Sentries built\">SB", $players[0]))
											{
												$sentries = $players[$ii][$findStats];
												$findStats = $findStats + 2;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
											else if(!(in_array("Sentries built\">SB", $players[0])))
											{
												$sentries = 0;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
										}
									}
									if(!(in_array("Headshots\">HS", $players[0]) || in_array("Headshot kills\">HSK", $players[0])))
									{
										$headshot = 0;
										if(in_array("AIRSHOTS\">AS", $players[0]))
										{
											$airshots = $players[$ii][$findStats];
											$findStats = $findStats + 2;
											if(in_array("Sentries built\">SB", $players[0]))
											{
												$sentries = $players[$ii][$findStats];
												$findStats = $findStats + 2;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
											else if(!(in_array("Sentries built\">SB", $players[0])))
											{
												$sentries = 0;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}	
										}
										if(!(in_array("AIRSHOTS\">AS", $players[0])))
										{
											$airshots = 0;
											if(in_array("Sentries built\">SB", $players[0]))
											{
												$sentries = $players[$ii][$findStats];
												$findStats = $findStats + 2;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
											else if(!(in_array("Sentries built\">SB", $players[0])))
											{
												$sentries = 0;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
										}
									}	
								}
								else if(!(in_array("Backstabs\">BS", $players[0])))
								{
									$backstabs = 0;
									if(in_array("Headshots\">HS", $players[0]) || in_array("Headshot kills\">HSK", $players[0]))
									{
										$headshot = $players[$ii][$findStats];
										$findStats = $findStats + 2;
										if(in_array("AIRSHOTS\">AS", $players[0]))
										{
											$airshots = $players[$ii][$findStats];
											$findStats = $findStats + 2;
											if(in_array("Sentries", $players[0]))
											{
												$sentries = $players[$ii][$findStats];
												$findStats = $findStats + 2;
												if(in_array("Capture", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
											else if(!(in_array("Sentries built\">SB", $players[0])))
											{
												$sentries = 0;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}	
										}
										if(!(in_array("AIRSHOTS\">AS", $players[0])))
										{
											$airshots = 0;
											if(in_array("Sentries built\">SB", $players[0]))
											{
												$sentries = $players[$ii][$findStats];
												$findStats = $findStats + 2;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
											else if(!(in_array("Sentries built\">SB", $players[0])))
											{
												$sentries = 0;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
										}
									}
									if(!(in_array("Headshots\">HS", $players[0]) || in_array("Headshot kills\">HSK", $players[0])))
									{
										$headshot = 0;
										if(in_array("AIRSHOTS\">AS", $players[0]))
										{
											$airshots = $players[$ii][$findStats];
											$findStats = $findStats + 2;
											if(in_array("Sentries built\">SB", $players[0]))
											{
												$sentries = $players[$ii][$findStats];
												$findStats = $findStats + 2;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
											else if(!(in_array("Sentries built\">SB", $players[0])))
											{
												$sentries = 0;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}	
										}
										if(!(in_array("AIRSHOTS\">AS", $players[0])))
										{
											$airshots = 0;
											if(in_array("Sentries built\">SB", $players[0]))
											{
												$sentries = $players[$ii][$findStats];
												$findStats = $findStats + 2;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
											else if(!(in_array("Sentries built\">SB", $players[0])))
											{
												$sentries = 0;
												if(in_array("Capture Point Captures\">CAP", $players[0]))
												{
													$captures = $players[$ii][$findStats];
													$findStats = $findStats + 2;
												}
												else if(!(in_array("Capture Point Captures\">CAP", $players[0])))
												{
													$captures = 0;
												}
											}
										}
									}	
								}

								

								/*
								echo "<br/ >Name: $nameString " . "<br /> ";
								echo "Time: $time  <br /> "  ; 
								echo "Edit Time: $edittime  <br /> "  ; 		
								echo "STEAM ID: $fullID <br / >";
								echo "Kills: $kills" . "<br /> ";
								echo "Assists: $assists" . "<br /> ";
								echo "Deaths: $deaths" . "<br /> ";
								echo "Damage: $damage" . "<br /> ";
								echo "Damage Per Min: $damagem" . "<br /> ";
								echo "Kill/Assist per Death: $kad" . "<br /> ";
								echo "Kill/Death: $kd" . "<br /> ";
								echo "Health picked up: $hp" . "<br />";
								echo "Backstabs: $backstabs" . "<br /> ";
								echo "Headshots: $headshot" . "<br /> ";
								echo "Aitshots: $airshots". "<br /> ";
								echo "Sentries: $sentries" . "<br /> ";
								echo "Captures: $captures" . "<br /> ";
								*/
								mySQLentry( $time , $database , $nameString , $fullID , $class , $kills , $assists , $deaths , $damage , $damagem , $kad , $kd , $damaget, $hp , $backstabs , $headshot , $airshots , $sentries , $captures);
								break;
							}
						
						}
					}

					//this block prints out the values the stats are attached too. It is used for debugging (making sure all the values got assigned) and is not needed in the code. 
					

					

					
				}	

				

		}
}

var_dump($players);

?>










</body>
</html>