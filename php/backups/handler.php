<?php

/**
 * The Schools of McKeel Academy Website ( $Id: index.php 9 2011-12-09 19:16:43Z brandon $ )
 *
 * cron script gateway file
 *
 * @author			Jeff AKA KillerZebra
 * @version			$Rev: 1
 */


//This function takes all the info and adds it to the database. 
	function mySQLentry($nameString , $fullID , $class , $killsString , $assistsString , $deathsString , $damageString , $damagemString , $kadString , $kdString , $damagetString , $hpString , $backstabsString , $headshotString , $airshotString , $sentriesString , $capturesString)
	{


		$checkID = mysql_query("SELECT * FROM stats WHERE stats_steamid='$fullID'"); 

	    if(mysql_fetch_array($checkID) !== false)
	    {
	        $insert = "UPDATE stats set stats_name='$nameString' , stats_kills= stats_kills+'$killsString' , stats_assist=stats_assist+'$assistsString' , stats_deaths=stats_deaths+'$deathsString' , stats_damage=stats_damage+'$deathsString' , stats_dam=stats_dam+'$damagetString' , stats_kad=stats_kad+'$kadString' , stats_killdeaths=stats_killdeaths+'$kdString' , stats_damagetaken=stats_damagetaken+'$damagetString' , stats_hpt=stats_hpt+'$hpString' , stats_backstab= stats_backstab+'$backstabsString' , stats_hs=stats_hs+'$headshotString' , stats_as=stats_as+'$airshotString' , stats_sb=stats_sb+'$sentriesString' , stats_cap=stats_cap+'$capturesString' WHERE stats_steamid = '$fullID'";
	    	$result = mysql_query( $insert ); 
	    	if($result)
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
	    	$insert = "INSERT INTO stats(stats_name , stats_class, stats_steamid , stats_kills , stats_assist , stats_deaths , stats_damage , stats_dam , stats_kad , stats_killdeaths , stats_damagetaken , stats_hpt , stats_backstab , stats_hs , stats_as , stats_sb , stats_cap)
				VALUES('$nameString' , '$class' , '$fullID' , '$killsString' , '$assistsString' , '$deathsString', '$damageString', '$damagemString', '$kadString', '$kdString', '$damagetString' , '$hpString', '$backstabsString', '$headshotString', '$airshotString' , '$sentriesString', '$capturesString')";
	    	$result = mysql_query( $insert ); 
	    	if($result)
	    	{
	    		echo "Successfully imported $nameString ||| $fullID <br />";
	 	   	}
	 	   	else
	    	{
	    		echo "Failed to import $nameString ||| $fullID <br />";
	 	   	}
	    }

	}
		header("Refresh: 10; url=table.php");
	 	echo '<h3>Returning to Table in 10 seconds</h3>';
	 	echo '<p><a href=table.php>Or click here</a></p>';
?>				
