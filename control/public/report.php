<?php
	require_once('../admin/droppoint.php');
	
	if(!isset($_GET['code']) and !isset($_GET['domain'])){
		echo "5";
		exit();
	}
	if($_GET['code'] == $secretCode){
		// TODO : Save info here - Need database
		echo "1";
	}
	else{
		echo "2";
	}
	
?>
