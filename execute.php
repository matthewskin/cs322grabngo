<?php 

	require_once("admin-utils.php");

	if($_POST["mode"] == "add-item"){

		$executeQuery = 1;

		$item_name = $_POST["item-name"];
		$item_desc = $_POST["item-desc"];

		if(strlen(trim($item_name)) < 1){
			$executeQuery = 0;
		}

		if(strlen($item_desc) < 1){
			$item_desc = "No description.";
		}
		
		if($executeQuery == 1){
			$statement = "INSERT INTO items (item_name, item_desc) VALUES ('" . $item_name . "', '" . $item_desc . "')";

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

?>