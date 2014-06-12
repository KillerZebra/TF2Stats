<?php

		function backupStats( $database )
		{
			require("connect/connectDB.php");

			if (!file_exists("../databases/backups/$database/")) 
			{
			    mkdir("../databases/backups/$database/", 0777, true);
			}

			$getTable = mysql_query( "SELECT * FROM `$database`" );

			$out = '';


			$fields = mysql_list_fields( $dbName, $database );
			$columns = mysql_num_fields( $fields );

			$out .="\n";
			 
			// Add all values in the table to $out.
			while ( $l = mysql_fetch_array( $getTable , MYSQL_NUM) ) 
			{
				for ( $i = 0; $i < $columns; $i++ ) 
				{

						$out .='"'.$l["$i"].'",';
					
				}
				$out .="\n";
			}
			 
			// Open file export.csv.
			$f = fopen ( "../databases/backups/$database/" . date("m-d-y") . '.csv','w' );
			 
			// Put all values from $out to export.csv.
			fputs( $f, $out );
			fclose( $f );

		}



?>