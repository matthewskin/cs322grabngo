

<!--
	This page serves a template for other pages
!-->
<?php
	require_once("dbutils.php");
	require_once("loginutils.php");
	$conn = connect();
	
	if (!isCookieValidLogin($conn)) {
		header("Location: home.php");
	}
?>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='stylesheet.css'>	
</head>
<header>
	<a href="logout.php">Logout</a>
</header>
<body>
	<div>
		<!--
			Content goes here
		!-->
		Student Login Successful!<br>
		Page Under Construction!<br>
		More to come soon!<br>
	</div>
</body>
<?php
	$conn->close();
?>
<footer>
	<a href='home.php'>Back to Home</a>
</footer>
</html>