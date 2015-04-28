<?php
	require_once("CS322dbutils.php");
	require_once("header.php");
?>

			
			<div id="login">
				<h1>Grab & Go Login</h1>
				<form action='CS322endlogin.php' method='post'>
					<div id="login-form">						
						Login as: 
						<input id='101' type='radio' name='logintype' value='admin'><label for='101'>Administrator</label>
						<input id='102' type='radio' name='logintype' value='student' checked><label for='102'>Student</label>				
						<br>
						Username: 
						<input type='text' name='username'>				
						<br>
						Password: 
						<input type='password' name='password'>				
						<br>
						<input type='submit' value='Login'>
						
						<?php
							if(isset($_GET["login"])){
								if($_GET["login"] == "invalid"){
									echo "<p class='error'> Invalid Credentials </p>";
								}
							}
						?>
					</div>		
				</form>

				
				
				<div>
				<a href="resetpassword.php">Reset Password</a><br>
				</div>

				<div>
					<a href="test.php">Home Page</a><br>
				</div>
			</div>			
		</content>	
	</body>
</html>
