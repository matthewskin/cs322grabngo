<?php

	function connect()
	{
		$dbhost = 'cs.knox.edu';
		$dbuser = 'root';
		$dbpass = 'KnxRlz1837';
		$dbname = 'CS322grabngo';

		$conn=new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql' . mysqli_connect_error());
		return $conn;
	}

?>
