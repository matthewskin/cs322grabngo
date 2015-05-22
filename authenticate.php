<?php

require_once("admin-utils.php");

function authenticate($username,$password,$account_type,$mode){
	$username = htmlspecialchars(mysql_real_escape_string($username));
	
	
	$statement = "SELECT * FROM users WHERE users.user_email='" . $username . "' AND users.user_password='" . $password . "'";
	$result = executeQuery($statement);

	$count = $result->num_rows;
	
	if($count == 1){
		$row = $result->fetch_assoc();
		if($row['account_type'] != $mode || $row['account_type'] != $account_type){
			header("Location: http://cs.knox.edu/grabngo/login.php");
		} else {
			return true;
		}
	} else {
		header("Location: http://cs.knox.edu/grabngo/login.php");
	}
}

?>