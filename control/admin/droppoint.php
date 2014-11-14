<?php
	defined("TEMPLATES_PATH") or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/view'));
	defined("LIBRARY_PATH") or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/lib'));
	
	include(LIBRARY_PATH .'/medoo.min.php');
	$db = new medoo(LIBRARY_PATH .'/database.db');
	$secretCode=$db->get("settings","value",["setting"=>"secretKey"]);
?>
