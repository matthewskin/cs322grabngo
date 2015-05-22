<?php
	require_once("dbutils.php");
	require_once("header.php");
?>

			
			<div id="login">
				<h1>Grab & Go Login</h1>
				<form action='endlogin.php' method='post'>
					<div id="login-form">
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
			</div>			
		</content>	
	</body>
</html>