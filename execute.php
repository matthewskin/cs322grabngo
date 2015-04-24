<?php 

	require_once("admin-utils.php");

	if($_POST["mode"] == "add-item"){

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
			$statement = "INSERT INTO items (item_name, item_desc, item_point_value, item_allergen_info) 
				VALUES ('" . $item_name . "', '" . $item_desc . "', '" . $point_value . "', '" . $allergen_info . "')";

			$result = executeQuery($statement);

			if($result == false){
				die("Unable to execute add item query.");
			}
		}

		header("Location: admin.php");
	}

	if($_POST["mode"] == "delete-item"){

		$statement = "DELETE FROM items WHERE items.item_pk = " . $_POST["item-id"];

		$result = executeQuery($statement);

		if($result == false){
			die("Unable to delete this item.");
		}

		header("Location: admin.php");
	}

	if($_POST["mode"] == "add-location"){

		$executeQuery = 1;

		$location_name = mysql_escape_string ($_POST["location-name"]);
		$location_open_time = mysql_escape_string ($_POST["location-open-time"]);
		$location_close_time = $_POST["location-close-time"];
		$location_info = mysql_escape_string ($_POST["location-info"]);

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
				die(mysqli_error(getConnection()));
			}
		}

		header("Location: admin.php?mode=locations");
	}

	if($_POST["mode"] == "delete-location"){

		$statement = "DELETE FROM locations WHERE locations.location_pk = " . $_POST["location-id"];

		$result = executeQuery($statement);

		if($result == false){
			die("Unable to delete this item.");
		}

		header("Location: admin.php?mode=locations");
	}

	if($_POST["mode"] == "delete-location-item"){

		$statement = "DELETE FROM itemlocationjoin WHERE location_fk = '" . $_POST["location-id"] . "' AND item_fk = '" . $_POST["item-id"] . "'";

		$result = executeQuery($statement);

		if($result == false){
			die("Unable to delete this item.");
		}

		header("Location: admin.php?mode=locations");
	}

?>