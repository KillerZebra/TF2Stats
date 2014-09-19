
<?php
/*

		require("connect/connectDB.php");

		function backupStats( $database )
		{

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

		function restoreStats( $database )
		{

			require_once 'Excel/reader.php';
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read("$database.xls");
			 
			$conn = mysql_connect("hostname","username","password");
			mysql_select_db("database",$conn);
			 
			for ($x = 2; $x < = count($data->sheets[0]["cells"]); $x++) 
			{
			    $name = $data->sheets[0]["cells"][$x][1];
			    $extension = $data->sheets[0]["cells"][$x][2];
			    $email = $data->sheets[0]["cells"][$x][3];
			    $sql = "INSERT INTO mytable (name,extension,email) 
			        VALUES ('$name',$extension,'$email')";
			    echo $sql."\n";
			    mysql_query($sql);
			}
		}
*/

?>