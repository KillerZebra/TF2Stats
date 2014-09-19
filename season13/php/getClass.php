<?php
	function getClass($players)
	{

		if(array_search('title="Soldier" data', $players) ) 
		{
			return '<img src="../../images/classes/soldier.png" title="Soldier">';
		}
		else if(array_search('title="Demoman" data', $players) ) 
		{
			return '<img src="../../images/classes/demoman.png" title="Demoman">';
		}
		else if(array_search('title="Sniper" data', $players) ) 
		{
			return '<img src="../../images/classes/sniper.png" title="Sniper">';
		}
		else if(array_search('title="Scout" data', $players) ) 
		{
			return '<img src="../../images/classes/scout.png" title="Scout"">';
		}
		else if(array_search('title="Medic" data', $players) ) 
		{
			return '<img src="../../images/classes/medic.png" title="Medic">';
		}
		else if(array_search('title="Spy" data', $players) ) 
		{
			return '<img src="../../images/classes/spy.png" title="Spy">';
		}
		else if(array_search('title="Pyro" data', $players) ) 
		{
			return '<img src="../../images/classes/pyro.png" title="Pyro">';
		}
		else if(array_search('title="Heavyweapons" data', $players) ) 
		{
			return '<img src="../../images/classes/heavy.png" title="Heavy">';
		}
		else if(array_search('title="Engineer" data', $players) ) 
		{
			return '<img src="../../images/classes/engineer.png" title="Engineer">';
		}


	}	

?>



