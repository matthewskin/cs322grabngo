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

  //   function listLocations(){
  //   	$statement = "SELECT * from locations ORDER BY locations.location_name";
  //   	$result executeQuery($statement);
		// returnJSONResult($result);
  //   }

    function addItem(){

    	$executeQuery = 1;

		$item_name = mysql_escape_string ($_POST["item-name"]);
		$item_desc = mysql_escape_string ($_POST["item-desc"]);
		$point_value = $_POST["point-value"];
		$allergen_info = mysql_escape_string ($_POST["allergen-info"]);

		if(strlen(trim($item_name)) < 1){
			$executeQuery = 0;
		}

		if(strlen($item_desc) < 1){
			$item_desc = "No description.";
		}


    	if($executeQuery == 1){
			$statement = "INSERT INTO items (item_name, item_desc, item_point_value, item_allergen_info) " . 
				"VALUES ('" . $item_name . "', '" . $item_desc . "', '" . $point_value . "', '" . $allergen_info . "')";

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

  //   function addLocation(){



  //   	if($executeQuery == 1){
		// 	$statement = "INSERT INTO locations (location_name, location_time_open, location_time_closed, location_info) 
		// 		OUTPUT Inserted.* 
		// 		VALUES ('" . $location_name . "', '" . $location_open_time . 
		// 			"', '" . $location_close_time . "', '" . $location_info . "')";

		// 	$result = executeQuery($statement);

		// 	if($result == false){
		// 		returnJSONError("Unable to add location.");
		// 	} else {
		// 		returnJSONResult($result);
		// 	}
		// }
  //   }

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