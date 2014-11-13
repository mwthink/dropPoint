<?php
	if(isset($_GET['login'])){
		
		// TODO: Change password storage method
		$hash = '$2y$10$.g9ymrdNEj/EUPxBpNIa2ec0ZK4CqgLIVaLVCryz3dbE/q0.4zG.i'; // "password"
		
		if(password_verify($_POST['password'], $hash) and $_POST['username']=='user'){
			$_SESSION['user']="user";
			header("Location: index.php");
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<style>
			body{
				text-align:center;
			}
		</style>
	</head>
	<body>
		<form action="index.php?login" method="post">
			<input type="text" placeholder="Username" name="username"><br>
			<input type="password" placeholder="Password" name="password"><br>
			<input type="submit" value="Sign In">
		</form> 
	</body>
</html>
