<?php
	require_once("dbutils.php");
	require_once("header.php");
?>

			
			<div id="login">
				<h1>Grab & Go Login</h1>
				<div id="sign-in-div">
					<span id="signinButton">
					  <span
					    class="g-signin"
					    data-callback="onSignInCallback"
					    data-clientid="205228710307-93umoqcphkle8htt5rf1eh57ln566a51.apps.googleusercontent.com"
					    data-cookiepolicy="single_host_origin"
					    data-requestvisibleactions="http://schema.org/AddAction"
					    data-scope="https://www.googleapis.com/auth/plus.login">
					  </span>
					</span>
					<input id="logout-button" type="button" onclick="logoutGoogle()" value="Logout">
				</div>
			</div>			
		</content>	
	</body>
	<script>
		$(document).ready(function() {


            
        });		
	</script>
</html>
