<?php

/**
 * 
 *
 * cron script gateway file
 *
 * @author			Jeff AKA KillerZebra
 * @version			$Rev: 1
 */


//This function takes all the info and adds it to the database. 
	function mySQLentry( $time , $database , $nameString , $fullID , $class , $killsString , $assistsString , $deathsString , $damageString , $damagemString , $kadString , $kdString , $damagetString , $hpString , $backstabsString , $headshotString , $airshotString , $sentriesString , $capturesString)
	{
		require("connect/connectDB.php");
		include_once('backup.php');


		$val = mysql_query("SELECT 1 FROM `$database`");

		if($val !== TRUE)
		{
			$create = "CREATE TABLE `$database` (stats_name VARCHAR(255),stats_steamid VARCHAR(255),stats_class VARCHAR(255),stats_kills INT(8),stats_assist INT(8),stats_deaths INT(8),stats_damage INT,stats_dam INT ,stats_kad DECIMAL(5,2),stats_killdeaths DECIMAL(5,2),stats_damagetaken INT,stats_hpt INT(8),stats_backstab INT(8),stats_hs INT(8),stats_as INT(8),stats_sb INT(8),stats_cap INT(8), stats_time DECIMAL(5,2))"; 
			$check = mysql_query( $create ); 
		}

		if($check)
		{
			echo "$database database did not exist but was created successfully <br /><br />";
		}

		$checkID = mysql_query("SELECT * FROM `$database` WHERE stats_steamid='$fullID'"); 

	    if(mysql_fetch_array( $checkID , MYSQL_NUM ) !== false)
	    {
	        $insert = "UPDATE `$database` set stats_name='$nameString' , stats_kills= stats_kills+'$killsString' , stats_assist=stats_assist+'$assistsString' , stats_deaths=stats_deaths+'$deathsString' , stats_damage=stats_damage+'$damageString' , stats_kad=(stats_kills+stats_assist)/stats_deaths , stats_killdeaths=stats_kills/stats_deaths , stats_damagetaken=stats_damagetaken+'$damagetString' , stats_hpt=stats_hpt+'$hpString' , stats_backstab= stats_backstab+'$backstabsString' , stats_hs=stats_hs+'$headshotString' , stats_as=stats_as+'$airshotString' , stats_sb=stats_sb+'$sentriesString' , stats_cap=stats_cap+'$capturesString' , stats_time=stats_time+'$time' , stats_dam=(stats_damage/stats_time)  WHERE stats_steamid = '$fullID'";
	    	$result = mysql_query( $insert ); 
	    	if( $result )
	    	{
	    		echo "Successfully updated $nameString ||| $fullID <br />";

	 	   	}
	 	   	else
	    	{
	    		echo "Failed to update $nameString ||| $fullID <br />";
	 	   	}
		}
	    else
	    {
	    	//echo "$fullID is not Assigned <br />";
	    	$insert = "INSERT INTO `$database`(stats_name , stats_class, stats_steamid , stats_kills , stats_assist , stats_deaths , stats_damage , stats_dam , stats_kad , stats_killdeaths , stats_damagetaken , stats_hpt , stats_backstab , stats_hs , stats_as , stats_sb , stats_cap , stats_time)
				VALUES('$nameString' , '$class' , '$fullID' , '$killsString' , '$assistsString' , '$deathsString', '$damageString', '$damagemString', '$kadString', '$kdString', '$damagetString' , '$hpString', '$backstabsString', '$headshotString', '$airshotString' , '$sentriesString', '$capturesString' , '$time')";
	    	$result = mysql_query( $insert ); 
	    	if( $result )
	    	{
	    		echo "Successfully imported $nameString ||| $fullID <br />";

	 	   	}
	 	   	else
	    	{
	    		echo "Failed to import $nameString ||| $fullID <br />";
	 	   	}
	    }

	}


	
		header("Refresh: 10; url=../index.php");
	 	echo '<h3>Returning to Table in 10 seconds</h3>';
	 	echo '<p><a href=../index.php>Or click here</a></p>';
	



?>				
