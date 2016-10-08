<?php

/**
 * Connect to DB
 */

try {
	$db_type = 'sqlite:';
	$db_location = $db_type . $local_dir . 'db/database.sdb';
	$db = new PDO($db_location);
	
} catch(PDOException $e) {
	echo $e->getMessage();
}

/**
 * Tables
 */
 
$table = [
	'accounts' => 'cpa_accounts',
	'status' => 'cpa_status',
	'activation' => 'cpa_activation',
	'profile' => 'cpa_profile',
	'sessions' => 'cpa_sessions',
];