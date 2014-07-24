<?php
	function getClass($players)
	{

		if(array_search('title="Soldier" data', $players) ) 
		{
			return "Soldier";
		}

		else if(array_search('title="Demoman" data', $players) ) 
		{
			return "Demoman";
		}
		else if(array_search('title="Sniper" data', $players) ) 
		{
			return "Sniper";
		}
		else if(array_search('title="Scout" data', $players) ) 
		{
			return "Scout";
		}
		else if(array_search('title="Medic" data', $players) ) 
		{
			return "Medic";
		}
		else if(array_search('title="Spy" data', $players) ) 
		{
			return "Spy";
		}
		else if(array_search('title="Pyro" data', $players) ) 
		{
			return "Pyro";
		}
		else if(array_search('title="Heavyweapons" data', $players) ) 
		{
			return "Heavy";
		}
		else if(array_search('title="Engineer" data', $players) ) 
		{
			return "Engineer";
		}


	}	

?>



