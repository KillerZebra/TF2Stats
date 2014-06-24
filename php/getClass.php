<?php
	function getClass($players)
	{


		if(array_search('Rocket Launcher', $players) || array_search('Black Box', $players) || array_search('Original', $players) || array_search('Direct Hit', $players))
		{
			return "Solider";
		}

		else if(array_search('Sticky Launcher', $players) || array_search('Grenade Launcher', $players))
		{
			return "Demoman";
		}
		else if(array_search('Sniper Rifle', $players) || array_search('Machina', $players) || array_search('Pro_smg', $players) || array_search('Kukri', $players))
		{
			return "Sniper";
		}
		else if(array_search('Scattergun', $players) || array_search('Boston_basher', $players) || array_search('Guillotine', $players) || array_search('Sandman', $players) || array_search('Soda_popper', $players))
		{
			return "Scout";
			
		}
		else if(array_search('Medigun', $players) || array_search('Ubersaw', $players) || array_search("Crusader&#39;s Crossbow", $players)) 
		{
			return "Medic";
		}
		else if(array_search('Knife', $players) || array_search('Ambassador', $players) || array_search('Spycicle', $players))
		{
			return "Spy";
		}
		else if(array_search('Degreaser', $players) || array_search('Flare Gun', $players) || array_search('Axtinguisher', $players))
		{
			return "Pyro";
		}
		else if(array_search('Minigun', $players) || array_search('Tomislav', $players))
		{
			return "Heavy";
		}
		else if(array_search('Sentry Gun Lvl 1', $players) || array_search('Sentry Gun Lvl 2', $players) || array_search('Sentry Gun Lvl 3', $players) || array_search('Wrangler', $players) || array_search('Minisentry', $players))
		{
			return "Engineer";
		}


	}	

?>



