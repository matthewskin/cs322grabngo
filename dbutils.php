<?php

	$servername = "cs.knox.edu";
    $username = "root";
    $password = "KnxRlz1837";
    $database = "CS322grabngo";

    // Create connection
    $GLOBALS["dbconnection"] = $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

	function connect()
	{
		return $conn;
	}

?>
