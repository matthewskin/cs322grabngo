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

    /*----------------------------------------------------Helper Functions-----------------------------------------------------*/

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

    function returnJSONResult($result){
    	$rows = array();
    	while($row = $result->fetch_assoc()){
    		$rows[] = $row;
    	}
    	print json_encode($rows);
    }

    /*----------------------------------------------------------Functions-----------------------------------------------------*/
    //http://docs.jquery.com/Ajax/jQuery.ajax
    //http://stackoverflow.com/questions/15757750/php-function-call-using-javascript

    switch ($_POST["endpoint"]) {
	    case "list-items":
	        $statement = "SELECT * from items ORDER BY items.item_name";
	        break;
	    case "list-locations":
	    	$statement = "SELECT * from locations ORDER BY locations.location_name"; 
	    	break;
    }
	$result executeQuery($statement);
	returnJSON($result);
    




?>