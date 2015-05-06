<?php

	require_once("dbutils.php");

    /*----------------------------------------------------Helper Functions-----------------------------------------------------*/

    function executeQuery($statement){
        $conn = getConnection();

        $result = $conn->query($statement); 

        if($result == false){
            return false;
        }
        return $result;
    }

    function getInsertedID(){
    	$conn = getConnection();
    	return $conn->insert_id;
    }

    function returnJSONResult($result){
		$rows = array();
		while($row = $result->fetch_assoc()){
			$rows[] = $row;
		}
    	print json_encode($rows);
    }

    function returnJSONError($message){
    	$output = array("status" => "ERROR", "message" => $message);
    	print json_encode($output);
    }

    /*----------------------------------------------------------Functions-----------------------------------------------------*/
    //http://docs.jquery.com/Ajax/jQuery.ajax
    //http://stackoverflow.com/questions/15757750/php-function-call-using-javascript

    function listItems(){
		$statement = "SELECT * from items ORDER BY items.item_name";
        $result = executeQuery($statement);

        if($result == false){
			returnJSONError("Unable to fetch items. Server Error. " . $GLOBALS["dbconnection"]->error);
			return false;
		} else {
			returnJSONResult($result);
			return true;
		}

    }

    function listLocations(){
    	$statement = "SELECT * from locations ORDER BY locations.location_name";
    	$result = executeQuery($statement);

    	if($result == false){
			returnJSONError("Unable to fetch locations. Server Error. " . $GLOBALS["dbconnection"]->error);
			return false;
		} else {
			returnJSONResult($result);
			return true;
		}
    }

    function addItem(){

    	$executeQuery = 1;

		$item_name = htmlspecialchars(mysql_escape_string ($_POST["item-name"]));
		$item_desc = htmlspecialchars(mysql_escape_string ($_POST["item-desc"]));
		$point_value = $_POST["point-value"];
		$allergen_info = htmlspecialchars(mysql_escape_string ($_POST["allergen-info"]));
		$special_diet = htmlspecialchars(mysql_escape_string ($_POST["item-special-diet"]));
		if($special_diet == "none"){
			$special_diet = null;
		}

		if(strlen(trim($item_name)) < 1){
			$executeQuery = 0;
		}

		if(strlen($item_desc) < 1){
			$item_desc = "No description.";
		}


    	if($executeQuery == 1){
			$statement = "INSERT INTO items (item_name, item_desc, item_point_value, item_allergen_info, item_special_diet) " . 
				"VALUES ('" . $item_name . "', '" . $item_desc . "', '" . $point_value . "', '" . $allergen_info . "', '" . $special_diet . "')";

			$result = executeQuery($statement);

			if($result == false){
				returnJSONError("Unable to add item. Server Error. " . $GLOBALS["dbconnection"]->error);
				return false;
			} else {
				//Get the pk of the inserted element and grab it.
				$item_id = getInsertedID();
				$item = executeQuery("SELECT * FROM items WHERE item_pk = " . $item_id);
				//Return new item to JS.
				returnJSONResult($item);
				return true;
			}
		} else {
			returnJSONError("Unable to add item. Invalid Input.");
			return false;
		}

		return false;
    }

    function addLocation(){

    	$executeQuery = 1;

		$location_name = htmlspecialchars(mysql_escape_string ($_POST["location-name"]));
		$location_open_time = htmlspecialchars(mysql_escape_string ($_POST["location-open-time"]));
		$location_close_time = $_POST["location-close-time"];
		$location_info = htmlspecialchars(mysql_escape_string ($_POST["location-info"]));

		if(strlen(trim($location_name)) < 1){
			$executeQuery = 0;
		}

		if(strlen($location_info) < 1){
			$location_info = "No additional information.";
		}
		
		if($executeQuery == 1){
			$statement = "INSERT INTO locations (location_name, location_time_open, location_time_closed, location_info) 
				VALUES ('" . $location_name . "', '" . $location_open_time . 
					"', '" . $location_close_time . "', '" . $location_info . "')";

			$result = executeQuery($statement);

			if($result == false){
				returnJSONError("Unable to add location. Server Error. " . $GLOBALS["dbconnection"]->error);
				return false;
			} else {
				//Get the pk of the inserted element and grab it.
				$location_id = getInsertedID();
				$location = executeQuery("SELECT * FROM locations WHERE location_pk = " . $location_id);
				//Return new item to JS.
				returnJSONResult($location);
				return true;
			}
		} else {
			returnJSONError("Unable to add location. Invalid Input.");
			return false;
		}

    }

    function listLocationItems(){
    	$location_key = $_POST["location-pk"];

    	$statement = "SELECT item_fk FROM itemlocationjoin WHERE location_fk = " . $location_key;
        $result = executeQuery($statement);

        if($result == false){
			returnJSONError("Unable to fetch location-items. Server Error. " . $GLOBALS["dbconnection"]->error);
			return false;
		} else {
			$rows = array();
			while($row = $result->fetch_assoc()){
				$rows[] = $row["item_fk"];
			}
			print json_encode($rows);
			return true;
		}
    }

    function deleteItem(){

    }

    function deleteLocation(){

    }


    switch ($_POST["endpoint"]) {
	    case "list-items":
	        listItems();
	        break;
	    case "list-locations":
	    	listLocations();
	    	break;
	    case "list-location-items":
	    	listLocationItems();
	    	break;
	    case "add-item":
	    	addItem();
	    	break;
	    case "add-location":
	    	addLocation();
	    	break;
	    case "delete-item":
	    	deleteItem();
	    	break;
	    case "delete-location":
    		deleteLocation();
    		break;
    }
	
    




?>