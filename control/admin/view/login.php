<?php
	if(isset($_GET['login'])){
		if($db->has("users",["username" => strtolower($_POST['username'])])){
			if(password_verify($_POST['password'], $db->get('users','password',['username'=>strtolower($_POST['username'])]))){
				$_SESSION['user']="user";
				header("Location: index.php");
			}
			else{
				$noticeMessage="Invalid username or password";
			}
		}
		else{
			$noticeMessage="Invalid username or password";
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
		<?php echo "<p>".$noticeMessage."</p>" ?>
		<form action="index.php?login" method="post">
			<input type="text" placeholder="Username" name="username"><br>
			<input type="password" placeholder="Password" name="password"><br>
			<input type="submit" value="Sign In">
		</form> 
	</body>
</html>
