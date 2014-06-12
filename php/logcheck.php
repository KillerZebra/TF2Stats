

//Creates a new text file that stores log files that have been uploaded. If the filename is already in the log, it raises an error. 

<?php
//this assignment is already in the stats.php code
$url = $_POST['url'];

// This is the file holding the URLs of the Log files that have been uploaded
$logFile = 'logURL.txt';

$loglength = count($logFile);
for ($i = 0; $i < $loglentgh; $i++) {
	if ($i === $url) {
		echo "That log file already exists";
		}
	else {
	file_put_contents( array $logFile, $url\n, FILE_APPEND);
	}
}

?>