<?php
	require_once('../admin/droppoint.php');
	if(!isset($_GET['code']) or !isset($_GET['domain'])){
		echo "5";
		exit();
	}
	if($_GET['code'] == $secretCode){
		if($db->has("hosts",["domain"=>$_GET['domain']])){
			$db->update("hosts",["checkInTime"=>time()],["domain"=>$_GET['domain']]);
			echo "2";
		}
		else{
			$db->insert("hosts",["domain"=>$_GET['domain'],"checkInTime"=>time()]);
			echo "1";
		}
		// TODO: Error checking
		
	}
	else{
		echo "3";
	}
	
?>
