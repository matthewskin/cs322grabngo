<?php

	/*
    Matt Skinner
    */

    require_once("dbutils.php");



    /*----------------------------------------------------Functions-----------------------------------------------------------*/

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

    function getLocations(){
        $statement = "SELECT * from locations ORDER BY locations.location_name"; 

        return executeQuery($statement);
    }

    function getLocationItems($location_id){
        $statement = "SELECT * from items INNER JOIN itemlocationjoin ON items.item_pk = itemlocationjoin.item_fk " .
            "WHERE itemlocationjoin.location_fk = '" . $location_id . "' ORDER BY items.item_name";

        return executeQuery($statement);
    }


?>