<?php
	defined("TEMPLATES_PATH") or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/view'));
	defined("LIBRARY_PATH") or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/lib'));
	
	include(LIBRARY_PATH .'/medoo.min.php');
	if(isset($_GET['install']) and !file_exists(LIBRARY_PATH .'/database.db') and isset($_POST['username']) and isset($_POST['pwd']) and isset($_POST['rpt']) and $_POST['pwd'] == $_POST['rpt']){
		$db = new medoo(LIBRARY_PATH .'/database.db');
		$db->query("CREATE TABLE users (username TEXT,password TEXT);");
		$db->query("CREATE TABLE settings (setting TEXT,value TEXT);");
		$db->query("CREATE TABLE hosts (domain TEXT,checkInTime TEXT,description TEXT);");
		$db->insert("users",["username"=>strtolower($_POST['username']),"password"=>password_hash($_POST['pwd'], PASSWORD_DEFAULT)]);
		$db->insert("settings",["setting"=>"secretKey","value"=>rand()]);
		if(!$db->error()[0] == "00000"){
			unlink(LIBRARY_PATH.'/database.db');
			$noticeMessage="An error occurred while saving the database.";
		}
		else{
			$noticeMessage="Successfully installed DropPoint control. Please login.";
		}
	}
	if(!file_exists(LIBRARY_PATH .'/database.db')){
		include(TEMPLATES_PATH.'/setup.php');
		exit();
	}
	$db = new medoo(LIBRARY_PATH .'/database.db');
	$secretCode=$db->get("settings","value",["setting"=>"secretKey"]);
	function dbHasError(){
		global $db;
		if($db->error()[0] == "00000"){
			return false;
		}
		else{
			return true;
		}
	}
?>
