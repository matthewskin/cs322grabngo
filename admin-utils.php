<?php

	/*
    Matt Skinner
    CS320 Databases
    */

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



    /*----------------------------------------------------Functions-----------------------------------------------------------*/

    function getConnection(){
        if(isset($GLOBALS["dbconnection"])){
            return $GLOBALS["dbconnection"];
        } else {
            die("Database connection does not exist.");
        }
    }

    function executeQuery($statement){
        $conn = getConnection();

        $result = $conn->query($statement); 

        if($result == false){
            return false;
        }

        return $result;
    }

    function getItems(){
        $statement = "SELECT * from items ORDER BY items.item_name"; 

        return executeQuery($statement);
    }


?>