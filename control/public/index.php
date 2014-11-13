<?php
	session_start();
	if(isset($_GET['logout'])){
		session_destroy();
		header("Location: index.php");
	}
	require_once('../admin/droppoint.php');
	if(isset($_SESSION['user'])){
		include(TEMPLATES_PATH.'/controls.php');
	}
	else{
		include(TEMPLATES_PATH.'/login.php');
	}
?>
