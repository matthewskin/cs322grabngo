<?php

    /*Database for cs.knox.edu*/
	$servername = "cs.knox.edu";
    $username = "root";
    $password = "KnxRlz1837";
    $database = "CS322grabngo";

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $database = "CS322grabngo";

    // $servername = "localhost";
    // $username = "test";
    // $password = "test";
    // $database = "CS322grabngo";


    //----------------------------------Create Connection----------------------------//


    // Create connection and store it in a global field
    $GLOBALS["dbconnection"] = $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

	function connect()
	{
		if(isset($GLOBALS["dbconnection"])){
            return $GLOBALS["dbconnection"];
        } else {
            die("Database connection does not exist.");
        }
	}

    function getConnection(){
        if(isset($GLOBALS["dbconnection"])){
            return $GLOBALS["dbconnection"];
        } else {
            die("Database connection does not exist.");
        }
    }

?>
