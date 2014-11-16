<?php
	// report.php status codes
	// 1 - Successfully added new node
	// 2 - Successfully updated existing node
	// 3 - Invalid input information
	// 4 - Existing client is using PSK but should be using authKey
	// 5 - Missing GET argument(s)
	// 6 - Database error
	
	require_once('../admin/droppoint.php');
	if(!isset($_GET['code']) or !isset($_GET['domain'])){
		echo "5";
		exit();
	}
	if($_GET['code'] == $secretCode and isset($_GET['getAuth']) and $db->get("hosts","authKey",["domain"=>$_GET['domain']]) == null){
		$authKey = md5(uniqid(rand(), true));
		$db->update("hosts",["authKey"=>password_hash($authKey, PASSWORD_DEFAULT)],["domain"=>$_GET['domain']]);
		echo $authKey;
		exit();
	}
	if($_GET['code'] == $secretCode){
		if($db->has("hosts",["domain"=>$_GET['domain']])){
			echo "4";
		}
		else{
			$db->insert("hosts",["domain"=>$_GET['domain'],"checkInTime"=>time()]);
			echo "1";
		}
		// TODO: Error checking
		
	}
	elseif(password_verify($_GET['code'], $db->get("hosts","authKey",["domain"=>$_GET['domain']]))){
		$db->update("hosts",["checkInTime"=>time()],["domain"=>$_GET['domain']]);
		echo "2";
	}
	else{
		echo "3";
	}
	
?>
