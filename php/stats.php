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

$team = $_POST['team'];
$database = trim($_POST['database']);
$league = $_POST['league'];


$data = file_get_html($url);

$tables = $data->find('table tr');
$players= array();

if ($league == "hl")
{
	for($i=0; $i<=18; $i++)
	{
		$tables[$i]->plaintext . "<br />";

		$players[$i] = preg_split( '/(<td>|<ul|<\/td>|<span class="tip" title="|<\/span)/', $tables[$i],-1,PREG_SPLIT_NO_EMPTY); 	

	}
}
else if ($league == "sixes")
{
	for($i=0; $i<=18; $i++)
	{
		$tables[$i]->plaintext . "<br />";
		$players[$i] = preg_split( '/(<td>|<ul|<\/td>|<span class="tip" title="|<\/span>)/', $tables[$i],-1,PREG_SPLIT_NO_EMPTY); 	

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


if($league == "hl")
{
	for($ii = 1; $ii <= 18; $ii++ )
	{
		$arraySize = count($players[$ii]);
		$findStats = 70; 

			//makes all arrays the size of 100 for easy input. Every table converted into a random array size, making it impossible to get data from. 
			while($arraySize <= 102)
			{
				$inserted = array( 'x' );
				array_splice( $players[$ii], 5, 0, $inserted );
				$arraySize++;

			}
			$get75 = ($players[$ii][69]);

				$findStats = 75; 
				if($ii == 1)
				{
					$j = 50;
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

					// gets player name
					$name = substr($players[$ii][2], 94);
					$nameString = str_replace('</a>', '', $name); // removes anchor tag characters after name

					// gets player steam id
					$fullID = substr($players[$ii][3], 374, 18);

					$class = getClass($players[$ii]);// directs to getClass.php	

					while(strlen($players[$ii][$findStats]) != 2 || strlen($players[$ii][$findStats]) != 1)
					{
						$findStats++;

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
								$damaget = $players[$ii][$findStats];
								$findStats = $findStats + 2;
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
								/*
								echo "<br/ >Name: $nameString " . "<br /> ";
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
								echo "Health picked up: $hp" . "<br />";
								echo "Backstabs: $backstabs" . "<br /> ";
								echo "Headshots: $headshot" . "<br /> ";
								echo "Aitshots: $airshots". "<br /> ";
								echo "Sentries: $sentries" . "<br /> ";
								echo "Captures: $captures" . "<br /> ";
								*/
								mySQLentry( $time , $database , $nameString , $fullID , $class , $kills , $assists , $deaths , $damage , $damagem , $kad , $kd , $damaget , $hp , $backstabs , $headshot , $airshots , $sentries , $captures);
								break;
							}
						}

							
						


					}
					//this block prints out the values the stats are attached too. It is used for debugging (making sure all the values got assigned) and is not needed in the code. 
			
					

					

					
				}	

				
			//the purpose of this if/else statement is because if a match has 0 airshots, that stat doesn't appear. If there is more than 1 airshot, it appears, and throws the stat placement off by one. 
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
									if(in_array("Headshots\">HS", $players[0]))
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
									if(!(in_array("Headshots\">HS", $players[0])))
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
									if(in_array("Headshots\">HS", $players[0]))
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
									if(!(in_array("Headshots\">HS", $players[0])))
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

//var_dump($players);

?>










</body>
</html>