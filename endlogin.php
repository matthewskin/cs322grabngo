<?php
	require_once("pageutils.php");
	require_once("dbutils.php");
	require_once("admin-utils.php");
	
	$conn = connect();

	$username = $_POST["username"];
	$password = $_POST["password"];

	$username = htmlspecialchars(mysql_real_escape_string($username));
	$password = crypt($password, 'a8hd9j2');
	
	$statement="SELECT * FROM users WHERE user_email='$username' and user_password='$password'";
	$result = executeQuery($statement);

	$count = $result->num_rows;
	
	if($count==1){
		$row = $result->fetch_assoc();
		if($row['account_type'] == 1){
			$expires = 1 * 1000 * 60 * 60 * 24;
			setcookie("username", $username, time()+$expires);
			setcookie("password", $password, time()+$expires);
			setcookie("account_type", $row['account_type'], time()+$expires);

			header("Location: http://cs.knox.edu/grabngo/student.php");
		} else if($row['account_type'] == 2){
			$expires = 1 * 1000 * 60 * 60 * 24;
			setcookie("username", $username, time()+$expires);
			setcookie("password", $password, time()+$expires);
			setcookie("account_type", $row['account_type'], time()+$expires);

			header("Location: http://cs.knox.edu/grabngo/admin.php");
		} else {
			header("Location: http://cs.knox.edu/grabngo/login.php?login=invalid");
		} 
	} else {
		header("Location: http://cs.knox.edu/grabngo/login.php?login=invalid");
	}
?>
