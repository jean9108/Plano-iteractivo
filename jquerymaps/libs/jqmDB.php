<?php
	// Set up here your database access credentials
	
	// Host name
	$host = "evaluation.jquerymaps.com";
//	$host = "localhost";

	// Database name
	$db   = "jqm_eval_php_mysql_us-wo_01";

	// User
	$user = "evaluation";

	// Password
	$pass = "evaluation";
	
	$jqm_db = new mysqli($host, $user, $pass, $db);
	if ($jqm_db->connect_errno) { echo "Error MySQL: (" . $jqm_db->connect_errno . ") " . $jqm_db->connect_error; }
	
	$jqm_db->set_charset("utf8");
?>