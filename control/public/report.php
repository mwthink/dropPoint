<?php
	$secretCode="changeThisCode";
	if(!isset($_GET['code']) and !isset($_GET['domain'])){
		echo "5";
		exit();
	}
	if($_GET['code'] == $secretCode){
		// TODO : Save info here - Need database
	}
	else{
		echo "2";
	}
	
?>
