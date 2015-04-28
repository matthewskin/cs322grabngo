<?php
	require_once("pageutils.php");
	require_once("dbutils.php");
	require_once("loginutils.php");
	
	$conn = connect();

	$user = $_POST["username"];
	$pass = $_POST["password"];
	$type = $_POST["logintype"];

	setLoginCookie($conn, $user, $pass, $type);
	
	// We can't use the cookie variables because they won't be sent to the page without a refresh
	// see: http://stackoverflow.com/questions/3230133/accessing-cookie-immediately-after-setcookie
	$pass = getEncrypted($pass);
	
	if (isValidLogin($conn, $user, $pass, $type)) {
		if ($type == student) {
			header("Location: student.php");
		} else if ($type == admin){
			header("Location: admin.php");
		} else {
			echo " $user / $pass / $type
			Login Failed!";
		}
	} else {

		header("Location: login.php?login=invalid");
	}
	createHeader("End Login", false, false);

	$conn->close();
	createFooter();
?>
