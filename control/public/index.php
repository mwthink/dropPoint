<?php
	session_start();
	if(isset($_GET['logout'])){
		session_destroy();
		header("Location: index.php");
	}
	if(isset($_SESSION['user'])){
		include('../admin/view/controls.php');
	}
	else{
		include('../admin/view/login.php');
	}
?>
